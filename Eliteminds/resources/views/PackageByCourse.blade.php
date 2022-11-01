@extends('layouts.public')

@section('content')
    <!-- Page Banner Start -->
    <div class="section page-banner">

        <img class="shape-1 animation-round" src="{{asset('index-assets/images/shape/shape-8.png')}}" alt="Shape">

        <img class="shape-2" src="{{asset('index-assets/images/shape/shape-23.png')}}" alt="Shape">

        <div class="container">
            <!-- Page Banner Start -->
            <div class="page-banner-content">
                <ul class="breadcrumb">
                    <li><a href="{{route('index')}}">Home</a></li>
                    <li class="active">Courses</li>
                </ul>
                <h2 class="title">All <span>Courses</span></h2>
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
    <!-- Page Banner End -->

    <!-- Courses Start -->
    <div class="section section-padding">
        <div class="container">

            <!-- Courses Category Wrapper Start  -->
            <!--<div class="courses-category-wrapper">-->
            <!--    <div class="courses-search search-2">-->

            <!--    </div>-->

                <!--<ul class="category-menu">-->
                <!--    @foreach(\App\Course::where('private', 0)->get() as $c)-->
                <!--        <li><a @if(request()->course_id == $c->id) class="active" @endif style="width:auto;" href="{{route('package.by.course', $c->id)}}">{{$c->title}}</a></li>-->
                <!--    @endforeach-->
                <!--</ul>-->
            <!--</div>-->
            <!-- Courses Category Wrapper End  -->

            <!-- Courses Wrapper Start  -->
            <div class="courses-wrapper-02">
                <div class="row">
                    @foreach($best_sell as $package)
                        <div class="col-lg-4 col-md-6">
                            <!-- Single Courses Start -->
                            <div class="single-courses">
                                <div class="courses-images">
                                    <a href="{{route('public.package.view', $package->package->id)}}"><img src="{{url('storage/package/imgs/'.basename($package->package->img))}}" alt="Courses"></a>
                                </div>
                                <div class="courses-content">
                                    <div class="courses-author">
                                        <div class="author">
                                            <div class="author-name">
                                                
                                                <a class="name" href="{{route('public.package.view', $package->package->id)}}">{{$package->package->course_title}}</a>
                                            </div>
                                        </div>
                                        <!--<div class="tag">-->
                                        <!--    <a href="javascript:;">Popular</a>-->
                                        <!--</div>-->
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
                            <!-- Single Courses End -->
                        </div>
                    @endforeach

                </div>
            </div>
            <!-- Courses Wrapper End  -->

        </div>
    </div>
    <!-- Courses End -->
@endsection
