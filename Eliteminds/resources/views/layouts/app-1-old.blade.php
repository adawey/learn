<!DOCTYPE html>

<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        
        <title>{{env('APP_NAME')}} | Dashboard</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/global/plugins/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/global/plugins/simple-line-icons/simple-line-icons.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/global/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        {{-- <link href="{{asset('assets/global/plugins/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}" rel="stylesheet" type="text/css" /> --}}
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="{{asset('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/global/plugins/morris/morris.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/global/plugins/fullcalendar/fullcalendar.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/global/plugins/jqvmap/jqvmap/jqvmap.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="{{asset('assets/global/css/components.min.css')}}" rel="stylesheet" id="style_components" type="text/css" />
        <link href="{{asset('assets/global/css/plugins.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="{{asset('assets/layouts/layout/css/layout.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/layouts/layout/css/themes/light.min.css')}}" rel="stylesheet" type="text/css" id="style_color" />
        <link href="{{asset('assets/layouts/layout/css/custom.min.css')}}" rel="stylesheet" type="text/css" />
        @yield('header')
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="favicon.ico" />
        
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-N9L8423');</script>
    </head>
    <!-- END HEAD -->

    <body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo" >
        <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-N9L8423"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
        <!-- BEGIN HEADER -->
        <div class="page-header navbar navbar-fixed-top" >
            <!-- BEGIN HEADER INNER -->
            <div class="page-header-inner ">
                <!-- BEGIN LOGO -->
                <div class="page-logo">
                    <a href="index.html">
                        <img src="{{asset('assets/layouts/layout/img/logo-light.png')}}" alt="logo" class="logo-default" /> </a>
                    <div class="menu-toggler sidebar-toggler">
                        <span></span>
                    </div>
                </div>
                <!-- END LOGO -->
                <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
                    <span></span>
                </a>
                <!-- END RESPONSIVE MENU TOGGLER -->
                <!-- BEGIN TOP NAVIGATION MENU -->
                <div class="top-menu" style="border:1xp dashed red !important; float:right !important;" >
                    <ul class="nav navbar-nav pull-right">
                        <!-- BEGIN NOTIFICATION DROPDOWN -->
                        <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                        <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                <i class="icon-bell"></i>
                                @if(count(\App\Notification::where('sight','=','0')->get()))
                                <span class="badge badge-default pendingg_notification_count"> {{count(\App\Notification::where('sight','=','0')->get())}} </span>
                                @endif

                            </a>
                            <ul class="dropdown-menu" >
                                <li class="external">
                                    
                                    <h3 class="pending_notification">
                                        <span class="bold">{{count(\App\Notification::where('sight','=','0')->get())}} pending</span> notifications
                                        
                                    </h3>
                                    <a class="makeAsRead btn btn-link">Make Read</a>
                                </li>
                                <li>
                                    <ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">
                                        @foreach(\App\Notification::orderBy('created_at','desc')->get()->take(30) as $notify)
                                        <li>
                                            <a href="{{ route('payment.approve.index')}}">
                                                <span class="time">{{$notify->created_at->format('j M Y')}}</span>
                                                <span class="details" style="text-align: justify;">
                                                    <span class="label label-sm label-icon label-success" style="margin-bottom: 5px;">
                                                        <i class="fa fa-plus"></i>
                                                    </span>
                                                    <span class="message">{{$notify->description}}</span>
                                                </span>
                                            </a>
                                        </li>
                                        @endforeach
                                        
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <!-- END NOTIFICATION DROPDOWN -->
                        <!-- BEGIN INBOX DROPDOWN -->
                        <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                        <li class="dropdown dropdown-extended dropdown-inbox" id="header_inbox_bar">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                <i class="icon-envelope-open"></i>
                                @if( count(\App\Message::where('to_user_type','=','admin')->where('sight','=',0)->get()) )
                                <span class="badge badge-default pending_msg_remove"> {{count(\App\Message::where('to_user_type','=','admin')->where('sight','=',0)->where('to_user_id', '=',Auth::user()->id)->get())}} </span>
                                @endif
                            </a>
                            <ul class="dropdown-menu">
                                <li class="external">
                                    <h3 class="pending_msg_edit">You have
                                        <span class="bold">{{count(\App\Message::where('to_user_type','=','admin')->where('sight','=',0)->where('to_user_id', '=',Auth::user()->id)->get())}} New</span> Messages
                                    </h3>
                                    <a class="massage_make_as_read">Make read</a>
                                </li>
                                <li>
                                    <ul class="dropdown-menu-list scroller" style="height: 275px;" data-handle-color="#637283">

                                        @php
                                            $messages = \App\Message::where(function($q){
                                                $q->where('from_user_type', 'admin')->orWhere('to_user_type', 'admin');
                                            })->where(function($q){
                                                $q->where('from_user_id', Auth::user()->id)->orWhere('to_user_id', Auth::user()->id);
                                            })->orderBy('created_at', 'desc')->get();
                                            $user_list = [];
                                        @endphp

                                        @foreach($messages->take(30) as $msg)
                                            @php
                                                if($msg->from_user_id == Auth::user()->id && $msg->from_user_type == 'admin'){

                                                    if(\App\User::find($msg->to_user_id)){
                                                        $user = \App\User::find($msg->to_user_id);
                                                    }else{
                                                        $user= \App\DisabledUser::find($msg->to_user_id);
                                                    }

                                                }else{
                                                
                                                    if(\App\User::find($msg->from_user_id)){
                                                        $user= \App\User::find($msg->from_user_id);
                                                    }else{
                                                        $user = \App\DisabledUser::find($msg->from_user_id);
                                                    }
                                                }
                                            @endphp
                                            @if($user)
                                                @if(!in_array($user->id, $user_list))
                                                    <li>
                                                
                                                        <a href="{{route('admin.inboxv2')}}?user_id={{$msg->from_user_id}}">
                                                            <span class="photo">
                                                                <img src="{{asset('assets/layouts/layout3/img/avatar2.jpg')}}" class="img-circle" alt=""> </span>
                                                            <span class="subject">
                                                                
                                                                    <span class="from"> {{ $user->name }} </span>
                                                                    <span class="time"> {{ $msg->created_at->format('j M Y') }} </span>
                                                                
                                                            </span>
                                                            <span class="message"> {{$msg->message}} </span>
                                                        </a>

                                                        @php
                                                            array_push($user_list, $user->id);
                                                        @endphp
                                                    
                                                    </li>
                                                @endif
                                            @endif

                                        @endforeach
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <!-- END INBOX DROPDOWN -->
                        <!-- BEGIN TODO DROPDOWN -->
                        <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                        
                        <li class="dropdown dropdown-user">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                <img alt="" class="img-circle" src="{{asset('assets/layouts/layout/img/avatar3_small.jpg')}}" />
                                <span class="username username-hide-on-mobile"> {{ Auth::user()->name }} </span>
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-default">
                                <li>
                                    <a href="{{ route('admin.inboxv2') }}">
                                        <i class="icon-envelope-open"></i>Inbox
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="icon-key"></i> Log Out </a>
                                </li>
                                
                            </ul>
                        </li>
                        <!-- END USER LOGIN DROPDOWN -->
                        <!-- BEGIN QUICK SIDEBAR TOGGLER -->
                    </ul>
                </div>
                <!-- END TOP NAVIGATION MENU -->
            </div>
            <!-- END HEADER INNER -->
        </div>
        <!-- END HEADER -->
        <!-- BEGIN HEADER & CONTENT DIVIDER -->
        <div class="clearfix"> </div>
        <!-- END HEADER & CONTENT DIVIDER -->
        <!-- BEGIN CONTAINER -->
        <div class="page-container">
            <!-- BEGIN SIDEBAR -->
            <div class="page-sidebar-wrapper" >
                <!-- BEGIN SIDEBAR -->
                <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                <div class="page-sidebar navbar-collapse collapse" >
                    <!-- BEGIN SIDEBAR MENU -->
                    <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
                    <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
                    <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
                    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                    <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
                    <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                    <ul class="page-sidebar-menu  page-header-fixed page-sidebar-menu-light " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
                        <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
                        <li class="sidebar-toggler-wrapper hide" style="background: #000000">
                            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                            <div class="sidebar-toggler" style="background: #000000">
                                <span></span>
                            </div>
                            <!-- END SIDEBAR TOGGLER BUTTON -->
                        </li>
                        <!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
                        <li class="sidebar-search-wrapper" style="background: #000000">
                            <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
                            <!-- DOC: Apply "sidebar-search-bordered" class the below search form to have bordered search box -->
                            <!-- DOC: Apply "sidebar-search-bordered sidebar-search-solid" class the below search form to have bordered & solid search box -->
                        <!--    <form class="sidebar-search  " action="page_general_search_3.html" method="POST">
                                <a href="javascript:;" class="remove">
                                    <i class="icon-close"></i>
                                </a>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search...">
                                    <span class="input-group-btn">
                                        <a href="javascript:;" class="btn submit">
                                            <i class="icon-magnifier"></i>
                                        </a>
                                    </span>
                                </div>
                            </form>
                            <!-- END RESPONSIVE QUICK SEARCH FORM -->
                        </li>
                        <li class="nav-item start active open">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link nav-toggle">
                                <i class="icon-home"></i>
                                <span class="title">Dashboard</span>
                                
                            </a>
                        </li>
                        
                        
                        <li class="heading">
                            <h3 class="uppercase" style="color: #000000">Features</h3>
                        </li>
                        <li class="nav-item  ">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="fa fa-question-circle"></i>
                                <span class="title">Events</span>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item  ">
                                    <a href="{{ route('event.create') }}" class="nav-link ">
                                        <span class="title">Add Event</span>
                                    </a>
                                </li>
                                <li class="nav-item  ">
                                    <a href="{{ route('event.index') }}" class="nav-link ">
                                        <span class="title">All Event</span>
                                    </a>
                                </li>

                            </ul>
                        </li>
                        <li class="nav-item  ">

                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="fa fa-question-circle"></i>
                                <span class="title">Exams</span>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item  ">
                                    <a href="{{ route('question.create') }}" class="nav-link ">
                                        <span class="title">Add Question</span>
                                    </a>
                                </li>
                                <li class="nav-item  ">
                                    <a href="{{ route('question.index') }}" class="nav-link ">
                                        <span class="title">All Questions</span>
                                    </a>
                                </li>
                            </ul>
                                <li class="nav-item  ">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="fa fa-play-circle"></i>
                                <span class="title">Video</span>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item  ">
                                    <a href="{{ route('video.create') }}" class="nav-link ">
                                        <span class="title">Add Video</span>
                                    </a>
                                </li>
                                <li class="nav-item  ">
                                    <a href="{{ route('video.index') }}" class="nav-link ">
                                        <span class="title">All Video</span>
                                    </a>
                                </li>
                               </ul>
                                <li class="nav-item  ">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="icon-layers"></i>
                                <span class="title">Package</span>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item  ">
                                    <a href="{{ route('packages.create') }}" class="nav-link ">
                                        <span class="title">Add Package</span>
                                    </a>
                                </li>
                                <li class="nav-item  ">
                                    <a href="{{ route('packages.index') }}" class="nav-link ">
                                        <span class="title">All Packages</span>
                                    </a>
                                </li>
                                </ul>
                              
                        </li>
                        <li class="nav-item  ">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="icon-users"></i>
                                <span class="title">Users</span>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item  ">
                                    <a href="{{ route('showAllUsers') }}" class="nav-link ">
                                        <span class="title">All users  </span>
                                    </a>
                                </li>
                                 <li class="nav-item  ">
                                    <a href="{{ route('ScreenShotAttempts')}}" class="nav-link ">
                                        <span class="title">Screen Shot Attempts</span></a>
                                </li>
                                <li class="nav-item  ">
                                    <a href="{{ route('disabled.user.view') }}" class="nav-link ">
                                        <span class="title">Disabled Users</span>
                                    </a>
                                </li>
                                </ul>
                                 <li class="nav-item  ">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="fa fa-money"></i>
                                <span class="title">Payments</span>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item  ">
                                    <a href="{{ route('paypal.config.index')}}" class="nav-link ">
                                        <span class="title">PayPal settings</span></a>
                                </li>
                                <li class="nav-item  ">
                                    <a href="{{ route('payment.approve.index')}}" class="nav-link ">
                                        <span class="title">Payments Approve</span></a>
                                </li>
                                <li class="nav-item  ">
                                    <a href="{{ route('extension.payment.approve.index')}}" class="nav-link ">
                                        <span class="title">Extension Payments Approve</span></a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item  ">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="fa fa-credit-card"></i>
                                <span class="title">Coupons</span>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                
                                <li class="nav-item  ">
                                    <a href="{{ route('coupon.create') }}" class="nav-link ">
                                        <span class="title">Create</span>
                                    </a>
                                </li>
                                <li class="nav-item  ">
                                    <a href="{{ route('coupon.show') }}" class="nav-link ">
                                        <span class="title">show</span>
                                    </a>
                                </li>
                                
                            </ul>
                        </li>
                          <li class="nav-item  ">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="icon-puzzle"></i>
                                <span class="title">System Management</span>
                                <span class="arrow"></span>
                                <ul class="sub-menu">
                                    <li>
                                        
                                        <a href="{{ route('users.feedback.view') }}" class="nav-link ">
                                            <span class="title">Users Feedback</span>
                                        </a>
                                    </li>
                                  <li class="nav-item  ">
                                    <a href="{{ route('chapterManager.show') }}" class="nav-link ">
                                        <span class="title">Chapters Mangager</span>
                                    </a>
                                </li>
                                  <li class="nav-item  ">
                                    <a href="{{ route('material.show.admin') }}" class="nav-link ">
                                        <span class="title"> Add Material</span>
                                    </a>
                                </li>
                                  <li class="nav-item  ">
                                    <a href="{{route('studyPlan.show.admin')}}" class="nav-link ">
                                        <span class="title">Add Study Plan</span>
                                    </a>
                                </li>
                                 <li class="nav-item  ">
                                    <a href="{{route('flashCard.show.admin')}}" class="nav-link ">
                                        <span class="title">Add Flash Card</span>
                                    </a>
                                </li>   
                                <li class="nav-item  ">
                                    <a href="{{route('faq.show.admin')}}" class="nav-link ">
                                        <span class="title">Add FAQs</span>
                                    </a>
                                </li>      
                                <li class="nav-item  ">
                                    <a href="{{route('promotion.index')}}" class="nav-link ">
                                        <span class="title">Promotion</span>
                                    </a>
                                </li>
                                <li class="nav-item  ">
                                    <a href="{{route('admin.terms.index')}}" class="nav-link ">
                                        <span class="title">Terms Of Service</span>
                                    </a>
                                </li>     
                                
                            </ul>
                            <li class="nav-item  ">
                                <a href="javascript:;" class="nav-link nav-toggle">
                                    <i class="icon-settings"></i>
                                    <span class="title">Statics</span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                    @foreach(\App\Course::where('private', 0)->get() as $c)
                                    <li class="nav-item  ">
                                        <a href="{{route('statics.index', $c->id)}}" class="nav-link ">
                                            <span class="title">{{$c->title}}</span>
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </li>
                            <li class="nav-item  ">
                                <a href="javascript:;" class="nav-link nav-toggle">
                                    <i class="icon-settings"></i>
                                    <span class="title">Video Rearrange</span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                    @foreach(\App\Course::all() as $c)
                                    <li class="nav-item  ">
                                        <a href="{{route('rearrange.index', $c->id)}}" class="nav-link ">
                                            <span class="title">{{$c->title}}</span>
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </li>
                            <li class="nav-item  ">
                                <a href="javascript:;" class="nav-link nav-toggle">
                                    <i class="icon-comment"></i>
                                    <span class="title">Comments</span>
                                    <span class="arrow"></span>
                                    @if(count(\App\PageComment::where('sight', 0)->get()))
                                        <span class="badge badge-default pendingg_notification_count"> {{count(\App\PageComment::where('sight', 0)->get())}} </span>
                                    @endif
                                </a>
                                <ul class="sub-menu">
                                    @foreach(['video','exam', 'chapter', 'process_group'] as $c)
                                    <li class="nav-item  ">
                                        <a href="{{route('admin.comments.show', $c)}}" class="nav-link ">
                                            <span class="title">{{$c}}</span>
                                            @if(count(\App\PageComment::where('sight', 0)->where('page', $c)->get()))
                                                <span class="badge badge-default pendingg_notification_count"> {{count(\App\PageComment::where('sight', 0)->where('page', $c)->get())}} </span>
                                            @endif
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </li>
                        <li class="nav-item  ">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="icon-settings"></i>
                                <span class="title">My Account </span>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item  ">
                                    <a href="form_controls.html" class="nav-link ">
										<span class="title">My Profile </span>
                                    </a>
                                </li>
                                <li class="nav-item  ">
                                    <a href="form_controls_md.html" class="nav-link ">
                                        <span class="title">My Calender</span>
                                    </a>
                                </li>
                                <li class="nav-item  ">
                                    <a href="{{route('admin.inboxv2')}}" class="nav-link ">
                                        <span class="title">My Inbox</span>
                                    </a>
                                </li>
                                <li class="nav-item  ">
                                    <a href="form_validation_states_md.html" class="nav-link ">
                                        <span class="title">My Task</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        {{-- <li class="nav-item  ">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="icon-lock"></i>
                                <span class="title">lock Screen</span></a>
                        </li> --}}
                        <li class="nav-item  ">
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link nav-toggle">
                                <i class="icon-logout"></i>
                                <span class="title">Logout</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                    <!-- END SIDEBAR MENU -->
                    <!-- END SIDEBAR MENU -->
                </div>
                <!-- END SIDEBAR -->
            </div>
            <!-- END SIDEBAR -->

            
            
            
                @include('include.msg')
            
            
            
            
            
            
            @yield('content')







            <!-- BEGIN QUICK SIDEBAR -->
            <a href="javascript:;" class="page-quick-sidebar-toggler">
                <i class="icon-login"></i>
            </a>
            
            <!-- END QUICK SIDEBAR -->
        </div>
        <!-- END CONTAINER -->
        <!-- BEGIN FOOTER -->
        <div class="page-footer">
            <div class="page-footer-inner"> 2019 &copy; {{env('APP_NAME')}}.
                <a href="https://adtit.com" title="Purchase Metronic just for 27$ and get lifetime updates for free" target="_blank">Powerd by Adtit</a>
            </div>
            <div class="scroll-to-top">
                <i class="icon-arrow-up"></i>
            </div>
        </div>
        <!-- END FOOTER -->
        @yield('jscode')

        {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> --}}

        <script>
            $('.makeAsRead').click(function(){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                
                $.ajax ({
                    type: 'POST',
                    url: '{{ route('MakeRead') }}', 
                    success: function(res){
                        $('.pending_notification').html('<span class="bold">0 pending</span> notifications');
                        $('.pendingg_notification_count').remove();
                    },
                    error: function(res){
                        console.log('Error:', res);    
                    }
                });
            });

            $('.massage_make_as_read').click(function(){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                
                $.ajax ({
                    type: 'POST',
                    url: '{{ route('MakeReadMsg.admin') }}', 
                    success: function(res){
                        $('.pending_msg_edit').html('<span class="bold">0 New</span> messages');
                        $('.pending_msg_remove').remove();
                    },
                    error: function(res){
                        console.log('Error:', res);    
                    }
                });
            });
        </script>
    </body>

</html>
