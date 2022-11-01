@extends('layouts.app-1')


@section('header')
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link href="{{asset('assets/global/css/components.min.css')}}" rel="stylesheet" id="style_components" type="text/css" />
    <link href="{{asset('assets/global/css/plugins.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/global/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="{{asset('assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/global/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/jquery-te-1.4.0.css')}}" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS -->
@endsection

@php
    $see = \App\PageComment::where('page', $page)->get();
    foreach($see as $s){
        $s->sight = 1;
        $s->save();
    }

@endphp

@section('content')
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    
        
    <div class="page-content">
        <!-- BEGIN PAGE HEAD-->
        
        <div class="page-head">
            <!-- BEGIN PAGE TITLE -->
            
            <!-- END PAGE TITLE -->                        <!-- BEGIN PAGE TOOLBAR -->
            
            <!-- END PAGE TOOLBAR -->
        </div>
        <!-- END PAGE HEAD-->
        <!-- BEGIN PAGE BREADCRUMB -->
        
        <!-- END PAGE BREADCRUMB -->
        <!-- BEGIN PAGE BASE CONTENT -->
        <div class="row" id="app-1">
            <div class="col-md-12">
                <!-- BEGIN PORTLET-->
                <div class="portlet light form-fit bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-settings font-green"></i>
                            <span class="caption-subject font-green sbold uppercase">Comments | {{$page}}</span>
                        </div>
                       
                    </div>
                    <div class="portlet-body form">
                        
                        <div class="container">
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1">
                                    @foreach($comments as $comment)
                                    
                                    <div class="row" style="border-bottom: 1px solid #ccc; padding: 10px 0;">
                                        <div class="col-md-11">
                                            <h5><b>{{\App\User::find($comment->user_id)->name}}</b> <i style="color:#333;">{{$comment->created_at->diffForHumans()}}</i></h5>
                                            
                                            @if($page == 'video')
                                                <h5><i><b>Course:</b> {{\App\Course::find(\App\Chapters::find(\App\Video::find(\App\PageComment::where('comment_id', $comment->id)->get()->first()->item_id)->chapter)->course_id)->title}}</i></h5>
                                                <h5><i><b>Video:</b> {{\App\Video::find(\App\PageComment::where('comment_id', $comment->id)->get()->first()->item_id)->title}}</i></h5>                                            
                                            @elseif($page == 'chapter')
                                                <h5><i><b>Course:</b> {{\App\Course::find(\App\Chapters::find(\App\PageComment::where('comment_id', $comment->id)->get()->first()->item_id)->course_id)->title}}</i></h5>
                                                <h5><i><b>Chapter:</b> {{\App\Chapters::find(\App\PageComment::where('comment_id', $comment->id)->get()->first()->item_id)->name}}</i></h5>
                                            @elseif($page == 'exam')
                                                <h5><i><b>Exam:</b> Exam {{\App\PageComment::where('comment_id', $comment->id)->get()->first()->item_id}}</i></h5>
                                            @elseif($page == 'process_group')
                                                <h5><i><b>Process Group:</b> {{\App\Process_group::find(\App\PageComment::where('comment_id', $comment->id)->get()->first()->item_id)->name}}</i></h5>
                                            @endif
                                        
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
                                    {{\App\Comment::whereIn('id',\App\PageComment::where('page', $page)->pluck('comment_id')->toArray())->paginate(15)->links()}}
    
                                    
                                </div>
                                
                            </div>
                        </div>

                        
                    </div>


                </div>
                <!-- END PORTLET-->
            </div>
        </div>
        <!-- END PAGE BASE CONTENT -->
        
    </div>

    
    <!-- END CONTENT BODY -->
</div>
@endsection

@section('jscode')
        <!-- BEGIN CORE PLUGINS -->
        <script src="{{asset('assets/global/plugins/jquery.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/global/plugins/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/global/plugins/js.cookie.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/global/plugins/jquery.blockui.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="{{asset('assets/global/plugins/moment.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/global/plugins/morris/morris.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/global/plugins/morris/raphael-min.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/global/plugins/counterup/jquery.waypoints.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/global/plugins/counterup/jquery.counterup.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/global/plugins/amcharts/amcharts/amcharts.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/global/plugins/amcharts/amcharts/serial.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/global/plugins/amcharts/amcharts/pie.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/global/plugins/amcharts/amcharts/radar.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/global/plugins/amcharts/amcharts/themes/light.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/global/plugins/amcharts/amcharts/themes/patterns.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/global/plugins/amcharts/amcharts/themes/chalk.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/global/plugins/amcharts/ammap/ammap.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/global/plugins/amcharts/ammap/maps/js/worldLow.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/global/plugins/amcharts/amstockcharts/amstock.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/global/plugins/fullcalendar/fullcalendar.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/global/plugins/horizontal-timeline/horozontal-timeline.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/global/plugins/flot/jquery.flot.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/global/plugins/flot/jquery.flot.resize.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/global/plugins/flot/jquery.flot.categories.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/global/plugins/jquery.sparkline.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/global/plugins/jqvmap/jqvmap/jquery.vmap.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js')}}" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="{{asset('assets/global/scripts/app.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/global/plugins/bootstrap-markdown/lib/markdown.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/global/plugins/bootstrap-markdown/js/bootstrap-markdown.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/global/plugins/bootstrap-summernote/summernote.min.js')}}" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="{{asset('assets/pages/scripts/dashboard.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/pages/scripts/components-editors.min.js')}}" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="{{asset('assets/layouts/layout/scripts/layout.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/layouts/layout/scripts/demo.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/layouts/global/scripts/quick-sidebar.min.js')}}" type="text/javascript"></script>
        <!-- END THEME LAYOUT SCRIPTS -->

        <script src="{{asset('assets/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/global/plugins/bootstrap-markdown/lib/markdown.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/global/plugins/bootstrap-markdown/js/bootstrap-markdown.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/global/plugins/bootstrap-summernote/summernote.min.js')}}" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="{{asset('assets/pages/scripts/components-editors.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/jquery-te-1.4.0.min.js')}}" type="text/javascript"></script>

        <script>
            $('.jqte-test').jqte();
            
            // settings of status
            var jqteStatus = true;
            $(".status").click(function()
            {
                jqteStatus = jqteStatus ? false : true;
                $('.jqte-test').jqte({"status" : jqteStatus})
            });
        </script>


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
                            this._('reply-form-'+comment_id).innerHTML = '<div class="row"><div class="col-md-10 col-md-offset-2"><form action="{{route("comment.admin.reply")}}" method="post">@csrf<input type="hidden" name="reply_to_id" value="'+comment_id+'"><div class="form-group col-md-8" style="padding-left: 0 !important;"><textarea rows="1" name="contant" placeholder="Write comment here ..." class="form-control c-square"></textarea></div><div class="form-group col-md-4"><div class="row"><button type="submit" class="btn blue uppercase btn-md col-md-6 sbold">Reply</button></div></div></form></div></div>';
                        }else{
                            this._('reply-form-'+comment_id).innerHTML = '';
                        }
                    },
                    removeReplyForm: function(comment_id){
                        this._('reply-form-'+comment_id).innerHTML = '';
                        alert('ok');
                    },
                    


                }
            });
        </script>
        
@endsection