<?php

namespace App\Http\Resources\Video;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

use App\QuestionRoles;
use App\Question;
use App\Chapters;
use App\Process_group;
use App\UserPackages;

class VideoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $progress = false;
        if(Auth::check()){
            $progress = \App\VideoProgress::where('video_id', $this->id)->where('user_id', Auth::user()->id)->first();
            if($progress){
                $progress = $progress->complete ? true : false;
            }
        }


        return [
            'id' => $this->id,
            'chapter' => [
                'id' => $this->chapter,
                'name' => \App\Chapters::find($this->chapter)->name
            ],
            'title' => $this->title,
            'description' => $this->description,
            'duration' => $this->duration,
            'vimeo_id' => $this->vimeo_id,
            'attachment_url' => $this->attachment_url ? url('storage/material/'.basename($this->attachment_url)): null,
            'watched' => $progress ? true: false,
            'demo' => $this->demo,
            'created_at' => $this->created_at,
        ];
    }
}
