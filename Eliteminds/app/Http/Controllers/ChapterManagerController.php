<?php

namespace App\Http\Controllers;
use App\Localization\Locale;
use App\Transcode\Transcode;
use Illuminate\Http\Request;
use App\Chapters;
use App\Process_group;
use App\Question;
use App\ProjectManagementGroup as PMG;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;


class ChapterManagerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Locale $locale){
        return view('chapters.show')
            ->with('locale', $locale->locale);
    }

    public function load(Locale $locale){
        $courses = DB::table('courses')
            ->leftJoin(DB::raw('(SELECT t.row_, t.transcode FROM transcodes AS t WHERE table_=\'courses\') AS transcodes'),
                'transcodes.row_', '=', 'courses.id')
            ->select(
                'id',
                DB::raw('(title) AS title_en'),
                DB::raw('(CASE WHEN transcode IS NULL THEN title ELSE transcode END) AS title_ar'),
                'created_at'
            )
            ->orderBy('courses.created_at')
            ->get();


        $chapters = DB::table('chapters')
            ->leftJoin(DB::raw('(SELECT t.row_, t.transcode FROM transcodes AS t WHERE table_=\'chapters\') AS transcodes'),
                'transcodes.row_', '=', 'chapters.id')
            ->select(
                'id',
                'course_id',
                DB::raw('(name) AS title_en'),
                DB::raw('(CASE WHEN transcode IS NULL THEN name ELSE transcode END) AS title_ar'),
                'created_at'
            )
            ->orderBy('chapters.created_at')
            ->get();

        $process_group = DB::table('process_groups')
            ->leftJoin(DB::raw('(SELECT t.row_, t.transcode FROM transcodes AS t WHERE table_=\'process_groups\') AS transcodes'),
                'transcodes.row_', '=', 'process_groups.id')
            ->select(
                'id',
                DB::raw('(name) AS title_en'),
                DB::raw('(CASE WHEN transcode IS NULL THEN name ELSE transcode END) AS title_ar'),
                'created_at'
            )
            ->orderBy('process_groups.created_at')
            ->get();

        $exams = DB::table('exams')
            ->leftJoin(DB::raw('(SELECT t.row_, t.transcode FROM transcodes AS t WHERE table_=\'exams\') AS transcodes'),
                'transcodes.row_', '=', 'exams.id')
            ->select(
                'id',
                DB::raw('(name) AS title_en'),
                DB::raw('(CASE WHEN transcode IS NULL THEN name ELSE transcode END) AS title_ar'),
                'created_at'
            )
            ->orderBy('exams.created_at')
            ->get();
        return [
            'courses' => $courses,
            'chapters' => $chapters,
            'process_groups' => $process_group,
            'exams' => $exams
        ];
    }

    public function add(Request $request){
        $title = $request->input('value_en');
        $title_ar = $request->input('value_ar');
        $type = $request->input('type');

        if( $type == 'chapter'){
            $ck = $request->input('CK');

            if($ck == 'true')
                $ck = '1';
            else
                $ck = '0';

            $course = \App\Course::find($request->input('course'));
            if($course){

                $q = new Chapters;
                $q->name = $title;
                $q->ck = $ck;
                $q->course_id = $course->id;
                $q->save();
                // transcode
                Transcode::add($q, [
                    'name' => $title_ar
                ]);

                return [
                    'id' => $q->id,
                    'title_ar' => $title_ar,
                    'title_en' => $title,
                    'course_id' => $q->course_id,
                ];

            }
            return null;
        }else if ( $type == 'process_group'){
            $q = new Process_group;
            $q->name = $title;
            $q->save();

            // transcode
            Transcode::add($q, [
                'name' => $title_ar
            ]);

            return [
                'id' => $q->id,
                'title_ar' => $title_ar,
                'title_en' => $title,
            ];

        }elseif($type == 'course'){

            $course = new \App\Course;
            $course->title = $title;
            $course->private = $request->input('private');
            $course->save();

            // transcode
            Transcode::add($course, [
                'title' => $title_ar
            ]);

            return [
                'id' => $course->id,
                'title_ar' => $title_ar,
                'title_en' => $title,
            ];

        }elseif($type == 'exam'){
            $exam = new \App\Exam;
            $exam->name = $title;
            $exam->save();

            // transcode
            Transcode::add($exam, [
                'title' => $title_ar
            ]);

            return [
                'id' => $exam->id,
                'title_ar' => $title_ar,
                'title_en' => $title,
            ];

        }else{
            return '404';
        }

        return '200';

    }

    public function delete(Request $request){
        $title = $request->input('value');
        $type = $request->input('type');
        if($type == 'knowledge'){
            $q1 = Chapters::where('name', '=', $title)->first();
            $check = Question::where('chapter','=',$q1->id);

            if($check->first()){
                // you can not delete it , its in use
                return '300';
            }else {
                $q1->delete();  /** Delete Chapter */
            }

        }else if ($type == 'process_group'){
            $q2 = Process_group::where('name', '=', $title)->first();
            $check = Question::where('process_group','=',$q2->id);

            if($check->first()){
                // you can not delete it , its in use
                return '300';
            }else {
                $q2->delete(); /** Delete Process Group */
            }
        }else if ($type == 'PMG'){
            // check if in use !
            // $check = Question::where('PMG','=',$q->id);
            $q3 = PMG::where('name', '=',$title)->first();
            $q3->delete();
        }elseif($type== 'course'){
            $course = \App\Course::where('title', '=', $title)->get()->first();
            if($course){
                $check = \App\Chapters::where('course_id', '=', $course->id)->get()->first();
                if($check){
                    return '300';
                }else{
                    $course->delete(); /** Delete Course */
                }
            }
        }elseif($type== 'exam'){
            $exam = \App\Exam::where('name', $title)->get()->first();
            if($exam){
                $exam->delete(); /** Delete Exam */
            }
        }else {

            return '404';
        }
        return '200';
    }


    public function update(Request $request){

        $type = $request->input('type');
        $id = $request->input('id');

        if($type == 'chapter'){
            $chapter = \App\Chapters::find($id);
            $chapter->name = $request->value_en;
            $chapter->save();

            // transcode
            Transcode::update($chapter, [
                'name' => $request->value_ar
            ]);

            return [
                'id' => $chapter->id,
                'title_en' => $request->value_en,
                'title_ar' => $request->value_ar,
                'course_id' => $chapter->course_id,
            ];


        }else if ($type == 'process_group'){
            $process = \App\Process_group::find($id);

            $process->name = $request->value_en;
            $process->save();

            // transcode
            Transcode::update($process, [
                'name' => $request->value_ar
            ]);

            return [
                'id' => $process->id,
                'title_en' => $request->value_en,
                'title_ar' => $request->value_ar,
            ];

        }elseif($type== 'course'){
            $course = \App\Course::find($id);
            if($course){
                $course->title = $request->value_en;
                $course->save();

                Transcode::update($course, [
                    'title' => $request->value_ar,
                ]);

                return [
                    'id' => $course->id,
                    'title_en' => $request->value_en,
                    'title_ar' => $request->value_ar,
                ];
            }
        }elseif($type== 'exam'){
            $exam = \App\Exam::find($id);
            $exam->name = $request->value_en;
            $exam->save();

            // transcode
            Transcode::update($exam, [
                'title' => $request->value_ar
            ]);

            return [
                'id' => $exam->id,
                'title_en' => $request->value_en,
                'title_ar' => $request->value_ar,
            ];

        }else {

            return '404';
        }
        return '200';
    }
}

