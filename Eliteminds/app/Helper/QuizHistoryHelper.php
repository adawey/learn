<?php


namespace App\Helper;

use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

trait QuizHistoryHelper
{
    /** Get Stored Quiz */
    public function getQuizData($quiz_id){

        /**
         * Get Answers History From
         */
        $answers = $this->getAnswers($quiz_id);
        $dragRightAnswers = $this->getDragRightAnswers($quiz_id);
        $dragCenterAnswers = $this->getDragCenterAnswers($quiz_id);

        return [
            'answers'           => $answers,
            'dragRightAnswers'  => $dragRightAnswers,
            'dragCenterAnswers' => $dragCenterAnswers
        ];
    }

    public function getDragCenterAnswers($quiz_id){
        $dragCenterAnswers0 = DB::table('correct_drag_center_answers')
            ->where('quiz_id', $quiz_id);
        $dragCenterAnswers = DB::table('wrong_drag_center_answers')
            ->where('quiz_id', $quiz_id)
            ->union($dragCenterAnswers0)
            ->get()
            ->groupBy('question_id');
        return $dragCenterAnswers;
    }

    public function getDragRightAnswers($quiz_id){
        $dragRightAnswers0 = DB::table('correct_drag_right_answers')
            ->where('quiz_id', $quiz_id);
        $dragRightAnswers = DB::table('wrong_drag_right_answers')
            ->where('quiz_id', $quiz_id)
            ->union($dragRightAnswers0)
            ->get()
            ->groupBy('question_id');
        return $dragRightAnswers;
    }

    public function getAnswers($quiz_id){
        $answers0 = DB::table('correct_answers')
            ->where('quiz_id', $quiz_id);
        $answers = DB::table('wrong_answers')
            ->where('quiz_id', $quiz_id)
            ->union($answers0)
            ->get()
            ->groupBy('question_id');
        return $answers;
    }

    /** Move answers from active tables */
    public function moveAnswersFromActiveTables($quiz_id, $user_answers){

        $user_answers = $this->groupAnswersByQuestionType($user_answers);

        /** Move Multiple Answer question like [choice, multiple response, fill in blank ] */
        $this->moveCRBQuestionsFromActive($quiz_id, $user_answers);
        /** Move Answer of question like [Drag Right Questions] */
        $this->moveDragRightQuestionFromActive($quiz_id, $user_answers);
        /** Move Answer of question like [Drag Center Questions] */
        $this->moveDragCenterQuestionFromActive($quiz_id, $user_answers);
    }

    /** Move Drag Center Questions */
    public function moveDragCenterQuestionFromActive($quiz_id, $user_answers){
        $answers = DB::table('active_drag_center_answers')
            ->where('quiz_id', $quiz_id)
            ->get();

        $correctAnswers_arr = [];
        $wrongAnswers_arr   = [];
        /** @var filtering for WrongAnswers $wrongAnswers */
        $wrongAnswers = $answers->filter(function($row)use($user_answers){
            $thisAnswer = array_filter($user_answers['drag_center'], function($i)use($row){
                return $i['question_id'] == $row->question_id && $i['user_answer_is_correct'] == 'false';
            });
            return count($thisAnswer) > 0;
        });
        /** @var filtering for CorrectAnswers  $correctAnswers */
        $correctAnswers = $answers->filter(function($row)use($user_answers){
            $thisAnswer = array_filter($user_answers['drag_center'], function($i)use($row){
                return $i['question_id'] == $row->question_id && $i['user_answer_is_correct'] == 'true';
            });
            return count($thisAnswer) > 0;
        });

        /** @var Restructure the data $c */
        foreach($wrongAnswers as $c){
            array_push($wrongAnswers_arr, [
                'quiz_id' => $c->quiz_id,
                'question_id' => $c->question_id,
                'question_drag_center_id' => $c->question_drag_center_id,
                'user_answer' => $c->user_answer,
                'flaged' => $c->flaged,
                'created_at' => $c->created_at,
                'updated_at' => $c->updated_at,
            ]);
        }
        /** @var Restructure the data $c */
        foreach($correctAnswers as $c){
            array_push($correctAnswers_arr, [
                'quiz_id' => $c->quiz_id,
                'question_id' => $c->question_id,
                'question_drag_center_id' => $c->question_drag_center_id,
                'user_answer' => $c->user_answer,
                'flaged' => $c->flaged,
                'created_at' => $c->created_at,
                'updated_at' => $c->updated_at,
            ]);
        }

        /** Insert New Data */
        DB::table('correct_drag_center_answers')
            ->insert($correctAnswers_arr);
        DB::table('wrong_drag_center_answers')
            ->insert($wrongAnswers_arr);
    }

