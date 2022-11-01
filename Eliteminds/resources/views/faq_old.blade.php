<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FAQ Page</title>

    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{asset('indexassets/css/owl.carousel.css')}}">
    <link rel="stylesheet" href="{{asset('indexassets/css/fontawesome-all.css')}}">
    <link rel="stylesheet" href="{{asset('indexassets/css/flaticon.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('indexassets/css/meanmenu.css')}}">
    <link rel="stylesheet" href="{{asset('indexassets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('indexassets/css/video.min.css')}}">
    <link rel="stylesheet" href="{{asset('indexassets/css/lightbox.css')}}">
    <link rel="stylesheet" href="{{asset('indexassets/css/progess.css')}}">
    <link rel="stylesheet" href="{{asset('indexassets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('indexassets/css/responsive.css')}}">
    <link rel="stylesheet"  href="{{asset('indexassets/css/colors/switch.css')}}">
    <link href="{{asset('indexassets/css/colors/color-2.css')}}" rel="alternate stylesheet" type="text/css" title="color-2">
    <link href="{{asset('indexassets/css/colors/color-3.css')}}" rel="alternate stylesheet" type="text/css" title="color-3">
    <link href="{{asset('indexassets/css/colors/color-4.css')}}" rel="alternate stylesheet" type="text/css" title="color-4">
    <link href="{{asset('indexassets/css/colors/color-5.css')}}" rel="alternate stylesheet" type="text/css" title="color-5">
    <link href="{{asset('indexassets/css/colors/color-6.css')}}" rel="alternate stylesheet" type="text/css" title="color-6">
    <link href="{{asset('indexassets/css/colors/color-7.css')}}" rel="alternate stylesheet" type="text/css" title="color-7">
    <link href="{{asset('indexassets/css/colors/color-8.css')}}" rel="alternate stylesheet" type="text/css" title="color-8">
    <link href="{{asset('indexassets/css/colors/color-9.css')}}" rel="alternate stylesheet" type="text/css" title="color-9">
</head>

<body>
<div id="preloader"></div>
<div id="switch-color" class="color-switcher">
    <div class="open"><i class="fas fa-cog fa-spin"></i></div>
    <h4>COLOR OPTION</h4>
    <ul>
        <li><a class="color-2" onclick="setActiveStyleSheet('color-2'); return true;" href="#!"><i class="fas fa-circle"></i></a> </li>
        <li><a class="color-3" onclick="setActiveStyleSheet('color-3'); return true;" href="#!"><i class="fas fa-circle"></i></a> </li>
        <li><a class="color-4" onclick="setActiveStyleSheet('color-4'); return true;" href="#!"><i class="fas fa-circle"></i></a> </li>
        <li><a class="color-5" onclick="setActiveStyleSheet('color-5'); return true;" href="#!"><i class="fas fa-circle"></i></a> </li>
        <li><a class="color-6" onclick="setActiveStyleSheet('color-6'); return true;" href="#!"><i class="fas fa-circle"></i></a> </li>
        <li><a class="color-7" onclick="setActiveStyleSheet('color-7'); return true;" href="#!"><i class="fas fa-circle"></i></a> </li>
        <li><a class="color-8" onclick="setActiveStyleSheet('color-8'); return true;" href="#!"><i class="fas fa-circle"></i></a> </li>
        <li><a class="color-9" onclick="setActiveStyleSheet('color-9'); return true;" href="#!"><i class="fas fa-circle"></i></a> </li>
    </ul>
    <button class="switcher-light">WIDE </button>
    <button class="switcher-dark">BOX </button>
    <a class="rtl-v" href="RTL_Genius/index.html">RTL </a> </div>

<!-- Start of Header section
		============================================= -->
<!--<header>-->
<!--    <div id="main-menu"  class="main-menu-container">-->
<!--        <div  class="main-menu">-->
<!--            <div class="container">-->
<!--                <div class="navbar-default">-->
<!--                    <div class="navbar-header float-left"> <a class="navbar-brand text-uppercase" href="#">-->
<!--                            <img src="{{asset('indexassets/img/logo/pmlogo2.png')}}" alt="logo" style="width: 250 px;height: 50px"></a> </div>-->
<!--                    <div class="log-in float-right">-->
                        <!-- The Modal -->
<!--                        <div class="modal fade" id="myModal1" tabindex="-2" role="dialog" aria-hidden="true">-->
<!--                            <div class="modal-dialog">-->
<!--                                <div class="modal-content">-->

                                    <!-- Modal Header -->
<!--                                    <div class="modal-header backgroud-style">-->
<!--                                        <div class="gradient-bg"></div>-->
<!--                                        <div class="popup-logo"> <img src="indexassets/img/logo/p-logo.jpg" alt=""> </div>-->
<!--                                        <div class="popup-text text-center">-->
<!--                                            <h2> <span>Sign Up and Start Learning!</span></h2>-->
<!--                                        </div>-->
<!--                                    </div>-->


