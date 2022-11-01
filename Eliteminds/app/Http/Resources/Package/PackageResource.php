<?php

namespace App\Http\Resources\Package;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

use App\QuestionRoles;
use App\Question;
use App\Chapters;
use App\Process_group;
use App\UserPackages;

class PackageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // ensure that the package is belongs to the user ..
        $userPackages = UserPackages::where('user_id','=' , Auth::user()->id )->where('package_id', '=', $this->id)->get()->first();
        if(!$userPackages){
            return[
                'error' => 'Please, buy the package so that you have full access to it',
                'buy' => [
                    'link' => route('pay', [$this->id, 'ignore'])
                ]
            ];
        }
        
        // ensure its not expire !
        

        if(\Carbon\Carbon::parse($userPackages->created_at)->addDays($this->expire_in_days)->gte(\Carbon\Carbon::now())){ // original package still not expired
            
        }else{
            $extension = \App\PackageExtension::where('user_id', '=', Auth::user()->id)->where('package_id', '=', $this->id)->orderBy('expire_at', 'desc')->first();
            if(!$extension){
                return[
                    'error' => 'Please, buy the package so that you have full access to it',
                    'buy' => [
                        'link' => route('pay', [$this->id, 'ignore'])
                    ]
                ];
            }else{
                if(\Carbon\Carbon::parse($extension->expire_at)->gte(\Carbon\Carbon::now())){
                    
                }else{
                    return[
                        'error' => 'Please, buy the package so that you have full access to it',
                        'buy' => [
                            'link' => route('pay', [$this->id, 'ignore'])
                        ]
                    ];
                }
            }
        }
        
        // calculate package questions number ..
        $ids_arr = [];
        $countall = 0;
        $question_q = QuestionRoles::where('package_id', '=', $this->id)->get(); // imposipole to be null
        if($question_q->first()){
            foreach($question_q as $r){
                $quest = Question::where('id', '=', $r->question_id)->get();
                if($quest->first()){
                    $countall++;
                    array_push($ids_arr, $quest->first()->id);
                }
            }
        }

        if($this->exams != null){
            $exams = explode(',', $this->exams);
            foreach($exams as $exam){
                $questionWithExamFlag = Question::where('exam_num', 'like','%'.$exam.'%')->get();
                foreach ($questionWithExamFlag as $q){
                    if( !in_array($q->id, $ids_arr) ){
                        $countall++;
                    }
                }
            }
        }

        $chapters = $this->chapter_included;
        if( $this->chapter_included != NULL){
            $chapters = [];
            $chapters_by_id = explode(',', $this->chapter_included);
            foreach($chapters_by_id as $id){
                $query = Chapters::find((int)$id);
                // calculate number of questions attached to this process group
                $count = 0;
                $questionRoles = QuestionRoles::where('package_id' ,'=', $this->id)->get();
                if($questionRoles->first()){
                    foreach($questionRoles as $q){
                        $question = Question::where('id', '=', $q->question_id)->where('chapter','=', $id)->get()->first();
                        if($question){
                            $count++;
                        }
                    }
                }
                $item = ['id'=> (int)$id , 'name'=>$query->name , 'questions_number' => $count];
                array_push($chapters, $item);
            }

        }
        $process_groups = $this->process_group_included;
        if($this->process_group_included != NUll){
            $process_groups = [];
            $process_by_id = explode(',', $this->process_group_included);
            foreach($process_by_id as $id){
                $query = Process_group::find((int)$id);

                // calculate number of questions attached to this process group
                $count = 0;
                $questionRoles = QuestionRoles::where('package_id' ,'=', $this->id)->get();
                if($questionRoles->first()){
                    foreach($questionRoles as $q){
                        $question = Question::where('id', '=', $q->question_id)->where('process_group','=', $id)->get()->first();
                        if($question){
                            $count++;
                        }
                    }
                }
                $item = ['id'=> (int)$id, 'name' => $query->name , 'questions_number' => $count];
                array_push($process_groups, $item);

            }
        }  
        $exams = NULL;
        if($this->exams){
            $exams = [];
            $exams_by_id = explode(',', $this->exams);
            foreach($exams_by_id as $id){
                $count = count(Question::where('exam_num', 'like', '%'.$id.'%')->get());
                $item = ['id'=> (int)$id, 'name' => 'Exam '.$id, 'questions_number'=> $count];
                array_push($exams, $item);
            }
        }


        // return arrary of data
        return [
            'id'=> $this->id,
            'name'=> $this->name,
            'current_price' => $this->price,
            'previous_price' => $this->original_price,
            'trending' => $this->popular,



            'description'=> $this->description,
            'chapters' => $chapters,
            'process_groups' => $process_groups,
            'exams' => $exams,
            'package_questions_number' => $countall,
            'filter_by' => $this->filter,
            'created_at' => $this->created_at,
            'buyer_link' => route('pay', [$this->id, 'ignore']),

        ];
    }
}
