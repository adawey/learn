@extends('layouts.layoutV2')


@section('content')


        <div class="row" style="padding-bottom: 50px;">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12  ">
                <div class=" uk-card-hover card">
                    <div class="  card-body">
                        <a href="{{route('my.package.view')}}">
                        <div class="uk-flex-middle" uk-grid>
                            <div class="uk-width-auto">
                                <h5 class="mb-2"> {{__('User/dashboard.active-courses')}} </h5>
                                <h1>{{$active_package_number}}</h1>

                                <span class="badge badge-soft-danger mt-n1"> {{$expired_package_number }} {{__('User/dashboard.expired')}}</span>

                            </div>
                            <div class="uk-width-expand" style="text-align: center;">
                                <i class="icon-material-outline-shopping-cart icon-xlarge"></i>
                                <!-- <img src="../assets/images/demos/d-sales.png" alt=""> -->
                            </div>
                        </div>
                        </a>
                    </div>
                    <div class="card-footer d-flex justify-content-between py-2">
                        <p class="mb-0"> {{$all_package_number}} {{__('User/dashboard.courses-available')}} </p>
                        <a href="{{route('package.by.course')}}" class=" "> <span class="icon-feather-arrow-right"> </span>{{__('User/dashboard.view')}} </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12  ">
                <div class=" uk-card-hover card">
                    <div class="  card-body">
                        <a href="{{route('my.package.view')}}">
                            <div class="uk-flex-middle" uk-grid>
                                <div class="uk-width-auto">
                                    @php
                                        $myEvents = \App\EventUser::where(['user_id'=> Auth::user()->id])->get();
                                        $expired_events_count = 0;
                                        $total_events_count = $myEvents->count();
                                        foreach($myEvents as $userEvent){
                                            $event__ = Cache::remember('event_'.$userEvent->event_id, 1440, function() use($userEvent){
                                                return \App\Event::find($userEvent->event_id);
                                            });
                                            if($event__){
                                                if(\Carbon\Carbon::parse($event__->end)->lte(\Carbon\Carbon::now())){
                                                    $expired_events_count++;
                                                }
                                            }

                                        }
                                    @endphp
                                    <h5 class="mb-2"> {{__('User/dashboard.active-event')}} </h5>
                                    <h1>{{$total_events_count}}</h1>
                                    <span class="badge badge-soft-danger mt-n1"> {{__('User/dashboard.expired')}} {{$expired_events_count}}</span>
                                </div>
                                <div class="uk-width-expand" style="text-align: center;">
                                    <i class="icon-line-awesome-calendar icon-xlarge"></i>
                                    <!-- <img src="../assets/images/demos/d-sales.png" alt=""> -->
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="card-footer d-flex justify-content-between py-2">
                        <p class="mb-0"> {{$total_number_events}} {{__('User/dashboard.event-available')}} </p>
                        <a href="{{route('package.by.course')}}" class=" "> <span class="icon-feather-arrow-right"> </span>{{__('User/dashboard.view')}} </a>
                    </div>
                </div>

            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 ">
                <div class="card uk-card-hover">
                    <div class="card-body">
                        <div class="uk-flex-middle" uk-grid>
                            <div class="uk-width-auto">
                                <h5 class="mb-2"> {{__('User/dashboard.success')}}  </h5>
                                <h1>{{$success_number}}</h1>
                                <span class="badge badge-soft-danger mt-n1"> {{__('User/dashboard.fails')}}  {{$all_quizzes_number- $success_number}}</span>
                            </div>
                            <div class="uk-width-expand" style="text-align: center;">
                                <i class="icon-material-outline-check-circle icon-xlarge "></i>
                                <!-- <img src="../assets/images/demos/d-sales.png" alt=""> -->
                            </div>
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-between py-2">
                        <p class="mb-0"> {{$all_quizzes_number}}  {{__('User/dashboard.exam-analysis')}} </p>
                        <a href="{{ route('QuizHistoryShow') }}" class=""> <span class="icon-feather-arrow-right"> </span>{{__('User/dashboard.view')}}</a>
                    </div>
                </div>

            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 ">
                <div class="card uk-card-hover">
                    <div class="card-body">
                        <div class="uk-flex-middle" uk-grid>
                            <div class="uk-width-auto">
                                <h5 class="mb-2"> {{__('User/dashboard.certifications')}} </h5>
                                <h1>{{$user_certifications_number}}</h1>
                            </div>
                            <div class="uk-width-expand" style="text-align: center;">
                                <i class="icon-line-awesome-certificate icon-xlarge "></i>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-between py-2">
                        <p class="mb-0"> {{$user_certifications_number}} {{__('User/dashboard.certification')}}  </p>
                        <a href="#certifications-modal" uk-toggle> <span class="icon-feather-arrow-right"> </span>{{__('User/dashboard.view')}}</a>
                        <div id="certifications-modal" uk-modal>
                            <div class="uk-modal-dialog uk-modal-body">
                                <h2 class="uk-modal-title">{{__('User/dashboard.certifications')}}</h2>
                                <p>
                                    <table class="table table-bordered table-hover">
                                        <thead>

                                            <tr>
                                                <td>{{__('User/dashboard.package')}}</td>
                                                <td>{{__('User/dashboard.certification')}}</td>
                                            </tr>

                                        </thead>
                                        <tbody>
                                            @foreach($userCertifications as $certificate)
                                            <tr>
                                                <td>{{$certificate->product_name}}</td>
                                                <td>
                                                    <a href="{{route('download.certification', $certificate->id)}}">{{__('User/dashboard.download')}}</a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </p>
                                <p class="uk-text-right"> <button class="uk-button uk-button-default uk-modal-close" type="button">{{__('User/dashboard.close')}}</button> </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="section-small pt-0" >

            <div class="course-grid-slider" uk-slider="finite: true">

                <div class="grid-slider-header">
                    <div>
                        <h4 class="uk-text-truncate"> {{__('User/dashboard.what-learn-next')}}
                            <a href="#" class="text-muted">{{__('User/dashboard.recommended-you')}}</a> </h4>
                    </div>
                    <div class="grid-slider-header-link">
                        <a href="{{route('package.by.course')}}" class="button transparent uk-visible@m" style="margin: 10px 15px 0 0;"> {{__('User/dashboard.view-all')}} </a>
                        <a href="#" class="slide-nav-prev" uk-slider-item="previous"></a>
                        <a href="#" class="slide-nav-next" uk-slider-item="next"></a>
                    </div>
                </div>

                <ul class="uk-slider-items uk-child-width-1-4@m uk-child-width-1-3@s uk-grid">
                    @foreach($packages_arr as $package_data)
                    <li>
                        @php $i = $package_data->package; @endphp
                        @if($package_data->content_type == 'question')
                            <a href="{{route('public.package.view', $i->id)}}">
                                <div class="course-card">
                                    <div class="course-card-thumbnail">
                                        <img src="{{ url('storage/package/imgs/'.basename($i->img))}}">
                                    </div>
                                    <div class="course-card-body">
                                        <div class="course-card-info">
                                            <div>
                                                <span class="catagroy">{{ Transcode::evaluate(\App\Course::find($i->course_id))['title'] }}</span>
                                            </div>
                                            <div>
                                                @if($i->popular == 1)
                                                <span class="badge badge-soft-danger mt-n1">
                                                    {{__('User/dashboard.hot')}}
                                                </span>
                                                @endif
                                            </div>
                                        </div>

                                        <h4>{{Transcode::evaluate(\App\Packages::find($i->id))['name']}} [ {{__('User/dashboard.exam')}} ] </h4>
                                        <p>

                                        </p>

                                        <div class="course-details-info " style="">
                                            <div class="star-rating"  >
                                                <span class="avg"> {{$package_data->total_rating}} </span>
                                                @php $x = round($package_data->total_rating); @endphp
                                                @while($x > 0)
                                                    <span class="star"></span>
                                                    @php $x--; @endphp
                                                @endwhile
                                            </div>
                                        </div>
                                        <div class="course-card-footer">

                                            {{-- package{id}examsCount --}}
                                            {{-- package{id}questionsCount --}}
                                            <h5> <i class="icon-feather-file-text "></i> {{$package_data->exams_num}} {{__('User/dashboard.exams')}} </h5>
                                            <h5> <i class="icon-line-awesome-question"></i> {{$package_data->questions_num}} {{__('User/dashboard.questions')}}  </h5>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            @elseif($package_data->content_type == 'video')
                            <a href="{{route('public.package.view', $i->id)}}">
                                <div class="course-card">
                                    <div class="course-card-thumbnail ">
                                        <img src="{{url('storage/package/imgs/'.basename($i->img))}}">
                                        <span class="play-button-trigger"></span>
                                    </div>
                                    <div class="course-card-body">
                                        <div class="course-card-info">
                                            <div>
                                                <span class="catagroy">{{ Transcode::evaluate(\App\Course::find($i->course_id))['title'] }}</span>
                                            </div>
                                            <div>
                                                @if($i->popular == 1)
                                                    <span class="badge badge-soft-danger mt-n1">
                                                    {{__('User/dashboard.hot')}}
                                                </span>
                                                @endif
                                            </div>
                                        </div>

                                        <h4>{{Transcode::evaluate(\App\Packages::find($i->id))['name']}}</h4>
                                        <p></p>

                                        <div class="course-details-info " style="padding: 5px 0 0 10px;">
                                            <div class="star-rating"  >
                                                <span class="avg"> {{$package_data->total_rating}} </span>
                                                @php $x = round($package_data->total_rating); @endphp
                                                @while($x > 0)
                                                    <span class="star"></span>
                                                    @php $x--; @endphp
                                                @endwhile
                                            </div>
                                        </div>

                                        <div class="course-path-card-footer">
                                            <h5> <i class="icon-feather-film mr-1"></i> {{$package_data->numberVideos}} {{__('User/dashboard.lectures')}} </h5>
                                            <div>
                                                <h5>
                                                    <i class="icon-feather-clock mr-1"></i>
                                                    {{$package_data->package_hours}} {{__('User/dashboard.hours')}} </h5>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </a>
                        @endif
                    </li>
                    @endforeach
                </ul>

            </div>

        </div>

        <div class="section-small pt-0" >

            <div class="course-grid-slider" uk-slider="finite: true">

                <div class="grid-slider-header">
                    <div>
                        <h4 class="uk-text-truncate">{{__('User/dashboard.online-sessions')}}</h4>
                    </div>
                </div>

                <ul class="uk-slider-items uk-child-width-1-4@m uk-child-width-1-3@s uk-grid">
                    
                    @foreach(\App\Event::where('active', '=', 1)->where('end' , '>', now())->get(['id']) as $event__)
                        <li>
                        @php
                            $event = Cache::remember('event_'.$event__->id, 1440, function() use($event__){
                                return \App\Event::find($event__->id);
                            });
                        @endphp

                            <a href="{{route('public.event.view', $event->id)}}">
                                <div class="course-card">
                                    <div class="course-card-thumbnail ">
                                        <img src="{{url('storage/events/'.basename($event->img))}}">
                                        <span class="play-button-trigger"></span>
                                    </div>
                                    <div class="course-card-body">
                                        <div class="course-card-info">
                                            <div>
                                                <span class="catagroy">{{Transcode::evaluate(\App\Course::find($event->course_id))['title']}}</span>
                                            </div>
                                            <div>

                                                @if(\Carbon\Carbon::parse(  $event->end   )->gte(\Carbon\Carbon::now()) )
                                                    <span class="badge badge-soft-success mt-n1">
                                                        {{__('User/dashboard.end-at')}} {{$event->end}}
                                                    </span>
                                                @else
                                                    <span class="badge badge-soft-danger mt-n1">
                                                        {{__('User/dashboard.end-at')}} {{$event->end}}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <h4>{{Transcode::evaluate($event)['name']}}</h4>
                                        <p></p>
                                        @php
                                            $numberVideos = Cache::remember('event'.$i->id.'videosCount', 1440, function()use($event){
                                                $videos_arr = [];
                                                foreach(\App\Chapters::where('course_id', $event->course_id)->get() as $chapter){
                                                    $chapter_id = $chapter->id;
                                                    $videos = \App\Video::where(['chapter'=> $chapter_id, 'event_id' => $event->id])->get();
                                                    foreach($videos as $v){
                                                        if(!in_array($v->id, $videos_arr)){
                                                            array_push($videos_arr, $v->id);
                                                        }
                                                    }

                                                }
                                                return count($videos_arr);
                                            });
                                        @endphp
                                        @php
                                            $total_rating = 0;
                                            $rate = \App\Rating::where('event_id', $event->id)->get();
                                            foreach($rate as $r){
                                              $total_rating += $r->rate;
                                            }
                                            if($rate->first()){
                                                $total_rating = round($total_rating / count($rate), 1);
                                            }else{
                                                $total_rating = 0;
                                            }

                                        @endphp
                                        <div class="course-details-info " style="padding: 5px 0 0 10px;">
                                            <div class="star-rating"  >
                                                <span class="avg"> {{$total_rating}} </span>
                                                @php $x = round($total_rating); @endphp
                                                @while($x > 0)
                                                    <span class="star"></span>
                                                    @php $x--; @endphp
                                                @endwhile
                                            </div>
                                        </div>
                                        @php
                                            $package_hours = Cache::remember('event'.$i->id.'hoursCount', 1440, function()use($event){
                                                $total_hours = 0;
                                                $total_min = 0;
                                                $total_sec = 0;



                                                foreach(\App\Chapters::where('course_id', $event->course_id)->get() as $chapter){
                                                    $chapter_id = $chapter->id;
                                                    $videos = \App\Video::where(['chapter'=> $chapter_id, 'event_id'=> $event->id])->get();
                                                    foreach($videos as $v){
                                                        if($v->duration != '' && $v->duration != null){

                                                            $total_min += \Carbon\Carbon::parse($v->duration)->format('i');
                                                            $total_sec += \Carbon\Carbon::parse($v->duration)->format('s');
                                                            if(\Carbon\Carbon::parse($v->duration)->format('h') != 12){
                                                                $total_hours += \Carbon\Carbon::parse($v->duration)->format('h');
                                                            }
                                                        }
                                                    }
                                                }

                                                $total_time = [$total_hours, $total_min, $total_sec]; //[hr, min, sec]
                                                $total_time[1] += $total_time[2]/60;
                                                $total_time[2] = round($total_time[2]%60);

                                                $total_time[0] += $total_time[1]/60;
                                                $total_time[1] = round($total_time[1]%60);
                                                $total_time[0] = round($total_time[0]);
                                                return $total_time[0];
                                            });
                                        @endphp
                                        <div class="course-path-card-footer">
                                            <h5> <i class="icon-feather-film mr-1"></i> {{$numberVideos}} {{__('User/dashboard.lectures')}} </h5>
                                            <div>
                                                <h5>
                                                    <i class="icon-feather-clock mr-1"></i>
                                                    {{$package_hours}} {{__('User/dashboard.hours')}} </h5>

                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>

            </div>
        </div>

        <div class="uk-grid-large" uk-grid>
{{--            <div class="uk-width-expand">--}}

