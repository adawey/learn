@extends('layouts.layoutV2')

@section('content')

    <div class="container">
        <h2>Account</h2>

        <nav class="responsive-tab mb-4">
            <li class="uk-active"><a href="#">Account</a></li>
        </nav>

        <div uk-grid>
            <div class="uk-width-2-5@m">

                <div class="uk-card-default rounded text-center p-4">

                    @php
                        $profile_pic = '';
                        if(Auth::check()){
                            if(\App\UserDetail::where('user_id', '=', Auth::user()->id)->get()->first() ){
                                if(\App\UserDetail::where('user_id', '=', Auth::user()->id)->get()->first()->profile_pic){
                                    $profile_pic =url('storage/profile_picture/'.basename(\App\UserDetail::where('user_id','=',Auth::user()->id)->get()->first()->profile_pic));
                                }
                            }
                        }
                    @endphp

                    <div class="user-profile-photo  m-auto">
                        <img src="{{$profile_pic}}" alt="">
                    </div>
                    <h4 class="mb-2 mt-3">{{Auth::user()->name}} </h4>
                    <p class="m-0"> Member since {{Auth::user()->created_at->diffForHumans()}} </p>

                </div>

                <div class="uk-card-default rounded mt-5">
                    <div class="uk-flex uk-flex-between uk-flex-middle py-3 px-4">
                        <h5 class="mb-0"> Progress </h5>

                    </div>
                    <hr class="m-0">
                    <div class="p-3">
                        @php
                            $success_count = \App\UserScore::where('user_id', '=', Auth::user()->id)->where('score','>=', '50')->count();
                            $fail_count = \App\UserScore::where('user_id', '=', Auth::user()->id)->where('score','<', '50')->count();
                            $total_quizzes = $success_count + $fail_count;
                            if($total_quizzes){
                                $success_count = $success_count / $total_quizzes * 100;
                                $fail_count = $fail_count / $total_quizzes * 100;
                            }
                        @endphp
                        <div class="uk-grid-small uk-flex-middle" uk-grid>


                            <div class="uk-width-auto">
                                <button type="button" class="btn btn-success btn-icon-only">
                                            <span class="d-flex justify-content-center">
                                       <i class="icon-material-outline-check icon-small"></i>
                                            </span>
                                </button>
                            </div>
                            <div class="uk-width-expand">
                                <h5 class="mb-2"> Success </h5>
                                <div class="course-progressbar">
                                    <div class="course-progressbar-filler" style="width:{{round($success_count)}}%"></div>
                                </div>
                            </div>

                        </div>

                        <div class="uk-grid-small uk-flex-middle" uk-grid>

                            <div class="uk-width-auto">
                                <button type="button" class="btn btn-danger btn-icon-only">
                                            <span class="d-flex justify-content-center">
                                                <i class="icon-line-awesome-close icon-small"></i>
                                            </span>
                                </button>
                            </div>
                            <div class="uk-width-expand">
                                <h5 class="mb-2"> Failure </h5>
                                <div class="course-progressbar">
                                    <div class="course-progressbar-filler" style="width:{{round($fail_count)}}%"></div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

            </div>
            <div class="uk-width-expand@m">

                <div class="uk-card-default rounded">
                    <div class="uk-flex uk-flex-between uk-flex-middle py-3 px-4">
                        <h5 class="mb-0"> Account details </h5>
                            <a href="{{route('show.profile')}}?edit=true" uk-tooltip="title:Edit Account; pos: left"> <i
                                        class="icon-feather-settings"></i> </a>
                    </div>
                    <hr class="m-0">
                    <div class="uk-child-width-1-2@s uk-grid-small p-4" uk-grid>
                        <div>
                            <h6 class="uk-text-bold"> Full Name  </h6>
                                <p> {{Auth::user()->name}} </p>
                        </div>

                        <div>
                            <h6 class="uk-text-bold"> Your email address </h6>
                                <p> {{Auth::user()->email}} </p>
                        </div>
                        <div>
                            <h6 class="uk-text-bold"> Phone </h6>
                                <p> {{Auth::user()->phone}}</p>
                        </div>
                        <div>
                            <h6 class="uk-text-bold"> City/Town  </h6>
                                <p> {{Auth::user()->city}} </p>
                        </div>
                        <div>
                            <h6 class="uk-text-bold"> Country </h6>
                                <p> {{Auth::user()->country}} </p>
                        </div>
                        <div>
                            <h6 class="uk-text-bold"> Occupation </h6>
                                <p> {{ ($user_details)? $user_details->occupation: '' }} </p>
                        </div>
                        <div style="width: 100%;">
                            <h6 class="uk-text-bold"> Interests </h6>
                                <p> {{ ($user_details)? $user_details->interests: '' }} </p>
                        </div>
                        <hr style="width: 100%;">
                        <div style="width: 100%; ">
                            <h6 class="uk-text-bold"> About  </h6>
                                <p> {{ ($user_details)? $user_details->about: '' }}</p>
                        </div>
                        <br>
                        <hr style="width: 100%;">
                        <br>
                        <div>
                            <h6 class="uk-text-bold">Website Url </h6>
                                <p>{{ ($user_details)? $user_details->website_url : '' }}</p>
                        </div>
                        <div>
                            <h6 class="uk-text-bold">Facebook Url </h6>
                                <p>{{ ($user_details)? $user_details->fb_url : '' }} </p>
                        </div>
                        <div>
                            <h6 class="uk-text-bold">Twitter Url  </h6>
                                <p> {{ ($user_details)? $user_details->tw_url : '' }} </p>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>

@endsection