<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->


<!--                    <nav class="navbar-menu float-right">-->
<!--                        <div class="nav-menu ul-li">-->
<!--                            <ul>-->
<!--                                <li><a href="{{route('index')}}">Home</a></li>-->
<!--                                <li><a href="{{route('index')}}#search-course">Course</a></li>-->

<!--                                <li class="menu-item-has-children ul-li-block">-->
<!--                                    <a href="">Free Resource</a>-->
<!--                                    <ul class="sub-menu">-->
<!--                                        <li><a href="{{route('FreeQuiz')}} ">Free Exam</a></li>-->
<!--                                        <li><a href="{{route('FreeVideo')}}"> Free Video</a></li>-->

<!--                                    </ul>-->
<!--                                </li>-->
<!--                                <li><a href="{{route('reviews')}}">Review</a></li>-->
<!--                                <li><a href="{{route('index')}}#faq">faq</a></li>-->
<!--                                <li><a href="{{route('index')}}#contact-area">Contact Us</a></li>-->
<!--                                @if(Auth::guard('web')->check())-->
<!--                                    <li><a href="{{route('user.dashboard')}}" title="dashboard">Dashboard</a></li>-->

<!--                                @elseif(Auth::guard('admin')->check())-->
<!--                                    <li><a href="{{route('admin.dashboard')}}" title="dashboard">Dashboard</a></li>-->
<!--                                @else-->
<!--                                    <li><a href="{{route('login')}}">Login</a></li>-->
<!--                                    <li><a href="{{route('register')}}" title="signup">Sign Up</a></li>-->
<!--                                @endif-->
<!--                            </ul>-->
<!--                        </div>-->
<!--                    </nav>-->
                    <!--start mobile-menu-->
<!--                    <div class="mobile-menu">-->
<!--                        <div class="logo"><a href="#"><img src="{{asset('indexassets/img/logo/pmlogo2.png')}}" alt="Logo"></a></div>-->
<!--                        <nav>-->
<!--                            <ul>-->
<!--                                <li><a href="{{route('index')}}">Home</a></li>-->
<!--                                <li><a href="{{route('index')}}#search-course">Course</a></li>-->

<!--                                <li class="menu-item-has-children ul-li-block">-->
<!--                                    <a href="">Free Resource</a>-->
<!--                                    <ul class="sub-menu">-->
<!--                                        <li><a href="{{route('FreeQuiz')}} ">Free Exam</a></li>-->
<!--                                        <li><a href="{{route('FreeVideo')}}"> Free Video</a></li>-->

<!--                                    </ul>-->
<!--                                </li>-->
<!--                                <li><a href="{{route('reviews')}}">Review</a></li>-->
<!--                                <li><a href="{{route('index')}}#faq">faq</a></li>-->
<!--                                <li><a href="{{route('index')}}#contact-area">Contact Us</a></li>-->
<!--                                @if(Auth::guard('web')->check())-->
<!--                                    <li><a href="{{route('user.dashboard')}}" title="dashboard">Dashboard</a></li>-->

<!--                                @elseif(Auth::guard('admin')->check())-->
<!--                                    <li><a href="{{route('admin.dashboard')}}" title="dashboard">Dashboard</a></li>-->
<!--                                @else-->
<!--                                    <li><a href="{{route('login')}}">Login</a></li>-->
<!--                                    <li><a href="{{route('register')}}" title="signup">SignUp</a></li>-->
<!--                                @endif-->
<!--                            </ul>-->
<!--                        </nav>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</header>-->
<!-- Start of Header section
 		============================================= -->

<!-- Start of breadcrumb section
		============================================= -->
<section id="breadcrumb" class="breadcrumb-section relative-position backgroud-style">
    <div class="blakish-overlay"></div>
    <div class="container">
        <div class="page-breadcrumb-content text-center">
            <div class="page-breadcrumb-title">
                <h2 class="breadcrumb-head black bold">Frequently <span>Ask & Questions</span></h2>
            </div>
            <div class="page-breadcrumb-item ul-li">
                <ul class="breadcrumb text-uppercase black">
                    <li class="breadcrumb-item"><a href="{{route('index')}}">Home</a></li>
                    <li class="breadcrumb-item active">FAQ</li>
                </ul>
            </div>
        </div>
    </div>
</section>
<!-- End of breadcrumb section
		============================================= -->

<!-- Start FAQ section
		============================================= -->
