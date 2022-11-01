<!doctype html>
<html lang="en" {{app()->getLocale() == 'ar'? 'dir=rtl':'dir=ltr'}}>

<head>

    <!-- Basic Page Needs
    ================================================== -->
    <title>{{Transcode::evaluate($i->event)['name'] }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link href="{{asset('assetsV2/images/favicon.png')}}" rel="icon" type="image/png">

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

<!-- icons
    ================================================== -->
    <link rel="stylesheet" href="{{asset('assetsV2/css/icons.css')}}">


    <link rel="stylesheet" href="{{asset('indexassets/css/owl.carousel.css')}}">
    <link rel="stylesheet" href="{{asset('indexassets/css/fontawesome-all.css')}}">
    <link rel="stylesheet" href="{{asset('indexassets/css/flaticon.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('indexassets/css/meanmenu.css')}}">
    <link rel="stylesheet" href="{{asset('indexassets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('indexassets/css/video.min.css')}}">
    <link rel="stylesheet" href="{{asset('indexassets/css/lightbox.css')}}">
    <link rel="stylesheet" href="{{asset('indexassets/css/progess.css')}}">
    <link rel="stylesheet" href="{{asset('indexassets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('indexassets/css/responsive.css')}}">


    <link rel="stylesheet"  href="{{asset('indexassets/css/colors/switch.css')}}">
    <link href="{{asset('indexassets/css/colors/color-2.css')}}" rel="alternate stylesheet" type="text/css" title="color-2">
    <link href="{{asset('indexassets/css/colors/color-3.css')}}" rel="alternate stylesheet" type="text/css" title="color-3">
    <link href="{{asset('indexassets/css/colors/color-4.css')}}" rel="alternate stylesheet" type="text/css" title="color-4">
    <link href="{{asset('indexassets/css/colors/color-5.css')}}" rel="alternate stylesheet" type="text/css" title="color-5">
    <link href="{{asset('indexassets/css/colors/color-6.css')}}" rel="alternate stylesheet" type="text/css" title="color-6">
    <link href="{{asset('indexassets/css/colors/color-7.css')}}" rel="alternate stylesheet" type="text/css" title="color-7">
    <link href="{{asset('indexassets/css/colors/color-8.css')}}" rel="alternate stylesheet" type="text/css" title="color-8">
    <link href="{{asset('indexassets/css/colors/color-9.css')}}" rel="alternate stylesheet" type="text/css" title="color-9">

    <style>
        .form-row {
            width: 70%;
            float: left;
            background-color: #ededed;
        }
        #card-element {
            background-color: transparent;
            height: 40px;
            border-radius: 4px;
            border: 1px solid transparent;
            box-shadow: 0 1px 3px 0 #e6ebf1;
            -webkit-transition: box-shadow 150ms ease;
            transition: box-shadow 150ms ease;
        }

        #card-element--focus {
            box-shadow: 0 1px 3px 0 #cfd7df;
        }

        #card-element--invalid {
            border-color: #fa755a;
        }

        #card-element--webkit-autofill {
            background-color: #fefde5 !important;
        }

        #submitbutton,#tap-btn{
            align-items:flex-start;
            background-attachment:scroll;background-clip:border-box;
            background-color:rgb(50, 50, 93);background-image:none;
            background-origin:padding-box;
            background-position-x:0%;
            background-position-y:0%;
            background-size:auto;
            border-bottom-color:rgb(255, 255, 255);
            border-bottom-left-radius:4px;
            border-bottom-right-radius:4px;border-bottom-style:none;
            border-bottom-width:0px;border-image-outset:0px;
            border-image-repeat:stretch;border-image-slice:100%;
            border-image-source:none;border-image-width:1;
            border-left-color:rgb(255, 255, 255);
            border-left-style:none;
            border-left-width:0px;
            border-right-color:rgb(255, 255, 255);
            border-right-style:none;
            border-right-width:0px;
            border-top-color:rgb(255, 255, 255);
            border-top-left-radius:4px;
            border-top-right-radius:4px;
            border-top-style:none;
            border-top-width:0px;
            box-shadow:rgba(50, 50, 93, 0.11) 0px 4px 6px 0px, rgba(0, 0, 0, 0.08) 0px 1px 3px 0px;
            box-sizing:border-box;color:rgb(255, 255, 255);
            cursor:pointer;
            display:block;
            float:left;
            font-family:"Helvetica Neue", Helvetica, sans-serif;
            font-size:15px;
            font-stretch:100%;
            font-style:normal;
            font-variant-caps:normal;
            font-variant-east-asian:normal;
            font-variant-ligatures:normal;
            font-variant-numeric:normal;
            font-weight:600;
            height:35px;
            letter-spacing:0.375px;
            line-height:35px;
            margin-bottom:0px;
            margin-left:12px;
            margin-right:0px;
            margin-top:28px;
            outline-color:rgb(255, 255, 255);
            outline-style:none;
            outline-width:0px;
            overflow-x:visible;
            overflow-y:visible;
            padding-bottom:0px;
            padding-left:14px;
            padding-right:14px;
            padding-top:0px;
            text-align:center;
            text-decoration-color:rgb(255, 255, 255);
            text-decoration-line:none;
            text-decoration-style:solid;
            text-indent:0px;
            text-rendering:auto;
            text-shadow:none;
            text-size-adjust:100%;
            text-transform:none;
            transition-delay:0s;
            transition-duration:0.15s;
            transition-property:all;
            transition-timing-function:ease;
            white-space:nowrap;
            width:150.781px;
            word-spacing:0px;
            writing-mode:horizontal-tb;
            -webkit-appearance:none;
            -webkit-font-smoothing:antialiased;
            -webkit-tap-highlight-color:rgba(0, 0, 0, 0);
            -webkit-border-image:none;

        }

    </style>

