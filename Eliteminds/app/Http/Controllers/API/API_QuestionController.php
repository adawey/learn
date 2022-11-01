<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\Question\QuestionResource;
use App\Http\Resources\Question\QuestionCollection;

use App\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class API_QuestionController extends Controller
{
    public function show($id){
        return new QuestionResource( Question::find($id) );
    }

    public function index(){
        return QuestionCollection::collection( Question::paginate(100) );
    }
}
