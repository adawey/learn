@extends('layouts.layoutV2')

@section('head')
    <link rel="stylesheet" href="{{asset('helper/css/tagify.css')}}">
    <link rel="stylesheet" href="{{asset('css/custom.css')}}">
    <link rel="stylesheet" href="{{asset('helper/css/quiz.css')}}">
    <style>
        iframe {
            width: 100% !important;
        }
        @media only screen and (min-width: 320px) {
          iframe {
            height: 150px !important;
          }
        }
        
        @media only screen and (min-width: 768px) {
          iframe {
            height: 450px !important;
          }
        }
        
        @media only screen and (min-width: 1024px) {
          iframe {
            height: 550px !important;
          }
        }
        
        @media only screen and (min-width: 1200px) {
          iframe {
            height: 720px !important;
          }
        }
        
        .tagify__tag > div {
            height: unset !important;
        }
        /*input[type='checkbox'].btn-foreground.hover-outline:hover {}*/
        /*input[type='checkbox']:checked .btn-foreground.hover-outline {*/
        /*    background-color: var(--foreground);*/
        /*    color: var(--primary) !important;*/
        /*}*/

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
@endsection

@section('content')
    <div class="container d-flex flex-column" id="app-1">
        <!-- Title and Top Buttons Start -->
        <div class="page-title-container">
            <div class="row">
                <!-- Title Start -->
                <div class="col-12 col-sm-6">
                    <h1 class="mb-0 pb-0 display-4" id="title">{{$package_name}}</h1>
                    <nav class="breadcrumb-container d-inline-block" aria-label="breadcrumb">
                        <ul class="breadcrumb pt-0">
                            <li class="breadcrumb-item"><a href="{{route('user.dashboard')}}">Dashabord</a></li>
                            <li class="breadcrumb-item"><a href="{{route('package.details', $package_id)}}">Package Details</a></li>
                        </ul>
                    </nav>
                </div>
                <!-- Title End -->
            </div>

            <!-- Contents Button Start -->
            <button
                    style="float: right;"
                    type="button"
                    class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-sm-auto d-inline-block d-xl-none"
                    data-bs-toggle="modal"
                    data-bs-target="#tableOfContentsModal"
            >
                <i data-cs-icon="menu-right"></i>
                <span>Contents</span>
            </button>
            <!-- Contents Button End -->

            @if($video)
            <div class="row my-1">
                <!-- Title Start -->
                <div class="col-12 col-sm-12">
                    <h1 class="mb-0 pb-0 display-4" id="title">{{$video->title}}</h1>
                </div>
                <!-- Title End -->
            </div>
            @endif
            @if($explanation)
                <div class="row my-1">
                    <!-- Title Start -->
                    <div class="col-12 col-sm-12">
                        <h1 class="mb-0 pb-0 display-4" id="title">{{$explanation->title}}</h1>
                    </div>
                    <!-- Title End -->
                </div>
            @endif
        </div>
        <!-- Title and Top Buttons End -->

        <!-- Content Start -->
        <div class="row d-flex flex-grow-1 overflow-hidden pb-2 h-100">
            @if(!$video & !$explanation)
            <div class="col-lg-8 col-xxl-9" v-if="!video_id">
                <div class="card mb-3">
                    <div class="card-body">

                        {{-- Quiz Init FOrm --}}
                        <form @submit.prevent="optimizeQuiz" id="optimizeForm"  style="display:block;">
                            <div class="optimization_form" style="padding-top: 16px; padding-left: 50px; width:100%; ">

                                <div class="">
                                    <div class="row g-3 mb-5 d-flex justify-content-center">
                                        <div class="col-12 col-lg-6 col-xxl-3">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="heading mb-0 d-flex justify-content-between lh-1-25 mb-3">
                                                        <span>{{__('User/quiz.questions')}}</span>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 16 16" stroke="currentColor" stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round" class="cs-icon cs-icon-star text-primary">
                                                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                            <path d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286zm1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94z"/>
                                                        </svg>
                                                    </div>
                                                    <div class="text-medium text-muted mb-1">
                                                    </div>
                                                    <div class="cta-1 text-primary">@{{max_questions_num}}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6 col-xxl-3">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="heading mb-0 d-flex justify-content-between lh-1-25 mb-3">
                                                        <span>{{__('User/quiz.score-required')}}</span>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="cs-icon cs-icon-diploma text-primary"><path d="M15 3.99999V3.99999C16.1046 3.99999 17 4.89542 17 5.99999L17 14.5C17 15.9044 17 16.6067 16.6629 17.1111C16.517 17.3295 16.3295 17.517 16.1111 17.6629C15.6067 18 14.9045 18 13.5 18L6.5 18C5.09554 18 4.39331 18 3.88886 17.6629C3.67048 17.517 3.48298 17.3295 3.33706 17.1111C3 16.6067 3 15.9044 3 14.5L3 7.49999C3 6.09553 3 5.3933 3.33706 4.88886C3.48298 4.67047 3.67048 4.48297 3.88886 4.33706C4.39331 4 5.09554 4 6.5 4L9.5 3.99999"></path><path d="M14 6L14 13.3252C14 13.5663 14 13.6868 13.9433 13.7319C13.9196 13.7507 13.8908 13.7619 13.8606 13.764C13.7884 13.7691 13.7069 13.6803 13.544 13.5025L13.29 13.2255C12.7767 12.6655 12.5201 12.3856 12.2057 12.3195C12.0701 12.2909 11.9299 12.2909 11.7943 12.3195C11.4799 12.3856 11.2233 12.6655 10.71 13.2255L10.456 13.5025C10.2931 13.6803 10.2116 13.7691 10.1394 13.764C10.1092 13.7619 10.0804 13.7507 10.0567 13.7319C10 13.6868 10 13.5663 10 13.3252L10 6"></path><circle cx="12" cy="4" r="3"></circle><path d="M6 15H7M6 12H7M6 9H7"></path></svg>
                                                    </div>
                                                    <div class="text-medium text-muted mb-1">
                                                    </div>
                                                    <div class="cta-1 text-primary">75%</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6 col-xxl-3">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="heading mb-0 d-flex justify-content-between lh-1-25 mb-3">
                                                        <span>{{__('User/quiz.min')}}</span>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="cs-icon cs-icon-clock text-primary"><path d="M8 12L9.70711 10.2929C9.89464 10.1054 10 9.851 10 9.58579V6"></path><circle cx="10" cy="10" r="8"></circle></svg>
                                                    </div>
                                                    <div class="text-medium text-muted mb-1">
                                                    </div>
                                                    <div class="cta-1 text-primary">@{{Math.round(examTimeMin > 0 ? examTimeMin: max_questions_num*76.7/60)}}</div>
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
                        {{-- Loader --}}
                        <div id="quizLoading" style="margin: auto; display:none;">
                            <div class="spinner-border" style="width: 3rem; height: 3rem" role="status"></div>
                        </div>

                        {{-- Quiz View --}}
                        <div class="container-fluid primeQuizViewWM" id="quiz" style="min-height: 50px; margin:20px 0; display:none; background-image: url('{{asset('img/wm-n.png')}}'); background-size:cover;">


