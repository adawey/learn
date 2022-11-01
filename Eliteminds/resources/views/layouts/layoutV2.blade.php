@php
    $thisUser = Auth::user();
    $userCourses = Cache::remember('userCoursesCached'.$thisUser->id, 300, function()use($thisUser){
        return \Illuminate\Support\Facades\DB::table('user_packages')
            ->where('user_packages.user_id', '=', $thisUser->id)
            ->join('packages', 'user_packages.package_id', '=', 'packages.id')
            ->join('courses', 'packages.course_id', '=', 'courses.id')
            ->select(
                'courses.id',
                'courses.title'
            )
            ->groupBy('courses.id')
            ->get();
    });
@endphp
<!DOCTYPE html>
<html
        lang="en"
        data-footer="true"
        data-override='{"attributes": {"placement": "vertical","layout": "boxed", "behaviour": "unpinned" }, "storagePrefix": "elearning-portal"}'
>
<head>
    <meta charset="UTF-8" />
    <title>{{env('APP_NAME')}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="{{env('APP_NAME')}} is E-Learning Web application Built with Love by Mohamed Ahmed At http://misk.com.eg" />
    <meta name="author" content="">
    <!-- Favicon Tags Start -->
    <!--<link rel="apple-touch-icon-precomposed" sizes="57x57" href="{{asset('user-assets/img/favicon/apple-touch-icon-57x57.png')}}" />-->
    <!--<link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{asset('user-assets/img/favicon/apple-touch-icon-114x114.png')}}" />-->
    <!--<link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{asset('user-assets/img/favicon/apple-touch-icon-72x72.png')}}" />-->
    <!--<link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{asset('user-assets/img/favicon/apple-touch-icon-144x144.png')}}" />-->
    <!--<link rel="apple-touch-icon-precomposed" sizes="60x60" href="{{asset('user-assets/img/favicon/apple-touch-icon-60x60.png')}}" />-->
    <!--<link rel="apple-touch-icon-precomposed" sizes="120x120" href="{{asset('user-assets/img/favicon/apple-touch-icon-120x120.png')}}" />-->
    <!--<link rel="apple-touch-icon-precomposed" sizes="76x76" href="{{asset('user-assets/img/favicon/apple-touch-icon-76x76.png')}}" />-->
    <!--<link rel="apple-touch-icon-precomposed" sizes="152x152" href="{{asset('user-assets/img/favicon/apple-touch-icon-152x152.png')}}" />-->
    <!--<link rel="icon" type="image/png" href="{{asset('user-assets/img/favicon/favicon-196x196.png')}}" sizes="196x196" />-->
    <!--<link rel="icon" type="image/png" href="{{asset('user-assets/img/favicon/favicon-96x96.png')}}" sizes="96x96" />-->
    <!--<link rel="icon" type="image/png" href="{{asset('user-assets/img/favicon/favicon-32x32.png')}}" sizes="32x32" />-->
    <!--<link rel="icon" type="image/png" href="{{asset('user-assets/img/favicon/favicon-16x16.png')}}" sizes="16x16" />-->
    <!--<link rel="icon" type="image/png" href="{{asset('user-assets/img/favicon/favicon-128.png')}}" sizes="128x128" />-->
    <!--<meta name="application-name" content="&nbsp;" />-->
    <!--<meta name="msapplication-TileColor" content="#FFFFFF" />-->
    <!--<meta name="msapplication-TileImage" content="img/favicon/mstile-144x144.png')}}" />-->
    <!--<meta name="msapplication-square70x70logo" content="img/favicon/mstile-70x70.png')}}" />-->
    <!--<meta name="msapplication-square150x150logo" content="img/favicon/mstile-150x150.png')}}" />-->
    <!--<meta name="msapplication-wide310x150logo" content="img/favicon/mstile-310x150.png')}}" />-->
    <!--<meta name="msapplication-square310x310logo" content="img/favicon/mstile-310x310.png')}}" />-->
      <link rel="shortcut icon" type="image/x-icon" href="{{asset('index-assets/images/favicon.ico')}}">
    <meta property="og:image" content="{{asset('index-assets/images/favicon.ico')}}" />
    <!-- Favicon Tags End -->
    <!-- Font Tags Start -->
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('user-assets/font/CS-Interface/style.css')}}" />
    <!-- Font Tags End -->
    <!-- Vendor Styles Start -->
    <link rel="stylesheet" href="{{asset('user-assets/css/vendor/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{asset('user-assets/css/vendor/OverlayScrollbars.min.css')}}" />

    <link rel="stylesheet" href="{{asset('user-assets/css/vendor/glide.core.min.css')}}" />

    <!-- Vendor Styles End -->
    <!-- Template Base Styles Start -->
    <link rel="stylesheet" href="{{asset('user-assets/css/styles.css')}}" />
    <!-- Template Base Styles End -->
    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-Z72PZ12XTL"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-Z72PZ12XTL');
