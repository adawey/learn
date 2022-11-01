@extends('layouts.app-2')

@section('content')

    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <div class="row">
                <div class="col-md-10">
                    <!-- BEGIN SAMPLE TABLE PORTLET-->
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-doc font-green"></i>
                                <span class="caption-subject font-green bold uppercase">Study Plan</span>
                            </div>
                            
                        </div>
                        <div class="portlet-body">
                            @if(count($plans))
                                @foreach($plans as $plan)
                                    <h2>{{$plan->title}}</h2>
                                    
                                    <div class="portlet-body">
                                        <video oncontextmenu="return false;" width="100%" height="380" controls controlsList="nodownload">
                                            <source src="{{url('storage/studyPlan/'.basename($plan->video_url) )}}" type="video/mp4">
                                        </video>
                                    </div>
                                    <br>
                                    <p>
                                        {{$plan->created_at->diffForHumans()}}
                                    </p>
                                    <p> 
                                        {{$plan->description}}
                                        
                                    </p>
                                    <hr style="border: 1px solid #ccc">
                                @endforeach
                            @else
                            <p>Nothing To Show !</p>
                            @endif
                        </div>
                    </div>
                    <!-- END SAMPLE TABLE PORTLET-->
                </div>
                
            </div>
           <!------------------------------------------------------------------------------------------------>
            <div class="row" id="app-1">
                <div class="col-md-10">
                    <!-- BEGIN SAMPLE TABLE PORTLET-->
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-commenting font-green"></i>
                                <span class="caption-subject font-green bold uppercase">Comments</span>
                            </div>
                            
                        </div>
                        <div class="portlet-body">
                            <h3 class="sbold blog-comments-title">Leave A Comment</h3>
                            <form action="{{route('comment.store')}}" method="post">
                            @csrf
                            <input type="hidden" name="page" value="study_plan">
                            <input type="hidden" name="item_id" value="{{$id}}">
                            <div class="form-group">
                                <textarea rows="8" name="contant" placeholder="Write comment here ..." class="form-control c-square"></textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn blue uppercase btn-md sbold btn-block">Submit</button>
                            </div>
                        </form>
                          
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                @foreach($comments as $comment)
                                <div class="row" style="border-bottom: 1px solid #ccc; padding: 10px 0;">
                                    <div class="col-md-11">
                                        <h5><b>{{\App\User::find($comment->user_id)->name}}</b> <i style="color:#333;">{{$comment->created_at->diffForHumans()}}</i></h5>
                                        <p>{{$comment->contant}}</p>
                                        <b><a v-on:click="ShowReplyForm({{$comment->id}})">Reply</a></b>
                                    </div>

                                    {{--               Replies                       --}}
                                    <div class="row" id="replies" style="">
                                        @foreach(\App\Comment::whereIn('id', \App\Reply::where('reply_to_id','=',$comment->id)->pluck('comment_id')->toArray() )->orderBy('created_at', 'desc')->get() as $reply)
                                        <div class="col-md-10 col-md-offset-2">
                                            <h5><b>{{\App\User::find($reply->user_id)->name}}</b> <i style="color:#333;">{{$reply->created_at->diffForHumans()}}</i></h5>
                                            <p>{{$reply->contant}}</p>
                                        </div>
                                        @endforeach
                                    </div>


                                    {{-- Reply form --}}
                                    <div class="fluid-container" id="reply-form-{{$comment->id}}">
                                        
                                        {{-- <div class="row">
                                            <div class="col-md-10 col-md-offset-2">
                                                <form action="" method="post">
                                                    @csrf
                                                    
                                                    <input type="hidden" name="comment_id" value="">
                                                    <div class="form-group col-md-10" style="padding-left: 0 !important;">
                                                        <textarea rows="1" name="contant" placeholder="Write comment here ..." class="form-control c-square"></textarea>
                                                    </div>
                                                    <div class="form-group col-md-2">
                                                        <button type="submit" class="btn blue uppercase btn-md sbold btn-block">Reply</button>
                                                        <button v-on:click="removeReplyForm()" class="btn red uppercase btn-md sbold btn-block">Cancel</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>

                                
                                @endforeach

                                
                            </div>
                            
                        </div>
                        </div>
                    </div>
                    <!-- END SAMPLE TABLE PORTLET-->
                </div>
                
            </div>
           
           <!------------------------------------------------------------------------------------------------>
                <!--<div class="row" id="app-1">-->
                <!--    <div class="col-md-10 form-1" style="margin: 20px 0;" >-->
                         
                <!--        <h3 class="sbold blog-comments-title">Comments</h3>-->
                <!--        <h3 class="sbold blog-comments-title">Leave A Comment</h3>-->
                <!--        <form action="{{route('comment.store')}}" method="post">-->
                <!--            @csrf-->
                <!--            <input type="hidden" name="page" value="study_plan">-->
                <!--            <input type="hidden" name="item_id" value="{{$id}}">-->
                <!--            <div class="form-group">-->
                <!--                <textarea rows="8" name="contant" placeholder="Write comment here ..." class="form-control c-square"></textarea>-->
                <!--            </div>-->
                <!--            <div class="form-group">-->
                <!--                <button type="submit" class="btn blue uppercase btn-md sbold btn-block">Submit</button>-->
                <!--            </div>-->
                <!--        </form>-->

                <!--        <div class="row">-->
                <!--            <div class="col-md-10 col-md-offset-1">-->
                <!--                @foreach($comments as $comment)-->
                <!--                <div class="row" style="border-bottom: 1px solid #ccc; padding: 10px 0;">-->
                <!--                    <div class="col-md-11">-->
                <!--                        <h5><b>{{\App\User::find($comment->user_id)->name}}</b> <i style="color:#333;">{{$comment->created_at->diffForHumans()}}</i></h5>-->
                <!--                        <p>{{$comment->contant}}</p>-->
                <!--                        <b><a v-on:click="ShowReplyForm({{$comment->id}})">Reply</a></b>-->
                <!--                    </div>-->

                <!--                    {{--               Replies                       --}}-->
                <!--                    <div class="row" id="replies" style="">-->
                <!--                        @foreach(\App\Comment::whereIn('id', \App\Reply::where('reply_to_id','=',$comment->id)->pluck('comment_id')->toArray() )->orderBy('created_at', 'desc')->get() as $reply)-->
                <!--                        <div class="col-md-10 col-md-offset-2">-->
                <!--                            <h5><b>{{\App\User::find($reply->user_id)->name}}</b> <i style="color:#333;">{{$reply->created_at->diffForHumans()}}</i></h5>-->
                <!--                            <p>{{$reply->contant}}</p>-->
                <!--                        </div>-->
                <!--                        @endforeach-->
                <!--                    </div>-->


                <!--                    {{-- Reply form --}}-->
                <!--                    <div class="fluid-container" id="reply-form-{{$comment->id}}">-->
                                        
                <!--                        {{-- <div class="row">-->
                <!--                            <div class="col-md-10 col-md-offset-2">-->
                <!--                                <form action="" method="post">-->
                <!--                                    @csrf-->
                                                    
                <!--                                    <input type="hidden" name="comment_id" value="">-->
                <!--                                    <div class="form-group col-md-10" style="padding-left: 0 !important;">-->
                <!--                                        <textarea rows="1" name="contant" placeholder="Write comment here ..." class="form-control c-square"></textarea>-->
                <!--                                    </div>-->
                <!--                                    <div class="form-group col-md-2">-->
                <!--                                        <button type="submit" class="btn blue uppercase btn-md sbold btn-block">Reply</button>-->
                <!--                                        <button v-on:click="removeReplyForm()" class="btn red uppercase btn-md sbold btn-block">Cancel</button>-->
                <!--                                    </div>-->
                <!--                                </form>-->
                <!--                            </div>-->
                <!--                        </div> --}}-->
                <!--                    </div>-->
                <!--                </div>-->

                                
                <!--                @endforeach-->

                                
                <!--            </div>-->
                            
                <!--        </div>-->
                <!--    </div>-->
                <!--</div>-->
           
        </div>
    </div>

@endsection
@section('jscode')

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
<script src="{{ asset('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/morris/morris.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/morris/raphael-min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/counterup/jquery.waypoints.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/counterup/jquery.counterup.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/amcharts/amcharts/amcharts.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/amcharts/amcharts/serial.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/amcharts/amcharts/pie.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/amcharts/amcharts/radar.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/amcharts/amcharts/themes/light.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/amcharts/amcharts/themes/patterns.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/amcharts/amcharts/themes/chalk.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/amcharts/ammap/ammap.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/amcharts/ammap/maps/js/worldLow.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/amcharts/amstockcharts/amstock.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/fullcalendar/fullcalendar.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/horizontal-timeline/horozontal-timeline.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/flot/jquery.flot.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/flot/jquery.flot.resize.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/flot/jquery.flot.categories.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/jquery.sparkline.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/jqvmap/jqvmap/jquery.vmap.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js') }}" type="text/javascript"></script>
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

<script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>
    <script>
        

        


        var app = new Vue({
            el: '#app-1',

            data: {
                
            },
            methods: {
                _: function(ele){
                    return document.getElementById(ele);
                },
                ShowReplyForm:function(comment_id){
                    if(this._('reply-form-'+comment_id).innerHTML == ''){
                        this._('reply-form-'+comment_id).innerHTML = '<div class="row"><div class="col-md-10 col-md-offset-2"><form action="{{route("comment.reply")}}" method="post">@csrf<input type="hidden" name="reply_to_id" value="'+comment_id+'"><div class="form-group col-md-8" style="padding-left: 0 !important;"><textarea rows="1" name="contant" placeholder="Write comment here ..." class="form-control c-square"></textarea></div><div class="form-group col-md-4"><div class="row"><button type="submit" class="btn blue uppercase btn-md col-md-6 sbold">Reply</button></div></div></form></div></div>';
                    }else{
                        this._('reply-form-'+comment_id).innerHTML = '';
                    }
                },
                removeReplyForm: function(comment_id){
                    this._('reply-form-'+comment_id).innerHTML = '';
                    alert('ok');
                }


            }
        });
    </script>


@endsection
