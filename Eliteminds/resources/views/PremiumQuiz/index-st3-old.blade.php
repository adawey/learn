<!doctype html>
<html lang="en" @if(app()->getLocale()  == 'ar') dir="rtl" @endif>
<head>
    <!-- Basic Page Needs
    ================================================== -->
    <title>{{$package_name}}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}" />
    <!-- CSS
    ================================================== -->

    @if(app()->getLocale() == 'ar')
        <link rel="stylesheet" href="{{asset('assetsV2/css/style-rtl.css')}}">
        <link rel="stylesheet" href="{{asset('assetsV2/css/night-mode.css')}}">
        <link rel="stylesheet" href="{{asset('assetsV2/css/framework-rtl.css')}}">
        <link rel="stylesheet" href="{{asset('assetsV2/css/bootstrap.css')}}">
    @else
        <link rel="stylesheet" href="{{asset('assetsV2/css/style.css')}}">
        <link rel="stylesheet" href="{{asset('assetsV2/css/night-mode.css')}}">
        <link rel="stylesheet" href="{{asset('assetsV2/css/framework.css')}}">
        <link rel="stylesheet" href="{{asset('assetsV2/css/bootstrap.css')}}">
    @endif
    @if(app()->getLocale() == 'ar')
        <style>
            @font-face {
                font-family: 'Tajawal';
                src: URL('{{asset('fonts/tajawal/Tajawal-Regular.ttf')}}') format('truetype');
            }
            .section-title .subtitle {
                letter-spacing: 0 !important;
            }
            html, body, span{
                font-family: Tajawal !important;
            }
        </style>
    @endif
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- icons
    ================================================== -->
    <link rel="stylesheet" href="{{asset('assetsV2/css/icons.css')}}">
    <link rel="stylesheet" href="{{asset('helper/css/tagify.css')}}">
    <link rel="stylesheet" href="{{asset('css/custom.css')}}">
    <link rel="stylesheet" href="{{asset('helper/css/quiz.css')}}">


</head>


