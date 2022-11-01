<?php

namespace App\Http\Controllers;

use App\Localization\Locale;
use Illuminate\Http\Request;
use App\Message;
use Illuminate\Support\Facades\Auth;


class MessageController extends Controller
{

    public function user_inbox_show(Locale $locale){
        $messages = \App\Message::where(function($q){
            $q->where('from_user_type', 'admin')->where('to_user_id', Auth::user()->id);
        })->orWhere(function($q){
            $q->where('to_user_type', 'admin')->where('from_user_id', Auth::user()->id);
        })->orderBy('created_at', 'desc')->get();

        return view('user.inbox')
            ->with('messages', $messages);
    }

    public function user_inbox_send(Request $req){
        
        $this->validate($req,[
            'to_user_id'   =>  'required|numeric',
            'img'   => 'image|mimes:jpeg,png,jpg',
        ]);

        if($req->msg == null && !$req->has('img')){
            return back()->with('error', 'empty, write something.');
        }
        $new_msg = new Message;
        $new_msg->from_user_id = Auth::user()->id;
        $new_msg->from_user_type = 'user';
        $new_msg->to_user_id = $req->input('to_user_id');
        $new_msg->to_user_type = 'admin';
        $new_msg->message = $req->input('msg');
        $new_msg->save();

        if($req->hasFile('img')){
            $img = new \App\MessageImage;
            $img->message_id = $new_msg->id;
            $img->img = $req->file('img')->store('public/messages');
            $img->save();
        }

        return back()->with('success', 'message sent !');;
      

    }

    

    public function inbox_show(){
        $messages = \App\Message::where(function($q){
            $q->where('from_user_type', 'admin')->orWhere('to_user_type', 'admin');
        })->where(function($q){
            $q->where('from_user_id', Auth::user()->id)->orWhere('to_user_id', Auth::user()->id);
        })->orderBy('created_at', 'desc')->get();

        return view('admin.inbox')
            ->with('messages', $messages);
    }


    public function inbox_send(Request $req){
        
        $this->validate($req,[
            'to_user_id'   =>  'required|numeric',
            'img'   => 'mimes:jpeg,png,jpg',
        ]);

        $new_msg = new Message;
        $new_msg->from_user_id = Auth::user()->id;
        $new_msg->from_user_type = 'admin';
        $new_msg->to_user_id = $req->input('to_user_id');
        $new_msg->to_user_type = 'user';
        $new_msg->message = $req->input('msg');
        $new_msg->save();

        if($req->hasFile('img')){
            $img = new \App\MessageImage;
            $img->message_id = $new_msg->id;
            $img->img = $req->file('img')->store('public/messages');
            $img->save();
        }

        return back()->with('success', 'message sent !');
      

    }


    public function userIndex(){
        return view('userSendMsg');
    }

    public function userSend(Request $r){


        $this->validate($r, [
            'message'=>'required'
        ]);

        
        foreach(\App\Admin::all() as $admin){
            $new_msg = new Message;
            $new_msg->from_user_id = Auth::user()->id;
            $new_msg->from_user_type = 'user';
            $new_msg->to_user_id = $admin->id;
            $new_msg->to_user_type = 'admin';
            $new_msg->message = $r->input('message');
            $new_msg->save();
        }
        return \Redirect::to(route('home'))->with('success','Message Sent Successfully .');


    }

    public function adminIndex(){
        return view('admin-inbox');
    }

    public function adminSend(Request $req){
        $this->validate($req, [
            'send_to_email' => 'required',
            'msg'=>'required',
        ]);

        $user = \App\User::where('email', '=',$req->input('send_to_email'))->get()->first();
        if(!$user){
            return back()->with('error', 'Cant fount a user with this Email !');
        }

        $new_msg = new Message;
        $new_msg->from_user_id = Auth::user()->id;
        $new_msg->from_user_type = 'admin';
        $new_msg->to_user_id = $user->id;
        $new_msg->to_user_type = 'user';
        $new_msg->message= $req->input('msg');
        $new_msg->save();


        return back()->with('success', 'Message Sent Successfully !');
    }
}
