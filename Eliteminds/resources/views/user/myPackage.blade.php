@extends('layouts.layoutV2')

@section('content')
    <div class="container">
        <!-- Title and Top Buttons Start -->
        <div class="page-title-container">
            <div class="row">
                <!-- Title Start -->
                <div class="col-12 col-md-7">
                    <h1 class="mb-0 pb-0 display-4" id="title">My Packages</h1>
                    <nav class="breadcrumb-container d-inline-block" aria-label="breadcrumb">
                        <ul class="breadcrumb pt-0">
                            <li class="breadcrumb-item"><a href="{{route('user.dashboard')}}">Dashboard</a></li>
                        </ul>
                    </nav>
                </div>
                <!-- Title End -->
            </div>
        </div>
        <!-- Title and Top Buttons End -->

        <!-- Content Start -->

        <!-- Popular Start -->
        <div class="d-flex justify-content-between">
            <h2 class="small-title">Available Packages</h2>
        </div>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-3 mb-5">
            @foreach($exam_package_list_by_course as $course_id => $package_arr)
                @foreach($package_arr as $i)

                    <div class="col">
                        <div class="card h-100">
                            <img src="{{ url('storage/package/imgs/'.basename($i->package->img))}}" class="card-img-top sh-22" alt="card image" />
                            <div class="card-body">
                                <h5 class="heading mb-0"><a href="{{route('package.details', $i->package->package_id)}}" class="body-link stretched-link">
                                        {{Transcode::evaluate(\App\Packages::find($i->package->package_id))['name']}}
                                    </a></h5>
                            </div>
                            <div class="card-footer border-0 pt-0">
                                <div class="mb-2">
                                    <div class="br-wrapper br-theme-cs-icon d-inline-block">
                                        <select class="rating" name="rating" autocomplete="off" data-readonly="true" data-initial-rating="{{floor($i->package->rating ? $i->package->rating: -1)}}">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                    
{{--                                    <div class="text-muted d-inline-block text-small align-text-top">(114)</div>--}}
                                </div>

                                <div class="card-text mb-0">
                                    {{__('User/myPackages.expire-at')}} {{$i->meta_data['expire_date']}}
                                </div>
                            </div>
                        </div>
                    </div>

                @endforeach
            @endforeach
        </div>
        <!-- Popular End -->

        <!-- Paths Start -->
        <h2 class="small-title">Courses</h2>
        <div class="row g-3 row-cols-1 row-cols-xl-2 row-cols-xxl-4 mb-5">
            @php
                $icons = ['user-assets/img/illustration/icon-accounts.png', 'user-assets/img/illustration/icon-storage.png', 'user-assets/img/illustration/icon-experiment.png', 'user-assets/img/illustration/icon-performance.png'];
            @endphp
            @foreach($courses as $course)
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="text-center">
                                <img src="{{asset(array_random($icons))}}" class="theme-filter" alt="performance" />
                                <div class="d-flex flex-column sh-5">
                                    <a href="{{route('package.by.course')}}?course_id={{$course->id}}" class="heading stretched-link">{{$course->title}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
        <!-- Paths End -->

{{--        <h2 class="small-title">Sale</h2>--}}
{{--        <div class="row g-3">--}}
{{--            <div class="col-lg-6 mb-5 position-relative">--}}
{{--                <span class="badge rounded-pill bg-primary me-1 position-absolute e-4 t-n2 z-index-1">-30%</span>--}}
{{--                <div class="card w-100 sh-24 hover-img-scale-up">--}}
{{--                    <img src="{{asset('user-assets/img/banner/cta-horizontal-short-1.jpg')}}" class="card-img h-100 scale" alt="card image" />--}}
{{--                    <div class="card-img-overlay d-flex flex-column justify-content-between bg-transparent">--}}
{{--                        <div>--}}
{{--                            <div class="cta-3 mb-3 text-black w-75 w-md-50">Introduction to Sandwich Making</div>--}}
{{--                            <div class="text-muted text-overline text-small">--}}
{{--                                <del>$ 32.50</del>--}}
{{--                            </div>--}}
{{--                            <div class="mb-4">$ 26.25</div>--}}
{{--                            <a href="#" class="btn btn-icon btn-icon-start btn-primary stretched-link">--}}
{{--                                <i data-cs-icon="chevron-right"></i>--}}
{{--                                <span>View</span>--}}
{{--                            </a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-lg-6 mb-5 position-relative">--}}
{{--                <span class="badge rounded-pill bg-primary me-1 position-absolute e-4 t-n2 z-index-1">-25%</span>--}}
{{--                <div class="card w-100 sh-24 hover-img-scale-up">--}}
{{--                    <img src="{{asset('user-assets/img/banner/cta-horizontal-short-2.jpg')}}" class="card-img h-100 scale" alt="card image" />--}}
{{--                    <div class="card-img-overlay d-flex flex-column justify-content-between bg-transparent">--}}
{{--                        <div>--}}
{{--                            <div class="cta-3 mb-3 text-black w-75 w-md-50">Effects of Natural Ingredients</div>--}}
{{--                            <div class="text-overline text-small">--}}
{{--                                <del>$ 32.50</del>--}}
{{--                            </div>--}}
{{--                            <div class="mb-4">$ 19.80</div>--}}
{{--                            <a href="#" class="btn btn-icon btn-icon-start btn-primary stretched-link">--}}
{{--                                <i data-cs-icon="chevron-right"></i>--}}
{{--                                <span>View</span>--}}
{{--                            </a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

        <!-- Content End -->
    </div>
    
@endsection
@section('jscode')
    <script src="{{asset('user-assets/js/pages/course.explore.js')}}"></script>
@endsection