</script>

    <link rel="stylesheet" href="{{asset('user-assets/css/main.css')}}" />
    <script src="{{asset('user-assets/js/base/loader.js')}}"></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-128995532-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-128995532-1');
</script>
<style>
       .adawe {
        position: fixed;
        width: 60px;
        height: 60px;
        bottom: 40px;
        right: 40px;
        background-color: #25d366;
        color: #FFF;
        border-radius: 50px;
        text-align: center;
        font-size: 30px;
        box-shadow: 2px 2px 3px #999;
        z-index: 100;
    }

    .adawe2 {
        margin-top: 16px;

    }
</style>
    @yield('head')
</head>

<body>
      <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <a href="https://web.whatsapp.com/send?phone=%+962797205176&text=%D8%A7%D9%84%D8%B3%D9%84%D8%A7%D9%85%20%D8%B9%D9%84%D9%8A%D9%83%D9%85%20&type=phone_number&app_absent=0"
       class="adawe"
       target="_blank">
        <i class="fa fa-whatsapp adawe2"></i>
    </a>
<div id="root">
    <div id="nav" class="nav-container d-flex">
        <div class="nav-content d-flex">
            <!-- Logo Start -->
            <div class="logo position-relative">
                <a href="{{route('index')}}">
                    <!-- Logo can be added directly -->
                    <!-- <img src="{{asset('user-assets/img/logo/logo-white.svg')}}" alt="logo" /> -->

                    <!-- Or added via css to provide different ones for different color themes -->
                    <div class="img"></div>
                </a>
            </div>
            <!-- Logo End -->

            @php
                $profile_pic =asset('user-assets/img/profile/profile-11.jpg');
                if(Auth::check()){
                    if(\App\UserDetail::where('user_id', '=', Auth::user()->id)->get()->first() ){
                        if(\App\UserDetail::where('user_id', '=', Auth::user()->id)->get()->first()->profile_pic){
                            $profile_pic =url('storage/profile_picture/'.basename(\App\UserDetail::where('user_id','=',Auth::user()->id)->get()->first()->profile_pic));
                        }
                    }
                }
            @endphp

            <!-- User Menu Start -->
            <div class="user-container d-flex">
                <a href="#" class="d-flex user position-relative" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="profile" alt="profile" src="{{$profile_pic}}" />
                    <div class="name">{{Auth::user()->name}}</div>
                </a>
                <div class="dropdown-menu dropdown-menu-end user-menu wide">
                    <div class="row mb-1 ms-0 me-0">
                        <div class="col-12 p-1 mb-2 pt-2">
                            <div class="text-extra-small text-primary">Quick Access</div>
                        </div>
                        <div class="col-6 ps-1 pe-1">
                            <ul class="list-unstyled">
                                <li>
                                    <a href="{{route('user.dashboard')}}">Dashboard</a>
                                </li>
                                <li>
                                    <a href="{{route('my.package.view')}}">My Packages</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row mb-1 ms-0 me-0">
                        <div class="col-12 p-1 mb-2 pt-2">
                            <div class="text-extra-small text-primary">ACCOUNT</div>
                        </div>
                        <div class="col-6 pe-1 ps-1">
                            <ul class="list-unstyled">
                                <li>
                                    <a href="#">
                                        <i data-cs-icon="gear" class="me-2" data-cs-size="17"></i>
                                        <span class="align-middle">Settings</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i data-cs-icon="logout" class="me-2" data-cs-size="17"></i>
                                        <span class="align-middle">Logout</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- User Menu End -->

            <!-- Icons Menu Start -->
            <ul class="list-unstyled list-inline text-center menu-icons">
                <li class="list-inline-item">
                    <a href="#" id="pinButton" class="pin-button">
                        <i data-cs-icon="lock-on" class="unpin" data-cs-size="18"></i>
                        <i data-cs-icon="lock-off" class="pin" data-cs-size="18"></i>
                    </a>
                </li>
                <li class="list-inline-item">
                    <a href="#" id="colorButton">
                        <i data-cs-icon="light-on" class="light" data-cs-size="18"></i>
                        <i data-cs-icon="light-off" class="dark" data-cs-size="18"></i>
                    </a>
                </li>
                <li class="list-inline-item">
                    <a href="#" data-bs-toggle="dropdown" data-bs-target="#notifications" aria-haspopup="true" aria-expanded="false" class="notification-button">
                        <div class="position-relative d-inline-flex">
                            <i data-cs-icon="bell" data-cs-size="18"></i>
{{--                            <span class="position-absolute notification-dot rounded-xl"></span>--}}
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end wide notification-dropdown scroll-out" id="notifications">
                        <div class="scroll">
                            <ul class="list-unstyled border-last-none">
                                <li class="pb-3 pb-3 border-bottom border-separator-light d-flex">
                                    <img src="{{asset('user-assets/img/profile/profile-11.jpg')}}" class="me-3 sw-4 sh-4 rounded-xl align-self-center" alt="..." />
                                    <div class="align-self-center">
                                        <a href="#">Welcome To {{env('APP_NAME')}}!</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
            </ul>
            <!-- Icons Menu End -->

            <!-- Menu Start -->
            <div class="menu-container flex-grow-1">
                <ul id="menu" class="menu">
                    <li>
                        <a href="{{route('user.dashboard')}}">
                            <i data-cs-icon="home-garage" class="icon" data-cs-size="18"></i>
                            <span class="label">{{__('User/layout.dashboard')}}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('my.package.view')}}">
                            <i data-cs-icon="online-class" class="icon" data-cs-size="18"></i>
                            <span class="label">{{__('User/layout.my-courses')}}</span>
                        </a>
                    </li>
                    <li>
                        <a href="#studyMaterial">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="cs-icon cs-icon-quiz icon"><path d="M9.63882 4.7609 7.65184 6.7479C7.45657 6.94316 7.13999 6.94316 6.94473 6.74789L6.12803 5.93118M9.63882 8.7609 7.65184 10.7479C7.45657 10.9432 7.13999 10.9432 6.94473 10.7479L6.12803 9.93118M9.63882 12.7609 7.65184 14.7479C7.45657 14.9432 7.13999 14.9432 6.94473 14.7479L6.12803 13.9312M14 6.50003H12.5M14 10.5H12.5M14 14.5H12.5"></path><path d="M3 5.5C3 4.09554 3 3.39331 3.33706 2.88886C3.48298 2.67048 3.67048 2.48298 3.88886 2.33706C4.39331 2 5.09554 2 6.5 2H13.5C14.9045 2 15.6067 2 16.1111 2.33706C16.3295 2.48298 16.517 2.67048 16.6629 2.88886C17 3.39331 17 4.09554 17 5.5V14.5C17 15.9045 17 16.6067 16.6629 17.1111C16.517 17.3295 16.3295 17.517 16.1111 17.6629C15.6067 18 14.9045 18 13.5 18H6.5C5.09554 18 4.39331 18 3.88886 17.6629C3.67048 17.517 3.48298 17.3295 3.33706 17.1111C3 16.6067 3 15.9045 3 14.5V5.5Z"></path></svg>
                            <span class="label">{{__('User/layout.study-material')}}</span>
                        </a>
                        <ul id="studyMaterial">
                            @foreach($userCourses as $c)
                            <li>
                                <a href="{{ route('material.show', $c->id) }}">
                                    <span class="label">{{$c->title}}</span>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </li>
                    <li>
                        <a href="{{route('QuizHistoryShow')}}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="cs-icon cs-icon-destination icon"><path d="M11.5 5L6.25 5C4.73122 5 3.5 6.23122 3.5 7.75V7.75C3.5 9.26878 4.73122 10.5 6.25 10.5L14.25 10.5C15.7688 10.5 17 11.7312 17 13.25V13.25C17 14.7688 15.7688 16 14.25 16L8 16"></path><path d="M15 3.62775C15 1.45741 18 1.45743 18 3.62775 18 4.64119 17.1924 5.44466 16.7623 5.80062 16.608 5.92838 16.3921 5.92838 16.2377 5.80062 15.8077 5.44467 15 4.6412 15 3.62775zM2 15.6277C2 13.4574 5 13.4574 5 15.6277 5 16.6412 4.19236 17.4447 3.76235 17.8006 3.60801 17.9284 3.39207 17.9284 3.23773 17.8006 2.8077 17.4447 2 16.6412 2 15.6277z"></path></svg>
                            <span class="label">Analytics</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('user.feedback.index')}}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-stars" viewBox="0 0 16 16">
                                <path d="M7.657 6.247c.11-.33.576-.33.686 0l.645 1.937a2.89 2.89 0 0 0 1.829 1.828l1.936.645c.33.11.33.576 0 .686l-1.937.645a2.89 2.89 0 0 0-1.828 1.829l-.645 1.936a.361.361 0 0 1-.686 0l-.645-1.937a2.89 2.89 0 0 0-1.828-1.828l-1.937-.645a.361.361 0 0 1 0-.686l1.937-.645a2.89 2.89 0 0 0 1.828-1.828l.645-1.937zM3.794 1.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387A1.734 1.734 0 0 0 4.593 5.69l-.387 1.162a.217.217 0 0 1-.412 0L3.407 5.69A1.734 1.734 0 0 0 2.31 4.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387A1.734 1.734 0 0 0 3.407 2.31l.387-1.162zM10.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732L9.1 2.137a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L10.863.1z"/>
                            </svg>
                            <span class="label mx-2">{{__('User/layout.feedback')}}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('faq.index')}}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-patch-question-fill" viewBox="0 0 16 16">
                                <path d="M5.933.87a2.89 2.89 0 0 1 4.134 0l.622.638.89-.011a2.89 2.89 0 0 1 2.924 2.924l-.01.89.636.622a2.89 2.89 0 0 1 0 4.134l-.637.622.011.89a2.89 2.89 0 0 1-2.924 2.924l-.89-.01-.622.636a2.89 2.89 0 0 1-4.134 0l-.622-.637-.89.011a2.89 2.89 0 0 1-2.924-2.924l.01-.89-.636-.622a2.89 2.89 0 0 1 0-4.134l.637-.622-.011-.89a2.89 2.89 0 0 1 2.924-2.924l.89.01.622-.636zM7.002 11a1 1 0 1 0 2 0 1 1 0 0 0-2 0zm1.602-2.027c.04-.534.198-.815.846-1.26.674-.475 1.05-1.09 1.05-1.986 0-1.325-.92-2.227-2.262-2.227-1.02 0-1.792.492-2.1 1.29A1.71 1.71 0 0 0 6 5.48c0 .393.203.64.545.64.272 0 .455-.147.564-.51.158-.592.525-.915 1.074-.915.61 0 1.03.446 1.03 1.084 0 .563-.208.885-.822 1.325-.619.433-.926.914-.926 1.64v.111c0 .428.208.745.585.745.336 0 .504-.24.554-.627z"/>
                            </svg>
                            <span class="label mx-2">{{__('User/layout.faq')}}</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lock-fill" viewBox="0 0 16 16">
                                <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
                            </svg>
                            <span class="label mx-2">{{__('User/layout.sign-out')}}</span>
                        </a>
                    </li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>

                </ul>
            </div>
            <!-- Menu End -->

            <!-- Mobile Buttons Start -->
            <div class="mobile-buttons-container">
                <!-- Scrollspy Mobile Button Start -->
                <a href="#" id="scrollSpyButton" class="spy-button" data-bs-toggle="dropdown">
                    <i data-cs-icon="menu-dropdown"></i>
                </a>
                <!-- Scrollspy Mobile Button End -->

                <!-- Scrollspy Mobile Dropdown Start -->
                <div class="dropdown-menu dropdown-menu-end" id="scrollSpyDropdown"></div>
                <!-- Scrollspy Mobile Dropdown End -->

                <!-- Menu Button Start -->
                <a href="#" id="mobileMenuButton" class="menu-button">
                    <i data-cs-icon="menu"></i>
                </a>
                <!-- Menu Button End -->
            </div>
            <!-- Mobile Buttons End -->
        </div>
        <div class="nav-shadow"></div>
    </div>


    <!-- Content Goes here -->
    <main>
        @include('include.msg')
        @yield('content')
    </main>
    <!-- Content Ends here -->

    <!-- Layout Footer Start -->
    <footer>
        <div class="footer-content">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <p class="mb-0 text-muted text-medium"><p>© {{ date("Y") }} <strong>{{env('APP_NAME')}}</strong>. {{__('User/layout.right-statement')}}</p></p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Layout Footer End -->
