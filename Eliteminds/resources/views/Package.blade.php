@extends('layouts.public')
@php $quizzes = 0; $exams_number=0; @endphp
@if( !( Auth::check() && (\App\UserPackages::where('user_id','=', Auth::user()->id)->where('package_id','=',$i->package->id)->get()->first()) && !(\App\PaymentApprove::where('user_id','=', Auth::user()->id)->where('package_id','=',$i->package->id)->get()->first()) ))
    @php
        $show_enroll = 1;
        $lastPayment = session('lastPayment', null);
        if($lastPayment){
            if( $lastPayment->addMinutes(15)->lte(\Carbon\Carbon::now()) ){
                $show_enroll = 1;
            }else{
                $show_enroll = 0;
            }
        }
    @endphp
@else
    @php
        $show_enroll = 0;
    @endphp
@endif

@section('head')
    <style>
        .accordion-button:not(.collapsed) {
            color: #f58634;zz
            background-color: #fff3ed;
        }

        #videoContainer > iframe
        {
            max-width: 100% !important;
        }
    </style>
    
    <title>{{ Transcode::evaluate($i->package)['name'] }}</title>

    <meta property="og:title" content="{{ Transcode::evaluate($i->package)['name'] }}"/>
    <meta property="og:type" content="artical"/>
    <meta property="og:image" content="{{url('storage/package/imgs/'.basename($i->package->img))}}"/>

@endsection

