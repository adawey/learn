<?php

namespace App\Http\Controllers;

use App\Localization\Locale;
use App\Repository\PackageRepositoryInterface;
use App\Repository\PostRepositoryInterface;
use App\Transcode\Transcode;
use App\Zone\Zone;
use Illuminate\Http\Request;
use App\Packages;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactUsMail;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{

    use \App\Payment\Payment;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except([
            'index'
            , 'is_package_expired'
            , 'package_view'
            ,'testupload'
            , 'sendEmailCustomer'
            , 'index_termsOfSevice'
            , 'store_termsOfSevice'
            , 'securityCheck'
            , 'eventPage'
            , 'activateAccount'
            , 'freeResourceDemoVideos'
            , 'reviews'
            , 'aboutUs'
            , 'showPost'
            , 'indexBlog'
            , 'contactPage'
            , 'getVimeoVideoHtml']); //default auth --->> auth:web
        

    }

    public function indexBlog(PostRepositoryInterface $postRepository){
        $posts = $postRepository->all([], request()->section_id);
        return view('blog.blogGrid')->with('posts', $posts);
    }

    public function showPost(PostRepositoryInterface $postRepository, $slug){

        $post = $postRepository->findBySlug($slug)->first();
        if(!$post){
            $post_id = $slug;
            $post = $postRepository->find($post_id)->first();
            if($post){
                return redirect()->route('public.post.view', $post->slug);
            }
        }


//        $comments = DB::table('page_comments')
//            ->where('page', '=', 'post')
//            ->where('item_id', '=', $post->id)
//            ->join('comments', 'page_comments.comment_id', '=', 'comments.id')
//            ->join('users', 'comments.user_id', '=', 'users.id')
//            ->join('user_details', 'users.id', '=', 'user_details.user_id')
//            ->leftJoin('replies', 'page_comments.comment_id', '=', 'replies.reply_to_id')
//            ->select(
//
//                'comments.user_id',
//                'users.name',
//                'user_details.profile_pic',
//                DB::raw('comments.id AS comment_id'),
//                DB::raw('comments.contant AS comment'),
//                'comments.created_at',
//                DB::raw('replies.id AS reply_id'),
//                DB::raw('(SELECT users.name FROM users WHERE users.id = (SELECT comments.user_id FROM comments WHERE comments.id = replies.comment_id LIMIT 1)) AS reply_name'),
//                DB::raw('(SELECT user_details.profile_pic FROM user_details WHERE user_details.user_id = (SELECT comments.user_id FROM comments WHERE comments.id = replies.comment_id LIMIT 1)) AS reply_profile_pic'),
//                DB::raw('(SELECT comments.contant FROM comments WHERE comments.id = replies.comment_id LIMIT 1) AS reply_comment'),
//                DB::raw('(SELECT comments.created_at FROM comments WHERE comments.id = replies.comment_id LIMIT 1) AS reply_created_at')
//            )
//            ->orderBy('created_at', 'desc')
//            ->get();

        return view('blog.singleBlog')
            ->with('post', $post);
    }


    public function aboutUs(){
        $userFeedBack = ($this->getUsersFeedBack());
        return view('aboutus')->with('userFeedBack', $userFeedBack);
    }


    public function activateAccount(Request $req, $user_id){

        $disabled = \App\DisabledUser::where(['user_id'=> $user_id])->first();
        
        if(!$disabled){
            return \Redirect::to(route('login'))->with('error', 'Maybe this account has been activated !');
        }

        if(!Hash::check($disabled->password, $req->hash) ){
            return \Redirect::to(route('login'))->with('error', 'Something went wrong!');
        }


        $user = new \App\User;
        $user->id = $disabled->user_id;
        $user->name = $disabled->name;
        $user->email = $disabled->email;
        $user->city = $disabled->city;
        $user->country = $disabled->country;
        $user->phone = $disabled->phone;
        $user->last_login = $disabled->last_login;
        $user->last_action = $disabled->last_action;
        $user->last_ip = $disabled->last_ip;
        $user->password = $disabled->password;
        $user->remember_token = $disabled->remember_token;
        $user->created_at = $disabled->created_at;
        $user->updated_at = $disabled->updated_at;
        $user->save();

        $disabled->delete();

        return \Redirect::to(route('login'))->with('success', 'Account has been Activated. Please Login');
    }

    public function eventPage(Locale $locale, $event_id){

        $pricing = $this->PriceDetails(\request()->coupon, $event_id, 'event');

        $event = \App\Event::find($event_id);
        if(!$event){
            return back();
        }

        $item = (object)[];
        $item->event = $event;
        $item->users_no = count(\App\EventUser::where('event_id', $event->id)->get());
        $total_no = 0;
        $rate = \App\Rating::where('event_id',$event->id)->get();
        $devisor = count($rate);
        foreach($rate as $i){
            $total_no+= $i->rate;
        }
        if($devisor == 0){
            $item->total_rate = 0;
        }else{
            $item->total_rate = $total_no/$devisor;
        }

        return view('Event')
            ->with('i', $item)
            ->with('pricing', $pricing);
    }

    public function securityCheck(Request $req){
        if(Auth::check()){
            if(Auth::user()->id == \Session('attempt_user_id')){
                return 200;
            }else{
                Auth::logout();
                return 500;
            }
        }else{
            return 500;
        }
    }

    public function index_termsOfSevice(){
        return view('admin.termOfService');
    }

    public function store_termsOfSevice(Request $req){
        $data = \App\PaypalConfig::all()->first();
        $data->term_of_service = $req->input('terms');
        $data->Privacy_Policy = $req->input('policy');
        $data->Refund_polices = $req->input('refund');
        $data->save();

        return back()->with('success', 'Terms are Updated !');
    }

    public function show_inobox(){
        return view('user.inbox');
    }

    public function contactPage(){
        return view('contactUs');
    }

    public function sendEmailCustomer(Request $req){
        $this->validate($req, [
            'name'  =>  'required',
            'email' =>  'required',
            'msg'   =>  'required'
        ]);
        $data = [
            $req->input('name'),
            $req->input('email'),
            $req->input('msg')
        ];

        Mail::to('info@EliteMinds.co')->send(new ContactUsMail($data));
        return 'Message Sent';
    }

    public function testupload(Request $req){
        if($req->hasFile('file')){
            $x = $req->file('file')->store('public/testupload');
            return $x;
        }else{
            return 0;
        }
    }

    public function user_board(Locale $locale){
        $thisUser = Auth::user();
        /**
         * Certification data
         */
        $user_certifications_number = \App\Certification::where('user_id', Auth::user()->id)->get()->count();
        $userCertifications = DB::table('certifications')
            ->where('user_id', '=', $thisUser->id)
            ->leftJoin('packages', 'certifications.package_id', '=', 'packages.id')
            ->leftJoin('events', 'certifications.event_id', '=', 'events.id')
            ->select(
                DB::raw('(CASE WHEN packages.name IS NULL THEN events.name ELSE packages.name END) AS product_name'),
                'certifications.id'
            )
            ->get();

        /**
         * Packages data
         */
        $userPackagesList = [];
        $userPackages = app('App\Http\Controllers\Users\PremiumQuizController')->userPackages($thisUser->id);
        foreach($userPackages as $package){
            $videosProgress = DB::table('videos')
                ->whereIn('chapter', explode(',', $package->chapter_included))
                ->whereNull('videos.event_id')
                ->leftJoin(DB::raw('(SELECT * FROM video_progresses WHERE package_id='.$package->package_id.' AND user_id='.$thisUser->id.' GROUP BY video_id) AS video_progresses'),
                    'videos.id','=','video_progresses.video_id')
                ->select(
                    DB::raw('COUNT(IF(video_progresses.complete = \'1\', 1, NULL)) AS watched_videos'),
                    DB::raw('COUNT(*) as all_videos')
                )
                ->first();
            array_push($userPackagesList, [
                'package'   => $package,
                'progress'  => round($videosProgress->watched_videos / ($videosProgress->all_videos == 0 ? 1: $videosProgress->all_videos) * 100),
            ]);
        }


        $user_package = \App\UserPackages::where('user_id', Auth::user()->id)->get();
        $total_package_number = $user_package->count();


        /**
         * Quizzes data
         */
        $quizzes = \App\Quiz::where('user_id', Auth::user()->id)->where('complete', 1)->get();
        $all_quizzes_number = $quizzes->count();
        $success_number = $quizzes->filter(function($row){
            return $row->score > 75;
        })->count();


        $packages = \App\Packages::query()
            ->where([
                'active'    => 1,
                'user_packages.user_id' => $thisUser->id,
            ])
            ->whereNull('user_packages.package_id')
            ->leftJoin('user_packages', 'packages.id', '=', 'user_packages.package_id')
            ->select('packages.*')
            ->get()
            ->map(function($row){
                $row->pricing = $this->PriceDetails('', $row->id, 'package');
                $row->rating = DB::table('ratings')->where('package_id', $row->id)
                    ->average('rate');
                return $row;
            });

        $userCourses = DB::table('user_packages')
            ->where('user_packages.user_id', '=', $thisUser->id)
            ->join('packages', 'user_packages.package_id', '=', 'packages.id')
            ->join('courses', 'packages.course_id', '=', 'courses.id')
            ->select(
                'courses.id',
                'courses.title'
            )
            ->groupBy('courses.id')
            ->get();


        return view('user.dashboard')
            ->with('quizzes', $quizzes)
            ->with('total_package_number', $total_package_number)
            ->with('userPackagesList', $userPackagesList)
            ->with('user_certifications_number', $user_certifications_number)
            ->with('all_quizzes_number', $all_quizzes_number)
            ->with('success_number', $success_number)
            ->with('packages_arr', $packages)
            ->with('userCourses', $userCourses)
            ->with('userCertifications', $userCertifications);
    }

    /**
     * @param Packages $package
     * @return object
     * {
     *      package (modal),
     *      total_rating,
     *      package_uri
     *      numberVideos
     *      progress
     *      package_hours
     *  }
     */
    public function renderPublicVideoPackage(\App\Packages $package)
    {
        $i = (object)[];
        $i->package = $package;
        $i->content_type = 'video';
        /**
         * Expire data
         */
//        if (\Carbon\Carbon::parse(\App\UserPackages::where('user_id', '=', Auth::user()->id)->where('package_id', '=', $package->id)->get()->first()->created_at)->addDays($package->expire_in_days)->gte(\Carbon\Carbon::now())) {
//            $i->expire_at = \Carbon\Carbon::parse(\App\UserPackages::where('user_id', '=', Auth::user()->id)->where('package_id', '=', $package->id)->get()->first()->created_at)->addDays($package->expire_in_days)->toFormattedDateString();
//        } else {
//            $i->expire_at = Carbon\Carbon::parse(\App\PackageExtension::where('user_id', '=', Auth::user()->id)->where('package_id', '=', $package->id)->orderBy('expire_at', 'desc')->get()->first()->expire_at)->toFormattedDateString();
//        }

        /**
         * Rating calculation
         */
        $total_rating = 0;
        $rate = \App\Rating::where('package_id', $package->id)->get();
        foreach ($rate as $r) {
            $total_rating += $r->rate;
        }
        if ($rate->first()) {
            $total_rating = round($total_rating / count($rate), 1);
        } else {
            $total_rating = 0;
        }
        $i->total_rating = $total_rating;

        /**
         * Package link
         */
//        if (\App\VideoProgress::where('user_id', Auth::user()->id)->where('package_id', $package->id)->where('complete', 1)->get()->first()){
//            $last_video_progress = \App\VideoProgress::where('user_id', Auth::user()->id)->where('package_id', $package->id)->where('complete', 1)->orderBy('updated_at', 'desc')->get()->first()->video_id;
//            $video = \App\Video::find($last_video_progress);
//            if ($video) {
//                $last_video_chapter_id = $video->chapter;
//                $video_id_ = \App\Video::where('chapter', explode(',', \App\Packages::find($package->id)->chapter_included)[0])->get()->first()->id;
//            } else {
//                $last_video_chapter_id = explode(',', \App\Packages::find($package->id)->chapter_included)[0];
//                $video_id_ = \App\Video::where('chapter', explode(',', \App\Packages::find($package->id)->chapter_included)[0])->get()->first()->id;
//            }
//            $package_uri = route('st4_vid', [$package->id, 'chapter', $last_video_chapter_id, $video_id_]);
//
//        }else{
//
//            $attack_video = 0;
//            $attack_chapter = 0;
//            foreach (explode(',', \App\Packages::find($package->id)->chapter_included) as $chapter_id) {
//                $attack_video = \App\Video::where('chapter', $chapter_id)->get()->first();
//                $attack_chapter = $chapter_id;
//                if ($attack_video) {
//                    break;
//                }
//            }
//            $package_uri = route('st4_vid', [$package->id, 'chapter', $attack_chapter, $attack_video->id]);
//        }
//        $i->package_uri = $package_uri;

        /**
         * Number of Package Videos
         */
        $numberVideos = Cache::remember('package'.$package->id.'videosCount', 1440, function()use($package){
            $videos_arr = [];
            if($package->chapter_included){
                foreach(explode(',', $package->chapter_included) as $chapter_id){
                    $videos = \App\Video::where('chapter', $chapter_id)->get();
                    foreach($videos as $v){
                        if(!in_array($v->id, $videos_arr)){
                            array_push($videos_arr, $v->id);
                        }
                    }
                }
            }
            return count($videos_arr);
        });
        $i->numberVideos = $numberVideos;

        /**
         * progress Percentage
         */
//        $numberCompletedVideos = \App\VideoProgress::where('user_id', Auth::user()->id)->where('package_id', $i->id)->where('complete', 1)->get()->count();
//        if($numberVideos > 0){
//            $progress = $numberCompletedVideos/$numberVideos * 100;
//        }else{
//            $progress = 0;
//        }
//        $i->progress = $progress;

        /**
         * Total Videos time
         */
        $package_hours = Cache::remember('package'.$package->id.'hoursCount', 1440, function()use($package){
            $total_hours = 0;
            $total_min = 0;
            $total_sec = 0;


            if($package->chapter_included){
                foreach(explode(',', $package->chapter_included) as $chapter_id){
                    $videos = \App\Video::where('chapter', $chapter_id)->get();
                    foreach($videos as $v){
                        if($v->duration != '' && $v->duration != null){

                            $total_min += \Carbon\Carbon::parse($v->duration)->format('i');
                            $total_sec += \Carbon\Carbon::parse($v->duration)->format('s');
                            if(\Carbon\Carbon::parse($v->duration)->format('h') != 12){
                                $total_hours += \Carbon\Carbon::parse($v->duration)->format('h');
                            }
                        }
                    }
                }
            }
            $total_time = [$total_hours, $total_min, $total_sec]; //[hr, min, sec]
            $total_time[1] += $total_time[2]/60;
            $total_time[2] = round($total_time[2]%60);

            $total_time[0] += $total_time[1]/60;
            $total_time[1] = round($total_time[1]%60);
            $total_time[0] = round($total_time[0]);
            return $total_time[0];
        });

        $i->package_hours = $package_hours;

        return $i;

    }

    /**
     * @param Packages $package
     * @return object
     *  {
     *      package (object modal),
     *      expire_at, string
     *      total_rating, number
     *      exams_num, number
     *      questions_num, number
     *  }
     */
    public function renderPublicExamPackage(\App\Packages $package)
    {
        $i = (object)[];
        $i->package = $package;
        $i->content_type = 'question';
        /**
         * Expire data
         */
//        if (\Carbon\Carbon::parse(\App\UserPackages::where('user_id', '=', Auth::user()->id)->where('package_id', '=', $package->id)->get()->first()->created_at)->addDays($package->expire_in_days)->gte(\Carbon\Carbon::now())) {
//            $i->expire_at = \Carbon\Carbon::parse(\App\UserPackages::where('user_id', '=', Auth::user()->id)->where('package_id', '=', $package->id)->get()->first()->created_at)->addDays($package->expire_in_days)->toFormattedDateString();
//        } else {
//            $i->expire_at = Carbon\Carbon::parse(\App\PackageExtension::where('user_id', '=', Auth::user()->id)->where('package_id', '=', $package->id)->orderBy('expire_at', 'desc')->get()->first()->expire_at)->toFormattedDateString();
//        }

        /**
         * Rating calculation
         */
        $total_rating = 0;
        $rate = \App\Rating::where('package_id', $package->id)->get();
        foreach($rate as $r){
            $total_rating += $r->rate;
        }
        if($rate->first()){
            $total_rating = round($total_rating / count($rate), 1);
        }else{
            $total_rating = 0;
        }
        $i->total_rating = $total_rating;
        /**
         * Package meta data like [exams count, questions count]
         */
        $exams_num = Cache::remember('package'.$package->id.'examsCount', 1440, function()use($package){
            return count(explode(',', $package->chapter_included)) + count(explode(',', $package->process_group_included)) + count(explode(',', $package->exams));
        });
        $i->exams_num = $exams_num;
        $questions_num = Cache::remember('package'.$package->id.'questionsCount', 1440, function()use($package){
            $count = [];
            if($package->chapter_included){
                foreach(explode(',', $package->chapter_included) as $chapter_id){
                    $questions = \App\Question::where('chapter', $chapter_id)->get();
                    foreach($questions as $q){
                        if(!in_array($q->id, $count)){
                            array_push($count, $q->id);
                        }
                    }
                }
            }
            if($package->process_group_included){
                foreach(explode(',', $package->process_group_included) as $process_id){
                    $questions = \App\Question::where('process_group', $process_id)->get();
                    foreach($questions as $q){
                        if(!in_array($q->id, $count)){
                            array_push($count, $q->id);
                        }
                    }
                }
            }
            if($package->exams){
                foreach(explode(',', $package->exams) as $exam_id){
                    $questions = \App\Question::where('exam_num', 'LIKE' , '%'.$exam_id.'%')->get();
                    foreach($questions as $q){
                        if(!in_array($q->id, $count)){
                            array_push($count, $q->id);
                        }
                    }
                }
            }
            return count($count);
        });
        $i->questions_num = $questions_num;

        return $i;
    }

    public function getVimeoVideoHtml(Request $request){
        $video = DB::table('videos')->where([
            'demo'  => 1,
            'id'    => $request->video_id,
        ])->first();
        if($video){
            $video->html = (app('App\Http\Controllers\VideoController')->Vimeo_GetVideo($video->vimeo_id))->embed->html;
        }

        return response()->json([
            'html'    => $video->html,
        ], 200);
    }

    public function package_view(Request $req, $id){

        $package = \App\Packages::find($id);
        
        if(!$package){
            $package = \App\Packages::where('slug', $id)->first();
            if(!$package){
                return redirect()->route('index');
            }
        }else{
            if($package->slug){

                return redirect()->route('public.package.view', $package->slug);
            }
        }

        $id = $package->id;

        if(!Auth::user()){
            $coupon = $req->coupon;
            $prev_url = route('public.package.view', $id);
            $prev_url .= $coupon ? '?coupon='.$coupon: '';
            \Session(['prev_url' => $prev_url]);
        }

        $locale = new Locale;


        $pricing = $this->PriceDetails($req->coupon, $id, 'package');

        if($req->has('coupon')){
            $coupon = \App\Coupon::where('code', $req->coupon)->first();
            if(!$coupon){
                return \Redirect::to(route('public.package.view', $id));    
            }
            if(\Carbon\Carbon::parse($coupon->expire_date)->lt(\Carbon\Carbon::now()) || ($coupon->no_use) == 0) {
                return \Redirect::to(route('public.package.view', $id));    
            }
        }
        
        
        
        
        
        if(!$package->active){
            return \Redirect::to(route('index'));
        }
        if($package){


            $item = (object)[];
            $item->package = $package;
            $item->users_no = count(\App\UserPackages::where('package_id', $package->id)->get());
            $total_no = 0;
            $rate = \App\Rating::where('package_id',$package->id)->get();
            $devisor = count($rate);
            foreach($rate as $i){
                $total_no+= $i->rate;
            }
            if($devisor == 0){
                $item->total_rate = 0;
            }else{
                $item->total_rate = $total_no/$devisor;
            }

            $total_quiz_num = 0;
            $total_question_num = 0;

            /**
             * included content of package generation.
             */
            $chapters_inc   = [];
            $process_inc    = [];
            $exams_inc      = [];

            $total_videos_num = 0;
            $chapter_data = (object)['question_num'=>0, 'quiz_num'=>0];
            $process_data = (object)['question_num'=>0, 'quiz_num'=>0];
            $exam_data = (object)['question_num'=>0, 'quiz_num'=>0];

            $exams = $package->exams;


            $package_total_video_time = [0,0,0]; // hr,min,sec
            $package_total_time_toString = '';
            if($package->chapter_included != '' || $package->chapter_included != null){
                $arr_chapters_id = explode(',',$package->chapter_included);

                if( !empty($arr_chapters_id)){
                    $i=1;
                    foreach($arr_chapters_id as $id){
                        $ch = \App\Chapters::where('id', '=', $id)->get()->first();
                        $x = (object)[];
                        $x->num = $i;
                        $x->id = $ch->id;
                        $x->name = $ch->name;
                        $x->name_ar = Transcode::evaluate($ch)['name'];
                        $x->total_hours = 0;
                        $x->total_min = 0;
                        $x->total_sec = 0;
                        $x->total_time_toString = '';

                        foreach(\App\Video::where('chapter', $ch->id)->get() as $video){
                            if($video->duration != '' && $video->duration != null){

                                $x->total_min += \Carbon\Carbon::parse($video->duration)->format('i');
                                $x->total_sec += \Carbon\Carbon::parse($video->duration)->format('s');
                                if(\Carbon\Carbon::parse($video->duration)->format('h') != 12){
                                    $x->total_hours += \Carbon\Carbon::parse($video->duration)->format('h');
                                }
                            }
                        }


                        $x->total_min += floor($x->total_sec / 60);
                        $x->total_sec = $x->total_sec % 60;

                        $x->total_hours += floor($x->total_min / 60);
                        $x->total_min = $x->total_min % 60;







                        $package_total_video_time[0] += $x->total_hours;
                        $package_total_video_time[1] += $x->total_min;
                        $package_total_video_time[2] += $x->total_sec;

                        $x->total_time_toString = \Carbon\Carbon::create(2012, 1, 1, 0, 0, 0)->addHours($x->total_hours)->addMinutes($x->total_min)->addSeconds($x->total_sec)->format('H  i');

                        if($package->filter == 'chapter' || $package->filter == 'chapter_process'){
                            if(count(\App\Question::where('chapter', $ch->id)->get()) > 0){
                                $total_quiz_num++;
                                $total_question_num += count(\App\Question::where('chapter', $ch->id)->get());
                                $chapter_data->question_num += count(\App\Question::where('chapter', $ch->id)->get());
                                $chapter_data->quiz_num++;
                            }    
                        }

                        array_push($chapters_inc, $x);

                        $total_videos_num += count(\App\Video::where('chapter', $id)->get());
                        $i++;
                    }
                }
            }

            $package_total_time_toString = \Carbon\Carbon::create(2012, 1, 1, 0, 0, 0)->addHours($package_total_video_time[0])->addMinutes($package_total_video_time[1])->addSeconds($package_total_video_time[2]);
            $number_of_hours = $package_total_time_toString->diffInHours(\Carbon\Carbon::create(2012, 1, 1, 0, 0, 0));
             $number_of_minutess = $package_total_time_toString->format('i');

             if($locale->locale == 'en'){
                 $total_time = ($number_of_hours) . ' Hr '.($number_of_minutess).' Min';
             }else{
                 $total_time = ($number_of_hours) . ' ساعة '.($number_of_minutess).'دقيقة ';
             }


            if($package->process_group_included != '' || $package->process_group_included != null){
                $arr_process_id = explode(',',$package->process_group_included);
                if( !empty($arr_process_id != '')){
                    $i=1;
                    foreach($arr_process_id as $id){
                        $ch = \App\Process_group::where('id', '=', $id)->get()->first();
                        $x = (object)[];
                        $x->id = $ch->id;
                        $x->num = $i;
                        $x->name = $ch->name;
                        $x->name_ar = Transcode::evaluate($ch)['name'];

                        if($package->filter == 'process' || $package->filter == 'chapter_process'){
                            
                            if(count(\App\Question::where('process_group', $ch->id)->get()) > 0){
                                $total_quiz_num++;
                                $total_question_num += count(\App\Question::where('process_group', $ch->id)->get());
                                $process_data->question_num += count(\App\Question::where('process_group', $ch->id)->get());
                                $process_data->quiz_num++;
                            }
                        }
                        array_push($process_inc, $x);
                        $i++;

                    }
                }
            }

            if($exams != null){
                $exams = explode(',', $exams);
                $i=1;
                foreach($exams as $e){
                    $e_ = \App\Exam::find($e);
                    $x = (object)[];
                    $x->id = $e;
                    $x->num = $i;
                    $x->name = $e_->name;
                    $x->name_ar = Transcode::evaluate($e_)['name'];
                    if(count(\App\Question::where(DB::raw("CONCAT(',', TRIM(BOTH '\"' FROM `exam_num`), ',')"), 'LIKE', '%,'.$e.',%')->get()) > 0){
                        $total_quiz_num++;
                        $total_question_num += count(\App\Question::where(DB::raw("CONCAT(',', TRIM(BOTH '\"' FROM `exam_num`), ',')"), 'LIKE', '%,'.$e.',%')->get());
                        $exam_data->question_num += count(\App\Question::where(DB::raw("CONCAT(',', TRIM(BOTH '\"' FROM `exam_num`), ',')"), 'LIKE', '%,'.$e.',%')->get());
                        $exam_data->quiz_num++;
                    }
                    array_push($exams_inc, $x);
                    $i++;

                }
            }

            $package_total_video_time[1] += round($package_total_video_time[2]/60);
            $package_total_video_time[2] = round($package_total_video_time[2]%60);

            $package_total_video_time[0] += round($package_total_video_time[1]/60);
            $package_total_video_time[1] = round($package_total_video_time[1]%60);
            $rating = DB::table('ratings')->where('package_id', $package->id)
                ->select(
                    DB::raw('AVG(rate) as avg_rate'),
                    DB::raw('COUNT(*) as ratings_number'),
                    DB::raw('COUNT(IF(ratings.rate = \'5\', 1, NULL)) as five_stars'),
                    DB::raw('COUNT(IF(ratings.rate = \'4\', 1, NULL)) as four_stars'),
                    DB::raw('COUNT(IF(ratings.rate = \'3\', 1, NULL)) as three_stars'),
                    DB::raw('COUNT(IF(ratings.rate = \'2\', 1, NULL)) as two_stars'),
                    DB::raw('COUNT(IF(ratings.rate = \'1\', 1, NULL)) as one_stars')
                )->first();
            if($rating->ratings_number <= 0 ){
                $rating->ratings_number =1 ;
            }

            return view("Package")->with('i', $item)
                ->with('rating', $rating)
                ->with('chapter_list', $chapters_inc)
                ->with('process_list', $process_inc)
                ->with('exam_list', $exams_inc)
                ->with('total_videos_num', $total_videos_num)
                ->with('total_quiz_num', $total_quiz_num)
                ->with('total_question_num', $total_question_num)
                ->with('chapter_data', $chapter_data)
                ->with('process_data', $process_data)
                ->with('exam_data', $exam_data)
                ->with('total_time', $total_time)
                ->with('package_total_video_time', $package_total_video_time)
                ->with('pricing', $pricing);

        }else{
            return back();
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

    public function getPromotedCouponDetails($coupon){
        $cObj = (object)[];
        if($coupon){
            $now = (\Carbon\Carbon::now());
            $to = ($coupon->expire_date);
            $diff = \Carbon\Carbon::parse($to)->diffInSeconds($now);
            $total_time = gmdate('H:i:s', $diff);

            // $diff = $to - $now;

            // $total_time = [ 0, 0, $diff]; // hr, min, sec
            // $total_time[1] += $total_time[2]/60;
            // $total_time[2] = round($total_time[2]%60);
            // $total_time[0] += $total_time[1]/60;
            // $total_time[1] = round($total_time[1]%60);
            // $total_time[0] = round($total_time[0]);

            $cObj->coupon = $coupon;
            $cObj->total_time = $total_time;
            
            

            if($coupon->package_id){
                $cObj->coupon_link = route('public.package.view', $coupon->package_id  ).'?coupon='.$coupon->code;
                $cObj->new_price = max($coupon->package_price - $coupon->coupon_price, 0);
            }
            if($coupon->event_id){
                $cObj->coupon_link = route('public.event.view', $coupon->event_id  ).'?coupon='.$coupon->code;
                $cObj->new_price = max($coupon->event_price - $coupon->coupon_price, 0);
            }
            return $cObj;
        }
        
        return null;
    }

    public function getWebSiteStatistics(){
        $student_no = Cache::remember('student_no', 1440, function(){
            return DB::table('users')->select(DB::raw('COUNT(*) as student_no'))->first()->student_no;
        });

        $package_no = Cache::remember('package_no', 1440, function(){
            return DB::table('packages')->select(DB::raw('COUNT(*) as package_no'))->first()->package_no;
        });

        $sObj = (object)[];
        $sObj->student_no = $student_no;
        $sObj->package_no = $package_no;
        return $sObj;
    }


    public function getUsersFeedBack(){
        Cache::forget('userFeedBackCache');
        return (Cache::remember('userFeedBackCache', 1440, function(){
            return DB::table('feedback')
                ->where('disable', '=', 0)
                ->leftJoin('users', 'feedback.user_id', '=', 'users.id')
                ->leftJoin('user_details', 'users.id', '=', 'user_details.user_id')
                ->select('feedback.*', 'users.name', 'users.country', 'user_details.profile_pic')
                ->inRandomOrder()
                ->limit(20)
                ->get();
        }));
    }

    public function getEventDetails($country_code, $lang){
        /** Get translation table name */
        /** @var  $translationTable */
        $translationTable = Transcode::getTranslationTable($lang);
        /** Forget Cache if it required */
        // Cache::forget('eventsDetailsCache-'.$country_code.'-'.$lang);
        return (Cache::remember('eventsDetailsCache-'.$country_code.'-'.$lang, 1440, function()use($translationTable){
            $events = DB::table('events')
                ->where('active', '=', 1)
                ->where('end' , '>', now())
                ->leftJoin('ratings', 'events.id', '=', 'ratings.event_id')
                ->leftJoin('event_user', 'events.id', '=', 'event_user.event_id')
                ->leftJoin('courses', 'events.course_id', '=', 'courses.id');
            if($translationTable){
                $events = $events->leftJoin(DB::raw('(SELECT '.$translationTable.'.column_, '.$translationTable.'.transcode, '.$translationTable.'.row_ FROM '.$translationTable.' WHERE table_ = \'events\') AS event_title_transcodes'), function($join){
                    $join->on('event_title_transcodes.row_', '=', 'events.id');
                })->select(
                    DB::raw('(CASE WHEN event_title_transcodes.transcode IS NULL THEN events.name ELSE event_title_transcodes.transcode END) AS name'),
                    'events.id',
                    DB::raw('AVG((CASE WHEN ratings.rate IS NOT NULL THEN ratings.rate ELSE 0 END)) AS rate'),
                    DB::raw('SUM((CASE WHEN event_user.id IS NOT NULL THEN 1 ELSE 0 END)) AS enrolled_student_no'),
                    DB::raw('courses.title AS course_title'),
                    'events.total_time',
                    'events.total_lecture',
                    'events.start',
                    'events.price',
                    'events.img'
                );
            }else{
                $events = $events->select(
                    'events.id',
                    DB::raw('AVG((CASE WHEN ratings.rate IS NOT NULL THEN ratings.rate ELSE 0 END)) AS rate'),
                    DB::raw('SUM((CASE WHEN event_user.id IS NOT NULL THEN 1 ELSE 0 END)) AS enrolled_student_no'),
                    DB::raw('courses.title AS course_title'),
                    'events.name',
                    'events.total_time',
                    'events.total_lecture',
                    'events.start',
                    'events.price',
                    'events.img'
                );
            }

            $events = $events->groupBy('events.id')->get();

            $event_arr = [];
            if(count($events)){
                foreach($events as $event){
                    $i = (object)[];
                    $i->event = $event;
                    $i->pricing = $this->PriceDetails('', $event->id, 'event');
                    array_push($event_arr, $i);
                }
            }
            return $event_arr;
        }));
    }

    /**
     * Show the application dashboard.
     *
     * @param Locale $locale
     * @param PackageRepositoryInterface $packageRepository
     * @return \Illuminate\Http\Response
     */
    public function index(Locale $locale, PackageRepositoryInterface $packageRepository,
          PostRepositoryInterface $postRepository)
    {
        DB::enableQueryLog();
        // return 'under maintenance';
        /**
         * Get Promoted Coupon
         */
        Cache::forget('promoted_coupon');
        $promoted = Cache::remember('promoted_coupon', 1440, function(){
            $coupon = DB::table('coupons')
                ->where('promote', '=', 1)
                ->leftJoin('packages', 'coupons.package_id', '=', 'packages.id')
                ->leftJoin('events', 'coupons.event_id', '=', 'events.id')
                ->limit(1)
                ->select(
                    DB::raw('coupons.id AS coupon_id'),
                    DB::raw('coupons.price AS coupon_price'),
                    'coupons.code',
                    'coupons.no_use',
                    'coupons.package_id',
                    'coupons.event_id',
                    'coupons.expire_date',
                    DB::raw('packages.price AS package_price'),
                    DB::raw('events.price AS event_price')
                )
                ->first();
            if($coupon){
                if(\Carbon\Carbon::parse($coupon->expire_date)->gt(\Carbon\Carbon::now()) && ($coupon->no_use) > 0){
                    return $coupon;
                }
            }
            return null;
        });

        $promotedCouponDetails = $this->getPromotedCouponDetails($promoted);

        /**
         * WebSite Statistics
         */
        $webSiteStatistics = $this->getWebSiteStatistics();

        /**
         * Get Available courses data
         */
        Cache::forget('coursesIndexPage');
        $courses = Cache::remember('coursesIndexPage', 1440, function(){
            return \App\Course::where('private', '=', 0)->orderBy('updated_at','desc')->limit(6)
                ->get();
        });

        $country_code = Zone::getLocation()->country_code;

        /**
         * Get Popular Courses Data
         */
        $popular_courses = $packageRepository->getPopularPackages($country_code, $locale->locale);
        // dd($popular_courses );
        /**
         * Get users FeedBack
         */
        $userFeedBack = ($this->getUsersFeedBack());

        /**
         * Get Event Details
         */
        $events = $this->getEventDetails($country_code, $locale->locale);
        
        /**
         * Get FAQ
         */
        // Cache::forget('faq.public');
        $faq = Cache::remember('faq.public', 1440, function(){
            return (\App\FAQ::query()
                ->limit(4)
                ->orderBy('created_at', 'desc')
                ->get());
        });
        
        $feedbackRating = DB::table('feedback')
            ->select(
                DB::raw('AVG(rate) AS rate'),
                DB::raw('COUNT(*) AS rate_count')
            )->first();

        $posts = ($postRepository->all()->take(8));
        
         
        return view('index')
            ->with('promotedCouponDetails', $promotedCouponDetails)
            ->with('webSiteStatistics', $webSiteStatistics)
            ->with('courses', $courses)
            ->with('popular_courses', $popular_courses)
            ->with('userFeedBack', $userFeedBack)
            ->with('events', $events)
            ->with('faq', $faq)
            ->with('feedbackRating', $feedbackRating)
            ->with('posts', $posts);

    }



    public function freeResourceDemoVideos(){
        return view('freeResourceVideos');
    }

    public function showAllPackages($course_id){
        return view('packages.showAll')->with('course_id',$course_id);
    }

    public function showProfile(Locale $locale, Request $req){
        
        $user_details = \App\UserDetail::where('user_id', '=', Auth::user()->id)->get()->first();

        if($req->has('edit')){
            return view('user.profile-edit')->with('user_details', $user_details);
        }
        return view('user.profile')->with('user_details', $user_details);
    }


    public function UserUpdatePasswordRequest(Request $req){
        $this->validate($req, [
            'old_password'              =>  'required|string|min:6',
            'password'                  =>  'required|string|min:6|confirmed', 
        ]);

        

        if(!\Hash::check($req->input('old_password'), Auth::user()->password)){
            return \redirect(route('show.profile').'#tab_1_3')->with('error', 'wrong password !');
        }
        $user = \App\User::find(Auth::user()->id);
        $user->password = \Hash::make($req->input('password'));
        $user->save();

        return \Redirect::to(route('show.profile'))->with('success', 'Password Updated');


    }

    public function UserUpdateProfileInfo(Request $req){
        $this->validate($req, [
            'name'      =>'required|string',
            'email'     =>'required',
            'phone'     =>'required',
            'city'      =>'required',
            // country is required , check for it later on
            'occupation'=>'required',
        ]);

        $user1 = \App\User::where('email','=',$req->input('email'))->get()->first();
        if($user1){
            if($user1->id != Auth::user()->id){
                return back()->with('error', 'this email is already in use !');
            }
        }
        
        
        $user = \App\User::find(Auth::user()->id);
        $user->name = $req->input('name');
        
        $user->email = $req->input('email');
        $user->phone = $req->input('phone');
        $user->city = $req->input('city');
        if($req->input('country') != ''){
            $user->country = $req->input('country');
        }
        $user->save();
        
        $info = \App\UserDetail::where('user_id', '=', $user->id)->get()->first();
        if(!$info){
            $info = new \App\UserDetail;
            $info->user_id = $user->id;
        }
        
        $info->interests = $req->input('interests');
        $info->occupation = $req->input('occupation');
        $info->about = $req->input('about');
        $info->fb_url = $req->input('fb_url');
        $info->tw_url = $req->input('tw_url');
        $info->website_url = $req->input('website_url');
        $info->save();

        return \Redirect::to(route('show.profile'))->with('success', 'Profile updated');
        
    }

    public function UserUpdateProfilePic(Request $req){

        $this->validate($req, [
            'profile_pic' => 'required|mimes:jpg,png,jpeg'
        ]);

        
        

        $info = \App\UserDetail::where('user_id', '=', Auth::user()->id)->get()->first();
        if(!$info){
            $info = new \App\UserDetail;
            $info->user_id = Auth::user()->id;
        }

        if($info->profile_pic){
            if(Storage::exists($info->profile_pic)){
                Storage::delete($info->profile_pic);
            }
        }

        // store the img
        $path = $req->file('profile_pic')->store('public/profile_picture');

        $info->profile_pic = $path;
        $info->save();
        return \Redirect::to(route('show.profile'))->with('success', 'Profile picture updated');
    }

    

    public function reviews(){
        return view('reviews');
    }










}