    /** Move Drag Right Questions */
    public function moveDragRightQuestionFromActive($quiz_id, $user_answers){
        $answers = DB::table('active_drag_right_answers')
            ->where('quiz_id', $quiz_id)
            ->get();

        $correctAnswers_arr = [];
        $wrongAnswers_arr   = [];
        /** @var filtering for WrongAnswers $wrongAnswers */
        $wrongAnswers = $answers->filter(function($row)use($user_answers){
            $thisAnswer = array_filter($user_answers['drag_right'], function($i)use($row){
                return $i['question_id'] == $row->question_id && $i['user_answer_is_correct'] == 'false';
            });
            return count($thisAnswer) > 0;
        });
        /** @var filtering for CorrectAnswers  $correctAnswers */
        $correctAnswers = $answers->filter(function($row)use($user_answers){
            $thisAnswer = array_filter($user_answers['drag_right'], function($i)use($row){
                return $i['question_id'] == $row->question_id && $i['user_answer_is_correct'] == 'true';
            });
            return count($thisAnswer) > 0;
        });

        /** @var Restructure the data $c */
        foreach($wrongAnswers as $c){
            array_push($wrongAnswers_arr, [
                'quiz_id' => $c->quiz_id,
                'question_id' => $c->question_id,
                'question_drag_right_id' => $c->question_drag_right_id,
                'question_drag_left_id' => $c->question_drag_left_id,
                'flaged' => $c->flaged,
                'created_at' => $c->created_at,
                'updated_at' => $c->updated_at,
            ]);
        }
        /** @var Restructure the data $c */
        foreach($correctAnswers as $c){
            array_push($correctAnswers_arr, [
                'quiz_id' => $c->quiz_id,
                'question_id' => $c->question_id,
                'question_drag_right_id' => $c->question_drag_right_id,
                'question_drag_left_id' => $c->question_drag_left_id,
                'flaged' => $c->flaged,
                'created_at' => $c->created_at,
                'updated_at' => $c->updated_at,
            ]);
        }

        /** Insert New Data */
        DB::table('correct_drag_right_answers')
            ->insert($correctAnswers_arr);
        DB::table('wrong_drag_right_answers')
            ->insert($wrongAnswers_arr);
    }

