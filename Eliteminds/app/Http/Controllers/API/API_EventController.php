<?php


namespace App\Http\Controllers\API;


use App\Event;
use App\Payment\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class API_EventController
{
    use Payment;

    private function renderEventDetails($event, $user_id = null){
        $lecture_nbr = 0;
        $completed_lecture_nbr = 0;
        $last_video = null;
        $total_video_time = [0, 0, 0]; // hr, min, secs
        $chapters = DB::table('chapters')
            ->where('course_id', $event->course_id)
            ->get();
        $eventVideos = DB::table('videos')
            ->whereIn('chapter', $chapters->pluck(['id']))
            ->where('videos.event_id', $event->id)
            ->join('chapters', 'videos.chapter', '=', 'chapters.id');
        if($user_id){
            $eventVideos = $eventVideos->leftJoin(
                DB::raw('(select * from video_progresses where user_id='.$user_id.' AND event_id='.$event->id.' GROUP BY video_id) as video_progresses'),
                'video_progresses.video_id', '=', 'videos.id')
            ->select(
                'videos.id',
                'videos.title',
                'videos.description',
                'videos.duration',
                'videos.vimeo_id',
                'videos.attachment_url',
                'videos.demo',
                DB::raw('video_progresses.complete AS watched'),
                DB::raw('chapters.id AS chapter_id'),
                DB::raw('chapters.name AS chapter_name'),
                DB::raw('video_progresses.created_at AS last_progress'),
                DB::raw('videos.created_at AS VideoCreatedAt')
            );
        }else{
            $eventVideos = $eventVideos->select(
                'videos.id',
                'videos.title',
                'videos.description',
                'videos.duration',
                'videos.vimeo_id',
                'videos.attachment_url',
                'videos.demo',
                DB::raw('chapters.id AS chapter_id'),
                DB::raw('chapters.name AS chapter_name'),
                DB::raw('videos.created_at AS VideoCreatedAt')
            );
        }
        $eventVideos = $eventVideos->orderBy('index_z')->get();
        $chapters_data = [];
        foreach($chapters as $chapter) {


            $videos_array = [];
            $total_hours = 0;
            $total_min = 0;
            $total_sec = 0;
            $thisChapterVideos = $eventVideos->filter(function($video)use($chapter){
                return $video->chapter_id == $chapter->id;
            });
            foreach ($thisChapterVideos as $v) {
                $nv = (object)[];
                $nv->id = $v->id;
                $nvChapter = (object)[];
                $nvChapter->id = $v->chapter_id;
                $nvChapter->name = $v->chapter_name;
                $nv->chapter = $nvChapter;
                $nv->title = $v->title;
                $nv->description = $v->description;
                $nv->duration = $v->duration;
                $nv->vimeo_id = $v->vimeo_id;
                $nv->demo = $v->demo ? 1 : 0;
                $nv->attachment_url = $v->attachment_url ? url('storage/material/' . basename($v->attachment_url)) : null;
                $nv->created_at = Carbon::parse($v->VideoCreatedAt);
                if (property_exists($v, 'watched')) {
                    $nv->watched = $v->watched ? true : false;
                    if ($v->watched) {
                        $completed_lecture_nbr++;
                    }
                }
                if (property_exists($v, 'last_progress')) {
                    $nv->last_progress = $v->last_progress;
                    if ($last_video == null) {
                        $last_video = $nv;
                    } else {
                        if (\Carbon\Carbon::parse($nv->last_progress)->gte(\Carbon\Carbon::parse($last_video->last_progress))) {
                            $last_video = $nv;
                        }
                    }
                }
                array_push($videos_array, $nv);
                if ($v->duration != '' && $v->duration != null) {
                    $total_min += \Carbon\Carbon::parse($v->duration)->format('i');
                    $total_sec += \Carbon\Carbon::parse($v->duration)->format('s');
                    if (\Carbon\Carbon::parse($v->duration)->format('h') != 12) {
                        $total_hours += \Carbon\Carbon::parse($v->duration)->format('h');
                    }
                    $lecture_nbr++;
                }
            }

            $total_min += floor($total_sec / 60);
            $total_sec = $total_sec % 60;

            $total_hours += floor($total_min / 60);
            $total_min = $total_min % 60;

            $total_video_time[0] += $total_hours;
            $total_video_time[1] += $total_min;
            $total_video_time[2] += $total_sec;

            $item = [
                'id' => $chapter->id ,
                'name'=> $chapter->name,
                'videos' => $videos_array,
            ];
            if(count($videos_array)){
                array_push($chapters_data, $item);
            }

        }

        $total_video_time[1] += round($total_video_time[2]/60);
        $total_video_time[2] = round($total_video_time[2]%60);
        $total_video_time[0] += round($total_video_time[1]/60);
        $total_video_time[1] = round($total_video_time[1]%60);

        $users_no = DB::table('event_user')
            ->where('event_id', '=', $event->id)
            ->count();

        $event_full_data = (object)[
            'id'                    => $event->id,
            'name'                  => $event->name,
            'instructor'            => 'Eng. Elsayed Mohsen',
            'course'                => $event->course_title,
            'current_price'         => $event->price,
            'previous_price'        => $event->original_price,
            'number_of_students'    => $users_no,
            'rate'                  => round($event->rating),
            'language'              => $event->lang,
            'access'                => $event->expire_in_days,
            'number_of_lectures'    => $event->total_lecture,
            'duration'              => $event->total_time,
            'estimated_lectures'    => $lecture_nbr,
            'estimated_duration'    => $total_video_time[0].' Hr '.$total_video_time[1].' Min',
            'certification'         => $event->certification,
            'img_large'             => url('storage/events/'.basename($event->img)),
            'img_small'             => url('storage/events/'.basename($event->img)),
            'img_medium'            => url('storage/events/'.basename($event->img)),
            'description'           => $event->description,
            'what_you_learn'        => $event->what_you_learn,
            'requirement'           => $event->requirement,
            'who_course_for'        => $event->who_course_for,
            'chapters'              => $chapters_data,
            'created_at'            => Carbon::parse($event->created_at),
//            'buyer_link'            => route('public.event.view', $event->id),
        ];
        if ($user_id) {
            $event_full_data->last_video = $last_video;
            $event_full_data->time_table = DB::table('event_times')->where('event_id', $event->id)
                ->get(['day', 'from', 'to']);
            $event_full_data->whatsapp_link = $event->whatsapp;
            $event_full_data->zoom_linke = $event->zoom;
        }
        return $event_full_data;
    }

    public function allEvents(){
        $events = DB::table('events')
            ->where('active', '=', 1)
            ->where('end' , '>', now())
            ->join('courses', 'events.course_id', '=', 'courses.id')
            ->leftJoin('ratings', 'events.id', '=', 'ratings.event_id')
            ->select(
                'events.*',
                DB::raw('AVG(ratings.rate) AS rating'),
                DB::raw('courses.title AS course_title')
            )
            ->get()
            ->map(function($event){
                return $this->renderEventDetails($event);
            });

        return response()->json($events, 200);
    }

    public function show($event_id){
        $events = DB::table('events')
            ->where([
                'active'    => 1,
                'events.id' => $event_id
            ])
            ->where('end' , '>', now())
            ->join('courses', 'events.course_id', '=', 'courses.id')
            ->leftJoin('ratings', 'events.id', '=', 'ratings.event_id')
            ->select(
                'events.*',
                DB::raw('AVG(ratings.rate) AS rating'),
                DB::raw('courses.title AS course_title')
            )
            ->get()
            ->map(function($event){
                return $this->renderEventDetails($event, Auth::user()->id);
            });

        return response()->json($events, 200);
    }

    public function search(Request $request){
        $events = DB::table('events')
            ->where(function($query)use($request){
                $query->where('events.name' , 'LIKE', '%'.$request->query_string.'%')
                    ->orWhere('courses.title', 'LIKE', '%'.$request->query_string.'%');
            })
            ->where([
                'active'    => 1,
            ])
            ->where('end' , '>', now())
            ->join('courses', 'events.course_id', '=', 'courses.id')
            ->leftJoin('ratings', 'events.id', '=', 'ratings.event_id')
            ->select(
                'events.*',
                DB::raw('AVG(ratings.rate) AS rating'),
                DB::raw('courses.title AS course_title')
            )
            ->get()
            ->map(function($event){
                return $this->renderEventDetails($event);
            });

        return response()->json($events, 200);
    }

    public function own(){
        $thisUser = Auth::user();
        $events = DB::table('event_user')->where('user_id', $thisUser->id)->get(['event_id'])->pluck(['event_id']);
        if(count($events)){
            $events = DB::table('events')
                ->whereIn('events.id', $events)
                ->where([
                    'active'    => 1,
                ])
                ->where('end' , '>', now())
                ->join('courses', 'events.course_id', '=', 'courses.id')
                ->leftJoin('ratings', 'events.id', '=', 'ratings.event_id')
                ->select(
                    'events.*',
                    DB::raw('AVG(ratings.rate) AS rating'),
                    DB::raw('courses.title AS course_title')
                )
                ->get()
                ->map(function($event)use($thisUser){
                    return $this->renderEventDetails($event, $thisUser->id);
                });
        }
        return response()->json($events, 200);
    }
}