{{--                            <a class="btn" type="button" style="background-color: #ccc; max-width: 200px; margin-bottom: 10px;" id="toggleCorrectAnswer" v-on:click="openWhiteBoard">--}}
{{--                                <i class="fa fa-edit"></i> {{__('User/quiz.white-board')}}--}}
{{--                            </a>--}}
                            <div class="d-flex flex-wrap justify-content-between">
                                <div class="d-flex">
                                    <span style="font-size: 1.5em;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-question-circle" viewBox="0 0 16 16">
                                          <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                          <path d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286zm1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94z"/>
                                        </svg>
                                    </span>
                                    <span style="font-size: 1.5em; margin-top: 3px;">
                                        @{{current_question_number}}/@{{question_number}}
                                    </span>
                                </div>
                                <div style="display: flex;justify-content: center;gap: 30px;">
                                    <a id="pause" v-on:click="stopTimer_pause" style="margin-right:15px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor" class="bi bi-pause-circle" viewBox="0 0 16 16">
                                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                            <path d="M5 6.25a1.25 1.25 0 1 1 2.5 0v3.5a1.25 1.25 0 1 1-2.5 0v-3.5zm3.5 0a1.25 1.25 0 1 1 2.5 0v3.5a1.25 1.25 0 1 1-2.5 0v-3.5z"/>
                                        </svg>
                                    </a>
                                    <a v-on:click="Confirmation">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor" class="bi bi-stop-circle" viewBox="0 0 16 16">
                                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                            <path d="M5 6.5A1.5 1.5 0 0 1 6.5 5h3A1.5 1.5 0 0 1 11 6.5v3A1.5 1.5 0 0 1 9.5 11h-3A1.5 1.5 0 0 1 5 9.5v-3z"/>
                                        </svg>
                                    </a>
                                </div>
                                <div>
                                    <span style="font-size: 1.5em;" class="d-flex">
                                        <svg style="margin-top: 3px;" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-clock-history" viewBox="0 0 16 16">
                                          <path d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022l-.074.997zm2.004.45a7.003 7.003 0 0 0-.985-.299l.219-.976c.383.086.76.2 1.126.342l-.36.933zm1.37.71a7.01 7.01 0 0 0-.439-.27l.493-.87a8.025 8.025 0 0 1 .979.654l-.615.789a6.996 6.996 0 0 0-.418-.302zm1.834 1.79a6.99 6.99 0 0 0-.653-.796l.724-.69c.27.285.52.59.747.91l-.818.576zm.744 1.352a7.08 7.08 0 0 0-.214-.468l.893-.45a7.976 7.976 0 0 1 .45 1.088l-.95.313a7.023 7.023 0 0 0-.179-.483zm.53 2.507a6.991 6.991 0 0 0-.1-1.025l.985-.17c.067.386.106.778.116 1.17l-1 .025zm-.131 1.538c.033-.17.06-.339.081-.51l.993.123a7.957 7.957 0 0 1-.23 1.155l-.964-.267c.046-.165.086-.332.12-.501zm-.952 2.379c.184-.29.346-.594.486-.908l.914.405c-.16.36-.345.706-.555 1.038l-.845-.535zm-.964 1.205c.122-.122.239-.248.35-.378l.758.653a8.073 8.073 0 0 1-.401.432l-.707-.707z"/>
                                          <path d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0v1z"/>
                                          <path d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5z"/>
                                        </svg>
                                        <div style="padding: 0 5px;" id="timer">00:00</div>
                                    </span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12" style="display:flex; justify-content: center; flex-direction: column; align-items: center;">
                                    <div class="progress sh-2 w-100 my-2">
                                        <div class="progress-bar" id="progress_bar" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;"></div>
                                    </div>
                                </div>
                            </div>


                            <hr style="margin-top:0">
                            <!-- Rating  -->

                            <!-- Question Body -->
                            <div class="d-flex flex-row align-content-center align-items-center mb-5">
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
                                        <input type="radio" class="btn-check" :value="choice.id" :id="'item_' +choice.id" v-model="multipleChoiceValue"
                                               @click="applyUserChoice(choice.id, choice.question_id)"/>
                                        <label
                                                class="btn btn-foreground hover-outline sw-4 sh-4 p-0 rounded-xl d-flex justify-content-center align-items-center stretched-link"
                                                :for="'item_' +choice.id"
                                                :style="[seeAnswer ? choice.id == user_answers[currentQuestionId].answers.filter(row => row.is_correct)[0].answer_id ? {'box-shadow':'inset 0 0 0 1px green !important'}:  user_answers[currentQuestionId].answer && choice.id == user_answers[currentQuestionId].answer.answer_id ? {'box-shadow':'inset 0 0 0 1px red !important'}: {} : {}]"

                                        >
                                            @{{ alpha[idx] }}
                                        </label>
                                    </div>
                                </div>
                                <div class="mb-0 text-alternate">
                                    @{{renderChoice(choice)}}
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
                                               :disabled="currentSelectedAnswersCount == current_question_correct_answers_required && !user_answers[choice.question_id].answers[choice.id].selected"
                                               @click="applyUserChoice(choice.id, choice.question_id)"/>
                                        <label
                                                class="btn active-outline  sw-4 sh-4 p-0 rounded-xl d-flex justify-content-center align-items-center stretched-link"
                                                :for="'item_' +choice.id"
                                                :style="[seeAnswer ? user_answers[currentQuestionId].answers.filter(row => row.is_correct && row.answer_id == choice.id).length ? {'box-shadow':'inset 0 0 0 1px green !important'}: user_answers[currentQuestionId].answers.filter(row => row.answer_id == choice.id && row.selected).length ? {'box-shadow':'inset 0 0 0 1px red !important'}: {}: user_answers[currentQuestionId].answers.filter(row => row.answer_id == choice.id && row.selected).length ? {'box-shadow':'inset 0 0 0 1px var(--primary) !important'}: {}]"
                                        >
                                            @{{ alpha[idx] }}
                                        </label>
                                    </div>
                                </div>
                                <div class="mb-0 text-alternate">
                                    @{{renderChoice(choice)}}
                                </div>
                            </div>
{{--                            <div v-if="isMultipleResponses" class="container-fluid row options" style="font-size: 18px;  min-height: 50px; width: 100%;">--}}
{{--                                <div v-for="choice in current_question_choices" class="radio" style="padding-right: 0; padding-left: 0;" :style="[seeAnswer ? user_answers[currentQuestionId].answers.filter(row => row.is_correct && row.answer_id == choice.id).length ? {'border-color': 'green'}: user_answers[currentQuestionId].answers.filter(row => row.answer_id == choice.id && row.selected).length ? {'border-color': 'red'}: {}: {}]">--}}
{{--                                    <label style="display:flex;"><input style=" margin: 5px 15px auto 15px; flex: 0 0 17px;" class="uk-checkbox" type="checkbox"--}}
{{--                                                                        :disabled="currentSelectedAnswersCount == current_question_correct_answers_required && !user_answers[choice.question_id].answers[choice.id].selected"--}}
{{--                                                                        @click="applyUserChoice(choice.id, choice.question_id)"--}}
{{--                                                                        :id="'item_' +choice.id"--}}
{{--                                                                        v-model="multipleResponseValue[choice.id].selected">--}}
{{--                                        @{{renderChoice(choice)}}--}}
{{--                                    </label>--}}
{{--                                </div>--}}
{{--                            </div>--}}
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
                                <div class="col-12 ">
                                    <div class="box-body d-flex flex-wrap justify-content-between" style="font-size: 1rem !important;">
                                        <button type="button" class="btn m-1 btn-outline-primary btn-icon btn-icon-end" style="max-width: 120px;" id="prev" v-on:click="prev">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-circle" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
                                            </svg> previous
                                        </button>
                                        <button type="button" class="btn m-1 btn-outline-primary btn-icon btn-icon-end" v-on:click="openCalc">  calculator</button>
                                        <button type="button" class="btn m-1 btn-outline-primary btn-icon btn-icon-end" data-bs-toggle="modal" data-bs-target="#myModal"> All Questions</button>

                                        <button type="button" class="btn m-1 btn-outline-primary btn-icon btn-icon-end" v-on:click="feedMeBack" v-if="!isMatchingToRight"> See Answer</button>
                                        <button type="button" class="btn btn-outline-primary btn-icon btn-icon-end" v-on:click="feedMeBack" v-if="isMatchingToRight" data-toggle="modal" data-target="#dragRightAnswer"> See Answer</button>

                                        <button type="button" class="btn m-1 btn-icon btn-icon-end " :class="{'btn-outline-primary': !current_question_flag, 'btn-primary': current_question_flag}" @click="toggleFlag"> Flag</button>
                                        <button type="button" class="btn m-1 btn-outline-primary btn-icon btn-icon-end " id="next" style="max-width: 120px;" v-on:click="next">
                                            Next <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-circle" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
                                            </svg>
                                        </button>
                                        <button type="button" class="btn m-1 btn-outline-primary btn-icon btn-icon-end " style="max-width: 120px;" id="finish_btn" v-on:click="Confirmation">
                                            Finish Test <i data-cs-icon="check"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Draggable Answer Modal -->
                        <div class="modal" id="dragRightAnswer" @if(app()->getLocale() == 'ar') dir="rtl" style="text-align:right;" @else dir="ltr" style="text-align:left;" @endif>
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Correct Answers</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="match-right" v-if="isMatchingToRight">
                                            <div class="right">
                                                <div v-for="draggable in user_answers[currentQuestionId].right" v-if="draggable" class="empty" :data-right-id="draggable.id" data-max="2">
                                                    <div class="m-2">
                                                        @{{ language == 'ar' ? draggable.transcodes.right_sentence: draggable.right_sentence }}
                                                    </div>
                                                    <div class="fill">
                                                        <div class="radio" style="padding-right: 0; padding-left: 0;">
                                                            <label style="display:flex; padding: 0 10px; cursor: move;">
                                                                @{{ language == 'ar' ? draggable.transcodes.left_sentence: draggable.left_sentence }}
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
                        <!-- All Question Modal -->
                        <div class="modal" tabindex="-1" id="myModal">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Questions List</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="filled custom-control-container">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-flag-fill" viewBox="0 0 16 16">
                                                <path d="M14.778.085A.5.5 0 0 1 15 .5V8a.5.5 0 0 1-.314.464L14.5 8l.186.464-.003.001-.006.003-.023.009a12.435 12.435 0 0 1-.397.15c-.264.095-.631.223-1.047.35-.816.252-1.879.523-2.71.523-.847 0-1.548-.28-2.158-.525l-.028-.01C7.68 8.71 7.14 8.5 6.5 8.5c-.7 0-1.638.23-2.437.477A19.626 19.626 0 0 0 3 9.342V15.5a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 1 0v.282c.226-.079.496-.17.79-.26C4.606.272 5.67 0 6.5 0c.84 0 1.524.277 2.121.519l.043.018C9.286.788 9.828 1 10.5 1c.7 0 1.638-.23 2.437-.477a19.587 19.587 0 0 0 1.349-.476l.019-.007.004-.002h.001"/>
                                            </svg>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" v-model="flagged_question_only" style="height: 20px; width: 30px; opacity:1;">
                                                <label class="form-check-label" for="flexSwitchCheckChecked">Flagged Only</label>
                                            </div>
                                        </div>

                                        <table class="table table-striped table-borderless" >
                                            <thead>
                                            <tr>
                                                <th>{{__('User/quiz.title')}}</th>
                                                <th>{{__('User/quiz.points')}}</th>
                                                <th>Flag</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="i in question_title_list" v-if="!flagged_question_only">
                                                <td data-dismiss="modal" v-on:click="push_question(i.id)" data-bs-dismiss="modal" style="cursor: pointer;" v-html="i.title"></td>
                                                <td>1</td>
                                                <td v-if="Object.entries(user_answers).length > 0 && Object.entries(user_answers).filter(r => r[1].question_number == i.id)[0][1].flag" class="text-danger">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bookmark-check" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd" d="M10.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                                                        <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5V2zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1H4z"/>
                                                    </svg>
                                                </td>
                                                <td v-else>--</td>
                                            </tr>
                                            <tr v-for="i in question_title_list" v-if="flagged_question_only && Object.entries(user_answers).length > 0 && Object.entries(user_answers).filter(r => r[1].question_number == i.id)[0][1].flag">
                                                <td data-dismiss="modal" v-on:click="push_question(i.id)" data-bs-dismiss="modal" style="cursor: pointer;" v-html="i.title"></td>
                                                <td>1</td>
                                                <td class="text-danger">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bookmark-check" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd" d="M10.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                                                        <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5V2zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1H4z"/>
                                                    </svg>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>

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
            @endif

            @if($video)
            <div class="col-xl-8 col-xxl-9 h-100" v-if="video_id">
                @if(isset($next_video) && $next_video)
                    <!--<a class="btn btn-success" href="{{route('PremiumQuiz-st3', [$package->package_id, 'chapter', $next_video->chapter_id, 'realtime']).'?video_id='.$next_video->video_id}}">Next</a>-->
                @endif
                
                <div class="card mb-5 h-100 bg-transparent" style="padding: 0;">
                    <div class="card-body mb-3" style="padding: 0;">
                     {!! $video->html !!}
                    </div>

                </div>
                <div class="page-title-container">
                    <h1 class="mb-0 pb-0 display-4">Video Content</h1>
                    <nav class="breadcrumb-container d-inline-block" aria-label="breadcrumb">
                        <ul class="breadcrumb pt-0">
                            <li class="breadcrumb-item"><a href="javascript:;">Description & Materials</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="card">
                    <div class="card-body">
                        <p>
                            {!! $video->description !!}
                        </p>
                        <hr>
                        <div class="d-flex flex-row flex-wrap">
                            @if($video->attachment_url)
                                <div class="sw-30 me-2 mb-2">
                                    <div class="row g-0 rounded-sm sh-8 border">
                                        <div class="col-auto">
                                            <div class="sw-10 d-flex justify-content-center align-items-center h-100">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="cs-icon cs-icon-file-text text-primary"><path d="M6.5 18H13.5C14.9045 18 15.6067 18 16.1111 17.6629C16.3295 17.517 16.517 17.3295 16.6629 17.1111C17 16.6067 17 15.9045 17 14.5V7.44975C17 6.83775 17 6.53175 16.9139 6.24786C16.8759 6.12249 16.8256 6.00117 16.7638 5.88563C16.624 5.62399 16.4076 5.40762 15.9749 4.97487L14.0251 3.02513L14.0251 3.02512C13.5924 2.59238 13.376 2.37601 13.1144 2.23616C12.9988 2.1744 12.8775 2.12415 12.7521 2.08612C12.4682 2 12.1622 2 11.5503 2H6.5C5.09554 2 4.39331 2 3.88886 2.33706C3.67048 2.48298 3.48298 2.67048 3.33706 2.88886C3 3.39331 3 4.09554 3 5.5V14.5C3 15.9045 3 16.6067 3.33706 17.1111C3.48298 17.3295 3.67048 17.517 3.88886 17.6629C4.39331 18 5.09554 18 6.5 18Z"></path><path d="M13 6 7 6M13 10 7 10M13 14 7 14"></path></svg>
                                            </div>
                                        </div>
                                        <div class="col rounded-sm-end d-flex flex-column justify-content-center pe-3">
                                            <div class="d-flex justify-content-between">
                                                <p class="mb-0 clamp-line" data-line="1" style="overflow: hidden; text-overflow: ellipsis; -webkit-box-orient: vertical; display: -webkit-box; -webkit-line-clamp: 1;">{{__('User/video.attachment')}}</p>
                                                <a href="{{route('download.material', $video->attachment_id )}}" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-delay="{&quot;show&quot;:&quot;1000&quot;, &quot;hide&quot;:&quot;0&quot;}" data-bs-original-title="Download">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="cs-icon cs-icon-download text-alternate"><path d="M2 14V14.5C2 15.9045 2 16.6067 2.33706 17.1111C2.48298 17.3295 2.67048 17.517 2.88886 17.6629C3.39331 18 4.09554 18 5.5 18H14.5C15.9045 18 16.6067 18 17.1111 17.6629C17.3295 17.517 17.517 17.3295 17.6629 17.1111C18 16.6067 18 15.9045 18 14.5V14"></path><path d="M14 10 10.7071 13.2929C10.3166 13.6834 9.68342 13.6834 9.29289 13.2929L6 10M10 2 10 13"></path></svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <p>{{__('User/video.no-resources')}}</p>
                            @endif


                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if($explanation)
            <div class="col-xl-8 col-xxl-9 h-100" v-if="explanation_id">
                <div class="card mb-5 h-100 ">
                    <div class="card-body mb-3">
                        {!! $explanation->explanation !!}
                    </div>
                </div>

            </div>
            @endif
            <div class="d-none d-xl-flex col-xl-4 col-xxl-3 h-100 scroll-out table-of-contents-scroll" id="tableOfContentsColumn">
                <!-- Content of this will be moved from #tableOfContentsMoveContent div based on the responsive breakpoint.  -->
            </div>

        </div>

        <!-- Content Menu -->
        <div class="modal modal-right fade" id="tableOfContentsModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Content</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0 px-1">
                        <!-- Content of below will be moved to #tableOfContentsColumn or back in here based on the data-move-breakpoint attribute below -->
                        <!-- Content will be here if the screen size is smaller than xl -->
                        <div id="tableOfContentsMoveContent" data-move-target="#tableOfContentsColumn" data-move-breakpoint="xl">
                            <!-- Table of Contents Start -->
                            <div id="courseContent">
                                <!-- Chapters -->
                                <div class="row my-1">
                                    <!-- Title Start -->
                                    <div class="col-12 col-sm-12">
                                        <h1 class="mb-0 pb-0 display-4" id="title">Chapters</h1>
                                    </div>
                                    <!-- Title End -->
                                </div>
                                <div class="card mb-2" v-for="i,idx in chapters_inc" v-if="i.questions_number > 1 || i.videos.length > 0 || i.explanations.length > 0">
                                    <div class="card-body">
                                        <div
                                                class="d-flex flex-row align-content-center align-items-center cursor-pointer"
                                                :class="topic_id == i.id && topic_type == i.key ? '': 'collapsed'"
                                                data-bs-toggle="collapse"
                                                :data-bs-target="'#chapterCollapse_'+i.id"
                                                :aria-expanded="topic_id == i.id && topic_type == i.key ? 'true': 'false'"
                                                :aria-controls="'chapterCollapse_'+i.id"
                                                @click="loadTopic('exam')"
                                        >
                                            <div class="sw-4 me-3">
                                                <div class="border border-1 border-primary rounded-xl sw-4 sh-4 text-primary d-flex justify-content-center align-items-center">
                                                    @{{ idx + 1 }}
                                                </div>
                                            </div>
                                            <div>
                                                <div class="heading mb-0">@{{ i.name }}</div>
                                            </div>
                                        </div>
                                        <div :id="'chapterCollapse_'+i.id" class="accordion-collapse collapse ms-2 ps-1 my-5" :class="topic_id == i.id && topic_type == i.key ? 'show': ''" data-bs-parent="#courseContent">
                                            <div class="row g-0 " v-for="j in i.videos.filter(row => !row.after_chapter_quiz)">
                                                <div class="col-auto sw-1 d-flex flex-column justify-content-center align-items-center position-relative me-4">
                                                    <div class="w-100 d-flex sh-1 position-relative justify-content-center">
                                                        <div class="line-w-1 bg-separator h-100 position-absolute" :class="isWatched(j.watched)"></div>
                                                    </div>
                                                    <div class="rounded-xl shadow d-flex flex-shrink-0 justify-content-center align-items-center">
                                                        <div class="sw-1 sh-1 rounded-xl position-relative" :class="isWatched(j.watched)"></div>
                                                    </div>
                                                    <div class="w-100 d-flex h-100 justify-content-center position-relative">
                                                        <div class="line-w-1 bg-separator h-100 position-absolute" :class="isWatched(j.watched)"></div>
                                                    </div>
                                                </div>
                                                <div class="col mb-2">
                                                    <div class="h-100">
                                                        <div class="d-flex flex-column justify-content-start">
                                                            <div class="d-flex flex-column">
                                                                <a :href="topicURL(i.key, i.id)+'?video_id='+j.video_id" class="heading" :class="itemHighlighted('video', j.video_id)">
                                                                    @{{ j.title }}
                                                                    <i style="float: right;">@{{ j.duration }}</i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row g-0 mt-4" v-if="i.questions_number > 1">
                                                <div class="col-auto sw-1 d-flex flex-column justify-content-center align-items-center position-relative me-4">
                                                    <div class="w-100 d-flex sh-1"></div>
                                                    <div class="rounded-xl shadow d-flex flex-shrink-0 justify-content-center align-items-center">
                                                        <div class="bg-muted sw-1 sh-1 rounded-xl position-relative" :class="isWatched(i.completedQuizNumber)"></div>
                                                    </div>
                                                    <div class="w-100 d-flex h-100 justify-content-center position-relative">
                                                        <div class="line-w-1 bg-separator h-100 position-absolute" ></div>
                                                    </div>
                                                </div>
                                                <div class="col mb-2">
                                                    <div class="h-100">
                                                        <div class="d-flex flex-column justify-content-start">
                                                            <div class="d-flex flex-column">
                                                                <a :href="topicURL(i.key, i.id)" class="heading" :class="itemHighlighted(i.key, i.id)">QUIZ</a>
                                                                <i v-if="i.savedQuizNumber > 0" style="color:#c6112d; float: right;"> [{{__('User/quiz.saved')}}]</i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row g-0" v-for="j in i.videos.filter(row => row.after_chapter_quiz)">
                                                <div class="col-auto sw-1 d-flex flex-column justify-content-center align-items-center position-relative me-4">
                                                    <div class="w-100 d-flex sh-1 position-relative justify-content-center">
                                                        <div class="line-w-1 bg-separator h-100 position-absolute"></div>
                                                    </div>
                                                    <div class="rounded-xl shadow d-flex flex-shrink-0 justify-content-center align-items-center">
                                                        <div class="bg-muted sw-1 sh-1 rounded-xl position-relative" :class="isWatched(j.watched)"></div>
                                                    </div>
                                                    <div class="w-100 d-flex h-100 justify-content-center position-relative">
                                                        <div class="line-w-1 bg-separator h-100 position-absolute"></div>
                                                    </div>
                                                </div>
                                                <div class="col mb-2">
                                                    <div class="h-100">
                                                        <div class="d-flex flex-column justify-content-start">
                                                            <div class="d-flex flex-column">
                                                                <a :href="topicURL(i.key, i.id)+'?video_id='+j.video_id" class="heading" :class="itemHighlighted('video', j.video_id)">
                                                                    @{{ j.title }}
                                                                    <i style="float: right;">@{{ j.duration }}</i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row g-0" :class="idx == 0 ? 'mt-4': ''" v-if="i.explanations.length > 0" v-for="j,idx in i.explanations">
                                                <div class="col-auto sw-1 d-flex flex-column justify-content-center align-items-center position-relative me-4">
                                                    <div class="w-100 d-flex sh-1" v-if="idx == 0"></div>
                                                    <div class="w-100 d-flex sh-1 position-relative justify-content-center" v-if="idx != 0">
                                                        <div class="line-w-1 bg-separator h-100 position-absolute"></div>
                                                    </div>
                                                    <div class="rounded-xl shadow d-flex flex-shrink-0 justify-content-center align-items-center">
                                                        <div class="sw-1 sh-1 rounded-xl position-relative" :class="isWatched(0)"></div>
                                                    </div>
                                                    <div class="w-100 d-flex h-100 justify-content-center position-relative">
                                                        <div class="line-w-1 bg-separator h-100 position-absolute"></div>
                                                    </div>
                                                </div>
                                                <div class="col mb-2">
                                                    <div class="h-100">
                                                        <div class="d-flex flex-column justify-content-start">
                                                            <div class="d-flex flex-column">
                                                                <a :href="topicURL(i.key, i.id)+'?explanation_id='+j.id" class="heading" :class="itemHighlighted('explanation', j.id)">@{{ j.title }}</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Exams -->
                                <div class="row my-1">
                                    <!-- Title Start -->
                                    <div class="col-12 col-sm-12">
                                        <h1 class="mb-0 pb-0 display-4" id="title">Exams</h1>
                                    </div>
                                    <!-- Title End -->
                                </div>
                                <div class="card mb-2">
                                    <div class="card-body">
                                        <div
                                                class="d-flex flex-row align-content-center align-items-center cursor-pointer"
                                                :class=" topic_type == 'exam' ? '': 'collapsed'"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#examCollapse"
                                                :aria-expanded="topic_type == 'exam' ? 'true': 'false'"
                                                aria-controls="examCollapse"
                                        >
                                            <div class="sw-4 me-3">
                                                <div class="border border-1 border-primary rounded-xl sw-4 sh-4 text-primary d-flex justify-content-center align-items-center">
                                                    #
                                                </div>
                                            </div>
                                            <div>
                                                <div class="heading mb-0">Exams</div>
                                            </div>
                                        </div>
                                        <div id="examCollapse" class="accordion-collapse collapse ms-2 ps-1" :class="topic_type == 'exam' ? 'show': ''" data-bs-parent="#courseContent">
                                            <div  class="row g-0" :class="idx == 0 ? 'mt-4': ''" v-for="i,idx in exams_inc" v-if="i.questions_number > 0">
                                                <div class="col-auto sw-1 d-flex flex-column justify-content-center align-items-center position-relative me-4">
                                                    <div class="w-100 d-flex sh-1" v-if="idx == 0"></div>
                                                    <div class="w-100 d-flex sh-1 position-relative justify-content-center" v-if="idx != 0">
                                                        <div class="line-w-1 bg-separator h-100 position-absolute"></div>
                                                    </div>
                                                    <div class="rounded-xl shadow d-flex flex-shrink-0 justify-content-center align-items-center">
                                                        <div class="sw-1 sh-1 rounded-xl position-relative" :class="isWatched(i.completedQuizNumber)"></div>
                                                    </div>
                                                    <div class="w-100 d-flex h-100 justify-content-center position-relative">
                                                        <div class="line-w-1 bg-separator h-100 position-absolute"></div>
                                                    </div>
                                                </div>

                                                <div class="col mb-2">
                                                    <div class="h-100">
                                                        <div class="d-flex flex-column justify-content-start">
                                                            <div class="d-flex flex-column">
                                                                <a :href="topicURL(i.key, i.id)" class="heading" :class="itemHighlighted(i.key, i.id)">
                                                                    @{{ i.name }}
                                                                    <i v-if="i.savedQuizNumber > 0" style="color:#c6112d; float: right;"> [{{__('User/quiz.saved')}}]</i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Table of Contents End -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Content End -->
    </div>
