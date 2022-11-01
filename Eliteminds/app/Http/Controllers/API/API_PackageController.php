<?php

namespace App\Http\Controllers\API;


use App\Chapters;
use App\Http\Resources\Package\PackageCollection;
use App\Http\Resources\Video\VideoResource;
use App\Packages;
use App\Process_group;
use App\Question;
use App\UserPackages;
use App\Http\Resources\Package\ReviewResource;
use App\Http\Resources\Package\ReviewCollection;
use App\Http\Resources\Package\UserPackageCollection;
use Illuminate\Support\Facades\Cache;


use App\Video;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class API_PackageController extends Controller
{

    public function getSpecificVideo(Request $req){
        return response()->json($this->vimeo_GetVideo($req->vimeo_id), 200);
    }

    public function Vimeo_GetVideo($video_id){
        if($video_id == ''){
            return 0;
        }


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.vimeo.com/videos/'.$video_id);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer 0160c68b3e161aba0836d05288a7195d',
            'Content-Type: application/x-www-form-urlencoded',
            'Accept: application/vnd.vimeo.*+json;version=3.4'
        ));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        try{
            $output = curl_exec($ch);
            $output = json_decode($output);
            if(isset($output->error))
            {
                return 0;
            }
            else
            {
                return ($output);
            }
        }catch(\Exception $e){
            return 0;
        }

    }

    public function search(Request $req){

        $packages_arr = [];
        $packages = \App\Packages::where('name', 'like', '%'.$req->text.'%')->get();

        foreach($packages as $package){
            $item = $this->renderPackageDetails($package->id);
            array_push($packages_arr, $item);
        }
        return response()->json($packages_arr, 200);
    }


    public function packageByCourse(Request $req){
        $packages_arr = [];
        $packages = \App\Packages::where('course_id', $req->course_id)->get();

        foreach($packages as $package){
            $item = $this->renderPackageDetails($package->id);
            array_push($packages_arr, $item);
        }
        return response()->json($packages_arr, 200);

    }

    public function VideoComplete(Request $req){


        $video_ = \App\Video::find($req->video_id);
        if(!$video_){
            return response()->json(['error' => 'video does not exists'], 404);
        }

        $package_ = \App\Packages::find($req->package_id);
        if(!$package_){
            return response()->json(['error' => 'package does not exists'], 404);
        }

        if($package_->contant_type == 'question'){
            return response()->json(['error' => 'package does not include videos'], 404);
        }

        // that package include videos
        if(!in_array($video_->chapter , explode(',', $package_->chapter_included))){
            return response()->json(['error' => 'video does not belongs to this package'], 404);
        }

        if(!\App\UserPackages::where('package_id', $req->package_id)->where('user_id', Auth::user()->id)->first()){
            return response()->json(['error' => 'package does not belongs to this user'], 404);
        }

        $complete = \App\VideoProgress::where('user_id', Auth::user()->id)->where('package_id', $req->input('package_id'))->where('video_id', $req->input('video_id'))->first();
        if(!$complete){

            $complete= new \App\VideoProgress;
            $complete->user_id = Auth::user()->id;
            $complete->package_id = $req->input('package_id');
            $complete->video_id =  $req->input('video_id');

        }

        $complete->complete = $req->complete ? 0: 1;
        $complete->save();

        $complete->complete = $req->complete ? 1: 0;
        $complete->save();

        return $complete;
        return response()->json([], 201);
    }



    //all package show with less details
    public function index(Request $req){

        $package_arr = [];

        if($req->popular == 1){
            $packages = \App\Packages::where('active', 1)->where('popular', 1)->orderBy('created_at')->get();
//            return PackageCollection::collection( Packages::where('popular', 1)->get() );
        }else{
            $packages = \App\Packages::where('active', 1)->orderBy('created_at')->get();
//            return PackageCollection::collection( Packages::all() );
        }

        foreach($packages as $package){

            $details = $this->renderPackageDetails($package->id);
            array_push($package_arr, $details);
        }

        return response()->json($package_arr, 200);






    }

    public function renderPackageDetailsV2($userPackage){

        // init variables
        $no_of_quizzes = 0;
        $no_of_lectures = 0;
        $no_of_completed_lectures = 0;
        $last_video = null;
        $package_total_video_time = [0,0,0]; // hr, min, secs
        $chapters = [];

        if( $userPackage->chapter_included != NULL){


            $chapters_by_id = explode(',', $userPackage->chapter_included);
            // select this chapter from database




            if($userPackage->contant_type == 'video' || $userPackage->contant_type == 'combined'){
                $packageVideos = DB::table('videos')
                    ->whereIn('chapter', $chapters_by_id)
                    ->whereNull('videos.event_id')
                    ->leftJoin(
                        DB::raw('(select * from video_progresses where user_id='.$userPackage->user_id.' AND package_id='.$userPackage->package_id.' GROUP BY video_id) as video_progresses'),
                        'video_progresses.video_id', '=', 'videos.id')
                    ->join('chapters', 'videos.chapter', '=', 'chapters.id')
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
                    )
                    ->orderBy('index_z')
                    ->get();



            }
    

            if($userPackage->contant_type == 'question' || $userPackage->contant_type == 'combined'){
                $packageChapters = DB::table('chapters')
                    ->whereIn('chapters.id', $chapters_by_id)
                    ->leftJoin('questions', 'chapters.id','=','questions.chapter')
                    ->select('chapters.*', DB::raw('COUNT(*) as questionsCount'))
                    ->groupBy('chapters.id')
                    ->get();
            }else{
                $packageChapters = DB::table('chapters')
                    ->whereIn('chapters.id', $chapters_by_id)
                    ->select('chapters.*', DB::raw('0 as questionsCount'))
                    ->get();
            }




            foreach($packageChapters as $thisChapter){
                // questions package section
                $no_of_quizzes++;


                $videos_array = [];

                $total_hours = 0;
                $total_min = 0;
                $total_sec = 0;

                if($userPackage->contant_type == 'video' || $userPackage->contant_type == 'combined'){
                    $videos = $packageVideos->filter(function($row)use($thisChapter){
                        return $row->chapter_id == $thisChapter->id;
                    });

                    foreach($videos as $v){
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
                        $nv->watched = $v->watched ? true: false;
                        $nv->demo = $v->demo ? 1: 0;
                        $nv->last_progress = $v->last_progress;
                        $nv->attachment_url = $v->attachment_url ? url('storage/material/'.basename($v->attachment_url)): null;
                        $nvCreatedAt = (object)[];
                        $nvCreatedAt->date = $v->VideoCreatedAt;
                        $nvCreatedAt->timezone_type = 3;
                        $nvCreatedAt->timezone = "UTC";
                        $nv->created_at = $nvCreatedAt;
                        array_push($videos_array, $nv);


                        if($v->last_progress){
                            if($last_video == null){
                                $last_video = $nv;
                            }else{
                                if(\Carbon\Carbon::parse($v->last_progress)->gte(\Carbon\Carbon::parse($last_video->last_progress)) ){
                                    $last_video = $nv;
                                }
                            }
                        }


                        if($v->watched){
                            $no_of_completed_lectures++;
                        }
                        if($v->duration != '' && $v->duration != null){
                            $total_min += \Carbon\Carbon::parse($v->duration)->format('i');
                            $total_sec += \Carbon\Carbon::parse($v->duration)->format('s');
                            if(\Carbon\Carbon::parse($v->duration)->format('h') != 12){
                                $total_hours += \Carbon\Carbon::parse($v->duration)->format('h');
                            }
                            $no_of_lectures++;
                        }
                    }
                }


                $total_min += floor($total_sec / 60);
                $total_sec = $total_sec % 60;

                $total_hours += floor($total_min / 60);
                $total_min = $total_min % 60;

                $package_total_video_time[0] += $total_hours;
                $package_total_video_time[1] += $total_min;
                $package_total_video_time[2] += $total_sec;

                $item = [
                    'id' => $thisChapter->id ,
                    'name'=> $thisChapter->name,
                    'questions_number' => $thisChapter->questionsCount == 1 ? 0: $thisChapter->questionsCount,
                    'videos' => $videos_array,
                ];



                array_push($chapters, $item);
            }

        }

        $package_total_video_time[1] += round($package_total_video_time[2]/60);
        $package_total_video_time[2] = round($package_total_video_time[2]%60);

        $package_total_video_time[0] += round($package_total_video_time[1]/60);
        $package_total_video_time[1] = round($package_total_video_time[1]%60);


        $packageProcessGroups = [];
        if($userPackage->process_group_included != NUll){

            $process_by_id = explode(',', $userPackage->process_group_included);

            $packageProcessGroups = DB::table('process_groups')
                ->whereIn('process_groups.id', $process_by_id)
                ->join('questions', 'process_groups.id','=','questions.process_group')
                ->select(
                    'process_groups.id',
                    'process_groups.name',
                    DB::raw('COUNT(*) as questions_number')
                )
                ->groupBy('id')
                ->get();

            $no_of_quizzes += count($packageProcessGroups);

        }



        $packageExams = [];
        if($userPackage->exams){
            $exams_by_id = explode(',', $userPackage->exams);
            $exams = \App\Exam::whereIn('id', $exams_by_id)->get();
            foreach($exams_by_id as $id){
                $exam_ = $exams->filter(function($i)use($id){
                    return $i->id == $id;
                })->first();
                if($exam_){
                    $count = Cache::remember('api-exam-'.$id.'-question-nbr', 1440, function()use($id){
                        return Question::where(DB::raw("CONCAT(',', TRIM(BOTH '\"' FROM `exam_num`), ',')"), 'LIKE', '%,'.$id.',%')->count();
                    });
                    $item = ['id'=> (int)$id, 'name' => $exam_->name, 'questions_number'=> $count];
                    array_push($packageExams, $item);    
                    $no_of_quizzes++;
                }
                
            }
            // $no_of_quizzes += count($packageExams);
        }


        $users_no = DB::table('user_packages')
            ->where('package_id', '=', $userPackage->package_id)
            ->count();

        
        $nCreatedAt = (object)[];
        $nCreatedAt->date = $userPackage->created_at;
        $nCreatedAt->timezone_type = 3;
        $nCreatedAt->timezone = "UTC";

        return [
            'id'=> $userPackage->package_id,
            'name'=> $userPackage->name,
            'instructor' => 'Sayed Mohsen',
            'current_price' => $userPackage->price,
            'previous_price' => $userPackage->original_price,
            'trending' => $userPackage->popular,
            'number_of_students' => $users_no,
            'rate' => round($userPackage->rating),
            'number_of_practical_tests' => $no_of_quizzes,
            'number_of_lectures' => $no_of_lectures,
            'language' => $userPackage->lang,
            'access' => $userPackage->expire_in_days,
            'duration' => $package_total_video_time[0].' Hr '.$package_total_video_time[1].' Min',
            'certification' => $userPackage->certification,
            'img_large' => url('storage/package/imgs/'.basename($userPackage->img_large)),
            'img_small' => url('storage/package/imgs/'.basename($userPackage->img_small)),
            'img_medium' => url('storage/package/imgs/'.basename($userPackage->img)),
            'description'=> $userPackage->description,
            'what_you_learn' => $userPackage->what_you_learn,
            'requirement' => $userPackage->requirement,
            'who_course_for' => $userPackage->who_course_for,
            'chapters' => $chapters,
            'process_groups' => $packageProcessGroups,
            'exams' => $packageExams,
            'content_type' => $userPackage->contant_type,
            'course' => $userPackage->course_title,
            'no_of_completed_lectures' => $no_of_completed_lectures,
            'last_video' => $last_video,
            'created_at' => $nCreatedAt,
            'buyer_link' => route('public.package.view', [$userPackage->package_id]),
        ];

    }

    public function renderPackageDetails($package_id){
        $package = \App\Packages::find($package_id);

        $no_of_quizzes = 0;
        $no_of_lectures = 0;

        if(!$package){
            return response()->json([
                'error' => 'package not exists'
            ], 404);
        }



        $package_total_video_time = [0,0,0]; // hr, min, secs
        $chapters = [];
        if( $package->chapter_included != NULL){

            $chapters_by_id = explode(',', $package->chapter_included);
            foreach($chapters_by_id as $id){
                $no_of_quizzes++;
                $query = Chapters::find((int)$id);
                // calculate number of questions attached to this process group
                $count = 0;
                $questions = \App\Question::where('chapter', $id)->get();

                $count += count($questions);
                $videos_array = [];
                $total_hours = 0;
                $total_min = 0;
                $total_sec = 0;

                if($package->contant_type == 'video' || $package->contant_type == 'combined'){
                    $video = \App\Video::where('chapter', $id)->orderBy('index_z')->get();




                    foreach($video as $v){
                        if($v->event_id == null){
                            array_push($videos_array, new VideoResource($v));
                        }

                        if($v->duration != '' && $v->duration != null){

                            $total_min += \Carbon\Carbon::parse($v->duration)->format('i');
                            $total_sec += \Carbon\Carbon::parse($v->duration)->format('s');
                            if(\Carbon\Carbon::parse($v->duration)->format('h') != 12){
                                $total_hours += \Carbon\Carbon::parse($v->duration)->format('h');
                            }

                            $no_of_lectures++;
                        }
                    }
                }


                $total_min += floor($total_sec / 60);
                $total_sec = $total_sec % 60;

                $total_hours += floor($total_min / 60);
                $total_min = $total_min % 60;

                $package_total_video_time[0] += $total_hours;
                $package_total_video_time[1] += $total_min;
                $package_total_video_time[2] += $total_sec;

                $item = [
                    'id'=> (int)$id ,
                    'name'=>$query->name ,
                    'questions_number' => $count,
                    'videos' => $videos_array,
                ];



                array_push($chapters, $item);
            }

        }

        $package_total_video_time[1] += round($package_total_video_time[2]/60);
        $package_total_video_time[2] = round($package_total_video_time[2]%60);

        $package_total_video_time[0] += round($package_total_video_time[1]/60);
        $package_total_video_time[1] = round($package_total_video_time[1]%60);


        $process_groups = [];
        if($package->process_group_included != NUll){

            $process_by_id = explode(',', $package->process_group_included);
            foreach($process_by_id as $id){
                $no_of_quizzes++;
                $query = Process_group::find((int)$id);

                // calculate number of questions attached to this process group
                $count = 0;
                $questions = \App\Question::where('process_group', $id)->get();

                $count += count($questions);

                $item = [
                    'id'=> (int)$id,
                    'name' => $query->name ,
                    'questions_number' => $count,
                ];
                array_push($process_groups, $item);

            }
        }



        $exams = [];
        if($package->exams){
            $exams_by_id = explode(',', $package->exams);
            foreach($exams_by_id as $id){
                $no_of_quizzes++;
                $count = Question::where(DB::raw("CONCAT(',', TRIM(BOTH '\"' FROM `exam_num`), ',')"), 'LIKE', '%,'.$id.',%')->get()->count();
                $item = ['id'=> (int)$id, 'name' => 'Exam '.$id, 'questions_number'=> $count];
                array_push($exams, $item);
            }
        }




        $users_no = count(\App\UserPackages::where('package_id', $package->id)->get());

        $total_no = 0;
        $rate = \App\Rating::where('package_id',$package->id)->get();
        $devisor = count($rate);
        foreach($rate as $i){
            $total_no+= $i->rate;
        }
        if($devisor == 0){
            $total_rate = 0;
        }else{
            $total_rate = $total_no/$devisor;
        }




        return [
            'id'=> $package->id,
            'name'=> $package->name,
            'instructor' => 'Sayed Mohsen',
            'current_price' => $package->price,
            'previous_price' => $package->original_price,
            'trending' => $package->popular,
            'number_of_students' => $users_no,
            'rate' => round($total_rate),
            'number_of_practical_tests' => $no_of_quizzes,
            'number_of_lectures' => $no_of_lectures,
            'language' => $package->lang,
            'access' => $package->expire_in_days,
            'duration' => $package_total_video_time[0].' Hr '.$package_total_video_time[1].' Min',
            'certification' => $package->certification,
            'img_large' => url('storage/package/imgs/'.basename($package->img_large)),
            'img_small' => url('storage/package/imgs/'.basename($package->img_small)),
            'img_medium' => url('storage/package/imgs/'.basename($package->img)),
            'description'=> $package->description,
            'what_you_learn' => $package->what_you_learn,
            'requirement' => $package->requirement,
            'who_course_for' => $package->who_course_for,
            'chapters' => $chapters,
            'domains' => $process_groups,
            'exams' => $exams,
            'content_type' => $package->contant_type,
            'course' => \App\Course::find($package->course_id)->title,
            'created_at' => $package->created_at,
            'buyer_link' => route('public.package.view', [$package->id]),
        ];
    }

    // one package show with more details
    public function show($package_id){
        // $UserPackage = DB::table('user_packages')
        //     ->where('user_packages.user_id', '=', Auth::user()->id)
        //     ->where('user_packages.package_id', '=', $package_id)
        //     ->join('packages', 'user_packages.package_id', '=', 'packages.id')
        //     ->leftJoin('ratings', 'user_packages.package_id', '=', 'ratings.package_id')
        //     ->join('courses', 'packages.course_id', '=', 'courses.id')
        //     ->select(
        //         'packages.*',
        //         'user_packages.*',
        //         DB::raw('AVG(ratings.rate) AS rating'), // created_at belongs to user_packages table
        //         DB::raw('courses.title AS course_title')
        //     )
        //     ->groupBy('user_packages.id')
        //     ->limit(1)
        //     ->get();
        // if(!count($UserPackage)){
        //     return response()->json(null,404);
        // }

        // $details = $this->renderPackageDetailsV2($UserPackage->first());
        // return response()->json($details,200);

        $details = $this->renderPackageDetails($package_id);

        return response()->json($details,200);

    }

    public function free_videos(){

        $videos_array = [];

        $video = \App\Video::where(['demo'=> 1, 'event_id' => null])
            ->orderBy('index_z')
            ->get();


        foreach($video as $v){
            if($v->event_id == null){
                array_push($videos_array, new VideoResource($v));
            }
        }

        return response()->json($videos_array, 200);
    }


    public function ownPackage(){
        DB::enableQueryLog();
        $packages_arr = [];

        $userPackages = DB::table('user_packages')
            ->where('user_packages.user_id', '=', Auth::user()->id)
            ->join('packages', 'user_packages.package_id', '=', 'packages.id')
            ->leftJoin('ratings', 'user_packages.package_id', '=', 'ratings.package_id')
            ->join('courses', 'packages.course_id', '=', 'courses.id')
            ->select(
                'packages.*',
                'user_packages.*',
                DB::raw('AVG(ratings.rate) AS rating'), // created_at belongs to user_packages table
                DB::raw('courses.title AS course_title')
            )
            ->groupBy('user_packages.id')
            ->get();


        
        foreach($userPackages as $userPackage){


            if(!$userPackage){
                continue;
            }


            if($this->is_package_expiredV2($userPackage)){
                continue;
            }
            
            
            $package_details =  $this->renderPackageDetailsV2($userPackage);

            $user_details = [
                'no_completed_lectures' => $package_details['no_of_completed_lectures'],
                'last_video' =>  $package_details['last_video'],
                'expire_in' => \Carbon\Carbon::parse($userPackage->created_at)->addDays($userPackage->expire_in_days),
            ];

            $package = (object)[
                'user_details' => $user_details,
                'package_details' => $package_details,

            ];

            array_push($packages_arr, $package);
        }

        return ($packages_arr);
    }

    public function is_package_expiredV2($userPackage /** row include userPackage data[id, ..,created_at] and some data of the package itself */){

        if(!$userPackage){
            return 1;
        }

        if(\Carbon\Carbon::parse($userPackage->created_at)->addDays($userPackage->expire_in_days)->gte(\Carbon\Carbon::now())){ // original package still not expired
            return 0;

        }else{
            $extension = \App\PackageExtension::where('user_id', '=', Auth::user()->id)->where('package_id', '=', $userPackage->package_id)->orderBy('expire_at', 'desc')->first();
            if(!$extension){
                return  1;

            }else{
                if(\Carbon\Carbon::parse($extension->expire_at)->gte(\Carbon\Carbon::now())){
                    return 0;

                }else{

                    return 1;
                }
            }
        }

    }


    public function is_package_expired($package_id){

        $package = \App\Packages::find($package_id);
        if(!$package){
            return 1;
        }

        $user_package = \App\UserPackages::where('user_id', '=' ,Auth::user()->id)->where('package_id', '=', $package_id)->get()->first();
        if(!$user_package){
            return 1;
        }

        if(\Carbon\Carbon::parse($user_package->created_at)->addDays($package->expire_in_days)->gte(\Carbon\Carbon::now())){ // original package still not expired
            return 0;
        }else{
            $extension = \App\PackageExtension::where('user_id', '=', Auth::user()->id)->where('package_id', '=', $package_id)->orderBy('expire_at', 'desc')->first();
            if(!$extension){
                return  1;
            }else{
                if(\Carbon\Carbon::parse($extension->expire_at)->gte(\Carbon\Carbon::now())){
                    return 0;
                }else{
                    return 1;
                }
            }
        }

    }

    public function belongsToMe($package_id){
        $package = \App\Packages::find($package_id);
        if(!$package){
            return response()->json([
                'meta' => [
                        'code' => 404,
                        'response' => 'Package not found'
                    ]
                ]);
        }

        if($this->is_package_expired($package_id)){
            return response()->json([
                'meta' => [
                    'code' => 200,
                    'response' => 'Package Expired'
                ]
            ]);
        }

        $user_package = \App\UserPackages::where('package_id', '=', $package_id)->where('user_id', '=', Auth::user()->id)->get()->first();
        if($user_package){
            return response()->json([
                'meta' => [
                        'code' => 200,
                        'response' => 'true'
                    ]
                ]);
        }

        $user_approve = \App\PaymentApprove::where('package_id', '=', $package_id)->where('user_id','=', Auth::user()->id)->get()->first();
        if($user_approve){
            return response()->json([
                'meta' => [
                        'code' => 200,
                        'response' => 'wait_approve'
                    ]
                ]);
        }

        return response()->json([
            'meta' => [
                'code' => 404,
                'response' => 'false'
            ]
        ]);


    }


    public function get_top_search(Request $req){
        /**
         * no_of_items
         */

        $package_selles_list = [];
        $packages = \App\Packages::all();
        if($packages->first()) {

            foreach ($packages as $package) {
                $item = (object)[];
                $item->package = $package->id;
                $item->users_no = count(\App\UserPackages::where('package_id', $package->id)->get());
                $total_no = 0;
                $rate = \App\Rating::where('package_id', $package->id)->get();
                $devisor = count($rate);
                foreach ($rate as $i) {
                    $total_no += $i->rate;
                }
                if ($devisor == 0) {
                    $item->total_rate = 0;
                } else {
                    $item->total_rate = round($total_no / $devisor);
                }


                array_push($package_selles_list, $item);
            }

            for ($i = 0; $i < count($package_selles_list); $i++) {
                $val = $package_selles_list[$i]->users_no;
                $val2 = $package_selles_list[$i]->package;
                $val3 = $package_selles_list[$i]->total_rate;

                $j = $i - 1;
                while ($j >= 0 && $package_selles_list[$j]->users_no < $val) {
                    $package_selles_list[$j + 1]->users_no = $package_selles_list[$j]->users_no;
                    $package_selles_list[$j + 1]->package = $package_selles_list[$j]->package;
                    $package_selles_list[$j + 1]->total_rate = $package_selles_list[$j]->total_rate;
                    $j--;
                }
                $package_selles_list[$j + 1]->users_no = $val;
                $package_selles_list[$j + 1]->package = $val2;
                $package_selles_list[$j + 1]->total_rate = $val3;
            }
        }

        $end = min($req->no_of_items, count($package_selles_list));

        $package_arr = [];

        for($i=0; $i<$end; $i++){


            $details = $this->renderPackageDetails($package_selles_list[$i]->package);
            array_push($package_arr, $details);



        }

        return response()->json($package_arr, 200);

    }


    public function getAllCourses(){
        $courses_arr = [];
        $courses = \App\Course::where('private' ,0)->get();
        foreach($courses as $course){
            $item = (object)[];
            $item->course_id = $course->id;
            $item->title = $course->title;

            array_push($courses_arr, $item);
        }

        return response()->json($courses_arr, 200);
    }


}
