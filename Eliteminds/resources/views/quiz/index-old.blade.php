<!DOCTYPE html>

<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>{{env('APP_NAME')}} | Dashboard</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <style>
            a#prev, a#next, a.aElement {
                color: #333 !important;
            }
            a#prev:hover, a#next:hover, a.aElement:hover{
                text-decoration: none !important;
                
                color: dimgray !important;

            }
        </style>
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
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
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="favicon.ico" />
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
        <style>
        .contral-question {
            display:flex;
            flex-direction: row;
            flex-wrap: wrap;
            /* justify-content: space-between; */

        }
        .contral-question {
                display:flex;
                flex-direction: row;
                flex-wrap: wrap;
                justify-content: space-between; 
    
        }
        .contral-question > div {
            margin: 0 11px 3px 0;
        }
        .options > div > label{
            font-weight:bold;
        }
        </style>
    </head>
    <!-- END HEAD -->

    <body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo" style="">
        <!-- BEGIN HEADER -->
        <div class="page-header navbar navbar-fixed-top" style="">
            <!-- BEGIN HEADER INNER -->
            <div class="page-header-inner ">
                <!-- BEGIN LOGO -->
                <div class="page-logo">
                    <a href="index.html">
                        <img src="{{asset('assets/layouts/layout/img/logo-light.png')}}" alt="logo" class="logo-default" /> </a>
                    
                </div>
                <!-- END LOGO -->
                <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"  style="color:#ffffff">
                    <span></span>
                </a>
                <!-- END RESPONSIVE MENU TOGGLER -->
                <!-- BEGIN TOP NAVIGATION MENU -->
                @if(Auth::guard('admin')->check())      
                        
                <div class="top-menu" style="float:right !important">
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
                            <ul class="dropdown-menu">
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
                                            <a href="javascript:;">
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
                                        @foreach(\App\Message::where('to_user_type','=','admin')->where('to_user_id', '=',Auth::user()->id)->orderBy('created_at','desc')->get()->take(30) as $msg)
                                        <li>
                                            <a href="#">
                                                <span class="photo">
                                                    <img src="{{asset('assets/layouts/layout3/img/avatar2.jpg')}}" class="img-circle" alt=""> </span>
                                                <span class="subject">
                                                    <span class="from"> {{ App\User::find($msg->from_user_id)->name }} </span>
                                                    <span class="time"> {{ $msg->created_at->format('j M Y') }} </span>
                                                </span>
                                                <span class="message"> {{$msg->message}} </span>
                                            </a>
                                        </li>
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
                                <img alt="" class="img-circle" 
                                @if(Auth::check())
                                    @if(\App\UserDetail::where('user_id', '=', Auth::user()->id)->get()->first() )
                                        @if(\App\UserDetail::where('user_id', '=', Auth::user()->id)->get()->first()->profile_pic)
                                            src="{{ url('storage/profile_picture/'.basename(\App\UserDetail::where('user_id','=',Auth::user()->id)->get()->first()->profile_pic))}}"
                                        @else
                                            src="{{asset('assets/layouts/layout/img/avatar3_small.jpg')}}" 
                                        @endif
                                    @else    
                                        src="{{asset('assets/layouts/layout/img/avatar3_small.jpg')}}" 
                                    @endif
                                @endif
                                />
                                <span class="username username-hide-on-mobile"> 
                                    @if(Auth::check())
                                        {{ Auth::user()->name }}
                                    @endif
                                </span>
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-default">
                                <li>
                                    <a href="{{ route('user.index') }}">
                                        <i class="icon-envelope-open"></i>Inbox
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="icon-logout"></i> Log Out </a>
                                </li>
                            </ul>
                        </li>
                        <!-- END USER LOGIN DROPDOWN -->
                        <!-- BEGIN QUICK SIDEBAR TOGGLER -->
                    </ul>
                </div>
                <!-- END TOP NAVIGATION MENU -->
                @elseif(Auth::guard('web')->check())
                <div class="top-menu"  style="float:right !important">
                    
                        <ul class="nav navbar-nav pull-right">
                            <!-- BEGIN NOTIFICATION DROPDOWN -->
                            <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                            <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <i class="icon-bell"></i>
                                    {{-- @if(count(\App\Notification::where('sight','=','0')->get()))
                                    <span class="badge badge-default pendingg_notification_count"> {{count(\App\Notification::where('sight','=','0')->get())}} </span>
                                    @endif --}}
    
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="external">
                                        
                                        <h3 class="pending_notification">
                                            <span class="bold">
                                                {{-- {{count(\App\Notification::where('sight','=','0')->get())}} --}}
                                                 pending</span> notifications
                                            
                                        </h3>
                                        <a class="makeAsRead btn btn-link">Make Read</a>
                                    </li>
                                    <li>
                                        <ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">
                                            {{-- @foreach(\App\Notification::orderBy('created_at','desc')->get()->take(30) as $notify)
                                            <li>
                                                <a href="javascript:;">
                                                    <span class="time">{{$notify->created_at->format('j M Y')}}</span>
                                                    <span class="details" style="text-align: justify;">
                                                        <span class="label label-sm label-icon label-success" style="margin-bottom: 5px;">
                                                            <i class="fa fa-plus"></i>
                                                        </span>
                                                        <span class="message">{{$notify->description}}</span>
                                                    </span>
                                                </a>
                                            </li>
                                            @endforeach --}}
                                            
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
                                    {{-- @if( count(\App\Message::where('to_user_type','=','admin')->where('sight','=',0)->get()) )
                                    <span class="badge badge-default pending_msg_remove"> {{count(\App\Message::where('to_user_type','=','admin')->where('sight','=',0)->where('to_user_id', '=',Auth::user()->id)->get())}} </span>
                                    @endif --}}
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="external">
                                        <h3 class="pending_msg_edit">You have
                                            <span class="bold">
                                                {{-- {{count(\App\Message::where('to_user_type','=','admin')->where('sight','=',0)->where('to_user_id', '=',Auth::user()->id)->get())}} --}}
                                                 New</span> Messages
                                        </h3>
                                        <a class="massage_make_as_read">Make read</a>
                                    </li>
                                    <li>
                                        <ul class="dropdown-menu-list scroller" style="height: 275px;" data-handle-color="#637283">
                                            {{-- @foreach(\App\Message::where('to_user_type','=','admin')->where('to_user_id', '=',Auth::user()->id)->orderBy('created_at','desc')->get()->take(30) as $msg)
                                            <li>
                                                <a href="#">
                                                    <span class="photo">
                                                        <img src="{{asset('assets/layouts/layout3/img/avatar2.jpg')}}" class="img-circle" alt=""> </span>
                                                    <span class="subject">
                                                        <span class="from"> {{ App\User::find($msg->from_user_id)->name }} </span>
                                                        <span class="time"> {{ $msg->created_at->format('j M Y') }} </span>
                                                    </span>
                                                    <span class="message"> {{$msg->message}} </span>
                                                </a>
                                            </li>
                                            @endforeach --}}
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
                                    <span class="username username-hide-on-mobile"> 
                                        @if(Auth::check())
                                            {{ Auth::user()->name }}
                                        @endif
                                    </span>
                                    <i class="fa fa-angle-down"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-default">
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

                @endif
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
            <div class="page-sidebar-wrapper">
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
                    <ul class="page-sidebar-menu  page-header-fixed page-sidebar-menu-light " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px" >
                        <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
                        <li class="sidebar-toggler-wrapper hide" >
                            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                            <div class="sidebar-toggler" style="color: white;" >
                                <span></span>
                            </div>
                            <!-- END SIDEBAR TOGGLER BUTTON -->
                        </li>
                        <!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
                        
                        @if(Auth::guard('web')->check())
                        <li class="nav-item start active open">
                                <a href="{{ route('admin.dashboard') }}" class="nav-link nav-toggle">
                                    <i class="icon-home"></i>
                                    <span class="title">Dashboard</span>
                                    
                                </a>
                            </li>
                            {{-- <li class="heading">
                                <h3 class="uppercase">Features</h3>
                            </li> --}}
    
                            
                            <li class="nav-item  ">
                                <a href="javascript:;" class="nav-link nav-toggle">
                                    <i class="icon-basket"></i>
                                    <span class="title">Packages</span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item  ">
                                        <a href="{{ route('showAllPackages', \App\Course::all()->first()->id) }}" class="nav-link ">
                                            <span class="title">All Courses</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item  ">
                                <a href="javascript:;" class="nav-link nav-toggle">
                                    <i class="icon-diamond"></i>
                                    <span class="title">Exam</span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item  ">
                                        <a href="{{ route('FreeQuiz') }}" class="nav-link ">
                                            <span class="title">Free Quiz</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="{{ route('PremiumQuiz-st1') }}" class="nav-link ">
                                            <span class="title">Premium Quiz</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="{{ route('scoreHistory') }}" class="nav-link ">
                                            <span class="title">Score History</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="{{ route('QuizHistoryShow') }}" class="nav-link ">
                                            <span class="title">Quiz History</span>
                                        </a>
                                    </li>
                                    
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
                                        <a href="" class="nav-link ">
                                            <span class="title">My Profile </span>
                                        </a>
                                    </li>
                                    
                                    <li class="nav-item  ">
                                        <a href="{{ route('user.index')}}" class="nav-link ">
                                            <span class="title">My Inbox</span>
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
                                    <i class="icon-key"></i>
                                    <span class="title">Logout</span>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>                             
                        
                        @elseif(Auth::guard('admin')->check())
                        <li class="nav-item start active open">
                                <a href="{{ route('admin.dashboard') }}" class="nav-link nav-toggle">
                                    <i class="icon-home"></i>
                                    <span class="title">Dashboard</span>
                                    
                                </a>
                            </li>
                            <li class="heading">
                                <h3 class="uppercase">Features</h3>
                            </li>
                            <li class="nav-item  ">
                                <a href="javascript:;" class="nav-link nav-toggle">
                                    <i class="icon-diamond"></i>
                                    <span class="title">Exam manager</span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item  ">
                                        <a href="{{ route('question.create') }}" class="nav-link ">
                                            <span class="title">Add Qustions</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="{{ route('question.index') }}" class="nav-link ">
                                            <span class="title">All Qustions</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="{{ route('packages.create') }}" class="nav-link ">
                                            <span class="title">Add Package</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="{{ route('packages.index') }}" class="nav-link ">
                                            <span class="title">All courses</span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="{{ route('chapterManager.show') }}" class="nav-link ">
                                            <span class="title">Chapters Mangager</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item  ">
                                <a href="javascript:;" class="nav-link nav-toggle">
                                    <i class="icon-puzzle"></i>
                                    <span class="title">System Manager</span></a>
                                <ul class="sub-menu">
                                    <li class="nav-item  ">
                                        <a href="components_date_time_pickers.html" class="nav-link ">
                                            <span class="title">All users  </span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="components_color_pickers.html" class="nav-link ">
                                            <span class="title">Profit</span></a>
                                    </li>
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
                                        <a href="form_validation.html" class="nav-link ">
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
                                    <i class="icon-key"></i>
                                    <span class="title">Logout</span>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        @else
                        <li class="nav-item  ">
                                <a href="{{ route('login') }}" class="nav-link nav-toggle">
                                    <i class="icon-settings"></i>
                                    <span class="title">Login</span>
                                </a>
                            </li>
    
                            <li class="nav-item  ">
                                <a href="{{ route('register') }}" class="nav-link nav-toggle">
                                    <i class="icon-settings"></i>
                                    <span class="title">Sign Up</span>
                                </a>
                            </li>

                        @endif
                        
                    </ul>
                    <!-- END SIDEBAR MENU -->
                    <!-- END SIDEBAR MENU -->
                </div>
                <!-- END SIDEBAR -->
            </div>
            <!-- END SIDEBAR -->
            <!-- END SIDEBAR -->



