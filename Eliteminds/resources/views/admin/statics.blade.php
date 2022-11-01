@extends('layouts.app-1')

@section('pageTitle') Statistics @endsection

@section('content')
    <div class="row" id="app">
        <div class="col-md-12">
            <!-- BEGIN PORTLET-->
            <div class="card card-custom">
                <div class="card-header">
                    <div class="card-title">
                    <span class="card-icon">
                        <i class="icon-2x  text-primary flaticon-graph"></i>
                    </span>
                        <h3 class="card-label">Statistics</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div>
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-lg-4">
                                    <label>Year:</label>
                                    <select name="year" id="year" class="form-control" v-model="year">
                                        <option value="all" >All</option>
                                        @php
                                            //first record - oldest
                                            $first = \Carbon\Carbon::parse(\App\Payments::all()->first()->created_at)->year;
                                            // last record - newer
                                            $last = \Carbon\Carbon::parse(\App\Payments::orderBy('created_at', 'desc')->get()->first()->created_at)->year;
                                            $i = $last - $first;
                                            $year_list = [];


                                            if($i > 0){
                                                $year_list = range($first, $last);
                                            }else{
                                                $year_list = [$first];
                                            }

                                        @endphp

                                        @foreach($year_list as $y)
                                            <option value="{{$y}}" >{{$y}}</option>
                                        @endforeach
                                    </select>
                                    <span class="form-text text-muted">Limit the search to specific year</span>
                                </div>
                                <div class="col-lg-4">
                                    <label>Month:</label>
                                    <select name="month" id="month" v-model="month" class="form-control">
                                        <option value="all">All</option>

                                        @foreach(range(1,12) as $m)
                                            <option value="{{$m}}" >{{$m}}</option>
                                        @endforeach
                                    </select>
                                    <span class="form-text text-muted">Limit the search to specific month</span>
                                </div>
                                <div class="col-lg-4">
                                    <label for="product">Product:</label>
                                    <select name="product" id="product" class="form-control" v-model="product">

                                        <optgroup label="Packages">
                                            <option value="p_all">All Packages</option>
                                            @php
                                                $packages = \App\Packages::where('course_id', $course_id)->orderBy('created_at', 'desc')->get();
                                            @endphp
                                            @foreach($packages as $package)
                                                <option value="p_{{$package->id}}">{{$package->name}}</option>
                                            @endforeach
                                        </optgroup>

                                        <optgroup label="Events">
                                            <option value="e_all">All Events</option>
                                            @php
                                                $events = \App\Event::where('course_id', $course_id)->orderBy('created_at', 'desc')->get();
                                            @endphp
                                            @foreach($events as $event)
                                                <option value="e_{{$event->id}}">{{$event->name}}</option>
                                            @endforeach
                                        </optgroup>

                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                </div>
                                <div class="col-lg-6 text-right">
                                    <button type="button" @click="search" class="btn btn-primary">Search</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="portlet light bordered">
                                <div class="row widget-row">
                                    <div class="col-md-2">
                                        <!-- BEGIN WIDGET THUMB -->
                                        <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
                                            <h4 class="widget-thumb-heading">Payments</h4>
                                            <div class="widget-thumb-wrap">
                                                <div class="widget-thumb-body">
                                                    <span class="widget-thumb-body-stat" data-counter="counterup">@{{payments_no}}</span>
                                                    Payment
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END WIDGET THUMB -->
                                    </div>
                                    <div class="col-md-2">
                                        <!-- BEGIN WIDGET THUMB -->
                                        <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
                                            <h4 class="widget-thumb-heading">PayPAl&amp;VISA</h4>
                                            <div class="widget-thumb-wrap">

                                                <div class="widget-thumb-body">
                                                    <span class="widget-thumb-body-stat" data-counter="counterup">@{{paypal_payments_revenue}}</span>
                                                    USD
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END WIDGET THUMB -->
                                    </div>
                                    <div class="col-md-2">
                                        <!-- BEGIN WIDGET THUMB -->
                                        <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
                                            <h4 class="widget-thumb-heading">TAP</h4>
                                            <div class="widget-thumb-wrap">
                                                <div class="widget-thumb-body">
                                                    <span class="widget-thumb-body-stat" data-counter="counterup">@{{tap_payments_revenue}} </span>
                                                    USD
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END WIDGET THUMB -->
                                    </div>

                                    <div class="col-md-2">
                                        <!-- BEGIN WIDGET THUMB -->
                                        <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
                                            <h4 class="widget-thumb-heading">ToTAl</h4>
                                            <div class="widget-thumb-wrap">
                                                <div class="widget-thumb-body">
                                                    <span class="widget-thumb-body-stat" data-counter="counterup">@{{paypal_payments_revenue + tap_payments_revenue}}</span>
                                                    USD
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END WIDGET THUMB -->
                                    </div>
                                    <div class="col-md-2">
                                        <!-- BEGIN WIDGET THUMB -->
                                        <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
                                            <h4 class="widget-thumb-heading">Package Price</h4>
                                            <div class="widget-thumb-wrap">
                                                <div class="widget-thumb-body">
                                                    <span class="widget-thumb-body-stat" data-counter="counterup">
                                                        @{{ product_price }}
                                                    </span>
                                                    USD
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END WIDGET THUMB -->
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 20px;">
                        <div class="col-md-12">
                            <!-- BEGIN EXAMPLE TABLE PORTLET-->
                            <div class="portlet light bordered">
                                <div class="portlet-body">
                                    <table class="table table-bordered table-hover table-checkable" style="margin-top: 13px !important">
                                        <thead>
                                            <tr>
                                                <th> User </th>
                                                <th> Date </th>
                                                <th> Product </th>
                                                <th> Revenue </th>
                                                <th> Payment Method </th>
                                                <th> Coupon Code</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <tr v-for="i in payments">
                                                <td>@{{ i.user_name }}</td>
                                                <td>@{{ i.created_at }}</td>
                                                <td>@{{ i.product_name }}</td>
                                                <td>@{{ i.totalPaid }}</td>
                                                <td>@{{ i.paymentMethod }}</td>
                                                <td>@{{ i.coupon_code }}</td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- END EXAMPLE TABLE PORTLET-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('jscode')
    <script src="{{asset('assets/js/pages/crud/datatables/extensions/buttons.js?v=7.0.4')}}"></script>
    <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.4')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>
    <script>
        app = new Vue({
            el: '#app',
            data: {
                course_id: '{{$course_id}}',
                year: 'all',
                month: 'all',
                product: 'p_all',
                product_price: '--',
                payments_no: 0,
                payments: [],
                paypal_payments: [],
                tap_payments: [],
            },
            mounted(){
                this.loader();
            },
            computed: {
                paypal_payments_revenue: function(){
                    total = 0;
                    for (const [key, value] of Object.entries(this.paypal_payments)) {
                        total += parseFloat(value.totalPaid);
                    }
                    return Math.round(total * 100) /100;
                },
                tap_payments_revenue: function(){
                    total = 0;
                    for (const [key, value] of Object.entries(this.tap_payments)) {
                        total += parseFloat(value.totalPaid);
                    }
                    return Math.round(total * 100) /100;
                },
            },
            methods: {
                loader: function(){
                    KTApp.blockPage();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}'
                        }
                    });
                    $.ajax({
                        url: '{{route('statics.query')}}',
                        method: 'POST',
                        data: {
                            course_id: this.course_id,
                            year: this.year,
                            month: this.month,
                            product: this.product,
                        },
                        success: function(res){
                            app.payments = res.payments;
                            app.paypal_payments = res.paypal_payments;
                            app.tap_payments = res.tap_payments;
                            app.payments_no = res.payments_no;
                            app.product_price  = res.product_price;
                            KTApp.unblockPage();
                        },
                        error: function(err){console.log(err)}
                    });
                },
                search: function(){
                    this.payments = [];
                    this.paypal_payments = [];
                    this.tap_payments = [];
                    this.payments_no = 0;
                    this.package_price  = '--';
                    this.loader();

                }
            },
        });
    </script>
@endsection

