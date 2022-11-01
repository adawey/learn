@extends('layouts.layoutV2')

@section('head')
    <link rel="stylesheet" href="{{asset('helper/css/quiz.css')}}">
<style>
    
    /* .fa-star {
        font-size: 120px;
        color: black;
    }
    .checked ,.fa-star:hover{
        color: orange;
    } */
    .radio {
        display: block;
    }
.rate {
    display: flex;
    justify-content: center;
    flex-direction: row-reverse;
    
}
.rate:not(:checked) > input {
    position:absolute;
    top:-9999px;
}
.rate:not(:checked) > label {
    float:right;
    width:1em;
    overflow:hidden;
    white-space:nowrap;
    cursor:pointer;
    font-size:120px;
    color:#ccc;
}
.rate:not(:checked) > label:before {
    content: '★ ';
    
}
.rate > input:checked ~ label {
    color: #ffc700;    
}
.rate:not(:checked) > label:hover,
.rate:not(:checked) > label:hover ~ label {
    color: #deb217;  
}
.rate > input:checked + label:hover,
.rate > input:checked + label:hover ~ label,
.rate > input:checked ~ label:hover,
.rate > input:checked ~ label:hover ~ label,
.rate > label:hover ~ input:checked ~ label {
    color: #c59b08;
}


    .radio {
        display: block;
        min-width: 100%;
        margin: 5px 0;
        border-radius: 9px !important;
        border: 1px solid rgb(204, 204, 204);
        min-height: 40px;
        padding: 12px 0 10px 20px;
        margin-bottom: 10px;
    }

    .active-outline {
        box-shadow: inset 0 0 0 1px white !important;
        background-color: var(--foreground);
        color: var(--primary) !important;
    }
    input[type='checkbox']:hover + .active-outline {
        box-shadow: inset 0 0 0 1px var(--primary) !important;
    }
    input[type='checkbox']:disabled + .active-outline {
        box-shadow: inset 0 0 0 1px white !important;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endsection

@section('content')

<div class="page-content-wrapper">
    
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content" id="app-1">
        <ul class="nav nav-tabs nav-tabs-title nav-tabs-line-title responsive-tabs" id="lineTitleTabsContainer" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" data-bs-toggle="tab" href="#firstLineTitleTab" role="tab" aria-selected="true">Quiz Question Review</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" data-bs-toggle="tab" href="#secondLineTitleTab" role="tab" aria-selected="false">Score Review</a>
            </li>
        </ul>
        <div class="card mb-5">
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane fade active show" id="firstLineTitleTab" role="tabpanel">
                        <div class="container-fluid">
                            <div class="row">

                                <div class="col-md-12 form-1" id="quiz_app_container" style="">

                                    <div id="loading1" style="margin:auto">
                                        <span uk-spinner="ratio: 4.5"></span>
                                    </div>
                                    <div id="quiz"  style="display:none; background-size:cover; background-position: center;">
                                        <div class="row">
                                            <div class="col-md-9"></div>
                                            <div class="col-md-3 ">
                                                <select class="uk-input" v-model="answers_filter" style="margin:10px 0; width:100%;" v-on:change="toggleFilter" id = "toggle_answers">
                                                    <option value="3">{{__('User/quiz.all')}}</option>
                                                    <option value="0">{{__('User/quiz.incorrect')}}</option>
                                                    <option value="1">{{__('User/quiz.correct')}}</option>
                                                    <option value="2">{{__('User/quiz.skipped')}}</option>
                                                    <option value="4">{{__('User/quiz.flaged')}}</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="container-fluid primeQuizViewWM"   id="quiz" style="min-height: 50px; margin:20px 0; ">
                                            Question [@{{ current_question_number }} of @{{ questions.length }}]: @{{ current_question_status }}  <i v-if="current_question_flag">| <b style="color:red;">Flag</b></i>

                                            <!-- Question Body -->
                                            <div class="d-flex flex-row align-content-center align-items-center my-5">
                                                <div class="sw-5 me-4">
                                                    <div class="border border-1 border-primary rounded-xl sw-5 sh-5 text-primary d-flex justify-content-center align-items-center">@{{ current_question_number }}</div>
                                                </div>
                                                <div class="heading mb-0" v-html="current_question_title"></div>
                                            </div>
                                            <div class="row" v-if="current_question_image">
                                                <div class="fig" id="fig" style="margin: 0 0 10px 50px;">
                                                    <img class="img-responsive" v-bind:src="current_question_image" width="550" alt="fig0-0">
                                                </div>
                                            </div>
                                            {{--  MultipleChoice  --}}
                                            <div class="d-flex flex-row align-content-center align-items-center position-relative mb-3"
                                                 v-for="choice,idx in current_question_choices"
                                                 v-if="isMultipleChoice">
                                                <div class="sw-5 me-4 d-flex justify-content-center flex-grow-0 flex-shrink-0">
                                                    <div class="d-flex justify-content-center align-items-center">
                                                        <input type="radio" class="btn-check" :value="choice.id" :id="'item_' +choice.id" v-model="multipleChoiceValue" disabled/>
                                                        <label
                                                                class="btn btn-foreground hover-outline sw-4 sh-4 p-0 rounded-xl d-flex justify-content-center align-items-center stretched-link"
                                                                :for="'item_' +choice.id"
                                                                :style="[choice.id == user_answers[currentQuestionId].answers.filter(row => row.is_correct)[0].answer_id ? {'box-shadow': 'inset 0 0 0 1px green !important'}:  user_answers[currentQuestionId].answer && choice.id == user_answers[currentQuestionId].answer.answer_id ? {'box-shadow': 'inset 0 0 0 1px red !important'}: {}]"
                                                        >
                                                            @{{ alpha[idx] }}
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="mb-0 text-alternate">
                                                    @{{  renderChoice(choice) }}
                                                </div>
                                            </div>

                                            {{--  MultipleResponse  --}}
                                            <div class="d-flex flex-row align-content-center align-items-center position-relative mb-3"
                                                 v-for="choice,idx in current_question_choices"
                                                 v-if="isMultipleResponses">
                                                <div class="sw-5 me-4 d-flex justify-content-center flex-grow-0 flex-shrink-0">
                                                    <div class="d-flex justify-content-center align-items-center">
                                                        <input type="checkbox" class="btn-check"
                                                               :value="choice.id"
                                                               v-model="multipleChoiceValue"
                                                               :id="'item_' +choice.id"
                                                               :disabled="currentSelectedAnswersCount == current_question_correct_answers_required && !user_answers[choice.question_id].answers[choice.id].selected"/>
                                                        <label
                                                                class="btn hover-outline btn-foreground  sw-4 sh-4 p-0 rounded-xl d-flex justify-content-center align-items-center stretched-link"
                                                                :for="'item_' +choice.id"
                                                                :style="[user_answers[currentQuestionId].answers.filter(row => row.is_correct && row.answer_id == choice.id).length ? {'box-shadow':'inset 0 0 0 1px green !important'}: user_answers[currentQuestionId].answers.filter(row => row.answer_id == choice.id && row.selected).length ? {'box-shadow':'inset 0 0 0 1px red !important'}: {}]"
                                                        >
                                                            @{{ alpha[idx] }}
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="mb-0 text-alternate">
                                                    @{{renderChoice(choice)}}
                                                </div>
                                            </div>
{{--                                            <div v-if="isMultipleResponses" class="container-fluid row options" style="font-size: 18px;  min-height: 50px; width: 100%;">--}}
{{--                                                <div v-for="choice in current_question_choices" class="radio" style="padding-right: 0; padding-left: 0;" :style="[seeAnswer ? user_answers[currentQuestionId].answers.filter(row => row.is_correct && row.answer_id == choice.id).length ? {'border-color': 'green'}: user_answers[currentQuestionId].answers.filter(row => row.answer_id == choice.id && row.selected).length ? {'border-color': 'red'}: {}: {}]">--}}
{{--                                                    <label style="display:flex;">--}}
{{--                                                        <input style=" margin: 5px 15px auto 15px; flex: 0 0 17px;" class="uk-checkbox" type="checkbox" disabled--}}
{{--                                                            :id="'item_' +choice.id"--}}
{{--                                                            v-model="multipleResponseValue[choice.id].selected">--}}
{{--                                                        @{{renderChoice(choice)}}--}}
{{--                                                    </label>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
                                            {{--  FillInTheBlank  --}}
                                            <div v-if="isFillInTheBlank" class="container-fluid row options" style="font-size: 18px;  min-height: 50px; width: 100%;">
                                                <div v-for="choice in current_question_choices" class="radio" :style="[user_answers[currentQuestionId].answers.filter(row => row.is_correct && row.answer_id == choice.id).length ? {'border-color': 'green'}: user_answers[currentQuestionId].answers.filter(row => row.answer_id == choice.id && row.selected).length ? {'border-color': 'red'}: {}]">
                                                    <label style="display:flex; padding: 0 10px;">
                                                        @{{renderChoice(choice)}}
                                                        {{--                                                @{{language == 'ar' ? choice.transcodes.answer: choice.answer}}--}}
                                                    </label>
                                                </div>
                                            </div>
                                            {{-- Matching To Right --}}
                                            <div v-if="isMatchingToRight" class="container-fluid row options" style="font-size: 18px;  min-height: 50px; width: 100%;">
                                                <div class="match-right">
                                                    <div class="right">
                                                        <h4>Correct Answers</h4>
                                                        <div v-for="draggable in user_answers[currentQuestionId].right" v-if="draggable" class="empty" :data-right-id="draggable.id" data-max="2">
                                                            <div class="m-2">
                                                                @{{ renderDragRightChoice(draggable, 'right_sentence') }}
                                                                {{--                                                        @{{ language == 'ar' ? draggable.transcodes.right_sentence: draggable.right_sentence }}--}}
                                                            </div>
                                                            <div class="fill" draggable="true">
                                                                <div class="radio" style="padding-right: 0; padding-left: 0;">
                                                                    <label style="display:flex; padding: 0 10px; cursor: move;">
                                                                        @{{ renderDragRightChoice(draggable, 'left_sentence') }}
                                                                        {{--                                                                @{{ language == 'ar' ? draggable.transcodes.left_sentence: draggable.left_sentence }}--}}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="right">
                                                        <h4>Your Answers</h4>
                                                        <div v-for="draggable in user_answers[currentQuestionId].right" v-if="draggable" class="empty" :data-right-id="draggable.id" data-max="2">
                                                            <div class="m-2">
                                                                @{{ renderDragRightChoice(draggable, 'right_sentence') }}
                                                                {{--                                                        @{{ language == 'ar' ? draggable.transcodes.right_sentence: draggable.right_sentence }}--}}
                                                            </div>
                                                            <div v-if="draggable.left" :data-left-id="draggable.left.id" class="fill" draggable="true">
                                                                <div class="radio" style="padding-right: 0; padding-left: 0;">
                                                                    <label style="display:flex; padding: 0 10px; cursor: move;">
                                                                        @{{ renderDragCenterChoice(draggable, 'left', 'left_sentence') }}
                                                                        {{--                                                                @{{ language == 'ar' ? draggable.left.transcodes.left_sentence: draggable.left.left_sentence }}--}}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Matching To Center --}}
                                            <div v-if="isMatchingToCenter" class="container-fluid row options" style="font-size: 18px;  min-height: 50px; width: 100%;">
                                                <div class="match-center">
                                                    <div v-for="question in user_answers[currentQuestionId].center" v-if="question" class="match-row">
                                                        <div class="empty" :data-accept-id="question.id" data-position="left">
                                                            <div class="fill" v-if="!question.left.selected" :data-id="question.id" data-position="left" draggable="true">
                                                                <div class="radio" style="padding-right: 0; padding-left: 0;">
                                                                    <label style="display:flex; padding: 0 10px; cursor: move;">
                                                                        @{{ renderDragCenterChoice(question, 'left', 'left_sentence') }}
                                                                        {{--                                                                @{{ language == 'ar' ? question.left.transcodes.left_sentence: question.left.left_sentence  }}--}}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="empty" id="center-item" data-max="2" :data-accept-id="question.id" data-position="center">
                                                            <div class="m-2">
                                                                @{{ renderDragCenterChoice(question, 'center_sentence', null) }}
                                                                {{--                                                        @{{ language == 'ar' ? question.transcodes.center_sentence: question.center_sentence  }}--}}
                                                            </div>
                                                            <div class="fill" v-if="question.left.selected" :data-id="question.id" data-position="left" draggable="true">
                                                                <div class="radio" style="padding-right: 0; padding-left: 0;" :style="[question.left.left_sentence == question.correct_sentence ? {'border-color': 'green'}: {'border-color': 'red'}]">
                                                                    <label style="display:flex; padding: 0 10px; cursor: move;">
                                                                        @{{ renderDragCenterChoice(question, 'left', 'left_sentence') }}
                                                                        {{--                                                                @{{ language == 'ar' ? question.left.transcodes.left_sentence: question.left.left_sentence  }}--}}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="fill" v-if="question.right.selected" :data-id="question.id" data-position="right" draggable="true">
                                                                <div class="radio" style="padding-right: 0; padding-left: 0;" :style="[question.right.right_sentence == question.correct_sentence ? {'border-color': 'green'}: {'border-color': 'red'}]">
                                                                    <label style="display:flex; padding: 0 10px; cursor: move;">
                                                                        @{{ renderDragCenterChoice(question, 'right', 'right_sentence') }}
                                                                        {{--                                                                @{{ language == 'ar' ? question.right.transcodes.right_sentence: question.right.right_sentence  }}--}}
                                                                    </label>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="empty" :data-accept-id="question.id" data-position="right">
                                                            <div class="fill" v-if="!question.right.selected" :data-id="question.id" data-position="right" draggable="true">
                                                                <div class="radio" style="padding-right: 0; padding-left: 0;">
                                                                    <label style="display:flex; padding: 0 10px; cursor: move;">
                                                                        @{{ renderDragCenterChoice(question, 'right', 'right_sentence') }}
                                                                        {{--                                                                @{{ language == 'ar' ? question.right.transcodes.right_sentence: question.right.right_sentence  }}--}}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="container-fluid">
                                                    <p>
                                                        <b>{{__('User/quiz.explanation')}}</b> <br>
                                                        <b v-html="current_question_feedback"></b>
                                                    </p>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="row">
                                                <div class="col-md-2 {{app()->getLocale() == 'ar' ? 'offset-md-8': ''}}" style="  min-height: 30px; font-size: 18px;">
                                                    <a id="prev" v-on:click="prev">
                                                        <b>  <i class="fa fa-angle-{{app()->getLocale() == 'ar' ? 'right': 'left'}}" style="font-weight: bold; font-size: 21px; padding-right:5px;"></i> {{__('User/quiz.back')}}</b>
                                                    </a>
                                                </div>


                                                <div class="col-md-2 {{app()->getLocale() == 'ar' ? '':'offset-md-8'}}" style="  min-height: 30px; text-align: right; font-size: 18px;margin-bottom: 15px;">
                                                    <a id="next" v-on:click="next">
                                                        <b> {{__('User/quiz.next')}} <i class="fa fa-angle-{{app()->getLocale() == 'ar' ? 'left': 'right'}}" style="font-weight: bold; font-size: 21px; padding-left:5px;"></i></b>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="secondLineTitleTab" role="tabpanel">
                        <div class="container result"  style="display:none;" >
                            <h2>
                                {{__('User/quiz.your-score')}}: @{{overallScore}} %
                            </h2>
                            <div class="row my-1">
                                <p v-html="ScoreMsg"></p>
                            </div>

                            <div id="menu1">
                                <center>
                                    <h3>{{__('User/quiz.score-analysis')}}</h3>
                                    <div class="row">
                                        <div class="col-md-5"></div>
                                        <div class="col-md-2">
                                            {{--                                                    @if($quiz)--}}
                                            {{--                                                        <a class="btn btn-primary" v-if="!cx_quiz" style="color:white;" href="{{route('QuizHistory.show', $quiz->id)}}">{{__('User/quiz.review')}} </a>--}}
                                            {{--                                                    @else--}}
                                            {{--                                                        <a class="btn btn-primary" style="color:white;" v-if="saved_quiz_id != 0 && !cx_quiz" v-on:click = "showReview">{{__('User/quiz.review')}}</a>--}}
                                            {{--                                                    @endif--}}
                                        </div>
                                    </div>
                                </center>
                                <h3 style="color:#5bbae3; text-decoration:underline;" >
                                    Results By Chapter
                                </h3>
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <th>Chapter</th>
                                    <th>{{__('User/quiz.no-questions')}}</th>
                                    <th>{{__('User/quiz.correct-answers')}}</th>
                                    <th>%{{__('User/quiz.correct')}}</th>
                                    </thead>
                                    <tbody id="resultByChapter">
                                    </tbody>
                                </table>
                                <br>
                                <h3 style="color:#5bbae3; text-decoration:underline;" >
                                    Results By Question
                                </h3>
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <th>{{__('User/quiz.question-no')}}</th>
                                    <th>Chapter</th>
                                    <th>{{__('User/quiz.score')}}</th>
                                    </thead>
                                    <tbody id="resultByProcess">
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>





    </div>
</div>

@endsection

@section('jscode')
    <script type="text/javascript">
        $(document).ready(function(){
            document.addEventListener('contextmenu', event => event.preventDefault());

            $(window).keyup(function(e){
                if(e.keyCode == 44){
                    $(".page-content").hide();
                    $(".prsc-msg").show();


                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax ({
                        type: 'GET',
                        url: '{{ route('ScreenShot') }}',
                        success: function(res){

                        },
                        error: function(res){
                            console.log('Error:', res);
                        }
                    });

                }
            });
            // app.markExam();
        });
    </script>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <script src="https://unpkg.com/sweetalert2@7.8.2/dist/sweetalert2.all.js"></script>
    <script src="{{asset('helper/js/jQuery.tagify.min.js')}}"></script>
    @if(env('APP_ENV') == 'local')
        <script src="{{asset('helper/js/vue-dev.js')}}"></script>
    @else
        <script src="{{asset('helper/js/vue-prod.min.js')}}"></script>
    @endif

    <script>
        quizHistoryAttr = {
            language: '{{\Session('locale')}}',
            quiz_id: '{{$quiz->id}}',
            base_url: '{{url('')}}',
            api: {
                csrf: '{{csrf_token()}}',
                quizHistory : '{{route('QuizHistory.load')}}',
                quizHistoryFeedback: '{{route('QuizHistory.score.feedback')}}',
            },
            translation: {
                overallPerformance  : '{{__('User/quiz.overall-performance')}}',
                passed              : '{{__('User/quiz.passed')}}',
                failed              : '{{__('User/quiz.failed')}}',
                needImprove         : '{{__('User/quiz.need-improve')}}',
                belowTarget         : '{{__('User/quiz.below-target')}}',
                target              : '{{__('User/quiz.target')}}',
                aboveTarget         : '{{__('User/quiz.above-target')}}',
            },
        };
    </script>
    <script src="{{asset('helper/js/quizHistory-V0.2.js')}}"></script>



@endsection