<section id="faq-page" class="faq-page-section">
    <div class="container">
        <div class="faq-element">
            <div class="row">
                <div class="col-md-12">
                    <div class="faq-page-tab">
                        <div class="section-title-2 mb65 headline text-left">
                            <h2>Find <span>Your Questions & Answers.</span></h2>
                        </div>
                        <div class="faq-tab faq-secound-home-version mb35">
                            <div class="faq-tab-ques  ul-li">
                                <!--
                                                        <div class="tab-button text-left mb45">
                                                            <ul class="product-tab">
                                                                <li class="active" rel="tab1">GENERAL </li>
                                                            </ul>
                                                        </div>
                -->
                                <!-- /tab-head -->

                                <!-- tab content -->
                                <!--
                                                        <div class="tab-container">

                                                            <div  class="tab-content-1 pt150" style="padding:0 !important;">
                                                                <div id="accordion-2"  class="panel-group">
                                                                    <div class="col-15" style="margin-left:0 !important;">
                                                                        <div class="panel-title col-12" id="headingSix">
                                                                            <h3 class="mb-0">
                                                                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseSix" aria-expanded="true" aria-controls="collapseSix" style="width:100%; padding-right:15px;">
                                                                                    What is PMP Certification?
                                                                        </button>
                                                                            </h3>
                                                                        </div>
                                                                        <div id="collapseSix" class="collapse show col-12" aria-labelledby="headingSix" data-parent="#accordion-2">
                                                                            <div class="panel-body">
                                                                                PMP stands for Project Management Professional (PMP). PMP Certification, offered by the Project Management Institute (PMI), is an industry-recognized credential for project managers. PMP certification demonstrates the project manager's experience, knowledge, skills, and competencies required to lead and direct projects.
                                                                            </div>
                                                                        </div>
                                                                    </div>


                                                                </div>
                                                                <hr>
                                                                 end of #accordion

                                                            </div>




                                                            </div>
                -->

                                <div id="tab2" class="tab-content-1 pt35" style="padding:0 !important;">
                                    <div id="accordion-2" class="panel-group">


                                        @foreach(\App\FAQ::orderBy('created_at', 'desc')->get() as $f)
                                            <div class=" col-15" >
                                                <div class="panel-title " id="heading11">
                                                    <h3 class="mb-0">
                                                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse{{$f->id}}" aria-expanded="true" aria-controls="collapse11" >{{Transcode::evaluate($f)['title']}} </button>
                                                    </h3>
                                                </div>
                                                <div id="collapse{{$f->id}}" class="collapse" aria-labelledby="heading11" data-parent="#accordion-2">
                                                    <div class="panel-body"> {!!Transcode::evaluate($f)['contant']!!} </div>
                                                </div>
                                            </div>
                                            <hr>
                                        @endforeach
                                    </div>
                                    <!-- end of #accordion -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End FAQ section
		============================================= -->

<!-- Start of recent view product
		============================================= -->

<!-- End of recent view product
		============================================= -->

<!-- Start of footer section
		============================================= -->
<footer>
    <section id="footer-area" class="footer-area-section">
        <div class="container">

            <!-- /footer-widget-content -->

            <div class="copy-right-menu">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="copy-right-text">
                                <p>© 2019 - {{date("Y")}} <u>{{env('APP_NAME')}}</u> All rights reserved - Powered By <a href="http://marvelits.com" target="_blank"><u>MiskIt</u></a></p>
                            </div>
                            
                            
                        </div>
                        <div class="col-md-6">
                            <div class="copy-right-menu-item float-right ul-li">
                                <ul>
                                    <li><a href="{{route('terms.show.public')}}">Term Of Service</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </section>
</footer>
<!-- End of footer section
		============================================= -->

<!-- For Js Library -->
<script src="{{asset('indexassets/js/jquery-2.1.4.min.js')}}"></script>
<script src="{{asset('indexassets/js/bootstrap.min.js')}}"></script>
<script src="{{asset('indexassets/js/popper.min.js')}}"></script>
<script src="{{asset('indexassets/js/owl.carousel.min.js')}}"></script>
<script src="{{asset('indexassets/js/jarallax.js')}}"></script>
<script src="{{asset('indexassets/js/jquery.magnific-popup.min.js')}}"></script>
<script src="{{asset('indexassets/js/lightbox.js')}}"></script>
<script src="{{asset('indexassets/js/jquery.meanmenu.js')}}"></script>
<script src="{{asset('indexassets/js/scrollreveal.min.js')}}"></script>
<script src="{{asset('indexassets/js/jquery.counterup.min.js')}}"></script>
<script src="{{asset('indexassets/js/waypoints.min.js')}}"></script>
<script src="{{asset('indexassets/js/jquery-ui.js')}}"></script>
<script src="{{asset('indexassets/js/gmap3.min.js')}}"></script>
<script src="{{asset('indexassets/js/switch.js')}}"></script>
<script src="http://maps.google.com/maps/api/js?key=AIzaSyC61_QVqt9LAhwFdlQmsNwi5aUJy9B2SyA"></script>
<script src="{{asset('indexassets/js/script.js')}}"></script>
</body>
</html>
