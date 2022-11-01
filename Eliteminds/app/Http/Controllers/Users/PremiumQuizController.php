<?php

namespace App\Http\Controllers\users;

use App\Helper\QuizHistoryHelper;
use App\Localization\Locale;
use App\Transcode\Transcode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Question;
use App\Chapters;
use App\Process_group;
use App\UserPackages;
use App\Packages;
use App\UserScore;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use \App\Helper\QuestionHelper;

class PremiumQuizController extends Controller
{

    use QuestionHelper;
    use QuizHistoryHelper;

    public $per_part = 180;

    public function optimizeQuestionTranslation($questions){
        $qustions_arr = [];
        $lastQuestionID = 0;
        $lastQuestionObj = null;

        for($i=0; $i <  count($questions); $i++){
            if($lastQuestionID == $questions[$i]->id){
                $lastQuestionObj->transcodes[$questions[$i]->column_] = $questions[$i]->transcode;
                // case last loop
                if($i == count($questions) - 1){
                    array_push($qustions_arr, $lastQuestionObj);
                }
            }else{
                // push lastQuestionObj to Questions_arr
                // case first loop
                if($lastQuestionID != 0){
                    array_push($qustions_arr, $lastQuestionObj);
                }

                // load the new question data
                $lastQuestionID = $questions[$i]->id;
                $lastQuestionObj = (object)[];
                $lastQuestionObj->title = $questions[$i]->title;
                $lastQuestionObj->a = $questions[$i]->a;
                $lastQuestionObj->b = $questions[$i]->b;
                $lastQuestionObj->c = $questions[$i]->c;
                $lastQuestionObj->chapter = $questions[$i]->chapter;
                $lastQuestionObj->chapter_name = $questions[$i]->chapter_name;
                $lastQuestionObj->correct_answer = $questions[$i]->correct_answer;
                $lastQuestionObj->created_at = $questions[$i]->created_at;
                $lastQuestionObj->demo = $questions[$i]->demo;
                $lastQuestionObj->exam_num = $questions[$i]->exam_num;
                $lastQuestionObj->feedback = $questions[$i]->feedback;
                $lastQuestionObj->id = $questions[$i]->id;
                $lastQuestionObj->img = $questions[$i]->img;
                $lastQuestionObj->process_group = $questions[$i]->process_group;
                $lastQuestionObj->process_group_name = $questions[$i]->process_group_name;
                $lastQuestionObj->project_management_group = $questions[$i]->project_management_group;
                $lastQuestionObj->updated_at = $questions[$i]->updated_at;
                $lastQuestionObj->transcodes = [
                    'title' => $questions[$i]->title,
                    'a' => $questions[$i]->a,
                    'b' => $questions[$i]->b,
                    'c' => $questions[$i]->c,
                    'correct_answer' => $questions[$i]->correct_answer,
                    'feedback' => $questions[$i]->feedback,
                ];
                // push first tarnslate
                $lastQuestionObj->transcodes[$questions[$i]->column_] = $questions[$i]->transcode;
            }

        }

        return $qustions_arr;
    }
    
    public function QuizHistory_scoreFeedback(Request $req){
        $quiz = DB::table('quizzes')
            ->where('id', $req->quiz_id)
            ->where('user_id', Auth::user()->id)
            ->first();
        if($quiz){
            DB::table('quizzes')
                ->where('id', $req->quiz_id)
                ->update(['score' => $req->score]);
        }
        return response()->json($req->all(), 200);
    }

    /**
     * @param Request $req
     * @return array
     */
    public function QuizHistory_load(Request $req){
        $locale = new Locale();

        $quiz = \App\Quiz::find($req->quiz_id);
        if($quiz){
            $historyData = $this->getQuizData($quiz->id);

            switch($quiz->topic_type){
                case 'exam':
                    $questions =  DB::table('questions')
                        ->where(DB::raw("CONCAT(',', TRIM(BOTH '\"' FROM `exam_num`), ',')"), 'LIKE', '%,'.$quiz->topic_id.',%')
                        ->select('questions.id')
                        ->get()
                        // ->take($quiz->questions_number)
                        ->pluck(['id']);
                    break;
                case 'chapter':
                    $questions =  DB::table('questions')
                        ->where('chapter', '=', $quiz->topic_id)
                        ->select('questions.id')
                        ->get()
                        // ->take($quiz->questions_number)
                        ->pluck(['id']);
                    break;
                case 'process':
                    $questions =  DB::table('questions')
                        ->where('process_group', '=', $quiz->topic_id)
                        ->select('questions.id')
                        ->get()
                        // ->take($quiz->questions_number)
                        ->pluck(['id']);
                        
                    $questions = $this->DivideIntoParts($questions, $this->per_part, $quiz->part_id);
                    break;
                case 'mistake':
                    $questions0 =  DB::table('quizzes')
                        ->where('user_id', $quiz->user_id)
                        ->where('package_id', $quiz->package_id)
                        ->where(function($q)use($quiz){
                            if($quiz->topic_id == 1){
                                $q->where('topic_type', 'chapter');
                            }elseif($quiz->topic_id == 2){
                                $q->where('topic_type', 'process');
                            }elseif($quiz->topic_id == 3){
                                $q->where('topic_type', 'exam');
                            }
                        })
                        ->leftJoin('wrong_answers', 'quizzes.id', '=', 'wrong_answers.quiz_id')
                        ->join('questions', function($join){
                            $join->on('wrong_answers.question_id', '=', 'questions.id');
                        })
                        ->select('questions.id');

                    $questions1 =  DB::table('quizzes')
                        ->where('user_id', $quiz->user_id)
                        ->where('package_id', $quiz->package_id)
                        ->where(function($q)use($quiz){
                            if($quiz->topic_id == 1){
                                $q->where('topic_type', 'chapter');
                            }elseif($quiz->topic_id == 2){
                                $q->where('topic_type', 'process');
                            }elseif($quiz->topic_id == 3){
                                $q->where('topic_type', 'exam');
                            }
                        })
                        ->leftJoin('wrong_drag_right_answers', 'quizzes.id', '=', 'wrong_drag_right_answers.quiz_id')
                        ->join('questions', function($join){
                            $join->on('wrong_drag_right_answers.question_id', '=', 'questions.id');
                        })
                        ->select('questions.id');

                    $questions =  DB::table('quizzes')
                        ->where('user_id', $quiz->user_id)
                        ->where('package_id', $quiz->package_id)
                        ->where(function($q)use($quiz){
                            if($quiz->topic_id == 1){
                                $q->where('topic_type', 'chapter');
                            }elseif($quiz->topic_id == 2){
                                $q->where('topic_type', 'process');
                            }elseif($quiz->topic_id == 3){
                                $q->where('topic_type', 'exam');
                            }
                        })
                        ->leftJoin('wrong_drag_center_answers', 'quizzes.id', '=', 'wrong_drag_center_answers.quiz_id')
                        ->join('questions', function($join){
                            $join->on('wrong_drag_center_answers.question_id', '=', 'questions.id');
                        })
                        ->select('questions.id')
                        ->union($questions0)
                        ->union($questions1)
                        ->groupBy('questions.id')
                        ->get()
                        ->pluck(['id']);
                    break;
            }

            if(count($questions)){
                $questions = $this->batchQuestionLoader($questions)->toArray();
                $x = $this->reArrange($questions);
                $start_ = $quiz->start_part;
                return response()->json([
                    'questions' => $this->startFromPart($x[0], $x[1], $start_),
                    'answers_number' => $quiz->answered_question_number,
                    'answers'   => $historyData['answers'],
                    'dragRightAnswers'   => $historyData['dragRightAnswers'],
                    'dragCenterAnswers'   => $historyData['dragCenterAnswers'],
                ], 200);
            }
            return response()->json([], 404);
        }
        return response()->json([], 200);
    }

    public function QuizHistory_show($id){
        $locale = new Locale();
        $quiz = \App\Quiz::find($id);

        if($quiz){
            if($quiz->topic_type == 'chapter'){
                $topic = \App\Chapters::find($quiz->topic_id)->name;
            }elseif($quiz->topic_type == 'process'){
                $topic = \App\Process_group::find($quiz->topic_id)->name;
            }elseif($quiz->topic_type == 'exam'){
                $topic = \App\Exam::find($quiz->topic_id)->name;
            }elseif($quiz->topic_type == 'mistake'){
                if($quiz->topic_id == 1){
                    $topic = 'Chapter Mistakes';
                }else if($quiz->topic_id == 2){
                    $topic = 'Process Group Mistakes';
                }else if($quiz->topic_id == 3){
                    $topic = 'Exam Mistakes';
                }

            }
            $score = $quiz->score;

            if($topic){
                return view('PremiumQuiz.review')
                    ->with('quiz', $quiz)
                    ->with('topic', $topic)
                    ->with('score', $score);
            }
            return back()->with('error','Error !');

        }else{
            return back()->with('error','Error !');
        }

    }


    public function reset_package($package_id){


        $history = \App\ExtensionHistory::where('package_id', '=', $package_id)->where('user_id', '=', Auth::user()->id)->get()->first();
        $package = \App\Packages::find($package_id);
        if(!$package){
            return back()->with('error', 'package not found !');
        }

        if($history){
            if($history->extend_num >= $package->max_extension_in_days){
                /** delete data from extension history */
                // $history->delete();
            }else{
//                return back()->with('error', 'You can extend the package with less price !');
            }

        }


        /** delete data from userPackages ! */
        $user_package = \App\UserPackages::where('package_id', '=', $package_id)->where('user_id', '=', Auth::user()->id)->get()->first();
        if($user_package){
            $user_package->delete();
        }

        /** delete data from package extension table */
        $extension = \App\PackageExtension::where('package_id', '=', $package_id)->where('user_id' , '=', Auth::user()->id)->get();
        if($extension->first()){
            foreach($extension as $ex){
                $ex->delete();
            }
        }

        $quizzes = \App\Quiz::where('user_id', '=', Auth::user()->id)->where('package_id','=', $package_id)->get();
        foreach($quizzes as $q){
            DB::table('correct_answers')->where('quiz_id', $q->id)->delete();
            DB::table('wrong_answers')->where('quiz_id', $q->id)->delete();
            $q->delete();
        }

        $video_progress = \App\VideoProgress::where('user_id', Auth::user()->id)->where('package_id', $package_id)->get();
        if($video_progress){
            foreach($video_progress as $v){
                $v->delete();
            }
        }

        return back()->with('success', 'Now You can buy the package again');
    }

