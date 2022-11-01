<?php


namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class API_MessageController extends Controller
{
    public function store(Request $request){
        $this->validate($request,[
            'message'   => 'required_without:file',
            'file'   => 'required_without:message|size:30000',
        ]);

        $new_msg = new Message;
        $new_msg->from_user_id = Auth::user()->id;
        $new_msg->from_user_type = 'user';
        $new_msg->to_user_id = 2; // admin Sayed-Mohsen
        $new_msg->to_user_type = 'admin';
        $new_msg->message = $request->message;
        $new_msg->save();

        if($request->hasFile('file')){
            $img = new \App\MessageImage;
            $img->message_id = $new_msg->id;
            $img->img = $request->file('file')->store('public/messages');
            $img->save();
        }
        return response()->json(null, 201);
    }

    public function index(){
        $user_messages = DB::table('messages')
            ->leftJoin('message_images', 'messages.id', '=', 'message_images.message_id')
            ->where(function($query){
                $query->where('from_user_id', Auth::user()->id)
                    ->orWhere('to_user_id', Auth::user()->id);
            })
            ->select(
                'message',
                DB::raw('(CASE WHEN from_user_type = \'admin\' THEN 1 ELSE 0 END) AS by_admin'),
                DB::raw('(sight) AS seen'),
                'messages.created_at',
                DB::raw('(img) AS attachment')
            )
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($row){
                $row->attachment = $row->attachment ? [
                    'url'   => url('storage/messages/'.basename($row->attachment)),
                ]: null;
                return $row;
            });
        return response()->json([
            'messages'  => $user_messages
        ], 200);
    }
}
