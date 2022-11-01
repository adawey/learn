<!doctype html>
<html lang="en" @if(app()->getLocale()  == 'ar') dir="rtl" @endif>

<head>

    <!-- Basic Page Needs
    ================================================== -->
    <title>{{$video->title}}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Courseplus - Professional Learning Management HTML Template">

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

    @if($video->wr_id)
    <link rel="stylesheet" href="https://cdn.plyr.io/3.6.2/plyr.css" />
    @endif
    <!-- icons
    ================================================== -->
    <link rel="stylesheet" href="{{asset('assetsV2/css/icons.css')}}">

    <style>
        @media print { body { display:none } }
        
        body, html{     
            /* Prevent selection */
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;  
        }
        
        @media only screen and (max-width: 770px) {
            .go-when-less-770 { display: none !important;}
            .remove-position-when-less-770 { position: relative !important;}
        }
        .style-ma-1 {
            min-height: 300px; background-color: white; min-width: 1024px; margin: 20px auto 0 auto; padding-top:30px;
        }
        .style-ma-2 {
            width: 1024px    ; margin:auto;
        }
        .style-ma-3 {
            padding: 20px;
        }
        .dont-hover {color: white !important; }
        .dont-hover:hover {
            color: white !important;
            text-decoration: none;
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
            font-size:100px;
            color:#ccc;
        }
        .rate:not(:checked) > label:before {
            font-family: "Font Awesome 5 Duotone";
            content: '★';
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

        /* circular progress bar */
        .progress {
            width: 42px;
            height: 42px;
            background: none;
            position: relative;
        }

        .progress::after {
            content: "";
            width: 100%;
            height: 100%;
            border-radius: 50%;
            border: 2px solid #eee;
            position: absolute;
            top: 0;
            left: 0;
        }

        .progress>span {
            width: 50%;
            height: 100%;
            overflow: hidden;
            position: absolute;
            top: 0;
            z-index: 1;
        }

        .progress .progress-left {
            left: 0;
        }

        .progress .progress-bar {
            width: 100%;
            height: 100%;
            background: none;
            border-width: 3px;
            border-style: solid;
            border-color: #07fc03 !important;
            position: absolute;
            top: 0;
        }

        .progress .progress-left .progress-bar {
            left: 100%;
            border-top-right-radius: 80px;
            border-bottom-right-radius: 80px;
            border-left: 0;
            -webkit-transform-origin: center left;
            transform-origin: center left;
        }

        .progress .progress-right {
            right: 0;
        }

        .progress .progress-right .progress-bar {
            left: -100%;
            border-top-left-radius: 80px;
            border-bottom-left-radius: 80px;
            border-right: 0;
            -webkit-transform-origin: center right;
            transform-origin: center right;
        }

         .progress-value {
            position: absolute;
            top: 0;
            left: 0;
        }
        .progress {
            display: inline-block;
            margin-left: 20px;
            margin-right: 10px;
        }


    </style>
</head>


<body class="">

<!-- Wrapper -->
<div id="wrapper">

    <div class="course-layouts" id="app-1">

        <div class="course-content bg-dark" style="order: 1;">
            <div class="course-header" @if(app()->getLocale() == 'ar') style="padding-left: 0 !important;" @endif>

                <h4 class="text-white"> {{$video->title}} </h4>

                <div style="display: flex; align-items: center; justify-content:center;">
                    <a class="dont-hover" href="#rating-form" uk-toggle>
                        <i class="icon-line-awesome-star-o btns" @if($package->userRatePackage) style="color:gold;" @endif > </i>
                        @if(!$package->userRatePackage)
                            {{__('User/video.leave-rating')}}
                        @else
                            {{__('User/video.update-rating')}}
                        @endif
                    </a>
                    <div id="rating-form" uk-modal>
                        <div class="uk-modal-dialog uk-modal-body" @if(app()->getLocale() == 'ar') style="text-align: right !important;" @endif>
                            <h2 class="uk-modal-title">{{__('User/video.rating-question')}}</h2>
                            <p>
                                <center>
                                    <p style="color:#333; font-size: 20px; font-weight: 10; min-height: 30px;">
                                        @{{rate_sentance}}
                                    </p>

                                    <div class="row rate" style=" min-height: 50px; margin: 0px 0 15px 0;">

                                        <input type="radio"  id="star5" v-model="rate_value" v-on:change="rate"  name="rate" value="5" />
                                        <label for="star5" title="text" @mouseover="rate_state('{{__('User/video.rate-statement-5')}}')"></label>


                                        <input type="radio"  id="star4" v-model="rate_value" v-on:change="rate"  name="rate" value="4" />
                                        <label for="star4" title="text" @mouseover="rate_state('{{__('User/video.rate-statement-4')}}')"></label>


                                        <input type="radio" id="star3"  v-model="rate_value" v-on:change="rate"  name="rate" value="3" />
                                        <label for="star3" title="text" @mouseover="rate_state('{{__('User/video.rate-statement-3')}}')"></label>


                                        <input type="radio"  id="star2" v-model="rate_value" v-on:change="rate"  name="rate" value="2" />
                                        <label for="star2" title="text" @mouseover="rate_state('{{__('User/video.rate-statement-2')}}')"></label>


                                        <input type="radio" id="star1" v-model="rate_value" v-on:change="rate"  name="rate" value="1" />
                                        <label for="star1" title="text" @mouseover="rate_state('{{__('User/video.rate-statement-1')}}')"></label>

                                    </div>

                                    <div class="row">
                                        <div class="col-md-12" id="rateTextBox" @if(!$package->userRatePackage) style="display:none;" @endif >
                                            <div class="form-group">
                                                <textarea v-model="user_review" placeholder="{{__('User/video.tell-us-something')}}" cols="30" rows="10" class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </center>
                            </p>
                            <p class="uk-text-right">
                                <button class="uk-button uk-button-default uk-modal-close" type="button">{{__('User/video.cancel')}}</button>
                                <a v-on:click="post_review" class="uk-modal-close uk-button uk-button-default" type="button">{{__('User/video.submit')}}</a>
                            </p>
                        </div>
                    </div>

                    <div class="uk-inline uk-display-inline-block">
                        <button class="uk-button-default" style="border:0; outline: 0;">
                            <div class="progress" data-value='{{$percentage}}'>
                                <span class="progress-left">
                                    <span class="progress-bar border-primary"></span>
                                </span>

                                <span class="progress-right">
                                    <span class="progress-bar border-primary"></span>
                                </span>

                                <div class="progress-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center" style="margin-top:3px;">
                                    <div class="h2 font-weight-bold" >
                                        <i class="icon-line-awesome-trophy icon-small btns" style="margin:0;"></i>
                                    </div>
                                </div>
                            </div>
                        </button>
                        <div uk-dropdown="pos:bottom-right" style="min-width:300px !important; font-size: 14px;">
                            {{$noCompletedVideos}} {{__('User/video.of')}} {{$noTotalVideos}} {{__('User/video.completed')}}.
                        </div>
                    </div>

                    @if($percentage == 100 && $package->certification == 1)
                        <a href="#certificate-form" uk-toggle class="dont-hover">
                            {{__('User/video.get-certificate')}}
                        </a>
                    @endif
                    @if($percentage == 100 && $package->certification == 1)
                        <div id="certificate-form" uk-modal>
                            <div class="uk-modal-dialog uk-modal-body" @if(app()->getLocale() == 'ar') style="text-align: right !important;" @endif>
                                <h2 class="uk-modal-title">{{__('User/video.course-certification')}}</h2>
                                <p>
                                @if(!$package->certification_id)
                                    <p>{{__('User/video.get-certificate-1')}}<br>{{__('User/video.get-certificate-2')}}</p>
                                @endif
                                <form action="{{route('generate.certification')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{$package->event_id}}">
                                    <input type="hidden" name="product_type" value="event">
                                    <div class="row">
                                        @if(!$package->certification_id)
                                            <div class="col-md-3">
                                                {{__('User/video.full-name')}}:
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" name="name" class="form-control" required>
                                            </div>
                                        @else
                                            <input type="hidden" name="name" value="0">
                                        @endif
                                    </div>
                                    <hr style="margin: 20px 0 0 0;">
                                    <p class="uk-text-right" style="margin: 15px 0 10px 0;">
                                        <button type="submit" type="button"  class="uk-button uk-button-default">{{__('User/video.get-certificate')}}</button>
                                        <button class="uk-button uk-button-default uk-modal-close" type="button">{{__('User/video.cancel')}}</button>
                                    </p>
                                </form>
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
            <div class="course-content-inner" style="height: 650px !important;">
                <div class="video-responsive">

                    @if($video->vimeo_id)
                        <iframe id="player1" src="https://player.vimeo.com/video/{{$video->vimeo_id}}?api=1&player_id=player1" width="100%" height="400px" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
                    @elseif($video->wr_id)
                        <video id="player" playsinline controls>
                            <source src="{{$watch_link}}" type="video/mp4" />
                        </video>
                    @endif
                </div>

            </div>
            <div class="style-ma-1">
                <nav class="responsive-tab style-5 style-ma-2">
                    <ul uk-switcher="connect: #course-intro-tab ;animation: uk-animation-slide-right-medium, uk-animation-slide-left-medium">
                        <li><a href="#">{{__('User/video.course-description')}}</a></li>
                        <li><a href="#">{{__('User/video.resources')}}</a></li>
                        <li><a href="#">{{__('User/video.q-and-a')}}</a></li>
                    </ul>
                </nav>
                <hr style="margin-top: 0; padding-top:0;">
                <ul id="course-intro-tab" class="uk-switcher style-ma-2 style-ma-3" @if(app()->getLocale() == 'ar') style="text-align: right;" @endif>
                    <!-- course description -->
                    <li class="course-description-content">
                        <h3>{{__('User/video.description')}}</h3>
                        <p>
                            {!! $eventModelTranscode['description'] !!}
                        </p>
                        <h3>{{__('User/video.what-you-learn')}}</h3>

                        {!! $eventModelTranscode['what_you_learn'] !!}
                        <hr>
                        <h3>{{__('User/video.requirement')}}</h3>

                        {!! $eventModelTranscode['requirement'] !!}
                        <hr>
                        <hr>
                        <h3>{{__('User/video.who-for')}}</h3>
                        <p>
                            {!! $eventModelTranscode['who_course_for'] !!}
                        </p>
                    </li>
                    <li class="course-description-content">
                        @if($video->attachment_url)

                            <div class="row">
                                {{__('User/video.attachment')}}: <a href=" {{route('download.material', \App\Material::where('file_url', '=', $video->attachment_url)->get()->first()->id )}}" class="btn green">   <i class="fa fa-download"></i></a>

                            </div>
                        @else
                            <p>{{__('User/video.no-resources')}}</p>
                        @endif
                    </li>
                    <li class="course-description-content">
                        <div class="comments">
                            <ul>
                                @foreach($comments as $comment)
                                <li>
                                    @php
                                        $profile_pic = asset('assets/layouts/layout/img/avatar3_small.jpg');
                                        $ud = App\UserDetail::where('user_id', '=', $comment->user_id)->get()->first();
                                        if($ud){
                                            if($ud->profile_pic){
                                                $profile_pic =url('storage/profile_picture/'.basename($ud->profile_pic));
                                            }
                                        }
                                    @endphp

                                    <div class="comments-avatar">
                                        <img src="{{$profile_pic}}" alt="">
                                    </div>
                                    <div class="comment-content">
                                        <div class="comment-by">{{\App\User::find($comment->user_id)->name}} <span>{{$comment->created_at->diffForHumans()}}</span>
                                        <a @click.prevent="ShowReplyForm({{$comment->id}})" class="reply"><i class="icon-line-awesome-undo"></i> {{__('User/video.reply')}}</a>
                                        </div>
                                        <p> {{$comment->contant}} </p>
                                    </div>

                                    <ul>
                                        <li id="reply-form-{{$comment->id}}"></li>
                                        @foreach(\App\Comment::whereIn('id', \App\Reply::where('reply_to_id','=',$comment->id)->pluck('comment_id')->toArray() )->orderBy('created_at', 'desc')->get() as $reply)
                                            @php
                                                $profile_pic = asset('assets/layouts/layout/img/avatar3_small.jpg');
                                                $ud = App\UserDetail::where('user_id', '=', $reply->user_id)->get()->first();
                                                if($ud){
                                                    if($ud->profile_pic){
                                                        $profile_pic =url('storage/profile_picture/'.basename($ud->profile_pic));
                                                    }
                                                }
                                            @endphp

                                            <li id="reply-form-{{$comment->id}}">
                                            <div class="comments-avatar"><img src="{{$profile_pic}}" alt="">
                                            </div>
                                            <div class="comment-content">
                                                <div class="comment-by">{{\App\User::find($reply->user_id)->name}}<span>{{$reply->created_at->diffForHumans()}}</span>

                                                </div>
                                                <p> {{$reply->contant}} </p>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>

                                </li>
                                @endforeach


                            </ul>


                            <h3>{{__('User/video.submit-review')}} </h3>
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
                                    <div class="comments-avatar"><img src="{{$profile_pic}}" alt="">
                                    </div>
                                    <div class="comment-content">
                                        <form class="uk-grid-small" action="{{route('comment.store')}}" method="post" uk-grid>
                                            @csrf
                                            <input type="hidden" name="page" value="event{{$event->id}}video">
                                            <input type="hidden" name="item_id" value="{{$video->video_id}}">
                                            <div class="uk-width-1-1@s">
                                                <label class="uk-form-label">{{__('User/video.comment')}}</label>
                                                <textarea class="uk-textarea"
                                                          name="contant"
                                                          placeholder="{{__('User/video.enter-comment-here')}}"
                                                          style=" height:160px" required></textarea>
                                            </div>
                                            <div class="uk-grid-margin">
                                                <input type="submit" value="{{__('User/video.submit')}}" class="btn btn-default">
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
            <div class="course-sidebar-title" style="justify-content: space-between; width: 100%;">
                <h3> {{__('User/video.table-of-content')}}</h3> <span> {{$total_time[0]}} {{__('User/video.hr')}} {{$total_time[1]}} {{__('User/video.min')}} </span>
            </div>
            <div class="course-sidebar-container">

                <ul class="course-video-list-section" uk-accordion>

                    @foreach($chapters as $chapter)
                        @if(count($chapter->videos))
                            <li class="@if($chapter_id == $chapter->id) uk-open @endif">
                                <a class="uk-accordion-title" style="@if(app()->getLocale() == 'ar') text-align:right; @endif" href="#"> {{$chapter->name}} <span style="float:{{app()->getLocale() == 'ar' ? 'left': 'right'}}; margin-right: 7px;">{{$chapter->total_time_toString}}</span> </a>
                                <div class="uk-accordion-content">
                                    <!-- course-video-list -->
                                    <ul class="course-video-list highlight-watched">
                                        @foreach($chapter->videos as $v)
                                            <li class="@if($v->watched) watched @endif"  style="text-align:{{app()->getLocale() == 'ar' ? 'right':'left'}}">
                                                @php
                                                    $vuri = route('event_vid', [$package->event_id, 'chapter', $chapter->id, $v->video_id]);
                                                    if(!$video->watched){
                                                        $vuri .= '?watched='.$video->video_id;
                                                    }
                                                @endphp
                                                <a href="{{$vuri}}">
                                                    {{$v->title}}
                                                    <span> {{\Carbon\Carbon::parse($v->duration)->format('i')}} Min </span>
                                                    @if($video->attachment_url)
                                                    <div style="text-align: left;">
                                                        <button class="uk-button uk-button-default" style="padding: 5px 7px; margin:0;" type="button">
                                                            <i class="icon-material-outline-library-books"></i>
                                                            {{__('User/video.resource')}}
                                                        </button>
                                                        <div uk-dropdown="mode: click, pos: right-center" @click.prevent="goto('{{route('download.material', \App\Material::where('file_url', '=', $video->attachment_url)->get()->first()->id )}}')" style="margin:0; padding: 10px 0 10px 10px; text-align: left;">
                                                            file name
                                                        </div>
                                                    </div>
                                                    @endif
                                                </a>

                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                        @endif
                    @endforeach
                </ul>

            </div>

        </div>

    </div>



</div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <script>

        (function (window, document, undefined) {

            $(".progress").each(function() {

                var value = $(this).attr('data-value');
                var left = $(this).find('.progress-left .progress-bar');
                var right = $(this).find('.progress-right .progress-bar');

                if (value > 0) {
                    if (value <= 50) {
                        right.css('transform', 'rotate(' + percentageToDegrees(value) + 'deg)')
                    } else {
                        right.css('transform', 'rotate(180deg)')
                        left.css('transform', 'rotate(' + percentageToDegrees(value - 50) + 'deg)')
                    }
                }

            });
            
            
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

            function percentageToDegrees(percentage) {

                return percentage / 100 * 360

            }

        })(window, document);
    </script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>
    <script>
    var app = new Vue({
        el: '#app-1',
        data: {
            event_id: '{{$event->id}}',
            rate_value: 0,
            rate_sentance: '',
            user_review: '',
        },
        methods: {
            goto: function(url){
                window.location.replace(url);
            },
            _: function (ele) {
                return document.getElementById(ele);
            },
            ShowRate: function () {
                $('#myModalRating').show();
            },
            HideRate: function () {
                $('#myModalRating').hide();
            },
            post_review: function () {
                Data = {
                    user_review: this.user_review,
                    event_id: this.event_id
                };


                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    }
                });

                $.ajax({
                    type: 'POST',
                    url: '{{ route('user.review')}}',
                    data: Data,
                    success: function (res) {
                    },
                    error: function (res) {
                        console.log('Error:', res);
                    }


                });

            },
            rate_state: function (r_s) {
                this.rate_sentance = r_s;
            },
            rate: function () {

                Data = {
                    rate: this.rate_value,
                    event_id: this.event_id
                };


                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}',
                    }
                });

                $.ajax({
                    type: 'POST',
                    url: '{{ route('user.rate')}}',
                    data: Data,
                    success: function (res) {
                        $("#rateTextBox").slideDown();
                    },
                    error: function (res) {
                        console.log('Error:', res);
                    }


                });


            },
            ShowReplyForm: function (comment_id) {
                if (this._('reply-form-' + comment_id).innerHTML == '') {
                    this._('reply-form-' + comment_id).innerHTML = '<div class="row"><div class="col-md-10 col-md-offset-2"><form action="{{route("comment.reply")}}" method="post">@csrf<input type="hidden" name="reply_to_id" value="' + comment_id + '"><div class="form-group col-md-8" style="padding-left: 0 !important;"><textarea rows="1" name="contant" required placeholder="Write comment here ..." class="form-control c-square"></textarea></div><div class="form-group col-md-4"><div class="row"><button type="submit" class="btn blue uppercase btn-md col-md-6 sbold">Reply</button></div></div></form></div></div>';
                } else {
                    this._('reply-form-' + comment_id).innerHTML = '';
                }
            },
            removeReplyForm: function (comment_id) {
                this._('reply-form-' + comment_id).innerHTML = '';
                alert('ok');
            },

        }
    });
