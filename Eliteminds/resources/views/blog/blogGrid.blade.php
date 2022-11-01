@extends('layouts.public')
@section('head')
    <title>{{env('APP_NAME')}} | Blog</title>
    <style>
        .nice-select {
            border: 1px solid #ccc !important;
            padding: 5px 5px 0 5px !important;
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
                <h2 class="title">Our <span>Blog</span></h2>
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
            <div class="container mb-6 mb-xl-8 z-index-2">
                <label for="section_id" class="col-md-2">Browse By</label>
                <div class="row my-2">

                    <div class="col-md-6">
                        <div class="form-group">
                            <select name="section_id" id="section_id" class="form-control" onchange="window.location.replace('{{route('public.blog.index').'?section_id='}}'+this.value)">
                                <option value="">All</option>
                                @foreach(\App\Section::all() as $section)
                                    <option value="{{$section->id}}" {{request()->section_id == $section->id ? 'selected': ''}}>{{Transcode::evaluate($section)['title']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Blog Wrapper Start -->
            <div class="blog-wrapper">
                <div class="row">
                    @foreach($posts as $post)
                        <div class="col-lg-4 col-md-6">
                            <!-- Single Blog Start -->
                            <div class="single-blog">
                                <div class="blog-image" style="max-height: 300px; overflow:hidden;">
                                    <a href="{{route('public.post.view', $post->slug ?? $post->id)}}">
                                        <img src="{{$post->cover ? $post->cover: 'https://via.placeholder.com/300'}}" alt="Blog">
                                    </a>
                                </div>
                                <div class="blog-content">

                                    <h4 class="title">
                                        <a href="{{route('public.post.view', $post->id)}}">
                                            {{$post->title}}
                                        </a>
                                    </h4>

                                    <div class="blog-meta">
                                        <span> <i class="icofont-calendar"></i> {{\Carbon\Carbon::parse($post->created_at)->diffForHumans() }}</span>
                                        <a href="{{route('public.post.view', $post->slug )}}" class="btn btn-secondary btn-hover-primary">Read More</a>
                                    </div>


                                </div>
                                <!-- Single Blog End -->
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- Blog Wrapper End -->

        </div>
    </div>
@endsection
