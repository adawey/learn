@extends('layouts.public')
@section('head')
    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">-->
    <title>{{env('APP_NAME')}}</title>
@endsection
@section('content')
    <!-- Slider Start -->
    <div class="section slider-section ">

        <!-- Slider Shape Start -->
        <div class="slider-shape">
            {{-- <img class="shape-1 animation-round" src="{{asset('index-assets/images/shape/shape-8.png')}}" alt="Shape"> --}}
        </div>
        <!-- Slider Shape End -->

        <div class="container">

            <!-- Slider Content Start -->
            <div class="slider-content">
                {{-- <h4 class="sub-title">Start your favourite course</h4> --}}
                <h2 class="main-title">Experts in Project and Business Management  </h2>
                <p>Our mission is to deliver affordable and high quality self-paced courses in a convenient manner to help professionals achieve their learning goals anytime anywhere. </p>
                <a class="btn btn-primary btn-hover-dark" href="{{route('user.dashboard')}}">Explore Courses</a>
            </div>
            <!-- Slider Content End -->

        </div>

        <!-- Slider Courses Box Start -->
        <div class="slider-courses-box">

            <img class="shape-1 animation-left" src="{{asset('index-assets/images/shape/shape-5.png')}}" alt="Shape">

            <div class="box-content">
                <div class="box-wrapper">
                    <i class="flaticon-open-book"></i>
                    <span class="count">{{$webSiteStatistics->package_no}}</span>
                    <p>courses</p>
                </div>
            </div>

            <img class="shape-2" src="{{asset('index-assets/images/shape/shape-6.png')}}" alt="Shape">

        </div>
        <!-- Slider Courses Box End -->

        <!-- Slider Rating Box Start -->
        <div class="slider-rating-box">

            <div class="box-rating">
                <div class="box-wrapper">
                    <span class="count">{{round($feedbackRating->rate, 2)}} <i class="flaticon-star"></i></span>
                    <p>Rating ({{$feedbackRating->rate_count}})</p>
                </div>
            </div>

            <img class="shape animation-up" src="{{asset('index-assets/images/shape/shape-7.png')}}" alt="Shape">

        </div>
        <!-- Slider Rating Box End -->

        <!-- Slider Images Start -->
        <div class="slider-images">
            <div class="images">
               <img src="{{asset('index-assets/images/slider/slider-1.png')}}" alt="Slider"> 
            </div>
        </div>
        <!-- Slider Images End -->

        <!-- Slider Video Start -->
        <div class="slider-video">
            <img class="shape-1" src="{{asset('index-assets/images/shape/shape-9.png')}}" alt="Shape">

            <div class="video-play">
                <img src="{{asset('index-assets/images/shape/shape-10.png')}}" alt="Shape">
                <a href="https://www.youtube.com/watch?v=BRvyWfuxGuU" class="play video-popup"><i class="flaticon-play"></i></a>
            </div>
        </div>
        <!-- Slider Video End -->

    </div>
    <!-- Slider End -->

    <!-- All Courses Start -->
    <div class="section section-padding-02">
        <div class="container">

            <!-- All Courses Top Start -->
            <div class="courses-top">

                <!-- Section Title Start -->
                <div class="section-title shape-01">
                    <h2 class="main-title">All <span>Courses</span> of Elite Minds</h2>
                </div>
                <!-- Section Title End -->


            </div>
            <!-- All Courses Top End -->

          
            <!-- All Courses tab content Start -->
            <div class="tab-content courses-tab-content">
                @foreach($courses as $course)
                <div class="tab-pane fade @if($loop->first) show active @endif" id="tabs1">
                    <!-- All Courses Wrapper Start -->
                    <div class="courses-wrapper">
                        <div class="row">
                            @foreach($popular_courses as $package)
                            
                                <div class="col-lg-4 col-md-6">
                                    <!-- Single Courses Start -->
                                     <a href="{{route('public.package.view', $package->package->id)}}">
                                    <div class="single-courses">
                                        <div class="courses-images">
                                            <a href="{{route('public.package.view', $package->package->id)}}"><img src="{{url('storage/package/imgs/'.basename($package->package->img))}}" alt="Courses"></a>
                                        </div>
                                       
                                        <div class="courses-content">
                                             
                                            <div class="courses-author">
                                                <a href="{{route('public.package.view', $package->package->id)}}">
                                                <div class="author">
                                                    <div class="author-name">
                                                        <a class="name"href="{{route('public.package.view', $package->package->id)}}">{{$package->package->course_title}}</a>
                                                    </div>
                                                </div>
                                               
                                                </a>
                                            </div>
                                                
                                            <h4 class="title"><a href="{{route('public.package.view', $package->package->id)}}">{{$package->package->name}}</a></h4>
                                            <a href="{{route('public.package.view', $package->package->id)}}">
                                            <div class="courses-meta">
                                               
                                                <span> <i class="icofont-clock-time"></i> {{$package->package->total_time}} Hrs</span>
                                                <span> <i class="icofont-read-book"></i> {{$package->lessons_number}} Lectures </span>
                                               
                                            </div>
                                             </a>
                                            <div class="courses-price-review">
                                                {{-- {{ route('paytabs_payment_test',$package->package->id) }} --}}
                                                <a href="" class="courses-price">
                                                    @if($package->pricing['localized_price'] == $package->pricing['localized_original_price'])
                                                    <span class="sale-parice">{{$package->pricing['localized_price']}} {{$package->pricing['currency_code']}}</span>
                                                    @else
                                                    <span class="sale-parice">{{$package->pricing['localized_price']}} {{$package->pricing['currency_code']}}</span>
                                                    <span class="old-parice">{{$package->pricing['localized_original_price']}} {{$package->pricing['currency_code']}}</span>
                                                    @endif
                                                </a>
                                                 
                                                <div class="courses-review">
                                                    <span class="rating-count">{{round($package->package->rate, 2)}}</span>
                                                    <span class="rating-star">
                                                            <span class="rating-bar" style="width: {{round($package->package->rate)*100/5}}%;"></span>
                                                    </span>
                                                </div>
                                               
                                            </div>
                                        </div>
                                    </div>
                                    </a>
                                    <!-- Single Courses End -->
                                </div>
                                
                          @endforeach
                        </div>
                    </div>
                    <!-- All Courses Wrapper End -->
                </div>
                @endforeach
            </div>
            <!-- All Courses tab content End -->

            <!-- All Courses BUtton Start -->
            <div class="courses-btn text-center">
                <a href="{{route('package.by.course')}}" class="btn btn-secondary btn-hover-primary">Other Course</a>
            </div>
            <!-- All Courses BUtton End -->

        </div>
    </div>
    <!-- All Courses End -->

    <!-- How It Work End -->
    <div class="section section-padding mt-n1">
        <div class="container">

            <!-- Section Title Start -->
            <div class="section-title shape-03 text-center">
                <h5 class="sub-title">Over {{$webSiteStatistics->package_no}}+ Course</h5>
                <h2 class="main-title">How It <span> Work?</span></h2>
            </div>
            <!-- Section Title End -->

            <!-- How it Work Wrapper Start -->
            <div class="how-it-work-wrapper">



                <!-- Single Work Start -->
                <div class="single-work" style="min-height: 350px;">
                    <img class="shape-2" src="{{asset('index-assets/images/shape/shape-15.png')}}" alt="Shape">

                    <div class="work-icon">
                        <i class="fa fa-door-open"></i>
                    </div>
                    <div class="work-content">
                        <h3 class="title">Visit our blog</h3>
                        <p>Our blog is equipped with all information necessary to prepare for any of the PMI certifications. Access it for free 
                            <a href="{{route('public.blog.index')}}" class="text text-primary">Our Blog</a>
                        </p>
                    </div>
                </div>
                <!-- Single Work End -->

                <!-- Single Work Start -->
                <div class="work-arrow">
                    <img class="arrow" src="{{asset('index-assets/images/shape/shape-17.png')}}" alt="Shape">
                </div>
                <!-- Single Work End -->

                <!-- Single Work Start -->
                <div class="single-work" style="min-height: 350px;">
                    <img class="shape-3" src="{{asset('index-assets/images/shape/shape-16.png')}}" alt="Shape">

                    <div class="work-icon">
                        <i class="fa fa-search"></i>
                    </div>
                    <div class="work-content">
                        <h3 class="title">Explore our courses</h3>
                        <p>Based on the certification exam you are preparing for, select the course that best fits your needs</p>
                    </div>
                </div>
                <!-- Single Work End -->

                <!-- Single Work Start -->
                <div class="work-arrow">
                    <img class="arrow" src="{{asset('index-assets/images/shape/shape-17.png')}}" alt="Shape">
                </div>
                <!-- Single Work End -->

                <!-- Single Work Start -->
                <div class="single-work" style="min-height: 350px;">
                    <img class="shape-3" src="{{asset('index-assets/images/shape/shape-13.png')}}" alt="Shape">

                    <div class="work-icon">
                        <i class="fa fa-user-graduate"></i>
                    </div>
                    <div class="work-content">
                        <h3 class="title">Register and Book a Seat</h3>
                        <p>After you selected the course, register and start your exciting learning journey</p>
                    </div>
                </div>
                <!-- Single Work End -->

                <!-- Single Work Start -->
                <div class="work-arrow">
                    <img class="arrow" src="{{asset('index-assets/images/shape/shape-17.png')}}" alt="Shape">
                </div>
                <!-- Single Work End -->

                <!-- Single Work Start -->
                <div class="single-work" style="min-height: 350px;">
                    <img class="shape-3" src="{{asset('index-assets/images/shape/shape-15.png')}}" alt="Shape">

                    <div class="work-icon">
                        <i class="fa fa-graduation-cap"></i>
                    </div>
                    <div class="work-content">
                        <h3 class="title">Obtain your certification</h3>
                        <p>Upon 100% completion of the course material, you will be able to download your certification of completion</p>
                    </div>
                </div>
                <!-- Single Work End -->




            </div>

        </div>
    </div>
    <!-- How It Work End -->

   
    <!-- Testimonial End -->
    <div class="section section-padding-02 mt-n1">
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
                                <h4 class="name">{{$feedback->name ?? $feedback->title}}</h4>
{{--                                <span class="designation">{{$feedback->country}}</span>--}}
                            </div>
                        </div>
                        <!-- Single Testimonial End -->
                    @endforeach
                    </div>
                    <!-- Add Pagination -->
                    <div class="swiper-pagination"></div>
                </div>
            </div>
            <!-- Testimonial Wrapper End -->

        </div>
    </div>
    <!-- Testimonial End -->

    <!-- Brand Logo Start -->
    <div class="section section-padding-02">
        <div class="container">

            <!-- Brand Logo Wrapper Start -->
            <div class="brand-logo-wrapper">

                <!--<img class="shape-1" src="{{asset('index-assets/images/shape/shape-19.png')}}" alt="Shape">-->

                <img class="shape-2 animation-round" src="{{asset('index-assets/images/shape/shape-20.png')}}" alt="Shape">

                <!-- Section Title Start -->
                <div class="section-title shape-03">
                    <h2 class="main-title">We Can Help you achieve those accreditations</h2>
                </div>
                <!-- Section Title End -->

                <!-- Brand Logo Start -->
                <div class="brand-logo brand-active">
                    <div class="swiper-container">
                        <div class="swiper-wrapper">

                            <!-- Single Brand Start -->
                            <div class="single-brand swiper-slide">
                                <img src="{{asset('index-assets/Courses_index/CAPM.png')}}" alt="Brand">
                            </div>
                            <!-- Single Brand End -->

                            <!-- Single Brand Start -->
                            <div class="single-brand swiper-slide">
                                <img src="{{asset('index-assets/Courses_index/PFMP.png')}}" alt="Brand">
                            </div>
                            <!-- Single Brand End -->

                            <!-- Single Brand Start -->
                            <div class="single-brand swiper-slide">
                                <img src="{{asset('index-assets/Courses_index/PGMP.png')}}" alt="Brand">
                            </div>
                            <!-- Single Brand End -->

                            <!-- Single Brand Start -->
                            <div class="single-brand swiper-slide">
                                <img src="{{asset('index-assets/Courses_index/PMI ACP.png')}}" alt="Brand">
                            </div>
                            <!-- Single Brand End -->

                            <!-- Single Brand Start -->
                            <div class="single-brand swiper-slide">
                                <img src="{{asset('index-assets/Courses_index/PMI PBA.png')}}" alt="Brand">
                            </div>
                            <!-- Single Brand End -->

                            <!-- Single Brand Start -->
                            <div class="single-brand swiper-slide">
                                <img src="{{asset('index-assets/Courses_index/PMI RMP.png')}}" alt="Brand">
                            </div>
                            <!-- Single Brand End -->
                            <!-- Single Brand Start -->
                            <div class="single-brand swiper-slide">
                                <img src="{{asset('index-assets/Courses_index/PMI SP.png')}}" alt="Brand">
                            </div>
                            <!-- Single Brand End -->
                            <!-- Single Brand Start -->
                            <div class="single-brand swiper-slide">
                                <img src="{{asset('index-assets/Courses_index/PMP.png')}}" alt="Brand">
                            </div>
                            <!-- Single Brand End -->

                        </div>
                    </div>
                </div>
                <!-- Brand Logo End -->

            </div>
            <!-- Brand Logo Wrapper End -->

        </div>
    </div>
    <!-- Brand Logo End -->

    <!-- Blog Start -->
    <div class="section section-padding mt-n1">
        <div class="container">

            <!-- Section Title Start -->
            <div class="section-title shape-03 text-center">
                <h5 class="sub-title">Latest News</h5>
                <h2 class="main-title">Educational Tips & <span> Tricks</span></h2>
            </div>
            <!-- Section Title End -->

            <!-- Blog Wrapper Start -->
            <div class="blog-wrapper">
                <div class="row">
                    @foreach($posts as $post)
                        <div class="col-lg-4 col-md-6">
                            <!-- Single Blog Start -->
                            <div class="single-blog">
                                <div class="blog-image" style="">
                                    <a href="{{route('public.post.view', $post->slug )}}">
                                        <img src="{{$post->cover ? $post->cover: 'https://via.placeholder.com/300'}}" style="object-fit: cover" alt="Blog">
                                    </a>
                                </div>
                                <div class="blog-content">

                                    <h4 class="title">
                                        <a href="{{route('public.post.view', $post->slug )}}">
                                            {{$post->title}}
                                        </a>
                                    </h4>

                                    <div class="blog-meta">
                                        <span> <i class="icofont-calendar"></i> {{\Carbon\Carbon::parse($post->created_at)->diffForHumans() }}</span>
                                        <a href="{{route('public.post.view', $post->slug)}}" class="btn btn-secondary btn-hover-primary">Read More</a>
                                    </div>


                                </div>
                                <!-- Single Blog End -->
                            </div>
                        </div>
                    @endforeach
                    <div class="courses-btn text-center">
                        <a href="{{route('public.blog.index')}}" class="btn btn-secondary btn-hover-primary">Other Blog</a>
                    </div>
                </div>
            </div>
            <!-- Blog Wrapper End -->

        </div>
    </div>
    <!-- Blog End -->
@endsection
