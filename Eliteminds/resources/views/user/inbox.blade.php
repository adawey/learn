@extends('layouts.layoutV2')

@section('content')

	<div class="" id="app-2">

		<div class="d-flex">
			<nav id="breadcrumbs" class="mb-3">
				<ul>
					<li><a href="{{route('user.dashboard')}}"> <i class="uil-home-alt"></i> </a></li>
					<li><a> Chat </a></li>

				</ul>
			</nav>
		</div>



		<div class="chats-container margin-top-0">

			<div class="chats-container-inner">

				<!-- chats -->
				<div class="chats-inbox">


					<ul>
						@php
							$adminimg = asset('storage/icons/user/'.rand(1,3).'.png');
							$user_list = [];
						@endphp
						@foreach($messages as $msg)
							@php
								if($msg->from_user_type == 'admin'){
                                    $user = \App\Admin::find($msg->from_user_id);
                                }else{
                                    $user = \App\Admin::find($msg->to_user_id);
                                }


							@endphp

							@if(!in_array($user->id, $user_list))
							<li @if($msg->sight == 0 && $msg->to_user_id == Auth::user()->id && $msg->to_user_type == 'user') class="active-message" @endif>
								<a href="{{route('user.inboxv2')}}?user_id={{$user->id}}">
									<div class="message-avatar"><i class="status-icon status-online"></i><img
												src="{{$adminimg}}" alt="" /></div>

									<div class="message-by">
										<div class="message-by-headline">
											<h5>{{$user->name}}</h5>
											<span>{{$msg->created_at->diffForHumans()}}</span>
										</div>
										<p>{!! $msg->message !!}</p>
										@if($msg->to_user_type == 'admin' && !$msg->sight)
										<span class="message-readed uil-check"> </span>
										@endif
									</div>
								</a>
							</li>
							@endif
							@php
								array_push($user_list, $user->id);
							@endphp
						@endforeach

						@if(count($messages) == 0)
							@php
								$user = \App\Admin::find(2);
							@endphp
							<li class="active-message">
								<a href="{{route('user.inboxv2')}}?user_id={{$user->id}}">
									<div class="message-avatar">
										<i class="status-icon status-online"></i>
										<img src="{{$adminimg}}" alt="" />
									</div>

									<div class="message-by">
										<div class="message-by-headline">
											<h5>{{$user->name}}</h5>
											<span>{{\Carbon\Carbon::now()->diffForHumans()}}</span>
										</div>
										<p>Contact Me !</p>
									</div>
								</a>
							</li>
						@endif
					</ul>
				</div>
				<!-- chats / End -->

				@if(Illuminate\Support\Facades\Input::get('user_id'))
					@php

						if(\App\User::find(Illuminate\Support\Facades\Input::get('user_id'))){
                            $user = \App\Admin::find(Illuminate\Support\Facades\Input::get('user_id'));
                        }


						$userimg =asset('assets/layouts/layout/img/avatar3_small.jpg');
						if(Auth::check()){
							if(\App\UserDetail::where('user_id', '=', Auth::user()->id)->get()->first() ){
								if(\App\UserDetail::where('user_id', '=', Auth::user()->id)->get()->first()->profile_pic){
									$userimg =url('storage/profile_picture/'.basename(\App\UserDetail::where('user_id','=',Auth::user()->id)->get()->first()->profile_pic));
								}
							}
						}

						/**
						 *   (from_user_type == admin && from_user_id == Auth) or (from_user_type == user && from_user_id == $user->id)
						*/
						$user_messages = \App\Message::where(function($q)use($user){
							$q->where('from_user_type', 'user')
								->where('from_user_id', Auth::user()->id)
								->where('to_user_id', $user->id);
						})->orWhere(function($q)use($user){
							$q->where('from_user_type', 'admin')
								->where('from_user_id', $user->id)
								->where('to_user_id' ,Auth::user()->id);
						})->orderBy('created_at', 'asc')->get();

						foreach($user_messages as $m){
							$m->sight =1;
							$m->save();
						}

					@endphp
					<!-- Message Content -->
					<div class="message-content" id="messageContent">

						<div class="chats-headline">

							<div class="d-flex">
								<div class="avatar-parent-child">
									<img alt="Image placeholder" src="{{$adminimg}}"
										 class="avatar  rounded-circle avatar-sm">
									<span class="avatar-child avatar-badge bg-success"></span>
								</div>
								<h4 class="ml-2">{{$user->name}}<span>Online</span> </h4>
							</div>
						</div>

						<!-- Message Content Inner -->
						<div class="message-content-inner">


							@foreach($user_messages as $msg)
								@if($msg->from_user_type == 'user')
								<!-- Time Sign -->
								<div class="message-bubble me">
									<div class="message-bubble-inner">
										<div class="message-avatar">
											<img src="{{$userimg}}" alt="" />
										</div>
										<div class="message-text">
											<p>{!! $msg->message !!}</p>
											<span style="font-size:11px;">{{$msg->created_at->diffForHumans()}}</span>
											@if(\App\MessageImage::where('message_id', $msg->id)->get()->first())
												<p>
													<img src="{{ url('storage/messages/'.basename(\App\MessageImage::where('message_id', $msg->id)->get()->first()->img))}}" style="max-width: 350px; max-height:350px;">
												</p>
											@endif
										</div>
									</div>
									<div class="clearfix"></div>
								</div>
								@else
								<div class="message-bubble">
									<div class="message-bubble-inner">
										<div class="message-avatar">
											<img src="{{$adminimg}}" alt="" />
										</div>
										<div class="message-text">
											<p>{!! $msg->message !!}</p>
											<span style="font-size:11px;">{{$msg->created_at->diffForHumans()}}</span>
											@if(\App\MessageImage::where('message_id', $msg->id)->get()->first())
												<p>
													<img src="{{ url('storage/messages/'.basename(\App\MessageImage::where('message_id', $msg->id)->get()->first()->img))}}" style="max-width: 350px; max-height:350px;">
												</p>
											@endif
										</div>
									</div>
									<div class="clearfix"></div>
								</div>
								@endif
							@endforeach
						</div>
						<!-- Message Content Inner / End -->

						<!-- Reply Area -->
						<div class="message-reply" >

							<form class="d-flex align-items-center w-100" method="POST" action="{{route('user.inboxv2.send')}}" enctype="multipart/form-data">
								@csrf
								<input type="hidden" name="to_user_id" value="{{Illuminate\Support\Facades\Input::get('user_id')}}">
								<div class="btn-box d-flex align-items-center mr-3">
									<input type="file" name="img" style="display: none;">
									<a class="btn btn-icon  btn-default btn-circle d-inline-block  " id="uploadFile">
										<i class="uil-link-alt"></i>
									</a>
									<span id="uploadFileText"></span>
								</div>

								<textarea style="height: 100px; border:0; width:100%; padding-left: 10px;" v-model="fakeInput" v-on:change="updateValue" word-break="break-word" id="fakeInput" placeholder="Type here..." ></textarea>
								<textarea style="display:none;" v-model="realtimeInput" name="msg" id="realtimeInput"></textarea>

								<button type="submit" class="send-btn d-inline-block btn btn-default">Send <i
											class="bx bx-paper-plane"></i></button>
							</form>

						</div>

				</div>
				<!-- Message Content -->
				@endif
			</div>
		</div>
		<!-- chats Container / End -->

		

	</div>
@endsection
@section('jscode')
	<script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>
	<script>

		var app2 = new Vue({
			el: '#app-2',

			data: {
				fakeInput: '',
				realtimeInput: '',
			},
			methods: {
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

			document.getElementById('uploadFileText').innerHTML = val.split(/(\\|\/)/g).pop();
		});
	</script>
@endsection
