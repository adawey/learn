@extends('layouts.public')

@section('head')
    <title>{{ app()->getLocale() == 'en' ? $post->title: Transcode::evaluate(\App\Post::find($post->id))['title'] }}</title>
    <meta property="og:title" content="{{ app()->getLocale() == 'en' ? $post->title: Transcode::evaluate(\App\Post::find($post->id))['title'] }}"/>
    <meta property="og:type" content="article"/>
    <meta property="og:image" content="{{asset($post->cover)}}"/>
    
    <style>
        .blog-details-description > ol,.blog-details-description > ul {
            list-style: auto !important;
            margin: 10px 0 10px 25px;
            
        }
        
    </style>
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
                    <li class="active">Blog</li>
                </ul>
                <h2 class="title">
                    {{$post->title}}
                    @foreach($post->sections as $section)
                        <span class="badge badge-primary fs-6">{{app()->getLocale() == 'en' ? $section->title: $section->title_ar}}</span>
                    @endforeach
                </h2>

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
    <div class="section section-padding mt-n10">
        <div class="container">
            <div class="row gx-10">
                <div class="col-lg-12">

                    <!-- Blog Details Wrapper Start -->
                    <div class="blog-details-wrapper">
                        <div class="blog-details-admin-meta">
                            <div class="blog-meta">
                                <span> <i class="icofont-calendar"></i> {{\Carbon\Carbon::parse($post->created_at)->diffForHumans()}}</span>
                            </div>
                        </div>


                        <div class="blog-details-description">
                            {!! $post->content !!}
                        </div>
                    </div>
                    <!-- Blog Details Wrapper End -->

                    <!-- Blog Details Comment End -->
{{--                    <div class="blog-details-comment">--}}
{{--                        <div class="comment-wrapper">--}}
{{--                            <h3 class="title">Comments (03)</h3>--}}

{{--                            <ul class="comment-items">--}}
{{--                                <li>--}}
{{--                                    <!-- Single Comment Start -->--}}
{{--                                    <div class="single-comment">--}}
{{--                                        <div class="comment-author">--}}
{{--                                            <div class="author-thumb">--}}
{{--                                                <img src="assets/images/author/author-01.jpg" alt="Author">--}}
{{--                                            </div>--}}
{{--                                            <div class="author-content">--}}
{{--                                                <h4 class="name">Sara Alexander</h4>--}}
{{--                                                <div class="meta">--}}
{{--                                                    <span class="designation">Product Designer, USA</span>--}}
{{--                                                    <span class="time">35 minutes ago</span>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <p>Lorem Ipsum has been the industry's standard dummy text since the 1500 when unknown printer took a galley type and scrambled to make type specimen’s book has survived not five centuries but also the leap into electronic type and book.</p>--}}
{{--                                        <a href="#" class="reply"> <i class="icofont-reply"></i> Reply</a>--}}
{{--                                    </div>--}}
{{--                                    <!-- Single Comment End -->--}}

{{--                                    <ul class="comment-reply">--}}
{{--                                        <li>--}}
{{--                                            <!-- Single Comment Start -->--}}
{{--                                            <div class="single-comment">--}}
{{--                                                <div class="comment-author">--}}
{{--                                                    <div class="author-thumb">--}}
{{--                                                        <img src="assets/images/author/author-03.jpg" alt="Author">--}}
{{--                                                    </div>--}}
{{--                                                    <div class="author-content">--}}
{{--                                                        <h4 class="name">Robert Morgan</h4>--}}
{{--                                                        <div class="meta">--}}
{{--                                                            <span class="designation">Product Designer, USA</span>--}}
{{--                                                            <span class="time">35 minutes ago</span>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                                <p>Lorem Ipsum has been the industry's standard dumm text since the 1500 when printer took a galley type and scrambled to make type specimen book survived centuries but also the electronic type and book.</p>--}}
{{--                                                <a href="#" class="reply"> <i class="icofont-reply"></i> Reply</a>--}}
{{--                                            </div>--}}
{{--                                            <!-- Single Comment End -->--}}
{{--                                        </li>--}}
{{--                                    </ul>--}}
{{--                                </li>--}}
{{--                                <li>--}}
{{--                                    <!-- Single Comment Start -->--}}
{{--                                    <div class="single-comment">--}}
{{--                                        <div class="comment-author">--}}
{{--                                            <div class="author-thumb">--}}
{{--                                                <img src="assets/images/author/author-07.jpg" alt="Author">--}}
{{--                                            </div>--}}
{{--                                            <div class="author-content">--}}
{{--                                                <h4 class="name">Rochelle Hunt</h4>--}}
{{--                                                <div class="meta">--}}
{{--                                                    <span class="designation">Product Designer, USA</span>--}}
{{--                                                    <span class="time">35 minutes ago</span>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <p>Lorem Ipsum has been the industry's standard dummy text since the 1500 when unknown printer took a galley type and scrambled to make type specimen’s book has survived not five centuries but also the leap into electronic type and book.</p>--}}
{{--                                        <a href="#" class="reply"> <i class="icofont-reply"></i> Reply</a>--}}
{{--                                    </div>--}}
{{--                                    <!-- Single Comment End -->--}}
{{--                                </li>--}}
{{--                            </ul>--}}
{{--                        </div>--}}
{{--                        <div class="comment-form">--}}
{{--                            <h3 class="title">Leave a comment</h3>--}}

{{--                            <!-- Form Wrapper Start -->--}}
{{--                            <div class="form-wrapper">--}}
{{--                                <form action="#">--}}
{{--                                    <div class="row">--}}
{{--                                        <div class="col-md-6">--}}
{{--                                            <!-- Form Wrapper Start -->--}}
{{--                                            <div class="single-form">--}}
{{--                                                <input type="text" placeholder="Name">--}}
{{--                                            </div>--}}
{{--                                            <!-- Form Wrapper End -->--}}
{{--                                        </div>--}}
{{--                                        <div class="col-md-6">--}}
{{--                                            <!-- Form Wrapper Start -->--}}
{{--                                            <div class="single-form">--}}
{{--                                                <input type="email" placeholder="Email">--}}
{{--                                            </div>--}}
{{--                                            <!-- Form Wrapper End -->--}}
{{--                                        </div>--}}
{{--                                        <div class="col-md-12">--}}
{{--                                            <!-- Form Wrapper Start -->--}}
{{--                                            <div class="single-form">--}}
{{--                                                <textarea placeholder="Massage"></textarea>--}}
{{--                                            </div>--}}
{{--                                            <!-- Form Wrapper End -->--}}
{{--                                        </div>--}}
{{--                                        <div class="col-md-12">--}}
{{--                                            <!-- Form Wrapper Start -->--}}
{{--                                            <div class="single-form text-center">--}}
{{--                                                <button class="btn btn-primary btn-hover-dark">Submit Now</button>--}}
{{--                                            </div>--}}
{{--                                            <!-- Form Wrapper End -->--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </form>--}}
{{--                            </div>--}}
{{--                            <!-- Form Wrapper End -->--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    <!-- Blog Details Comment End -->

                </div>
            </div>
        </div>
    </div>
@endsection