{{--                <!-- Blog Post -->--}}
{{--                <a href="blog-single-1.html" class="blog-post">--}}
{{--                    <!-- Blog Post Thumbnail -->--}}
{{--                    <div class="blog-post-thumbnail">--}}
{{--                        <div class="blog-post-thumbnail-inner">--}}
{{--                            <span class="blog-item-tag">Details</span>--}}
{{--                            <img src="../assets/images/blog/img-1.jpg" alt="">--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <!-- Blog Post Content -->--}}
{{--                    <div class="blog-post-content">--}}
{{--                        <span class="blog-post-date">22 July 2020</span>--}}
{{--                        <h3>10 amazing web demos and experiments For Developers</h3>--}}
{{--                        <p>Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id--}}
{{--                            quod mazim placerat facer possim tempor cum soluta nobis</p>--}}
{{--                    </div>--}}
{{--                </a>--}}

{{--                <!-- Blog Post -->--}}
{{--                <a href="blog-single-1.html" class="blog-post">--}}
{{--                    <!-- Blog Post Thumbnail -->--}}
{{--                    <div class="blog-post-thumbnail">--}}
{{--                        <div class="blog-post-thumbnail-inner">--}}
{{--                            <span class="blog-item-tag">Details</span>--}}
{{--                            <img src="../assets/images/blog/img-2.jpg" alt="">--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <!-- Blog Post Content -->--}}
{{--                    <div class="blog-post-content">--}}
{{--                        <span class="blog-post-date">12 MAy 2020</span>--}}
{{--                        <h3>10 Awesome Web Dev Tools and Resources For 2020</h3>--}}
{{--                        <p>Nam liber tempor cum soluta nobis nihil imperdiet doming id tempor cum soluta nobis--}}
{{--                            quod mazim placerat facer possim soluta nobis eleifend assum</p>--}}
{{--                    </div>--}}
{{--                </a>--}}

{{--            </div>--}}
            <div class="uk-width-1-3@s" >

                <div class="uk-card-default rounded " >

                    <ul class="uk-child-width-expand uk-tab"
                        uk-switcher="animation: uk-animation-fade">
                        <li><a href="#">{{__('User/dashboard.study-material')}}</a></li>

                    </ul>

                    <ul class="uk-switcher">
                        <!-- tab 1 -->
                        <li>
                            <div class="py-3 px-4">
                                @foreach($userCourses as $c)
                                <a href="{{ route('material.show', $c->id) }}">
                                    <div class="uk-grid-small" uk-grid style="margin-bottom: 10px">
                                        <div class="uk-width-expand">
                                            <p> {{Transcode::evaluate(\App\Course::find($c->id))['title']}} </p>
                                        </div>
                                        <div class="uk-width-1-3">
                                            <img src="../assets/images/blog/img-3.jpg" alt="" class="rounded-sm">
                                        </div>

                                    </div>
                                </a>
                                @endforeach
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>









@endsection