@endsection

@section('jscode')
    <script src="https://player.vimeo.com/api/player.js"></script>
    <script src="{{asset('user-assets/js/vendor/movecontent.js')}}"></script>
    <script src="https://unpkg.com/sweetalert2@7.8.2/dist/sweetalert2.all.js"></script>
    <script src="{{asset('helper/js/jQuery.tagify.min.js')}}"></script>
    @if(env('APP_ENV') == 'local')
        <script src="{{asset('helper/js/vue-dev.js')}}"></script>
    @else
        <script src="{{asset('helper/js/vue-prod.min.js')}}"></script>
    @endif
    <script src="{{asset('js/easyTimer.min.js')}}"></script>
    <script>
        (function() {
            $('#wrapper').show();
            $('#loading').hide();
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

                        },
                        error: function(res){
                            console.log('Error:', res);
                        }
                    });

                }
            });
        })();
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
            video_id: '{{request()->video_id}}',
            explanation_id: '{{request()->explanation_id}}',
            examTimeMin: '{{isset($examTimeMin) ? $examTimeMin: 0}}',
        };
    </script>
    <script src="{{asset('helper/js/quiz-V0.3.js')}}"></script>

    <script src="https://player.vimeo.com/api/player.js"></script>
    <script>
    
        
        
        $(function() {
            
            var iframe = document.querySelector('iframe');
            var player = new Vimeo.Player(iframe);
        
            player.on('loaded', function(){
                player.play();
            });
            player.on('ended', onFinish);
            
            // Call the API when a button is pressed
            function onFinish() {
                @if($next_video)
                    window.location.href = "{{route('PremiumQuiz-st3', [$package->package_id, 'chapter', $next_video->chapter_id, 'realtime']).'?video_id='.$next_video->video_id}}";
                @endif
            }
    
        });
    
    
    </script>
@endsection