</head>

<body>

<div id="wrapper">

    <!-- Header Container
    ================================================== -->
    @include('include.header1')

    <!-- content -->
    <div class="page-content" id="app-1">

        <div class="course-details-wrapper topic-1 uk-light pt-5">

            <div class="container p-sm-0">

                <div uk-grid>
                    <div class="uk-width-2-3@m">

                        <div class="course-details">
                            <h1 style="margin:50px 0;" class="{{app()->getLocale() == 'ar'? 'text-right':''}}"> {{Transcode::evaluate($i->event)['name'] }}</h1>
                            <p>  </p>

                            <div class="course-details-info mt-4">
                                <ul>
                                    <li>
                                        <div class="star-rating">
                                            <span class="avg"> {{round($i->total_rate, 2) }} </span>
                                            @for($j=0; $j< round($i->total_rate); $j++)
                                                <span class="star"></span>
                                            @endfor
                                        </div>
                                    </li>
                                    <!--<li> <i class="icon-feather-users"></i> {{$i->users_no}} {{__('Public/package.enrolled')}} </li>-->
                                </ul>
                            </div>

                            <div class="course-details-info">

                                <ul>
                                    <li> {{__('Public/package.created-by')}} <a href="#"> Elsayed Mohsen </a> </li>
                                </ul>

                            </div>
                        </div>
                        <nav class="responsive-tab style-5">
                            <ul
                                    uk-switcher="connect: #course-intro-tab ;animation: uk-animation-slide-right-medium, uk-animation-slide-left-medium">
                                <li><a href="#">{{__('Public/package.overview')}}</a></li>
                                <li><a href="#">{{__('Public/package.curriculum')}}</a></li>
                                <li><a href="#">{{__('Public/package.reviews')}}</a></li>
                            </ul>
                        </nav>

                    </div>
                </div>

            </div>
        </div>

        <div class="container">

            <div class="uk-grid-large mt-4" uk-grid>
                <div class="uk-width-2-3@m">
                    <ul id="course-intro-tab" class="uk-switcher mt-4 {{app()->getLocale() == 'ar'? 'text-right':''}}">

                        <!-- course description -->
                        <li class="course-description-content">
                            @if($i->event->free_package_id)
                                <h4>Free Pacakge Included</h4>
                                <p>{{\App\Packages::find($i->event->free_package_id)->name}}</p>
                            @endif
                            <h4> {{__('Public/package.description')}} </h4>
                            <p>{!!  Transcode::evaluate($i->event)['description'] !!} </p>

                            <h4> {{__('Public/package.what-you-learn')}} </h4>
                            {!! Transcode::evaluate($i->event)['what_you_learn'] !!}

                            <h4> {{__('Public/package.requirements')}} </h4>
                            {!! Transcode::evaluate($i->event)['requirement'] !!}

                            <h4> {{__('Public/package.who-course-for')}} </h4>
                            <p> {!!  Transcode::evaluate($i->event)['who_course_for']!!} </p>


                        </li>

                        <!-- course Curriculum-->

                        <li>

                            <div class="uk-card uk-card-primary uk-card-hover uk-card-body uk-light">
                                <h3 class="uk-card-title" style="display:inline-block;">{{__('Public/package.course')}} <b>{{__('Public/package.content')}}:</b></h3>
                                <span style="display:inline-block; float:{{app()->getLocale() == 'ar'? 'left': 'right'}};">
                                    {{$i->event->total_time}} | {{$i->event->total_lecture}} {{__('Public/package.lectures')}}
                                </span>
                            </div>
                            <ul class="course-curriculum" uk-accordion="multiple: true">

                                @foreach(\App\Chapters::where(['course_id' => $i->event->course_id])->get() as $chapter)

                                    <li>
                                        <a class="uk-accordion-title" href="#">
                                            {{Transcode::evaluate($chapter)['name']}}
                                        </a>
                                    </li>

                                @endforeach


                            </ul>

                        </li>
                        <!-- course Reviews-->
                        <li>

                            <div class="review-summary">
                                <h4 class="review-summary-title"> {{__('Public/package.student-feedback')}} </h4>
                                <div class="review-summary-container">
                                    <div class="review-summary-avg">
                                        <div class="avg-number">
                                            {{round($i->total_rate,1)}}
                                        </div>
                                        <div class="review-star">
                                            <div class="star-rating">
                                                @for($j=0; $j< round($i->total_rate); $j++)
                                                    <span class="star"></span>
                                                @endfor
                                            </div>
                                        </div>
                                        <span>{{__('Public/package.course-rate')}}</span>
                                    </div>

                                    @php
                                        $star5percentage = 0;
                                        $star4percentage = 0;
                                        $star3percentage = 0;
                                        $star2percentage = 0;
                                        $star1percentage = 0;
                                        $reviews_count = count(\App\Rating::where('event_id', $i->event->id)->get());
                                        if( count(\App\Rating::where('event_id', $i->event->id)->get()) ){
                                            $star5percentage = round(count(\App\Rating::where('event_id', $i->event->id)->where('rate', 5)->get())/ count(\App\Rating::where('event_id', $i->event->id)->get())   *100);
                                            $star4percentage = round(count(\App\Rating::where('event_id', $i->event->id)->where('rate', 4)->get())/ count(\App\Rating::where('event_id', $i->event->id)->get())   *100);
                                            $star3percentage = round(count(\App\Rating::where('event_id', $i->event->id)->where('rate', 3)->get())/ count(\App\Rating::where('event_id', $i->event->id)->get())   *100);
                                            $star2percentage = round(count(\App\Rating::where('event_id', $i->event->id)->where('rate', 2)->get())/ count(\App\Rating::where('event_id', $i->event->id)->get())   *100);
                                            $star1percentage = round(count(\App\Rating::where('event_id', $i->event->id)->where('rate', 1)->get())/ count(\App\Rating::where('event_id', $i->event->id)->get())   *100);
                                        }
                                    @endphp

                                    <div class="review-summary-rating">
                                        <div class="review-summary-rating-wrap">
                                            <div class="review-bars">
                                                <div class="full_bar">
                                                    <div class="bar_filler" style="width:{{$star5percentage}}%"></div>
                                                </div>
                                            </div>
                                            <div class="review-stars">
                                                <div class="star-rating"><span class="star"></span><span
                                                            class="star"></span><span class="star"></span><span
                                                            class="star"></span><span class="star"></span></div>
                                            </div>
                                            <div class="review-avgs">
                                                {{$star5percentage}} %
                                            </div>
                                        </div>
                                        <div class="review-summary-rating-wrap">
                                            <div class="review-bars">
                                                <div class="full_bar">
                                                    <div class="bar_filler" style="width:{{$star4percentage}}%"></div>
                                                </div>
                                            </div>
                                            <div class="review-stars">
                                                <div class="star-rating"><span class="star"></span><span
                                                            class="star"></span><span class="star"></span><span
                                                            class="star"></span><span class="star empty"></span>
                                                </div>
                                            </div>
                                            <div class="review-avgs">
                                                {{$star4percentage}} %
                                            </div>
                                        </div>
                                        <div class="review-summary-rating-wrap">
                                            <div class="review-bars">
                                                <div class="full_bar">
                                                    <div class="bar_filler" style="width:{{$star3percentage}}%"></div>
                                                </div>
                                            </div>
                                            <div class="review-stars">
                                                <div class="star-rating"><span class="star"></span><span
                                                            class="star"></span><span class="star"></span><span
                                                            class="star empty"></span><span class="star empty"></span>
                                                </div>
                                            </div>
                                            <div class="review-avgs">
                                                {{$star3percentage}} %
                                            </div>
                                        </div>
                                        <div class="review-summary-rating-wrap">
                                            <div class="review-bars">
                                                <div class="full_bar">
                                                    <div class="bar_filler" style="width:{{$star2percentage}}%"></div>
                                                </div>
                                            </div>
                                            <div class="review-stars">
                                                <div class="star-rating"><span class="star"></span><span
                                                            class="star"></span><span class="star empty"></span><span
                                                            class="star empty"></span><span class="star empty"></span>
                                                </div>
                                            </div>
                                            <div class="review-avgs">
                                                {{$star2percentage}} %
                                            </div>
                                        </div>
                                        <div class="review-summary-rating-wrap">
                                            <div class="review-bars">
                                                <div class="full_bar">
                                                    <div class="bar_filler" style="width:{{$star1percentage}}%"></div>
                                                </div>
                                            </div>
                                            <div class="review-stars">
                                                <div class="star-rating"><span class="star"></span><span
                                                            class="star empty"></span><span
                                                            class="star empty"></span><span
                                                            class="star empty"></span><span class="star empty"></span>
                                                </div>
                                            </div>
                                            <div class="review-avgs">
                                                {{$star1percentage}} %
                                            </div>
                                        </div>


                                    </div>

                                </div>
                            </div>

                            <div class="comments">
                                <h4>{{__('Public/package.reviews')}} <span class="comments-amount"> ({{$reviews_count}}) </span> </h4>

                                <ul>

                                    @foreach(\App\Rating::where("event_id", $i->event->id)->orderBy('created_at', 'desc')->paginate(8) as $rate)
                                        @if(\App\User::find($rate->user_id))
                                        <li>
                                            @php
                                                $pic = asset('storage/icons/user/'.rand(1,3).'.png');
                                                if(\App\UserDetail::where('user_id', $rate->user_id)->first()){
                                                    if(\App\UserDetail::where('user_id', $rate->user_id)->get()->first()->profile_pic != null ){
                                                        $pic = url('storage/profile_picture/'.basename(\App\UserDetail::where('user_id', $rate->user_id)->get()->first()->profile_pic));
                                                    }
                                                }
                                            @endphp
                                            <div class="comments-avatar"><img src="{{$pic}}" alt="">
                                            </div>
                                            <div class="comment-content">
                                                <div class="comment-by">{{\App\User::find($rate->user_id)->name}}<span>{{__('Public/package.student')}}</span>
                                                    <div class="comment-stars">
                                                        <div class="star-rating">
                                                            @for($j=0; $j< round($rate->rate); $j++)
                                                                <span class="star"></span>
                                                            @endfor
                                                        </div>
                                                    </div>
                                                </div>
                                                <p>
                                                    {{$rate->review}}
                                                </p>
                                                @if(Auth::guard('admin')->check())
                                                <div class="comment-footer">
                                                    <span> {{__('Public/package.was-this-helpful')}} </span>
                                                    <a href="{{route('delete.package.review', $rate->id)}}"> {{__('Public/package.delete')}}</a> |
                                                    <a v-on:click="showReplyForm('reply_form_{{$rate->id}}')">{{__('Public/package.reply')}}</a>
                                                    <form action="{{route('rate.store.nested')}}" method="post" style="display:none;" id="reply_form_{{$rate->id}}">
                                                        @csrf
                                                        <input type="hidden" name="rate_id" value="{{$rate->id}}">
                                                        <div class="form-group">
                                                            <textarea rows="8" name="contant" placeholder="{{__('Public/package.write-comment-here')}}" class="form-control c-square"></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <button type="submit" class="btn blue uppercase btn-md sbold btn-block">{{__('Public/package.submit')}}</button>
                                                        </div>
                                                    </form>
                                                </div>
                                                @endif
                                                @php
                                                    $comments_id = \App\PageComment::where('page', '=', 'rate')->where('item_id', '=', $rate->id)->pluck('comment_id')->toArray();
                                                    $comments = \App\Comment::whereIn('id', $comments_id)->orderBy('created_at', 'desc')->get();
                                                @endphp

                                                <ul style="margin-left:0 !important;">
                                                    @foreach($comments as $comment)

                                                        <li>
                                                            <div class="comments-avatar"><img src="{{asset('storage/icons/user/'.rand(1,3).'.png')}}" alt="">
                                                            </div>
                                                            <div class="comment-content">
                                                                <div class="comment-by">{{\App\Admin::find( $comment->user_id )->name}}<span>{{__('Public/package.admin')}}</span>
                                                                </div>
                                                                <p>
                                                                    {{$comment->contant}}
                                                                </p>
                                                        </li>
                                                    @endforeach
                                                </ul>



                                            </div>

                                        </li>
                                        @endif
                                    @endforeach


                                </ul>

                            </div>

                        </li>

                    </ul>
                </div>

                <div class="uk-width-1-3@m">
                    <div class="course-card-trailer" uk-sticky="top: 10 ;offset:95 ; media: @m ; bottom:true">

                        <div class="course-thumbnail">
                            <img src="{{ url('storage/events/'.basename($i->event->img))}}" alt="">
                        </div>

                        <div class="p-3">

                            <p class="my-3 text-center">
                                <span class="uk-h1"> {{$pricing['localized_price'] - $pricing['localized_coupon_discount']}} {{$pricing['currency_code']}}  </span>
                                <s class="uk-h4 text-muted"> {{ $pricing['localized_original_price'] }} {{$pricing['currency_code']}} </s>
                            </p>

                            <div class="uk-child-width-1-1 uk-grid-small mb-4" uk-grid>
                                <div>
                                    @if( !( Auth::check() && (\App\EventUser::where('user_id','=', Auth::user()->id)->where('event_id','=',$i->event->id)->get()->first()) ))
                                        <a href="#PaymentModal" uk-toggle v-on:click="regenerate_price"
                                           class="uk-width-1-1 btn btn-default transition-3d-hover"> <i
                                                    class="uil-play"></i> Enroll </a>
                                    @endif
                                </div>
                            </div>

                            @if( !( Auth::check() && (\App\EventUser::where('user_id','=', Auth::user()->id)->where('event_id','=',$i->event->id)->get()->first()) ))
                            <!-- payment modal -->
                            <div id="PaymentModal" uk-modal>
                                <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">
                                    <div>
                                        <ul class="uk-child-width-expand" uk-tab>
                                            <li>
                                                <a href="#">
                                                    <img style="width: 60px; height: 30px;" src="{{env('APP_URL')}}/img/visa-master.jpg">
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <img style="width: 30px; height: 30px;" src="https://urway.sa/wp-content/uploads/2019/07/mada3.png">
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <img src="https://www.paypalobjects.com/webstatic/mktg/Logo/pp-logo-100px.png" alt="">
                                                </a>
                                            </li>

                                        </ul>

                                        <ul class="uk-switcher uk-margin">
                                            <li>
                                                <p class="alert alert-danger" v-if="error != ''">@{{ error }}</p>

                                                <p v-if="discount > 0">
                                                    Coupon Code: @{{coupon}}
                                                    <b v-if="discount > 0" style="color:green;">Valid</b>
                                                    <b v-if="discount <= 0" style="color:green;">Expired</b><br>
                                                </p>

                                                Price: @{{price}} $<br>
                                                <p v-if="discount > 0">
                                                    Discount: @{{discount}} $<br>
                                                    <b style="text-decoration: underline; color: green;">New Price: @{{newPrice}} $</b>
                                                </p>
                                                <br><br>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <button class="btn btn-warning btn-lg w-100" @click="myfatoorah_charge">Buy Now</button>
                                                    </div>
                                                </div>

                                            </li>
                                            <li>
                                                <p class="alert alert-danger" v-if="error != ''">@{{ error }}</p>

                                                <p v-if="discount > 0">
                                                    Coupon Code: @{{coupon}}
                                                    <b v-if="discount > 0" style="color:green;">Valid</b>
                                                    <b v-if="discount <= 0" style="color:green;">Expired</b><br>
                                                </p>

                                                Price: @{{price}} $<br>
                                                <p v-if="discount > 0">
                                                    Discount: @{{discount}} $<br>
                                                    <b style="text-decoration: underline; color: green;">New Price: @{{newPrice}} $</b>
                                                </p>
                                                <br><br>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <form id="form-container" method="post" action="{{route('charge')}}">
                                                            <!-- Tap element will be here -->
                                                            @csrf
                                                            <div id="element-container"></div>
                                                            <div id="error-handler" role="alert"></div>
                                                            <div id="success" style=" display: none;;position: relative;float: left;">
                                                                validation success
                                                            </div>
                                                            <!-- Tap pay button -->
                                                            <button id="tap-btn" v-if="error==''">Pay</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <p class="alert alert-danger" v-if="error != ''">@{{ error }}</p>
                                                <p>
                                                <p v-if="discount > 0">
                                                    Coupon Code: @{{coupon}}
                                                    <b v-if="discount > 0" style="color:green;">Valid</b>
                                                    <b v-if="discount <= 0" style="color:green;">Expired</b><br>
                                                </p>

                                                Price: @{{price}} $<br>
                                                <p v-if="discount > 0">
                                                    Discount: @{{discount}} $<br>
                                                    <b style="text-decoration: underline; color: green;">New Price: @{{newPrice}} $</b>
                                                </p>
                                                <br><br>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div id="paypal-button-container"></div>
                                                    </div>
                                                </div>



                                                <p v-if="auth == 0" style="color:red;">Please Login so you can pay with credit card ! </p>

                                                </p>
                                            </li>




                                        </ul>
                                    </div>
                                    <p class="uk-text-right">
                                        <button class="uk-button uk-button-default uk-modal-close" type="button">Cancel</button>
                                    </p>
                                </div>
                            </div>
                            @endif

                            <p class="uk-text-bold">{{__('Public/package.this-course-include')}}</p>

                            <div class="uk-child-width-1-2 uk-grid-small" uk-grid>

                                <div>
                                    <span><i class="uil-youtube-alt"></i> {{$i->event->total_time}} {{__('Public/package.hours-video')}}</span>
                                </div>
                                <div>
                                    <span> <i class="uil-video"></i> {{__('Public/package.watch-online')}} </span>
                                </div>
                                @if($i->event->id != 41)
                                <!--<div>-->
                                <!--    <span>  <i class="uil-clock-five"></i> {{$i->event->expire_in_days}} {{__('Public/package.day-access')}} </span>-->
                                <!--</div>-->
                                @endif
                                <div>
                                    <span> <i class="uil-book"></i> {{$i->event->lang}} </span>
                                </div>
                                @if($i->event->free_package_id)
                                <div>
                                    <span> <i class="uil-gift"></i> {{__('Public/package.free-package-included')}} </span>
                                </div>
                                @endif

                            </div>
{{--                            @if( !( Auth::check() && (\App\EventUser::where('user_id','=', Auth::user()->id)->where('event_id','=',$i->event->id)->get()->first()) ))--}}
{{--                            <div class="uk-child-width-1-1 uk-grid-small mb-4" uk-grid>--}}
{{--                                <div>--}}
{{--                                    <input type="text" placeholder="Coupon" v-model="coupon" class="uk-input" value="{{Illuminate\Support\Facades\Input::get('coupon')}}">--}}
{{--                                </div>--}}
{{--                                <div>--}}
{{--                                    <a href="#PaymentModal" uk-toggle v-on:click="regenerate_price"--}}
{{--                                       class="btn btn-danger uk-width-1-1 transition-3d-hover"> <i--}}
{{--                                                class="uil-gift"></i> Apply Coupon </a>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            @endif--}}
                        </div>
                    </div>
                </div>

            </div>

            <!-- footer
           ================================================== -->
            <div class="footer">
                <div class="uk-grid-collapse" uk-grid>
                    <div class="uk-width-expand@s uk-first-column {{app()->getLocale() == 'ar'? 'text-right':'text-left'}}">
                        {{__('Public/package.rights-sentence')}}
                    </div>
                    <div class="uk-width-auto@s">
                        <nav class="footer-nav-icon">
                            <ul>
                                <li><a href="#"><i class="icon-brand-facebook"></i></a></li>
                                <li><a href="#"><i class="icon-brand-dribbble"></i></a></li>
                                <li><a href="#"><i class="icon-brand-youtube"></i></a></li>
                                <li><a href="#"><i class="icon-brand-twitter"></i></a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
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

    <!-- For Night mode -->
    <script>
        (function (window, document, undefined) {
            'use strict';
            if (!('localStorage' in window)) return;
            var nightMode = localStorage.getItem('gmtNightMode');
            if (nightMode) {
                document.documentElement.className += ' night-mode';
            }
        })(window, document);


        (function (window, document, undefined) {

            'use strict';

            // Feature test
            if (!('localStorage' in window)) return;

            // Get our newly insert toggle
            var nightMode = document.querySelector('#night-mode');
            if (!nightMode) return;

            // When clicked, toggle night mode on or off
            nightMode.addEventListener('click', function (event) {
                event.preventDefault();
                document.documentElement.classList.toggle('night-mode');
                if (document.documentElement.classList.contains('night-mode')) {
                    localStorage.setItem('gmtNightMode', true);
                    return;
                }
                localStorage.removeItem('gmtNightMode');
            }, false);

        })(window, document);
    </script>


    <!-- javaScripts
