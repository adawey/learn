
@extends('layouts.app-1')
@section('pageTitle') Coupons @endsection
@section('subheaderTitle') Coupons @endsection
@section('header')
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
@endsection
@section('content')


    <div class="row" style="background-color: white; padding: 0 0;">
        <div class="col-md-12">
            <div class="card card-custom">
                <div class="card-header">
                    <div class="card-title">
                    <span class="card-icon">
                        <i class="icon-3x  text-primary flaticon-gift"></i>
                    </span>
                        <h3 class="card-label">Coupons</h3>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover table-checkable" id="kt_datatable1" style="margin-top: 13px !important">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Product</th>
                            <th>Code</th>
                            <th>link</th>
                            <th>Coupon Price</th>
                            <th>No. of use Available</th>
                            <th>Expire In</th>
                            <th>Promoted</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count(\App\Coupon::all() ) )
                            @foreach(\App\Coupon::orderBy('created_at', 'desc')->paginate(25) as $coupon)


                                <tr
                                        @if(\Carbon\Carbon::parse($coupon->expire_date)->lt(\Carbon\Carbon::now()) || ($coupon->no_use) == 0)
                                        style="background-color: tomato; color:snow;"
                                        @endif

                                >
                                    <td>{{ $coupon->id }}</td>
                                    <td>
                                        @if($coupon->package_id)
                                            Package: {{ \App\Packages::find($coupon->package_id)->name }}
                                        @elseif($coupon->event_id)
                                            Event: {{ \App\Event::find($coupon->event_id)->name }}
                                        @endif
                                    </td>
                                    <td>{{ $coupon->code }}</td>
                                    <td>
                                        {{ route('generate.payment.with.coupon', $coupon->code) }}
                                    </td>
                                    <td>{{ $coupon->price }}</td>
                                    <td>{{ $coupon->no_use }}</td>
                                    @if(\Carbon\Carbon::parse($coupon->expire_date)->lt(\Carbon\Carbon::now()) || ($coupon->no_use) == 0 )
                                        <td>Expired  </td>
                                    @else
                                        <td>{{ $coupon->expire_date }}</td>
                                    @endif
                                    <td>@if($coupon->promote) Promoted @else -- @endif</td>
                                    <td>{{ $coupon->created_at }}</td>
                                    <td>
                                        <a href="{{route('coupon.destroy', $coupon->id)}}">Delete</a> |

                                        @if($coupon->promote)
                                            <a href="{{route('coupon.demote', $coupon->id)}}">Demote</a>
                                        @else
                                            <a href="{{route('coupon.promote', $coupon->id)}}">Promote</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <p>noting to show !</p>

                        @endif
                        </tbody>
                    </table>

                    <center>
                        {{ \App\Coupon::orderBy('created_at', 'desc')->paginate(25)->links() }}
                    </center>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('jscode')
    <script src="{{asset('assets/js/pages/crud/datatables/extensions/buttons.js?v=7.0.4')}}"></script>
    <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.4')}}"></script>
@endsection
