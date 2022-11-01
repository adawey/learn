<?php

namespace App\Http\Controllers;

use App\Process_group;
use App\Question;

use App\Course;
use App\Chapters;
use App\Exam;

use App\Section;
use App\Transcode\Transcode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LibraryController extends \App\Http\Controllers\Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
     public function doSlug(string $title, int $package_id): void
    {
        $slug = $this->makeSlug($title, '-');
        $slugExists = DB::table('courses')
            ->where('slug', $slug)
            ->exists();
        if($slugExists){
            $slug = $slug.'-'.$package_id;
            $slugExists = DB::table('courses')->where('slug', $slug)->exists();
            while($slugExists){
                $slug = $slug.'-'.mt_rand(1000, 9999);
            }
        }

        DB::table('courses')->where('id', $package_id)->update(['slug' => $slug]);
    }

    /**
     * @param $str
     * @param string $delimiter
     * @return string
     */
    public function makeSlug($str, $delimiter = '-'){
        $slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))))), $delimiter));
        return $slug;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = DB::table('courses')
            ->leftJoin(DB::raw('(SELECT transcode, row_, column_, table_ FROM transcodes WHERE table_=\'courses\' GROUP BY row_) AS transcodes')
                , 'courses.id', '=', 'transcodes.row_')
            ->leftJoin(DB::raw('(SELECT transcode, row_, column_, table_ FROM transcode_frs WHERE table_=\'courses\' GROUP BY row_) AS transcode_frs')
                , 'courses.id', '=', 'transcode_frs.row_')
            ->select('courses.id', 'courses.title', 'transcodes.transcode', DB::raw('(transcode_frs.transcode) AS transcode_fr') )
            ->get();
        return view('admin.library.index')
            ->with('courses', $courses);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.library.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /** validate Path Title */
        if(!$request->has('course_title')){
            return response()->json(config('library.course.en').' Title is required', 500);
        }

        $thisUser = Auth::user();
        $course_title = $request->course_title;
        $course_title_ar = $request->course_title_ar;


        /** Create New Path */
        $courseModel = Course::create([
            'title'             => $course_title,
            'private'           => $request->course_private,
        ]);
        $courseModel->slug = $this->doSlug($course_title, $courseModel->id);
        
        Transcode::add($courseModel, ['title' => $course_title_ar]);

        if(!isset($request->chapters)){
            return $this->successJsonResponse();
        }
        if(!is_iterable($request->chapters)){
            return $this->successJsonResponse();
        }
        foreach($request->chapters as $chapter){
            /**
             * it has title (string), parts (array)
             */
            $chapterModel = Chapters::create([
                'name'             => $chapter['title'],
                'course_id'        => $courseModel->id,
                'ck'                => 0,
            ]);
            Transcode::add($chapterModel, [
                'name'  => $chapter['title_ar'],
            ]);
        }
        if(!isset($request->course_details)){
            return $this->successJsonResponse();
        }
        if(!is_iterable($request->course_details)){
            return $this->successJsonResponse();
        }
        /** Insert New Course Details */
        $data = array_map(function($i)use($courseModel){
            return [
                'title' => $i['title'],
                'description'   => $i['description'],
                'course_id'  => $courseModel->id,
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ];
        }, $request->course_details);
        DB::table('course_details')
            ->insert($data);

        return $this->successJsonResponse();
    }

    public function singleStore(Request $request, $topic_type){
        switch ($topic_type){
            case 'chapter':
                $chapterModel = Chapters::create([
                    'name'             => $request->title,
                    'course_id'           => $request->parent_id,
                ]);
                Transcode::add($chapterModel, [
                    'name'  => $request->title_ar,
                ]);
                break;
            default:
                break;
        }
        return response()->json([], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->getCourse($id);
    }

    public function getCourse($course_id){
        $coursesModel = Course::find($course_id);
        $courseTranscode = Transcode::evaluate($coursesModel, 'ar', true);
        $courseTranscode_fr = Transcode::evaluate($coursesModel, 'fr', true);
        $chapters = [];
        $chaptersModel = DB::table('chapters')
            ->leftJoin(DB::raw('(SELECT transcode, row_, column_, table_ FROM transcodes WHERE table_=\'chapters\' GROUP BY row_) AS transcodes')
                , 'chapters.id', '=', 'transcodes.row_')
            ->leftJoin(DB::raw('(SELECT transcode, row_, column_, table_ FROM transcode_frs WHERE table_=\'chapters\' GROUP BY row_) AS transcode_frs')
                , 'chapters.id', '=', 'transcode_frs.row_')
            ->select('chapters.id', 'chapters.name', 'transcodes.transcode', DB::raw('(transcode_frs.transcode) AS transcode_fr'))
            ->where('course_id', $course_id)
            ->get();
        if(is_iterable($chaptersModel)){
            foreach($chaptersModel as $chapter){
                $chapter_item = [
                    'id'    => $chapter->id,
                    'title' => $chapter->name,
                    'title_ar'  => $chapter->transcode,
                    'title_fr'  => $chapter->transcode_fr,
                ];

                array_push($chapters, $chapter_item);
            }
        }

        $course_details = DB::table('course_details')
            ->where('course_id', $coursesModel->id)
            ->select('title', 'description')
            ->get()->toArray();

        return [
            'id'            => $coursesModel->id,
            'title'         => $coursesModel->title,
            'title_ar'      => $courseTranscode['title'],
            'title_fr'      => $courseTranscode_fr['title'],
            'private'       => $coursesModel->private,
            'chapters'      => $chapters,
            'course_details'=> $course_details,
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin.library.edit')
            ->with('course_id', $id);
    }

    /**
     * Edit page Loader
     * @param $path_id
     * @return array
     */
    public function loader($course_id){
        return $this->getCourse($course_id);
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
        /** Only update the Path title */
        $course = Course::find($id);
        if($course){
            Transcode::update($course, ['title' => $request->course_title_ar]);
            Transcode::update($course, ['title' => $request->course_title_fr], 'fr');
            $course->title = $request->course_title;
            $course->private = $request->course_private;
            $course->slug = $this->doSlug($request->course_title, $course->id);
            $course->save();
        }

        if(!isset($request->course_details)){
            return $this->successJsonResponse();
        }
        if(!is_iterable($request->course_details)){
            return $this->successJsonResponse();
        }
        /** Delete Existing Course Details */
        DB::table('course_details')
            ->where('course_id', $course->id)
            ->delete();
        /** Insert New Course Details */
        $data = array_map(function($i)use($course){
            return [
                'title' => $i['title'],
                'description'   => $i['description'],
                'course_id'     => $course->id,
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ];
        }, $request->course_details);
        DB::table('course_details')
            ->insert($data);


        return response($course, 200);
    }

    public function singleUpdate(Request $request, $topic_type){

        if($request->value == ''){
            return response()->json('empty ?', 422);
        }

        $topic = $this->modelByTopicType($topic_type, $request->topic_id);

        if($topic){
            if($topic_type == 'course'){
                $topic->title = $request->value;
                Transcode::update($topic, ['title' => $request->value_ar]);
                Transcode::update($topic, ['title' => $request->value_fr], 'fr');
            }else if($topic_type == 'chapter'){
                $topic->name = $request->value;
                Transcode::update($topic, ['name' => $request->value_ar]);
                Transcode::update($topic, ['name' => $request->value_fr], 'fr');
            }

            $topic->save();
        }

        return response()->json([], 200);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $course = Course::where([
            'id'                => $id,
        ])->first();

        if($course){
            Transcode::delete($course);
            Transcode::delete($course, 'fr');
            $course->delete();
        }
        return back()->with('success', config('library.path.en').' Deleted.');
    }

    public function singleDestroy(Request $request, $topic_type){
        $topic = $this->modelByTopicType($topic_type, $request->topic_id);

        if($topic){
            Transcode::delete($topic);
            Transcode::delete($topic, 'fr');
            $topic->delete();
        }

        return response()->json([], 200);
    }



    public function successJsonResponse(){
        return response()->json(null, 200);
    }

    public function fetchLibrary(Request $request){

        switch($request->topic_required){
            case 'path':
                $courses = Course::get(['id', 'title']);
                return response()->json($courses, 200);
                break;
            case 'course':
                $chapters = DB::table('chapters')
                    ->where([
                        'course_id'       => $request->parent_topic_id,
                    ])
                    ->select('id', DB::raw('(name) AS title'))
                    ->get();
                return response()->json($chapters, 200);
                break;
            default:
                return response()->json([], 200);
        }
    }

    public function modelByTopicType($topic_type, $topic_id){
        switch ($topic_type){
            case 'course':
                $topic = Course::find($topic_id);
                break;
            case 'chapter':
                $topic = Chapters::find($topic_id);
                break;
            default:
                $topic = null;
                break;
        }
        return $topic;
    }

    private function getExams($id = null){
        return DB::table('exams')
            ->leftJoin(DB::raw('(SELECT transcode, row_, column_, table_ FROM transcodes WHERE table_=\'exams\' GROUP BY row_) AS transcodes')
                , 'exams.id', '=', 'transcodes.row_')
            ->leftJoin(DB::raw('(SELECT transcode, row_, column_, table_ FROM transcode_frs WHERE table_=\'exams\' GROUP BY row_) AS transcode_frs')
                , 'exams.id', '=', 'transcode_frs.row_')
            ->select('exams.id', 'exams.name', 'exams.duration', 'transcodes.transcode', DB::raw('(transcode_frs.transcode) AS transcode_fr'))
            ->where(function($query) use($id) {
                if($id){
                    $query->where('exams.id', $id);
                }
            })->get();
    }


    /**
     * Insert New Exam
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeExam(Request $request){
        $examModel = Exam::create([
            'name' => $request->exam_title,
            'duration' => $request->duration,
        ]);
        Transcode::add($examModel, [
           'name'   => $request->exam_title_ar,
        ]);
        Transcode::add($examModel, [
            'name'   => $request->exam_title_fr,
        ], 'fr');
        return response()->json($examModel, 201);
    }

    /**
     * All Exams
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexExam(){
        $exams = $this->getExams()->toArray();
        return response()->json($exams);
    }

    /**
     * Delete Exam
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyExam($id){
        DB::table('exams')
            ->where('id', $id)
            ->delete();
        DB::table('transcodes')
            ->where([
                'table_'    => 'exams',
                'column_'   => 'name',
                'row_'      => $id
            ])
            ->delete();
        DB::table('transcode_frs')
            ->where([
                'table_'    => 'exams',
                'column_'   => 'name',
                'row_'      => $id
            ])
            ->delete();
        return response()->json(null, 404);
    }


    /**
     * Update Exam
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateExam(Request $request, $id){
        $exam = Exam::find($id);
        if($exam){
            $exam->name = $request->exam_title;
            $exam->duration = $request->duration;
            $exam->save();
            Transcode::update($exam,[
                'name'  => $request->exam_title_ar,
            ]);
            Transcode::update($exam,[
                'name'  => $request->exam_title_fr,
            ], 'fr');
            return response()->json(null, 200);
        }
        return response()->json(null, 404);
    }

    private function getDomains($id = null){
        return DB::table('process_groups')
            ->leftJoin(DB::raw('(SELECT transcode, row_, column_, table_ FROM transcodes WHERE table_=\'process_groups\' GROUP BY row_) AS transcodes')
                , 'process_groups.id', '=', 'transcodes.row_')
            ->leftJoin(DB::raw('(SELECT transcode, row_, column_, table_ FROM transcode_frs WHERE table_=\'process_groups\' GROUP BY row_) AS transcode_frs')
                , 'process_groups.id', '=', 'transcode_frs.row_')
            ->select('process_groups.id', 'process_groups.name', 'transcodes.transcode', DB::raw('(transcode_frs.transcode) AS transcode_fr'))
            ->where(function($query) use($id) {
                if($id){
                    $query->where('process_groups.id', $id);
                }
            })->get();
    }


    /**
     * Insert New Exam
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeDomain(Request $request){
        $processModel = Process_group::create([
            'name' => $request->domain_title,
        ]);
        Transcode::add($processModel, [
            'name'  => $request->domain_title_ar
        ]);
        Transcode::add($processModel, [
            'name'  => $request->domain_title_fr
        ], 'fr');
        return response()->json($processModel, 201);
    }

    /**
     * All Exams
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexDomain(){
        $domains = $this->getDomains()->toArray();
        return response()->json($domains);
    }

    /**
     * Delete Exam
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyDomain($id){
        DB::table('process_groups')
            ->where('id', $id)
            ->delete();
        DB::table('transcodes')
            ->where([
                'table_'    => 'process_groups',
                'column_'   => 'name',
                'row_'      => $id
            ])
            ->delete();
        DB::table('transcode_frs')
            ->where([
                'table_'    => 'process_groups',
                'column_'   => 'name',
                'row_'      => $id
            ])
            ->delete();
        return response()->json(null, 404);
    }


    /**
     * Update Exam
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateDomain(Request $request, $id){
        $domain = Process_group::find($id);
        if($domain){
            $domain->name = $request->domain_title;
            $domain->save();
            Transcode::update($domain, [
                'name'  => $request->domain_title_ar,
            ]);
            Transcode::update($domain, [
                'name'  => $request->domain_title_fr,
            ], 'fr');
            return response()->json(null, 200);
        }
        return response()->json(null, 404);
    }


    private function getSections($id = null){
        return DB::table('sections')
            ->leftJoin(DB::raw('(SELECT transcode, row_, column_, table_ FROM transcodes WHERE table_=\'sections\' GROUP BY row_) AS transcodes')
                , 'sections.id', '=', 'transcodes.row_')
            ->leftJoin(DB::raw('(SELECT transcode, row_, column_, table_ FROM transcode_frs WHERE table_=\'sections\' GROUP BY row_) AS transcode_frs')
                , 'sections.id', '=', 'transcode_frs.row_')
            ->select('sections.id', 'sections.title', 'transcodes.transcode', DB::raw('(transcode_frs.transcode) AS transcode_fr'))
            ->where(function($query) use($id) {
                if($id){
                    $query->where('sections.id', $id);
                }
            })->get();
    }

    /**
     * Insert New Section
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeSection(Request $request){
        $sectionModel = Section::create([
            'title' => $request->section_title,
        ]);
        Transcode::add($sectionModel, [
            'title'   => $request->section_title_ar,
        ]);
        Transcode::add($sectionModel, [
            'title'   => $request->section_title_fr,
        ], 'fr');
        return response()->json($sectionModel, 201);
    }

    /**
     * All Section
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexSection(){
        $exams = $this->getSections()->toArray();
        return response()->json($exams);
    }

    /**
     * Delete Section
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroySection($id){
        DB::table('sections')
            ->where('id', $id)
            ->delete();
        DB::table('transcodes')
            ->where([
                'table_'    => 'sections',
                'column_'   => 'title',
                'row_'      => $id
            ])
            ->delete();
        DB::table('transcode_frs')
            ->where([
                'table_'    => 'sections',
                'column_'   => 'title',
                'row_'      => $id
            ])
            ->delete();
        return response()->json(null, 404);
    }


    /**
     * Update Section
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateSection(Request $request, $id){
        $section = Section::find($id);
        if($section){
            $section->title = $request->section_title;
            $section->save();
            Transcode::update($section,[
                'title'  => $request->section_title_ar,
            ]);
            Transcode::update($section,[
                'title'  => $request->section_title_fr,
            ], 'fr');
            return response()->json(null, 200);
        }
        return response()->json(null, 404);
    }

}