</script>
<script>
        (function() {
            $('#wrapper').show();
            $('#loading').hide();
        })();
        
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
</script>


    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <script>
        function make_button_active(tab) {
            //Get item siblings
            var siblings = tab.siblings();

            /* Remove active class on all buttons
            siblings.each(function(){
                $(this).removeClass('active');
            }) */

            //Add the clicked button class
            tab.addClass('watched');
        }

        // Attach events to highlight-watched
        // $(document).ready(function () {
        //
        //     if (localStorage) {
        //         var ind = localStorage['tab']
        //         make_button_active($('.highlight-watched li').eq(ind));
        //     }
        //
        //     $(".highlight-watched li").click(function () {
        //         if (localStorage) {
        //             localStorage['tab'] = $(this).index();
        //         }
        //         make_button_active($(this));
        //     });
        //
        // });
    </script>

@if($video->wr_id)
    <script src="https://cdn.plyr.io/3.6.2/plyr.js"></script>
    <script>
        const player = new Plyr('#player');
    </script>
@elseif($video->vimeo_id)
        
    <script src="https://f.vimeocdn.com/js/froogaloop2.min.js"></script>
    <!--<script src="https://player.vimeo.com/api/player.js"></script>-->
    <script>
    
        $(function() {
            var iframe = $('#player1')[0];
            var player = $f(iframe);
    
    
            // When the player is ready, add listeners for pause, finish, and playProgress
            player.addEvent('ready', function() {
                // player.addEvent('finish', onFinish);
            });
    
            // Call the API when a button is pressed
            function onFinish() {
    
    
                Data = {
                    event_id  : {{$event->id}},
                    video_id    : {{$video->video_id}},
                    complete    : 1
    
                };
    
    
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
    
                $.ajax ({
                    type: 'POST',
                    url: '{{ route('Event.PremiumQuiz.VideoComplete')}}',
                    data: Data,
                    success: function(res){
                        @if($next_video)
                            window.location.href = "{{route('event_vid', [$event->id, $topic, $next_video->chapter, $next_video->video_id])}}";
                        @endif
    
                    },
                    error: function(res){
                        console.log('Error:', res);
                    }
                });
            }
    
        });
    
    
    </script>
    

@endif









<!-- javaScripts
================================================== -->
<script src="{{asset('assetsV2/js/framework.js')}}"></script>
<script src="{{asset('assetsV2/js/jquery-3.3.1.min.js')}}"></script>
<script src="{{asset('assetsV2/js/simplebar.js')}}"></script>
<script src="{{asset('assetsV2/js/main.js')}}"></script>
<script src="{{asset('assetsV2/js/bootstrap-select.min.js')}}"></script>


</body>

</html>