@section('content')
    <div class="section page-banner" >

        <img class="shape-1 animation-round" src="{{asset('index-assets/images/shape/shape-8.png')}}" alt="Shape">

        <img class="shape-2" src="{{asset('index-assets/images/shape/shape-23.png')}}" alt="Shape">

        <div class="container">
            <!-- Page Banner Start -->
            <div class="page-banner-content">
                <ul class="breadcrumb">
                    <li><a href="{{route('index')}}">Home</a></li>
                    <li class="active">Courses Details</li>
                </ul>
                <h2 class="title">Courses <span> Details</span></h2>
            </div>
            <!-- Page Banner End -->
        </div>

        <!-- Shape Icon Box Start -->
        <div class="shape-icon-box">

            <img class="icon-shape-1 animation-left" src="{{asset('index-assets/images/shape/shape-5.png')}}" alt="Shape">

            <div class="box-content">
                <div class="box-wrapper">
                    <i class="flaticon-badge"></i>
                </div>
            </div>

            <img class="icon-shape-2" src="{{asset('index-assets/images/shape/shape-6.png')}}" alt="Shape">

        </div>
        <!-- Shape Icon Box End -->

        <img class="shape-3" src="{{asset('index-assets/images/shape/shape-24.png')}}" alt="Shape">

        <img class="shape-author" src="{{asset('index-assets/images/author/author-11.jpg')}}" alt="Shape">

    </div>
    <div class="section section-padding mt-n10" id="app-1">
        <div class="container">
            <div class="row gx-10">
                <div class="col-lg-8">

                    <!-- Courses Details Start -->
                    <div class="courses-details">

                        <div class="courses-details-images">
                            @if($i->package->preview_video_url == null && $i->package->preview_video_url == '')
                            <img src="{{ url('storage/package/imgs/'.basename($i->package->img_large))}}" alt="Courses Details">
                            @endif
                            @if($i->package->preview_video_url != null && $i->package->preview_video_url != '')
                                <video oncontextmenu="return false;" width="100%" controls controlsList="nodownload">
                                    <source src="{{url('storage/videos/'.basename($i->package->preview_video_url) )}}" type="video/mp4">
                                </video>
                            @endif
                        </div>

                        <h2 class="title">{{Transcode::evaluate($i->package)['name'] }}</h2>

                        <div class="courses-details-admin flex-column align-items-start w-100">
                            <div class="admin-author w-100">
                                <div class="author-content p-0 w-100 justify-content-between d-flex">
                                    <a class="name" href="javascript:;">{{\App\Course::find($i->package->course_id)->title }}</a>
                                    <span class="Enroll">{{$i->users_no}} Enrolled Students</span>
                                </div>
                            </div>
                            <div class="admin-rating">
                                <span class="rating-count">{{round($i->total_rate, 2)}}</span>
                                <span class="rating-star">
                                        <span class="rating-bar" style="width: {{$i->total_rate*100/5}}%;"></span>
                                </span>
                                <span class="rating-text">({{count(\App\Rating::where('package_id', $i->package->id)->get())}} Rating)</span>
                            </div>
                        </div>

                        <!-- Courses Details Tab Start -->
                        <div class="courses-details-tab">

                            <!-- Details Tab Menu Start -->
                            <div class="details-tab-menu">
                                <ul class="nav justify-content-center">
                                    <li><button class="active" data-bs-toggle="tab" data-bs-target="#description" style="width: auto;">Description</button></li>
                                    <li><button data-bs-toggle="tab" data-bs-target="#instructors" style="width: auto;">Course Content</button></li>
                                    <li><button data-bs-toggle="tab" data-bs-target="#reviews">Reviews</button></li>
                                </ul>
                            </div>
                            <!-- Details Tab Menu End -->

                            <!-- Details Tab Content Start -->
                            <div class="details-tab-content">
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="description">

                                        <!-- Tab Description Start -->
                                        <div class="tab-description">
                                            <div class="description-wrapper">
                                                <h3 class="tab-title">Description:</h3>
                                                <p>{!!  Transcode::evaluate($i->package)['description'] !!} </p>
                                            </div>
                                            <div class="description-wrapper">
                                                <h3 class="tab-title"> {{__('Public/package.what-you-learn')}}</h3>
                                                <p>{!! Transcode::evaluate($i->package)['what_you_learn'] !!}</p>
                                            </div>
                                            <div class="description-wrapper">
                                                <h3 class="tab-title">{{__('Public/package.requirements')}}</h3>
                                                <p>{!! Transcode::evaluate($i->package)['requirement'] !!}</p>
                                            </div>
                                            <div class="description-wrapper">
                                                <h3 class="tab-title"> {{__('Public/package.who-course-for')}}</h3>
                                                <p> {!!  Transcode::evaluate($i->package)['who_course_for']!!} </p>
                                            </div>
                                        </div>
                                        <!-- Tab Description End -->

                                    </div>
                                    <div class="tab-pane fade" id="instructors">

                                        <!-- Tab Instructors Start -->
                                        <div class="tab-instructors">
                                            <h3 class="tab-title">Content:</h3>
                                            <span style="display:inline-block; float:{{app()->getLocale() == 'ar'? 'left': 'right'}};">
                                                @if($total_videos_num > 0)
                                                {{$total_time}} | {{$total_videos_num}} {{__('Public/package.lectures')}}
                                                @endif
                                            </span>
                                            <div class="accordion my-5" id="accordionExample">
                                                @foreach($chapter_list as $chapter)
                                                    @php $demo = \App\Video::where('chapter', $chapter->id)->get(); @endphp
                                                    @php $explanations = \App\Explanation::where('chapter_id', $chapter->id)->count(); @endphp
                                                    @php $questions = \App\Question::where('chapter', $chapter->id)->count(); @endphp
                                                    @if(count($demo) || $explanations || $questions)
                                                    <div class="accordion-item">
                                                        <h1 class="accordion-header" id="heading{{$chapter->id}}">
                                                            <button class="accordion-button @if($chapter->num != 1) collapsed @endif" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$chapter->id}}" aria-expanded="false" aria-controls="collapseOne">
                                                            <span style="width: 100%;" class="d-flex w-100 justify-content-between">
                                                                <span style="text-overflow: ellipsis; max-width: 75%;overflow: hidden;white-space: nowrap; font-size: 18px"><b>
                                                                    @if(app()->getLocale() == 'ar')
                                                                            {{$chapter->name_ar}}
                                                                        @else
                                                                            {{$chapter->name}}
                                                                        @endif</b>
                                                                </span>
                                                                @if(count($demo))
                                                                <small>{{count(\App\Video::where('chapter', $chapter->id)->get())}} {{__('Public/package.lecture')}} | {{$chapter->total_hours}} {{__('Public/package.hr')}} {{ $chapter->total_min}} {{__('Public/package.min')}}</small>
                                                                @endif
                                                            </span>
                                                            </button>

                                                        </h1>
                                                        <div id="collapse{{$chapter->id}}" class="accordion-collapse collapse  @if($chapter->num == 1) show @endif" aria-labelledby="heading{{$chapter->id}}" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body" style="padding:0;">
                                                                <div class="list-group">
                                                                    @foreach($demo as $video)
                                                                        <a href="#" class="list-group-item list-group-item-action">
                                                                            <div class="d-flex w-100 justify-content-between">
                                                                                <h6 class="mb-1" style="font-size:15px !important;">
                                                                                    {{Transcode::evaluate($video)['title']}}
                                                                                </h6>
                                                                                <div class="d-flex">
                                                                                    @if($video->demo)
                                                                                        <small class="btn-primary p-1 mx-2" data-bs-toggle="modal" data-bs-target="#demoVideo" @click="getVideo('{{$video->id}}')">Preview</small>
                                                                                    @endif
                                                                                    <small>
                                                                                        {{ explode(':', $video->duration)[1]. ':'. explode(':', $video->duration)[2]}}
                                                                                    </small>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    @endforeach

                                                                    @if($questions)
                                                                        @php $quizzes++ @endphp
                                                                        <a href="#" class="list-group-item list-group-item-action">
                                                                            <div class="d-flex w-100 justify-content-between">
                                                                                <h6 class="mb-1" style="font-size:15px !important;">
                                                                                    Quiz
                                                                                </h6>
                                                                                <div class="d-flex">
                                                                                    <small>
                                                                                        {{$questions}} Questions
                                                                                    </small>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    @endif

                                                                    @if($explanations)
                                                                    <a href="#" class="list-group-item list-group-item-action">
                                                                        <div class="d-flex w-100 justify-content-between">
                                                                            <h6 class="mb-1" style="font-size:15px !important;">
                                                                                Explanations
                                                                            </h6>
                                                                            <div class="d-flex">
                                                                                <small>
                                                                                    {{$explanations}} Items
                                                                                </small>
                                                                            </div>
                                                                        </div>
                                                                    </a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                @endforeach
                                            </div>

                                            <div class="accordion my-5" id="accordionExample2">

                                                <div class="accordion-item">
                                                    <h1 class="accordion-header" id="headingExam">
                                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExam" aria-expanded="false" aria-controls="collapseOne">
                                                        <span style="width: 100%;" class="d-flex w-100 justify-content-between">
                                                            <span style="text-overflow: ellipsis; max-width: 75%;overflow: hidden;white-space: nowrap; font-size: 18px"><b>
                                                                Exams
                                                                </b>
                                                            </span>
                                                        </span>
                                                        </button>

                                                    </h1>
                                                    <div id="collapseExam" class="accordion-collapse collapse show" aria-labelledby="headingExam" data-bs-parent="#accordionExample2">
                                                        <div class="accordion-body" style="padding:0;">
                                                            <div class="list-group">
                                                                @foreach($exam_list as $exam)
                                                                    @php $exams_number++; @endphp
                                                                    @php $e_count = \App\Question::where(DB::raw("CONCAT(',', TRIM(BOTH '\"' FROM `exam_num`), ',')"), 'LIKE', '%,'.$exam->id.',%')->get()->count(); @endphp
                                                                    @if($e_count > 0)
                                                                    <a href="javascript:;" class="list-group-item list-group-item-action">
                                                                        <div class="d-flex w-100 justify-content-between">
                                                                            <h6 class="mb-1" style="font-size:15px !important;">
                                                                                {{Transcode::evaluate( \App\Exam::find($exam->id) )['name'] }}
                                                                            </h6>
                                                                            <div class="d-flex">
                                                                                <small>{{ round( $e_count) }} {{__('Public/package.questions')}}</small>
                                                                            </div>
                                                                        </div>
                                                                    </a>
                                                                    @endif
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Tab Instructors End -->

                                        <!-- Demo Videos -->
                                        <div class="modal fade" id="demoVideo">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <!-- Reviews Form Start -->
                                                    <div class="modal-body reviews-form" id="videoContainer">
                                                    </div>
                                                    <!-- Reviews Form End -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="reviews">

                                        <!-- Tab Reviews Start -->
                                        <div class="tab-reviews">
                                            <h3 class="tab-title">Student Reviews:</h3>

                                            <div class="reviews-wrapper reviews-active">
                                                <div class="swiper-container swiper-container-initialized swiper-container-horizontal swiper-container-pointer-events">
                                                    <div class="swiper-wrapper" id="swiper-wrapper-c23b591a042b3f0c" aria-live="off" style="transform: translate3d(-2379px, 0px, 0px); transition-duration: 0ms;">
                                                        <div class="single-review swiper-slide swiper-slide-duplicate swiper-slide-duplicate-active" data-swiper-slide-index="2" role="group" aria-label="1 / 5" style="width: 763px; margin-right: 30px;">
                                                            <div class="review-author">
                                                                <div class="author-thumb">
                                                                    <img src="{{asset('index-assets/images/author/author-03.jpg')}}" alt="Author">
                                                                    <i class="icofont-quote-left"></i>
                                                                </div>
                                                                <div class="author-content">
                                                                    <h4 class="name">Gertude Culbertson</h4>
                                                                    <span class="designation">Product Designer, USA</span>
                                                                    <span class="rating-star">
																				<span class="rating-bar" style="width: 100%;"></span>
                                                                        </span>
                                                                </div>
                                                            </div>
                                                            <p>Lorem Ipsum has been the industry's standard dummy text since the 1500 when unknown printer took a galley of type and scrambled to make type specimen book has survived not five centuries but also the leap into electronic type and book.</p>
                                                        </div>
                                                        @foreach(\App\Rating::where("package_id", $i->package->id)->orderBy('created_at', 'desc')->paginate(8) as $rate)
                                                            @if(\App\User::find($rate->user_id))
                                                                @php
                                                                    $pic = asset('index-assets/images/author/author-'.rand(12,16).'.jpg');
                                                                    if(\App\UserDetail::where('user_id', $rate->user_id)->first()){
                                                                        if(\App\UserDetail::where('user_id', $rate->user_id)->get()->first()->profile_pic != null ){
                                                                            $pic = url('storage/profile_picture/'.basename(\App\UserDetail::where('user_id', $rate->user_id)->get()->first()->profile_pic));
                                                                        }
                                                                    }
                                                                @endphp
                                                                <!-- Single Reviews Start -->
                                                                <div class="single-review swiper-slide swiper-slide-duplicate-next" data-swiper-slide-index="{{$loop->index}}" role="group" aria-label="2 / 5" style="width: 763px; margin-right: 30px;">
                                                                    <div class="review-author">
                                                                        <div class="author-thumb">
                                                                            <img src="{{$pic}}" alt="Author">
                                                                            <i class="icofont-quote-left"></i>
                                                                        </div>
                                                                        <div class="author-content">
                                                                            <h4 class="name">{{\App\User::find($rate->user_id)->name}}</h4>
                                                                            <span class="rating-star">
                                                                                    <span class="rating-bar" style="width: {{round($rate->rate)*100/5}}%;"></span>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <p>{{$rate->review}}</p>
                                                                </div>
                                                                <!-- Single Reviews End -->
                                                                @endif
                                                            @endforeach

                                                        <div class="single-review swiper-slide swiper-slide-duplicate swiper-slide-next" data-swiper-slide-index="0" role="group" aria-label="5 / 5" style="width: 763px; margin-right: 30px;">
                                                            <div class="review-author">
                                                                <div class="author-thumb">
                                                                    <img src="{{asset('index-assets/images/author/author-06.jpg')}}" alt="Author">
                                                                    <i class="icofont-quote-left"></i>
                                                                </div>
                                                                <div class="author-content">
                                                                    <h4 class="name">Sara Alexander</h4>
                                                                    <span class="designation">Product Designer, USA</span>
                                                                    <span class="rating-star">
																				<span class="rating-bar" style="width: 100%;"></span>
                                                                        </span>
                                                                </div>
                                                            </div>
                                                            <p>Lorem Ipsum has been the industry's standard dummy text since the 1500 when unknown printer took a galley of type and scrambled to make type specimen book has survived not five centuries but also the leap into electronic type and book.</p>
                                                        </div></div>
                                                    <!-- Add Pagination -->
                                                    <div class="swiper-pagination swiper-pagination-clickable swiper-pagination-bullets"><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 1"></span><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 2"></span><span class="swiper-pagination-bullet swiper-pagination-bullet-active" tabindex="0" role="button" aria-label="Go to slide 3"></span></div>
                                                    <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>
                                            </div>

                                        </div>
                                        <!-- Tab Reviews End -->

                                    </div>
                                </div>
                            </div>
                            <!-- Details Tab Content End -->

                        </div>
                        <!-- Courses Details Tab End -->

                    </div>
                    <!-- Courses Details End -->

                </div>
                <div class="col-lg-4">
                    <!-- Courses Details Sidebar Start -->
                    <div class="sidebar">

                        <!-- Sidebar Widget Information Start -->
                        <div class="sidebar-widget widget-information">
                            <div class="info-price">
                                <span class="price">{{$pricing['localized_price'] - $pricing['localized_coupon_discount']}} {{$pricing['currency_code']}}</span>
                                @if($pricing['localized_coupon_discount']>0)
                                <small style="text-decoration: line-through;">{{ $pricing['localized_original_price'] }} {{$pricing['currency_code']}}</small>
                                @endif
                            </div>
                            <div class="info-list">
                                <ul>
{{--                                    <li><i class="icofont-man-in-glasses"></i> <strong>Instructor</strong> <span>Pamela Foster</span></li>--}}
                                    @if($package_total_video_time[0] > 0)
                                    <li><i class="icofont-clock-time"></i> <strong>Duration</strong> <span>{{$package_total_video_time[0]}} Hrs</span></li>
                                    @endif
                                    @if($total_videos_num > 0)
                                    <li><i class="icofont-ui-video-play"></i> <strong>Lectures</strong> <span>{{$total_videos_num}}</span></li>
                                    @endif
                                    @if($quizzes > 0)
                                    <li><i class="fa fa-book"></i> <strong>Quizzes</strong> <span>{{$quizzes}}</span></li>
                                    @endif
                                    @if($exams_number > 0)
                                    <li><i class="fa fa-book"></i> <strong>Exams</strong> <span>{{$exams_number}}</span></li>
                                    @endif
                                    <li><i class="fa fa-language"></i> <strong>Language</strong> <span>{{$i->package->lang}}</span></li>
                                    @if($i->package->certification)
                                    <li><i class="icofont-certificate-alt-1"></i> <strong>Certificate</strong> <span>Yes</span></li>
                                    @endif
                                </ul>
                            </div>
                            @if($show_enroll)

                            <form action="{{route('paytabs.charge')}}" method="GET">
                                <div class="form-group my-2">
                                    <label for="coupon_">Coupon: </label>
                                    <input type="text" id="coupon_" v-model="coupon" name="coupon" class="form-control py-2 px-1">
                                    <input type="hidden" name="item_id" value="{{$i->package->id}}">
                                    <input type="hidden" name="item_type" value="package">
                                </div>
                                <div class="info-btn">
                                    <a href="javascript:;" v-on:click="regenerate_price" data-bs-toggle="modal" data-bs-target="#paymentModel" class="btn btn-primary btn-hover-dark">Enroll Now</a>
{{--                                    <button href="javascript:;" onclick="this.nearest('form').submit()" class="btn btn-primary btn-hover-dark">Enroll Now</button>--}}
                                </div>
                            </form>

                            @endif
                        </div>
                        <!-- Sidebar Widget Information End -->

                        <div class="courses-details-tab ">
                            <div class="row details-tab-content">
                                <!-- Sidebar Widget Share Start -->
                                <div class="tab-rating-box">
                                    <span class="count">{{round($rating->avg_rate)}} <i class="icofont-star"></i></span>
                                    <p>Rating ({{$rating->ratings_number}}+)</p>

                                    <div class="rating-box-wrapper">
                                        <div class="single-rating">
                                            <span class="rating-star">
                                                    <span class="rating-bar" style="width: 100%;"></span>
                                            </span>
                                            <div class="rating-progress-bar">
                                                <div class="rating-line" style="width: {{$rating->five_stars/($rating->ratings_number == 0 ? 1: $rating->ratings_number)*100 }}%;"></div>
                                            </div>
                                        </div>

                                        <div class="single-rating">
                                            <span class="rating-star">
                                                    <span class="rating-bar" style="width: 80%;"></span>
                                            </span>
                                            <div class="rating-progress-bar">
                                                <div class="rating-line" style="width: {{$rating->four_stars/($rating->ratings_number == 0 ? 1: $rating->ratings_number)*100 }}%;"></div>
                                            </div>
                                        </div>

                                        <div class="single-rating">
                                            <span class="rating-star">
                                                    <span class="rating-bar" style="width: 60%;"></span>
                                            </span>
                                            <div class="rating-progress-bar">
                                                <div class="rating-line" style="width: {{$rating->three_stars/($rating->ratings_number == 0 ? 1: $rating->ratings_number)*100 }}%;"></div>
                                            </div>
                                        </div>

                                        <div class="single-rating">
                                            <span class="rating-star">
                                                    <span class="rating-bar" style="width: 40%;"></span>
                                            </span>
                                            <div class="rating-progress-bar">
                                                <div class="rating-line" style="width: {{$rating->two_stars/($rating->ratings_number == 0 ? 1: $rating->ratings_number)*100 }}%;"></div>
                                            </div>
                                        </div>

                                        <div class="single-rating">
                                            <span class="rating-star">
                                                    <span class="rating-bar" style="width: 20%;"></span>
                                            </span>
                                            <div class="rating-progress-bar">
                                                <div class="rating-line" style="width: {{$rating->one_stars/($rating->ratings_number == 0 ? 1: $rating->ratings_number)*100 }}%;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Sidebar Widget Share End -->
                            </div>
                        </div>
                    </div>
                    <!-- Courses Details Sidebar End -->
                </div>

            </div>
        </div>
        <div class="modal fade" id="paymentModel" tabindex="-1" role="dialog" aria-labelledby="modalExampleTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">

                        <!-- Close -->
                        <button type="button" class="close btn btn-danger btn-sm" data-bs-dismiss="modal" aria-label="Close" style="line-height: unset;">
                            <span aria-hidden="true">×</span>
                        </button>

                        <!-- Heading -->
                        <h2 class="fw-bold text-center mb-1" id="modalExampleTitle">
                            Payment
                        </h2>

                        <!-- Text -->
                        <p class="font-size-lg text-center text-muted mb-6 mb-md-8">
                            Choose Payment Method
                        </p>

                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">
                                    <img src="https://www.paypalobjects.com/webstatic/mktg/Logo/pp-logo-100px.png">
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">
                                    <img src="{{asset('img/visa-master.jpg')}}" width="100px">
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <p class="alert alert-danger" v-if="error != ''">@{{ error }}</p>
                                <p v-if="error == ''">
                                <p v-if="discount > 0">
                                    Coupon Code: @{{coupon}}
                                    <b v-if="discount > 0" style="color:green;">Valid</b>
                                    <b v-if="discount <= 0" style="color:green;">Expired</b><br>
                                </p>

                                Price: @{{price}} $<br>
                                <p v-if="discount > 0">
                                    Discount: @{{discount}} $<br>
                                    <b style="text-decoration: underline; color: green;">{{__('Public/package.new-price')}}: @{{newPrice}} $</b>
                                </p>
                                <br><br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div id="paypal-button-container"></div>
                                    </div>
                                </div>
                                <p v-if="auth == 0" style="color:red;">Please Login so you can pay with credit card ! </p>

                            </div>

                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
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
                                <div class="d-flex justify-content-center">
                                    <button @click="paytabs_charge" class="btn btn-primary">Pay Now</button>
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
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>
    <script
            src="https://www.paypal.com/sdk/js?client-id={{\App\PaypalConfig::all()->first()->client_id}}">
    </script>
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

        function runVideo(run_vid){
            // pauseVid(stop_vid);


            if(run_vid){
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
                package_id: {{$i->package->id}},
                paymentMethod: 'null',
                coupon: '{{Illuminate\Support\Facades\Input::get('coupon')}}',
                price: 0,
                discount: 0,
                newPrice: 0,
                visa_generated: 0,
                auth: @if(Auth::check()) 1 @else 0 @endif

            },
            methods: {
                getVideo: function(video_id){
                    document.getElementById('videoContainer').innerHTML = '<p class="mx-auto">Loading...</p>';
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}'
                        }
                    });

                    $.ajax ({
                        type: 'POST',
                        url: '{{ route('public.package.view.video')}}',
                        data: {
                            video_id,
                        },
                        success: function(res) {
                            if(res)
                                document.getElementById('videoContainer').innerHTML = res['html'];
                        },
                        error: function(err){
                            console.log(err);
                        }
                    });
                },
                tapTokenHandler: function(token, coupon, package_id){
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

                    var pacakge_id_ = document.createElement('input');
                    pacakge_id_.setAttribute('type', 'hidden');
                    pacakge_id_.setAttribute('name', 'item_id');
                    pacakge_id_.setAttribute('value', package_id);
                    form.appendChild(pacakge_id_);

                    var item_type = document.createElement('input');
                    item_type.setAttribute('type', 'hidden');
                    item_type.setAttribute('name', 'item_type');
                    item_type.setAttribute('value', 'package');
                    form.appendChild(item_type);
                    // Submit the form
                    form.submit();
                },
                showReplyForm: function(form_id){
                    $('#'+form_id).toggle();
                },
                payModel: function(package_id){
                    this.package_id = package_id;
                },
                regenerate_price: function(){


                    if(!this.auth){
                        window.location.replace('{{route('login')}}');
                    }

                    Data = {
                        package_id: app.package_id,
                        coupon_code: app.coupon,
                    };

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}'
                        }
                    });

                    $.ajax ({
                        type: 'POST',
                        url: '{{ route('price.details')}}',
                        data: Data,
                        success: function(res) {


                            if (res.error == '') {

                                app.price = Number(res.price);
                                app.discount = Number(res.discount);

                                if (app.price > app.discount) {
                                    app.newPrice = app.price - app.discount;
                                } else {

                                    app.newPrice = 0;
                                }


                                if (app.newPrice > 0 && app.visa_generated == 0 && app.auth == 1) {
                                    /** setup paypal **/
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
                                                    package_id: app.package_id,
                                                    coupon: app.coupon

                                                };


                                                $.ajaxSetup({
                                                    headers: {
                                                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                                                    }
                                                });

                                                $.ajax({
                                                    type: 'POST',
                                                    url: '{{ route('confirmPaymentMethod2')}}',
                                                    data: Data,
                                                    success: function (res) {
                                                        if (res == 0) {
                                                            swal({
                                                                title: 'Payment Complete Successfully !',
                                                                type: 'success',
                                                                //   confirmButtonColor: '#DD6B55',
                                                                confirmButtonText: 'Ok',
                                                            }).then(function () {
                                                                window.location = '{{route('my.package.view')}}';
                                                            });
                                                        } else {
                                                            swal({
                                                                title: res,
                                                                type: 'success',
                                                                //   confirmButtonColor: '#DD6B55',
                                                                confirmButtonText: 'Ok',
                                                            }).then(function () {
                                                                window.location = '{{route('my.package.view')}}';
                                                            });
                                                        }


                                                    },
                                                    error: function (res) {
                                                        console.log('Error:', res);
                                                    }
                                                });


                                            });
                                        }
                                    }).render('#paypal-button-container');
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
                            'X-CSRF-TOKEN': '{{csrf_token()}}'
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
                paytabs_charge: function(){
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}'
                        }
                    });

                    $.ajax ({
                        type: 'POST',
                        url: '{{ route('paytabs.charge')}}',
                        data: {
                            item_id: app.package_id,
                            item_type: 'package',
                            coupon_code: app.coupon,
                        },
                        success: function (res) {
                            if(res.error == ''){
                                window.location.replace(res.url);
                            }else{
                                // console.log(res);
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
@endsection
