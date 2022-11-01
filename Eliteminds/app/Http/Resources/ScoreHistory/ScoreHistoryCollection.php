<?php

namespace App\Http\Resources\ScoreHistory;

use Illuminate\Http\Resources\Json\Resource;

class ScoreHistoryCollection extends Resource
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
            'package_name' => $this->package,
            'topic_name' => $this->topic,
            'question_number' => $this->question_number,
            'score' => $this->score,
            'date' => $this->created_at
        ];
    }
}
