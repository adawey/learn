<?php

namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class API_PremiumQuizController extends Controller
{

    public function faq(){
        $faq = \App\FAQ::orderBy('created_at', 'desc')->get()->toArray();
        return response()->json($faq, 200);
    }

    public function flashcard(){
        $flashcards = DB::table('flash_cards')
            ->select(
                'title',
                DB::raw('(img) AS image'),
                DB::raw('(contant) as content'),
                'created_at'
            )->orderBy('created_at', 'desc')
            ->get()
            ->map(function($row){
                $row->image = $row->image ? [
                    'url'   => url('storage/flashcard/'.basename($row->image)),
                ]: null;
            });
        return response()->json([
            'flashcards'    => $flashcards
        ], 200);
    }

    /**
     * return my study material
     */
    public function studyMaterial(){

        $myCourses = [];
        $myPackages = \App\UserPackages::where('user_id', Auth::user()->id)->get();
        foreach($myPackages as $item){
            $package = \App\Packages::find($item->package_id);

            if(!in_array($package->course_id, $myCourses)){
                array_push($myCourses, $package->course_id);
            }
        }

        $materials_arr = [];
        foreach($myCourses as $course_id){
            $materials = \App\Material::where('course_id', $course_id)->get();
            $materials_arr_item = (object)[];
            $materials_arr_item->course = (object)[];
            $materials_arr_item->course->id = $course_id;
            $materials_arr_item->course->title = \App\Course::find($course_id)->title;
            $materials_arr_item->materials = [];
            foreach($materials as $m){
                $i = [
                    'title' => $m->title,
                    'url'   => url('storage/material/'.basename($m->file_url))
                ];
                array_push($materials_arr_item->materials, $i);
            }

            array_push($materials_arr, $materials_arr_item);
        }

        return response()->json($materials_arr, 200);



    }

    /**
     * @param $package_id
     * @param $topic
     * @param $topic_id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeAnswer(Request $request){

        $package_id = $request->package_id;
        $topic = $request->topic == 'process_group'? 'process': $request->topic;
        $topic_id = $request->topic_id;
        $questions_number = $request->questions_number;
        $period_of_time = $request->period_of_time_taken;
        $question_id = $request->question_id;
        $question_answer = $request->question_answer;
        $part_id = $request->part_id;

        $thisUser = Auth::user();

        /** Search For Existent Quiz - Create one if not found */
        $quiz_id = app('App\Http\Controllers\Users\PremiumQuizController')->getInProgressQuizOrCreateNew(
            $thisUser,
            $package_id,
            $topic,
            $topic_id,
            $part_id,
            [
                'time_left'     => $period_of_time,
                'answered_question_number'  => 0,
                'questions_number'          => $request->questions_number,
                'start_part'                => $request->start_from_,
            ]
        );
        /** Define Question type */
        /** Search if the given answer is stored before */
        /** Update the Records */
        $response = app('App\Http\Controllers\Users\PremiumQuizController')->storeAnswer($quiz_id, $request->user_answer);

        /** Update Quiz table */
        DB::table('quizzes')
            ->where('id', $quiz_id)
            ->update([
                'answered_question_number' => $request->answered_question_number,
                'time_left' => DB::raw('time_left + '.$period_of_time)
            ]);

        /** return quiz id */
        return response()->json([
            'quiz_id'   => $quiz_id,
        ], 200);
    }

    function generate($package_id, $topic, $topic_id, $quiz_id, $request){
        $thisUser = Auth::user();
        $questions_array = [];
        /**
         * GET Package FUll Data
         * Confidentiality: user have the package
         */
        $userPackage = DB::table('user_packages')
            ->where('user_packages.user_id', '=', $thisUser->id)
            ->where('user_packages.package_id', '=', $package_id)
            ->join('packages', 'user_packages.package_id', '=', 'packages.id')
            ->leftJoin(DB::raw('(SELECT * FROM ratings WHERE user_id='.$thisUser->id.' AND package_id='.$package_id.' LIMIT 1) AS ratings'),
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

        if(!$userPackage){
            return response()->json([
                'message'   => 'Package does not exists in user account.',
                'errors'    => []
            ]);
        }
        if(app('App\Http\Controllers\Users\PremiumQuizController')->is_package_expiredV3($userPackage->package_id, $userPackage->havePackageSince, $userPackage->expire_in_days)){
            return response()->json([
                'message'   => 'Package Expired.',
                'errors'    => []
            ]);
        }

        $activeAnswers = null;
        $activeDragRightAnswers = null;
        $activeDragCenterAnswers = null;
        $part_id = $request->part_id ? $request->part_id: null;

        $quiz = DB::table('quizzes')
            ->where('user_id', '=', $thisUser->id)
            ->where('package_id', '=', $userPackage->package_id)
            ->where('topic_type', '=', $topic)
            ->where('topic_id', '=', $topic_id)
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
        if($quiz){
            $time_left = (int)($quiz->time_left);
            $answers_number = $quiz->answered_question_number;
        }else{
            $time_left = 0;
            $answers_number = 0;
        }

        if($topic == 'chapter') {
            if (!in_array($request->topic_id, explode(',', $userPackage->chapter_included))) {
                return response()->json([
                    'message'   => 'Package Does not include this topic.',
                    'errors'    => []
                ]);
            }

            $questions =  DB::table('questions')
                ->where('chapter', '=', $topic_id)
                ->select('questions.id')
                ->get()
                ->pluck(['id']);

        }elseif($topic == 'process_group'){
            if(!in_array($topic_id, explode(',', $userPackage->process_group_included))){
                return response()->json([
                    'message'   => 'Package Does not include this topic.',
                    'errors'    => []
                ]);
            }
            $questions =  DB::table('questions')
                ->where('process_group', '=', $topic_id)
                ->select('questions.id')
                ->get()
                ->pluck(['id']);
            $questions = app('App\Http\Controllers\Users\PremiumQuizController')->DivideIntoParts($questions, app('App\Http\Controllers\Users\PremiumQuizController')->per_part, $part_id);
        }elseif($topic == 'exam'){
            $exam_num = $topic_id;
            // check if included in package ..
            $all_exams = $userPackage->exams;
            $all_exams = explode(',', $all_exams);
            if(!in_array($exam_num, $all_exams)){
                return response()->json([
                    'message'   => 'Package Does not include this topic.',
                    'errors'    => []
                ]);
            }
            $questions =  DB::table('questions')
                ->where(DB::raw("CONCAT(',', TRIM(BOTH '\"' FROM `exam_num`), ',')"), 'LIKE', '%,'.$exam_num.',%')
                ->select('questions.id')
                ->get()
                ->pluck(['id']);
        }

        $questions = app('App\Http\Controllers\Users\PremiumQuizController')->batchQuestionLoader($questions)->toArray();
        $x = app('App\Http\Controllers\Users\PremiumQuizController')->reArrange($questions);
        if($quiz){
            $start_ = $quiz->start_part;
        }else{
            $start_ = rand(1, $x[1]);
        }

        return response()->json([
            'start_from_'               => $start_,
            'questions'                 => app('App\Http\Controllers\Users\PremiumQuizController')->startFromPart($x[0], $x[1], $start_), // questions
            'time_taken_sec'            => $time_left,  //
            'answers_number'            => $answers_number, // answers_number
            'userAnswers'               => $activeAnswers ? $activeAnswers: null,
            'userDragRightAnswers'      => $activeDragRightAnswers ? $activeDragRightAnswers: null,
            'userDragCenterAnswers'     => $activeDragCenterAnswers ? $activeDragCenterAnswers: null,
        ], 200);


    }

    public function generate_bychapter($package_id, $topic_id, Request $request){
        $quiz = null;
        return $this->generate($package_id, 'chapter', $topic_id, $quiz, $request);
    }

    public function generate_byprocess($package_id, $topic_id , Request $request){
        $quiz = null;
        return $this->generate($package_id, 'process_group', $topic_id, $quiz, $request);
    }

    public function generate_exam($package_id, $topic_id, Request $request){
        $quiz = null;
        return $this->generate($package_id, 'exam', $topic_id, $quiz, $request);
    }

    /**
     * @param $package_id
     * @param $topic
     * @param $topic_id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeScore(Request $request){

        $score = $request->totalScore;
        $package_id = $request->package_id;
        $topic = $request->topic_type;
        $topic_id = $request->topic_id;
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

            app('App\Http\Controllers\Users\PremiumQuizController')->moveAnswersFromActiveTables($quiz->id, $request->user_answers);

            $quiz->complete = 1;
            $quiz->time_left += $request->input('period_of_time_taken');
            $quiz->score = $score;
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

        return response()->json([], 201);
    }

    public function showQuiz(Request $request){

        $quiz = \App\Quiz::where('user_id', Auth::user()->id)
            ->where(function($query)use($request){
                if($request->has('topic')){
                    $query->where('topic_type', $request->topic);
                }
                if($request->has('topic_id')){
                    $query->where('topic_id', $request->topic_id);
                }
                if($request->has('package_id')){
                    $query->where('package_id', $request->package_id);
                }
            })
            ->orderBy('created_at','desc')
            ->where('complete', 1)
            ->get();

        $quiz_list = [];

        foreach($quiz as $q){
            $package = \App\Packages::find($q->package_id);

            if($q->topic_type == 'chapter'){
                $topic_name = \App\Chapters::find($q->topic_id)->name;
            }elseif($q->topic_type == 'process'){
                $topic_name = \App\Process_group::find($q->topic_id)->name;
            }elseif($q->topic_type == 'exam'){
                $topic_name = \App\Exam::find($q->topic_id)->name;
            }elseif($q->topic_type == 'mistake'){
                if($q->topic_id == 1){
                    $topic_name = 'Chapter Mistakes';
                }else if($q->topic_id == 2){
                    $topic_name = 'Process Group Mistakes';
                }else if($q->topic_id == 3){
                    $topic_name = 'Exam Mistakes';
                }

            }else{
                continue;
            }

            if($package){
                $i = (object)[];
                $i->id = $q->id;
                $i->pacakge_id = $q->package_id;
                $i->package_name = $package->name;
                $i->user_id = $q->user_id;
                $i->topic = $q->topic_type;
                $i->topic_id = $q->topic_id;
                $i->topic_name = $topic_name;
                $i->questions_number = $q->questions_number;
                $i->answered_question_number = $q->answered_question_number;
                $i->score = round($q->score, 2);
                $i->time_taken = round($q->time_left);
                $i->created_at = $q->created_at;
                $i->updated_at = $q->updated_at;
                array_push($quiz_list, $i);
            }

        }
        return response()->json($quiz_list, 200);
    }



    public function reviewQuiz(Request $request){
        $quizModule = app('App\Http\Controllers\Users\PremiumQuizController');
        return $quizModule->QuizHistory_load($request);
    }
}
