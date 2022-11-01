<?php


namespace App\Helper;
use Illuminate\Support\Facades\DB;

trait QuestionHelper
{
    public $languages = ['ar', 'fr'];

    public function fixDuplicationDueTranslation($records, $record_columns, $record_translation_columns){
        $items_arr = [];
        $currentItemID = 0;
        $currentItem = null;
        for($i=0; $i <  count($records); $i++){
            // all children records are array [key => value]
            $records[$i] = (array)$records[$i];
            if($currentItemID == $records[$i]['id']){
                $currentItem['transcodes'][$records[$i]['column_']] = $records[$i]['transcode']; // to be deleted
                foreach($this->languages as $l){
                    if($records[$i]['column_'.$l]){
                        $currentItem['transcodes'][  $records[$i]['column_'.$l].'_'.$l   ] = array_key_exists('transcode_'.$l, $records[$i]) ?$records[$i]['transcode_'.$l]: '--';
                    }
                }
            }else{
                // push current item and process new one
                // condition to bypass first iteration
                if($currentItemID != 0){
                    array_push($items_arr, $currentItem);
                }
                // records must have special identifier [id]
                $currentItemID = $records[$i]['id'];
                $currentItem = [];

                foreach($record_columns as $column){
                    $currentItem[$column] = $records[$i][$column];
                }
                $currentItem['transcodes'] = [];
                foreach($record_translation_columns as $column){
                    $currentItem['transcodes'][$column] = '';
                    foreach($this->languages as $l){
                        $currentItem['transcodes'][$column.'_'.$l] = '';
                    }
                }

                // push first translation
                $currentItem['transcodes'][$records[$i]['column_']] = $records[$i]['transcode']; // to be deleted
                foreach($this->languages as $l){
                    if($records[$i]['column_'.$l]){
                        $currentItem['transcodes'][  $records[$i]['column_'.$l].'_'.$l   ] = array_key_exists('transcode_'.$l, $records[$i]) ?$records[$i]['transcode_'.$l]: '--';
                    }

                }

            }
            // case last loop in iteration
            if(($i + 1) == count($records)){
                array_push($items_arr, $currentItem);
            }

        }
        return $items_arr;
    }

