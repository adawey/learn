<?php

namespace App\Http\Resources\Review;

use Illuminate\Http\Resources\Json\Resource;

class ReviewCollection extends Resource
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
            $rate_description = $this->review;
            $rate_date = $this->created_at;


            return [
                'user_name' => $user_name,
                'rate' => $rate,
                'rate_description' => $rate_description,
                'rate_date' => $rate_date,
            ];

        }

        return [];
    }
}
