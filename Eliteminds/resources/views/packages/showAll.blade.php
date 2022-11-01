@extends('layouts.app-2')


@section('content')

    <div class="page-content-wrapper" id="app-1">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <!-- BEGIN PAGE HEADER-->
            <!-- BEGIN THEME PANEL -->
            <!-- END THEME PANEL -->
            <!-- BEGIN PAGE BAR -->
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="">Home</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span>Dashboard</span>
                    </li> 
                </ul>
                <div class="page-toolbar">
                    <div id="dashboard-report-range" class="pull-right tooltips btn btn-sm" data-container="body" data-placement="bottom" data-original-title="Change dashboard date range">
                        <i class="icon-calendar"></i>&nbsp;
                        <span class="thin uppercase hidden-xs"></span>&nbsp;
                    </div>
                </div>
            </div>
            <!-- END PAGE BAR -->
            <!-- BEGIN PAGE TITLE-->
            <h3 >
            </h3>
            <!-- END PAGE TITLE-->
            <!-- END PAGE HEADER-->
            
               
                    <!-- BEGIN WIDGET THUMB -->
                    @php    
                    $i =0;
                    @endphp
                    @if(count(\App\Packages::where('course_id', '=', $course_id)->get()))
                        @foreach(\App\Packages::where('course_id', '=', $course_id)->get() as $package)
                        @if( ($i == 0) || ($i%4) == 0 )
                            <div class="row widget-row">
                        @endif
                        <div class="col-md-3">
                            <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
                                <h4 class="widget-thumb-heading">{{$package->name}}</h4>
                                <div class="widget-thumb-wrap">
                                    <i class="widget-thumb-icon bg-red icon-rocket"></i>
                                    <div class="widget-thumb-body">
                                        @if($package->discount > 0)
                                        instead of <i style=" color: red; text-decoration: line-through;">{{round($package->original_price, 2) }}</i> $
                                        @endif
                                        </span>
                                        <span class="widget-thumb-body-stat">
                                        @if($package->price > 0)
                                            {{$package->price}} $
                                        @else 
                                            Free
                                        @endif
                                        </span>
                                    </div>
                                </div>
                                <hr>
                                <div class="description" style="">
                                    <p style="text-align: justify;">{!!$package->description!!}</p>
                                    <br>
									{{$package->expire_in_days}} day access.
                                    <hr>
                                    @if( !(\App\UserPackages::where('user_id','=', Auth::user()->id)->where('package_id','=',$package->id)->get()->first()) && !(\App\PaymentApprove::where('user_id','=', Auth::user()->id)->where('package_id','=',$package->id)->get()->first()) )
                                        <div class="order" style="display:flex; flex-direction:row; justify-content: flex-end;">

                                            <a class="btn  red" href="{{route('public.package.view', $package->id)}}" data-toggle="modal" href="#large"> Details</a>
{{--                                            <a class="btn  red" v-on:click="payModel({{$package->id}})" data-toggle="modal" href="#large"> ENROLL NOW </a>--}}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @php
                            $i++;
                        @endphp
                        @if( ($i == 0) || ($i%4) == 0 )
                            </div>
                        @endif
                            
                        @endforeach
                    @else
                        <p>Noting to show !</p>
                    @endif
                    
                    <!-- END WIDGET THUMB -->
                
                
        
            
                    <div class="modal fade bs-modal-lg" id="large" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h4 class="modal-title">Payment</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-8" >
                                            <div class="form-group row">
                                                <label class="control-label col-md-4 col-md-offset-2">
                                                    Payment Method
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-6">
                                                    <select name="paymentMethod" id="paymentMethod" class="form-control" v-model="paymentMethod" v-on:change="selectPaymentMethod">
                                                        <option value="null" selected disabled>choose ..</option>
                                                        <option value="paypal">Paypal</option>
                                                        <!--<option value="check">Bank Transfer</option>-->
                                                    </select>
                                                    <span class="help-block">please select the payment method</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="paypal_form" style="display:none">
                                            <div class="col-md-8" >
                                                <div class="form-group row">
                                                    <label class="control-label col-md-4 col-md-offset-2">
                                                        Seller Email
                                                        
                                                    </label>
                                                    <div class="col-md-6">
                                                        <label >engineersayed2089@gmail.com</label>
                                                        <span class="help-block" style="color:crimson;">make sure you are paying to this account</span>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group row">
                                                            <label class="control-label col-md-4 col-md-offset-2">
                                                                Coupon :
                                                            </label>
                                                            <div class="col-md-6">
                                                                <input type="text" class="form-control" v-model="coupon" id="coupon" placeholder="enter coupon if you have one !">
                                                                
                                                            </div>

                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 col-md-offset-6">
{{--                                                            <a v-on:click="redirect_pay" class="btn  btn-primary">Order Now</a>--}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        
                                    </div>
                                    <div class="row" id="check_form" style="display:none">
                                        <form action="{{route('pay.check')}}" method="POST" enctype="multipart/form-data" class="col-md-8">
                                            @csrf
                                            <input type="hidden" name="package_id" :value="package_id">
                                            <div class="form-group row">
                                                <label class="control-label col-md-4 col-md-offset-2">
                                                    Bank
                                                </label>
                                                <div class="col-md-6">
                                                    <label style="font-weight: bold;">National Bank Of Egypt , Faques Branch</label>
                                                    
                                                    
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="control-label col-md-4 col-md-offset-2">
                                                    
                                                </label>
                                                <div class="col-md-6">
                                                    <label style="font-weight: bold;">البنك الاهلي المصري</label>
                                                    
                                                    
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="control-label col-md-4 col-md-offset-2">
                                                    Bank Account
                                                </label>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control" disabled id="bank_account_id" value="{{ \App\PaypalConfig::all()->first()->bank_account }}">
                                                    
                                                    <span class="help-block">
                                                        <a class="btn btn-link" id="copy_btn" v-on:click="copy">Duoble click and Copy</a>
                                                    </span>
                                                    <span class="help-block" style="color:crimson;">please make a bank payment to this bank account and upload an image of a paper that prove the payment</span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="control-label col-md-4 col-md-offset-2">
                                                    Currency
                                                </label>
                                                <div class="col-md-6">
                                                    <label style="font-weight: bold;">United States Dollar ($)</label>
                                                    
                                                    
                                                </div>
                                            </div>
                                            
                                            <div class="form-group row">
                                                <label class="control-label col-md-4 col-md-offset-2">
                                                    Image
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-6">
                                                    <input type="file" name="img" id="img">
                                                    <span class="help-block">select an image</span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                
                                                <div class="col-md-6 col-md-offset-6">
                                                   <input type="submit" value="Order" class="btn btn-success">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                        
                                        
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->
        </div>
        <!-- END CONTENT BODY -->
    </div>
    <!-- END CONTENT -->
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
    <script src="{{ asset('assets/global/plugins/jquery-ui/jquery-ui.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/pages/scripts/ui-modals.min.js') }}" type="text/javascript"></script>
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
                
                package_id: '',
                paymentMethod: 'null',
                coupon: '',
                
            },
            methods: {
                payModel: function(package_id){
                    
                    this.package_id = package_id;
                },
                redirect_pay:function(){
                    Data = {
                        package_id: app.package_id,
                        coupon_code: app.coupon,
                    };

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    
                    $.ajax ({
                        type: 'POST',
                        url: '{{ route('generate.payment.link')}}', 
                        data: Data,
                        success: function(res){
                            window.location.href = res;        
                            
                        },
                        error: function(res){
                            console.log('Error:', res);    
                        }
                    });
                    
                    
                    
                },
                selectPaymentMethod: function(){
                    if(this.paymentMethod == 'paypal'){
                        $("#paypal_form").show();
                        $("#check_form").hide();
                    }else{
                        $("#paypal_form").hide();
                        $("#check_form").show();
                    }
                },
                copy: function(){
                    

                }
            }
        });
    </script>
@endsection