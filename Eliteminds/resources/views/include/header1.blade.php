<header class="header header-transparent uk-light" uk-sticky="top:20 ; cls-active:header-sticky ; cls-inactive: uk-light" style="z-index: 999999;">

    <div class="container">
        <div id="main-menu"  class="main-menu-container" style="padding:0 !important; padding-top:5px !important; background-color: #3659A2 !important; top:0;left:0; height:70px;">
            <div  class="main-menu">
                <div class="container">
                    <div class="navbar-default">
                        <div class="navbar-header float-left">
                            <a class="navbar-brand text-uppercase" href="#">
                                <img src="{{asset('indexassets/img/logo/pmlogo2.png')}}" alt="logo">
                            </a>
                        </div><!-- /.navbar-header -->
                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <nav class="navbar-menu float-right">
                            <div class="nav-menu ul-li">
                                <ul>
                                    <li class="menu-item-has-children ul-li-block">
                                        <a href="{{route('index')}}">{{__('Public/header.home')}}</a>
                                    </li>
                                    <li><a href="{{route('index')}}#about-us">{{__('Public/header.about-us')}}</a></li>
                                    <li class="menu-item-has-children ul-li-block">
                                        <a href="#!">{{__('Public/header.all-courses')}}</a>
                                        <ul class="sub-menu">
                                            @foreach(\App\Course::where('private', 0)->get() as $c)
                                                <li><a href="{{route('package.by.course').'?course_id='.$c->id}}">{{Transcode::evaluate($c)['title']}}</a></li>
                                            @endforeach
                                        </ul>
                                    </li>
                                    @if(Auth::guard('web')->check())
                                        <li><a href="{{route('my.package.view', ['all', 'all'])}}">{{__('Public/header.my-courses')}}</a></li>
                                        <li><a href="{{route('user.dashboard')}}">{{__('Public/header.my-dashboard')}}</a></li>
                                        <li><a href="{{ route('logout') }}"
                                               onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                                {{ __('Public/header.logout') }}
                                            </a></li>
                                    @elseif(Auth::guard('admin')->check())
                                        <li><a  href="{{route('admin.dashboard')}}">{{__('Public/header.dashboard')}}</a></li>
                                        <li><a href="{{ route('logout') }}"
                                               onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                                {{ __('Public/header.logout') }}
                                            </a></li>
                                    @else
                                        <li><a  href="{{route('login')}}" uk-toggle>{{__('Public/header.login')}}</a></li>
                                        <li><a  href="{{route('register')}}" uk-toggle>{{__('Public/header.sign-up')}} </a></li>
                                    @endif
                                    <li class="menu-item-has-children ul-li-block">
                                        <a href="#!">{{__('general.language')}}</a>
                                        <ul class="sub-menu">

                                            <li><a href="{{ route('set.localization', 'en') }}">English</a></li>
                                            <li><a href="{{ route('set.localization', 'ar') }}">العربية</a></li>
                                            <li><a href="{{ route('set.localization', 'fr') }}">Français</a></li>

                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </nav>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <div class="mobile-menu">
                            <div class="logo"><a href="{{route('index')}}"><img src="{{asset('indexassets/img/logo/logo.png')}}" alt="Logo"></a></div>
                            <nav>
                                <ul>
                                    <li><a href="{{route('index')}}">Home</a>
                                    </li>
                                </ul>
                            </nav>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- container  / End -->

</header>