<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content" style="">
        <!-- BEGIN PAGE HEADER-->
        <!-- BEGIN THEME PANEL -->
        <!-- END THEME PANEL -->
        <!-- BEGIN PAGE BAR -->
        
        <!-- END PAGE BAR -->
        <!-- BEGIN PAGE TITLE-->
        <h3 >
        </h3>
        <!-- END PAGE TITLE-->
        <!-- END PAGE HEADER-->

        







        <div class="container-fluid" id="app-1">
            <div class="row">
                <div class="col-md-7 form-1" >
                    {{-- optimize Quiz Questions Form --}}
                    {{-- 
                        *******************************
                        *******************************
                        *******************************
                        *******************************
                        *******************************
                        *******************************                
                        --}}
                    <form @submit.prevent="optimizeQuiz" id="optimizeForm" style="">
                        <div class="row" style="padding-top: 16px;">
                            <div class="col-lg-5">
                                <div class="form-group form-inline">
                                    <strong><label for="type">Question Type : </label></strong>
                                    <select name="type" id="type" v-model="question_type" v-on:change="reloadQuestionsNumber" class="form-control">
                                        <option v-for="i in question_type_list">@{{i}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="form-group-form-inline" >
                                    <strong><label for="num">Question Number : </label></strong>
                                    <input type="number" min="1" v-bind:max="max_questions_num" id="num" class="form-control" v-model="question_num"><strong> /@{{max_questions_num}} questions</strong>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <a v-on:click="optimizeQuiz" class="btn btn-primary" style="margin-top:23px;" >Start Quiz</a>
                                </div>
                            </div>
                        </div>
                    </form>
        
                    {{-- Quiz View --}}
                    {{-- 
                        *******************************
                        *******************************
                        *******************************
                        *******************************
                        *******************************
                        *******************************                
                        --}}

                    <div class="container-fluid primeQuizViewWM" id="quiz" style="min-height: 50px; margin:20px 0; display:none;">
                        <div class="row" style=" ">
                            <div class="col-md-1" style="padding: 0 !important;">
                                <strong>@{{current_question_number}}</strong>/@{{q_number}}
                            </div>
                            
                            <div class="col-md-9">
                                <div class="progress" style="border: 1px solid #ccc;">
                                    <div class="progress-bar progress-bar-striped" id="progress_bar" role="progressbar" style="width: 10%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">60%</div>
                                </div>
                            </div>

                            <div class="col-md-1" style=" text-align: center;">
                                <div class="row" style="color: #333;  font-weight: lighter;" id="timer">00:00:00</div>
                            </div>


                            <div class="col-md-1" style="text-align: center; padding:0 !important;">
                                
                                                                                             
                                <a class="aElement" v-on:click="markExam">
                                    <i class="fa fa-stop" style=""></i>
                                </a>
                            </div>
                            
                        </div>              

                        <hr>
                        <div class="row" style=" font-size: 21px; border-radius: 10px !important; background-color: #e8ebef; font-weight:bold; margin: 10px 0 20px 0;">
                            <p class="col-md-12" style="margin: 8px 0; padding: 0 10px;">
                                @{{question_title}}
                            </p>
                        </div>

                        <div class="row">
                            <div class="fig" id="fig" style="display:none; margin: 0 0 10px 50px;">
                                <img class="img-responsive" v-bind:src="img_link" width="550" alt="fig0-0">
                            </div>
                        </div>

                        <div class="container-fluid row options" style="font-size: 18px;  min-height: 50px; width: 100%;">
                            <div class="radio" id="radio1" style="border-radius: 9px !important; border: 1px solid rgb(204, 204, 204); min-height: 40px; padding: 10px 0 10px 10px; margin-bottom: 10px;">
                                <label ><input v-on:click="answerd_counter" type="radio" name="optradio" v-model="rad" v-bind:value='opt1'>@{{opt1}}</label>
                            </div>
                            <div class="radio" id="radio2" style="border-radius: 9px !important; border: 1px solid rgb(204, 204, 204); min-height: 40px; padding: 10px 0 10px 10px; margin-bottom: 10px;">
                                <label ><input v-on:click="answerd_counter" type="radio" name="optradio"  v-model="rad" v-bind:value='opt2'>@{{opt2}}</label>
                            </div>
                            <div class="radio" id="radio3" style="border-radius: 9px !important; border: 1px solid rgb(204, 204, 204); min-height: 40px; padding: 10px 0 10px 10px; margin-bottom: 10px;">
                                <label ><input v-on:click="answerd_counter" type="radio" name="optradio" v-model="rad" v-bind:value='opt3'>@{{opt3}}</label>
                            </div>
                            <div class="radio" id="radio4" style="border-radius: 9px !important; border: 1px solid rgb(204, 204, 204); min-height: 40px; padding: 10px 0 10px 10px;">
                                <label ><input v-on:click="answerd_counter" type="radio" name="optradio" v-model="rad" v-bind:value='opt4'>@{{opt4}}</label>
                            </div>
                        
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-2" style="  min-height: 30px; font-size: 18px;">
                                <a id="prev" v-on:click="prev">
                                    <i class="fa fa-angle-left" style="font-weight: bold; font-size: 21px; padding-right:5px;"></i>  PREVIOUS
                                </a>
                            </div>
                            <div class="col-md-offset-8 col-md-2" style="  min-height: 30px; text-align: right; font-size: 18px;">
                                <a id="next" v-on:click="next" >
                                    NEXT <i class="fa fa-angle-right" style="font-weight: bold; font-size: 21px; padding-left:5px;"></i>
                                </a>
                            </div>
                        </div>
                    
                    </div>    

                    <div class="container-fluid" id="result" style="display:none;" >
                        <h2>
                            Your Score is : @{{score}} % 
                            <i v-html="ScoreMsg"></i>
                        </h2>
        
                        <h3>Score Analysis</h3>
        
                        <div class="mx-auto">
                            <a class="btn green-meadow" v-on:click="return_to_quiz">Review</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            

















        
        
    </div>
    <!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->
<!-- BEGIN QUICK SIDEBAR -->
<a href="javascript:;" class="page-quick-sidebar-toggler">
    <i class="icon-login"></i>
</a>

<!-- END QUICK SIDEBAR -->
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<div class="page-footer">
<div class="page-footer-inner"> 2019 &copy; {{env('APP_NAME')}}.COM.
    <a href="http://adtit.com" title="Purchase Metronic just for 27$ and get lifetime updates for free" target="_blank">Powerd by Adtit</a>
</div>
<div class="scroll-to-top">
    <i class="icon-arrow-up"></i>
</div>
</div>
<!-- END FOOTER -->



<!-- BEGIN CORE PLUGINS -->
<script src="{{ asset('assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/js.cookie.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/jquery.blockui.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->

<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="{{ asset('assets/global/scripts/app.min.js') }}" type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ asset('assets/pages/scripts/dashboard.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<script src="{{ asset('assets/layouts/layout/scripts/layout.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/layouts/layout/scripts/demo.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/layouts/global/scripts/quick-sidebar.min.js') }}" type="text/javascript"></script>
<!-- END THEME LAYOUT SCRIPTS -->
<script src="{{asset('js/easyTimer.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>
    <script>
        
        


        var app = new Vue({
            el: '#app-1',
            data: {
                feedback: '',
                current_question_answer: '',
                rad:'',
                questions: [],
                question_title_list: [],
                current_question_number: 0, 
                q_number: 0,
                question_title: '',
                opt1: '',
                opt2: '',
                opt3: '',
                opt4: '',
                q_answerd: 0,
                q_answerd_list: [],
                user_answers:[],
                timer: new Timer(),
                timeTaken: '',
                score: 0,
                question_type_list: [
                    'All',
                    @if(count($type_list))
                        @foreach($type_list as $type)
                            '{{$type}}',
                        @endforeach
                    @endif
                ],
                question_type: 'All',
                question_num: {{$questions_number}},
                max_questions_num: {{$questions_number}},
                img_link: '',
                make_exam: {
                    taken: 0,
                    text: 'Submit Exam'
                }, // exam has been taken or not
                ScoreMsg: '',
                scoreAnalysis: {
                    @if(count($type_list))
                        @foreach($type_list as $type)
                            '{{$type}}': {msg: '',count: 0 , data: []},
                        @endforeach
                    @endif
                },
                flaged: [],

            },
            methods: {
                _:function(ele){
                    return document.getElementById(ele);
                },
                update_progress: function(add){
                    if(app.make_exam.taken == 0){
                        percent = Math.round((app.q_answerd)/app.q_number*100);
                        $('.progress-bar').attr('aria-valuenow', percent);
                        $('.progress-bar').attr('style', 'width: '+percent+'%');
                        this._('progress_bar').innerHTML = percent.toString().substr(0,5)+' %';
                    }
                },
                reloadQuestionsNumber: function(e){
                    Data = {
                        name: this.question_type
                    };


                    e.preventDefault();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    
                    $.ajax ({
                        type: 'POST',
                        url: '{{ route('quiz.reloadQuestionsNumber')}}', 
                        data: Data,
                        success: function(res){
                            
                            app.max_questions_num = res;
                            app.question_num = res;
                        },
                        error: function(res){
                            console.log('Error:', res);    
                        }
                    });
                },
                storeAnswers:function(){
                    this.user_answers.forEach(ele => {
                        if(ele.question_num == this.current_question_number){
                            ele.user_answer = this.rad;
                        }
                    });
                },
                answerd_counter: function(){
                    if(!this.q_answerd_list.includes(this.current_question_number)){
                        this.q_answerd_list.push(this.current_question_number);
                        this.q_answerd++;      
                    }
                },
                optimizeQuiz: function(e){
                    $("#optimizeForm").hide();
                    
                    done  = 0;
                    // send request to generate the questions
                    Data = {
                        num: this.question_num,
                        type: this.question_type
                    };


                    e.preventDefault();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    
                    $.ajax ({
                        type: 'POST',
                        url: '{{ route('quiz.generate')}}', 
                        data: Data,
                        success: function(res){
                            if (res[0] == '222'){
                                alert(res[1]);
                                exit();
                            }
                            app.q_number = res.length;
                            app.current_question_number = 1;
                            app.questions = res;
                            counter = 1;
                            res.forEach(ele => {
                                app.question_title_list.push({
                                    id: counter,
                                    title: counter+'. '+ele['title'].substring(0,80)+'..',
                                    score: 0,
                                });
                                counter++;
                            });
                            app.push_question(app.current_question_number);
                            
                            c = 1;
                            app.questions.forEach(q => {
                                app.user_answers.push({
                                    question_num: c,
                                    user_answer: '',
                                    correct_answer: q['correct_answer'],
                                    process_group: q['process_group']
                                });
                                c++;
                            });

                            console.log(app.questions);
                            
                        },
                        error: function(res){
                            console.log('Error:', res);    
                        }
                    });

                    // show the quiz form and fire the timer on
                    
                    app.timer.start({countdown: true, startValues: {seconds: this.question_num *72}});
                    app.timer.addEventListener('secondsUpdated', function (e) {
                        $('#timer').html(app.timer.getTimeValues().toString());
                    });
                    app.timer.addEventListener('targetAchieved', function(e){
                        app.markExam();
                    });
                    $("#quiz").show();
                    $("#prev").hide();
                    if(app.question_num <= 1){
                        $("#next").hide();
                    }
                    done= 1;
                    while(1){
                        if(done==1){
                            app.update_progress();
                            break;
                        }
                    }

                },
                push_question: function(CQN/* Current question Number */){
                    this.question_title = this.questions[CQN-1]['title'];
                    this.opt1 = this.questions[CQN-1]['answers'][0];
                    this.opt2 = this.questions[CQN-1]['answers'][1];
                    this.opt3 = this.questions[CQN-1]['answers'][2];
                    this.opt4 = this.questions[CQN-1]['answers'][3];
                    this.feedback = this.questions[CQN-1]['feedback'];
                    this.current_question_answer = this.questions[CQN-1]['correct_answer'];
                    if(this.questions[CQN-1]['img'] != 'null'){
                        this.img_link = './storage/questions/'+this.questions[CQN-1]['img'];
                        $("#fig").show();
                    }else{
                        this.img_link = '';
                        $("#fig").hide();
                    }
                    
                },
                push_question_and_store_last_answer: function(QN /* question number */){
                    
                    this.storeAnswers();
                    this.push_question(QN);
                    this.current_question_number = QN;
                    this.selectUserAnswer();
                    
                    //check the question number to adjustfy the next and prev btns
                    if(this.current_question_number == this.q_number && this.q_number > 1){
                        $("#prev").show();
                        $("#next").hide();
                    }else if(this.current_question_number == 1 && this.q_number > 1){
                        $("#next").show();
                        $("#prev").hide();
                    }else if(this.current_question_number == this.q_number && this.q_number == 1){
                        $("#prev").hide();
                        $("#next").hide();
                    }else {
                        $("#next").show();
                        $("#prev").show();
                    }
                    if(this.make_exam.taken == 1){
                        this.selectCorrectAnswer();
                    }
                    this.colorMyflag();
                },
                next: function(){
                    // store the answer if exist
                    app.update_progress();
                    this.storeAnswers();
                    
                    //show the next question
                    if((this.current_question_number+2) > this.q_number){
                        $("#next").hide();
                        $("#prev").show();                      
                    }else{
                        $("#prev").show();
                        
                    }
                    this.current_question_number++;
                    
                    
                    this.push_question(this.current_question_number);
                    
                    //select the answer if exits
                    this.selectUserAnswer();
                    if(this.make_exam.taken == 1){
                        this.selectCorrectAnswer();
                    }
                    this.colorMyflag();
                },
                prev: function(){
                    // store the answer if exist
                    app.update_progress();
                    this.storeAnswers();
                    

                    //show the previous question
                    if((this.current_question_number - 2) < 1){
                        $("#prev").hide();
                        $("#next").show();
                    }else{
                        $("#next").show();
                    }
                    this.current_question_number--;
                    this.push_question(this.current_question_number);
                    //select the answer if exits
                    this.selectUserAnswer();
                    if(this.make_exam.taken == 1){
                        this.selectCorrectAnswer();
                    }
                    this.colorMyflag();
                },
                unselectRadio: function(){
                    this.rad = '';   
                },
                selectUserAnswer: function(){
                    found = 0;
                    this.user_answers.forEach(ele => {
                        if(ele.question_num == this.current_question_number){
                            this.rad = ele.user_answer;
                            found = 1;
                        }
                    });
                    if (!found){
                        this.unselectRadio();
                    }
                },
                selectCorrectAnswer: function(){
                    $("#radio1").find('.fa').remove();
                    $("#radio2").find('.fa').remove();
                    $("#radio3").find('.fa').remove();
                    $("#radio4").find('.fa').remove();

                    switch (this.questions[this.current_question_number-1].correct_answer) {
                        case this.opt1:
                            $("#radio1").prepend('<i class="fa fa-check" style="margin-left: -14px; color: green;"></i>');
                            break;
                        case this.opt2:
                            $("#radio2").prepend('<i class="fa fa-check" style="margin-left: -14px; color: green;"></i>');
                            break;
                        case this.opt3:
                            $("#radio3").prepend('<i class="fa fa-check" style="margin-left: -14px; color: green;"></i>');
                            break;
                        case this.opt4:
                            $("#radio4").prepend('<i class="fa fa-check" style="margin-left: -14px; color: green;"></i>');
                            break;
                    }
                },
                markExam: function(){
                    
                    app.update_progress();

                    if(this.flaged.length > 0 && !confirm("you have Flaged questions, Do you like to Process ?")){
                        console.log('stay down !');                        
                    }else{
                        if(this.make_exam.taken == 1){
                            $("#quiz").hide();
                            $("#result").show();
                            
                        }else{
                            // stop the timer and stor the time .
                            this.storeAnswers();

                            app.timer.stop();
                            // this.timeTaken = $("#timer").html();
                            $("#quiz").hide();
                            
                            counter = 0;
                            this.user_answers.forEach(ele => {
                                if(ele.user_answer == ele.correct_answer){
                                    this.score++;
                                    this.question_title_list[counter].score = '1  <i class="fa fa-check" style="color:green"></i>';
                                    
                                                        
                                }else{
                                    this.question_title_list[counter].score = '0 <i class="fa fa-times" style="color: red"></i>';
                                }
                                
                                counter++;
                            });
                            
                            
                            this.score /= this.q_number;
                            this.score *= 100;
                            this.score = Math.round(this.score);
        
                            if(this.score > 75){
                                this.ScoreMsg = '<small style="color:springgreen;">Congraulation you have Passed</small>';
                            }else{
                                this.ScoreMsg = '<small style="color:#DC143C;">Sorry You Failed !</small>';
                            }

                            // score analysis..
                            
                            this.user_answers.forEach(answer => {
                                score = 0;
                                if(answer.user_answer == answer.correct_answer){
                                    score = 1;
                                }
                                this.scoreAnalysis[answer.process_group].data.push({
                                    q_num: answer.question_num,
                                    q_score: score
                                });
                            });
                            // calculate number of question per process group..
                            for(i in this.scoreAnalysis){
                                this.scoreAnalysis[i].count = this.scoreAnalysis[i].data.length;
                            }
                            // generate the massage 
                            number_de_correct_answers = 0;
                            for(i in this.scoreAnalysis){
                                this.scoreAnalysis[i].data.forEach(ele => {
                                    if(ele.q_score == 1){
                                        number_de_correct_answers++;
                                    }
                                });
                                process_score = number_de_correct_answers / this.scoreAnalysis[i].count;
                                process_score *= 100;
                                process_score = Math.round(process_score);

                                if(process_score <= 60){
                                    this.scoreAnalysis[i].msg = '<i style="color: red;">Need Improvment</i>';
                                }else if(process_score > 60 && process_score<=70){
                                    this.scoreAnalysis[i].msg = '<i style="color: red;">below target</i>';
                                }else if(process_score >= 75 && process_score <= 80){
                                    this.scoreAnalysis[i].msg = '<i style="color: #999900;">target</i>';
                                }else if(process_score > 80){
                                    this.scoreAnalysis[i].msg = '<i style="color:green;">above target</i>';
                                }
                                number_de_correct_answers = 0;
                            }
                            // delete unused process groups from the object..
                            for(i in this.scoreAnalysis){
                                if(this.scoreAnalysis[i].count == 0){
                                    delete this.scoreAnalysis[i];
                                }

                            }

                            // generate the analysis with jquery ..
                            
                            
                            r = $("#result");
                            html_ = '';
                            for(var k in this.scoreAnalysis){
                                if(this.scoreAnalysis.hasOwnProperty(k)){
                                    html_ += '<h4>'+k+' :</h4><h5>'+this.scoreAnalysis[k].msg+'</h5><table class="table table-bordered table-hover"><thead><th>Question No.</th><th>Score</th></thead><tbody>';
                                    this.scoreAnalysis[k].data.forEach(x => {
                                        if(x.q_score == 1){
                                            html_ += '<tr><td>'+x.q_num+'</td><td><i class="fa fa-check" style="color:green"></i></td></tr>';
                                        }else{
                                            html_ += '<tr><td>'+x.q_num+'</td><td><i class="fa fa-times" style="color: red"></i></td></tr>';
                                        }
                                    });
                                    html_ += '</tbody></table>';
                                    r.append(html_);
                                    html_ = '';
                                }
                            }


                            this.make_exam.taken = 1;
                            this.make_exam.text = 'Your Score';
                        
                            this.selectCorrectAnswer();

                            $("#feedback_btn").show();
                            $("#result").show();
                        }
                    }
                },
                return_to_quiz: function(){
                    $("#result").hide();
                    $("#quiz").show();
                },
                flagMe: function(){
                    located = 0;
                    this.flaged.forEach(ele => {
                        if(ele == this.current_question_number)
                        {
                            //remove from array
                            this.flaged.splice(this.flaged.indexOf(this.current_question_number), 1);
                            located = 1;
                        }
                    });
                    if(located == 0 ){
                        // add it to array
                        this.flaged.push(this.current_question_number);                        
                    }
                    // add color,
                    this.colorMyflag();
                },
                colorMyflag:function(){
                    located = 0;
                    this.flaged.forEach(ele => {
                        if(ele == this.current_question_number){
                            //color to red 
                            $("#flag").css('color','red');
                            located =1;
                        }
                    });
                    if(located ==  0)
                    {
                        $("#flag").css('color','gray');
                    }
                }

            }
        });
    </script>



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