</div>

<!-- Vendor Scripts Start -->
<script src="{{asset('user-assets/js/vendor/jquery-3.5.1.min.js')}}"></script>
<script src="{{asset('user-assets/js/vendor/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('user-assets/js/vendor/OverlayScrollbars.min.js')}}"></script>
<script src="{{asset('user-assets/js/vendor/autoComplete.min.js')}}"></script>
<script src="{{asset('user-assets/js/vendor/clamp.min.js')}}"></script>

<script src="{{asset('user-assets/js/vendor/glide.min.js')}}"></script>

<script src="{{asset('user-assets/js/vendor/Chart.bundle.min.js')}}"></script>

<script src="{{asset('user-assets/js/vendor/jquery.barrating.min.js')}}"></script>

<!-- Vendor Scripts End -->

<!-- Template Base Scripts Start -->
<script src="{{asset('user-assets/font/CS-Line/csicons.min.js')}}"></script>
<script src="{{asset('user-assets/js/base/helpers.js')}}"></script>
<script src="{{asset('user-assets/js/base/globals.js')}}"></script>
<script src="{{asset('user-assets/js/base/nav.js')}}"></script>
<script src="{{asset('user-assets/js/base/search.js')}}"></script>
<script src="{{asset('user-assets/js/base/settings.js')}}"></script>
<script src="{{asset('user-assets/js/base/init.js')}}"></script>
<!-- Template Base Scripts End -->
<!-- Page Specific Scripts Start -->
<script src="{{asset('user-assets/js/cs/glide.custom.js')}}"></script>
<script src="{{asset('user-assets/js/cs/charts.extend.js')}}"></script>
<script src="{{asset('user-assets/js/pages/dashboard.elearning.js')}}"></script>
<script src="{{asset('user-assets/js/common.js')}}"></script>
<script src="{{asset('user-assets/js/scripts.js')}}"></script>
<!-- Page Specific Scripts End -->

@yield('jscode')
</body>
</html>
