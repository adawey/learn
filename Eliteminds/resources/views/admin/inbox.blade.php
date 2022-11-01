<!DOCTYPE html>

<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 4 & Angular 8
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
Renew Support: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<html lang="en">

	<!-- begin::Head -->
	<head>

		<!--begin::Base Path (base relative path for assets of this page) -->
<!--		<base href="../../../../">-->

		<!--end::Base Path -->
		<meta charset="utf-8" />
		<title>{{env('APP_NAME')}} | Inbox</title>
		<meta name="description" content="Private chat example">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!--begin::Fonts -->
		<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
		<script>
			WebFont.load({
				google: {
					"families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"]
				},
				active: function() {
					sessionStorage.fonts = true;
				}
			});
		</script>

		<!--end::Fonts -->

		<!--begin:: Global Mandatory Vendors -->
		<link href="{{asset('chat_assets/vendors/general/perfect-scrollbar/css/perfect-scrollbar.css')}}" rel="stylesheet" type="text/css" />

		<!--end:: Global Mandatory Vendors -->

		<!--begin:: Global Optional Vendors -->
		<link href="{{asset('chat_assets/vendors/general/tether/dist/css/tether.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('chat_assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('chat_assets/vendors/general/bootstrap-datetime-picker/css/bootstrap-datetimepicker.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('chat_assets/vendors/general/bootstrap-timepicker/css/bootstrap-timepicker.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('chat_assets/vendors/general/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('chat_assets/vendors/general/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('chat_assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('chat_assets/vendors/general/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('chat_assets/vendors/general/select2/dist/css/select2.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('chat_assets/vendors/general/ion-rangeslider/css/ion.rangeSlider.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('chat_assets/vendors/general/nouislider/distribute/nouislider.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('chat_assets/vendors/general/owl.carousel/dist/assets/owl.carousel.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('chat_assets/vendors/general/owl.carousel/dist/assets/owl.theme.default.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('chat_assets/vendors/general/dropzone/dist/dropzone.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('chat_assets/vendors/general/summernote/dist/summernote.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('chat_assets/vendors/general/bootstrap-markdown/css/bootstrap-markdown.min.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('chat_assets/vendors/general/animate.css/animate.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('chat_assets/vendors/general/toastr/build/toastr.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('chat_assets/vendors/general/morris.js/morris.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('chat_assets/vendors/general/sweetalert2/dist/sweetalert2.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('chat_assets/vendors/general/socicon/css/socicon.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('chat_assets/vendors/custom/vendors/line-awesome/css/line-awesome.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('chat_assets/vendors/custom/vendors/flaticon/flaticon.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('chat_assets/vendors/custom/vendors/flaticon2/flaticon.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('chat_assets/vendors/general/@fortawesome/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css" />

		<!--end:: Global Optional Vendors -->

		<!--begin::Global Theme Styles(used by all pages) -->
		<link href="{{asset('chat_assets/css/demo1/style.bundle.css')}}" rel="stylesheet" type="text/css" />

		<!--end::Global Theme Styles -->

		<!--begin::Layout Skins(used by all pages) -->
		<link href="{{asset('chat_assets/css/demo1/skins/header/base/light.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('chat_assets/css/demo1/skins/header/menu/light.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('chat_assets/css/demo1/skins/brand/dark.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('chat_assets/css/demo1/skins/aside/dark.css')}}" rel="stylesheet" type="text/css" />

		<!--end::Layout Skins -->
		
	</head>

	<!-- end::Head -->

	<!-- begin::Body -->
	<body class="kt-app__aside--left kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-aside--enabled kt-aside--fixed kt-page--loading">

		<!-- begin:: Page -->

		<!-- begin:: Header Mobile -->
		@if(session('success'))
		<div class="alert alert-success">
			{{session('success')}}
		</div>
		@endif

		<!-- end:: Header Mobile -->
		<div class="kt-grid kt-grid--hor kt-grid--root">
			<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">

			
					<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

						<!-- begin:: Content -->
						<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

							<!--Begin::App-->
							<div class="kt-grid kt-grid--desktop kt-grid--ver kt-grid--ver-desktop kt-app">

								<!--Begin:: App Aside Mobile Toggle-->
								<button class="kt-app__aside-close" id="kt_chat_aside_close">
									<i class="la la-close"></i>
								</button>

								<!--End:: App Aside Mobile Toggle-->

								<!--Begin:: App Aside-->
								<div class="kt-grid__item kt-app__toggle kt-app__aside kt-app__aside--lg kt-app__aside--fit" id="kt_chat_aside">

									<!--begin::Portlet-->
									<div class="kt-portlet kt-portlet--last">
										<div class="kt-portlet__body">
                                            <div class="row">
                                                <a href="{{route('admin.dashboard')}}" class="btn btn-default" style="text-align:center; width:100%;" >DashBoard</a>
                                            </div>
											
											<div class="kt-widget kt-widget--users kt-mt-20">
												<div class="kt-scroll kt-scroll--pull">
													<div class="kt-widget__items">
                                                        @php
                                                            $user_list = [];
                                                        @endphp
                                                        @foreach($messages as $msg)
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
																
																

																if($user){

																
																	$img = \App\UserDetail::where('user_id', $user->id)->get()->first();
																	
																																	
																	if(!$img){
																		$img = asset('storage/icons/user/'.rand(1,3).'.png');
																	}else{
																		if($img->profile_pic){
																			$img = url('storage/profile_picture/'.basename($img->profile_pic));
																		}else{
																			$img = asset('storage/icons/user/'.rand(1,3).'.png');
																		}

																		
																	}

																}	


															
                                                            @endphp
															@if($user)
																@if(!in_array($user->id, $user_list))
																<div class="kt-widget__item">
																	<span class="kt-userpic kt-userpic--circle">
																		
																		<a href="{{route('admin.inboxv2')}}?user_id={{$user->id}}">
																			<img src="{{$img}}" alt="image">
																		</a>
																	</span>
																	<div class="kt-widget__info">
																		<div class="kt-widget__section">
																			<a href="{{route('admin.inboxv2')}}?user_id={{$user->id}}" class="kt-widget__username">
																				{{$user->name}}
																			</a>
																			
																			@if($msg->sight == 0 && $msg->to_user_id == Auth::user()->id && $msg->to_user_type == 'admin')
																			<span class="kt-badge kt-badge--success kt-badge--dot"></span>
																			@endif
																		</div>
																		<a href="{{route('admin.inboxv2')}}?user_id={{$user->id}}">
																			<span class="kt-widget__desc">
																				{!! $msg->message !!}
																			</span>
																		</a>
																	</div>
																	<div class="kt-widget__action">
																		<span class="kt-widget__date">{{$msg->created_at->diffForHumans()}}</span>
																		{{-- file<span class="kt-badge kt-badge--success kt-font-bold">7</span> --}}
																	</div>


																	
																</div>

																@php
																	array_push($user_list, $user->id);
																@endphp

																@endif
															@endif
                                                        @endforeach
														
														
                                                        
														
													</div>
												</div>
											</div>
										</div>
									</div>

									<!--end::Portlet-->
								</div>

								<!--End:: App Aside-->

								<!--Begin:: App Content-->
								<div class="kt-grid__item kt-grid__item--fluid kt-app__content" id="kt_chat_content">
									<div class="kt-chat">
										<div class="kt-portlet kt-portlet--head-lg kt-portlet--last">
                                            @if(Illuminate\Support\Facades\Input::get('user_id'))

                                            @php

                                                if(\App\User::find(Illuminate\Support\Facades\Input::get('user_id'))){
                                                    $user = \App\User::find(Illuminate\Support\Facades\Input::get('user_id'));
                                                }else{
                                                    $user = \App\UserDetail::where('user_id', Illuminate\Support\Facades\Input::get('user_id'))->get()->first();
                                                }

                                            @endphp
											<div class="kt-portlet__head">
												<div class="kt-chat__head ">
													
													<div class="kt-chat__center">
														<div class="kt-chat__label">
                                                            <a href="#" class="kt-chat__title">{{$user->name}}</a>
                                                            @if($user->last_action == 'loged in')
                                                                <span class="kt-chat__status">
                                                                    <span class="kt-badge kt-badge--dot kt-badge--success"></span> Active
                                                                </span>
                                                            @endif
                                                        </div>
													</div>
													
												</div>
											</div>
											<div class="kt-portlet__body">
												<div class="kt-scroll kt-scroll--pull" data-mobile-height="300">
													<div class="kt-chat__messages">


                                                        @php

                                                            /**
                                                             *   (from_user_type == admin && from_user_id == Auth) or (from_user_type == user && from_user_id == $user->id)
                                                            */
                                                            $user_messages = \App\Message::where(function($q)use($user){
                                                                $q->where('from_user_type', 'admin')
                                                                    ->where('from_user_id', Auth::user()->id)
                                                                    ->where('to_user_id', $user->id);
                                                            })->orWhere(function($q)use($user){
                                                                $q->where('from_user_type', 'user')
                                                                    ->where('from_user_id', $user->id)
                                                                    ->where('to_user_id' ,Auth::user()->id);
                                                            })->orderBy('created_at', 'asc')->get();

                                                            foreach($user_messages as $m){
                                                                $m->sight =1;
                                                                $m->save();
                                                            }

                                                            
															$adminimg = asset('storage/icons/user/'.rand(1,3).'.png');
                                                            

															$userimg = \App\UserDetail::where('user_id', $user->id)->get()->first();
															if(!$userimg){
																$userimg = asset('storage/icons/user/'.rand(1,3).'.png');
															}else{
																if($userimg->profile_pic){
																	$userimg = url('storage/profile_picture/'.basename($userimg->profile_pic));
																}else{
																	$userimg = asset('storage/icons/user/'.rand(1,3).'.png');
																}

																
															}

                                                        @endphp
                                                        

                                                        @foreach($user_messages as $msg)

                                                            @if($msg->from_user_type == 'admin')
                                                                <div class="kt-chat__message kt-chat__message--right">
                                                                    <div class="kt-chat__user">
                                                                        <span class="kt-chat__datetime">{{$msg->created_at->diffForHumans()}}</span>
                                                                        <a href="#" class="kt-chat__username">You</span></a>
                                                                        <span class="kt-userpic kt-userpic--circle kt-userpic--sm">
                                                                            <img src="{{$adminimg}}" alt="image">
                                                                        </span>
																	</div>
																	@if($msg->message != '')
                                                                    <div class="kt-chat__text kt-bg-light-brand">
                                                                        {!! $msg->message !!}
																	</div>
																	@endif
																	<br>
																	@if(\App\MessageImage::where('message_id', $msg->id)->get()->first())
																		<div class="kt-chat__text kt-bg-light-brand">
																			<img src="{{ url('storage/messages/'.basename(\App\MessageImage::where('message_id', $msg->id)->get()->first()->img))}}" style="max-width: 350px; max-height:350px;">
																		</div>
																	@endif
                                                                </div>
															@else
																
                                                                <div class="kt-chat__message">
                                                                    <div class="kt-chat__user">
                                                                        <span class="kt-userpic kt-userpic--circle kt-userpic--sm">
                                                                            <img src="{{$userimg}}" alt="image">
                                                                        </span>
                                                                        <a href="#" class="kt-chat__username">{{$user->name}}</span></a>
                                                                        <span class="kt-chat__datetime">{{$msg->created_at->diffForHumans()}}</span>
																	</div>
																	@if($msg->message != '')
                                                                    <div class="kt-chat__text kt-bg-light-success">
                                                                        {!! $msg->message !!}
																	</div>
																	@endif
																	<br>
																	@if(\App\MessageImage::where('message_id', $msg->id)->get()->first())
																		<div class="kt-chat__text kt-bg-light-success">
																			<img src="{{ url('storage/messages/'.basename(\App\MessageImage::where('message_id', $msg->id)->get()->first()->img))}}" style="max-width: 350px; max-height:350px;">
																		</div>
																	@endif
																</div>
																
                                                            @endif
                                                        @endforeach                                                        


														
														
													</div>
												</div>
											</div>
											<div class="kt-portlet__foot" id="app-2">
												<form  method="POST" action="{{route('admin.inboxv2.send')}}" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="to_user_id" value="{{Illuminate\Support\Facades\Input::get('user_id')}}">
			                                           
                                                    <textarea style="height: 100px; border:0; width:100%;" v-model="fakeInput" v-on:change="updateValue" word-break="break-word" id="fakeInput" placeholder="Type here..." ></textarea>
													<textarea style="display:none;" v-model="realtimeInput" name="msg" id="realtimeInput"></textarea>
													<div class="kt-chat__toolbar">
														<div class="kt_chat__tools">
															<input type="file" name="img" style="display:none;">
															<div class="kt_chat__tools">
																<a><i id="uploadFile" class="flaticon2-photo-camera"></i></a>
																<span id="uploadFileText" style="font-weight: bold; padding: 0 10px;"></span>
															</div>
														</div>
														<div class="kt_chat__action">
															<input type="submit" class="btn btn-success" value="reply" style="float:right;"/>
														</div>
													</div>
												</form>
                                            </div>
                                            @endif
                                        </div>
                                        
									</div>
								</div>

								<!--End:: App Content-->
							</div>

							<!--End::App-->
						</div>

						<!-- end:: Content -->
					</div>

					<!-- begin:: Footer -->
					

					<!-- end:: Footer -->
				</div>
			</div>
		
		<!-- end:: Page -->

		<!-- begin::Quick Panel -->
		

		<!-- end::Quick Panel -->

		<!-- begin::Scrolltop -->
		<div id="kt_scrolltop" class="kt-scrolltop">
			<i class="fa fa-arrow-up"></i>
		</div>

		<!-- end::Scrolltop -->

		<!-- begin::Sticky Toolbar -->
		

		<!-- end::Sticky Toolbar -->

		<!-- begin::Demo Panel -->
		

		<!-- end::Demo Panel -->

		<!--Begin:: Chat-->
		

		<!--ENd:: Chat-->

		<!-- begin::Global Config(global config for global JS sciprts) -->
		<script>
			var KTAppOptions = {
				"colors": {
					"state": {
						"brand": "#5d78ff",
						"dark": "#282a3c",
						"light": "#ffffff",
						"primary": "#5867dd",
						"success": "#34bfa3",
						"info": "#36a3f7",
						"warning": "#ffb822",
						"danger": "#fd3995"
					},
					"base": {
						"label": ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"],
						"shape": ["#f0f3ff", "#d9dffa", "#afb4d4", "#646c9a"]
					}
				}
			};
		</script>

		<!-- end::Global Config -->

		<!--begin:: Global Mandatory Vendors -->
		<script src="{{asset('chat_assets/vendors/general/jquery/dist/jquery.js')}}" type="text/javascript"></script>
		<script src="{{asset('chat_assets/vendors/general/popper.js/dist/umd/popper.js')}}" type="text/javascript"></script>
		<script src="{{asset('chat_assets/vendors/general/bootstrap/dist/js/bootstrap.min.js')}}" type="text/javascript"></script>
		<script src="{{asset('chat_assets/vendors/general/js-cookie/src/js.cookie.js')}}" type="text/javascript"></script>
		<script src="{{asset('chat_assets/vendors/general/moment/min/moment.min.js')}}" type="text/javascript"></script>
		<script src="{{asset('chat_assets/vendors/general/tooltip.js/dist/umd/tooltip.min.js')}}" type="text/javascript"></script>
		<script src="{{asset('chat_assets/vendors/general/perfect-scrollbar/dist/perfect-scrollbar.js')}}" type="text/javascript"></script>
		<script src="{{asset('chat_assets/vendors/general/sticky-js/dist/sticky.min.js')}}" type="text/javascript"></script>
		<script src="{{asset('chat_assets/vendors/general/wnumb/wNumb.js')}}" type="text/javascript"></script>

		<!--end:: Global Mandatory Vendors -->

		<!--begin:: Global Optional Vendors -->
		<script src="{{asset('chat_assets/vendors/general/jquery-form/dist/jquery.form.min.js')}}" type="text/javascript"></script>
		<script src="{{asset('chat_assets/vendors/general/block-ui/jquery.blockUI.js')}}" type="text/javascript"></script>
		<script src="{{asset('chat_assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}" type="text/javascript"></script>
		<script src="{{asset('chat_assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js')}}" type="text/javascript"></script>
		<script src="{{asset('chat_assets/vendors/general/bootstrap-datetime-picker/js/bootstrap-datetimepicker.min.js')}}" type="text/javascript"></script>
		<script src="{{asset('chat_assets/vendors/general/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}" type="text/javascript"></script>
		<script src="{{asset('chat_assets/vendors/custom/js/vendors/bootstrap-timepicker.init.js')}}" type="text/javascript"></script>
		<script src="{{asset('chat_assets/vendors/general/bootstrap-daterangepicker/daterangepicker.js')}}" type="text/javascript"></script>
		<script src="{{asset('chat_assets/vendors/general/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.js')}}" type="text/javascript"></script>
		<script src="{{asset('chat_assets/vendors/general/bootstrap-maxlength/src/bootstrap-maxlength.js')}}" type="text/javascript"></script>
		<script src="{{asset('chat_assets/vendors/custom/vendors/bootstrap-multiselectsplitter/bootstrap-multiselectsplitter.min.js')}}" type="text/javascript"></script>
		<script src="{{asset('chat_assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js')}}" type="text/javascript"></script>
		<script src="{{asset('chat_assets/vendors/general/bootstrap-switch/dist/js/bootstrap-switch.js')}}" type="text/javascript"></script>
		<script src="{{asset('chat_assets/vendors/custom/js/vendors/bootstrap-switch.init.js')}}" type="text/javascript"></script>
		<script src="{{asset('chat_assets/vendors/general/select2/dist/js/select2.full.js')}}" type="text/javascript"></script>
		<script src="{{asset('chat_assets/vendors/general/ion-rangeslider/js/ion.rangeSlider.js')}}" type="text/javascript"></script>
		<script src="{{asset('chat_assets/vendors/general/typeahead.js/dist/typeahead.bundle.js')}}" type="text/javascript"></script>
		<script src="{{asset('chat_assets/vendors/general/handlebars/dist/handlebars.js')}}" type="text/javascript"></script>
		<script src="{{asset('chat_assets/vendors/general/inputmask/dist/jquery.inputmask.bundle.js')}}" type="text/javascript"></script>
		<script src="{{asset('chat_assets/vendors/general/inputmask/dist/inputmask/inputmask.date.extensions.js')}}" type="text/javascript"></script>
		<script src="{{asset('chat_assets/vendors/general/inputmask/dist/inputmask/inputmask.numeric.extensions.js')}}" type="text/javascript"></script>
		<script src="{{asset('chat_assets/vendors/general/nouislider/distribute/nouislider.js')}}" type="text/javascript"></script>
		<script src="{{asset('chat_assets/vendors/general/owl.carousel/dist/owl.carousel.js')}}" type="text/javascript"></script>
		<script src="{{asset('chat_assets/vendors/general/autosize/dist/autosize.js')}}" type="text/javascript"></script>
		<script src="{{asset('chat_assets/vendors/general/clipboard/dist/clipboard.min.js')}}" type="text/javascript"></script>
		<script src="{{asset('chat_assets/vendors/general/dropzone/dist/dropzone.js')}}" type="text/javascript"></script>
		<script src="{{asset('chat_assets/vendors/general/summernote/dist/summernote.js')}}" type="text/javascript"></script>
		<script src="{{asset('chat_assets/vendors/general/markdown/lib/markdown.js')}}" type="text/javascript"></script>
		<script src="{{asset('chat_assets/vendors/general/bootstrap-markdown/js/bootstrap-markdown.js')}}" type="text/javascript"></script>
		<script src="{{asset('chat_assets/vendors/custom/js/vendors/bootstrap-markdown.init.js')}}" type="text/javascript"></script>
		<script src="{{asset('chat_assets/vendors/general/bootstrap-notify/bootstrap-notify.min.js')}}" type="text/javascript"></script>
		<script src="{{asset('chat_assets/vendors/custom/js/vendors/bootstrap-notify.init.js')}}" type="text/javascript"></script>
		<script src="{{asset('chat_assets/vendors/general/jquery-validation/dist/jquery.validate.js')}}" type="text/javascript"></script>
		<script src="{{asset('chat_assets/vendors/general/jquery-validation/dist/additional-methods.js')}}" type="text/javascript"></script>
		<script src="{{asset('chat_assets/vendors/custom/js/vendors/jquery-validation.init.js')}}" type="text/javascript"></script>
		<script src="{{asset('chat_assets/vendors/general/toastr/build/toastr.min.js')}}" type="text/javascript"></script>
		<script src="{{asset('chat_assets/vendors/general/raphael/raphael.js')}}" type="text/javascript"></script>
		<script src="{{asset('chat_assets/vendors/general/morris.js/morris.js')}}" type="text/javascript"></script>
		<script src="{{asset('chat_assets/vendors/general/chart.js/dist/Chart.bundle.js')}}" type="text/javascript"></script>
		<script src="{{asset('chat_assets/vendors/custom/vendors/bootstrap-session-timeout/dist/bootstrap-session-timeout.min.js')}}" type="text/javascript"></script>
		<script src="{{asset('chat_assets/vendors/custom/vendors/jquery-idletimer/idle-timer.min.js')}}" type="text/javascript"></script>
		<script src="{{asset('chat_assets/vendors/general/waypoints/lib/jquery.waypoints.js')}}" type="text/javascript"></script>
		<script src="{{asset('chat_assets/vendors/general/counterup/jquery.counterup.js')}}" type="text/javascript"></script>
		<script src="{{asset('chat_assets/vendors/general/es6-promise-polyfill/promise.min.js')}}" type="text/javascript"></script>
		<script src="{{asset('chat_assets/vendors/general/sweetalert2/dist/sweetalert2.min.js')}}" type="text/javascript"></script>
		<script src="{{asset('chat_assets/vendors/custom/js/vendors/sweetalert2.init.js')}}" type="text/javascript"></script>
		<script src="{{asset('chat_assets/vendors/general/jquery.repeater/src/lib.js')}}" type="text/javascript"></script>
		<script src="{{asset('chat_assets/vendors/general/jquery.repeater/src/jquery.input.js')}}" type="text/javascript"></script>
		<script src="{{asset('chat_assets/vendors/general/jquery.repeater/src/repeater.js')}}" type="text/javascript"></script>
		<script src="{{asset('chat_assets/vendors/general/dompurify/dist/purify.js')}}" type="text/javascript"></script>

		<!--end:: Global Optional Vendors -->

		<!--begin::Global Theme Bundle(used by all pages) -->
		<script src="{{asset('chat_assets/js/demo1/scripts.bundle.js')}}" type="text/javascript"></script>

		<!--end::Global Theme Bundle -->

		<!--begin::Page Scripts(used by this page) -->
		<script src="{{asset('chat_assets/js/demo1/pages/custom/chat/chat.js')}}" type="text/javascript"></script>

        <!--end::Page Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>
    	<script>
        var app2 = new Vue({
            el: '#app-2',

            data: {
                fakeInput: '',
				realtimeInput: '',
            },
            methods: {
                
                _: function(ele){
                    return document.getElementById(ele);
                },
				updateValue: function(){
					this.realtimeInput = this.fakeInput.replace(/(?:\r\n|\r|\n)/g, '<br />');
				},
                


            },

        });



		$("#uploadFile").click(function () {
			$("input[type='file']").trigger('click');
		});

		$('input[type="file"]').on('change', function() {
			var val = $(this).val();
			
			document.getElementById('uploadFileText').innerHTML = val;
		});
        </script>


        
	</body>

	<!-- end::Body -->
</html>