    public function ScreenShot(){
        $thisUser = Auth::user();
        $shot = \App\ScreenShot::where('user_id', '=', Auth::user()->id)->get()->first();
        if(!$shot){
            $shot = new \App\ScreenShot;
            $shot->user_id= $thisUser->id;
            $shot->count = 1;

        }else{
            $shot->count+=1;
        }

        $shot->save();

        if($shot->count >= 10){

            $user = \App\User::find($thisUser->id);

            Auth::logout();
            //log him out..

            $disUser = new \App\DisabledUser;
            $disUser->user_id = $user->id;
            $disUser->name = $user->name;
            $disUser->email = $user->email;
            $disUser->city = $user->city;
            $disUser->country = $user->country;
            $disUser->phone = $user->phone;
            $disUser->last_login = $user->last_login;
            $disUser->last_action = $user->last_action;
            $disUser->last_ip = $user->last_ip;
            $disUser->password = $user->password;
            $disUser->remember_token = $user->remember_token;
            $disUser->created_at = $user->created_at;
            $disUser->updated_at = $user->updated_at;
            $disUser->save();
            $user->delete();

            return 'disabled';

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

    public function indexSt1(){
        $package_list = []; // list of all chapter and process Group in our data base
        $expire_package = [];
        // $package_name = '';
        $packages = UserPackages::where('user_id','=', Auth::user()->id)->get();
        if($packages->first()){
            foreach ($packages as $package) {
                $package_data = Packages::where('id', '=', $package->package_id)->get()->first();

                if($this->is_package_expired($package_data->id)){
                    array_push($expire_package, $package_data);
                }else{
                    array_push($package_list, $package_data);
                }






            }
        }

        $video_packages = $this->indexSt1Video();
        $video_package_list = $video_packages['package_list'];

        $video_package_progress = $video_packages['package_progress'];

        return view('PremiumQuiz/index-st1')
            ->with('package_list', $package_list)
            ->with('expire_package', $expire_package)
            ->with('video_package_list', $video_package_list)
            ->with('video_package_progress', $video_package_progress);
    }


    public function indexSt1Video(){
        return redirect()->to(route('user.dashboard'));
        $package_list = []; // list of all chapter and process Group in our data base
        $expire_package = [];

        $package_progress = [];

        // $package_name = '';
        $packages = UserPackages::where('user_id','=', Auth::user()->id)->get();
        if($packages->first()){
            foreach ($packages as $package) {
                $package_data = Packages::where('id', '=', $package->package_id)->get()->first();

                if($this->is_package_expired($package_data->id)){
                    array_push($expire_package, $package_data);
                }else{
                    array_push($package_list, $package_data);
                }
            }
        }


        foreach($package_list as $package){
            if($package->contant_type == 'video' || $package->contant_type =='combined'){
                $chapters_inc = [];
                $total_videos_no = 0;
                $completed_videos_no = count(\App\VideoProgress::where('package_id', $package->id)->where('user_id', Auth::user()->id)->where('complete', 1)->get());
                // calculate the chapters included within the package
                if($package->chapter_included != '' || $package->chapter_included != null){
                    $arr_chapters_id = explode(',',$package->chapter_included);
                    if( !empty($arr_chapters_id)){
                        foreach($arr_chapters_id as $id){
                            $ch = Chapters::where('id', '=', $id)->get()->first();
                            array_push($chapters_inc, $ch->id);
                        }
                    }
                }
                foreach($chapters_inc as $chapter){
                    $n = count(\App\Video::where('chapter', $chapter)->get());
                    $total_videos_no += $n;
                }

                $percentage = round($completed_videos_no/$total_videos_no * 100);
                $item = (object)[];
                $item->package_id = $package->id;
                $item->progress = $percentage;
                array_push($package_progress, $item);


            }
        }


        // $process = [];
        // $process_group = Process_group::all();
        // foreach ($process_group as $p) {
        //     array_push($process, $p->name);

        // }

        return [
            'package_list'      => $package_list,
            'package_progress'  => $package_progress
        ];
    }





    public function reloadTopics_video($package_id){


        $comments_id = \App\PageComment::where('page', '=', 'video')->where('item_id', '=', $package_id)->pluck('comment_id')->toArray();
        $comments = \App\Comment::whereIn('id', $comments_id)->orderBy('created_at', 'desc')->get();


        $topic_list = [];
        $chapters_inc = [];
        $process_inc = [];
        $exams_inc = [];

        if($this->is_package_expired($package_id)){
            return back()->with('error', 'Please, Extend the package to keep access !');
        }



        $package_data = Packages::where('id', '=',$package_id)->get()->first();

        $userpackages = UserPackages::where('package_id', '=', $package_data->id)->where('user_id','=', Auth::user()->id)->get();
        if($userpackages->first()){
            $filter = $package_data->filter;
            $exams = $package_data->exams;


            // calculate the chapters included within the package
            if($package_data->chapter_included != '' || $package_data->chapter_included != null){
                $arr_chapters_id = explode(',',$package_data->chapter_included);
                if( !empty($arr_chapters_id)){
                    foreach($arr_chapters_id as $id){
                        $ch = Chapters::where('id', '=', $id)->get()->first();
                        $item = (object)[];
                        $item->id = $ch->id;
                        $item->name = $ch->name;
                        array_push($chapters_inc, $item);
                    }
                }
            }

            if($package_data->process_group_included != '' || $package_data->process_group_included != null){
                $arr_process_id = explode(',',$package_data->process_group_included);
                if( !empty($arr_process_id != '')){
                    foreach($arr_process_id as $id){
                        $ch = Process_group::where('id', '=', $id)->get()->first();
                        $item = (object)[];
                        $item->id = $ch->id;
                        $item->name = $ch->name;
                        array_push($process_inc, $item);
                    }
                }
            }

            // // calculate the process group included ..
            // $process_group_list = Process_group::all();
            // foreach($process_group_list as $pro){
            //     if($this->reloadQuestionsNumber($package_id, 'process', $pro->id) > 0){
            //         $item = (object)[];
            //         $item->id = $pro->id;
            //         $item->name = $pro->name;

            //         $located = 0;
            //         foreach($process_inc as $p){
            //             if($p->id == $pro->id){
            //                 $located = 1;
            //             }
            //         }

            //         if( !$located ){
            //             array_push($process_inc, $item);
            //         }
            //     }
            // }

            if($exams != null){
                $exams = explode(',', $exams);
                foreach($exams as $e){
                    $item = (object)[];
                    $item->id = $e;
                    $item->name = 'Exam '.$e;
                    array_push($exams_inc, $item);
                }
            }

            if($filter == 'chapter'){
                $topic_list = [];
                if(!count($chapters_inc)){
                    $chapters_inc = null;
                }
                $topic_list['chapters'] = $chapters_inc;
                $topic_list['process'] = null;

            }else if($filter == 'process'){
                $topic_list = [];
                if(!count($process_inc)){
                    $process_inc = null;
                }
                $topic_list['process'] = $process_inc;
                $topic_list['chapters'] = null;
            }else if ($filter == 'chapter_process'){ // chapter and process group

                $topic_list = [];

                if(!count($chapters_inc)){
                    $chapters_inc = null;
                }
                $topic_list['chapters'] = $chapters_inc;
                if(!count($process_inc)){
                    $process_inc = null;
                }
                $topic_list['process'] = $process_inc;
            }

            // add the exams  if exist

            if(count($exams_inc)> 0){
                // foreach ($exams_inc as $i){
                //     array_push($topic_list, $i);
                // }
                $topic_list['exams'] = $exams_inc;
            }else{
                $topic_list['exams'] = null;
            }

            $topic_list['filter'] = $filter;
            $topic_list['package_id'] = $package_id;
            $topic_list['contant_type'] = $package_data->contant_type;


            // if($package_data->contant_type == 'combined'){
            return view('PremiumQuiz/index-st2-vid')->with('topics', $topic_list)->with('comments', $comments)->with('package', $package_data);
            // }else if ($package_data->contant_type == 'video'){
            // return view('PremiumQuiz/index-st2-vid')->with('topics', $topic_list);
            // }

            // if($package_data->contant_type == 'question' || $package_data->contant_type == 'combined'){
            //     return view('PremiumQuiz/index-st2')->with('topics', $topic_list);
            // }else{
            //     return view('PremiumQuiz/index-st2-vid')->with('topics', $topic_list);
            // }



        }else{
            // return $package_data->name.' ... '.Auth::user()->id;
            return back();
        }



    }


    public function reloadTopics($package_id){


        $topic_list = [];
        $chapters_inc = [];
        $process_inc = [];
        $exams_inc = [];

        if($this->is_package_expired($package_id)){
            return back()->with('error', 'Please, Extend the package to keep access !');
        }



        $package_data = Packages::where('id', '=',$package_id)->get()->first();

        $userpackages = UserPackages::where('package_id', '=', $package_data->id)->where('user_id','=', Auth::user()->id)->get();
        if($userpackages->first()){
            $filter = $package_data->filter;
            $exams = $package_data->exams;



            // calculate the chapters included within the package
            if($package_data->chapter_included != '' || $package_data->chapter_included != null){
                $arr_chapters_id = explode(',',$package_data->chapter_included);
                if( !empty($arr_chapters_id)){
                    foreach($arr_chapters_id as $id){
                        $ch = Chapters::where('id', '=', $id)->get()->first();
                        $item = (object)[];
                        $item->id = $ch->id;
                        $item->name = $ch->name;
                        array_push($chapters_inc, $item);
                    }
                }
            }
            // calsculate the process group included within the package
            if($package_data->process_group_included != '' || $package_data->process_group_included != null){
                $arr_process_id = explode(',',$package_data->process_group_included);
                if( !empty($arr_process_id != '')){
                    foreach($arr_process_id as $id){
                        $ch = Process_group::where('id', '=', $id)->get()->first();
                        $item = (object)[];
                        $item->id = $ch->id;
                        $item->name = $ch->name;
                        array_push($process_inc, $item);
                    }
                }
            }

            // calculate exams included within the package
            if($exams != null){
                $exams = explode(',', $exams);
                foreach($exams as $e){
                    $item = (object)[];
                    $item->id = $e;
                    $item->name = 'Exam '.$e;
                    array_push($exams_inc, $item);
                }
            }

            if($filter == 'chapter'){
                $topic_list = [];
                if(!count($chapters_inc)){
                    $chapters_inc = null;
                }
                $topic_list['chapters'] = $chapters_inc;
                $topic_list['process'] = null;

            }else if($filter == 'process'){
                $topic_list = [];
                if(!count($process_inc)){
                    $process_inc = null;
                }
                $topic_list['process'] = $process_inc;
                $topic_list['chapters'] = null;
            }else if ($filter == 'chapter_process'){ // chapter and process group

                $topic_list = [];

                if(!count($chapters_inc)){
                    $chapters_inc = null;
                }
                $topic_list['chapters'] = $chapters_inc;
                if(!count($process_inc)){
                    $process_inc = null;
                }
                $topic_list['process'] = $process_inc;
            }

            // add the exams  if exist

            if(count($exams_inc)> 0){
                // foreach ($exams_inc as $i){
                //     array_push($topic_list, $i);
                // }
                $topic_list['exams'] = $exams_inc;
            }else{
                $topic_list['exams'] = null;
            }

            $topic_list['filter'] = $filter;
            $topic_list['package_id'] = $package_id;
            $topic_list['contant_type'] = $package_data->contant_type;




            return view('PremiumQuiz/index-st2')->with('topics', $topic_list)->with('package', $package_data);




        }else{

            return back();
        }



    }


    public function attachThePackageContent($package_id){

        $locale = new Locale();
        $translationTable = Transcode::getTranslationTable();

        $chapters_inc = [];
        $exams_inc = [];
        $arr_chapters_id = [];

        if($this->is_package_expired($package_id)){
            return back()->with('error', 'Please, Extend the package to keep access !');
        }

        $package_data = DB::table('packages')
            ->join('user_packages', 'packages.id', '=', 'user_packages.package_id')
            ->where('packages.id', $package_id)
            ->where('user_packages.user_id', Auth::user()->id)
            ->first();

        if($package_data){
            $exams = $package_data->exams;

            // calculate the chapters included within the package
            if($package_data->chapter_included != '' || $package_data->chapter_included != null){
                $arr_chapters_id = explode(',',$package_data->chapter_included);
                if( !empty($arr_chapters_id)){
                    foreach($arr_chapters_id as $id){
                        $ch = Chapters::where('id', '=', $id)->get()->first();
                        $item = (object)[];
                        $item->id = $ch->id;
                        $item->name = $ch->name;
                        array_push($chapters_inc, $item);
                    }
                }
            }

            // calculate exams included within the package
            if($exams != null){
                $exams = explode(',', $exams);
                foreach($exams as $e){
                    $item = (object)[];
                    $item->id = $e;
                    $item->name = 'Exam '.$e;
                    array_push($exams_inc, $item);
                }
            }

            $firstVideo = $this->getPackageFirstVideo($package_id, $arr_chapters_id, $translationTable);

            if(count($chapters_inc)){
                foreach($chapters_inc as $i){
                    if($i->id == $firstVideo->chapter_id){
                        return \Redirect::to(
                            route('PremiumQuiz-st3', [$package_id,'chapter', $i->id, 'realtime'])
                            .'?video_id='.$firstVideo->video_id
                        );
                    }
                    $questions = \App\Question::where('chapter', $i->id)->limit(1)->first();
                    if($questions){
                        return \Redirect::to(route('PremiumQuiz-st3', [$package_id,'chapter', $i->id, 'realtime']));
                    }
                }
            }

            if(count($exams_inc)){
                $id = $exams_inc[0]->id;
                foreach($exams_inc as $i){
                    $questions = \App\Question::where(DB::raw("CONCAT(',', TRIM(BOTH '\"' FROM `exam_num`), ',')"), 'LIKE', '%,'.$id.',%')->limit(1)->first();
                    if($questions){
                        return \Redirect::to(route('PremiumQuiz-st3', [$package_id,'exam', $i->id, 'realtime']));
                    }
                }
            }

            return back();

        }else{
            return back();
        }
    }

    public function initTopic(Request $request){
        $topics_included_arr = [];
        $thisUser = Auth::user();
        if(!$thisUser){
            return $topics_included_arr;
        }
        $userPackage = $this->UserPackage($request->package_id, $thisUser->id);
        $mistakeIndex = ['chapter', 'process', 'exam'];
        $topics_included_arr = $this->CalcIncluded($userPackage, $request->topic_type == 'mistake' ? $mistakeIndex[$request->topic_id-1]: $request->topic_type);
        return $topics_included_arr;
    }


    public function getPackageFirstVideo($package_id, $arr_chapters_id, $translationTable){
        return $this->getPackageVideos($package_id, $arr_chapters_id, $translationTable, null, true);
    }

    public function getPackageVideo($package_id, $arr_chapters_id, $translationTable, $video_id){
        return $this->getPackageVideos($package_id, $arr_chapters_id, $translationTable, $video_id)->first();
    }

    public function getPackageVideos($package_id, $arr_chapters_id, $translationTable, $video_id = null, $first_video_only = false){
        $packageVideos = DB::table('videos')
            ->where(function($query) use($video_id){
                if($video_id)
                    $query->where('videos.id', $video_id);
            })
            ->whereIn('chapter', $arr_chapters_id)
            ->whereNull('videos.event_id')
            ->leftJoin(DB::raw('(SELECT * FROM video_progresses WHERE package_id='.$package_id.' AND user_id='.Auth::user()->id.' GROUP BY video_id) AS video_progresses'),
                'videos.id','=','video_progresses.video_id')
            ->join('chapters', 'videos.chapter', '=', 'chapters.id')
            ->leftJoin('materials', 'videos.attachment_url', '=', 'materials.file_url');
        if($translationTable){
            $packageVideos = $packageVideos->leftJoin(DB::raw('(SELECT * FROM '.$translationTable.' WHERE table_=\'chapters\') AS chapterTranscode'),
                'chapters.id', '=', 'chapterTranscode.row_')
                ->leftJoin(DB::raw('(SELECT * FROM '.$translationTable.' WHERE table_=\'videos\' AND column_=\'title\') AS videoTranscode'),
                    'videos.id', '=', 'videoTranscode.row_')
                ->select(
                    DB::raw('videos.id AS video_id'),
                    DB::raw('videos.chapter AS chapter_id'),
                    DB::raw('(CASE WHEN chapterTranscode.transcode IS NULL THEN chapters.name ELSE chapterTranscode.transcode END) AS chapter_name'),
                    DB::raw('(CASE WHEN videoTranscode.transcode IS NULL THEN videos.title ELSE videoTranscode.transcode END) AS title'),
//                    'videos.title',
                    'videos.chapter',
                    'videos.attachment_url',
                    DB::raw('(materials.id) AS attachment_id'),
                    'videos.duration',
                    'videos.vimeo_id',
                    DB::raw('(CASE WHEN video_progresses.complete IS NULL THEN 0 ELSE 1 END) AS watched'),
                    DB::raw('(video_progresses.updated_at) AS watched_at'),
                    'videos.index_z',
                    'wr_id',
                    'videos.description',
                    'videos.after_chapter_quiz'
                );
        }else{
            $packageVideos = $packageVideos->select(
                DB::raw('videos.id AS video_id'),
                DB::raw('videos.chapter AS chapter_id'),
                DB::raw('chapters.name AS chapter_name'),
                'videos.title',
                'videos.chapter',
                'videos.attachment_url',
                DB::raw('(materials.id) AS attachment_id'),
                'videos.duration',
                'videos.vimeo_id',
                DB::raw('(CASE WHEN video_progresses.complete IS NULL THEN 0 ELSE 1 END) AS watched'),
                DB::raw('(video_progresses.updated_at) AS watched_at'),
                'videos.index_z',
                'wr_id',
                'videos.description',
                'videos.after_chapter_quiz'
            );
        }

        if($first_video_only){
            return $packageVideos->orderBy('index_z')
                ->limit(1)
                ->first();
        }
        return $packageVideos->orderBy('index_z')
            ->get();
    }


    /**
     * @param Packages $package
     * @param string $topic [chapter, exam, process], null => all
     * @return array [
     *      {
     *          'name': 'chapter',
     *          'key': 'chapter',
     *          'content': [
     *                 { id: 2, name: 'chapter 1' },
     *           ]
     *      },
     * ]
     */

    public function CalcIncluded($package, $topic){

        $locale = new Locale();
        $translationTable = Transcode::getTranslationTable();

        $chapters_inc = [];
        $process_inc = [];
        $exams_inc = [];
        $topics_included_arr = [];

        if($topic == 'chapter'){
            // calculate the chapters included within the package
            if( ($package->chapter_included != '' || $package->chapter_included != null) ){


                $object_i = (object)[];
                $object_i->name = 'Chapter';
                $object_i->key = 'chapter';


                $arr_chapters_id = explode(',',$package->chapter_included);
                if(!empty($arr_chapters_id)){
                    $chapterQuery = DB::table('chapters')
                        ->whereIn('chapters.id', $arr_chapters_id)
                        ->leftJoin('questions', 'chapters.id', '=', 'questions.chapter');
                    if($translationTable){
                        $chapterQuery = $chapterQuery->leftJoin(DB::raw('(SELECT * FROM '.$translationTable.' WHERE table_=\'chapters\') AS chapterTranscode'),
                            'chapters.id', '=', 'chapterTranscode.row_')
                            ->select(
                                DB::raw('(COUNT(*)) AS questionsNumber'),
                                DB::raw('(SELECT COUNT(*) FROM quizzes WHERE user_id='.$package->user_id.' AND package_id='.$package->package_id.' AND topic_type=\'chapter\' AND complete=\'1\' AND topic_id=chapters.id) AS completedQuizNumber'),
                                DB::raw('(SELECT COUNT(*) FROM quizzes WHERE user_id='.$package->user_id.' AND package_id='.$package->package_id.' AND topic_type=\'chapter\' AND complete=\'0\' AND topic_id=chapters.id) AS savedQuizNumber'),
                                'chapters.*',
                                DB::raw('(CASE WHEN chapterTranscode.transcode IS NULL THEN chapters.name ELSE chapterTranscode.transcode END) AS chapter_name')
                            );
                    }else{
                        $chapterQuery = $chapterQuery->select(
                            DB::raw('(COUNT(*)) AS questionsNumber'),
                            DB::raw('(SELECT COUNT(*) FROM quizzes WHERE user_id='.$package->user_id.' AND package_id='.$package->package_id.' AND topic_type=\'chapter\' AND complete=\'1\' AND topic_id=chapters.id) AS completedQuizNumber'),
                            DB::raw('(SELECT COUNT(*) FROM quizzes WHERE user_id='.$package->user_id.' AND package_id='.$package->package_id.' AND topic_type=\'chapter\' AND complete=\'0\' AND topic_id=chapters.id) AS savedQuizNumber'),
                            'chapters.*',
                            DB::raw('(chapters.name) AS chapter_name')
                        );
                    }
                    $chapterQuery = $chapterQuery->groupBy('chapters.id')
                        ->get();


                    $kill_mistake = false;
                    $total_chapters_question_no = 0;

                    // Videos Data ..
                    $packageVideos = $this->getPackageVideos($package->package_id, $arr_chapters_id, $translationTable);

                    // Explanations Data
                    $packageExplanations = DB::table('explanations')
                        ->whereIn('chapter_id', $arr_chapters_id)
                        ->select(
                            DB::raw('explanations.title'),
                            DB::raw('explanations.id'),
                            DB::raw('explanations.chapter_id')
                        )->get();

                    $total_time = [0, 0, 0];
                    foreach($arr_chapters_id as $id){
                        $thisChapterVideos = $packageVideos->filter(function($video)use($id){
                            return $video->chapter_id == $id;
                        });
                        $ch = $chapterQuery->filter(function($row)use($id){ return $row->id == $id;})->first();
                        $thisChapterExplanations = $packageExplanations->filter(function($explanation)use($id){
                            return $explanation->chapter_id == $id;
                        });
                        if($ch){
                            $item = (object)[];
                            $item->id = $ch->id;
                            $item->key = 'chapter';
                            $item->name_en = $ch->name;
                            $item->name = $ch->chapter_name;
                            // Quiz Meta
                            $item->questions_number = $ch->questionsNumber;
                            $total_chapters_question_no += $ch->questionsNumber;
                            $item->completedQuizNumber = $ch->completedQuizNumber;
                            $item->savedQuizNumber = $ch->savedQuizNumber;
                            // Videos Meta
                            $item->total_hours = 0;
                            $item->total_min = 0;
                            $item->total_sec = 0;
                            $item->total_time_toString = '';
                            $item->videos = [];
                            $item->explanations = $thisChapterExplanations;


                            foreach($thisChapterVideos as $video){
                                if($video->duration != '' && $video->duration != null){

                                    $item->total_min += \Carbon\Carbon::parse($video->duration)->format('i');
                                    $item->total_sec += \Carbon\Carbon::parse($video->duration)->format('s');
                                    if(\Carbon\Carbon::parse($video->duration)->format('h') != 12){
                                        $item->total_hours += \Carbon\Carbon::parse($video->duration)->format('h');
                                    }
                                }

                                array_push($item->videos, $video);
                            }

                            $item->total_time_toString = \Carbon\Carbon::create(2012, 1, 1, 0, 0, 0)->addHours($item->total_hours)->addMinutes($item->total_min)->addSeconds($item->total_sec)->format('H:i:s');

                            $total_time[0] += $item->total_hours;
                            $total_time[1] += $item->total_min;
                            $total_time[2] += $item->total_sec;



                            if($ch->completedQuizNumber <= 0){
                                $kill_mistake = false;
                            }
                            array_push($chapters_inc, $item);
                        }
                    }
                    if($kill_mistake && $total_chapters_question_no > 0){
                        $item = (object)[];
                        $item->id = 1;
                        $item->key = 'mistake';
                        $item->name_en = 'Kill Mistakes';
                        $item->name = __('general.kill-mistakes');
                        $item->questions_number = 1;
                        $item->completedQuizNumber = 0;
                        $item->savedQuizNumber = \App\Quiz::where([['user_id', '=', Auth::user()->id],
                            ['package_id','=', $package->package_id],
                            ['topic_type', '=', 'Kill Mistakes'],
                            ['topic_id', '=', 1],
                            ['complete', '=', 0],])->first() ? 1: 0;

                        array_push($chapters_inc, $item);
                    }
                }
                $total_time[1] += $total_time[2]/60;
                $total_time[2] = round($total_time[2]%60);

                $total_time[0] += $total_time[1]/60;
                $total_time[1] = round($total_time[1]%60);
                $total_time[0] = round($total_time[0]);

                $object_i->content = $chapters_inc;
                $object_i->total_video_time = $total_time;

                array_push($topics_included_arr, $object_i);
            }
        }

        if($topic == 'process'){
            if( ($package->process_group_included != '' || $package->process_group_included != null) && ($package->filter == 'process' || $package->filter == 'chapter_process')){

                $object_i = (object)[];
                $object_i->name = 'Domain';
                $object_i->key = 'process';

                $arr_process_id = explode(',',$package->process_group_included);
                if( !empty($arr_process_id != '')){
                    $processQuery = DB::table('process_groups')
                        ->whereIn('process_groups.id', $arr_process_id)
                        ->join('questions', 'process_groups.id', '=', 'questions.process_group');
                    if($translationTable){
                        $processQuery = $processQuery->leftJoin(DB::raw('(SELECT * FROM '.$translationTable.' WHERE table_=\'process_groups\') AS processTranscode'),
                            'process_groups.id', '=', 'processTranscode.row_')
                            ->select(
                                DB::raw('(COUNT(*)) AS questionsNumber'),
                                DB::raw('(SELECT COUNT(*) FROM quizzes WHERE user_id='.$package->user_id.' AND package_id='.$package->package_id.' AND topic_type=\'process\' AND complete=\'1\' AND topic_id=process_groups.id) AS completedQuizNumber'),
                                DB::raw('(SELECT COUNT(*) FROM quizzes WHERE user_id='.$package->user_id.' AND package_id='.$package->package_id.' AND topic_type=\'process\' AND complete=\'0\' AND topic_id=process_groups.id) AS savedQuizNumber'),
                                'process_groups.*',
                                DB::raw('(CASE WHEN processTranscode.transcode IS NULL THEN process_groups.name ELSE processTranscode.transcode END) AS process_name')
                            );
                    }else{
                        $processQuery = $processQuery->select(
                                DB::raw('(COUNT(*)) AS questionsNumber'),
                                DB::raw('(SELECT COUNT(*) FROM quizzes WHERE user_id='.$package->user_id.' AND package_id='.$package->package_id.' AND topic_type=\'process\' AND complete=\'1\' AND topic_id=process_groups.id) AS completedQuizNumber'),
                                DB::raw('(SELECT COUNT(*) FROM quizzes WHERE user_id='.$package->user_id.' AND package_id='.$package->package_id.' AND topic_type=\'process\' AND complete=\'0\' AND topic_id=process_groups.id) AS savedQuizNumber'),
                                'process_groups.*',
                                DB::raw('(process_groups.name) AS process_name')
                            );
                    }
                    $processQuery = $processQuery->groupBy('process_groups.id')
                        ->get();
                    $kill_mistake = true;
                    foreach($arr_process_id as $id){
                        $ch = $processQuery->filter(function($row)use($id){return $row->id == $id;})->first();

                        if($ch){
                            $item = (object)[];
                            $item->id = $ch->id;
                            $item->key = 'process';
                            $item->name_en = $ch->name;
                            $item->name = $ch->process_name;
                            $item->questions_number = $ch->questionsNumber;
                            $item->question_by_part = $this->per_part;
                            $item->parts_no = (int)(ceil($ch->questionsNumber / $item->question_by_part));
                            $item->completedQuizNumber = $ch->completedQuizNumber;
                            $item->savedQuizNumber = $ch->savedQuizNumber;
                            if($ch->completedQuizNumber <= 0){
                                $kill_mistake = false;
                            }
                            array_push($process_inc, $item);
                        }


                    }
                    if($kill_mistake){
                        $item = (object)[];
                        $item->id = 2;
                        $item->key = 'mistake';
                        $item->name_en = 'Kill Mistakes';
                        $item->name = __('general.kill-mistakes');
                        $item->questions_number = 1;
                        $item->completedQuizNumber = 0;
                        $item->savedQuizNumber = \App\Quiz::where([['user_id', '=', Auth::user()->id],
                            ['package_id','=', $package->package_id],
                            ['topic_type', '=', 'mistake'],
                            ['topic_id', '=', 2],
                            ['complete', '=', 0],])->first() ? 1: 0;

                        array_push($process_inc, $item);
                    }
                }
                $object_i->content = $process_inc;
                array_push($topics_included_arr, $object_i);
            }
        }

        if($topic == 'exam'){
            if($package->exams != null){
                $object_i = (object)[];
                $object_i->name = 'Exams';
                $object_i->key = 'exam';

                $exams = explode(',', $package->exams);
                Cache::forget('lang-'.$locale->locale.'-examsData-'.$package->exams);
                $examQuery = Cache::remember('lang-'.$locale->locale.'-examsData-'.$package->exams, 1440, function()use($exams, $translationTable){
                    $data = DB::table('questions')
                        ->Where(function($q)use($exams){
                            foreach($exams as $exam){
                                $q->orWhere(DB::raw("CONCAT(',', TRIM(BOTH '\"' FROM `exam_num`), ',')"), 'LIKE', '%,'.$exam.',%');
                            }
                        })
                        ->distinct()
                        ->crossJoin('exams');
                    if($translationTable){
                        $data = $data->leftJoin(DB::raw('(SELECT * FROM '.$translationTable.' WHERE table_=\'exams\') AS examTranscode'),
                            'exams.id', '=', 'examTranscode.row_')
                            ->select(
                                DB::raw('(SUM(CASE WHEN CONCAT(\',\' , TRIM(BOTH \'"\' FROM `exam_num`), \',\') LIKE concat(\'%,\', exams.id, \',%\')  THEN 1 ELSE 0 END)) AS questionsNumber'),
                                'exams.*',
                                DB::raw('(CASE WHEN examTranscode.transcode IS NULL THEN exams.name ELSE examTranscode.transcode END) AS exam_name')
                            );
                    }else{
                        $data = $data->select(
                            DB::raw('(SUM(CASE WHEN CONCAT(\',\' , TRIM(BOTH \'"\' FROM `exam_num`), \',\') LIKE concat(\'%,\', exams.id, \',%\')  THEN 1 ELSE 0 END)) AS questionsNumber'),
                            'exams.*',
                            DB::raw('(exams.name) AS exam_name')
                        );
                    }
                    return $data->groupBy('exams.id')->get();
                });

                $QuizNumber = DB::table('exams')
                    ->whereIn('exams.id', $exams)
                    ->select(
                        DB::raw('(SELECT COUNT(*) FROM quizzes WHERE user_id='.$package->user_id.' AND package_id='.$package->package_id.' AND topic_type=\'exam\' AND complete=\'1\' AND topic_id=exams.id) AS completedQuizNumber'),
                        DB::raw('(SELECT COUNT(*) FROM quizzes WHERE user_id='.$package->user_id.' AND package_id='.$package->package_id.' AND topic_type=\'exam\' AND complete=\'0\' AND topic_id=exams.id) AS savedQuizNumber'),
                        'exams.id'
                    )
                    ->groupBy('exams.id')
                    ->get();

                $kill_mistake = true;
                foreach($exams as $e){
                    $ex = $examQuery->filter(function($row)use($e){return $row->id == $e;})->first();
                    $numbers = $QuizNumber->filter(function($row)use($e){return $row->id == $e;})->first();
                    if($ex){
                        $item = (object)[];
                        $item->id = $ex->id;
                        $item->key = 'exam';
                        $item->name_en = $ex->name;
                        $item->name = $ex->exam_name;
                        $item->questions_number = $ex->questionsNumber;
                        $item->completedQuizNumber = $numbers->completedQuizNumber;
                        $item->savedQuizNumber = $numbers->savedQuizNumber;
                        if($numbers->completedQuizNumber <= 0){
                            $kill_mistake = false;
                        }
                        array_push($exams_inc, $item);
                    }

                }
                if($kill_mistake){
                    $item = (object)[];
                    $item->id = 3;
                    $item->key = 'mistake';
                    $item->name_en = 'Kill Mistakes';
                    $item->name = __('general.kill-mistakes');
                    $item->questions_number = 1;
                    $item->completedQuizNumber = 0;
                    $item->savedQuizNumber = \App\Quiz::where([['user_id', '=', Auth::user()->id],
                        ['package_id','=', $package->package_id],
                        ['topic_type', '=', 'mistake'],
                        ['topic_id', '=', 3],
                        ['complete', '=', 0],])->first() ? 1: 0;

                    array_push($exams_inc, $item);
                }
                $object_i->content = $exams_inc;
                array_push($topics_included_arr, $object_i);
            }
        }
        return $topics_included_arr;
    }

    /** Divide into parts and return given part_id */
    public function DivideIntoParts($questions, $per_part, $part_id){

        $questions_array = [];
        foreach($questions as $q){
            array_push($questions_array, $q);
        }
        $parts_no = (int)(ceil(count($questions_array)/$per_part));
        if( ($part_id <= $parts_no) && ($part_id >= 1) ){
            $start = ($part_id -1)*$per_part;
            $questions_array = array_slice( $questions_array , $start , $per_part );
        }
        return $questions_array;
    }

    public function userPackages($user_id){
        return $this->UserPackage(null, $user_id);
    }

    public function UserPackage($package_id, $user_id){
        if($package_id) $ratingQuery = DB::raw('(SELECT * FROM ratings WHERE user_id='.$user_id.' AND package_id='.$package_id.' LIMIT 1) AS ratings');
        else $ratingQuery = DB::raw('(SELECT * FROM ratings WHERE user_id='.$user_id.') AS ratings');

        $results = (DB::table('user_packages')
            ->where('user_packages.user_id', '=', $user_id)
            ->where(function($query)use($package_id){
                if($package_id){
                    $query->where('user_packages.package_id', '=', $package_id);
                }
            })
            ->join('packages', 'user_packages.package_id', '=', 'packages.id')
            ->leftJoin($ratingQuery,
                'user_packages.package_id', '=', 'ratings.package_id')
            ->leftJoin('certifications', function($join){
                $join->on('user_packages.user_id', '=', 'certifications.user_id');
                $join->on('user_packages.package_id', '=', 'certifications.package_id');
            })
            ->select(
                DB::raw('certifications.id AS certification_id'),
                DB::raw('(CASE WHEN ratings.id IS NULL THEN 0 ELSE 1 END) AS userRatePackage'),
                DB::raw('ratings.rate AS thisUserRate'),
                DB::raw('ratings.review AS thisUserRateReview'),
                DB::raw('user_packages.created_at AS havePackageSince'),
                'user_packages.package_id',
                'user_packages.user_id',
                'packages.name',
                'packages.chapter_included',
                'packages.process_group_included',
                'packages.exams',
                'packages.expire_in_days',
                'packages.filter',
                'packages.description',
                'packages.what_you_learn',
                'packages.requirement',
                'packages.who_course_for',
                'packages.certification',
                'packages.total_time',
                'packages.updated_at',
                'packages.lang',
                'packages.img'
            )
            ->groupBy('user_packages.id')
            ->get());
        if($package_id) return $results->first();
        else return $results;
    }


    public function reloadQuestionsNumber($package_id_, $topic, $topic_id, $quiz_id){
        // Auth::user()->id != 3 &&
        // if(Auth::user()->id != 5){
        //     return \Redirect::to(route('user.dashboard'))->with('success', 'Under Maintenance !');
        // }

        $package_id = intval($package_id_);
        $locale = new Locale();
        $translationTable = Transcode::getTranslationTable();

        if(Auth::check()){
            $thisUser = Auth::user();
        }else{
            if($package_id != 'question'){
                return \Redirect::to(route('login'));
            }
        }

        $process_list = Cache::remember('processGroupPluckName', 1440, function(){
            return Process_group::pluck('name');
        });
        /**
         * Special Case
         */

        /**
         * GET Topic Comments
         */
        $comments = DB::table('page_comments')
            ->where('page', '=', $topic)
            ->where('item_id', '=', $topic_id)
            ->join('comments', 'page_comments.comment_id', '=', 'comments.id')
            ->join('users', 'comments.user_id', '=', 'users.id')
            ->join('user_details', 'users.id', '=', 'user_details.user_id')
            ->leftJoin('replies', 'page_comments.comment_id', '=', 'replies.reply_to_id')
            ->select(

                'comments.user_id',
                'users.name',
                'user_details.profile_pic',
                DB::raw('comments.id AS comment_id'),
                DB::raw('comments.contant AS comment'),
                'comments.created_at',
                DB::raw('replies.id AS reply_id'),
                DB::raw('(SELECT users.name FROM users WHERE users.id = (SELECT comments.user_id FROM comments WHERE comments.id = replies.comment_id LIMIT 1)) AS reply_name'),
                DB::raw('(SELECT user_details.profile_pic FROM user_details WHERE user_details.user_id = (SELECT comments.user_id FROM comments WHERE comments.id = replies.comment_id LIMIT 1)) AS reply_profile_pic'),
                DB::raw('(SELECT comments.contant FROM comments WHERE comments.id = replies.comment_id LIMIT 1) AS reply_comment'),
                DB::raw('(SELECT comments.created_at FROM comments WHERE comments.id = replies.comment_id LIMIT 1) AS reply_created_at')
            )
            ->orderBy('created_at', 'asc')
            ->get()->groupBy('comment_id');


        /**
         * General Case
         * New Optimization
         */
        $userPackage = $this->UserPackage($package_id, $thisUser->id);

        if(!$userPackage){
            return \Redirect::to(route('user.dashboard'))->with('error', 'Something went wrong.');
        }

        if($this->is_package_expiredV3($package_id, $userPackage->havePackageSince, $userPackage->expire_in_days)){
            return back()->with('error', 'Please, Extend the package to keep access !!');
        }

        $mistakeIndex = ['chapter', 'process', 'exam'];

        $chapters_inc = [];
        $process_inc = [];
        $exams_inc = [];
        $topics_included_arr = $this->CalcIncluded($userPackage, $topic == 'mistake' ? $mistakeIndex[$topic_id-1]: $topic);
//
//        foreach($topics_included_arr as $tt){
//            if($tt->key == 'chapter'){
//                $chapters_inc = $tt->content;
//            }
//            if($tt->key == 'process'){
//                $process_inc = $tt->content;
//            }
//            if($tt->key == 'exam'){
//                $exams_inc = $tt->content;
//            }
//        }

        $part_id = \request()->part_id? \request()->part_id: null;
        if($quiz_id == 'realtime'){
            $quiz = DB::table('quizzes')
                ->where('user_id', $thisUser->id)
                ->where('package_id', $package_id)
                ->where('topic_type', $topic)
                ->where('topic_id', $topic_id)
                ->where('part_id', $part_id)
                ->where('complete', 0)
                ->first();
        }else{
            $quiz = DB::table('quizzes')->where('id', $quiz_id)->first();
        }


        $quiz_history = DB::table('quizzes')
            ->where('user_id', $thisUser->id)
            ->where('package_id', $package_id)
            ->where('topic_type', $topic)
            ->where('topic_id', $topic_id)
            ->where('part_id', $part_id)
            ->where('complete', 1)
            ->orderBy('created_at', 'desc')
            ->get();

        $quiz_history_arr = [];

        if($quiz_history){
            foreach($quiz_history as $history){
                $i = (object)[];
                $i->quiz = $history;
                $i->hours = 0;
                $i->mins = 0;
                $i->sec = 0;
                if($history->time_left != 0) {
                    $i->hours = floor($history->time_left / 3600);
                    $i->mins = floor(($history->time_left % 3600) / 60);
                    $i->sec = floor(($history->time_left % 3600) % 60);
                }
                array_push($quiz_history_arr, $i);
            }
        }

        if($topic == 'mistake'){

            $questions_count0 =  DB::table('quizzes')
                ->where('user_id', $thisUser->id)
                ->where('package_id', $userPackage->package_id)
                ->where(function($q)use($topic_id){
                    if($topic_id == 1){
                        $q->where('topic_type', 'chapter');
                    }elseif($topic_id == 2){
                        $q->where('topic_type', 'process');
                    }elseif($topic_id == 3){
                        $q->where('topic_type', 'exam');
                    }
                })
                ->where('complete', 1)
                ->leftJoin('wrong_answers', 'quizzes.id', '=', 'wrong_answers.quiz_id')
                ->join('questions', function($join){
                    $join->on('wrong_answers.question_id', '=', 'questions.id');
                })
                ->select('questions.id');

            $questions_count1 =  DB::table('quizzes')
                ->where('user_id', $thisUser->id)
                ->where('package_id', $userPackage->package_id)
                ->where(function($q)use($topic_id){
                    if($topic_id == 1){
                        $q->where('topic_type', 'chapter');
                    }elseif($topic_id == 2){
                        $q->where('topic_type', 'process');
                    }elseif($topic_id == 3){
                        $q->where('topic_type', 'exam');
                    }
                })
                ->where('complete', 1)
//                ->leftJoin('wrong_answers', 'quizzes.id', '=', 'wrong_answers.quiz_id')
                ->leftJoin('wrong_drag_right_answers', 'quizzes.id', '=', 'wrong_drag_right_answers.quiz_id')
                ->join('questions', function($join){
//                    $join->on('wrong_answers.question_id', '=', 'questions.id');
                    $join->on('wrong_drag_right_answers.question_id', '=', 'questions.id');
                })
                ->select('questions.id');

            $questions_count =  DB::table('quizzes')
                ->where('user_id', $thisUser->id)
                ->where('package_id', $userPackage->package_id)
                ->where(function($q)use($topic_id){
                    if($topic_id == 1){
                        $q->where('topic_type', 'chapter');
                    }elseif($topic_id == 2){
                        $q->where('topic_type', 'process');
                    }elseif($topic_id == 3){
                        $q->where('topic_type', 'exam');
                    }
                })
                ->where('complete', 1)
//                ->leftJoin('wrong_answers', 'quizzes.id', '=', 'wrong_answers.quiz_id')
//                ->leftJoin('wrong_drag_right_answers', 'quizzes.id', '=', 'wrong_drag_right_answers.quiz_id')
                ->leftJoin('wrong_drag_center_answers', 'quizzes.id', '=', 'wrong_drag_center_answers.quiz_id')
                ->join('questions', function($join){
//                    $join->on('wrong_answers.question_id', '=', 'questions.id');
//                    $join->on('wrong_drag_right_answers.question_id', '=', 'questions.id');
                    $join->on('wrong_drag_center_answers.question_id', '=', 'questions.id');
                })
                ->select('questions.id')
                ->union($questions_count0)
                ->union($questions_count1)
                ->groupBy('questions.id')
                ->get()->count();

            return view('PremiumQuiz.index-st3')
                ->with('examTimeMin', 0)
                ->with('process', $process_list)
                ->with('questionNum',$questions_count)
                ->with('package_id', $package_id)
                ->with('topic', $topic)
                ->with('topic_id', $topic_id)
                ->with('package_name', $userPackage->name)
                ->with('quiz', $quiz)
                ->with('chapters_inc' , json_encode($chapters_inc))
                ->with('process_inc', json_encode($process_inc))
                ->with('exams_inc' , json_encode($exams_inc))
                ->with('ignore', 0)
                ->with('comments', $comments)
                ->with('topics_included_arr', json_encode($topics_included_arr))
                ->with('package', $userPackage)
                ->with('quiz_history_arr', $quiz_history_arr);
        }
        /**
         * Verify package included this topic
         */

        $topicsScoop = array_filter($topics_included_arr, function($i)use($topic){
            return $i->key == $topic;
        });
        $topicsScoop = array_reverse($topicsScoop);
        $topicsScoop = array_pop($topicsScoop);

        if($topicsScoop){
            $currentTopic = array_filter($topicsScoop->content, function($i)use($topic_id){
                return $i->id == $topic_id;
            });
            /** @var get first Item  $currentTopic */
            $currentTopic = array_reverse($currentTopic);
            $currentTopic = array_pop($currentTopic);

            if(!$currentTopic){
                return \Redirect::to(route('user.dashboard'))->with('error', 'Something went wrong.');
            }
            if($currentTopic->questions_number <= 0){
                return \Redirect::to(route('user.dashboard'))->with('error', 'Something went wrong.');
            }
            $questionNo = $currentTopic->questions_number;
        }else{
            return \Redirect::to(route('user.dashboard'))->with('error', 'Something went wrong.');
        }

        $video = null;
        if(request()->video_id){

            $video_id = request()->video_id;
            $chapters_inc_list = explode(',', $userPackage->chapter_included);
            $videos = $this->getPackageVideos($package_id, $chapters_inc_list, $translationTable);
            
            if($videos->count() <= 0){
                return \redirect(route('user.dashboard'))->with('error', 'Something went wrong !');
            }
            $video = $videos->filter(function($row)use($video_id){
                return $row->video_id == $video_id;
            })->first();
            if(!$video){
                return \redirect(route('user.dashboard'))->with('error', 'Something went wrong !');
            }
            $video->html = (app('App\Http\Controllers\VideoController')->Vimeo_GetVideo($video->vimeo_id))->embed->html;
            $this->VideoComplete($package_id, request()->video_id);
            
            $chapter_id = $video->chapter_id;

            $next_video = $videos->filter(function($row)use($video){
                return $row->chapter_id == $video->chapter_id && $row->index_z > $video->index_z;
            })->first();
    
            if(!$next_video){
                // check if their is a chapter next !
                // $chapters_inc
    
                // $key = in_array($chapter_id, $chapters_inc_list);
                $key = $this->findItem($chapter_id, $chapters_inc_list);
    
                if( ($key + 1) == count($chapters_inc_list) || $key == -1){
                    $next_video = null;
                }else{
                    $chapter_id = $chapters_inc_list[$key+1];
    
                    $next_video = $videos->filter(function($row)use($chapter_id){
                        return $row->chapter_id == $chapter_id;
                    })->first();
                }
    
            }
            
            
        }

        $explanation = null;
        if(request()->explanation_id){
            $explanation = DB::table('explanations')->where('id', \request()->explanation_id)->first();
            if(!$explanation){
                return \redirect(route('user.dashboard'))->with('error','Something Went Wrong !');
            }

        }


        // handle exams case
        if($topic == 'exam'){
            $examModel = \App\Exam::find($topic_id);

            /**
             * *****************
             * *****************
             * *****************
             */
            return view('PremiumQuiz.index-st3')
                ->with('explanation', $explanation)
                ->with('video', $video)
                ->with('process', $process_list)
                ->with('questionNum',$currentTopic->questions_number)
                ->with('package_id', $package_id)
                ->with('topic', $topic)
                ->with('topic_id', $topic_id)
                ->with('package_name', $userPackage->name)
                ->with('quiz', $quiz)
                ->with('chapters_inc' , json_encode($chapters_inc))
                ->with('process_inc', json_encode($process_inc))
                ->with('exams_inc' , json_encode($exams_inc))
                ->with('ignore', 0)
                ->with('comments', $comments)
                ->with('topics_included_arr', json_encode($topics_included_arr))
                ->with('package', $userPackage)
                ->with('currentTopic', $currentTopic)
                ->with('quiz_history_arr', $quiz_history_arr)
                ->with('examTimeMin', $examModel->duration? $examModel->duration: 0)
                ->with('next_video', isset($next_video) ? $next_video: null);
        }

        // handle chapter and process group selection ..
        return view('PremiumQuiz.index-st3')
            ->with('explanation', $explanation)
            ->with('video', $video)
            ->with('process', $process_list)
            ->with('questionNum', $questionNo)
            ->with('package_id', $package_id)
            ->with('topic', $topic)
            ->with('topic_id', $topic_id)
            ->with('package_name', $userPackage->name)
            ->with('quiz', $quiz)
            ->with('chapters_inc' , json_encode($chapters_inc))
            ->with('process_inc', json_encode($process_inc))
            ->with('exams_inc' , json_encode($exams_inc))
            ->with('ignore', 0)
            ->with('comments', $comments)
            ->with('topics_included_arr', json_encode($topics_included_arr))
            ->with('package', $userPackage)
            ->with('currentTopic', $currentTopic)
            ->with('quiz_history_arr', $quiz_history_arr)
            ->with('examTimeMin', 0)
            ->with('next_video', isset($next_video) ? $next_video: null);

    }

    public function generatePackageContent(Request $req){
        $thisUser = Auth::user();
        if(!$thisUser){
            return [];
        }
        $userPackage = $this->UserPackage($req->package_id, $thisUser->id);
        $topics_included_arr = $this->CalcIncluded($userPackage, $req->topic);
        foreach($topics_included_arr as $tt){
            if($tt->key == $req->topic){
                return response($tt->content, 200);
            }
        }
        return [];
    }


    public function generateCX(Request $request){

        /**
        Data = {
        topic: topic, => [chapter, exam, process]
        items_arr: items_arr, [ids, ..]
        package: this.package_id,
        };
         */
        $thisUser = Auth::user();


        $userPackage = DB::table('user_packages')
            ->where('user_packages.user_id', '=', $thisUser->id)
            ->where('user_packages.package_id', '=', $request->package)
            ->join('packages', 'user_packages.package_id', '=', 'packages.id')
            ->select(
                DB::raw('user_packages.created_at AS havePackageSince'),
                'user_packages.package_id',
                'user_packages.user_id',
                'packages.chapter_included',
                'packages.process_group_included',
                'packages.exams',
                'packages.expire_in_days'
            )->limit(1)
            ->groupBy('user_packages.id')
            ->get()->first();
        /**
         * Confidentiality: package not expired
         */
        if($this->is_package_expiredV3($userPackage->package_id, $userPackage->havePackageSince, $userPackage->expire_in_days)){
            return '500';
        }

        $questions_array = [];

        $questions = [];
        /**
         * Exams,,
         */
        if($request->topic == 'exam'){
            // exams ..
            $questions = DB::table('questions')
                ->where(function($q)use($request){
                    if(count($request->items_arr) && is_iterable($request->items_arr)){
                        foreach($request->items_arr as $id){
                            // $q->orWhere('exam_num', 'LIKE', '%'.$id.'%');
                            $q->orWhere(DB::raw("CONCAT(',', TRIM(BOTH '\"' FROM `exam_num`), ',')"), 'LIKE', '%,'.$id.',%');
                        }
                    }
                })
                ->select('questions.id')
                ->get()
                ->pluck(['id']);
        }

        if($request->topic == 'chapter'){

            $questions = DB::table('questions')
                ->where(function($q)use($request){
                    if(count($request->items_arr) && is_iterable($request->items_arr)){
                        foreach($request->items_arr as $id){
                            $q->orWhere('chapter', '=', $id);
                        }    
                    }
                    
                })
                ->select('questions.id')
                ->get()
                ->pluck(['id']);
        }

        if($request->topic == 'process'){

            $questions = DB::table('questions')
                ->where(function($q)use($request){
                    if(count($request->items_arr) && is_iterable($request->items_arr)){
                        foreach($request->items_arr as $id){
                            $q->orWhere('process_group', '=', $id);
                        }
                    }
                })
                ->select('questions.id')
                ->get()
                ->pluck(['id']);
        }

        $questions = $this->batchQuestionLoader($questions)->toArray();

        if($questions){
            return [
                'questions'                 => $questions,
                'time_left'                 => 0,  //
                'answers_number'            => 0, // answers_number
                'start'                     => 1, // start part
                'activeAnswers'             => null,
                'activeDragRightAnswers'    => null,
                'activeDragCenterAnswers'   => null,
            ];
        }else{
            // no question attached to this exam !
            return '404';
        }

    }


    /**
     * @param Request $request
     * Data = {
     *       topic: this.topic_type,
     *       topic_id: this.topic_id,
     *       package: this.package_id
     *   };
     * @return array|int|string
     */
    public function generate(Request $request){
        DB::enableQueryLog();
        $thisUser = Auth::user();
        if(!$thisUser){
            return [];
        }
        $questions_array = [];
        /**
         * single Question review .. It's Not Included In this Version !
         */
        if($request->package == 'question'){
            $question = DB::table('questions')
                ->where('id', '=', $request->topic_id)
                ->leftJoin('chapters', 'questions.chapter', '=', 'chapters.id')
                ->leftJoin('process_groups', 'questions.process_group', '=' ,'process_groups.id')
                ->select(
                    'questions.*',
                    DB::raw('(chapters.name) AS chapter_name'),
                    DB::raw('(process_groups.name) AS process_group_name')
                )
                ->first();
            if($question){
                array_push($questions_array, $this->respose($question, null, null));
            }
            return [$questions_array];
        }

        /**
         * GET Package FUll Data
         * Confidentiality: user have the package
         */
        $userPackage = DB::table('user_packages')
            ->where('user_packages.user_id', '=', $thisUser->id)
            ->where('user_packages.package_id', '=', $request->package)
            ->join('packages', 'user_packages.package_id', '=', 'packages.id')
            ->leftJoin(DB::raw('(SELECT * FROM ratings WHERE user_id='.$thisUser->id.' AND package_id='.$request->package.' LIMIT 1) AS ratings'),
                'user_packages.package_id', '=', 'ratings.package_id')
            ->select(
                DB::raw('(CASE WHEN ratings.id IS NULL THEN 0 ELSE 1 END) AS userRatePackage'),
                DB::raw('ratings.rate AS thisUserRate'),
                DB::raw('ratings.review AS thisUserRateReview'),
                DB::raw('user_packages.created_at AS havePackageSince'),
                'user_packages.package_id',
                'user_packages.user_id',
                'packages.chapter_included',
                'packages.process_group_included',
                'packages.exams',
                'packages.expire_in_days'
            )->limit(1)
            ->groupBy('user_packages.id')
            ->get()->first();
        /**
         * Confidentiality: package not expired
         */
        if($this->is_package_expiredV3($userPackage->package_id, $userPackage->havePackageSince, $userPackage->expire_in_days)){
            return '500';
        }

        $activeAnswers = null;
        $activeDragRightAnswers = null;
        $activeDragCenterAnswers = null;
        $part_id = request()->part_id ? request()->part_id: null;

        $quiz = DB::table('quizzes')
            ->where('user_id', '=', $thisUser->id)
            ->where('package_id', '=', $userPackage->package_id)
            ->where('topic_type', '=', $request->topic)
            ->where('topic_id', '=', $request->topic_id)
            ->where('part_id', '=', $part_id)
            ->where('complete', '=', 0)
            ->first();
        if($quiz){
            /**
             * Get Answers History From
             */
            $activeAnswers = DB::table('active_answers')
                ->where('quiz_id', $quiz->id)
                ->get()
                ->groupBy('question_id');

            $activeDragRightAnswers = DB::table('active_drag_right_answers')
                ->where('quiz_id', $quiz->id)
                ->get()
                ->groupBy('question_id');

            $activeDragCenterAnswers = DB::table('active_drag_center_answers')
                ->where('quiz_id', $quiz->id)
                ->get()
                ->groupBy('question_id');
        }

        /** You Need to Account For other Tables */
        if($quiz){
            $time_left = (int)($quiz->time_left);
            $answers_number = $quiz->answered_question_number;
        }else{
            $time_left = 0;
            $answers_number = 0;
        }


        /**
         * Exam Case
         */
        if($request->input('topic') == 'exam'){

            $exam_num = $request->input('topic_id');
            // check if included in package ..
            $all_exams = $userPackage->exams;
            $all_exams = explode(',', $all_exams);
            if(!in_array($exam_num, $all_exams)){
                return '500';
            }

            $questions =  DB::table('questions')
                ->where(DB::raw("CONCAT(',', TRIM(BOTH '\"' FROM `exam_num`), ',')"), 'LIKE', '%,'.$exam_num.',%')
                ->select('questions.id')
                ->get()
                ->pluck(['id']);
            $questions = $this->batchQuestionLoader($questions)->toArray();
            $examModel = \App\Exam::find($exam_num);


            if($questions){
                $x = $this->reArrange($questions);
                if($quiz){
                    $start_ = $quiz->start_part;
                }else{
                    $start_ = rand(1, $x[1]);
                }

                return [
                    'questions'                 => $this->startFromPart($x[0], $x[1], $start_), // questions
                    'time_left'                 => $time_left,  //
                    'answers_number'            => $answers_number, // answers_number
                    'start'                     => $start_, // start part
                    'activeAnswers'             => $activeAnswers ? $activeAnswers: null,
                    'activeDragRightAnswers'    => $activeDragRightAnswers ? $activeDragRightAnswers: null,
                    'activeDragCenterAnswers'   => $activeDragCenterAnswers ? $activeDragCenterAnswers: null,
                    'examTimeMin'               => $examModel->duration ? $examModel->duration: 0,
                ];
            }else{
                // no question attached to this exam !
                return '404';
            }
        }else{
            // search for it in chapter table

            if($request->input('topic') == 'chapter'){

                if(!in_array($request->topic_id, explode(',', $userPackage->chapter_included))){
                    return 500;
                }

                $questions =  DB::table('questions')
                    ->where('chapter', '=', $request->topic_id)
                    ->select('questions.id')
                    ->get()
                    ->pluck(['id']);
                $questions = $this->batchQuestionLoader($questions)->toArray();

                if(!$questions){
                    return '404';
                }

                $x = $this->reArrange($questions);
                if($quiz){
                    $start_ = $quiz->start_part;
                }else{
                    $start_ = rand(1, $x[1]);
                }

                $data = [
                    'questions'                 => $this->startFromPart($x[0], $x[1], $start_), // questions
                    'time_left'                 => $time_left,  //
                    'answers_number'            => $answers_number, // answers_number
                    'start'                     => $start_, // start part
                    'activeAnswers'             => $activeAnswers ? $activeAnswers: null,
                    'activeDragRightAnswers'    => $activeDragRightAnswers ? $activeDragRightAnswers: null,
                    'activeDragCenterAnswers'   => $activeDragCenterAnswers ? $activeDragCenterAnswers: null,
                    'examTimeMin'               => 0,
                ];
                return $data; /**   ###########################  select chapter */



            }elseif ($request->input('topic') == 'process') {

                // search in process group table ..

                if(!in_array($request->topic_id, explode(',', $userPackage->process_group_included))){
                    return 500;
                }

                $questions =  DB::table('questions')
                    ->where('process_group', '=', $request->topic_id)
                    ->select('questions.id')
                    ->get()
                    ->pluck(['id']);

                $questions = $this->DivideIntoParts($questions, $this->per_part, $part_id);
                // return $questions;
                $questions = $this->batchQuestionLoader($questions)->toArray();

                if(!$questions){
                    return '404';
                }

                $x = $this->reArrange($questions);
                if($quiz){
                    $start_ = $quiz->start_part;
                }else{
                    $start_ = rand(1, $x[1]);
                }

                $data = [
                    'questions'                 => $this->startFromPart($x[0], $x[1], $start_), // questions
                    'time_left'                 => $time_left,  //
                    'answers_number'            => $answers_number, // answers_number
                    'start'                     => $start_, // start part
                    'activeAnswers'             => $activeAnswers ? $activeAnswers: null,
                    'activeDragRightAnswers'    => $activeDragRightAnswers ? $activeDragRightAnswers: null,
                    'activeDragCenterAnswers'   => $activeDragCenterAnswers ? $activeDragCenterAnswers: null,
                    'examTimeMin'               => 0,
                ];
                return $data;
                /**   ###########################  select process */

            }else if($request->topic == 'mistake'){

                $questions0 =  DB::table('quizzes')
                    ->where('user_id', $thisUser->id)
                    ->where('package_id', $userPackage->package_id)
                    ->where(function($q)use($request){
                        if($request->topic_id == 1){
                            $q->where('topic_type', 'chapter');
                        }elseif($request->topic_id == 2){
                            $q->where('topic_type', 'process');
                        }elseif($request->topic_id == 3){
                            $q->where('topic_type', 'exam');
                        }
                    })
                    ->where('complete', 1)
                    ->leftJoin('wrong_answers', 'quizzes.id', '=', 'wrong_answers.quiz_id')
                    ->join('questions', function($join){
                        $join->on('wrong_answers.question_id', '=', 'questions.id');
                    })
                    ->select('questions.id');

                $questions1 =  DB::table('quizzes')
                    ->where('user_id', $thisUser->id)
                    ->where('package_id', $userPackage->package_id)
                    ->where(function($q)use($request){
                        if($request->topic_id == 1){
                            $q->where('topic_type', 'chapter');
                        }elseif($request->topic_id == 2){
                            $q->where('topic_type', 'process');
                        }elseif($request->topic_id == 3){
                            $q->where('topic_type', 'exam');
                        }
                    })
                    ->where('complete', 1)
                    ->leftJoin('wrong_drag_right_answers', 'quizzes.id', '=', 'wrong_drag_right_answers.quiz_id')
                    ->join('questions', function($join){
                        $join->on('wrong_drag_right_answers.question_id', '=', 'questions.id');
                    })
                    ->select('questions.id');

                $questions =  DB::table('quizzes')
                    ->where('user_id', $thisUser->id)
                    ->where('package_id', $userPackage->package_id)
                    ->where(function($q)use($request){
                        if($request->topic_id == 1){
                            $q->where('topic_type', 'chapter');
                        }elseif($request->topic_id == 2){
                            $q->where('topic_type', 'process');
                        }elseif($request->topic_id == 3){
                            $q->where('topic_type', 'exam');
                        }
                    })
                    ->where('complete', 1)
                    ->leftJoin('wrong_drag_center_answers', 'quizzes.id', '=', 'wrong_drag_center_answers.quiz_id')
                    ->join('questions', function($join){
                        $join->on('wrong_drag_center_answers.question_id', '=', 'questions.id');
                    })
                    ->select('questions.id')
                    ->union($questions0)
                    ->union($questions1)
                    ->groupBy('questions.id')
                    ->get()
                    ->pluck(['id']);
                $questions = $this->batchQuestionLoader($questions)->toArray();

                if(!$questions){
                    return '404';
                }

                $x = $this->reArrange($questions);
                if($quiz){
                    $start_ = $quiz->start_part;
                }else{
                    $start_ = rand(1, $x[1]);
                }

                $data = [
                    'questions'                 => $this->startFromPart($x[0], $x[1], $start_), // questions
                    'time_left'                 => $time_left,  //
                    'answers_number'            => $answers_number, // answers_number
                    'start'                     => $start_, // start part
                    'activeAnswers'             => $activeAnswers ? $activeAnswers: null,
                    'activeDragRightAnswers'    => $activeDragRightAnswers ? $activeDragRightAnswers: null,
                    'activeDragCenterAnswers'   => $activeDragCenterAnswers ? $activeDragCenterAnswers: null,
                    'examTimeMin'               => 0,
                ];
                return $data;

            }else{
                return '500';
            }
        }
        return [];

    }


    public function reArrange($questions_array){

        // dived it into 20 for each part
        $into = 20;
        $parts_no = ceil(count($questions_array)/$into);

        $QuestionsByPart = [];
        for($i=1; $i<= $parts_no; $i++){
            array_push($QuestionsByPart, array_slice($questions_array, ($i-1)*$into , $into ));
        }

        return [$QuestionsByPart, $parts_no];

    }

    public function startFromPart($QuestionsByPart, $parts_no, $part_no){



        if( ($part_no <= $parts_no) && ($part_no >= 1) ){

            $index = $part_no - 1;

            $q_array =[
                $QuestionsByPart[$index],
            ];

            array_splice($QuestionsByPart, $index, 1);



            foreach($QuestionsByPart as $q){
                array_push($q_array, $q);
            }
            $final_out_ = [];

            foreach($q_array as $x){
                foreach($x as $y){
                    array_push($final_out_, $y);
                }
            }
            return $final_out_;

        }




        return $this->startFromPart($QuestionsByPart, $parts_no , 1);

    }


    public function respose($q, $quiz /**  last parameter is for selecting user saved answer */, $answers_all){
        $question = [];
        $question['id'] = $q->id;
        $question['title'] = [
            'en' => $q->title,
            'ar' => $q->transcodes['title']
        ];


        $question['answers']['a'] = [
            'en' => $q->a,
            'ar' => $q->transcodes['a']
        ];
        $question['answers']['b'] = [
            'en' => $q->b,
            'ar' => $q->transcodes['b']
        ];
        $question['answers']['c'] = [
            'en' => $q->c,
            'ar' => $q->transcodes['c']
        ];
        $question['answers']['d'] = [
            'en' => $q->correct_answer,
            'ar' => $q->transcodes['correct_answer']
        ];
        shuffle($question['answers']);
        $question['correct_answer'] = $q->correct_answer;
        $question['feedback'] = [
            'en' => $q->feedback,
            'ar' => $q->transcodes['feedback']
        ];

        $question['chapter'] = $q->chapter_name;

        if($q->process_group_name){
            $question['process_group'] = $q->process_group_name;
        }else{
            $question['process_group'] = rand(1,10000000);
        }

        $question['img'] = 'null';
        if($q->img){
            $question['img'] = basename($q->img);
        }

        if($answers_all){
            $answer = $answers_all->first(function($item) use($q){
                return $item->question_id == $q->id;
            });
            if($answer){
                $question['user_saved_answer'] = $answer->user_answer;
                $question['flaged'] = $answer->flaged;
            }else{
                $question['flaged'] = false;
                $question['user_saved_answer'] = '';
            }

        }else{
            $question['user_saved_answer'] = '';
        }

        return $question;
    }

    public function is_exist($arr, $title){
        foreach($arr as $a){
            if($a['title'] == $title){
                return 1;
            }
        }
        return 0;
    }


    public function scoreStore(Request $request){
        /**
         * Delete the row s when user click rest after package is expired.
         */
        $part_id = $request->part_id ? $request->part_id: null;
        $quiz = \App\Quiz::where('user_id', '=', Auth::user()->id)
            ->where('package_id', '=', $request->input('package_id'))
            ->where('topic_type', '=', $request->input('topic_type'))
            ->where('topic_id', '=', $request->input('topic_id'))
            ->where('part_id', '=', $part_id)
            ->where('complete','=', 0)->get()->first();
        if($quiz){

            $this->moveAnswersFromActiveTables($quiz->id, $request->user_answers);

            $quiz->complete = 1;
            $quiz->time_left += $request->input('time_left');
            $quiz->score = $request->input('totalScore');
            $quiz->save();

            // delete from active_answers
            DB::table('active_answers')
                ->where('quiz_id', $quiz->id)
                ->delete();
            DB::table('active_drag_right_answers')
                ->where('quiz_id', $quiz->id)
                ->delete();
            DB::table('active_drag_center_answers')
                ->where('quiz_id', $quiz->id)
                ->delete();
        }

        /**
         * delete all, but the latest 3 history records
         */
        $quizzes = \App\Quiz::where('user_id', Auth::user()->id)
            ->where('package_id', '=', $request->input('package_id'))
            ->where('topic_type', '=', $request->input('topic_type'))
            ->where('topic_id', '=', $request->input('topic_id'))
            ->where('part_id', '=', $part_id)
            ->where('complete','=', 1)
            ->orderBy('updated_at', 'desc')->get();
        $i = 1;
        foreach($quizzes as $q){
            if($i > 3 || \Carbon\Carbon::parse($q->updated_at)->addDays(90)->lt(\Carbon\Carbon::now()) ){
                DB::table('correct_answers')->where('quiz_id', $q->id)->delete();
                DB::table('wrong_answers')->where('quiz_id', $q->id)->delete();
                $q->delete();
            }
            $i++;
        }
        return 'saved';
    }

    public function scoreHistory(){
        $score = UserScore::where('user_id', '=', Auth::user()->id)->orderBy('updated_at', 'desc')->paginate(15);
        return view('PremiumQuiz.scoreHistory')->with('score', $score);
    }

    public function showFeedback($id){
        $locale = new Locale;

        $q= Question::find($id);
        $feedback = Transcode::evaluate($q)['feedback'];
        if($q){
            return view('PremiumQuiz.feedback')->with('feedback', $feedback);
        }
        return view('PremiumQuiz.feedback')->with('feedback', 'Error');


    }


    public function st3_vid($package_id, $topic , $topic_id){


        return \Redirect::to( route('st4_vid', [$package_id, 'chapter', 0, 0]) );

        $topic_type = 'chapter';
        $topic_name = '';
        if($topic != $topic_type){
            $topic_type = 'process_group';
            $topic_name = \App\Process_group::find($topic_id)->name;
        }else{
            $topic_name = \App\Chapters::find($topic_id)->name;
        }





        $videos = \App\Video::where([$topic_type => $topic_id, 'event_id' => null])->get();
        if(!$videos){
            return back();
        }


        return view('PremiumQuiz.index-st3-vid')->with('videos', $videos)
            ->with('topic', $topic_name)
            ->with('topic_id', $topic_id)
            ->with('package_id', $package_id)
            ->with('topic_type', $topic_type);
    }

    public function event_vid(Request $request, $event_id, $topic, $topic_id__, $video_id__){
        $locale = new Locale;
        $translationTable = Transcode::getTranslationTable();
        /**
         * Confidentiality: authenticated
         */
        if (!Auth::check()) {
            return back();
        }

        $thisUser = Auth::user();

        /**
         * GET Event FUll Data
         * Confidentiality: user have the package
         */
        $userEvent = DB::table('event_user')
            ->where('event_user.user_id', '=', $thisUser->id)
            ->where('event_user.event_id', '=', $event_id)
            ->join('events', 'event_user.event_id', '=', 'events.id')
            ->join('courses', 'events.course_id', '=', 'courses.id')
            ->leftJoin(DB::raw('(SELECT * FROM ratings WHERE user_id='.Auth::user()->id.' AND event_id='.$event_id.' LIMIT 1) AS ratings'),
                'event_user.event_id', '=', 'ratings.event_id')
            // ->leftJoin(DB::raw('(SELECT * FROM video_progresses WHERE user_id='.Auth::user()->id.' GROUP BY video_id) AS video_progresses'),
            //     'user_packages.package_id','=','video_progresses.package_id')
            ->leftJoin(DB::raw('(SELECT * FROM certifications WHERE user_id='.Auth::user()->id.' GROUP BY event_id) AS certifications'),
                'event_user.event_id', '=', 'certifications.event_id')
            ->select(
            // DB::raw('(SUM(CASE WHEN video_progresses.complete IS NULL THEN 0 ELSE video_progresses.complete END)) AS noCompletedVideos'),
                DB::raw('(CASE WHEN ratings.id IS NULL THEN 0 ELSE 1 END) AS userRatePackage'),
                DB::raw('ratings.rate AS thisUserRate'),
                DB::raw('ratings.review AS thisUserRateReview'),
                DB::raw('event_user.created_at AS haveEventSince'),
                'event_user.event_id',
                'events.name',
                'events.description',
                'events.what_you_learn',
                'events.who_course_for',
                'events.requirement',
                'events.course_id',
                DB::raw('(courses.title) AS course_title'),
                'events.total_time',
                'events.total_lecture',
                'events.start',
                'events.end',
                'events.expire_in_days',
                'events.certification',
                DB::raw('(certifications.id) AS certification_id')
            )->limit(1)
            ->groupBy('event_user.id')
            ->get()->first();


        /**
         * Not Expired
         */
        $expiration_date = Carbon::parse($userEvent->haveEventSince)->addDays($userEvent->expire_in_days);
        if(Carbon::now()->gt($expiration_date)){
            // it's expire
            return \Redirect::to(route('my.package.view'))->with('error', 'Event is No Longer Available.');
        }

        $eventModel = \App\Event::find($event_id);
        $eventModelTranscode = Transcode::evaluate($eventModel);

        if (!$userEvent) {
            return \redirect(route('user.dashboard'))->with('error', 'something went wrong');
        }

        /**
         * VideoProgress
         */
        if ($request->has('watched')) {
            $this->EventVideoComplete($event_id, $request->watched);
        }

        /**
         * GET All Videos FUll data
         */
        $chapters_inc_list = DB::table('chapters')
            ->where('course_id', $userEvent->course_id)
            ->get()->pluck('id')->toArray();

        $eventVideos = DB::table('videos')
            ->whereIn('chapter', $chapters_inc_list)
            ->where('videos.event_id', $userEvent->event_id)
            ->leftJoin(DB::raw('(SELECT * FROM video_progresses WHERE event_id='.$event_id.' AND user_id='.$thisUser->id.' GROUP BY video_id) AS video_progresses'),
                'videos.id','=','video_progresses.video_id')
            ->join('chapters', 'videos.chapter', '=', 'chapters.id');
        if($translationTable){
            $eventVideos = $eventVideos->leftJoin(DB::raw('(SELECT * FROM '.$translationTable.' WHERE table_=\'chapters\') AS chapterTranscode'),
                'chapters.id', '=', 'chapterTranscode.row_')
                ->leftJoin(DB::raw('(SELECT * FROM '.$translationTable.' WHERE table_=\'videos\' AND column_=\'title\') AS videoTranscode'),
                    'videos.id', '=', 'videoTranscode.row_')
                ->select(
                    DB::raw('videos.id AS video_id'),
                    DB::raw('videos.chapter AS chapter_id'),
                    DB::raw('(CASE WHEN chapterTranscode.transcode IS NULL THEN chapters.name ELSE chapterTranscode.transcode END) AS chapter_name'),
                    DB::raw('(CASE WHEN videoTranscode.transcode IS NULL THEN videos.title ELSE videoTranscode.transcode END) AS title'),
                    'videos.chapter',
                    'videos.attachment_url',
                    'videos.duration',
                    'videos.vimeo_id',
                    DB::raw('(CASE WHEN video_progresses.complete IS NULL THEN 0 ELSE 1 END) AS watched'),
                    DB::raw('(video_progresses.updated_at) AS watched_at'),
                    'videos.index_z',
                    'wr_id'
                );
        }else{
            $eventVideos = $eventVideos->select(
                DB::raw('videos.id AS video_id'),
                DB::raw('videos.chapter AS chapter_id'),
                DB::raw('chapters.name AS chapter_name'),
                'videos.title',
                'videos.chapter',
                'videos.attachment_url',
                'videos.duration',
                'videos.vimeo_id',
                DB::raw('(CASE WHEN video_progresses.complete IS NULL THEN 0 ELSE 1 END) AS watched'),
                DB::raw('(video_progresses.updated_at) AS watched_at'),
                'videos.index_z',
                'wr_id'
            );
        }

        $eventVideos = $eventVideos->orderBy('index_z')
            ->get();

        $topic_id = $topic_id__;
        $video_id = $video_id__;

        if($topic_id__ == 0 && $video_id__ == 0){
            // check if the given data are correct ..
            /**
             * get latest video watched
             */
            $latest_video = null;
            for($i = 0; $i < count($eventVideos); $i++){
                if($eventVideos[$i]->watched_at){
                    if($latest_video){
                        if(\Carbon\Carbon::parse($eventVideos[$i]->watched_at)->gt($latest_video->watched_at)){
                            $latest_video = $eventVideos[$i];
                        }
                    }else{
                        $latest_video = $eventVideos[$i];
                    }
                }
            }

            if(!$latest_video){
                if(!count($eventVideos)){
                    return back()->with('error', 'No Content Available Yet !');
                }
                $latest_video = $eventVideos->first();
            }


            $topic_id = $latest_video->chapter_id;
            $video_id = $latest_video->video_id;

        }


        /**
         * GET Video Comments
         */
        $comments_id = \App\PageComment::where('page', '=', 'event'.$event_id.'video')->where('item_id', '=', $video_id)->pluck('comment_id')->toArray();
        $comments = \App\Comment::whereIn('id', $comments_id)->orderBy('created_at', 'desc')->get();


        /**
         * GENERATE each chapter FULL data
         */

        $eventChapters = [];
        $total_time = [0, 0, 0]; //[hr, min, sec]
        foreach($chapters_inc_list as $chapter_id){
            $thisChapterVideos = $eventVideos->filter(function($video)use($chapter_id){
                return $video->chapter_id == $chapter_id;
            });

            if(count($thisChapterVideos)){

                $x = (object)[];
                $x->id = $chapter_id;
                $x->name = $thisChapterVideos->first()->chapter_name;
                $x->total_hours = 0;
                $x->total_min = 0;
                $x->total_sec = 0;
                $x->total_time_toString = '';


                $x->videos = [];
                foreach($thisChapterVideos as $video){
                    if($video->duration != '' && $video->duration != null){

                        $x->total_min += \Carbon\Carbon::parse($video->duration)->format('i');
                        $x->total_sec += \Carbon\Carbon::parse($video->duration)->format('s');
                        if(\Carbon\Carbon::parse($video->duration)->format('h') != 12){
                            $x->total_hours += \Carbon\Carbon::parse($video->duration)->format('h');
                        }
                    }

                    array_push($x->videos, $video);
                }

                $x->total_time_toString = \Carbon\Carbon::create(2012, 1, 1, 0, 0, 0)->addHours($x->total_hours)->addMinutes($x->total_min)->addSeconds($x->total_sec)->format('H:i:s');

                $total_time[0] += $x->total_hours;
                $total_time[1] += $x->total_min;
                $total_time[2] += $x->total_sec;

                array_push($eventChapters, $x);

            }
        }

        $total_time[1] += $total_time[2]/60;
        $total_time[2] = round($total_time[2]%60);

        $total_time[0] += $total_time[1]/60;
        $total_time[1] = round($total_time[1]%60);
        $total_time[0] = round($total_time[0]);

        $video = $eventVideos->filter(function($video)use($video_id){return $video->video_id == $video_id;})->first();

        if(!$video){
            return \redirect(route('user.dashboard'))->with('error', 'Something went wrong !');
        }


        $chapter_id = $video->chapter_id;

        $next_video = $eventVideos->filter(function($row)use($video){
            return $row->chapter_id == $video->chapter_id && $row->index_z > $video->index_z;
        })->first();

        if(!$next_video){
            // check if their is a chapter next !
            // $chapters_inc

            // $key = in_array($chapter_id, $chapters_inc_list);
            $key = $this->findItem($chapter_id, $chapters_inc_list);

            if( ($key + 1) == count($chapters_inc_list) || $key == -1){
                $next_video = null;
            }else{
                $chapter_id = $chapters_inc_list[$key+1];

                $next_video = $eventVideos->filter(function($row)use($chapter_id){
                    return $row->chapter_id == $chapter_id;
                })->first();
            }

        }

        $noCompletedVideos = DB::table('video_progresses')
            ->where('user_id', $thisUser->id)
            ->where('event_id', $userEvent->event_id)
            ->where('complete', 1)
            ->select(DB::raw('(COUNT(*)) AS count'))->get()->first()->count;

        $percentage = round($noCompletedVideos/count($eventVideos) * 100);



        return view('PremiumQuiz.index-st4-vid-Event')
            ->with('chapter_id', $topic_id)
            ->with('topic_id', $topic_id)
            ->with('topic', $topic)
            ->with('video', $video)
            ->with('comments', $comments)
            ->with('package', $userEvent)
            ->with('chapters', $eventChapters)
            ->with('percentage', $percentage)
            ->with('noCompletedVideos', $noCompletedVideos)
            ->with('noTotalVideos', count($eventVideos))
            ->with('next_video', $next_video)
            ->with('total_time', $total_time)
            ->with('event', $eventModel)
            ->with('eventModelTranscode', $eventModelTranscode);

    }

    public function is_package_expiredV3($package_id, $have_package_since, $package_expire_in_days /** row include userPackage data[id, ..,created_at] and some data of the package itself */){
        if(\Carbon\Carbon::parse($have_package_since)->addDays($package_expire_in_days)->gte(\Carbon\Carbon::now())){ // original package still not expired
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



    public function restVideosProgress($package_id){
        $thisUser = Auth::user();
        if(!$thisUser){
            return back()->with('error', 'Something went wrong');
        }

        DB::table('video_progresses')
            ->where('user_id', $thisUser->id)
            ->where('package_id', $package_id)
            ->delete();

        return back();

    }

    public function completeVideosProgress($package_id){
        $thisUser = Auth::user();
        $userPackages = DB::table('user_packages')
            ->where('user_packages.user_id', '=', $thisUser->id)
            ->where('user_packages.package_id', '=', $package_id)
            ->join('packages', 'user_packages.package_id', '=', 'packages.id')
            ->select(
                'packages.chapter_included'
            )->limit(1)
            ->groupBy('user_packages.id')
            ->get()->first()->chapter_included;

        $chapters_inc_list = explode(',', $userPackages);

        $packageVideos = DB::table('videos')
            ->whereIn('chapter', $chapters_inc_list)
            ->whereNull('videos.event_id')
            ->leftJoin(DB::raw('(SELECT * FROM video_progresses WHERE package_id='.$package_id.' AND user_id='.$thisUser->id.' GROUP BY video_id) AS video_progresses'),
                'videos.id','=','video_progresses.video_id')
            ->select(
                DB::raw('videos.id AS video_id'),
                DB::raw('(video_progresses.complete) AS watched'),
                DB::raw('(video_progresses.updated_at) AS watched_at'),
                'videos.index_z'
            )
            ->orderBy('index_z')
            ->get();

        $toBeUpdated = $packageVideos->filter(function($row){
            return $row->watched === 0;
        })->pluck(['video_id']);
        $toBeInserted = $packageVideos->filter(function($row){
            return $row->watched === null;
        })->pluck(['video_id']);

        $toBeInsertedStructured = [];

        if(count($toBeUpdated)){
            DB::table('video_progresses')
                ->where('user_id', $thisUser->id)
                ->where('package_id', $package_id)
                ->whereIn('video_id', $toBeUpdated)
                ->update(['complete' => 1]);
        }

        if(count($toBeInserted)){
            foreach($toBeInserted as $video_id){
                $j = [];
                $j['video_id'] = $video_id;
                $j['package_id'] = $package_id;
                $j['user_id'] = $thisUser->id;
                $j['complete'] = 1;
                array_push($toBeInsertedStructured, $j);
            }
            DB::table('video_progresses')
                ->insert($toBeInsertedStructured);

        }
        return back();
    }


    public function st4_vid(Request $request, $package_id_, $topic, $topic_id__, $video_id__)
    {
        $package_id = intval($package_id_);
        return redirect()->to(route('package.details', $package_id));

        $locale = new Locale();
        $translationTable = Transcode::getTranslationTable();
        /**
         * (package, user_package | ,package_videos, videos_videosProgress, videos_comments)
         */

        /**
         * Confidentiality: authenticated
         */
        if (!Auth::check()) {
            return back();
        }

        $thisUser = Auth::user();

        /**
         * GET Package FUll Data
         * Confidentiality: user have the package
         */
        $userPackages = DB::table('user_packages')
            ->where('user_packages.user_id', '=', Auth::user()->id)
            ->where('user_packages.package_id', '=', $package_id)
            ->join('packages', 'user_packages.package_id', '=', 'packages.id')
            ->leftJoin(DB::raw('(SELECT * FROM ratings WHERE user_id='.Auth::user()->id.' AND package_id='.$package_id.' LIMIT 1) AS ratings'),
                'user_packages.package_id', '=', 'ratings.package_id')
            // ->leftJoin(DB::raw('(SELECT * FROM video_progresses WHERE user_id='.Auth::user()->id.' GROUP BY video_id) AS video_progresses'),
            //     'user_packages.package_id','=','video_progresses.package_id')
            ->leftJoin(DB::raw('(SELECT * FROM certifications WHERE user_id='.Auth::user()->id.' GROUP BY package_id) AS certifications'),
                'user_packages.package_id', '=', 'certifications.package_id')
            ->select(
            // DB::raw('(SUM(CASE WHEN video_progresses.complete IS NULL THEN 0 ELSE video_progresses.complete END)) AS noCompletedVideos'),
                DB::raw('(CASE WHEN ratings.id IS NULL THEN 0 ELSE 1 END) AS userRatePackage'),
                DB::raw('ratings.rate AS thisUserRate'),
                DB::raw('ratings.review AS thisUserRateReview'),
                DB::raw('user_packages.created_at AS havePackageSince'),
                'user_packages.package_id',
                'packages.name',
                'packages.description',
                'packages.chapter_included',
                'packages.expire_in_days',
                'packages.what_you_learn',
                'packages.requirement',
                'packages.who_course_for',
                'packages.certification',
                DB::raw('(certifications.id) AS certification_id')
            )->limit(1)
            ->groupBy('user_packages.id')
            ->get()->first();
            
        // if(Auth::user()->id == 5)
        //     dd($userPackages);
            
        if(!$userPackages){
            return redirect()->to(route('user.dashboard'));
        }

        $packageModel = \App\Packages::find($package_id);
        $packageModelTranscode = Transcode::evaluate($packageModel);

        /**
         * Confidentiality: package not expired
         */

        if($this->is_package_expiredV3($userPackages->package_id, $userPackages->havePackageSince, $userPackages->expire_in_days)){
            return \Redirect::to(route('user.dashboard'))->with('error', 'This package is expired !');
        }

        /**
         * VideoProgress
         */
        if ($request->has('watched')) {
            $this->VideoComplete($package_id, $request->watched);
        }

        $chapters_inc_list = explode(',',$userPackages->chapter_included);

        /**
         * GET All Videos FUll data
         */
        $packageVideos = DB::table('videos')
            ->whereIn('chapter', $chapters_inc_list)
            ->whereNull('videos.event_id')
            ->leftJoin(DB::raw('(SELECT * FROM video_progresses WHERE package_id='.$package_id.' AND user_id='.Auth::user()->id.' GROUP BY video_id) AS video_progresses'),
                'videos.id','=','video_progresses.video_id')
            ->join('chapters', 'videos.chapter', '=', 'chapters.id')
            ->leftJoin('materials', 'videos.attachment_url', '=', 'materials.file_url');
        if($translationTable){
            $packageVideos = $packageVideos->leftJoin(DB::raw('(SELECT * FROM '.$translationTable.' WHERE table_=\'chapters\') AS chapterTranscode'),
                'chapters.id', '=', 'chapterTranscode.row_')
                ->leftJoin(DB::raw('(SELECT * FROM '.$translationTable.' WHERE table_=\'videos\' AND column_=\'title\') AS videoTranscode'),
                    'videos.id', '=', 'videoTranscode.row_')
                ->select(
                    DB::raw('videos.id AS video_id'),
                    DB::raw('videos.chapter AS chapter_id'),
                    DB::raw('(CASE WHEN chapterTranscode.transcode IS NULL THEN chapters.name ELSE chapterTranscode.transcode END) AS chapter_name'),
                    DB::raw('(CASE WHEN videoTranscode.transcode IS NULL THEN videos.title ELSE videoTranscode.transcode END) AS title'),
//                    'videos.title',
                    'videos.chapter',
                    'videos.attachment_url',
                    DB::raw('(materials.id) AS attachment_id'),
                    'videos.duration',
                    'videos.vimeo_id',
                    DB::raw('(CASE WHEN video_progresses.complete IS NULL THEN 0 ELSE 1 END) AS watched'),
                    DB::raw('(video_progresses.updated_at) AS watched_at'),
                    'videos.index_z',
                    'wr_id'
                );
        }else{
            $packageVideos = $packageVideos->select(
                DB::raw('videos.id AS video_id'),
                DB::raw('videos.chapter AS chapter_id'),
                DB::raw('chapters.name AS chapter_name'),
                'videos.title',
                'videos.chapter',
                'videos.attachment_url',
                DB::raw('(materials.id) AS attachment_id'),
                'videos.duration',
                'videos.vimeo_id',
                DB::raw('(CASE WHEN video_progresses.complete IS NULL THEN 0 ELSE 1 END) AS watched'),
                DB::raw('(video_progresses.updated_at) AS watched_at'),
                'videos.index_z',
                'wr_id'
            );
        }
        $packageVideos = $packageVideos->orderBy('index_z')
            ->get();


        $topic_id = $topic_id__;
        $video_id = $video_id__;

        if($topic_id__ == 0 && $video_id__ == 0){
            // check if the given data are correct ..
            /**
             * get latest video watched
             */
            $latest_video = null;
            for($i = 0; $i < count($packageVideos); $i++){
                if($packageVideos[$i]->watched_at){
                    if($latest_video){
                        if(\Carbon\Carbon::parse($packageVideos[$i]->watched_at)->gt($latest_video->watched_at)){
                            $latest_video = $packageVideos[$i];
                        }
                    }else{
                        $latest_video = $packageVideos[$i];
                    }
                }
            }

            if(!$latest_video){
                $latest_video = $packageVideos->first();
            }


            $topic_id = $latest_video->chapter_id;
            $video_id = $latest_video->video_id;

        }

        /**
         * GET Video Comments
         */
        $videoComments = DB::table('page_comments')
            ->where('page', '=', 'video')
            ->where('item_id', '=', $video_id)
            ->join('comments', 'page_comments.comment_id', '=', 'comments.id')
            ->join('users', 'comments.user_id', '=', 'users.id')
            ->join('user_details', 'users.id', '=', 'user_details.user_id')
            ->leftJoin('replies', 'page_comments.comment_id', '=', 'replies.reply_to_id')
            ->select(

                'comments.user_id',
                'users.name',
                'user_details.profile_pic',
                DB::raw('comments.id AS comment_id'),
                DB::raw('comments.contant AS comment'),
                'comments.created_at',
                DB::raw('replies.id AS reply_id'),
                DB::raw('(SELECT users.name FROM users WHERE users.id = (SELECT comments.user_id FROM comments WHERE comments.id = replies.comment_id LIMIT 1)) AS reply_name'),
                DB::raw('(SELECT user_details.profile_pic FROM user_details WHERE user_details.user_id = (SELECT comments.user_id FROM comments WHERE comments.id = replies.comment_id LIMIT 1)) AS reply_profile_pic'),
                DB::raw('(SELECT comments.contant FROM comments WHERE comments.id = replies.comment_id LIMIT 1) AS reply_comment'),
                DB::raw('(SELECT comments.created_at FROM comments WHERE comments.id = replies.comment_id LIMIT 1) AS reply_created_at')
            )
            ->orderBy('created_at', 'asc')
            ->get()->groupBy('comment_id');
        /**
         * GENERATE each chapter FULL data
         */
        $packageChapters = [];
        $total_time = [0, 0, 0]; //[hr, min, sec]
        foreach($chapters_inc_list as $chapter_id){

            $thisChapterVideos = $packageVideos->filter(function($video)use($chapter_id){
                return $video->chapter_id == $chapter_id;
            });

            if(count($thisChapterVideos)){

                $x = (object)[];
                $x->id = $chapter_id;
                $x->name = $thisChapterVideos->first()->chapter_name;
                $x->total_hours = 0;
                $x->total_min = 0;
                $x->total_sec = 0;
                $x->total_time_toString = '';
                $x->videos = [];

                foreach($thisChapterVideos as $video){
                    if($video->duration != '' && $video->duration != null){

                        $x->total_min += \Carbon\Carbon::parse($video->duration)->format('i');
                        $x->total_sec += \Carbon\Carbon::parse($video->duration)->format('s');
                        if(\Carbon\Carbon::parse($video->duration)->format('h') != 12){
                            $x->total_hours += \Carbon\Carbon::parse($video->duration)->format('h');
                        }
                    }

                    array_push($x->videos, $video);
                }

                $x->total_time_toString = \Carbon\Carbon::create(2012, 1, 1, 0, 0, 0)->addHours($x->total_hours)->addMinutes($x->total_min)->addSeconds($x->total_sec)->format('H:i:s');

                $total_time[0] += $x->total_hours;
                $total_time[1] += $x->total_min;
                $total_time[2] += $x->total_sec;

                array_push($packageChapters, $x);

            }

        }

        $total_time[1] += $total_time[2]/60;
        $total_time[2] = round($total_time[2]%60);

        $total_time[0] += $total_time[1]/60;
        $total_time[1] = round($total_time[1]%60);
        $total_time[0] = round($total_time[0]);





        $video = $packageVideos->filter(function($video)use($video_id){return $video->video_id == $video_id;})->first();

        if(!$video){
            return \redirect(route('index'))->with('error', 'Something went wrong !');
        }
        $video->html = (app('App\Http\Controllers\VideoController')->Vimeo_GetVideo($video->vimeo_id))->embed->html;

        $watch_link = null;
        // if($video->wr_id){
        //     $ch = curl_init();
        //     curl_setopt($ch, CURLOPT_URL, 'https://whitereflect.com/api/v1/watch/'.$video->wr_id.'?key_id='.$thisUser->id);
        //     curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        //         'Authorization: Bearer '.env('WR_TOKEN'),
        //         'Content-Type: application/json',
        //         'Accept: application/json'
        //     ));
        //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //     $output = curl_exec($ch);
        //     $output = json_decode($output);

        //     $watch_link = $output->link;
        // }

        // check videos in the same chapter
        $chapter_id = $video->chapter_id;

        $next_video = $packageVideos->filter(function($row)use($video){
            return $row->chapter_id == $video->chapter_id && $row->index_z > $video->index_z;
        })->first();

        if(!$next_video){
            // check if their is a chapter next !
            // $chapters_inc

            // $key = in_array($chapter_id, $chapters_inc_list);
            $key = $this->findItem($chapter_id, $chapters_inc_list);

            if( ($key + 1) == count($chapters_inc_list) || $key == -1){
                $next_video = null;
            }else{
                $chapter_id = $chapters_inc_list[$key+1];

                $next_video = $packageVideos->filter(function($row)use($chapter_id){
                    return $row->chapter_id == $chapter_id;
                })->first();
            }

        }

        $noCompletedVideos = DB::table('video_progresses')
            ->where('user_id', $thisUser->id)
            ->where('package_id', $userPackages->package_id)
            ->where('complete', 1)
            ->select(DB::raw('(COUNT(*)) AS count'))->get()->first()->count;

        $percentage = round($noCompletedVideos/count($packageVideos) * 100);

//        dd(DB::getQueryLog());
        return view('PremiumQuiz.index-st4-vid')
            ->with('chapter_id', $topic_id)
            ->with('topic_id', $topic_id)
            ->with('video', $video)
            ->with('comments', $videoComments)
            ->with('package', $userPackages)
            ->with('chapters', $packageChapters)
            ->with('percentage', $percentage)
            ->with('noCompletedVideos', $noCompletedVideos)
            ->with('noTotalVideos', count($packageVideos))
            ->with('next_video', $next_video)
            ->with('total_time', $total_time)
            ->with('packageModelTranscode', $packageModelTranscode)
            ->with('watch_link', $watch_link);

    }


    public function findItem($item, $array){
        $index = 0;
        foreach($array as $i){
            if($item == $i){
                return $index;
            }
            $index++;
        }
        return -1;
    }


    /**
     * save answers and continue later :D
     */


    public function SaveAnswersForLaterOn(Request $request){

        $thisUser = Auth::user();

        /** Search For Existent Quiz - Create one if not found */
        $quiz_id = $this->getInProgressQuizOrCreateNew(
            $thisUser,
            $request->package_id,
            $request->topic_type,
            $request->topic_id,
            $request->part_id,
            [
                'time_left'     => $request->time_left,
                'answered_question_number'  => 0,
                'questions_number'          => $request->questions_number,
                'start_part'                => $request->start_from_,
            ]
        );
        /** Define Question type */
        /** Search if the given answer is stored before */
        /** Update the Records */
        $response = $this->storeAnswer($quiz_id, $request->user_answer);

        /** Update Quiz table */
        DB::table('quizzes')
            ->where('id', $quiz_id)
            ->update([
                'answered_question_number' => $request->answered_question_number,
                'time_left' => DB::raw('time_left + '.$request->time_left)
            ]);

        /** return quiz id */
        return response()->json([
            'quiz_id'   => $quiz_id,
        ], 200);

    }

    public function QuizHistoryShow(Locale $locale){
        $quizzes = \App\Quiz::where('user_id', '=',  Auth::user()->id)->where('complete','=', 1)->orderBy('created_at', 'desc')->paginate(25);
        return view('QuizHistory.show')->with('quizzes', $quizzes);
    }


    public function material_show($course_id){
        $locale = new Locale();
        // check if user is subjected to this course
        $has = 0;
        $userPackages = \App\UserPackages::where('user_id', '=', Auth::user()->id)->get();
        if($userPackages){
            foreach($userPackages as $i){
                $package = \App\Packages::find($i->package_id);
                if($package->course_id == $course_id && ($package->contant_type == 'combined' || $package->contant_type == 'video') ){
                    $has = 1;
                    break;
                }
            }
        }

        if(!$has){
            return back()->with('error','You are not enrolled in this course !');
        }

        return view('user.material')->with('course_id', $course_id);
    }

    public function download_material($id){
        $m= \App\Material::find($id);
        if($m){
            return response()->download(storage_path('app/'.$m->file_url), $m->title.'-'.$m->created_at.'.'.pathinfo($m->file_url, PATHINFO_EXTENSION));
        }else{
            return 'error';
        }
    }

    public function studyPlan_show($id){
        $locale = new Locale();
        // course id -> $id
        $comments_id = \App\PageComment::where('page', '=', 'study_plan')->where('item_id', '=', $id)->pluck('comment_id')->toArray();
        $comments = \App\Comment::whereIn('id', $comments_id)->orderBy('created_at', 'desc')->get();

        $plans = \App\StudyPlan::where('course_id', '=', $id)->orderBy('created_at', 'desc')->get();
        return view('user.studyPlan')->with('plans', $plans)->with('comments', $comments)->with('id', $id);
    }

    public function flashCard_index(Locale $locale){
        return view('flashCard.index');
    }

    public function flashCard_show($id){
        $comments_id = \App\PageComment::where('page', '=', 'flashcard')->where('item_id', '=', $id)->pluck('comment_id')->toArray();
        $comments = \App\Comment::whereIn('id', $comments_id)->orderBy('created_at', 'desc')->get();

        return view('flashCard.show')->with('flashCard', \App\FlashCard::find($id))->with('comments', $comments);
    }

    public function faq_index(Locale $locale){
        $comments_id = \App\PageComment::where('page', '=', 'faq')->where('item_id', '=', 1)->pluck('comment_id')->toArray();
        $comments = \App\Comment::whereIn('id', $comments_id)->orderBy('created_at', 'desc')->get();
        return view('faq.index')->with('comments', $comments)->with('id',1);
    }

    public function VideoComplete($package_id, $video_id){
        $complete = \App\VideoProgress::where('user_id', Auth::user()->id)->where('package_id', $package_id)->where('video_id', $video_id)->get()->first();
        if(!$complete){
            $complete= new \App\VideoProgress;
            $complete->user_id = Auth::user()->id;
            $complete->package_id = $package_id;
            $complete->video_id =  $video_id;
            $complete->complete = 1;
            $complete->save();
        }
        $complete->complete = 1;
        $complete->save();
    }

    public function EventVideoComplete($event_id, $video_id){
        $complete = \App\VideoProgress::where('user_id', Auth::user()->id)->where('event_id', $event_id)->where('video_id', $video_id)->get()->first();
        if(!$complete){
            $complete= new \App\VideoProgress;
            $complete->user_id = Auth::user()->id;
            $complete->event_id = $event_id;
            $complete->video_id =  $video_id;
            $complete->complete = 1;
            $complete->save();
        }
        $complete->complete = 1;
        $complete->save();
    }

    public function feedback_index(Locale $locale){
        return view('user.feedback');
    }

    public function feedback_store(Request $req){
        $this->validate($req, [
            'rate' => 'numeric|required',
            'title' => 'required',
            'feedback'  =>  'required'
        ]);



        $f = new \App\Feedback;
        $f->feedback = $req->input('feedback');
        $f->user_id = Auth::user()->id;
        $f->title = $req->input('title');
        $f->rate = $req->input('rate');
        $f->save();

        return back()->with('success', 'feedback sent .');
    }

    public function feedback_delete($id){
        $feed = \App\Feedback::find($id);

        if($feed){
            if($feed->user_id == Auth::user()->id){
                $feed->disable = 1;
                $feed->save();

                return back()->with('success', 'Feedback deleted.');
            }else{
                return back()->with('error');
            }
        }else{
            return back()->with('error');
        }
    }

    public function rate(Request $req){
        if($req->has('package_id')) {

            $rate = \App\Rating::where('user_id', Auth::user()->id)->where('package_id', $req->input('package_id'))->get()->first();
            if (!$rate) {
                $rate = new \App\Rating;
            }

            $rate->user_id = Auth::user()->id;
            $rate->package_id = $req->input('package_id');
            $rate->rate = $req->input('rate');
            $rate->save();


        }else if($req->has('event_id')){
            $rate = \App\Rating::where('user_id', Auth::user()->id)->where('event_id', $req->input('event_id'))->get()->first();
            if (!$rate) {
                $rate = new \App\Rating;
            }

            $rate->user_id = Auth::user()->id;
            $rate->event_id = $req->input('event_id');
            $rate->rate = $req->input('rate');
            $rate->save();
        }
        return 0;
    }

    public function storeReview(Request $req){
        if($req->has('package_id')){
            $rate = \App\Rating::where('user_id', Auth::user()->id)->where('package_id', $req->input('package_id'))->get()->first();
            if($rate){
                $rate->review = $req->input('user_review');
                $rate->save();
            }
        }else if($req->has('event_id')){
            $rate = \App\Rating::where('user_id', Auth::user()->id)->where('event_id', $req->input('event_id'))->get()->first();
            if($rate){
                $rate->review = $req->input('user_review');
                $rate->save();
            }
        }

        return 0;
    }



    public function myPackages_view(Locale $locale){

        $UserPackage = DB::table('user_packages')
            ->where('user_packages.user_id', '=', Auth::user()->id)
            ->join('packages', 'user_packages.package_id', '=', 'packages.id')
            ->leftJoin('ratings', 'user_packages.package_id', '=', 'ratings.package_id')
            ->join('courses', 'packages.course_id', '=', 'courses.id')
            ->select(
                'packages.*',
                'user_packages.*',
                DB::raw('AVG(ratings.rate) AS rating'), // created_at belongs to user_packages table
                DB::raw('courses.title AS course_title'),
                'courses.title AS course_title'
            )
            ->groupBy('user_packages.id')
            ->get();

        $expired_exam_package_list = [];
        $expired_video_package_list = [];
        /**
         * Working with question Package
         */
        $exam_package_list_ = $UserPackage->filter(function($row){
            return ($row->contant_type == 'question' || $row->contant_type == 'combined');
        });


        $exam_package_list_by_course = [];
        $exam_courses = [];
        foreach($exam_package_list_ as $package){
            if(!in_array($package->course_title, $exam_courses)){
                array_push($exam_courses, $package->course_title);
            }

            $i = (object)[];
            $i->package = $package;
            $i->meta_data = [];

            $chapter_included = [];
            if($package->filter == 'chapter' || $package->filter == 'chapter_process'){
                if($package->chapter_included){
                    $chapter_included = explode(',', $package->chapter_included);
                }
            }

            $process_group_included = [];
            if($package->filter == 'process' || $package->filter == 'chapter_process'){
                if($package->process_group_included){
                    $process_group_included = explode(',', $package->process_group_included);
                }
            }

            $exams = [];
            if($package->exams){
                $exams = explode(',', $package->exams);
            }

//            Cache::forget('package'.$package->package_id.'QuestionsNumber');
            $packageQuestionsNumber = Cache::remember('package'.$package->package_id.'QuestionsNumber', 1440, function()use($chapter_included, $process_group_included, $exams){
                $chapter = DB::table('questions')
                    ->whereIn('questions.chapter', $chapter_included)->get()->count();
                $process = DB::table('questions')
                    ->whereIn('questions.process_group', $process_group_included)->get()->count();
                $exam = DB::table('questions')
                    ->where(function($q)use($exams){
                        foreach($exams as $exam){
                            $q->orWhere('questions.exam_num', 'LIKE', '%'.$exam.'%');
                        }
                    })
                    ->get()->count();
                return $chapter + $process + $exam;

            });


            if(Auth::user()->id == 5){
                // dd($package, $chapter_included, $process_group_included, $exams);
            }
            
            
            $i->meta_data['packageExamsNumber'] = 0;
            if(count($chapter_included)){
                $chapters_question_nbr = DB::table('chapters')
                ->whereIn('chapters.id', $chapter_included)
                ->join('questions', 'chapters.id', '=', 'questions.chapter')
                ->select('chapters.*', DB::raw('COUNT(*) AS question_nbr'))
                ->groupBy('chapters.id')
                ->get()
                ->filter(function($row){
                    return $row->question_nbr;
                });
            
                $i->meta_data['packageExamsNumber'] += count($chapters_question_nbr);
            }
            if(count($process_group_included)){
                $i->meta_data['packageExamsNumber'] += count($process_group_included);
            }
            if(count($exams)){
                $i->meta_data['packageExamsNumber'] += count($exams);
            }


            $i->meta_data['packageQuestionsNumber'] = $packageQuestionsNumber;
            $i->meta_data['expire_date'] = $this->packageNotExpired($package);
            if($this->packageNotExpired($package)){
                if(!array_key_exists($package->course_id, $exam_package_list_by_course)){
                    $exam_package_list_by_course[$package->course_id] = [];
                }
                array_push($exam_package_list_by_course[$package->course_id], $i);

            }else{
                array_push($expired_exam_package_list, $i);
            }


        }
        /**
         * End of Questions package
         */




        /**
         * Working with Video Package
         */
        $video_package_list_ = $UserPackage->filter(function($row){
            return ($row->contant_type == 'video' || $row->contant_type == 'combined');
        });
        $video_package_list_by_course = [];
        $video_courses = [];
        foreach($video_package_list_ as $package) {
            if (!in_array($package->course_title, $video_courses)) {
                array_push($video_courses, $package->course_title);
            }

            $i = (object)[];
            $i->package = $package;
            $i->meta_data = [];
            $i->meta_data['no_of_completed_lectures'] = 0;
            $i->meta_data['no_of_lectures'] = 0;

            $total_min = 0;
            $total_sec = 0;
            $total_hours = 0;

            $chapter_included = [0];
            if($package->chapter_included){
                $chapter_included = explode(',', $package->chapter_included);
            }


            $packageVideos = DB::table('videos')
                ->whereIn('chapter', $chapter_included)
                ->whereNull('videos.event_id')
                ->leftJoin(
                    DB::raw('(select * from video_progresses where user_id='.$package->user_id.' AND package_id='.$package->package_id.' GROUP BY video_id) AS video_progresses'),
                    'video_progresses.video_id', '=', 'videos.id')
                ->select(
                    'videos.duration',
                    DB::raw('video_progresses.complete AS watched')
                )
                ->get();



            $i->meta_data['no_of_lectures'] = count($packageVideos);

            foreach($packageVideos as $v){
                if($v->watched){
                    $i->meta_data['no_of_completed_lectures']++;
                }
                if($v->duration != '' && $v->duration != null){
                    $total_min += \Carbon\Carbon::parse($v->duration)->format('i');
                    $total_sec += \Carbon\Carbon::parse($v->duration)->format('s');
                    if(\Carbon\Carbon::parse($v->duration)->format('h') != 12){
                        $total_hours += \Carbon\Carbon::parse($v->duration)->format('h');
                    }

                }
            }

            $total_min += floor($total_sec / 60);
            $total_sec = $total_sec % 60;

            $total_hours += floor($total_min / 60);
            $total_min = $total_min % 60;

            $i->meta_data['packageTime'] = [round($total_hours), round($total_min), round($total_sec)];
            $i->meta_data['expire_date'] = $this->packageNotExpired($package);
            $i->meta_data['progress'] = $this->progress($i->meta_data['no_of_completed_lectures'], $i->meta_data['no_of_lectures']);

            if($this->packageNotExpired($package)){
                if(!array_key_exists($package->course_id, $video_package_list_by_course)){
                    $video_package_list_by_course[$package->course_id] = [];
                }
                array_push($video_package_list_by_course[$package->course_id], $i);
            }else{
                array_push($expired_video_package_list, $i);
            }




        }

        // dd($video_package_list_by_course, $video_courses);
        /**
         * End of Questions package
         */

        /**
         * Working with Events
         */
        $userEvents = DB::table('event_user')
            ->where('event_user.user_id', '=', Auth::user()->id)
            ->join('events', 'event_user.event_id', '=', 'events.id')
            ->leftJoin('ratings', 'event_user.event_id', '=', 'ratings.event_id')
            ->join('courses', 'events.course_id', '=', 'courses.id')
            ->select(
                'event_user.*',
                'events.*',
                DB::raw('AVG(ratings.rate) AS rating'), // created_at belongs to user_packages table
                DB::raw('courses.title AS course_title'),
                'courses.title AS course_title'
            )
            ->groupBy('event_user.id')
            ->get();

        $courses = DB::table('courses')->where('private', 0)->get();

        // dd($expired_video_package_list);
        return view('user/myPackage')
            ->with('exam_courses', $exam_courses)
            ->with('exam_package_list_by_course', $exam_package_list_by_course)
            ->with('video_courses', $video_courses)
            ->with('video_package_list_by_course', $video_package_list_by_course)
            ->with('userEvents', $userEvents)
            ->with('expired_exam_package_list', $expired_exam_package_list)
            ->with('expired_video_package_list', $expired_video_package_list)
            ->with('courses', $courses);
    }


    public function packageDetails($package_id_){
        $package_id = intval($package_id_);
        $locale = new Locale();
        $translationTable = Transcode::getTranslationTable();
        /**
         * Confidentiality: authenticated
         */
        if (!Auth::check()) {
            return back();
        }

        $thisUser = Auth::user();

        $userPackage = $this->UserPackage($package_id, $thisUser->id);

        if(!$userPackage){
            return redirect()->to(route('user.dashboard'));
        }

        /**
         * Confidentiality: package not expired
         */

        if($this->is_package_expiredV3($userPackage->package_id, $userPackage->havePackageSince, $userPackage->expire_in_days)){
            return \Redirect::to(route('user.dashboard'))->with('error', 'This package is expired !');
        }

        $chapters_inc_list = explode(',',$userPackage->chapter_included);
        $packageVideos = $this->getPackageVideos($package_id, $chapters_inc_list, $translationTable);

        $noCompletedVideos = DB::table('video_progresses')
            ->where('user_id', $thisUser->id)
            ->where('package_id', $userPackage->package_id)
            ->where('complete', 1)
            ->select(DB::raw('(COUNT(*)) AS count'))->get()->first()->count;
        $c1 = count($packageVideos) == 0 ? 1: count($packageVideos);
        $percentage = count($packageVideos) > 0 ? round($noCompletedVideos/$c1  * 100): 0;

        $rating = DB::table('ratings')->where('package_id', $package_id)
            ->select(
                DB::raw('AVG(rate) as avg_rate'),
                DB::raw('COUNT(*) as ratings_number'),
                DB::raw('COUNT(IF(ratings.rate = \'5\', 1, NULL)) as five_stars'),
                DB::raw('COUNT(IF(ratings.rate = \'4\', 1, NULL)) as four_stars'),
                DB::raw('COUNT(IF(ratings.rate = \'3\', 1, NULL)) as three_stars'),
                DB::raw('COUNT(IF(ratings.rate = \'2\', 1, NULL)) as two_stars'),
                DB::raw('COUNT(IF(ratings.rate = \'1\', 1, NULL)) as one_stars')
            )->first();
        $rating_reviews = DB::table('ratings')->where('package_id', $package_id_)
            ->join('user_details', 'ratings.user_id', '=', 'user_details.user_id')
            ->join('users', 'ratings.user_id', '=', 'users.id')
            ->select('ratings.rate', 'ratings.review', 'user_details.profile_pic', 'users.name', 'ratings.created_at')
            ->limit(8)->get();

        return view('user.packageDetails')
            ->with('percentage', $percentage)
            ->with('rating', $rating)
            ->with('rating_reviews', $rating_reviews)
            ->with('packageVideos', $packageVideos)
            ->with('userPackage', $userPackage)
            ->with('package_id', $package_id);
    }

    public function packageNotExpired($userPackage /** row include userPackage data[id, ..,created_at] and some data of the package itself */){
        if(!$userPackage){
            return 0;
        }

        if(\Carbon\Carbon::parse($userPackage->created_at)->addDays($userPackage->expire_in_days)->gte(\Carbon\Carbon::now())){ // original package still not expired
            return \Carbon\Carbon::parse(   $userPackage->created_at    )->addDays($userPackage->expire_in_days)->toFormattedDateString();

        }else{
            $extension = \App\PackageExtension::where('user_id', '=', Auth::user()->id)->where('package_id', '=', $userPackage->package_id)->orderBy('expire_at', 'desc')->first();
            if(!$extension){
                return  0;

            }else{

                if(\Carbon\Carbon::parse($extension->expire_at)->gte(\Carbon\Carbon::now())){

                    return \Carbon\Carbon::parse( $extension->expire_at )->toFormattedDateString();

                }else{

                    return 0;
                }
            }
        }

    }

    public function progress($part, $all){
        if($all == 0){
            return 0;
        }
        return $part/$all *100;
    }
}

