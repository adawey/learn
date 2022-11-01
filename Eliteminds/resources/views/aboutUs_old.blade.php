@extends('layouts.public')
@section('head')
@endsection
@section('content')


    <div class="section page-banner">

        <img class="shape-1 animation-round" src="{{asset('index-assets/images/shape/shape-8.png')}}" alt="Shape">

        <img class="shape-2" src="{{asset('index-assets/images/shape/shape-23.png')}}" alt="Shape">

        <div class="container">
            <!-- Page Banner Start -->
            <div class="page-banner-content">
                <ul class="breadcrumb">
                    <li><a href="#">Home</a></li>
                    <li class="active">About</li>
                </ul>
                <h2 class="title">About <span>{{env('APP_NAME')}}.</span></h2>
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

    <div class="section">

        <div class="section-padding-02 mt-n10">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">

                        <!-- About Images Start -->
                        <div class="about-images">
                            <div class="images">
                                <img src="{{asset('index-assets/images/about.jpg')}}"` alt="About">
                            </div>

                            <div class="about-years">
                                <div class="years-icon">
                                    <img src="{{asset('index-assets/images/logo-icon.png')}}" alt="About">
                                </div>
                                <p><strong>28+</strong> Years Experience</p>
                            </div>
                        </div>
                        <!-- About Images End -->

                    </div>
                    <div class="col-lg-6">

                        <!-- About Content Start -->
                        <div class="about-content">
                            <h5 class="sub-title">Welcome to Edule.</h5>
                            <h2 class="main-title">You can join with Edule and upgrade your skill for your <span>bright future.</span></h2>
                            <p>Lorem Ipsum has been the industr’s standard dummy text ever since unknown printer took galley type and scmbled make type specimen book. It has survived not only five centuries.</p>
                            <a href="{{route('package.by.course')}}" class="btn btn-primary btn-hover-dark">Start A Course</a>
                        </div>
                        <!-- About Content End -->

                    </div>
                </div>
            </div>
        </div>

        <div class="section-padding-02 mt-n6">
            <div class="container">

                <!-- About Items Wrapper Start -->
                <div class="about-items-wrapper">
                    <div class="row">
                        <div class="col-lg-4">
                            <!-- About Item Start -->
                            <div class="about-item">
                                <div class="item-icon-title">
                                    <div class="item-icon">
                                        <i class="flaticon-tutor"></i>
                                    </div>
                                    <div class="item-title">
                                        <h3 class="title">Top Instructors</h3>
                                    </div>
                                </div>
                                <p>Lorem Ipsum has been the industry's standard dumy text since the when took and scrambled to make type specimen book has survived.</p>
                                <p>Lorem Ipsum has been the industry's standard dumy text since the when took and scrambled make.</p>
                            </div>
                            <!-- About Item End -->
                        </div>
                        <div class="col-lg-4">
                            <!-- About Item Start -->
                            <div class="about-item">
                                <div class="item-icon-title">
                                    <div class="item-icon">
                                        <i class="flaticon-coding"></i>
                                    </div>
                                    <div class="item-title">
                                        <h3 class="title">Portable Program</h3>
                                    </div>
                                </div>
                                <p>Lorem Ipsum has been the industry's standard dumy text since the when took and scrambled to make type specimen book has survived.</p>
                                <p>Lorem Ipsum has been the industry's standard dumy text since the when took and scrambled make.</p>
                            </div>
                            <!-- About Item End -->
                        </div>
                        <div class="col-lg-4">
                            <!-- About Item Start -->
                            <div class="about-item">
                                <div class="item-icon-title">
                                    <div class="item-icon">
                                        <i class="flaticon-increase"></i>
                                    </div>
                                    <div class="item-title">
                                        <h3 class="title">Improve Quickly</h3>
                                    </div>
                                </div>
                                <p>Lorem Ipsum has been the industry's standard dumy text since the when took and scrambled to make type specimen book has survived.</p>
                                <p>Lorem Ipsum has been the industry's standard dumy text since the when took and scrambled make.</p>
                            </div>
                            <!-- About Item End -->
                        </div>
                    </div>
                </div>
                <!-- About Items Wrapper End -->

            </div>
        </div>

    </div>



    <!-- Testimonial End -->
    <div class="section section-padding-02 mt-n1 my-5">
        <div class="container">

            <!-- Section Title Start -->
            <div class="section-title shape-03 text-center">
                <h5 class="sub-title">Student Testimonial</h5>
                <h2 class="main-title">Feedback From <span> Student</span></h2>
            </div>
            <!-- Section Title End -->

            <!-- Testimonial Wrapper End -->
            <div class="testimonial-wrapper testimonial-active">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                    @foreach($userFeedBack as $feedback)
                        <!-- Single Testimonial Start -->
                            <div class="single-testimonial swiper-slide">
                                <div class="testimonial-author">
                                    <div class="author-thumb">
                                        @if($feedback->profile_pic)
                                            <img src="{{url('storage/profile_picture/'.basename($feedback->profile_pic))}}" alt="Author">
                                        @else
                                            <img src="{{asset('index-assets/images/author/author-'.rand(12, 16).'.jpg')}}" alt="Author">
                                        @endif


                                        <i class="icofont-quote-left"></i>
                                    </div>
                                    <span class="rating-star">
                                        <span class="rating-bar" style="width: {{$feedback->rate * 100 /5}}%;"></span>
                                </span>
                                </div>
                                <div class="testimonial-content">
                                    <p>{{$feedback->feedback}}</p>
                                    <h4 class="name">{{$feedback->name}}</h4>
                                    <span class="designation">{{$feedback->country}}</span>
                                </div>
                            </div>
                            <!-- Single Testimonial End -->
                    </div>
                @endforeach
                <!-- Add Pagination -->
                    <div class="swiper-pagination"></div>
                </div>
            </div>
            <!-- Testimonial Wrapper End -->

        </div>
    </div>
    <!-- Testimonial End -->

@endsection