    /** Move multiple Choice, multiple Response, fill in Blank */
    public function moveCRBQuestionsFromActive($quiz_id, $user_answers){
        $answers = DB::table('active_answers')
            ->where('quiz_id', $quiz_id)
            ->select(
                'active_answers.quiz_id',
                'active_answers.question_id',
                'active_answers.question_answer_id',
                'active_answers.flaged',
                'active_answers.created_at',
                'active_answers.updated_at'
            )
            ->get();

        $correctAnswers_arr = [];
        $wrongAnswers_arr   = [];
        /** @var filtering for WrongAnswers $wrongAnswers */
        $wrongAnswers = $answers->filter(function($row)use($user_answers){
            $thisAnswer = array_filter($user_answers['multiple'], function($i)use($row){
                return $i['question_id'] == $row->question_id && $i['user_answer_is_correct'] == 'false';
            });
            return count($thisAnswer) > 0;
        });
        /** @var filtering for CorrectAnswers  $correctAnswers */
        $correctAnswers = $answers->filter(function($row)use($user_answers){
            $thisAnswer = array_filter($user_answers['multiple'], function($i)use($row){
                return $i['question_id'] == $row->question_id && $i['user_answer_is_correct'] == 'true';
            });
            return count($thisAnswer) > 0;
        });
        /** @var Restructure the data $c */
        foreach($wrongAnswers as $c){
            array_push($wrongAnswers_arr, [
                'quiz_id' => $c->quiz_id,
                'question_id' => $c->question_id,
                'question_answer_id' => $c->question_answer_id,
                'flaged' => $c->flaged,
                'created_at' => $c->created_at,
                'updated_at' => $c->updated_at,
            ]);
        }
        /** @var Restructure the data $c */
        foreach($correctAnswers as $c){
            array_push($correctAnswers_arr, [
                'quiz_id' => $c->quiz_id,
                'question_id' => $c->question_id,
                'question_answer_id' => $c->question_answer_id,
                'flaged' => $c->flaged,
                'created_at' => $c->created_at,
                'updated_at' => $c->updated_at,
            ]);
        }

        /** Insert New Data */
        DB::table('correct_answers')
            ->insert($correctAnswers_arr);
        DB::table('wrong_answers')
            ->insert($wrongAnswers_arr);

    }

    public function groupAnswersByQuestionType($user_answers){
        $user_answers_ = [
            'multiple'      => [],
            'drag_right'    => [],
            'drag_center'   => [],
        ];

        foreach($user_answers as $question_id => $user_answer){
            switch ($user_answer['question_type_id']){
                case '1':
                    /** Multiple Choice */
                    array_push($user_answers_['multiple'], $user_answer);
                    break;
                case '2':
                    /** Multiple Response */
                    array_push($user_answers_['multiple'], $user_answer);
                    break;
                case '3':
                    /** Matching Right */
                    array_push($user_answers_['drag_right'], $user_answer);
                    break;
                case '4':
                    /** Fill in the Blank */
                    array_push($user_answers_['multiple'], $user_answer);
                    break;
                case '5':
                    /** Matching To Center */
                    array_push($user_answers_['drag_center'], $user_answer);
                    break;
                default:
                    /** do nothing ^_^ */
                    break;
            }
        }
        return $user_answers_;
    }

    /**
     * @param $quiz_id
     * @param $user_answer
     * @return array [answers updated count, answers created count]
     */
    public function storeAnswer($quiz_id, $user_answer){
        switch ($user_answer['question_type_id']){
            case '1':
                /** Multiple Choice */
                $this->storeMultipleChoice($quiz_id, $user_answer);
                break;
            case '2':
                /** Multiple Response */
                $this->storeMultipleResponse($quiz_id, $user_answer);
                break;
            case '3':
                /** Matching Right */
                $this->storeMatchingToRight($quiz_id, $user_answer);
                break;
            case '4':
                /** Fill in the Blank */
                $this->storeMultipleResponse($quiz_id, $user_answer);
                break;
            case '5':
                /** Matching To Center */
                $this->storeMatchingToCenter($quiz_id, $user_answer);
                break;
            default:
                /** do nothing ^_^ */
                break;
        }
    }

    public function storeMatchingToCenter($quiz_id, $user_answer){
        DB::table('active_drag_center_answers')
            ->where([
                'quiz_id'           => $quiz_id,
                'question_id'       => $user_answer['question_id'],
            ])->delete();
        $query = [];
        foreach($user_answer['center'] as $center){
            if($center){
                if($center['left']['selected'] == 'true'){
                    $answer = $center['left']['left_sentence'];
                }else if($center['right']['selected'] == 'true'){
                    $answer = $center['right']['right_sentence'];
                }else{
                    $answer = null;
                }
                array_push($query, [
                    'quiz_id'           => $quiz_id,
                    'question_id'       => $user_answer['question_id'],
                    'question_drag_center_id'   => $center['id'],
                    'user_answer'               => $answer,
                    'flaged'            => $user_answer['flag'] == "false" ? 0: 1,
                    'created_at'        => Carbon::now(),
                    'updated_at'        => Carbon::now(),
                ]);
            }
        }
        DB::table('active_drag_center_answers')
            ->insert($query);

    }

