<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\UserScore;
use App\Http\Resources\ScoreHistory\ScoreHistoryCollection;
use Illuminate\Support\Facades\Input;

class API_ScoreHistoryController extends Controller
{
    public function show(){
        if ( Input::get('paginate') ){
            $pagination = Input::get('paginate');
        }else{
            $pagination = 20;
        }

        $query = UserScore::where('user_id', '=', Auth::user()->id)->paginate($pagination);
        return ScoreHistoryCollection::collection($query);
    }

    public function store(Request $request){
        $score = new UserScore;
        $score->score = $request->input('score');
        $score->package = $request->input('package');
        $score->question_number = $request->input('question_number');
        $score->topic = $request->input('topic');
        $score->user_id = Auth::user()->id;
        $score->save();

        return response()->json([
            'meta' => [
                'code' => 200,
            ]
        ]);
    }
}
