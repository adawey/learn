<?php

namespace App\Http\Controllers\users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Question;
use App\Chapters;
use App\Process_group;

class QuizController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth');
    }

    public function videoShow($id){
        $video = \App\Video::find($id);
        if($video){
            if($video->demo == 1){
                return view('quiz.videoShow')->with('video', $video);
            }else{
               return back()->with('error', 'Error.');                
            }
        }else{
            return back()->with('error', 'Error.');
        }
        
    }

    public function videoIndex(){
        return view('quiz.video');
    }


    public function index(){
        $type_list = []; // list of all chapter and process Group in our data base
        
        // $process_groups_by_id = [];
        $process_groups = Process_group::all();
        foreach($process_groups as $process_group){
            if(Question::where('process_group', '=', $process_group->id)->where('demo','=',1)->get()->first()){
                array_push($type_list, $process_group->name);
                // array_push($process_groups_by_id, $process_group->id);
            }
        }
        // $chapters_by_id = [];
        // $chapters = Chapters::all();
        // foreach($chapters as $chapter){
        //     if(Question::where('chapter', '=', $chapter->id)->where('demo','=',1)->get()->first()){
        //         array_push($type_list, $chapter->name);
        //         array_push($chapters_by_id, $chapter->id);
        //     }
        // }

        $number_of_questions = count(Question::where('demo','=',1)->get());


        return view('quiz/index')
            ->with('type_list', $type_list)
            ->with('questions_number', $number_of_questions);
    }

    public function reloadQuestionsNumber(Request $req){
        $process_or_chapter = 'chapter'; 

        if($req->input('name') == 'All'){
            return count(Question::where('demo','=',1)->get());    
        }

        $q = Chapters::where('name','=',$req->input('name'))->get()->first();
        if(!$q){
            $q = Process_group::where('name','=',$req->input('name'))->get()->first();
            $process_or_chapter = 'process_group';
        }

        $question_num = count(Question::where('demo','=',1)->where($process_or_chapter, '=', $q->id)->get());
        return $question_num;
    }

    public function generate(Request $request){

        $questions_array = [];
        
        // in case of choosing ALL ..
        $quests = Question::where('demo','=','1')->take($request->input('num'))->get();

        if($request->input('type') != 'All'){
            // check weather it's process group or chapter !
            // $process_or_chapter = 'chapter';
            // $q = Chapters::where('name','=',$request->input('type'))->get()->first();
            // if(!$q){
            //     $q = Process_group::where('name','=',$request->input('type'))->get()->first();
            //     $process_or_chapter = 'process_group';
            // }

            $q = Process_group::where('name','=',$request->input('type'))->get()->first();
            $process_or_chapter = 'process_group';
            $quests = Question::where('demo','=',1)->where($process_or_chapter, '=', $q->id)->take($request->input('num'))->get();

        }
        
        foreach ($quests as $q) {
            $question = [];
            $question['title'] = $q->title;
            $question['answers']['a'] = $q->a;
            $question['answers']['b'] = $q->b;
            $question['answers']['c'] = $q->c;
            $question['answers']['d'] = $q->correct_answer;
            shuffle($question['answers']);
            $question['correct_answer'] = $q->correct_answer;
            $question['feedback'] = $q->feedback;


            $process_g = Process_group::where('id','=',$q->process_group)->get()->first();
            $question['process_group'] = $process_g->name;
            $question['img'] = 'null';
            if($q->img){
                $question['img'] = basename($q->img);
            }

            array_push($questions_array, $question);
        }
        shuffle($questions_array);
        return $questions_array;
    }
}