================================================== -->
    <script src="{{asset('assetsV2/js/framework.js')}}"></script>
    <script src="{{asset('assetsV2/js/jquery-3.3.1.min.js')}}"></script>
    <script src="{{asset('assetsV2/js/simplebar.js')}}"></script>
    <script src="{{asset('assetsV2/js/main.js')}}"></script>
    <script src="{{asset('assetsV2/js/bootstrap-select.min.js')}}"></script>
    <script src="https://unpkg.com/sweetalert2@7.8.2/dist/sweetalert2.all.js"></script>
    <script
            src="https://www.paypal.com/sdk/js?client-id={{\App\PaypalConfig::all()->first()->client_id}}">
    </script>

    {{--  Setup TAP Elements  --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bluebird/3.3.4/bluebird.min.js"></script>
    <script src="https://secure.gosell.io/js/sdk/tap.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.17.0/jquery.validate.js"></script>
    <script src="https://malsup.github.io/jquery.form.js"></script>
    <script src="{{asset('js/auth/auth.js')}}"></script>
<script src="https://player.vimeo.com/api/player.js"></script>
<script>
    @if(session('success'))
    swal({
        title: '{{session('success')}}',
        type: 'success',
        //   confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Ok',
    });
    @endif


    function pauseVid(vid){
        var iframe = document.getElementById(vid);
        var player = new Vimeo.Player(iframe);
        player.pause();

    }

    function runVideo(run_vid, stop_vid){
        pauseVid(stop_vid);

        if(run_vid != stop_vid){
            var iframe = document.getElementById(run_vid);
            var player = new Vimeo.Player(iframe);
            player.play();
        }

    }







    var app = new Vue({

        el: '#app-1',
        data: {
            error: '',
            publicKey: '{{config('tap.TAPpublicKey')}}',
            event_id: {{$i->event->id}},
            paymentMethod: 'null',
            coupon: '{{Illuminate\Support\Facades\Input::get('coupon')}}',
            price: 0,
            discount: 0,
            newPrice: 0,
            visa_generated: 0,
            auth: @if(Auth::check()) 1 @else 0 @endif

        },
        methods: {
            tapTokenHandler: function(token, coupon, event_id){
                // Insert the token ID into the form so it gets submitted to the server
                var form = document.getElementById('form-container');
                var hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'tapToken');
                hiddenInput.setAttribute('value', token);
                form.appendChild(hiddenInput);

                var coupon_ = document.createElement('input');
                coupon_.setAttribute('type', 'hidden');
                coupon_.setAttribute('name', 'coupon');
                coupon_.setAttribute('value', coupon);
                form.appendChild(coupon_);

                var event_id_ = document.createElement('input');
                event_id_.setAttribute('type', 'hidden');
                event_id_.setAttribute('name', 'item_id');
                event_id_.setAttribute('value', event_id);
                form.appendChild(event_id_);

                var item_type = document.createElement('input');
                item_type.setAttribute('type', 'hidden');
                item_type.setAttribute('name', 'item_type');
                item_type.setAttribute('value', 'event');
                form.appendChild(item_type);

                // Submit the form
                form.submit();
            },
            showReplyForm: function(form_id){
                $('#'+form_id).toggle();

            },
            payModel: function(event_id){

                this.event_id = event_id;
            },
            regenerate_price: function(){




                if(!this.auth){
                    window.location.replace('{{route('login')}}?prev_url={{URL::current()}}');
                }

                Data = {
                    event_id: app.event_id,
                    coupon_code: app.coupon,
                };

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax ({
                    type: 'POST',
                    url: '{{ route('event.price.details')}}',
                    data: Data,
                    success: function(res){


                        if (res.error == '') {


                            app.price = Number(res.price);
                            app.discount = Number(res.discount);

                            if (app.price > app.discount) {
                                app.newPrice = app.price - app.discount;
                            } else {

                                app.newPrice = 0;
                            }


                            if (app.newPrice > 0 && app.visa_generated == 0 && app.auth == 1) {
                                paypal.Buttons({
                                    createOrder: function (data, actions) {
                                        // Set up the transaction

                                        return actions.order.create({
                                            application_context: {
                                                locale: 'en-US',
                                            },

                                            purchase_units: [{
                                                amount: {
                                                    currency_code: 'USD',
                                                    value: app.newPrice
                                                }
                                            }],
                                        });
                                    },
                                    onApprove: function (data, actions) {

                                        console.log(data);
                                        return actions.order.capture().then(function (details) {

                                            Data = {
                                                orderID: data.orderID,
                                                payer_id: details.payer.payer_id,
                                                paypalEmail: details.payer.email_address,
                                                countryCode: details.payer.address.country_code,
                                                totalPaid: details.purchase_units[0].amount.value,
                                                paymentID: details.purchase_units[0].payments.captures[0].id,
                                                event_id: app.event_id,
                                                coupon: app.coupon

                                            };


                                            $.ajaxSetup({
                                                headers: {
                                                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                                                }
                                            });

                                            $.ajax({
                                                type: 'POST',
                                                url: '{{ route('event.confirmPaymentMethod2')}}',
                                                data: Data,
                                                success: function (res) {

                                                    swal({
                                                        title: 'Payment Complete Successfully !',
                                                        type: 'success',
                                                        //   confirmButtonColor: '#DD6B55',
                                                        confirmButtonText: 'Ok',
                                                    }).then(function () {
                                                        window.location = '{{route('my.package.view',['all','all'])}}';
                                                    });

                                                },
                                                error: function (res) {
                                                    console.log('Error:', res);
                                                }
                                            });


                                        });
                                    }
                                }).render('#paypal-button-container');


                                var tap = Tapjsli(app.publicKey);

                                var elements = tap.elements({});

                                var style = {
                                    base: {
                                        color: '#535353',
                                        lineHeight: '18px',
                                        fontFamily: 'sans-serif',
                                        fontSmoothing: 'antialiased',
                                        fontSize: '16px',
                                        '::placeholder': {
                                            color: 'rgba(0, 0, 0, 0.26)',
                                            fontSize: '15px'
                                        }
                                    },
                                    invalid: {
                                        color: 'red'
                                    }
                                };
                                // input labels/placeholders
                                var labels = {
                                    cardNumber: "Card Number",
                                    expirationDate: "MM-YY",
                                    cvv: "CVV",
                                    cardHolder: "Card Holder Name"
                                };
                                //payment options
                                var paymentOptions = {
                                    currencyCode: "all",
                                    labels: labels,
                                    TextDirection: 'ltr'
                                }
                                //create element, pass style and payment options
                                var card = elements.create('card', {style: style}, paymentOptions);
                                //mount element
                                card.mount('#element-container');
                                //card change event listener
                                card.addEventListener('change', function (event) {
                                    console.log("Change Event Fire: ", event);
                                    if (event.BIN) {
                                        console.log(event.BIN)
                                    }
                                    if (event.loaded) {
                                        console.log("UI loaded :" + event.loaded);
                                        console.log("current currency is :" + card.getCurrency())
                                    }
                                    var displayError = document.getElementById('error-handler');
                                    if (event.error) {
                                        displayError.textContent = event.error.message;
                                    } else {
                                        displayError.textContent = '';
                                    }
                                });

                                var form = document.getElementById('form-container');
                                form.addEventListener('submit', function (event) {
                                    event.preventDefault();

                                    tap.createToken(card).then(function (result) {
                                        console.log("Form Submission Event Fire: ", result);
                                        if (result.error) {
                                            // Inform the user if there was an error
                                            var errorElement = document.getElementById('error-handler');
                                            errorElement.textContent = result.error.message;
                                        } else {
                                            // Send the token to your server
                                            var errorElement = document.getElementById('success');
                                            errorElement.style.display = "block";
                                            app.tapTokenHandler(result.id, app.coupon, app.event_id);

                                        }
                                    });
                                });
                                app.visa_generated = 1;
                            }


                            if (app.newPrice <= 0) {
                                $("#paypal-button-container").hide();
                            } else {
                                $("#paypal-button-container").show();
                            }

                        }
                        app.error = res.error;
                    },
                    error: function(res){
                        console.log('Error:', res);
                    }
                });



            },
            redirect_pay:function(){
                Data = {
                    package_id: app.package_id,
                    coupon_code: app.coupon,
                };

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax ({
                    type: 'POST',
                    url: '{{ route('generate.payment.link')}}',
                    data: Data,
                    success: function(res){
                        window.location.href = res;

                    },
                    error: function(res){
                        console.log('Error:', res);
                    }
                });



            },
            selectPaymentMethod: function(){
                if(this.paymentMethod == 'paypal'){
                    $("#paypal_form").show();
                    $("#check_form").hide();
                }else{
                    $("#paypal_form").hide();
                    $("#check_form").show();
                }
            },
            myfatoorah_charge: function(){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    }
                });

                $.ajax ({
                    type: 'POST',
                    url: '{{ route('myfatoorah.charge')}}',
                    data: {
                        item_id: app.event_id,
                        item_type: 'event',
                        coupon_code: app.coupon,
                    },
                    success: function (res) {
                        if(res.error == ''){
                            window.location.replace(res.url);
                        }else{
                            swal({
                                title: res.error,
                                type: 'error',
                                //   confirmButtonColor: '#DD6B55',
                                confirmButtonText: 'Ok',
                            });
                        }
                    },
                    error: function (error) {
                        console.log(error)
                    },
                });
            },
        }
    });
</script>

</body>

</html>
