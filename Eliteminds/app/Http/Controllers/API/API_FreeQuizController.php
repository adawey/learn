<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Question;
use App\Process_group;

class API_FreeQuizController extends Controller
{
    public function generate_info(){
        $data = [];
        // count of total free quiz questions ..
        $free = Question::where('demo', '=', 1)->get();
        $countAll = count($free);
        
        array_push($data, ['id' => 00, 'name'=>'All', 'question_number'=> $countAll]);

        $count = 0;
        $process = Process_group::all();
        foreach($process as $p){
            $freebyProcess = Question::where('demo', '=', 1)->where('process_group' ,'=', $p->id)->get();
            if($freebyProcess->first()){
                foreach($freebyProcess as $q){
                    $count++;
                }
            }
            array_push($data, ['id' => $p->id, 'name'=>$p->name, 'question_number'=> $count]);
            // else pass
            $count = 0;
        }
        return response()->json([
            'data' => $data
        ]);
    }


    public function generate($process_id){
        $questions = Question::where('demo','=','1')
            ->where(function($query)use($process_id){
                if($process_id != 0){
                    $query->where('process_group', '=', $process_id);
                }
            })
            ->select('questions.id')
            ->get()
            ->pluck(['id']);
        
        $questions = app('App\Http\Controllers\Users\PremiumQuizController')->batchQuestionLoader($questions)->toArray();
        $x = app('App\Http\Controllers\Users\PremiumQuizController')->reArrange($questions);
        $start_ = rand(1, $x[1]);

        return response()->json([
            'questions'                 => app('App\Http\Controllers\Users\PremiumQuizController')->startFromPart($x[0], $x[1], $start_), // questions
        ], 200);

    }
}