    public function batchQuestionLoader($question_id_array){
        /** @var Get All Questions $questions */
        $questions = DB::table('questions')
            ->whereIn('questions.id', $question_id_array)
            // From Library..
            ->leftJoin('chapters', 'questions.chapter', '=', 'chapters.id')
            ->leftJoin('courses', 'chapters.course_id', '=', 'courses.id')
            ->leftJoin('process_groups', 'questions.process_group', '=', 'process_groups.id')
            ->select(
                'questions.id',
                'questions.correct_answers_required',
                'questions.question_type_id',
                DB::raw('(questions.title) AS question_title'),
                'questions.feedback',
                DB::raw('(courses.id) AS course_id'),
                DB::raw('(courses.title) AS course'),
                DB::raw('(chapters.id) AS chapter_id'),
                DB::raw('(chapters.name) AS chapter'),
                DB::raw('(process_groups.id) AS process_group_id'),
                DB::raw('(process_groups.name) AS process_group'),
                DB::raw("(TRIM(BOTH '\"' FROM `exam_num`)) AS exam_num"),
                'questions.img',
                'questions.demo'
            )
            ->get();

        /** @var Get All Question Translations $question_translate */
        // default was AR
        $question_translate = DB::table('transcodes')
            ->whereIn('row_', $question_id_array)
            ->where([
                'table_'    => 'questions'
            ])
            ->select('column_', 'transcode', 'row_')
            ->get();
        $question_translate_fr = DB::table('transcode_frs')
            ->whereIn('row_', $question_id_array)
            ->where([
                'table_'    => 'questions'
            ])
            ->select('column_', 'transcode', 'row_')
            ->get();

        /** @var Get All Questions Answers $question */
        $question_answers = DB::table('question_answers')
            ->whereIn('question_id', $question_id_array)
            ->leftJoin(DB::raw('(SELECT transcodes.column_, transcodes.transcode, transcodes.row_ FROM transcodes WHERE table_ = \'question_answers\' GROUP BY row_) AS transcodes'), function($join){
                $join->on('transcodes.row_', '=', 'question_answers.id');
            })
            ->leftJoin(DB::raw('(SELECT transcode_frs.column_, transcode_frs.transcode, transcode_frs.row_ FROM transcode_frs WHERE table_ = \'question_answers\' GROUP BY row_) AS transcode_frs'), function($join){
                $join->on('transcode_frs.row_', '=', 'question_answers.id');
            })
            ->select(
                'question_answers.id',
                'question_answers.question_id',
                'question_answers.answer',
                'transcodes.transcode', // to be deleted ..
                DB::raw('(transcodes.column_) AS column_ar'),
                DB::raw('(transcodes.transcode) AS transcode_ar'),
                DB::raw('(transcode_frs.column_) AS column_fr'),
                DB::raw('(transcode_frs.transcode) AS transcode_fr'),
                'transcodes.column_', // to be deleted ..
                'question_answers.is_correct'
            )
            ->get()
            ->toArray();

        $question_answers = $this->fixDuplicationDueTranslation($question_answers,
            ['id', 'question_id', 'answer', 'is_correct'],
            ['answer']);

        /** @var Get All Drag Right Items $question_drag_right */
        $question_drag_right = DB::table('question_dragdrops')
            ->whereIn('question_id', $question_id_array)
            ->leftJoin(DB::raw('(SELECT transcodes.column_, transcodes.transcode, transcodes.row_ FROM transcodes WHERE table_ = \'question_dragdrops\') AS transcodes'), function($join){
                $join->on('transcodes.row_', '=', 'question_dragdrops.id');
            })
            ->leftJoin(DB::raw('(SELECT transcode_frs.column_, transcode_frs.transcode, transcode_frs.row_ FROM transcode_frs WHERE table_ = \'question_dragdrops\') AS transcode_frs'), function($join){
                $join->on('transcode_frs.row_', '=', 'question_dragdrops.id');
            })
            ->select(
                'question_dragdrops.id',
                'question_dragdrops.question_id',
                'question_dragdrops.left_sentence',
                'question_dragdrops.right_sentence',
                'transcodes.column_',
                'transcodes.transcode',
                DB::raw('(transcodes.column_) AS column_ar'),
                DB::raw('(transcodes.transcode) AS transcode_ar'),
                DB::raw('(transcode_frs.column_) AS column_fr'),
                DB::raw('(transcode_frs.transcode) AS transcode_fr')
            )
            ->get()
            ->toArray();

        $question_drag_right = $this->fixDuplicationDueTranslation($question_drag_right,
            ['id', 'question_id', 'left_sentence', 'right_sentence'],
            ['left_sentence', 'right_sentence']);

        /** @var Get All Drag Center $question_drag_right */
        $question_drag_center = DB::table('question_center_dragdrops')
            ->whereIn('question_id', $question_id_array)
            ->leftJoin(DB::raw('(SELECT transcodes.column_, transcodes.transcode, transcodes.row_ FROM transcodes WHERE table_ = \'question_center_dragdrops\') AS transcodes'), function($join){
                $join->on('transcodes.row_', '=', 'question_center_dragdrops.id');
            })
            ->leftJoin(DB::raw('(SELECT transcode_frs.column_, transcode_frs.transcode, transcode_frs.row_ FROM transcode_frs WHERE table_ = \'question_center_dragdrops\') AS transcode_frs'), function($join){
                $join->on('transcode_frs.row_', '=', 'question_center_dragdrops.id');
            })
            ->select(
                'question_center_dragdrops.id',
                'question_center_dragdrops.question_id',
                'question_center_dragdrops.correct_sentence',
                'question_center_dragdrops.center_sentence',
                'question_center_dragdrops.wrong_sentence',
                'transcodes.column_',
                'transcodes.transcode',
                DB::raw('(transcodes.column_) AS column_ar'),
                DB::raw('(transcodes.transcode) AS transcode_ar'),
                DB::raw('(transcode_frs.column_) AS column_fr'),
                DB::raw('(transcode_frs.transcode) AS transcode_fr')
            )
            ->get()
            ->toArray();
        $question_drag_center = $this->fixDuplicationDueTranslation($question_drag_center,
            ['id', 'question_id', 'correct_sentence', 'center_sentence', 'wrong_sentence'],
            ['correct_sentence', 'center_sentence', 'wrong_sentence']);


        foreach($questions as $question){
            $translation = $question_translate->filter(function($row)use($question){
                return $row->row_ == $question->id;
            });
            $translation_fr = $question_translate_fr->filter(function($row)use($question){
                return $row->row_ == $question->id;
            });

            /** Add Questions Translations */
            $title_ar = $translation->filter(function($row){return $row->column_ == 'title';})->first();
            $title_ar = $title_ar ? $title_ar->transcode : null;
            $question->question_title_ar = $title_ar;

            $feedback_ar = $translation->filter(function($row){return $row->column_ == 'feedback';})->first();
            $feedback_ar = $feedback_ar ? $feedback_ar->transcode : null;
            $question->feedback_ar = $feedback_ar;

            $title_fr = $translation_fr->filter(function($row){return $row->column_ == 'title';})->first();
            $title_fr = $title_fr ? $title_fr->transcode : null;
            $question->question_title_fr = $title_fr;

            $feedback_fr = $translation_fr->filter(function($row){return $row->column_ == 'feedback';})->first();
            $feedback_fr = $feedback_fr ? $feedback_fr->transcode : null;
            $question->feedback_fr = $feedback_fr;

            /** Add Answers Array */
            $question->answers = null;
            if(count($question_answers)){
                $answers = array_filter($question_answers, function($i)use($question){
                    return $i['question_id'] == $question->id;
                });
                if(count($answers)){
                    $question->answers = $answers;
                    shuffle($question->answers);
                }
            }
            /** Add Drag Right */
            $question->drag_right = null;
            if(count($question_drag_right)){
                $drag_right = array_filter($question_drag_right, function($i)use($question){
                    return $i['question_id'] == $question->id;
                });
                if(count($drag_right)){
                    $question->drag_right = $drag_right;
                    shuffle($question->drag_right);
                }
            }
            /** Add Drag Center */
            $question->drag_center = null;
            if(count($question_drag_center)){
                $drag_center = array_filter($question_drag_center, function($i)use($question){
                    return $i['question_id'] == $question->id;
                });
                if(count($drag_center)){
                    $question->drag_center = $drag_center;
                    shuffle($question->drag_center);
                }
            }
        }
        return $questions;
    }

    public function questionLoader($question_id){
        $question = $this->batchQuestionLoader([$question_id]);
        if(count($question)){
            return ($question[0]);
        }
        return null;
    }

}