<body class="">
<!-- Wrapper -->
<div id="wrapper">
    
    <div class="container " id="prsc-msg" style=" display:none; background: #fff; color: red; padding: 20px; min-width:100px; min-height: 40px; margin: 30px auto;">
        <div class="row" style="padding: 20px;">
            <b>{{__('User/quiz.content-protected')}}</b>
            <br/><br/>
            <p>
                <b>{{__('User/quiz.note')}}:</b>
                {{__('User/quiz.statement-1')}}
                <br/>
                {{__('User/quiz.statement-2')}}
                <br/>
                {{__('User/quiz.statement-3')}}
            </p>   

        </div>
    </div>
    <div class="course-layouts" id="app-1">

        <div class="course-content bg-dark" style="order: 1;">
            <div class="course-header" @if(app()->getLocale() == 'ar') style="padding-left: 0 !important;" @endif>

                <h4 class="text-white">

                    @if($topic == 'mistake')
                        @if($topic_id == 1)
                            {{__('User/quiz.chapters-mistakes')}}
                        @elseif($topic_id == 2)
                            {{__('User/quiz.processes-mistakes')}}
                        @elseif($topic_id == 3)
                            {{__('User/quiz.exam-mistakes')}}
                        @endif
                    @else
                        @if(isset($currentTopic))
                            {{ $currentTopic->name }}
                        @endif
                    @endif
                </h4>

                <div style="display: flex; align-items: center; justify-content:center;">
                    @if(isset($package))
                    <a class="dont-hover" href="#rating-form" uk-toggle>
                        <i class="icon-line-awesome-star-o btns" @if($package->userRatePackage) style="color:gold;" @endif > </i>
                        @if(!$package->userRatePackage)
                            {{__('User/quiz.leave-rating')}}
                        @else
                            {{__('User/quiz.update-rating')}}
                        @endif
                    </a>
                    <div id="rating-form" uk-modal>
                        <div class="uk-modal-dialog uk-modal-body" @if(app()->getLocale() == 'ar') style="text-align: right !important;" @endif>
                            <h2 class="uk-modal-title">{{__('User/quiz.rating-question')}}</h2>
                            <p>
                                <center>
                            <p style="color:#333; font-size: 20px; font-weight: 10; min-height: 30px;">
                                @{{rate_sentance}}
                            </p>

                            <div class="row rate" style=" min-height: 50px; margin: 0px 0 15px 0;">

                                <input type="radio"  id="star5" v-model="rate_value" v-on:change="rate"  name="rate" value="5" />
                                <label for="star5" title="text" @mouseover="rate_state('{{__('User/quiz.rate-statement-5')}}')"></label>


                                <input type="radio"  id="star4" v-model="rate_value" v-on:change="rate"  name="rate" value="4" />
                                <label for="star4" title="text" @mouseover="rate_state('{{__('User/quiz.rate-statement-4')}}')"></label>


                                <input type="radio" id="star3"  v-model="rate_value" v-on:change="rate"  name="rate" value="3" />
                                <label for="star3" title="text" @mouseover="rate_state('{{__('User/quiz.rate-statement-3')}}')"></label>


                                <input type="radio"  id="star2" v-model="rate_value" v-on:change="rate"  name="rate" value="2" />
                                <label for="star2" title="text" @mouseover="rate_state('{{__('User/quiz.rate-statement-2')}}')"></label>


                                <input type="radio" id="star1" v-model="rate_value" v-on:change="rate"  name="rate" value="1" />
                                <label for="star1" title="text" @mouseover="rate_state('{{__('User/quiz.rate-statement-1')}}')"></label>

                            </div>

                            <div class="row">
                                <div class="col-md-12" id="rateTextBox" @if(!$package->userRatePackage) style="display:none;" @endif >
                                    <div class="form-group">
                                        <textarea v-model="user_review" placeholder="{{__('User/quiz.tell-us-something')}}" cols="30" rows="10" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                            </center>
                            </p>
                            <p class="uk-text-right">
                                <button class="uk-button uk-button-default uk-modal-close" type="button">{{__('User/quiz.cancel')}}</button>
                                <a v-on:click="post_review" class="uk-modal-close uk-button uk-button-default" type="button">{{__('User/quiz.submit')}}</a>
                            </p>
                        </div>
                    </div>
                    @endif
                    <a class="dont-hover" style="color: white; margin: 0 10px;" href="#">
                        <i class="icon-material-outline-language btns"></i>
                    </a>
                    <div class="dropdown-option-nav " uk-dropdown="pos: bottom-right ;mode : click" style="min-width:220px !important;">
                        <ul>
                            <li>
                                <a href="{{ route('set.localization', 'en') }}">
                                    English
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('set.localization', 'ar') }}">
                                    العربية
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('set.localization', 'fr') }}">
                                    Français
                                </a>
                            </li>
                        </ul>
                    </div>
                    <a class="dont-hover" style="color: white; margin: 0 10px;" href="{{route('user.dashboard')}}" uk-tooltip="title: {{__('User/quiz.go-dashboard')}}">
                        <i class="icon-material-outline-dashboard"></i>
                    </a>

                    <a href="#" class="uk-visible@s" uk-toggle="target: .course-layouts; cls: course-sidebar-collapse">
                        <i class="btns icon-feather-chevron-right"></i>
                    </a>

                </div>

            </div>
            <div class="course-content-inner" style="max-width:95% !important; min-height: auto; height: auto !important;">

                <!--
                **************************
                **************************
                -->
                <div class="form-1" id="quiz_app_container" style="border: 1px solid #eef1f5 !important;">
                    {{-- optimize Quiz Questions Form --}}
                    {{--
                        *******************************
                        *******************************
                        *******************************
                        *******************************
                        *******************************
                        *******************************
                        --}}
                    <form @submit.prevent="optimizeQuiz" id="optimizeForm"  style="display:block;">
                        <div class="optimization_form" style="padding-top: 16px; padding-left: 50px; width:100%; ">

                            <div>
                                <div class="row">

                                    <div class="uk-child-width-1-3@m uk-grid-small uk-grid-match" uk-grid style="margin-bottom: 20px;">
                                        <div style="min-width:15vw;">
                                            <div class="uk-card uk-card-primary uk-card-body flex-center-i" >
                                                <h4 class="uk-card-title">@{{Math.round(max_questions_num*76.7/60)}}</h4>
                                                <p class="white-color">{{__('User/quiz.min')}}</p>
                                            </div>
                                        </div>
                                        <div style="min-width:15vw; " >
                                            <div class="uk-card uk-card-primary uk-card-body flex-center-i">
                                                <h4 class="uk-card-title">@{{max_questions_num}}</h4>
                                                <p class="white-color">{{__('User/quiz.questions')}}</p>
                                            </div>
                                        </div>
                                        <div style="min-width:15vw; ">
                                            <div class="uk-card uk-card-primary uk-card-body flex-center-i">
                                                <h4 class="uk-card-title">75%</h4>
                                                <p class="white-color">{{__('User/quiz.score-required')}}</p>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">

                                    <h4>{{__('User/quiz.instructions')}}: </h4>
                                    <ul type="circle" style="overflow: auto; max-width: 800px; text-align: {{\Session('locale') == 'ar'? 'right': 'left'}};">
                                        <li>{{__('User/quiz.instructions-1')}}</li>
                                        <li>{{__('User/quiz.instructions-2')}}</li>
                                        <li>{{__('User/quiz.instructions-3')}}</li>
                                        <li>{{__('User/quiz.instructions-4')}}</li>
                                        <li>{{__('User/quiz.instructions-5')}}</li>
                                        <li>{{__('User/quiz.instructions-6')}}</li>
                                    </ul>
                                </div>
                            </div>








                            <div class="row">
                                <div class="form-group" style="display:flex; justify-content: center; align-items: center;">
                                    @if($quiz)
                                        @if($quiz->complete == 1)
                                            <a v-on:click="optimizeQuiz" class="btn btn-primary" id="startQuiz">{{__('User/quiz.review')}}</a>
                                        @else
                                            <a v-on:click="optimizeQuiz" class="btn btn-primary" id="startQuiz">{{__('User/quiz.continue')}}</a>
                                        @endif
                                    @else

                                        <a v-on:click="optimizeQuiz" class="btn btn-primary white-color" id="startQuiz">{{__('User/quiz.start-test')}}</a>
                                    @endif
                                    <a  class="btn btn-warning" style="display:none;" id="continueQuiz" v-on:click="continueQuize"  style="margin-top:23px;" >{{__('User/quiz.continue')}}</a>
                                    {{-- <a  class="btn btn-success" style="display:none;" id="saveforlateron" v-on:click="saveForLaterOn"  style="margin-top:23px;" >Save</a> --}}


                                </div>
                            </div>
                        </div>

                        <div class="row saving_form" style="display:none; margin: 40px 0;">
                            {{__('User/quiz.answers-being-saved')}}
                        </div>
                    </form>

                    <div id="quizLoading" style="margin: auto; display:none;">
                        <span uk-spinner="ratio: 4.5"></span>
                    </div>
                    {{-- Quiz View --}}
                    {{--
                        *******************************
                        *******************************
                        *******************************
                        *******************************
                        *******************************
                        *******************************
                        --}}

                    <div class="container-fluid primeQuizViewWM" id="quiz" style="min-height: 50px; margin:20px 0; display:none; background-image: url('{{asset('img/wm.png')}}'); background-size:cover;">

                        <div class="row" style=" ">
                            <div class="col-md-3" style="">
                                <div style="display:flex;">
                                    <i class="fa fa-hourglass-end"></i>
                                    <div style="margin: 0 5px;">{{__('User/quiz.time-remaining')}}</div>
                                    <div style="color: #333;  font-weight: lighter; padding: 0 5px;" id="timer">00:00</div>
                                </div>

                                <div style="display:flex;">
                                    <strong>@{{current_question_number}} </strong> <div style="margin: 0 5px;">{{__('User/quiz.of')}}</div>  @{{question_number}}
                                </div>
                                <div style="display:flex;">
                                    <i class="fa fa-flag" style="cursor:pointer;" :style="[ current_question_flag ? {'color': 'red'}: {'color': 'gray'}]" @click="toggleFlag" > {{__('User/quiz.flag-for-review')}}</i>
                                </div>

                            </div>

                            <div class="col-md-7" style="display:flex; justify-content: center; flex-direction: column; align-items: center;">
                                <a class="btn" type="button" style="background-color: #ccc; max-width: 200px; margin-bottom: 10px;" id="toggleCorrectAnswer" v-on:click="openWhiteBoard">
                                    <i class="fa fa-edit"></i> {{__('User/quiz.white-board')}}
                                </a>
                                <div class="progress" style="border: 1px solid #ccc; min-width: 100%;">
                                    <div class="progress-bar progress-bar-striped" id="progress_bar" role="progressbar" style="width: 10%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">60%</div>
                                </div>
                            </div>


                            <div class="col-md-2" style="text-align: center; padding:0 !important;">
                                <a class="btn" type="button" style="background-color: #ccc; margin-bottom: 10px;" id="toggleCorrectAnswer" v-on:click="openCalc">
                                    <i class="fa fa-calculator"></i> {{__('User/quiz.calculator')}}
                                </a>
                                <div style="display: flex;justify-content: center;gap: 30px;">
                                    <a class="aElement" id="pause" v-on:click="stopTimer_pause" style="margin-right:15px;">
                                        <i class="fa fa-pause" style=""></i>
                                    </a>
                                    <a class="aElement" v-on:click="Confirmation">
                                        <i class="fa fa-stop" style=""></i>
                                    </a>
                                </div>

                            </div>

                        </div>


                        <hr style="margin-top:0">
                        <!-- Rating  -->



                        <!-- Question Body -->
                        <div class="row" style=" font-size: 21px; border-radius: 10px !important; text-align:center; background-color: #e8ebef; font-weight:bold; margin: 10px 0 20px 0;">
                            <p class="col-md-12" style="margin: 8px 0; padding: 0 10px;" v-html="current_question_title"></p>
                        </div>
                        <div class="row" v-if="current_question_image">
                            <div class="fig" id="fig" style="margin: 0 0 10px 50px;">
                                <img class="img-responsive" v-bind:src="current_question_image" width="550" alt="fig0-0">
                            </div>
                        </div>
                        {{--  MultipleChoice  --}}
                        <div v-if="isMultipleChoice" class="container-fluid row options" style="font-size: 18px;  min-height: 50px; width: 100%;">
                            <div v-for="choice in current_question_choices" class="radio" style="padding-right: 0; padding-left: 0;" :style="[seeAnswer ? choice.id == user_answers[currentQuestionId].answers.filter(row => row.is_correct)[0].answer_id ? {'border-color': 'green'}:  user_answers[currentQuestionId].answer && choice.id == user_answers[currentQuestionId].answer.answer_id ? {'border-color': 'red'}: {} : {}]">
                                <label style="display:flex;"><input style=" margin: 5px 15px auto 15px; flex: 0 0 17px;" class="uk-radio" type="radio" @click="applyUserChoice(choice.id, choice.question_id)" :value="choice.id" :id="'item_' +choice.id" v-model="multipleChoiceValue">
                                    @{{renderChoice(choice)}}
                                </label>
                            </div>
                        </div>
                        {{--  MultipleResponse  --}}
                        <div v-if="isMultipleResponses" class="container-fluid row options" style="font-size: 18px;  min-height: 50px; width: 100%;">
                            <div v-for="choice in current_question_choices" class="radio" style="padding-right: 0; padding-left: 0;" :style="[seeAnswer ? user_answers[currentQuestionId].answers.filter(row => row.is_correct && row.answer_id == choice.id).length ? {'border-color': 'green'}: user_answers[currentQuestionId].answers.filter(row => row.answer_id == choice.id && row.selected).length ? {'border-color': 'red'}: {}: {}]">
                                <label style="display:flex;"><input style=" margin: 5px 15px auto 15px; flex: 0 0 17px;" class="uk-checkbox" type="checkbox"
                                    :disabled="currentSelectedAnswersCount == current_question_correct_answers_required && !user_answers[choice.question_id].answers[choice.id].selected"
                                    @click="applyUserChoice(choice.id, choice.question_id)"
                                    :id="'item_' +choice.id"
                                    v-model="multipleResponseValue[choice.id].selected">
                                    @{{renderChoice(choice)}}
                                </label>
                            </div>
                        </div>
                        {{--  FillInTheBlank  --}}
                        <div v-if="isFillInTheBlank" class="container-fluid row options" style="font-size: 18px;  min-height: 50px; width: 100%;">
                            <div v-for="choice in current_question_choices" class="radio" style="padding-right: 0; padding-left: 0;" :style="[seeAnswer ? user_answers[currentQuestionId].answers.filter(row => row.is_correct && row.answer_id == choice.id).length ? {'border-color': 'green'}: user_answers[currentQuestionId].answers.filter(row => row.answer_id == choice.id && row.selected).length ? {'border-color': 'red'}: {}: {}]">
                                <label style="display:flex; padding: 0 10px;">
                                    @{{renderChoice(choice)}}
                                </label>
                            </div>
                            <input id="fillInTheBlank" placeholder="Write Answer">
                        </div>
                        {{-- Matching To Right --}}
                        <div v-if="isMatchingToRight" class="container-fluid row options" style="font-size: 18px;  min-height: 50px; width: 100%;">
                            <div class="match-right">
                                <div class="left">
                                    <div class="empty">
                                        <div v-for="draggable in [...user_answers[currentQuestionId].left].sort(function() { return 0.5 - Math.random() })" v-if="draggable" :data-left-id="draggable.id" class="fill" draggable="true">
                                            <div  class="radio" style="padding-right: 0; padding-left: 0;">
                                                <label style="display:flex; padding: 0 10px; cursor: move;">
                                                    @{{ renderDragRightChoice(draggable, 'left_sentence') }}
{{--                                                    @{{ language == 'en' ? draggable.left_sentence : draggable.transcodes['left_sentence_'+language] }}--}}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="right" style="margin-top: 5px;">
                                    <div v-for="draggable in user_answers[currentQuestionId].right" v-if="draggable" class="empty" :data-right-id="draggable.id" data-max="2">
                                        <div class="m-2">
                                            @{{ renderDragRightChoice(draggable, 'right_sentence') }}
{{--                                            @{{ language == 'en' ? draggable.right_sentence: draggable.transcodes['right_sentence_'+language] }}--}}
                                        </div>
                                        <div v-if="draggable.left" :data-left-id="draggable.left.id" class="fill" draggable="true">
                                            <div class="radio" style="padding-right: 0; padding-left: 0;">
                                                <label style="display:flex; padding: 0 10px; cursor: move;">
                                                    @{{ renderDragRightChoice(draggable, 'left_sentence') }}
{{--                                                    @{{ language == 'en' ? draggable.left.left_sentence: draggable.left.transcodes['left_sentence_'+language] }}--}}
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
                                            <div class="radio" style="padding-right: 0; padding-left: 0;" :style="[seeAnswer ? question.left.left_sentence == question.correct_sentence ? {'border-color': 'green'}: {} : {}]">
                                                <label style="display:flex; padding: 0 10px; cursor: move;">
                                                    @{{ renderDragCenterChoice(question, 'left', 'left_sentence') }}
{{--                                                    @{{ language == 'en' ? question.left.left_sentence: question.left.transcodes['left_sentence_'+language]  }}--}}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="empty" id="center-item" data-max="2" :data-accept-id="question.id" data-position="center">
                                        <div class="m-2">
                                        @{{ renderDragCenterChoice(question, 'center_sentence', null) }}
{{--                                        @{{ language == 'en' ? question.center_sentence: question.transcodes['center_sentence_'+language]  }}--}}
                                        </div>
                                        <div class="fill" v-if="question.left.selected" :data-id="question.id" data-position="left" draggable="true">
                                            <div class="radio" style="padding-right: 0; padding-left: 0;" :style="[seeAnswer ? question.left.left_sentence == question.correct_sentence ? {}: {'border-color': 'red'} : {}]">
                                                <label style="display:flex; padding: 0 10px; cursor: move;">
                                                    @{{ renderDragCenterChoice(question, 'left', 'left_sentence') }}
{{--                                                    @{{ language == 'en' ? question.left.left_sentence: question.left.transcodes['left_sentence_'+language] }}--}}
                                                </label>
                                            </div>
                                        </div>
                                        <div class="fill" v-if="question.right.selected" :data-id="question.id" data-position="right" draggable="true">
                                            <div class="radio" style="padding-right: 0; padding-left: 0;" :style="[seeAnswer ? question.right.right_sentence == question.correct_sentence ? {} : {'border-color': 'red'} : {}]">
                                                <label style="display:flex; padding: 0 10px; cursor: move;">
                                                    @{{ renderDragCenterChoice(question, 'right', 'right_sentence') }}
{{--                                                    @{{ language == 'en' ? question.right.right_sentence: question.right.transcodes['right_sentence_'+language] }}--}}
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="empty" :data-accept-id="question.id" data-position="right">
                                        <div class="fill" v-if="!question.right.selected" :data-id="question.id" data-position="right" draggable="true">
                                            <div class="radio" style="padding-right: 0; padding-left: 0;" :style="[seeAnswer ? question.right.right_sentence == question.correct_sentence ? {'border-color': 'green'}: {} : {}]">
                                                <label style="display:flex; padding: 0 10px; cursor: move;">
                                                    @{{ renderDragCenterChoice(question, 'right', 'right_sentence') }}
{{--                                                    @{{ language == 'en' ? question.right.right_sentence: question.right.transcodes['right_sentence_'+language] }}--}}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="modal" id="flagedQuestion">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">{{__('User/quiz.marked-questions')}}: </h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="modal-body flaged_body">
                                            <div class="flagedItem" data-dismiss="modal" v-on:click="push_question(i[1].question_number)" v-for='i in Object.entries(user_answers).filter(function(ele){ return ele[1].flag; })'>@{{i[1].question_number}}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal" id="translatedQuestion">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">

                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">{{__('User/quiz.translate')}}: </h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="modal-body flaged_body">
                                            <div class="w-100">
                                                <ul class="uk-flex-center" uk-tab>
                                                    <li v-for="i, index in languages.filter(x => x.code != language)" :class="{'uk-active': index == 0}">
                                                        <a href="#">@{{ i.language }}</a>
                                                    </li>
                                                </ul>
                                                <ul class="uk-switcher uk-margin">
                                                    <li v-for="lang, idx in languages.filter(x => x.code != language)" v-if="getCurrentTitle(lang.code)">

                                                        <div class="row" style=" font-size: 21px; border-radius: 10px !important; text-align:center; background-color: #e8ebef; font-weight:bold; margin: 10px 0 20px 0; width: 100%;">
                                                            <p class="col-md-12" style="margin: 8px 0; padding: 0 10px;" v-html="getCurrentTitle(lang.code)"></p>
                                                        </div>
                                                        <div class="row" v-if="current_question_image">
                                                            <div class="fig" id="fig" style="margin: 0 0 10px 50px;">
                                                                <img class="img-responsive" v-bind:src="current_question_image" width="550" alt="fig0-0">
                                                            </div>
                                                        </div>
                                                        {{--  MultipleChoice  --}}
                                                        <div v-if="isMultipleChoice" class="container-fluid row options" style="font-size: 18px;  min-height: 50px; width: 100%;">
                                                            <div v-for="choice in current_question_choices" class="radio" style="padding-right: 0; padding-left: 0;" :style="[seeAnswer ? choice.id == user_answers[currentQuestionId].answers.filter(row => row.is_correct)[0].answer_id ? {'border-color': 'green'}:  user_answers[currentQuestionId].answer && choice.id == user_answers[currentQuestionId].answer.answer_id ? {'border-color': 'red'}: {} : {}]">
                                                                <label style="display:flex; padding: 0 10px;" :dir="lang.code == 'ar' ? 'rtl': 'ltr'">@{{lang.code == 'en' ? choice.answer : choice.transcodes['answer_'+lang.code]}}</label>
                                                            </div>
                                                        </div>
                                                        {{--  MultipleResponse  --}}
                                                        <div v-if="isMultipleResponses" class="container-fluid row options" style="font-size: 18px;  min-height: 50px; width: 100%;">
                                                            <div v-for="choice in current_question_choices" class="radio" style="padding-right: 0; padding-left: 0;" :style="[seeAnswer ? user_answers[currentQuestionId].answers.filter(row => row.is_correct && row.answer_id == choice.id).length ? {'border-color': 'green'}: user_answers[currentQuestionId].answers.filter(row => row.answer_id == choice.id && row.selected).length ? {'border-color': 'red'}: {}: {}]">
                                                                <label style="display:flex; padding: 0 10px;" :dir="lang.code == 'ar' ? 'rtl': 'ltr'">
                                                                    @{{lang.code == 'en' ? choice.answer : choice.transcodes['answer_'+lang.code]}}
                                                                </label>
                                                            </div>
                                                        </div>
                                                        {{--  FillInTheBlank  --}}
                                                        <div v-if="isFillInTheBlank" class="container-fluid row options" style="font-size: 18px;  min-height: 50px; width: 100%;">
                                                            <div v-for="choice in current_question_choices" class="radio" style="padding-right: 0; padding-left: 0;" :style="[seeAnswer ? user_answers[currentQuestionId].answers.filter(row => row.is_correct && row.answer_id == choice.id).length ? {'border-color': 'green'}: user_answers[currentQuestionId].answers.filter(row => row.answer_id == choice.id && row.selected).length ? {'border-color': 'red'}: {}: {}]">
                                                                <label style="display:flex; padding: 0 10px;" :dir="lang.code == 'ar' ? 'rtl': 'ltr'">
                                                                    @{{lang.code == 'en' ? choice.answer : choice.transcodes['answer_'+lang.code]}}
                                                                </label>
                                                            </div>
                                                        </div>
                                                        {{-- Matching To Right --}}
                                                        <div v-if="isMatchingToRight" class="container-fluid row options" style="font-size: 18px;  min-height: 50px; width: 100%;">
                                                            <div class="match-right">
                                                                <div class="left">
                                                                    <div class="empty">
                                                                        <div v-for="draggable in [...user_answers[currentQuestionId].left].sort(function() { return 0.5 - Math.random() })" v-if="draggable" class="fill">
                                                                            <div  class="radio" style="padding-right: 0; padding-left: 0;">
                                                                                <label style="display:flex; padding: 0 10px; cursor: move;" :dir="lang.code == 'ar' ? 'rtl': 'ltr'">
                                                                                    @{{ lang.code == 'en' ? draggable.left_sentence : draggable.transcodes['left_sentence_'+lang.code] }}
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="right" style="margin-top: 5px;">
                                                                    <div v-for="draggable in user_answers[currentQuestionId].right" v-if="draggable" class="empty">
                                                                        <div class="m-2" :dir="lang.code == 'ar' ? 'rtl': 'ltr'">
                                                                            @{{ lang.code == 'en' ? draggable.right_sentence : draggable.transcodes['right_sentence_'+lang.code] }}
                                                                        </div>
                                                                        <div v-if="draggable.left" class="fill">
                                                                            <div class="radio" style="padding-right: 0; padding-left: 0;">
                                                                                <label style="display:flex; padding: 0 10px; cursor: move;" :dir="lang.code == 'ar' ? 'rtl': 'ltr'">
                                                                                    @{{ language == 'en' ? draggable.left.left_sentence : draggable.left.transcodes['left_sentence_'+lang.code] }}
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
                                                                    <div class="empty">
                                                                        <div v-if="!question.left.selected" class="fill">
                                                                            <div class="radio" style="padding-right: 0; padding-left: 0;" :style="[seeAnswer ? question.left.left_sentence == question.correct_sentence ? {'border-color': 'green'}: {} : {}]">
                                                                                <label style="display:flex; padding: 0 10px; cursor: move;" :dir="lang.code == 'ar' ? 'rtl': 'ltr'">
                                                                                    @{{ lang.code == 'en' ? question.left.left_sentence : question.left.transcodes['left_sentence_'+lang.code]  }}
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="empty">
                                                                        <div class="m-2" :dir="lang.code == 'ar' ? 'rtl': 'ltr'">
                                                                            @{{ lang.code == 'en' ? question.center_sentence : question.transcodes['center_sentence_'+lang.code] }}
                                                                        </div>
                                                                        <div v-if="question.left.selected" class="fill">
                                                                            <div class="radio" style="padding-right: 0; padding-left: 0;" :style="[seeAnswer ? question.left.left_sentence == question.correct_sentence ? {}: {'border-color': 'red'} : {}]">
                                                                                <label style="display:flex; padding: 0 10px; cursor: move;" :dir="lang.code == 'ar' ? 'rtl': 'ltr'">
                                                                                    @{{ lang.code == 'en' ? question.left.left_sentence : question.left.transcodes['left_sentence_'+lang.code] }}
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div v-if="question.right.selected" class="fill">
                                                                            <div class="radio" style="padding-right: 0; padding-left: 0;" :style="[seeAnswer ? question.right.right_sentence == question.correct_sentence ? {} : {'border-color': 'red'} : {}]">
                                                                                <label style="display:flex; padding: 0 10px; cursor: move;" :dir="lang.code == 'ar' ? 'rtl': 'ltr'">
                                                                                    @{{ lang.code == 'en' ? question.right.right_sentence : question.right.transcodes['right_sentence_'+lang.code] }}
                                                                                </label>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="empty">
                                                                        <div v-if="!question.right.selected" class="fill">
                                                                            <div class="radio" style="padding-right: 0; padding-left: 0;" :style="[seeAnswer ? question.right.right_sentence == question.correct_sentence ? {'border-color': 'green'}: {} : {}]">
                                                                                <label style="display:flex; padding: 0 10px; cursor: move;" :dir="lang.code == 'ar' ? 'rtl': 'ltr'">
                                                                                    @{{ lang.code == 'en' ? question.right.right_sentence : question.right.transcodes['right_sentence_'+lang.code] }}
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li v-else>{{__('general.no-translation')}}</li>
                                                </ul>
                                            </div>
                                            <!-- Question Body -->

                                        </div>
                                        <div class="row" style="padding: 0 30px;">
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="btn-group col-md-4" style="min-height: 30px; font-size: 18px; margin-bottom: 15px;" role="group">




                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                    <i class="fa fa-list"></i> {{__('User/quiz.see-all-questions')}}
                                </button>

                                <button type="button" class="btn" style="background-color: #ccc;" data-toggle="modal" data-target="#translatedQuestion">
                                    <i class="fa fa-language"></i> {{__('User/quiz.translate')}}
                                </button>

                            </div>
                            <div class="col-md-1" style="  min-height: 30px; font-size: 18px; text-align: {{app()->getLocale() == 'ar' ? 'right': 'left'}};"></div>
                            <div class="btn-group col-md-2" style="min-height: 30px; font-size: 18px; margin-bottom: 15px;" role="group">
                                <a class="btn btn-warning" id="feedback_btn" style="color:white;" v-on:click="feedMeBack" v-if="!isMatchingToRight">
                                    <i class="fa fa-check"></i> {{__('User/quiz.see-answer')}}
                                </a>
                                <a class="btn btn-warning" id="feedback_btn" style="color:white;" v-on:click="feedMeBack" v-if="isMatchingToRight" data-toggle="modal" data-target="#dragRightAnswer">
                                    <i class="fa fa-check"></i> {{__('User/quiz.see-answer')}}
                                </a>
                            </div>
                            <div class="col-md-1" style="  min-height: 30px; font-size: 18px; text-align: {{app()->getLocale() == 'ar' ? 'right': 'left'}};"></div>
{{--                            <div class="col-md-1" style="  min-height: 30px; font-size: 18px; text-align: {{app()->getLocale() == 'en' ? 'left': 'right'}};"></div>--}}
                            <div class="col-md-1" style="  min-height: 30px; font-size: 15px; text-align: {{app()->getLocale() == 'ar' ? 'right': 'left'}};">
                                <a id="prev" v-on:click="prev">
                                    <b>  <i class="fa fa-angle-{{app()->getLocale() == 'ar' ? 'right': 'left'}}" style="font-weight: bold; font-size: 21px; padding-right:5px; "></i> {{__('User/quiz.back')}}</b>
                                </a>
                            </div>
                            <div class="col-md-2" style="  min-height: 30px; font-size: 18px; text-align: center;">
                                <a data-toggle="modal" data-target="#flagedQuestion" style="color:white; width:100%;" class="btn btn-danger" type="button">
                                    <i class="fa fa-flag"></i> {{__('User/quiz.marked')}}
                                </a>
                            </div>
                            <div class="col-md-1" style="  min-height: 30px; text-align: {{app()->getLocale() == 'ar' ? 'left': 'right'}}; font-size: 15px;margin-bottom: 15px;">
                                <a id="next" v-on:click="next"  > <b> {{__('User/quiz.next')}} <i class="fa fa-angle-{{app()->getLocale() == 'ar' ? 'left': 'right'}}" style="font-weight: bold; font-size: 21px; padding-left:5px;"></i></b>

                                </a>
                                <a id="finish_btn" v-on:click="Confirmation" style="display:none;" >
                                    <b>{{__('User/quiz.finish-test')}} <i class="fa fa-angle-{{app()->getLocale() == 'ar' ? 'left': 'right'}}" style="font-weight: bold; font-size: 21px; padding-left:5px;"></i></b>
                                </a>


                            </div>

                            <div class="modal" id="dragRightAnswer" @if(app()->getLocale() == 'ar') dir="rtl" style="text-align:right;" @else dir="ltr" style="text-align:left;" @endif>
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Correct Answers</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="moodal-body">
                                            <div class="match-right" v-if="isMatchingToRight">
                                                <div class="right">
                                                    <div v-for="draggable in user_answers[currentQuestionId].right" v-if="draggable" class="empty" :data-right-id="draggable.id" data-max="2">
                                                        <div class="m-2">
                                                            @{{ renderDragRightChoice(draggable, 'right_sentence') }}
{{--                                                            @{{ language == 'ar' ? draggable.transcodes.right_sentence: draggable.right_sentence }}--}}
                                                        </div>
                                                        <div class="fill">
                                                            <div class="radio" style="padding-right: 0; padding-left: 0;">
                                                                <label style="display:flex; padding: 0 10px; cursor: move;">
                                                                    @{{ renderDragRightChoice(draggable, 'left_sentence') }}
{{--                                                                    @{{ language == 'ar' ? draggable.transcodes.left_sentence: draggable.left_sentence }}--}}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>


                    <div class="modal" id="myModal">
                        <div class="modal-dialog" style="max-width: 80%;">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">{{__('User/quiz.question-list')}}: </h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <!-- Modal body -->
                                <div class="modal-body">
                                    <table class="table table-striped table-borderless" >
                                        <thead>
                                        <tr>
                                            <th>{{__('User/quiz.title')}}</th>
                                            <th>{{__('User/quiz.points')}}</th>
                                            <th>{{__('User/quiz.score')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="i in question_title_list">
                                            <td data-dismiss="modal" v-on:click="push_question(i.id)" style="cursor: pointer;" v-html="i.title"></td>
                                            <td>1</td>
                                            <td v-html="i.score"></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>


                    {{--
                        *******************************
                        *******************************
                        *******************************
                        *******************************
                        *******************************
                        *******************************
                    --}}

                    <div class="container-fluid result"  style="display:none;" >


                        <nav class="responsive-tab style-5 style-ma-2">
                            <ul uk-switcher="connect: #results-marked ;animation: uk-animation-slide-right-medium, uk-animation-slide-left-medium">
                                <li><a href="#">{{__('User/quiz.exam-result-report')}}</a></li>
                                <li><a href="#">{{__('User/quiz.result-break-down')}}</a></li>
                            </ul>
                        </nav>
                        <hr style="margin-top: 0; padding-top:0;">
                        <ul id="results-marked" class="uk-switcher style-ma-2 style-ma-3" @if(app()->getLocale() == 'ar') style="text-align: right;" @endif>
                            <li id="result">
                                <h2>
                                    {{__('User/quiz.your-score')}}: @{{overallScore}} %

                                </h2>
                                <div class="row" style="border:1px solid dimgrey; text-align: center; padding: 10px 0; color:gray; font-weight: lighter;">
                                    <i style="margin: 0 5px;">@if(Auth::check()) {{Auth::user()->name}} @else '' @endif</i> |
                                    <i style="margin: 0 5px;">{{\Carbon\Carbon::now() }}</i> |
                                    {{-- <i style="margin: 0 5px;">{{\App\Packages::find($package_id)->name }}</i> | --}}
                                    <i style="margin: 0 5px;">
                                        @if(isset($currentTopic))
                                            {{ $currentTopic->name }}
                                        @endif
                                    </i>
                                </div>
                                <div class="row" style="border:1px solid dimgrey; text-align: left; padding: 10px 10px; margin-top: 20px;display:flex;justify-content:center;align-items: flex-start;flex-direction:column; ">
                                    <p v-html="ScoreMsg">
                                    </p>
                                    <div class="fluid-container" style ="margin: 40px 0 40px 0; min-width: 100%; ">
                                        <div class="row" style="margin-bottom: 10px;">
                                            <div class="col-md-6" style="height: 20px; border-right:1px solid mediumturquoise;">
                                                <i class="fa fa-arrow-left" style="float:left; color: mediumturquoise;"></i>
                                                {{__('User/quiz.failing')}}
                                            </div>
                                            <div class="col-md-6" style="height: 20px; border-left:1px solid mediumturquoise;">
                                                {{__('User/quiz.passing')}}
                                                <i class="fa fa-arrow-right" style="float: right; color: mediumturquoise;"></i>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3" style=" height:25px;">
                                                <div v-if="overallScore >= 65" style="background-color:#ed7813; opacity:1; height:20px; widht:100%; margin-bottom:10px;text-align: center; color:white;">
                                                    <i style="color:white;" v-if="overallScore >= 0 && overallScore <65">{{__('User/quiz.you')}}</i>
                                                </div>
                                                <div v-if="overallScore < 65" style="background-color:#ed7813; opacity:0.8; height:20px; widht:100%; margin-bottom:10px;text-align: center; color:white;">{{__('User/quiz.you')}}</div>
                                                {{__('User/quiz.need-improve')}}
                                            </div>
                                            <div class="col-md-3" style=" height:25px;">
                                                <div v-if="overallScore >= 74" style="background-color:#dae332; opacity:1; height:20px; widht:100%;margin-bottom:10px; text-align: center; color:white;">
                                                    <i style="color:white;" v-if="overallScore >= 65 && overallScore <= 74">{{__('User/quiz.you')}}</i>
                                                </div>
                                                <div v-if="overallScore < 74" style="background-color:#dae332; opacity:0.8; height:20px; widht:100%;margin-bottom:10px;text-align: center; color:white;"></div>
                                                {{__('User/quiz.below-target')}}
                                            </div>
                                            <div class="col-md-3" style=" height:25px;">

                                                <div v-if="overallScore >= 75" style="background-color:#22e6d2; opacity:1; height:20px; widht:100%;margin-bottom:10px;text-align: center; color:white;">
                                                    <i style="color:white;" v-if="overallScore >= 75 && overallScore <= 84">{{__('User/quiz.you')}}</i>
                                                </div>
                                                <div v-if="overallScore < 75" style="background-color:#22e6d2; opacity:0.8; height:20px; widht:100%;margin-bottom:10px;text-align: center; color:white;"></div>
                                                {{__('User/quiz.target')}}
                                            </div>
                                            <div class="col-md-3" style=" height:25px;">
                                                <div v-if="overallScore >= 85" style="background-color:#6ced39; opacity:1; height:20px; widht:100%;margin-bottom:10px;text-align: center; color:white;">
                                                    <i style="color:white;" v-if="overallScore >= 85 && overallScore <= 100">{{__('User/quiz.you')}}</i>
                                                </div>
                                                <div v-if="overallScore < 85" style="background-color:#6ced39; opacity:0.8; height:20px; widht:100%;margin-bottom:10px;text-align: center; color:white;"></div>
                                                {{__('User/quiz.above-target')}}
                                            </div>

                                        </div>
                                    </div>

                                    <p style="max-width: 80vw;">
                                        <b>{{__('User/quiz.d-statement-1')}}</b>
                                    </p>
                                    <p style="max-width: 80vw;">
                                        {{__('User/quiz.d-statement-2')}}
                                    </p>
                                    <p style="max-width: 80vw;">
                                        <b>{{__('User/quiz.d-statement-3')}}</b>
                                    </p>
                                    <p style="max-width: 80vw;">
                                        <b>{{__('User/quiz.above-target')}}:</b> {{__('User/quiz.d-statement-4')}}
                                    </p>
                                    <p style="max-width: 80vw;">
                                        <b>{{__('User/quiz.target')}}:</b> {{__('User/quiz.d-statement-5')}}
                                    </p>
                                    <p style="max-width: 80vw;">
                                        <b>{{__('User/quiz.below-target')}}:</b> {{__('User/quiz.d-statement-6')}}
                                    </p>
                                    <p style="max-width: 80vw;">
                                        <b>{{__('User/quiz.need-improve')}}:</b> {{__('User/quiz.d-statement-7')}}
                                    </p>
                                    <p style="max-width: 80vw;">
                                        {{__('User/quiz.d-statement-8')}}
                                    </p>
                                    <p style="max-width: 80vw;">
                                        <b>{{__('User/quiz.d-statement-9')}}</b>
                                    </p>
                                    <p style="max-width: 80vw;">
                                        {{__('User/quiz.d-statement-10')}}
                                    </p>
                                    <p style="max-width: 80vw;">
                                        <b>{{__('User/quiz.d-statement-11')}}:</b>
                                    </p>
                                    <p style="max-width: 80vw;">
                                        {{__('User/quiz.d-statement-12')}}
                                    </p>
                                    <div style="width: 40vw;">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-bordered " style="background-color: #ecf0eb;">
                                                <thead>
                                                <tr id="table_head"></tr>
                                                </thead>
                                                <tbody>
                                                <tr id="table_body"></tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <b>{{__('User/quiz.d-statement-13')}}</b>
                                    <p style="max-width: 80vw;">
                                        {{__('User/quiz.d-statement-14')}}:
                                    <ul>
                                        <li>{{__('User/quiz.d-statement-15')}}</li>
                                        <li>{{__('User/quiz.d-statement-16')}}</li>
                                    </ul>
                                    </p>

                                </div>

                            </li>
                            <li id="menu1">
                                <center>
                                    <h3>{{__('User/quiz.score-analysis')}}</h3>
                                    <div class="row">
                                        <div class="col-md-5"></div>
                                        <div class="col-md-2">
                                            @if($quiz)
                                                <a class="btn btn-primary" v-if="!cx_quiz" style="color:white;" href="{{route('QuizHistory.show', $quiz->id)}}">{{__('User/quiz.review')}} </a>
                                            @else
                                                <a class="btn btn-primary" style="color:white;" v-if="saved_quiz_id != 0 && !cx_quiz" v-on:click = "showReview">{{__('User/quiz.review')}}</a>
                                            @endif
                                        </div>
                                    </div>
                                </center>
                                <h3 style="color:#5bbae3; text-decoration:underline;" >
                                    {{__('User/quiz.result-chapters')}}:
                                </h3>
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <th>{{__('User/quiz.knowledge-area')}}</th>
                                    <th>{{__('User/quiz.no-questions')}}</th>
                                    <th>{{__('User/quiz.correct-answers')}}</th>
                                    <th>%{{__('User/quiz.correct')}}</th>
                                    </thead>
                                    <tbody id="resultByChapter">

                                    </tbody>
                                </table>
                                <br>
                                <h3 style="color:#5bbae3; text-decoration:underline;" >
                                    {{__('User/quiz.result-process')}}
                                </h3>
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <th>{{__('User/quiz.question-no')}}</th>
                                        <th>{{__('User/quiz.process-group')}}</th>
                                        <th>{{__('User/quiz.knowledge-area')}}</th>
                                        <th>{{__('User/quiz.score')}}</th>
                                    </thead>
                                    <tbody id="resultByProcess">
                                    </tbody>
                                </table>
                            </li>
                        </ul>

                    </div>

                </div>
                <!--
                **************************
                **************************
                -->
            </div>
            <div class="style-ma-1">
                <nav class="responsive-tab style-5 style-ma-2">
                    <ul uk-switcher="connect: #course-footer ;animation: uk-animation-slide-right-medium, uk-animation-slide-left-medium">
                        <li><a >{{__('User/quiz.test-history')}}</a></li>
                        <li><a >{{__('User/quiz.q-and-a')}}</a></li>

                    </ul>
                </nav>
                <hr style="margin-top: 0; padding-top:0;">
                <ul id="course-footer" class="uk-switcher style-ma-2 style-ma-3">
                    <!-- course description -->
                    <li>
                        @if($package_id != 'question')
                        @php
                            $attempt = count($quiz_history_arr);
                        @endphp
                        @foreach($quiz_history_arr as $quiz_z)

                            <div class="row" style="margin-top: 10px; margin-bottom: 10x;">
                                <div class="container" id="view1{{$quiz_z->quiz->id}}" style="border:1px solid #ccc; width:80%; padding: 25px 0;box-shadow: 0px 9px 15px -4px rgba(0,0,0,0.14); ">
                                    <div style="display:flex; justify-content: space-evenly; align-items:center; flex-wrap: wrap;" >
                                        <div class=""></div>
                                        <div class="">
                                            @if($quiz_z->quiz->score >= 75)
                                                <b style="color:darkgreen">{{__('User/quiz.success')}}</b>
                                            @else
                                                <b style="color:darkred">{{__('User/quiz.failed')}}</b>
                                            @endif


                                        </div>
                                        <div class="">
                                            <b>{{$quiz_z->quiz->score}}%</b> {{__('User/quiz.correct')}}
                                        </div>
                                        <div class="">

                                            {{$quiz_z->hours}} {{__('User/quiz.hour')}} {{$quiz_z->mins}} {{__('User/quiz.min')}} {{$quiz_z->sec}} {{__('User/quiz.sec')}}
                                        </div>
                                        <div class="">
                                            {{\Carbon\Carbon::parse($quiz_z->quiz->updated_at)->diffForHumans()}}
                                        </div>
                                        <div class="col-md-1">
                                            <i class="fa fa-arrow-down" style="font-size: 25px; color:#ccc; cursor: pointer;" v-on:click="slideMe('view2{{$quiz_z->quiz->id}}', 'view1{{$quiz_z->quiz->id}}')"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="container" id="view2{{$quiz_z->quiz->id}}" style="border:1px solid #ccc; width:80%; padding: 25px 0;box-shadow: 0px 9px 15px -4px rgba(0,0,0,0.14);display:none;">
                                    <div class="row" >
                                        <div class="col-md-5"></div>
                                        <div class="col-md-6" style="display:flex; justify-content: space-evenly; align-items:flex-start; flex-direction:column; flex-wrap: wrap;">
                                            <div style="font-size: 20px; margin:5px;">
                                                Attempt {{$attempt}} :

                                                @if($quiz_z->quiz->score >= 75)
                                                    <i style="color: darkgreen;">{{__('User/quiz.success-required')}}</i>
                                                @else
                                                    <i style="color: darkred;">{{__('User/quiz.failed-required')}}</i>
                                                @endif
                                            </div>
                                            <div style="margin:5px;">
                                                <b style="font-size: 25px;"> {{$quiz_z->quiz->score}}% </b><small>{{__('User/quiz.correct')}}</small>
                                            </div>
                                            <div style="color: #ccc;margin:5px;">
                                                {{$quiz_z->hours}} {{__('User/quiz.hour')}} {{$quiz_z->mins}} {{__('User/quiz.min')}} {{$quiz_z->sec}} {{__('User/quiz.sec')}}
                                            </div>
                                            <div style="color: #ccc;margin:5px;">
                                                {{\Carbon\Carbon::parse($quiz_z->quiz->updated_at)->diffForHumans() }}
                                            </div>
                                            <div style="margin:5px;">
                                                <a href="{{route('QuizHistory.show', $quiz_z->quiz->id)}}" class="btn btn-primary">{{__('User/quiz.review-questions')}}</a>
                                            </div>

                                        </div>
                                        <div class="col-md-1">
                                            <i class="fa fa-arrow-up" style="font-size: 25px; color:#ccc; cursor: pointer;" v-on:click="slideMe('view1{{$quiz_z->quiz->id}}', 'view2{{$quiz_z->quiz->id}}')"></i>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            @php
                                $attempt--;
                            @endphp
                        @endforeach
                        @endif
                    </li>
                    <li>
                        <div class="comments">
                            <ul>
                                @foreach($comments as $fullComment)

                                    <li>
                                        @php
                                            $profile_pic = asset('assets/layouts/layout/img/avatar3_small.jpg');
                                            $comment = $fullComment->first()
                                        @endphp

                                        <div class="comments-avatar">
                                            <img src="@if($comment->profile_pic) {{asset('storage/profile_picture/'.basename($comment->profile_pic))}} @else {{$profile_pic}} @endif" alt="">
                                        </div>
                                        <div class="comment-content">
                                            <div class="comment-by">{{$comment->name}} <span>{{\Carbon\Carbon::parse($comment->created_at)->diffForHumans()}}</span>
                                                <a @click.prevent="ShowReplyForm({{$comment->comment_id}})" class="reply"><i class="icon-line-awesome-undo"></i> {{__('User/quiz.reply')}}</a>
                                            </div>
                                            <p> {{$comment->comment}} </p>
                                        </div>

                                        <ul>
                                            <li id="reply-form-{{$comment->comment_id}}"></li>
                                            @foreach($fullComment as $reply)
                                                @if($reply->reply_id)
                                                <li id="reply-form-{{$reply->reply_id}}">
                                                    <div class="comments-avatar">
                                                        <img src="@if($reply->reply_profile_pic) {{asset('storage/profile_picture/'.basename($reply->reply_profile_pic))}} @else {{$profile_pic}} @endif" alt="">
                                                    </div>
                                                    <div class="comment-content">
                                                        <div class="comment-by">{{$reply->reply_name}}<span>{{\Carbon\Carbon::parse($reply->reply_created_at)->diffForHumans()}}</span>

                                                        </div>
                                                        <p> {{$reply->reply_comment}} </p>
                                                    </div>
                                                </li>
                                                @endif
                                            @endforeach

                                        </ul>

                                    </li>
                                @endforeach


                            </ul>


                            <h3>{{__('User/quiz.submit-review')}}</h3>
                            <ul>
                                <li>
                                    @php

                                        $profile_pic = '';
                                        if(Auth::check()){
                                            if(\App\UserDetail::where('user_id', '=', Auth::user()->id)->get()->first() ){
                                                if(\App\UserDetail::where('user_id', '=', Auth::user()->id)->get()->first()->profile_pic){
                                                    $profile_pic =url('storage/profile_picture/'.basename(\App\UserDetail::where('user_id','=',Auth::user()->id)->get()->first()->profile_pic));
                                                }else{
                                                    $profile_pic =asset('assets/layouts/layout/img/avatar3_small.jpg');
                                                }
                                            }else{
                                                $profile_pic =asset('assets/layouts/layout/img/avatar3_small.jpg');
                                            }
                                        }

                                    @endphp
                                    <div class="comments-avatar">
                                        <img src="{{$profile_pic}}" alt="">
                                    </div>
                                    <div class="comment-content">
                                        <form class="uk-grid-small" action="{{route('comment.store')}}" method="post" uk-grid>
                                            @csrf
                                            <input type="hidden" name="page" value="{{$topic}}">
                                            <input type="hidden" name="item_id" value="{{$topic_id}}">
                                            <div class="uk-width-1-1@s">
                                                <label class="uk-form-label">{{__('User/quiz.comment')}}</label>
                                                <textarea class="uk-textarea"
                                                          name="contant"
                                                          placeholder="{{__('User/quiz.enter-comment-here')}}"
                                                          style=" height:160px" required></textarea>
                                            </div>
                                            <div class="uk-grid-margin">
                                                <input type="submit" value="{{__('User/quiz.submit')}}" class="btn btn-default">
                                            </div>
                                        </form>

                                    </div>
                                </li>
                            </ul>
                        </div>
                    </li>

                </ul>
            </div>
        </div>


        <!-- course sidebar -->
        <div class="course-sidebar go-when-less-770" style="order: 2;"></div>
        <div class="course-sidebar remove-position-when-less-770" style="order: 2; overflow:scroll; position:fixed; bottom: 0; {{app()->getLocale() == 'ar'? 'left':'right'}}:0;">
            <div class="course-sidebar-title" style="justify-content: space-between; padding-top: 20px; width: 100%;">
                <h3> {{__('User/quiz.table-content')}} </h3>
                <a href="#ExamGenerator" uk-toggle style="text-align: right;">
                    <i class="icon-line-awesome-plus icon-small " uk-tooltip="title:  Model Exam Generator ; pos:bottom"></i>
                </a>
            </div>
            <div class="course-sidebar-container">

                <ul class="course-video-list-section" uk-accordion>
                    <li class="course-video-list" style="padding-top: 20px;text-align:center;">
                        <a class="" uk-toggle href="#ExamGenerator">{{__('User/quiz.model-exam-generator')}}</a>
                    </li>
                </ul>


                <ul class="course-video-list-section" uk-accordion>

                    <li class="@if(count(json_decode($chapters_inc))) uk-open @endif">
                        <a class="uk-accordion-title" style=" @if(app()->getLocale() == 'ar') text-align:right; @endif" @click="loadTopic('chapter')" href="#">{{__('User/quiz.chapters')}}</a>
                        <div class="uk-accordion-content" style=" @if(app()->getLocale() == 'ar') text-align:right; @endif">
                            <!-- course-video-list -->
                            <ul class="course-video-list highlight-watched">
{{--                                <span v-if="chapters_inc.length == 0" style="display:flex; justify-content: center;" class="text-center">Loading..</span>--}}
                                <li v-for="i in chapters_inc" v-if="i.questions_number > 0" :class="isWatched(i.completedQuizNumber)">
                                    <a :href="topicURL(i.key, i.id)">
                                        @{{ i.name }}
                                        <i v-if="i.savedQuizNumber > 0" style="color:#c6112d; float: right;"> [{{__('User/quiz.saved')}}]</i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>


                    <li class="@if(count(json_decode($process_inc)))  uk-open @endif">
                        <a class="uk-accordion-title" style=" @if(app()->getLocale() == 'ar') text-align:right; @endif" @click="loadTopic('process')" href="#">{{__('User/quiz.process-groups')}}</a>
                        <div class="uk-accordion-content">
                            <!-- course-video-list -->
                            <ul style="list-style:none;">

                                <li v-for="i in process_inc" v-if="i.questions_number > 0" :class="isWatched(i.completedQuizNumber)">
                                    <ul class="course-video-list-section" uk-accordion>
                                        <li>
                                            <a class="uk-accordion-title" style=" @if(app()->getLocale() == 'ar') text-align:right; @endif" href="#">
                                                @{{ i.name }}
                                            </a>
                                            <div class="uk-accordion-content">
                                                <ul class="course-video-list highlight-watched">
                                                    <li v-for="index in i.parts_no" v-if="i.key != 'mistake'">
                                                        <a :href="topicURL(i.key, i.id, index)">
                                                            @{{ i.parts_no == 1 ? i.name : 'Part '+index }}
                                                        </a>
                                                    </li>
                                                    <li v-if="i.key == 'mistake'">
                                                        <a :href="topicURL(i.key, i.id)">
                                                            @{{ i.name }}
                                                        </a>
                                                    </li>
                                                    
                                                </ul>
                                            </div>

                                        </li>
                                    </ul>
                                </li>

                            </ul>
                        </div>
                    </li>


                    <li class="@if(count(json_decode($exams_inc))) uk-open @endif">
                        <a class="uk-accordion-title" style=" @if(app()->getLocale() == 'ar') text-align:right; @endif" @click="loadTopic('exam')" href="#">{{__('User/quiz.exams')}}</a>
                        <div class="uk-accordion-content">
                            <!-- course-video-list -->
                            <ul class="course-video-list highlight-watched">
{{--                                <span v-if="exams_inc.length == 0" style="display:flex; justify-content: center;" class="text-center">Loading..</span>--}}
                                <li v-for="i in exams_inc" v-if="i.questions_number > 0" :class="isWatched(i.completedQuizNumber)">
                                    <a :href="topicURL(i.key, i.id)">
                                        @{{ i.name }}
                                        <i v-if="i.savedQuizNumber > 0" style="color:#c6112d; float: right;"> [{{__('User/quiz.saved')}}]</i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                </ul>

            </div>

        </div>
        <div id="ExamGenerator" class="uk-modal-container" uk-modal>
            <div class="uk-modal-dialog uk-modal-body" @if(app()->getLocale() == 'ar') style="text-align: right !important;" @endif>
                <h2 class="uk-modal-title">{{__('User/quiz.model-exam-generator')}}</h2>
                <p>
                    {{__('User/quiz.meg-1')}}
                </p>
                <form class="uk-form-horizontal uk-margin-large">
                    <div class="uk-margin">
                        <label class="uk-form-label" for="topics_list">{{__('User/quiz.topic')}}</label>
                        <div class="uk-form-controls">
                            <select name="topics_list" id="topics_list" @change="clearCheckedItems" v-model="cx_topic" class="uk-input">
                                <option value="0" selected disabled>{{__('User/quiz.select-topic')}}</option>
                                <option v-for="i in topics_included_arr" selected :value="i.key">@{{ i.name }}</option>
                            </select>
                        </div>
                    </div>
                </form>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">@{{ selectedTopic }}</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr v-for="i in selectedTopicContent">
                            <td>
                                <label class="container">
                                    @{{ i['name'] }}
                                    <input type="checkbox" id="vehicle1" v-model="cx_checkedItems" :value="i.id">
                                    <span class="checkmark"></span>
                                </label>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <p class="uk-text-right">
                    <button class="uk-button uk-button-default uk-modal-close" type="button">{{__('User/quiz.cancel')}}</button>
                    <button class="uk-button uk-button-primary" @click="Generate_CX" type="button">{{__('User/quiz.start-test')}}</button>
                </p>
            </div>



        </div>
    </div>



</div>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-176072046-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-176072046-1');
</script>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>

<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<script src="https://unpkg.com/sweetalert2@7.8.2/dist/sweetalert2.all.js"></script>

<script src="{{asset('helper/js/jQuery.tagify.min.js')}}"></script>
@if(env('APP_ENV') == 'local')
    <script src="{{asset('helper/js/vue-dev.js')}}"></script>
@else
    <script src="{{asset('helper/js/vue-prod.min.js')}}"></script>
@endif
<script src="{{asset('js/easyTimer.min.js')}}"></script>
<script>

    if( navigator.userAgent.match(/Android/i)
        || navigator.userAgent.match(/webOS/i)
        || navigator.userAgent.match(/iPhone/i)
        || navigator.userAgent.match(/iPad/i)
        || navigator.userAgent.match(/iPod/i)
        || navigator.userAgent.match(/BlackBerry/i)
        || navigator.userAgent.match(/Windows Phone/i)
    ){
        window.location = '{{ route('mobile.redirect') }}';
    }

    (function() {
        $('#wrapper').show();
        $('#loading').hide();
    })();

    document.addEventListener('contextmenu', event => event.preventDefault());
        $(window).keyup(function(e){
        if(e.keyCode == 44){
            $("#app-1").hide();
            $("#prsc-msg").show();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax ({
                type: 'GET',
                url: '{{ route('ScreenShot') }}',
                success: function(res){
                    if(res == 'disabled'){
                        window.location.href = '{{route('login')}}';
                    }
                },
                error: function(res){
                    console.log('Error:', res);
                }
            });

        }
    });

</script>
<script>
    quizAttr = {
        package_id: '{{$package_id}}',
        topic_type: '{{$topic}}',
        topic_id: {{$topic_id}},
        package: '{{$package_name}}',
        max_questions_num: {{$questionNum}},
        scoreAnalysis: {
            @if(count($process))
                    @foreach($process as $type)
            '{{$type}}': {msg: '',count: 0 , data: [], score: 0},
            @endforeach
            @endif
        },
        scoreAnalysisByChapter: {
            @php
                $loaded = [];
            @endphp
                    @if(count(\App\Chapters::where('course_id', \App\Packages::find($package_id)->course_id)->get()))

                    @foreach(\App\Chapters::all() as $type)
                    @if(!in_array($type->name, $loaded))
            '{{$type->name}}': {msg: '',count: 0 , data: [], score: 0},
            @endif
            @php
                array_push($loaded, $type->name);
            @endphp
            @endforeach
            @endif
        },
        topics_included_arr: [],
        language: '{{\Session('locale')}}',
        chapters_inc: JSON.parse('{!! $chapters_inc !!}'),
        process_inc: JSON.parse('{!! $process_inc !!}'),
        exams_inc: JSON.parse('{!! $exams_inc !!}'),
        base_url: '{{url('')}}',
        calculator_url: '{{route('calculator')}}',
        whiteBoard_url: 'https://pm-white.herokuapp.com/',
        api: {
            csrf            : '{{csrf_token()}}',
            generate_quiz   : '{{ route('PremiumQuiz.generate')}}',
            init_topic      : '{{ route('init.topic')}}',
            load_topic      : '{{ route('load.topic')}}',
            saveForLaterOn  : '{{ route('saveForLaterOn') }}',
            scoreStore      : '{{route('PremiumQuiz.scoreStore')}}',
            postReview      : '{{ route('user.review')}}',
            userRate        : '{{ route('user.rate')}}',
            quizHistoryShow : '{{ route('QuizHistory.show', '') }}',
            feedback        : '{{url('PremiumQuiz/feedback')}}',
            cxQuiz          : '{{ route('PremiumQuiz.generateCX')}}',
            part_id         : '{{request()->part_id}}',
        },
        saved_quiz_id: @if($quiz) {{$quiz->id}} @else 'realtime' @endif,
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
<script src="{{asset('helper/js/quiz-V0.4.js')}}"></script>

<!-- javaScripts
================================================== -->
<script src="{{asset('assetsV2/js/framework.js')}}"></script>
<script src="{{asset('assetsV2/js/jquery-3.3.1.min.js')}}"></script>
<script src="{{asset('assetsV2/js/simplebar.js')}}"></script>
<script src="{{asset('assetsV2/js/main.js')}}"></script>
<script src="{{asset('assetsV2/js/bootstrap-select.min.js')}}"></script>


</body>

</html>