    public function storeMatchingToRight($quiz_id, $user_answer){
        DB::table('active_drag_right_answers')
            ->where([
                'quiz_id'           => $quiz_id,
                'question_id'       => $user_answer['question_id'],
            ])->delete();
        $query = [];
        foreach($user_answer['right'] as $right){
            if($right){
                if(array_key_exists('left', $right)){
                    $left_ = $right['left'] ? $right['left']['id']: null;
                }
                array_push($query, [
                    'quiz_id'           => $quiz_id,
                    'question_id'       => $user_answer['question_id'],
                    'question_drag_right_id'    => $right['id'],
                    'question_drag_left_id'     => $left_,
                    'flaged'            => $user_answer['flag'] == "false" ? 0: 1,
                    'created_at'        => Carbon::now(),
                    'updated_at'        => Carbon::now(),
                ]);
            }

        }
        DB::table('active_drag_right_answers')
            ->insert($query);
    }

    public function storeMultipleResponse($quiz_id, $user_answer){
        DB::table('active_answers')
            ->where([
                'quiz_id'           => $quiz_id,
                'question_id'       => $user_answer['question_id'],
            ])->delete();
        $query = [];
        foreach($user_answer['answers'] as $answer){
            if($answer['selected'] == 'true'){
                array_push($query, [
                    'quiz_id'           => $quiz_id,
                    'question_id'       => $user_answer['question_id'],
                    'question_answer_id'=> $answer['answer_id'],
                    'flaged'            => $user_answer['flag'] == "false" ? 0: 1,
                    'created_at'        => Carbon::now(),
                    'updated_at'        => Carbon::now(),
                ]);
            }
        }
        DB::table('active_answers')
            ->insert($query);
    }

    public function storeMultipleChoice($quiz_id, $user_answer){
        
        if($user_answer['answer'] !== null){
          $answer = DB::table('active_answers')
            ->updateOrInsert([
                'quiz_id'       => $quiz_id,
                'question_id'   => $user_answer['question_id'],
            ], [
                'question_answer_id'    => $user_answer['answer']['answer_id']   ,
                'flaged'                => $user_answer['flag'] == "false" ? 0: 1,
                'created_at'            => Carbon::now(),
                'updated_at'            => Carbon::now(),
            ]);
        }else{
           $answer = DB::table('active_answers')
            ->updateOrInsert([
                'quiz_id'       => $quiz_id,
                'question_id'   => $user_answer['question_id'],
            ], [
                'flaged'                => $user_answer['flag'] == "false" ? 0: 1,
                'created_at'            => Carbon::now(),
                'updated_at'            => Carbon::now(),
            ]);
        }
        
        
    }

    public function getInProgressQuizOrCreateNew($thisUser, $package_id, $topic_type, $topic_id, $part_id, $quiz_data){
        $quiz = (DB::table('quizzes')
            ->where([
                'user_id'       => $thisUser->id,
                'package_id'    => $package_id,
                'topic_type'    => $topic_type,
                'topic_id'      => $topic_id,
                'part_id'       => $part_id ? $part_id: null,
                'complete'      => 0,
            ])
            ->first());

        if(!$quiz){
            $quiz_id = DB::table('quizzes')
                ->insertGetId([
                    'user_id'                   => $thisUser->id,
                    'package_id'                => $package_id,
                    'topic_type'                => $topic_type,
                    'topic_id'                  => $topic_id,
                    'part_id'                   => $part_id ? $part_id: null,
                    'complete'                  => 0,
                    'time_left'                 => $quiz_data['time_left'],
                    'answered_question_number'  => $quiz_data['answered_question_number'],
                    'questions_number'          => $quiz_data['questions_number'],
                    'start_part'                => $quiz_data['start_part'],
                    'created_at'                => Carbon::now(),
                    'updated_at'                => Carbon::now(),
                ]);
            return $quiz_id;
        }
        return ($quiz->id);
    }
}
