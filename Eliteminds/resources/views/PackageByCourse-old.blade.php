<!doctype html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	
	<title>Course Page</title>

	@if(app()->getLocale() == 'ar')
	<style>
		tr th, tr td, .text-capitalize, .filter-select label
		, .course-title h3, .text-goes-right{
			text-align: right !important;
		}
		@font-face {
			font-family: 'Tajawal';
			src: URL('{{asset('fonts/tajawal/Tajawal-Regular.ttf')}}') format('truetype');
		}
		html, body, span{
			font-family: Tajawal !important;
		}
	</style>
	@endif
  <!-- Mobile Specific Meta -->
  <link rel="icon" href="{{asset('img/pmplearning.jpg')}}">
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

<body {{app()->getLocale() == 'en'? '':'dir=rtl'}}>

	<div id="preloader"></div>



	<!-- Start of Header section
		============================================= -->
		<header>
		 <div id="main-menu"  class="main-menu-container">
    <div  class="main-menu">
      <div class="container">
        <div class="navbar-default" style="display:flex; justify-content:space-between;">
          <div class="navbar-header float-left"> <a class="navbar-brand text-uppercase" href="#">
          <img src="{{asset('indexassets/img/logo/pmlogo2.png')}}" alt="logo" style="width: 250 px;height: 50px"></a> </div>

			<nav class="navbar-menu float-right">
				<div class="nav-menu ul-li">
					<ul>
						<li><a href="{{route('index')}}">{{__('Public/package-by-course.home')}}</a></li>
						<li><a href="{{route('index')}}#search-course">{{__('Public/package-by-course.courses')}}</a></li>

						<li class="menu-item-has-children ul-li-block">
							<a href="">{{__('Public/package-by-course.free-resources')}}</a>
							<ul class="sub-menu">
								<li><a href="{{route('FreeQuiz')}} ">{{__('Public/package-by-course.free-exam')}}</a></li>
								<li><a href="{{route('FreeVideo')}}">{{__('Public/package-by-course.free-video')}}</a></li>

							</ul>
						</li>
						<li><a href="{{route('reviews')}}">{{__('Public/package-by-course.reviews')}}</a></li>
						<li><a href="{{route('index')}}#faq">{{__('Public/package-by-course.faqs')}}</a></li>
						<li><a href="{{route('index')}}#contact-area">{{__('Public/package-by-course.contact-us')}}</a></li>
						@if(Auth::guard('web')->check())
							<li><a href="{{route('user.dashboard')}}" title="dashboard">{{__('Public/package-by-course.dashboard')}}</a></li>

						@elseif(Auth::guard('admin')->check())
							<li><a href="{{route('admin.dashboard')}}" title="dashboard">{{__('Public/package-by-course.dashboard')}}</a></li>
						@else
							<li><a href="{{route('login')}}">{{__('Public/package-by-course.login')}}</a></li>
							<li><a href="{{route('register')}}" title="signup">{{__('Public/package-by-course.sign-up')}}</a></li>
						@endif
						<li ><a  href="{{ route('set.localization', app()->getLocale() == 'en'? 'ar': 'en') }}"> {{app()->getLocale() == 'en' ? 'العربية':'English'}} </a></li>
					</ul>
				</div>
			</nav>
			<!--start mobile-menu-->
			<div class="mobile-menu">
				<div class="logo"><a href="#"><img src="{{asset('indexassets/img/logo/pmlogo2.png')}}" alt="Logo"></a></div>
				<nav>
					<ul>
						<li><a href="{{route('index')}}">{{__('Public/package-by-course.home')}}</a></li>
						<li><a href="{{route('index')}}#search-course">{{__('Public/package-by-course.courses')}}</a></li>

						<li class="menu-item-has-children ul-li-block">
							<a href="">{{__('Public/package-by-course.free-resources')}}</a>
							<ul class="sub-menu">
								<li><a href="{{route('FreeQuiz')}} ">{{__('Public/package-by-course.free-exam')}}</a></li>
								<li><a href="{{route('FreeVideo')}}">{{__('Public/package-by-course.free-video')}}</a></li>

							</ul>
						</li>
						<li><a href="{{route('reviews')}}">{{__('Public/package-by-course.review')}}</a></li>
						<li><a href="{{route('index')}}#faq">{{__('Public/package-by-course.faqs')}}</a></li>
						<li><a href="{{route('index')}}#contact-area">{{__('Public/package-by-course.contact-us')}}</a></li>
						@if(Auth::guard('web')->check())
							<li><a href="{{route('user.dashboard')}}" title="dashboard">{{__('Public/package-by-course.dashboard')}}</a></li>

						@elseif(Auth::guard('admin')->check())
							<li><a href="{{route('admin.dashboard')}}" title="dashboard">{{__('Public/package-by-course.dashboard')}}</a></li>
						@else
							<li><a href="{{route('login')}}">{{__('Public/package-by-course.login')}}</a></li>
							<li><a href="{{route('register')}}" title="signup">{{__('Public/package-by-course.sign-up')}}</a></li>
						@endif
						<li ><a  href="{{ route('set.localization', app()->getLocale() == 'en'? 'ar': 'en') }}"> {{app()->getLocale() == 'en' ? 'العربية':'English'}} </a></li>
					</ul>
				</nav>
			</div>
        </div>
      </div>
    </div>
  </div>
		</header>
 	<!-- Start of Header section
 		============================================= --> 


	<!-- Start of breadcrumb section
		============================================= -->
		<section id="breadcrumb" class="breadcrumb-section relative-position backgroud-style">
			<div class="blakish-overlay"></div>
			<div class="container">
				<div class="page-breadcrumb-content text-center">
					<div class="page-breadcrumb-title">
						<h2 class="breadcrumb-head black bold">PM <span>tricks</span></h2>
					</div>
					<div class="page-breadcrumb-item ul-li">
						<ul class="breadcrumb text-uppercase black">
							<li class="breadcrumb-item"><a href="{{route('index')}}">{{__('Public/package-by-course.home')}}</a></li>
							<li class="breadcrumb-item active">{{__('Public/package-by-course.courses')}}</li>
						</ul>
					</div>
				</div>
			</div>
		</section>
	<!-- End of breadcrumb section
		============================================= -->


	<!-- Start of course section
		============================================= -->
		<section id="course-page" class="course-page-section">
			<div class="container">
				<div class="row">
					<div class="col-md-9">
						<div class="short-filter-tab">
							
							<div class="tab-button blog-button ul-li text-center float-right">
								<ul class="product-tab">
									<li class="active" rel="tab1"><i class="fas fa-th"></i></li>
									<li rel="tab2"> <i class="fas fa-list"></i></li>
								</ul>
							</div>
							
						</div>
						<div class="text-goes-right">
						    {{__('Public/package-by-course.online-self-study')}}
    					</div>
    
                        <hr>

						<div class="genius-post-item">
							<div class="tab-container">
								<div id="tab1" class="tab-content-1 pt35">
									<div class="best-course-area best-course-v2">
										<div class="row">
                                        @foreach($best_sell as $i)
											<div class="col-md-4">
												<div class="best-course-pic-text relative-position">
													<div class="best-course-pic relative-position">
                                                        <img src="{{ url('storage/package/imgs/'.basename($i->package->img))}}" alt="">
                                                        @if($i->users_no >= 400)
														<div class="trend-badge-2 text-center text-uppercase">
															<i class="fas fa-bolt"></i>
															<span>{{__('Public/package-by-course.trending')}}</span>
                                                        </div>
                                                        @endif
{{--														<div class="course-price text-center gradient-bg">--}}
{{--															<span>@if($i->package->discount > 0)--}}
{{--																	<i style=" color: red; text-decoration: line-through;">{{round($i->package->original_price, 2) }}$</i>  |--}}
{{--																	@endif--}}
{{--																	</span>--}}
{{--																	<span class="widget-thumb-body-stat">--}}
{{--																	@if($i->package->price > 0)--}}
{{--																		{{$i->package->price}} $--}}
{{--																	@else --}}
{{--																		Free--}}
{{--																	@endif	</span>--}}
{{--														</div>--}}
														<div class="course-rate ul-li">
															<ul>
																<li style="@if($i->total_rate < 1)color:black !important;@endif"><i class="fas fa-star"></i></li>
																<li style="@if($i->total_rate < 2)color:black !important;@endif"><i class="fas fa-star"></i></li>
																<li style="@if($i->total_rate < 3)color:black !important;@endif"><i class="fas fa-star"></i></li>
																<li style="@if($i->total_rate < 4)color:black !important;@endif"><i class="fas fa-star"></i></li>
																<li style="@if($i->total_rate < 5)color:black !important;@endif"><i class="fas fa-star"></i></li>
															</ul>
														</div>
														<div class="course-details-btn">
															<a href="{{route('public.package.view', $i->package->id)}}">{{__('Public/package-by-course.course-detail')}} <i class="fas fa-arrow-right"></i></a>
														</div>
														<div class="blakish-overlay"></div>
													</div>
													<div class="best-course-text">
														<div class="course-title mb20 headline relative-position">
															<h3><a href="{{route('public.package.view', $i->package->id)}}">{{Transcode::evaluate($i->package)['name'] }}</a></h3>
														</div>
														<div class="course-meta">
															<span class="course-category"><a href="{{route('public.package.view', $i->package->id)}}">{{Transcode::evaluate(\App\Course::find(Illuminate\Support\Facades\Input::get('course_id')))['title']}}</a></span>
															{{--<span class="course-author"><a href="#">{{$i->users_no}} Students</a></span> --}}
														</div>
													</div>
												</div>
											</div>
											<!-- /course -->
                      @endforeach
											
										</div>
                                        <hr>
										<div class="text-goes-right">
											{{__('Public/package-by-course.online-interactive-courses')}}
										</div>

                                        <hr>
                                        <div class="row">

                                            @foreach($best_sell_event as $i)
                                                <div class="col-md-4">
                                                    <div class="best-course-pic-text relative-position">
                                                        <div class="best-course-pic relative-position">
                                                            <img src="{{ url('storage/events/'.basename($i->event->img))}}" alt="">
                                                            @if($i->users_no >= 400)
                                                                <div class="trend-badge-2 text-center text-uppercase">
                                                                    <i class="fas fa-bolt"></i>
                                                                    <span>{{__('Public/package-by-course.trending')}}</span>
                                                                </div>
                                                            @endif
{{--                                                            <div class="course-price text-center gradient-bg">--}}
{{--																<span>--}}
{{--																	@if($i->event->discount > 0)--}}
{{--																		<i style=" color: red; text-decoration: line-through;">{{round($i->event->original_price, 2) }}$</i>  |--}}
{{--																	@endif--}}
{{--																</span>--}}
{{--																<span class="widget-thumb-body-stat">--}}
{{--																	@if($i->event->price > 0)--}}
{{--																		{{$i->event->price}} $--}}
{{--																	@else--}}
{{--																		Free--}}
{{--																	@endif	--}}
{{--																</span>--}}
{{--                                                            </div>--}}
                                                            <div class="course-rate ul-li">
                                                                <ul>
                                                                    <li style="@if($i->total_rate < 1)color:black !important;@endif"><i class="fas fa-star"></i></li>
                                                                    <li style="@if($i->total_rate < 2)color:black !important;@endif"><i class="fas fa-star"></i></li>
                                                                    <li style="@if($i->total_rate < 3)color:black !important;@endif"><i class="fas fa-star"></i></li>
                                                                    <li style="@if($i->total_rate < 4)color:black !important;@endif"><i class="fas fa-star"></i></li>
                                                                    <li style="@if($i->total_rate < 5)color:black !important;@endif"><i class="fas fa-star"></i></li>
                                                                </ul>
                                                            </div>
                                                            <div class="course-details-btn">
                                                                <a href="{{route('public.event.view', $i->event->id)}}">{{__('Public/package-by-course.course-detail')}} <i class="fas fa-arrow-right"></i></a>
                                                            </div>
                                                            <div class="blakish-overlay"></div>
                                                        </div>
                                                        <div class="best-course-text">
                                                            <div class="course-title mb20 headline relative-position">
                                                                <h3><a href="{{route('public.event.view', $i->event->id)}}">{{Transcode::evaluate($i->event)['name'] }}</a></h3>
                                                            </div>
                                                            <div class="course-meta">
                                                                <span class="course-category"><a href="{{route('public.event.view', $i->event->id)}}">{{Transcode::evaluate(\App\Course::find(Illuminate\Support\Facades\Input::get('course_id')))['title']}}</a></span>
                                                                <span class="course-author"><a href="#">{{$i->users_no}} {{__('Public/package-by-course.student')}}</a></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
									</div>
								</div><!-- /tab-1 -->

								<div id="tab2" class="tab-content-1">
									<div class="course-list-view">
										<table style="text-align: right;">
											<tr class="list-head">
												<th>{{__('Public/package-by-course.course-name')}}</th>
												<th>{{__('Public/package-by-course.course-type')}}</th>
												<th>{{__('Public/package-by-course.access')}}</th>
											</tr>
											
											@foreach($best_sell as $i)
											<tr>
												<td>
													<div class="course-list-img-text">
														<div class="course-list-img">
															<img src="{{ url('storage/package/imgs/'.basename($i->package->img_small))}}" alt="">
														</div>
														<div class="course-list-text">
															<h3><a href="{{route('public.package.view', $i->package->id)}}">{{Transcode::evaluate($i->package)['name'] }}</a></h3>
															<div class="course-meta">
																<span class="course-category bold-font"><a>
																	@if($i->package->discount > 0)
																	{{__('Public/package-by-course.instead-of')}} <i style=" color: red; text-decoration: line-through;">{{round($i->package->original_price, 2) }}</i> $
																	@endif
																	</span>
																	<span class="widget-thumb-body-stat">
																	@if($i->package->price > 0)
																		{{$i->package->price}} $
																	@else 
																		{{__('Public/package-by-course.free')}}
																	@endif	
																</a></span>
																<br>
																<div class="course-rate ul-li">
																	<ul style="color:#ffc926 !important;">
																		<li style="@if($i->total_rate < 1)color:black !important; @else color:#ffc926 !important;@endif"><i class="fas fa-star"></i></li>
																		<li style="@if($i->total_rate < 2)color:black !important; @else color:#ffc926 !important;@endif"><i class="fas fa-star"></i></li>
																		<li style="@if($i->total_rate < 3)color:black !important; @else color:#ffc926 !important;@endif"><i class="fas fa-star"></i></li>
																		<li style="@if($i->total_rate < 4)color:black !important; @else color:#ffc926 !important;@endif"><i class="fas fa-star"></i></li>
																		<li style="@if($i->total_rate < 5)color:black !important; @else color:#ffc926 !important;@endif"><i class="fas fa-star"></i></li>
																	</ul>
																</div>
															</div>
														</div>
													</div>
												</td>
												<td>
													<div class="course-type-list">
														
														<span>{{Transcode::evaluate(\App\Course::find($i->package->course_id))['title']}}</span>
													
													</div>
												</td>
												<td>{{$i->package->expire_in_days}} {{__('Public/package-by-course.days')}}</td>
											</tr>
											@endforeach
                                            <tr>
                                                <td>{{__('Public/package-by-course.online-interactive-courses')}}</td>
                                                <td></td>
                                                <td></td>
                                            <tr/>
                                            @foreach($best_sell_event as $i)
                                                <tr>
                                                    <td>
                                                        <div class="course-list-img-text">
                                                            <div class="course-list-img">
                                                                <img src="{{ url('storage/events/'.basename($i->event->img))}}" alt="">
                                                            </div>
                                                            <div class="course-list-text">
                                                                <h3><a href="{{route('public.event.view', $i->event->id)}}">{{Transcode::evaluate($i->event)['name'] }}</a></h3>
                                                                <div class="course-meta">
																<span class="course-category bold-font"><a>
																	@if($i->package->discount > 0)
																	{{__('Public/package-by-course.instead-of')}} <i style=" color: red; text-decoration: line-through;">{{round($i->event->original_price, 2) }}</i> $
																	@endif
																	</span>
                                                                    <span class="widget-thumb-body-stat">
																	@if($i->event->price > 0)
																		{{$i->event->price}} $
																	@else
																		{{__('Public/package-by-course.free')}}
																	@endif
																	</a></span>
                                                                    <br>
                                                                    <div class="course-rate ul-li">
                                                                        <ul style="color:#ffc926 !important;">
                                                                            <li style="@if($i->total_rate < 1)color:black !important; @else color:#ffc926 !important;@endif"><i class="fas fa-star"></i></li>
                                                                            <li style="@if($i->total_rate < 2)color:black !important; @else color:#ffc926 !important;@endif"><i class="fas fa-star"></i></li>
                                                                            <li style="@if($i->total_rate < 3)color:black !important; @else color:#ffc926 !important;@endif"><i class="fas fa-star"></i></li>
                                                                            <li style="@if($i->total_rate < 4)color:black !important; @else color:#ffc926 !important;@endif"><i class="fas fa-star"></i></li>
                                                                            <li style="@if($i->total_rate < 5)color:black !important; @else color:#ffc926 !important;@endif"><i class="fas fa-star"></i></li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="course-type-list">

                                                            <span>{{Transcode::evaluate(\App\Course::find($i->event->course_id))['title']}}</span>

                                                        </div>
                                                    </td>
													<td>{{$i->event->expire_in_days}} {{__('Public/package-by-course.days')}}</td>
                                                </tr>
                                            @endforeach
										</table>
									</div>
								</div><!-- /tab-2 -->
							</div>
						</div>

						
					</div>

					<div class="col-md-3">
						<div class="side-bar">

							<div class="side-bar-widget  first-widget">
								<h2 class="widget-title text-capitalize" style="display:flex;"><span>{{__('Public/package-by-course.find')}} </span>{{__('Public/package-by-course.your-course')}}</h2>
								<div class="listing-filter-form pb30">
									<form action="#" method="get">
										<div class="filter-select mb20">
											<label>{{__('Public/package-by-course.course-type')}}</label>
											<select name="course_id">
												@foreach(\App\Course::where('private', 0)->get() as $c)
                                                <option @if(Illuminate\Support\Facades\Input::get('course_id') == $c->id) selected @endif value="{{$c->id}}">{{Transcode::evaluate($c)['title']}}</option>
                                                @endforeach
											</select>
										</div>

										
											<input value="{{__('Public/package-by-course.find-course')}}" style="padding: 0 !important; color:white;" type="submit" class="genius-btn gradient-bg text-center text-uppercase ul-li-block bold-font"/>
										
									</form>

								</div>
							</div>

							
							@if(count($best_sell))

							<div class="side-bar-widget">
								<h2 class="widget-title text-capitalize" style="display:flex; {{app()->getLocale() == 'en'? '':'flex-direction:row-reverse;justify-content:flex-end;'}} "><span>{{__('Public/package-by-course.featured')}}</span> {{__('Public/package-by-course.courses')}}</h2>
								<div class="featured-course">
									<div class="best-course-pic-text relative-position">
										<div class="best-course-pic relative-position">
											<img src="{{ url('storage/package/imgs/'.basename($best_sell[0]->package->img))}}" alt="">
											@if($best_sell[0]->users_no >= 400)
											<div class="trend-badge-2 text-center text-uppercase">
												<i class="fas fa-bolt"></i>
												<span>{{__('Public/package-by-course.trending')}}</span>
											</div>
											@endif
										</div>
										<div class="best-course-text">
											<div class="course-title mb20 headline relative-position">
												<h3><a href="{{route('public.package.view', $best_sell[0]->package->id)}}">{{Transcode::evaluate($best_sell[0]->package)['name'] }}</a></h3>
											</div>
											<div class="course-meta">
												<span class="course-category"><a href="{{route('public.package.view', $best_sell[0]->package->id)}}">{{Transcode::evaluate(\App\Course::find($best_sell[0]->package->course_id))['title']}}</a></span>
												<span class="course-author"><a href="#">{{$best_sell[0]->users_no}} Students</a></span>
											</div>
										</div>
									</div>
								</div>
							</div>
							@endif
						</div>
					</div>
				</div>
			</div>
		</section>
	<!-- End of course section
		============================================= -->


		

	<!-- Start of footer section
		============================================= -->
		<footer>
			<section id="footer-area" class="footer-area-section">
				<div class="container">
					

					<div class="copy-right-menu">
                    <div class="row" style="display:flex;justify-content:space-between;">
                        <div>
                            <div class="copy-right-text">
                                <p>© 2019 - {{date("Y")}} <u>{{env('APP_NAME')}}</u> {{__('Public/package-by-course.rights-sentence')}} <a href="http://marvelits.com" target="_blank"><u>MarvelIts</u></a></p>
                            </div>
                        </div>
                        <div>
                            <div class="copy-right-menu-item float-right ul-li">
                                <ul>
                                    <li><a href="{{route('terms.show.public')}}">{{__('Public/package-by-course.terms-of-service')}}</a></li>
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


        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-176072046-1"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());
        
          gtag('config', 'UA-176072046-1');
        </script>


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
