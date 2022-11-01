<?php

namespace App\Http\Controllers;

use App\Helper\QuestionHelper;
use App\QuestionAnswer;
use App\QuestionCenterDragdrop;
use App\QuestionDragdrop;
use App\Transcode\Transcode;

use Google\Cloud\Translate\V2\TranslateClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Question;
use App\Chapters;
use App\Process_group;
use App\QuestionRoles;
use App\Packages;
use App\ProjectManagementGroup as PMG;
use Illuminate\Support\Facades\Input;

// we could use
// use DB;

class QuestionsController extends Controller
{
    use QuestionHelper;
    
    public $pagination = 20;
    public $dropzone;

    public function __construct()
    {
        $this->middleware('auth:admin'); //default auth --->> auth:web
        $this->dropzone = app('App\Http\Controllers\DropzoneController');
        $this->PremiumQuizController = app('App\Http\Controllers\Users\PremiumQuizController');
    }


    public function translate($question_id){
        $question = \App\Question::find($question_id);
        $translate = new TranslateClient();
        $result = $translate->translateBatch([
            $question->title,
            $question->correct_answer,
            $question->a,
            $question->b,
            $question->c,
            $question->feedback
        ],
        [
            'target' => 'ar',
        ]);
        $question_translation['title'] = $result[0]['text'];
        $question_translation['correct_answer'] = $result[1]['text'];
        $question_translation['a'] = $result[2]['text'];
        $question_translation['b'] = $result[3]['text'];
        $question_translation['c'] = $result[4]['text'];
        $question_translation['feedback'] = $result[5]['text'];

        Transcode::update($question, $question_translation);
        return \Redirect::to(route('question.edit', $question->id));
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $word = request()->word;
        $chapter = \request()->chapter;
        $process_group = \request()->process_group;
        $exam = \request()->exam;
        $course_id = \request()->course_id;

        $questions_id = [];
        $questionsModel = DB::table('questions')
            ->leftJoin('chapters', 'questions.chapter', '=', 'chapters.id')
            ->leftJoin('process_groups', 'questions.process_group', '=' ,'process_groups.id')
            ->where(function($query) use($course_id){
                if($course_id){
                    $query->where('chapters.course_id', $course_id);
                }
            })
            ->where(function($query)use($word){
                if($word){
                    $query->where('questions.title', 'LIKE', '%'.$word.'%');
                }
            })
            ->where(function($query)use($chapter){
                if($chapter){
                    $query->where('questions.chapter', $chapter);
                }
            })
            ->where(function($query)use($process_group){
                if($process_group){
                    $query->where('questions.process_group', $process_group);
                }
            })
            ->where(function($query)use($exam){
                if($exam){
                    $query->where(DB::raw("CONCAT(',', TRIM(BOTH '\"' FROM `exam_num`), ',')"), 'LIKE', '%,'.$exam.',%');
                }
            })
            ->select('questions.id', 'questions.chapter', 'questions.process_group')
            ->paginate(request()->pagination > 0? request()->pagination: 10);

        foreach($questionsModel->items() as $question){
            array_push($questions_id, $question->id);
        }

        $questions_data = $this->batchQuestionLoader($questions_id);
        $result_counter = count($questions_data);
        // chapters
        $chapters = Chapters::all();
        $ch_select = [''=>''];
        foreach($chapters as $ch){
            $ch_select[$ch->id] = $ch->name;
        }
        // Process Groups
        $process_group = Process_group::all();
        $pg_select = [''=>''];
        foreach($process_group as $pg){
            $pg_select[$pg->id] = $pg->name;
        }

        return view('questions.show')
            ->with('questions_data', $questions_data)
            ->with('questionsModel', $questionsModel)
            ->with('ch_select', $ch_select)
            ->with('pg_select', $pg_select)
            ->with('result_counter',$result_counter);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $courses = \App\Course::all();
        $course_select = [''];
        foreach($courses as $ch) {
            $course_select[$ch->id] = $ch->title;
        }
        return view('questions.create')->with('course_select', $course_select);
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate for the img
        if($request->has('images')){
            foreach ($request->input('images') as $file_name) {
                $this->dropzone->upload($file_name, storage_path('app/public/questions/'.$file_name));
                $img_path = 'public/questions/'.$file_name;
            }
        }


        $question = new Question;
        $question->title = $request->input('question_title');
        $question->question_type_id = $request->question_type_id;
        $question->correct_answers_required = (int)$request->correct_answers_required;

        if(!empty($request->input('exam_num'))){
            $exams_arr = implode(',',$request->input('exam_num'));
            $question->exam_num = $exams_arr;
        }else{
            $question->exam_num = null;
        }

        $question->chapter = $request->chapter_id;
        if($request->input('process_group') != ''){
            $q01 = Process_group::where('name','=',$request->input('process_group'))->first();
            if(!$q01){
                return response()->json(['error' => 'Domain: '.$request->input('process_group').' was not found !'], 200);
            }
            $question->process_group = $q01->id;
        }

        $question->demo = $request->input('demo') == 'true' ? 1: 0;
        $question->img = isset($img_path) ? $img_path: null;
        $question->feedback = $request->input('feedback');
        $question->save();

        Transcode::add($question, [
            'title' => $request->question_title_ar,
            'feedback' => $request->feedback_ar,
        ]);

        if($request->question_type_id == 3) {
            /** Matching To Right */
            if (is_iterable($request->drags)) {
                foreach ($request->drags as $drag) {
                    $dragModel = QuestionDragdrop::create([
                        'left_sentence' => $drag['left_sentence'],
                        'right_sentence' => $drag['right_sentence'],
                        'question_id' => $question->id,
                    ]);
                    Transcode::add($dragModel, [
                        'left_sentence' => $drag['left_sentence_ar'],
                        'right_sentence' => $drag['right_sentence_ar'],
                    ]);
                }
            }
        }else if ($request->question_type_id == 5){
            /** Matching To Center */
            if (is_iterable($request->dragsCenter)) {
                foreach ($request->dragsCenter as $drag) {
                    $dragModel = QuestionCenterDragdrop::create([
                        'correct_sentence' => $drag['correct_sentence'],
                        'center_sentence' => $drag['center_sentence'],
                        'wrong_sentence' => $drag['wrong_sentence'],
                        'question_id' => $question->id,
                    ]);
                    Transcode::add($dragModel, [
                        'correct_sentence' => $drag['correct_sentence_ar'],
                        'center_sentence' => $drag['center_sentence_ar'],
                        'wrong_sentence' => $drag['wrong_sentence_ar'],
                    ]);
                }
            }
        }else{
            /** For The reset */
            if(is_iterable($request->answers)){
                foreach($request->answers as $answer){
                    $answerModel = QuestionAnswer::create([
                        'answer'        => $answer['answer'],
                        'is_correct'    => $answer['is_correct'] ? 1:0,
                        'question_id'   => $question->id,
                    ]);
                    Transcode::add($answerModel, [
                        'answer'        => $answer['answer_ar'],
                    ]);
                }
            }
        }

        return response()->json(['error' => ''], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return 'OK';
    }



    public function optimizeQuestionTranslation($questions){
        $qustions_arr = [];
        $lastQuestionID = 0;
        $lastQuestionObj = null;

        for($i=0; $i <  count($questions); $i++){
            if($lastQuestionID == $questions[$i]->id){
                $lastQuestionObj->transcodes[$questions[$i]->column_] = $questions[$i]->transcode;
                // case last loop
                if($i + 1 == count($questions)){
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
                $lastQuestionObj->correct_answer = $questions[$i]->correct_answer;
                $lastQuestionObj->created_at = $questions[$i]->created_at;
                $lastQuestionObj->demo = $questions[$i]->demo;
                $lastQuestionObj->exam_num = $questions[$i]->exam_num;
                $lastQuestionObj->feedback = $questions[$i]->feedback;
                $lastQuestionObj->id = $questions[$i]->id;
                $lastQuestionObj->img = $questions[$i]->img;
                $lastQuestionObj->process_group = $questions[$i]->process_group;
                $lastQuestionObj->project_management_group = $questions[$i]->project_management_group;
                $lastQuestionObj->updated_at = $questions[$i]->updated_at;
                $lastQuestionObj->transcodes = [
                    'title' => '',
                    'a' => '',
                    'b' => '',
                    'c' => '',
                    'correct_answer' => '',
                    'feedback' => '',
                ];
                // push first tarnslate
                $lastQuestionObj->transcodes[$questions[$i]->column_] = $questions[$i]->transcode;

                if(count($questions) == 1){
                    // only one question with no translation..
                    array_push($qustions_arr, $lastQuestionObj);
                }

            }

        }

        return $qustions_arr;
    }

    public function editV2($id){
        $courses = \App\Course::all();
        $course_select = [''];
        foreach($courses as $ch) {
            $course_select[$ch->id] = $ch->title;
        }
        return view('questions.editV2')
            ->with('question_id', $id)
            ->with('course_select', $course_select);
    }

    public function editLoader(Request $request){
//        return $this->batchQuestionLoader([$request->question_id]);
        $question = $this->questionLoader($request->question_id);
        $chapters = \App\Chapters::where('course_id', $question->course_id)->get(['id', 'name']);
        return response()->json([
            'chapters'  => $chapters,
            'question'  => $question,
        ], 200);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = DB::table('questions')
            ->where('id', $id)
            ->leftJoin(DB::raw('(SELECT transcodes.column_, transcodes.transcode, transcodes.row_ FROM transcodes WHERE table_ = \'questions\') AS transcodes'), function($join){
                $join->on('transcodes.row_', '=', 'questions.id');
            })
            ->select(
                'questions.*',
                DB::raw('(TRIM(BOTH \'"\' FROM `exam_num`)) AS exam_num'),
                'transcodes.column_',
                'transcodes.transcode'
            )->get();


        $question = ($this->optimizeQuestionTranslation($question))[0];


        $courses = \App\Course::all();
        $course_select = [''];
        foreach($courses as $ch){
            $course_select[$ch->id] = $ch->title;
        }

        $chapters = Chapters::all();
        $ch_select = [''];
        foreach($chapters as $ch){
            $ch_select[$ch->id] = $ch->name;
        }

        $process_group = Process_group::all();
        $pg_select = [];
        foreach($process_group as $pg){
            $pg_select[$pg->id] = $pg->name;
        }

        $pmg_list = [];
        $q = PMG::where('knowledge_area_id', '=',$question->chapter)->get();
        if($q->first()){
            foreach($q as $q){
                array_push($pmg_list, $q->name);
            }
        }
        if( $question->project_management_group){
            $q2 = PMG::where('id', '=', $question->project_management_group)->get()->first()->name;
        }else {
            $q2 = null;
        }
        if($question->process_group){
            $q3 = Process_group::where('id', '=', $question->process_group)->get()->first()->name;
        }else{
            $q3 = null;
        }
        
        
        return view('questions.edit')->with('question',$question)->with('ch_select', $ch_select)->with('pg_select', $pg_select)
            ->with('pmg_list', $pmg_list)
            ->with('pmg_value', $q2)
            ->with('pgroup_value',$q3)
            ->with('exams', explode(',', $question->exam_num))
            ->with('course_select', $course_select)
            ->with('course', \App\Chapters::find($question->chapter)->course_id)
            ->with('course_id', \App\Chapters::find($question->chapter)->course_id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $questionModel = Question::find($id);

        // validate for the img
        if($request->has('images')){
            foreach ($request->input('images') as $file_name) {
                $this->dropzone->upload($file_name, storage_path('app/public/questions/'.$file_name));
                $img_path = 'public/questions/'.$file_name;
            }
            $oldPath = $questionModel->img;
            if(Storage::exists($oldPath)){
                Storage::delete($oldPath);
            }
        }

        $questionModel->title = $request->input('question_title');
        $questionModel->question_type_id = $request->question_type_id;
        $questionModel->correct_answers_required = (int)$request->correct_answers_required;

        if(!empty($request->input('exam_num'))){
            $exams_arr = implode(',',$request->input('exam_num'));
            $questionModel->exam_num = $exams_arr;
        }else{
            $questionModel->exam_num = null;
        }

        $questionModel->chapter = $request->chapter_id;
        if($request->input('process_group') != ''){
            $q01 = Process_group::where('name','=',$request->input('process_group'))->get()->first();
            $questionModel->process_group = $q01->id;
        }

        $questionModel->demo = $request->input('demo') == 'true' ? 1: 0;
        if($request->has('images')){
            $questionModel->img = isset($img_path) ? $img_path: null;
        }
        $questionModel->feedback = $request->input('feedback');
        $questionModel->save();

        Transcode::update($questionModel, [
            'title' => $request->question_title_ar,
            'feedback' => $request->feedback_ar,
        ]);

        Transcode::update($questionModel, [
            'title' => $request->question_title_fr,
            'feedback' => $request->feedback_fr,
        ], 'fr');

        if($request->question_type_id == 3){
            /** Matching To Right */
            $drags_id = [];
            if (is_iterable($request->drags)) {
                foreach ($request->drags as $drag) {
                    if($drag['id']){
                        $dragModel = QuestionDragdrop::find($drag['id']);
                        $dragModel->update([
                            'left_sentence'  => $drag['left_sentence'],
                            'right_sentence' => $drag['right_sentence'],
                        ]);
                        Transcode::update($dragModel, [
                            'left_sentence'  => $drag['left_sentence_ar'],
                            'right_sentence' => $drag['right_sentence_ar'],
                        ]);
                        Transcode::update($dragModel, [
                            'left_sentence'  => $drag['left_sentence_fr'],
                            'right_sentence' => $drag['right_sentence_fr'],
                        ], 'fr');
                    }else{
                        $dragModel = QuestionDragdrop::create([
                            'left_sentence'  => $drag['left_sentence'],
                            'right_sentence' => $drag['right_sentence'],
                            'question_id'    => $questionModel->id,
                        ]);
                        Transcode::add($dragModel, [
                            'left_sentence'  => $drag['left_sentence_ar'],
                            'right_sentence' => $drag['right_sentence_ar'],
                        ]);
                        Transcode::add($dragModel, [
                            'left_sentence'  => $drag['left_sentence_fr'],
                            'right_sentence' => $drag['right_sentence_fr'],
                        ], 'fr');
                    }
                    array_push($drags_id, $dragModel->id);
                }
            }
            /** remove the rest if any */
            DB::table('question_dragdrops')
                ->where('question_id', $questionModel->id)
                ->whereNotIn('id', $drags_id)
                ->delete();
        }else if ($request->question_type_id == 5){
            /** Matching To Center */
            $drags_id = [];
            if (is_iterable($request->dragsCenter)) {
                foreach ($request->dragsCenter as $drag) {
                    if($drag['id']){
                        $dragModel = QuestionCenterDragdrop::find($drag['id']);
                        $dragModel->update([
                            'correct_sentence' => $drag['correct_sentence'],
                            'center_sentence'  => $drag['center_sentence'],
                            'wrong_sentence'   => $drag['wrong_sentence'],
                        ]);
                        Transcode::update($dragModel, [
                            'correct_sentence' => $drag['correct_sentence_ar'],
                            'center_sentence'  => $drag['center_sentence_ar'],
                            'wrong_sentence'   => $drag['wrong_sentence_ar'],
                        ]);
                        Transcode::update($dragModel, [
                            'correct_sentence' => $drag['correct_sentence_fr'],
                            'center_sentence'  => $drag['center_sentence_fr'],
                            'wrong_sentence'   => $drag['wrong_sentence_fr'],
                        ], 'fr');
                    }else{
                        $dragModel = QuestionCenterDragdrop::create([
                            'correct_sentence' => $drag['correct_sentence'],
                            'center_sentence'  => $drag['center_sentence'],
                            'wrong_sentence'   => $drag['wrong_sentence'],
                            'question_id'      => $questionModel->id,
                        ]);
                        Transcode::add($dragModel, [
                            'correct_sentence' => $drag['correct_sentence_ar'],
                            'center_sentence'  => $drag['center_sentence_ar'],
                            'wrong_sentence'   => $drag['wrong_sentence_ar'],
                        ]);
                        Transcode::add($dragModel, [
                            'correct_sentence' => $drag['correct_sentence_fr'],
                            'center_sentence'  => $drag['center_sentence_fr'],
                            'wrong_sentence'   => $drag['wrong_sentence_fr'],
                        ], 'fr');
                    }
                    array_push($drags_id, $dragModel->id);
                }
            }
            /** remove the rest if any */
            DB::table('question_center_dragdrops')
                ->where('question_id', $questionModel->id)
                ->whereNotIn('id', $drags_id)
                ->delete();
        }else{
            /** For The reset */
            $answers_id = [];
            if(is_iterable($request->answers)){
                foreach($request->answers as $answer){
                    if($answer['id']){
                        $answerModel = QuestionAnswer::find($answer['id']);
                        $answerModel->update([
                            'answer'        => $answer['answer'],
                            'is_correct'    => $answer['is_correct'] ? 1:0,
                        ]);
                        Transcode::update($answerModel, [
                            'answer'        => $answer['answer_ar'],
                        ]);
                        Transcode::update($answerModel, [
                            'answer'        => $answer['answer_fr'],
                        ], 'fr');
                    }else{
                        $answerModel = QuestionAnswer::create([
                            'answer'        => $answer['answer'],
                            'is_correct'    => $answer['is_correct'] ? 1:0,
                            'question_id'   => $questionModel->id,
                        ]);
                        Transcode::add($answerModel, [
                            'answer'        => $answer['answer_ar'],
                        ]);
                        Transcode::add($answerModel, [
                            'answer'        => $answer['answer_fr'],
                        ], 'fr');
                    }
                    array_push($answers_id, $answerModel->id);
                }
            }
            /** remove the rest if any */
            DB::table('question_answers')
                ->where('question_id', $questionModel->id)
                ->whereNotIn('id', $answers_id)
                ->delete();
        }

        return response()->json(null, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->email == 'edit_question@'.env('APP_DOMAIN')){
            return back()->with('error', 'You dont have Permission to Delete, This Action will be reported.');
        }
        $question = Question::find($id);
        $oldPath = $question->img;
        if(Storage::exists($oldPath)){
            Storage::delete($oldPath);
        }
        Transcode::delete($question);
        $answers = \App\QuestionAnswer::where('question_id', $id)->get();
        if(count($answers)){
            foreach($answers as $a){
                Transcode::delete($a);
            }
        }

        $dragRight = \App\QuestionDragdrop::where('question_id', $id)->get();
        if(count($dragRight)){
            foreach($dragRight as $d){
                Transcode::delete($d);
            }
        }

        $dragCenter = \App\QuestionCenterDragdrop::where('question_id', $id)->get();
        if(count($dragCenter)){
            foreach($dragCenter as $d){
                Transcode::delete($d);
            }
        }
        $question->delete();

        return redirect(route('question.index'))->with('success', 'Question Deleted');
    }

    public function batchDestory(Request $request){
        Question::whereIn('id', $request->questions)->delete();
        return response()->json([
            'error' => '',
        ], 200);
    }

    /* Additional Function other than resource */

    public function search(Request $Request){
        $word = Input::get('word');
        $chapter = Input::get('chapter');
        $process_group = Input::get('process_group');
        $pmg = Input::get('project_management_group');
        $exam = Input::get('exam');

        $questions = DB::table('questions')
            ->where('title', 'LIKE', '%'.$word.'%')
            ->where(function($qq) use ($chapter) {
                if($chapter!= '00'){
                    return $qq->where('questions.chapter','=',$chapter);
                }
            })
            ->where(function($qq) use ($process_group){
                if($process_group !='00' ){
                    return $qq->where('questions.process_group','=',$process_group);
                }
            })->where(function($qq) use ($pmg){
                if($pmg != '00'){
                    return $qq->where('questions.project_management_group', '=', $pmg);
                }
            })->where(function($qq) use($exam){
                if($exam != '00'){
                    return $qq->where('questions.exam_num', 'LIKE', '%'.$exam.'%');
                }
            })
            ->leftJoin('chapters', 'questions.chapter', '=', 'chapters.id')
            ->leftJoin('process_groups', 'questions.process_group', '=' ,'process_groups.id')
            ->leftJoin(DB::raw('(SELECT transcodes.column_, transcodes.transcode, transcodes.row_ FROM transcodes WHERE table_ = \'questions\') AS transcodes'), function($join){
                $join->on('transcodes.row_', '=', 'questions.id');
            })
            ->select(
                'questions.*',
                DB::raw('(chapters.name) AS chapter_name'),
                DB::raw('(process_groups.name) AS process_group_name'),
                'transcodes.column_',
                'transcodes.transcode'
            )
            ->orderBy('questions.id')
            ->get();

        $questions = $this->PremiumQuizController->optimizeQuestionTranslation($questions);

        
        $result_counter = count($questions);

        $chapters = Chapters::all();
        $ch_select = [''];
        foreach($chapters as $ch){
            $ch_select[$ch->id] = $ch->name;
        }

        $process_group = Process_group::all();
        $pg_select = [''];
        foreach($process_group as $pg){
            $pg_select[$pg->id] = $pg->name;
        }

        $pmg = PMG::all();
        $pmg_list = ['00' =>''];
        foreach($pmg as $i){
            $pmg_list[$i->id] = $i->name;
        }



        $roles_list = []; // to hold the full role -> (question id => package name) list
        $packages_name = []; // to hold the name of packages that attached to one question .
        
        $packages = Packages::all();
        if($packages->first()){
            foreach($packages as $package){
                $question = QuestionRoles::where('package_id', '=', $package->id)->get();
                // loop throug and add them to the roles _list..
                if($question->first()){
                    foreach($question as $q){
                        if(isset($roles_list[$q->question_id])){
                            $to_array = explode(", ",$roles_list[$q->question_id]);
                            array_push( $to_array,  $package->name);
                            $roles_list[$q->question_id] = implode(", ", $to_array);
                        }else{
                            $roles_list[$q->question_id]= $package->name;
                        }
                    }
                }
            }
        }

        return view('questions.show')->with('questions', $questions)->with('ch_select', $ch_select)->with('pg_select', $pg_select)
            ->with('roles_list', $roles_list)->with('pmg', $pmg_list)->with('result_counter', $result_counter);
    }


    /**
     * functions that handle the ajax request from add question page
     */

    public function showProcess(){
        $process=[];
        $q = Process_group::all();
        foreach($q as $i){
            array_push($process, $i->name);
        }
        return $process;
        
    }
    /**
     * end of the ajax request handler functions
     */

    public function fetchLibrary(Request $request){

        switch($request->topic_required){
            case 'chapter':
                $chapters = Chapters::where([
                    'course_id'           => $request->parent_topic_id,
                ])
                    ->get(['id', 'name']);
                return response()->json($chapters, 200);
                break;

            default:
                return response()->json([], 200);
        }
    }

}
