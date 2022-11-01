@extends('layouts.app-1')



@section('header')

<link href="{{ asset('assets/global/plugins/fancybox/source/jquery.fancybox.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/global/plugins/jquery-file-upload/blueimp-gallery/blueimp-gallery.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/global/plugins/jquery-file-upload/css/jquery.fileupload.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/global/plugins/jquery-file-upload/css/jquery.fileupload-ui.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/apps/css/inbox.min.css')}}" rel="stylesheet" type="text/css" />
@endsection



@section('content')
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content" style="min-height:1318px">
        <!-- END PAGE BAR -->
        <!-- BEGIN PAGE TITLE-->
        <h3 class="page-title"> Inbox
            <small>user inbox</small>
        </h3>
        <!-- END PAGE TITLE-->
        <!-- END PAGE HEADER-->
        <div class="inbox">
            <div class="row">
                <div class="col-md-2">
                    <div class="inbox-sidebar">
                        <a href="?compose=compose" data-title="Compose" class="btn red compose-btn btn-block">
                            <i class="fa fa-edit"></i> Compose </a>
                        <ul class="inbox-nav">
                            <li class="active">
                                <a href="?compose=inbox" data-type="inbox" data-title="Inbox"> Inbox
                                    
                                </a>
                            </li>
                            <li>
                                <a href="?compose=sent" data-type="sent" data-title="Sent"> Sent </a>
                            </li>
                            
                        </ul>
                        
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="inbox-body">
                        <div class="inbox-header">
                            

                            @if(Illuminate\Support\Facades\Input::get('compose') == 'compose')
                                <h1>Compose New Message</h1>
                                <form action="{{ route('admin.sendMessage') }}" method="POST" class="form-horizontal" style="background: white; padding: 30px 15px;">
                                    @csrf
                                    <div class="form-group form-md-line-input">
                                        <label class="col-md-2 control-label" for="form_control_1">To :</label>
                                        <div class="col-md-8">
                                        @if(Illuminate\Support\Facades\Input::get('toEmail'))
                                        <input type="text" class="form-control input-sm" name="send_to_email" placeholder="E-mail" value="{{Illuminate\Support\Facades\Input::get('toEmail')}}">
                                        @else
                                        <input type="text" class="form-control input-sm" name="send_to_email" placeholder="E-mail" value="" >
                                        @endif
                                            <div class="form-control-focus"> </div>
                                        </div>
                                    </div>
                                    <div class="form-group form-md-line-input">
                                        <label class="col-md-2 control-label" for="form_control_1">Message :</label>
                                        <div class="col-md-8">
                                            
                                            <textarea name="msg" class="form-control input-sm" placeholder="Your Message Here !" cols="30" rows="10"></textarea>
                                            <div class="form-control-focus"> </div>
                                        </div>
                                    </div>
                                    <div class="form-group control-label">
                                        <div class="col-md-2">
                                        <input type="submit" value="Send" class="btn btn-danger">
                                    </div>
                                    </div>
                                </form>



                                @if(Illuminate\Support\Facades\Input::get('toEmail'))

                                <div class="container">
                                    <div class="row" style="border:1px solid #ccc; padding: 10px 15px; border-radius: 10px !important;">
                                        <h3>latest conversation :</h3>
                                        @foreach(\App\Message::where('from_user_id',\App\User::where('email',Illuminate\Support\Facades\Input::get('toEmail'))->get()->first()->id)->where('from_user_type', 'user')->where('to_user_id',Auth::user()->id)->where('to_user_type', 'admin')->orderBy('created_at', 'desc')->get() as $m )
                                        <div class="col-md-2 col-md-offset-1" style="font-weight: bold;">
                                            {{\App\User::find($m->from_user_id)->name}} <br> <small>{{$m->created_at}} </small>
                                        </div>
                                        <div class="col-md-8" style="background-color:blanchedalmond; padding: 8px;">
                                            {{$m->message}}
                                        </div>
                                        @endforeach
                                        
                                    </div>

                                </div>

                                


                                @endif

                            @elseif(Illuminate\Support\Facades\Input::get('compose') == 'sent')

                                <h1 class="">Sent Messages</h1>
                                <div class="table-responsive ">          
                                    <table class="table table-borderless">
                                        <thead>
                                            <tr>

                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Message</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach(\App\Message::where('from_user_id', '=', Auth::user()->id)->where('from_user_type', '=', 'admin')->get() as $message)
                                                @if (\App\User::find($message->to_user_id))
                                                    <tr>
                                                        <td>{{ \App\User::find($message->to_user_id)->name }}</td>
                                                        <td>{{ \App\User::find($message->to_user_id)->email }}</td>
                                                        <td>{{ $message->message }}</td>
                                                    </tr>
                                                
                                                @elseif( \App\DisabledUser::where('user_id','=', $message->to_user_id) )
                                                    <tr>
                                                        <td>{{ \App\DisabledUser::where('user_id','=', $message->to_user_id)->get()->first()->name }}</td>
                                                        <td>{{ \App\DisabledUser::where('user_id','=', $message->to_user_id)->get()->first()->email }}</td>
                                                        <td>{{ $message->message }}</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <h1 class="">Inbox</h1>
                                <div class="table-responsive ">          
                                    <table class="table table-borderless">
                                        <thead>
                                            <tr>

                                                <th>Name</th>
                                                <th>Message</th>
                                                <th>--</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach(\App\Message::where('to_user_id', '=', Auth::user()->id)->where('to_user_type', '=', 'admin')->orderBy('created_at','desc')->get() as $message)
                                                @if (\App\User::find($message->from_user_id))
                                                <tr>
                                                    <td>{{ \App\User::find($message->from_user_id)->name }}</td>
                                                    <td>{{ $message->message }}</td>
                                                    <td>
                                                        <a href="{{route('admin.inbox')}}?compose=compose&toEmail={{ \App\User::find($message->from_user_id)->email }}">Relay</a>
                                                    </td>
                                                    
                                                </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif

                        </div>
                        <div class="inbox-content"></div>
                    </div>
                </div>
            </div>
        </div>
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
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="{{asset('assets/pages/scripts/dashboard.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>

        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="{{asset('assets/layouts/layout/scripts/layout.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/layouts/layout/scripts/demo.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/layouts/global/scripts/quick-sidebar.min.js')}}" type="text/javascript"></script>
        <!-- END THEME LAYOUT SCRIPTS -->

@endsection