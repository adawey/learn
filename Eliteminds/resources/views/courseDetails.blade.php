@extends('layouts.public')
@php
    use Illuminate\Support\Facades\DB;
    $topic = DB::table('course_details')->join('courses', 'course_details.course_id', '=', 'courses.id')
        ->where('course_details.id', request()->topic_id)
        ->select('course_details.*', 'courses.title AS course_title')
        ->first();
    if(!$topic){
        return redirect()->to(route('index'));
    }
@endphp
@section('content')
    <div class="section page-banner">

        <img class="shape-1 animation-round" src="{{asset('index-assets/images/shape/shape-8.png')}}" alt="Shape">

        <img class="shape-2" src="{{asset('index-assets/images/shape/shape-23.png')}}" alt="Shape">

        <div class="container">
            <!-- Page Banner Start -->
            <div class="page-banner-content">
                <ul class="breadcrumb">
                    <li><a href="#">Home</a></li>
                    <li class="active">{{$topic->course_title}}</li>
                </ul>
                <h2 class="title">{{$topic->title}}</h2>
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
                        <div class="blog-details-description">
                            <p>{!! $topic->description !!}</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
