<?php

namespace App\Http\Resources\Question;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $false_answer_arr = [$this->a, $this->b, $this->c];
        shuffle($false_answer_arr);


        return [
            'id'=> $this->id,
            'title'=>$this->title,
            'false_answers' => $false_answer_arr,
            'correct_answer' => $this->correct_answer,
            'feedback' => $this->feedback,
            'relations' => [
                'chapter' => $this->chapter,
                'project_management_group' => ($this->project_management_group) ? $this->project_management_group : NULL ,
                'process_group' => $this->process_group,
                'exam_num' => ( !empty( explode(',' , $this->exam_num) ) ) ? explode(',' , $this->exam_num) : NULL,
            ],
            'img' => ($this->img) ? url('storage/questions/'.basename($this->img)):NULL,
            'demo' => $this->demo,
            'created_at' => $this->created_at,
        ];
    }
}
