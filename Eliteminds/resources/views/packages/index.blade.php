@extends('layouts.app-1')
@section('pageTitle') All Packages @endsection
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card card-custom">
                <div class="card-header">
                    <div class="card-title">
                    <span class="card-icon">
                        <i class="icon-2x  text-primary flaticon2-box"></i>
                    </span>
                        <h3 class="card-label">Packages</h3>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover table-checkable" id="kt_datatable1" style="margin-top: 13px !important">

                        <thead>
                        <tr>
                            <th>Package</th>
                            <th>Price</th>
                            <th>Original price</th>
                            <th>Discount</th>
                            <th>Extension Price</th>
                            <th>Expire In</th>
                            <th>Extend For</th>
                            <th>Edit</th>
                            <th>State</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>

                        @if(count($packages) > 0)
                            @foreach($packages as $package)
                                <tr>
                                    <td>{{$package->name}}</td>
                                    <td>{{$package->price}} $</td>
                                    <td>{{$package->original_price}} $</td>
                                    <td>{{$package->discount}} %</td>
                                    <td>{{$package->extension_price }} $</td>
                                    <td>{{$package->expire_in_days}} day(s)</td>
                                    <td>{{$package->extension_in_days}} day(s)</td>

                                    <td><a href="{{ route('packages.edit', $package->id) }}">Edit</a></td>
                                    <td>
                                        @if($package->active == 1)
                                            Enabled
                                        @else
                                            Disabled
                                        @endif
                                    </td>
                                    <td style="font-size: 22px; display:flex; ">
                                        <a data-toggle="modal" data-target="#DeleteModal-{{$package->id}}" style="cursor:pointer;">
                                            @if($package->active == 1)
                                                <i class="fa fa-eye" style="color: #5bc0de;"></i>
                                            @else
                                                <i class="fa fa-eye-slash" style="color: #ccc;"></i>
                                            @endif
                                        </a>

                                        <div class="modal fade" id="DeleteModal-{{$package->id}}" role="dialog">
                                            <div class="modal-dialog">

                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-header" style="text-align: left;">
                                                        <h4 class="modal-title">Warning</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        @if($package->active == 0)
                                                            <p>
                                                                This package is already Disabled. Do you like to Enable it Again ?
                                                            </p>
                                                        @else
                                                            <p>
                                                                Deleting the package means that no one have the chooise to buy this package
                                                                but it still available for the current users who already bought it.
                                                                Are You sure ?
                                                            </p>
                                                        @endif

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        {!! Form::open(['action'=>['packageController@destroy', $package->id], 'method'=>'POST']) !!}
                                                        {{Form::hidden('_method', 'DELETE')}}
                                                        @if($package->active == 0)
                                                            {{Form::submit('Enable', ['class'=>'btn btn-primary'])}}
                                                        @else
                                                            {{Form::submit('Disable', ['class'=>'btn btn-danger'])}}
                                                        @endif
                                                        {!! Form::close() !!}
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <p>No Content !</p>
                        @endif


                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('jscode')
    <script src="{{asset('assets/js/pages/crud/datatables/extensions/buttons.js?v=7.0.4')}}"></script>
    <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.4')}}"></script>
@endsection
