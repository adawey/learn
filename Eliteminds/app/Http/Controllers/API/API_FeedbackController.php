<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\Feedback\FeedbackCollection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class API_FeedbackController extends Controller
{
    public function index(Request $req){
        return FeedbackCollection::collection(\App\Feedback::where('disable', 0)->orderBy('created_at', 'desc')->paginate($req->per_page) );
    }

    public function send_feedback(Request $req){
        /**
         * title
         * description
         * rate
         */

        if(!($req->rate <= 5 && $req->rate >=1)){
            return response()->json(null, 500);
        }

        if(!$req->description){
            return response()->json(['error', 'description id required'], 400);
        }

        $feed = new \App\Feedback;
        $feed->user_id = Auth::user()->id;
        $feed->feedback = $req->description;
        $feed->title = $req->title? $req->title : null;
        $feed->rate = $req->rate;
        $feed->disable = 0;
        $feed->save();

        return response()->json($feed , 201);


    }
}
