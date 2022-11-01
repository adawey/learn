<?php

namespace App\Http\Resources\Feedback;

use Illuminate\Http\Resources\Json\Resource;

class FeedbackCollection extends Resource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $user = \App\User::find($this->user_id);

        if($user){
            $user_name = $user->name;
            $rate = $this->rate;
            $feedback_description = $this->feedback;
            $feedback_title = $this->title;
            $rate_date = $this->created_at;


            return [
                'user_name' => $user_name,
                'rate' => $rate,
                'feedback' => [
                    'title' => $feedback_title,
                    'description' => $feedback_description,
                ],
                'date' => $rate_date,
            ];

        }

        return [];
    }
}
