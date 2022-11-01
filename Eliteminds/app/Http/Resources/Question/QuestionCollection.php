<?php

namespace App\Http\Resources\Question;

use Illuminate\Http\Resources\Json\Resource;

class QuestionCollection extends Resource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'title' => $this->title,
            'img' => ($this->img) ? url('storage/questions/'.basename($this->img)):NULL,
            'relations' => [
                'chapter' => $this->chapter,
                'project_management_group' => ($this->project_management_group) ? $this->project_management_group : NULL ,
                'process_group' => $this->process_group,
                'exam_num' => ( !empty( explode(',' , $this->exam_num) ) ) ? explode(',' , $this->exam_num) : NULL,
            ],
            'details' => [
                'link' => route('APIquestion.show', $this->id)
            ]
        ];
    }
}
