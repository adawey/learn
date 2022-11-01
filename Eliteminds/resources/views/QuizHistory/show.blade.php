@extends('layouts.layoutV2')

@section('content')

    <div class="container">
        <!-- Title and Top Buttons Start -->
        <div class="page-title-container">
            <div class="row">
                <!-- Title Start -->
                <div class="col-12 col-md-7">
                    <h1 class="mb-0 pb-0 display-4" id="title">Quiz Results</h1>
                    <nav class="breadcrumb-container d-inline-block" aria-label="breadcrumb">
                        <ul class="breadcrumb pt-0">
                            <li class="breadcrumb-item"><a href="{{route('user.dashboard')}}">Dashabord</a></li>
                            <li class="breadcrumb-item"><a href="javascript:;">Quiz History</a></li>
                        </ul>
                    </nav>
                </div>
                <!-- Title End -->
            </div>
        </div>
        <!-- Title and Top Buttons End -->

        <!-- Content Start -->

        <div class="row d-none d-lg-flex mb-3 g-0">
            <div class="col-auto">
                <div class="sw-lg-16 sh-1"></div>
            </div>
            <div class="col">
                <div class="row gx-2 px-5">
                    <div class="col-5">
                        <div class="text-muted text-small">TOPIC</div>
                    </div>
                    <div class="col-2">
                        <div class="text-muted text-small">OVERALL</div>
                    </div>
                    <div class="col-1">
                        <div class="text-muted text-small">SCORE</div>
                    </div>
                    <div class="col-2 text-end">
                        <div class="text-muted text-small text-center">DURATION</div>
                    </div>
                    <div class="col-2 text-end">
                        <div class="text-muted text-small">TIME</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-5">
            @php
                $attempt = count(\App\Quiz::where('user_id', Auth::user()->id)->where('complete', 1)->orderBy('updated_at', 'desc')->get());
            @endphp
            @foreach(\App\Quiz::where('user_id', Auth::user()->id)->where('complete', 1)->orderBy('updated_at', 'desc')->get() as $quiz_z)
            <div class="col-sm-6 col-lg-12">
                <div class="card">
                    <div class="row g-0 h-auto sh-lg-12">
                        <div class="col-12 col-lg p-0 h-100">
                            <div class="card-body h-100">
                                <div class="row gx-2 d-flex h-100 align-items-lg-center">
                                    <div class="col-lg-5 mb-2 mb-lg-1">
                                        <a href="{{route('QuizHistory.show', $quiz_z->id)}}" class="stretched-link body-link">
                                            <div class="lh-1-5 mb-0">
                                                @if($quiz_z->topic_type == 'chapter')
                                                    {{Transcode::evaluate(\App\Chapters::find($quiz_z->topic_id))['name'] }}
                                                @elseif($quiz_z->topic_type == 'process')
                                                    {{Transcode::evaluate(\App\Process_group::find($quiz_z->topic_id))['name']}} {{ $quiz_z->part_id ? '[Part '.$quiz_z->part_id.']': '' }}
                                                @elseif($quiz_z->topic_type == 'mistake')
                                                    @if($quiz_z->topic_id == 1)
                                                        {{__('User/quizHistory.chapters-mistakes')}}
                                                    @elseif($quiz_z->topic_id == 2)
                                                        {{__('User/quizHistory.processes-mistakes')}}
                                                    @elseif($quiz_z->topic_id == 3)
                                                        {{__('User/quizHistory.exam-mistakes')}}
                                                    @endif
                                                @else
                                                    {{Transcode::evaluate(\App\Exam::find($quiz_z->topic_id))['name']}}
                                                @endif
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="row gx-2 align-items-center">
                                            <div class="col-auto d-lg-none">
                                                <div class="sw-3 sh-4 d-flex justify-content-center align-items-center" >
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="cs-icon cs-icon-badge text-primary"><path d="M13 11L13.8819 17.1734C13.9258 17.4809 13.9478 17.6347 13.8803 17.7191C13.8518 17.7547 13.8142 17.7819 13.7713 17.7976C13.6699 17.835 13.531 17.7655 13.2532 17.6266L10.3913 16.1957C10.2271 16.1136 10.1451 16.0725 10.0578 16.0624C10.0194 16.0579 9.98059 16.0579 9.94217 16.0624C9.85494 16.0725 9.77286 16.1136 9.60869 16.1957L6.74684 17.6266C6.46901 17.7655 6.3301 17.835 6.22866 17.7976C6.18584 17.7819 6.14815 17.7547 6.11967 17.7191C6.05219 17.6347 6.07416 17.4809 6.11809 17.1734L7 11"></path><circle cx="10" cy="7" r="5"></circle></svg>
                                                </div>
                                            </div>
                                            <div class="col col-lg-12">
                                                <div class="row g-0">
                                                    <div class="col d-lg-none">
                                                        <div class="text-alternate sh-4 d-flex align-items-center lh-1-25">Overall</div>
                                                    </div>
                                                    <div class="col-auto col-lg-12">
                                                        <div class="sh-4 d-flex align-items-center text-alternate justify-content-center">
                                                            @if($quiz_z->score >= 75)
                                                                <b style="color:darkgreen">{{__('User/quizHistory.success')}}</b>
                                                            @else
                                                                <b style="color:darkred">{{__('User/quizHistory.failed')}}</b>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-1">
                                        <div class="row gx-2 align-items-center">
                                            <div class="col-auto d-lg-none">
                                                <div class="sw-3 sh-4 d-flex justify-content-center align-items-center" style="color: var(--primary);">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-percent" viewBox="0 0 16 16">
                                                        <path d="M13.442 2.558a.625.625 0 0 1 0 .884l-10 10a.625.625 0 1 1-.884-.884l10-10a.625.625 0 0 1 .884 0zM4.5 6a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm0 1a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5zm7 6a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm0 1a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="col col-lg-12">
                                                <div class="row g-0">
                                                    <div class="col d-lg-none">
                                                        <div class="text-alternate sh-4 d-flex align-items-center lh-1-25">Score</div>
                                                    </div>
                                                    <div class="col-auto col-lg-12">
                                                        <div class="sh-4 d-flex align-items-center text-alternate justify-content-lg-end">
                                                            <b>{{$quiz_z->score}}%</b> {{__('User/quizHistory.correct')}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="row gx-2 align-items-center">
                                            <div class="col-auto d-lg-none">
                                                <div class="sw-3 sh-4 d-flex justify-content-center align-items-center" style="color: var(--primary);">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-alarm" viewBox="0 0 16 16">
                                                        <path d="M8.5 5.5a.5.5 0 0 0-1 0v3.362l-1.429 2.38a.5.5 0 1 0 .858.515l1.5-2.5A.5.5 0 0 0 8.5 9V5.5z"/>
                                                        <path d="M6.5 0a.5.5 0 0 0 0 1H7v1.07a7.001 7.001 0 0 0-3.273 12.474l-.602.602a.5.5 0 0 0 .707.708l.746-.746A6.97 6.97 0 0 0 8 16a6.97 6.97 0 0 0 3.422-.892l.746.746a.5.5 0 0 0 .707-.708l-.601-.602A7.001 7.001 0 0 0 9 2.07V1h.5a.5.5 0 0 0 0-1h-3zm1.038 3.018a6.093 6.093 0 0 1 .924 0 6 6 0 1 1-.924 0zM0 3.5c0 .753.333 1.429.86 1.887A8.035 8.035 0 0 1 4.387 1.86 2.5 2.5 0 0 0 0 3.5zM13.5 1c-.753 0-1.429.333-1.887.86a8.035 8.035 0 0 1 3.527 3.527A2.5 2.5 0 0 0 13.5 1z"/>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="col col-lg-12">
                                                <div class="row g-0">
                                                    <div class="col d-lg-none">
                                                        <div class="text-alternate sh-4 d-flex align-items-center lh-1-25">Time</div>
                                                    </div>
                                                    <div class="col-auto col-lg-12">
                                                        <div class="sh-4 d-flex align-items-center text-alternate justify-content-lg-end">
                                                            @php
                                                                $hours = 0;
                                                                $mins = 0;
                                                                $sec = 0;
                                                                if($quiz_z->time_left != 0){
                                                                    $hours = floor($quiz_z->time_left/3600);
                                                                    $mins = floor( ($quiz_z->time_left%3600) / 60);
                                                                    $sec = floor(($quiz_z->time_left%3600) % 60);
                                                                }

                                                            @endphp
                                                            {{$hours}} {{__('User/quizHistory.hour')}} {{$mins}} {{__('User/quizHistory.min')}} {{$sec}} {{__('User/quizHistory.sec')}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="row gx-2 align-items-center">
                                            <div class="col-auto d-lg-none">
                                                <div class="sw-3 sh-4 d-flex justify-content-center align-items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="cs-icon cs-icon-clock text-primary"><path d="M8 12L9.70711 10.2929C9.89464 10.1054 10 9.851 10 9.58579V6"></path><circle cx="10" cy="10" r="8"></circle></svg>
                                                </div>
                                            </div>
                                            <div class="col col-lg-12">
                                                <div class="row g-0">
                                                    <div class="col d-lg-none">
                                                        <div class="text-alternate sh-4 d-flex align-items-center lh-1-25">Time</div>
                                                    </div>
                                                    <div class="col-auto col-lg-12">
                                                        <div class="sh-4 d-flex align-items-center text-alternate justify-content-lg-end">
                                                            {{$quiz_z->updated_at->diffForHumans()}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
{{--        <div class="row">--}}
{{--            <div class="col-12 text-center">--}}
{{--                <button class="btn btn-outline-primary sw-25">Load More</button>--}}
{{--            </div>--}}
{{--        </div>--}}

        <!-- Content End -->
    </div>
@endsection
