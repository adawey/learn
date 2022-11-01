@extends('layouts.layoutV2')

@php
    // one day to refresh


@endphp

@section('content')

    <h1> {{__('User/myPackages.my-courses')}}</h1>
    <!-- ------------------------ -->
    <!-- ------------------------ -->
    <!-- ------------------------ -->
    <!-- ------------------------ -->
    <!-- ------------------------ -->
    <h4>{{__('User/myPackages.exams')}}</h4>
    <div>
        <ul uk-tab>
            <li><a href="#">{{__('User/myPackages.all')}}</a></li>
            @foreach($exam_package_list_by_course as $package_arr)
                <li><a href="">{{Transcode::evaluate(\App\Course::find($package_arr[0]->package->course_id))['title']}}</a></li>
            @endforeach
        </ul>

        <ul class="uk-switcher uk-margin">
            <li>
                <div class="uk-child-width-1-4@m uk-child-width-1-3@s course-card-grid" uk-grid>
                    @foreach($exam_package_list_by_course as $course_id => $package_arr)
                        @foreach($package_arr as $i)
                            <div>
                                <a href="{{route('attach.package', $i->package->package_id)}}">
                                    <div class="course-card">
                                        <div class="course-card-thumbnail">
                                            <img src="{{ url('storage/package/imgs/'.basename($i->package->img))}}">
                                        </div>
                                        <div class="course-card-body">
                                            <div class="course-card-info">
                                                <div>
                                                    <span class="catagroy">{{Transcode::evaluate(\App\Course::find($i->package->course_id))['title']}}</span>
                                                </div>
                                                <div>
                                                <span class="badge badge-soft-success mt-n1">
                                                    {{__('User/myPackages.expire-at')}} {{$i->meta_data['expire_date']}}
                                                </span>
                                                </div>
                                            </div>

                                            <h4>
                                                {{Transcode::evaluate(\App\Packages::find($i->package->package_id))['name']}} [ {{__('User/myPackages.exam')}} ]
                                            </h4>
                                            <p>

                                            </p>
                                            <div class="course-details-info " style="">
                                                <div class="star-rating"  >
                                                    <span class="avg"> {{round($i->package->rating)}} </span>
                                                    @php $x = round($i->package->rating); @endphp
                                                    @while($x > 0)
                                                        <span class="star"></span>
                                                        @php $x--; @endphp
                                                    @endwhile
                                                </div>
                                            </div>
                                            <div class="course-card-footer">
                                                {{-- package{id}examsCount --}}
                                                {{-- package{id}questionsCount --}}
                                                <h5> <i class="icon-feather-file-text "></i> {{$i->meta_data['packageExamsNumber']}} {{__('User/myPackages.exams')}} </h5>
                                                <h5> <i class="icon-line-awesome-question"></i> {{$i->meta_data['packageQuestionsNumber']}} {{__('User/myPackages.questions')}}  </h5>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                        @endforeach
                    @endforeach
                </div>
            </li>
            @foreach($exam_package_list_by_course as $course_id => $package_arr)
            <li>
                <div class="uk-child-width-1-4@m uk-child-width-1-3@s course-card-grid" uk-grid>
                    @foreach($package_arr as $i)
                        <div>
                            <a href="{{route('attach.package', $i->package->package_id)}}">
                                <div class="course-card">
                                    <div class="course-card-thumbnail">
                                        <img src="{{ url('storage/package/imgs/'.basename($i->package->img))}}">
                                    </div>
                                    <div class="course-card-body">
                                        <div class="course-card-info">
                                            <div>
                                                <span class="catagroy">{{Transcode::evaluate(\App\Course::find($i->package->course_id))['title']}}</span>
                                            </div>
                                            <div>
                                                <span class="badge badge-soft-success mt-n1">
                                                    {{__('User/myPackages.expire-at')}} {{$i->meta_data['expire_date']}}
                                                </span>
                                            </div>
                                        </div>

                                        <h4>{{Transcode::evaluate(\App\Packages::find($i->package->package_id))['name']}} [ {{__('User/myPackages.exam')}} ] </h4>
                                        <p>

                                        </p>
                                        <div class="course-details-info " style="">
                                            <div class="star-rating"  >
                                                <span class="avg"> {{round($i->package->rating)}} </span>
                                                @php $x = round($i->package->rating); @endphp
                                                @while($x > 0)
                                                    <span class="star"></span>
                                                    @php $x--; @endphp
                                                @endwhile
                                            </div>
                                        </div>
                                        <div class="course-card-footer">
                                            {{-- package{id}examsCount --}}
                                            {{-- package{id}questionsCount --}}
                                            <h5> <i class="icon-feather-file-text "></i> {{$i->meta_data['packageExamsNumber']}} {{__('User/myPackages.exams')}} </h5>
                                            <h5> <i class="icon-line-awesome-question"></i> {{$i->meta_data['packageQuestionsNumber']}} {{__('User/myPackages.questions')}}  </h5>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                    @endforeach
                </div>
            </li>
            @endforeach
        </ul>
    </div>
    <hr>

    <!-- ------------------------ -->
    <!-- ------------------------ -->
    <!-- ------------------------ -->
    <!-- ------------------------ -->
    <!-- ------------------------ -->
    <h4 style="margin-top: 30px;">{{__('User/myPackages.videos')}}</h4>
    <div>
        <ul uk-tab>
            <li><a href="#">{{__('User/myPackages.all')}}</a></li>
            @foreach($video_package_list_by_course as $package_arr)
                <li><a href="">{{Transcode::evaluate(\App\Course::find($package_arr[0]->package->course_id))['title']}}</a></li>
            @endforeach
        </ul>

        <ul class="uk-switcher uk-margin">
            <li>
                <div class="uk-child-width-1-4@m uk-child-width-1-3@s course-card-grid" uk-grid>
                    @foreach($video_package_list_by_course as $course_id => $package_arr)
                        @foreach($package_arr as $i)
                            <div>
                                <a href="{{route('st4_vid', [$i->package->package_id, 'chapter', 0, 0])}}">
                                    <div class="course-card">
                                        <div class="course-card-thumbnail ">
                                            <img src="{{url('storage/package/imgs/'.basename($i->package->img))}}">
                                            <span class="play-button-trigger"></span>
                                        </div>
                                        <div class="course-card-body">
                                            <div class="course-card-info">
                                                <div>
                                                    <span class="catagroy">{{Transcode::evaluate(\App\Course::find($i->package->course_id))['title']}}</span>
                                                </div>
                                                <div>
                                                        <span class="badge badge-soft-success mt-n1">
                                                            {{__('User/myPackages.expire-at')}} {{$i->meta_data['expire_date']}}
                                                        </span>
                                                </div>
                                            </div>

                                            <h4>{{Transcode::evaluate(\App\Packages::find($i->package->package_id))['name']}}</h4>
                                            <p></p>
                                            <div class="course-progressbar mt-3">
                                                <div class="course-progressbar-filler" style="width:{{$i->meta_data['progress']}}%"></div>
                                            </div>

                                            <div class="course-details-info " style="padding: 5px 0 0 10px;">
                                                <div class="star-rating"  >
                                                    <span class="avg"> {{round($i->package->rating)}} </span>
                                                    @php $x = round($i->package->rating); @endphp
                                                    @while($x > 0)
                                                        <span class="star"></span>
                                                        @php $x--; @endphp
                                                    @endwhile
                                                </div>
                                            </div>
                                            <div class="course-path-card-footer">
                                                <h5> <i class="icon-feather-film mr-1"></i> {{$i->meta_data['no_of_lectures']}} {{__('User/myPackages.lectures')}} </h5>
                                                <div>
                                                    <h5>
                                                        <i class="icon-feather-clock mr-1"></i>
                                                        {{$i->meta_data['packageTime'][0]}} {{__('User/myPackages.hours')}} </h5>

                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </li>
            @foreach($video_package_list_by_course as $course_id => $package_arr)
                <li>
                    <div class="uk-child-width-1-4@m uk-child-width-1-3@s course-card-grid" uk-grid>
                        @foreach($package_arr as $i)
                            <div>
                                <a href="{{route('st4_vid', [$i->package->package_id, 'chapter', 0, 0])}}">
                                    <div class="course-card">
                                        <div class="course-card-thumbnail ">
                                            <img src="{{url('storage/package/imgs/'.basename($i->package->img))}}">
                                            <span class="play-button-trigger"></span>
                                        </div>
                                        <div class="course-card-body">
                                            <div class="course-card-info">
                                                <div>
                                                    <span class="catagroy">{{Transcode::evaluate(\App\Course::find($i->package->course_id))['title']}}</span>
                                                </div>
                                                <div>
                                                        <span class="badge badge-soft-success mt-n1">
                                                            {{__('User/myPackages.expire-at')}} {{$i->meta_data['expire_date']}}
                                                        </span>
                                                </div>
                                            </div>

                                            <h4>{{Transcode::evaluate(\App\Packages::find($i->package->package_id))['name']}}</h4>
                                            <p></p>
                                            <div class="course-progressbar mt-3">
                                                <div class="course-progressbar-filler" style="width:{{$i->meta_data['progress']}}%"></div>
                                            </div>

                                            <div class="course-details-info " style="padding: 5px 0 0 10px;">
                                                <div class="star-rating"  >
                                                    <span class="avg"> {{round($i->package->rating)}} </span>
                                                    @php $x = round($i->package->rating); @endphp
                                                    @while($x > 0)
                                                        <span class="star"></span>
                                                        @php $x--; @endphp
                                                    @endwhile
                                                </div>
                                            </div>
                                            <div class="course-path-card-footer">
                                                <h5> <i class="icon-feather-film mr-1"></i> {{$i->meta_data['no_of_lectures']}} {{__('User/myPackages.lectures')}} </h5>
                                                <div>
                                                    <h5>
                                                        <i class="icon-feather-clock mr-1"></i>
                                                        {{$i->meta_data['packageTime'][0]}} {{__('User/myPackages.hours')}} </h5>

                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
    <hr>
    <!-- ------------------------ -->
    <!-- ------------------------ -->
    <!-- ------------------------ -->
    <!-- ------------------------ -->
    <!-- ------------------------ -->
    <h4 style="margin-top: 30px;">{{__('User/myPackages.online-sessions')}}</h4>
    <div>
        <ul uk-tab>
            <li><a href="#">{{__('User/myPackages.all')}}</a></li>
        </ul>
        <ul class="uk-switcher uk-margin">
            <li>
                <div class="uk-child-width-1-4@m uk-child-width-1-3@s course-card-grid" uk-grid>
                    @if(count($userEvents))
                    @foreach($userEvents as $userEvent)

                        <div>
                            <a uk-toggle="target: #event_{{$userEvent->event_id}}">
                                <div class="course-card">
                                    <div class="course-card-thumbnail ">
                                        <img src="{{url('storage/events/'.basename($userEvent->img))}}">
                                        <span class="play-button-trigger"></span>
                                    </div>
                                    <div class="course-card-body">
                                        <div class="course-card-info">
                                            <div>
                                                <span class="catagroy">{{Transcode::evaluate(\App\Course::find($userEvent->course_id))['title']}}</span>
                                            </div>
                                            <div>

                                                @if(\Carbon\Carbon::parse(  $userEvent->end   )->gte(\Carbon\Carbon::now()) )
                                                    <span class="badge badge-soft-success mt-n1">
                                                            {{__('User/myPackages.end-at')}} {{$userEvent->end}}
                                                        </span>
                                                @else
                                                    <span class="badge badge-soft-danger mt-n1">
                                                            {{__('User/myPackages.end-at')}} {{$userEvent->end}}
                                                        </span>
                                                @endif
                                            </div>
                                        </div>

                                        <h4>{{Transcode::evaluate(\App\Event::find($userEvent->event_id))['name']}}</h4>
                                        <p></p>
                                        <div class="course-details-info " style="padding: 5px 0 0 10px;">
                                            <div class="star-rating"  >
                                                <span class="avg"> {{round($userEvent->rating) }} </span>
                                                @php $x = round($userEvent->rating); @endphp
                                                @while($x > 0)
                                                    <span class="star"></span>
                                                    @php $x--; @endphp
                                                @endwhile
                                            </div>
                                            @if($userEvent->whatsapp && \App\EventUser::where(['event_id'=> $userEvent->id, 'user_id'=> Auth::user()->id])->first()->show_whatsapp_link == 1)
                                            <a class="uk-button uk-button-primary uk-button-small float-right uk-text-small text-white" href="{{route('open.whatsapp', $userEvent->id)}}" type="button">WhatsApp Group</a>
                                            @endif
                                        </div>
                                        <div class="course-path-card-footer">
                                            <h5> <i class="icon-feather-film mr-1"></i> {{$userEvent->total_lecture}} {{__('User/myPackages.lectures')}} </h5>
                                            <div>
                                                <h5>
                                                    <i class="icon-feather-clock mr-1"></i>
                                                    {{$userEvent->total_time}} {{__('User/myPackages.hours')}} </h5>

                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </a>
                        </div>
                        <div id="event_{{$userEvent->event_id}}" uk-modal>
                            <div class="uk-modal-dialog uk-modal-body">
                                <h2 class="uk-modal-title">{{$userEvent->name}}</h2>
                                <p>{!! $userEvent->description !!}</p>
                                <hr>
                                <p>
                                <h6>{{__('User/myPackages.time-table')}}</h6>
                                <table class="table table-hover">
                                    <thead>
                                    <td>{{__('User/myPackages.date')}}</td>
                                    <td>{{__('User/myPackages.from')}}</td>
                                    <td>{{__('User/myPackages.to')}}</td>
                                    </thead>
                                    <tbody>
                                    @foreach(\App\EventTime::where('event_id', $userEvent->id)->orderBy('day')->get() as $t)
                                        <tr>
                                            <td>{{$t->day}}</td>
                                            <td>{{$t->from}}</td>
                                            <td>{{$t->to}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                </p>
                                <p class="uk-text-right">
                                    <button class="uk-button uk-button-default uk-modal-close" type="button">{{__('User/myPackages.close')}}</button>
                                    @if($userEvent->whatsapp && \App\EventUser::where(['event_id'=> $userEvent->id, 'user_id'=> Auth::user()->id])->first()->show_whatsapp_link == 1)
                                    <a class="uk-button uk-button-default" href="{{route('open.whatsapp', $userEvent->id)}}" type="button">Join WhatsApp Group</a>
                                    @endif
                                    @if($userEvent->zoom)
                                    <a class="uk-button uk-button-default" href="{{$userEvent->zoom}}" target="_blank" type="button">Zoom</a>
                                    @endif
                                    <a class="uk-button uk-button-primary" type="button" href="{{route('event_vid', [$userEvent->id, 'chapter', 0, 0])}}">{{__('User/myPackages.view-event')}}</a>
                                </p>
                            </div>
                        </div>

                    @endforeach
                    @else
                        <div>{{__('User/myPackages.not-available')}}</div>
                    @endif
                </div>
            </li>

        </ul>
    </div>

    <hr>
    <!-- ------------------------ -->
    <!-- ------------------------ -->
    <!-- ------------------------ -->
    <!-- ------------------------ -->
    <!-- ------------------------ -->
    <h4 style="margin-top: 30px;">{{__('User/myPackages.expired-courses')}}</h4>
    <div>
        <ul uk-tab>
            <li><a href="#">{{__('User/myPackages.exams')}}</a></li>
            <li><a href="#">{{__('User/myPackages.videos')}}</a></li>
        </ul>

        <ul class="uk-switcher uk-margin">
            <li>
                <div class="uk-child-width-1-4@m uk-child-width-1-3@s course-card-grid" uk-grid>
                    @if(count($expired_exam_package_list))
                    @foreach($expired_exam_package_list as $i)
                    
                        @php
                            $extendHistory = \App\ExtensionHistory::where('user_id', '=', Auth::user()->id)->where('package_id', '=', $i->package->package_id)->get()->first();
                            $action = '';
                            $action_text = '';
                            if($i->package->max_extension_in_days != 0){
                                if($extendHistory){
                                    if($extendHistory->extend_num >= $i->package->max_extension_in_days){
                                        $action = route('reset.package', $i->package->package_id);
                                        $action_text = __('User/myPackages.reset');
                                    }else{
                                        $action = route('extend', $i->package->package_id);
                                        $action_text = __('User/myPackages.extend');
                                    }
                                }else{
                                    $action = route('extend', $i->package->package_id);
                                    $action_text = __('User/myPackages.extend');
                                }
                            }else{
                                $action = route('reset.package', $i->package->package_id);
                                $action_text = __('User/myPackages.reset');
                            }
                        @endphp
                        <div>
                            <!--<a href="{{route('reset.package', $i->package->package_id)}}">-->
                            <a href="{{$action}}">
                                <div class="course-card">
                                    <div class="course-card-thumbnail">
                                        <img src="{{ url('storage/package/imgs/'.basename($i->package->img))}}">
                                    </div>
                                    <div class="course-card-body">
                                        <div class="course-card-info">
                                            <div>
                                                <span class="catagroy">{{Transcode::evaluate(\App\Course::find($i->package->course_id))['title']}}</span>
                                            </div>
                                            <div>
                                                <span class="badge badge-soft-danger mt-n1">
                                                    {{$action_text}}
                                                </span>
                                            </div>
                                        </div>

                                        <h4>{{Transcode::evaluate(\App\Packages::find($i->package->package_id))['name']}}</h4>
                                        <p>

                                        </p>
                                        <div class="course-details-info " style="">
                                            <div class="star-rating"  >
                                                <span class="avg"> {{round($i->package->rating)}} </span>
                                                @php $x = round($i->package->rating); @endphp
                                                @while($x > 0)
                                                    <span class="star"></span>
                                                    @php $x--; @endphp
                                                @endwhile
                                            </div>
                                        </div>
                                        <div class="course-card-footer">
                                            {{-- package{id}examsCount --}}
                                            {{-- package{id}questionsCount --}}
                                            <h5> <i class="icon-feather-file-text "></i> {{$i->meta_data['packageExamsNumber']}} {{__('User/myPackages.exams')}} </h5>
                                            <h5> <i class="icon-line-awesome-question"></i> {{$i->meta_data['packageQuestionsNumber']}} {{__('User/myPackages.questions')}}  </h5>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                    @endforeach
                    @else
                    <div>{{__('User/myPackages.packages-are-active')}}</div>
                    @endif
                </div>
            </li>
            <li>
                <div class="uk-child-width-1-4@m uk-child-width-1-3@s course-card-grid" uk-grid>
                    @if(count($expired_video_package_list))
                    @foreach($expired_video_package_list as $i)
                        @php
                            $extendHistory = \App\ExtensionHistory::where('user_id', '=', Auth::user()->id)->where('package_id', '=', $i->package->package_id)->get()->first();
                            $action = '';
                            $action_text = '';
                            if($i->package->max_extension_in_days != 0){
                                if($extendHistory){
                                    if($extendHistory->extend_num >= $i->package->max_extension_in_days){
                                        $action = route('reset.package', $i->package->package_id);
                                        $action_text = __('User/myPackages.reset');
                                    }else{
                                        $action = route('extend', $i->package->package_id);
                                        $action_text = __('User/myPackages.extend');
                                    }
                                }else{
                                    $action = route('extend', $i->package->package_id);
                                    $action_text = __('User/myPackages.extend');
                                }
                            }else{
                                $action = route('reset.package', $i->package->package_id);
                                $action_text = __('User/myPackages.reset');
                            }
                        @endphp
                        <div>
                            <!--<a href="{{route('reset.package', $i->package->package_id)}}">-->
                            <a href="{{$action}}">
                                <div class="course-card">
                                    <div class="course-card-thumbnail ">
                                        <img src="{{url('storage/package/imgs/'.basename($i->package->img))}}">
                                        <span class="play-button-trigger"></span>
                                    </div>
                                    <div class="course-card-body">
                                        <div class="course-card-info">
                                            <div>
                                                <span class="catagroy">{{Transcode::evaluate(\App\Course::find($i->package->course_id))['title']}}</span>
                                            </div>
                                            <div>
                                                <span class="badge badge-soft-danger mt-n1">
                                                    {{$action_text}}
                                                </span>
                                            </div>
                                        </div>

                                        <h4>{{Transcode::evaluate(\App\Packages::find($i->package->package_id))['name']}}</h4>
                                        <p></p>
                                        <div class="course-details-info " style="padding: 5px 0 0 10px;">
                                            <div class="star-rating"  >
                                                <span class="avg"> {{round($i->package->rating)}} </span>
                                                @php $x = round($i->package->rating); @endphp
                                                @while($x > 0)
                                                    <span class="star"></span>
                                                    @php $x--; @endphp
                                                @endwhile
                                            </div>
                                        </div>
                                        <div class="course-path-card-footer">
                                            <h5> <i class="icon-feather-film mr-1"></i> {{$i->meta_data['no_of_lectures']}} {{__('User/myPackages.lectures')}} </h5>
                                            <div>
                                                <h5>
                                                    <i class="icon-feather-clock mr-1"></i>
                                                    {{$i->meta_data['packageTime'][0]}} {{__('User/myPackages.hours')}} </h5>

                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </a>
                        </div>
                    @endforeach
                    @else
                    <div>{{__('User/myPackages.packages-are-active')}}</div>
                    @endif
                </div>
            </li>

        </ul>
    </div>


@endsection
