@extends('layouts.app-1')
@section('pageTitle') Package/Event @endsection
@section('subheaderTitle') {{ $user->name }} / {{$user->email}} @endsection
@section('subheaderNav')

    <!--begin::Button-->
    <a href="{{route('showAllUsers')}}" class="btn btn-fh btn-white btn-hover-primary font-weight-bold px-2 px-lg-5 mr-2">
    <span class="svg-icon svg-icon-success svg-icon-lg">
        <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Add-user.svg-->
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <polygon points="0 0 24 0 24 24 0 24"/>
                <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero"/>
            </g>
        </svg>
        <!--end::Svg Icon-->
    </span>All Users</a>
    <!--end::Button-->
@endsection
@section('content')

        <div class="card card-custom">
            <div class="card-body">
                <div class="card-header">
                    <h3>Packages</h3>
                </div>
                <!-- END PAGE TITLE-->
                <!-- END PAGE HEADER-->


                <form action="{{route('admin.user.manual.add.package.post')}}" method="POST" class="form-horizontal" style="background: white; padding: 30px 15px;">
                    @csrf
                    <div class="form-group form-md-line-input">
                        <label class="col-md-2 control-label" for="form_control_1">Pakcage List :</label>
                        <div class="col-md-8">
                            <input type="hidden" name="user_id" value="{{$user->id}}">
                            <select type="text" class="form-control input-sm" name="package_id" >
                                <option value="null" disabled selected>choose package ..</option>
                                @foreach(\App\Packages::all() as $package)
                                    @if(!\App\UserPackages::where('user_id', '=',$user->id)->where('package_id','=', $package->id)->get()->first() )
                                        <option value="{{$package->id}}">{{$package->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group control-label">
                        <div class="col-md-2">
                            <input type="submit" value="Add" class="btn btn-success">
                        </div>
                    </div>
                </form>
                <div class="card-header">
                    <h3>User Packages</h3>
                </div>
                <div class="form-horizontal form-md-line-input" style="background: white; padding: 30px 15px; margin-top:20px;">
                    <table class="table table-bordered table-hover table-checkable" id="kt_datatable" style="margin-top: 13px !important">
                        <thead>
                        <th>Name</th>
                        <th>price</th>
                        <th>Created At</th>
                        <th>Expire at</th>
                        <th>Extend For n (days)</th>
                        <th>Delete</th>
                        </thead>
                        <tbody>
                        @foreach(\App\UserPackages::where('user_id', '=' ,$user->id)->orderBy('created_at','desc')->get() as $package)
                            <tr>
                                <td>{{\App\Packages::find($package->package_id)->name}}</td>
                                <td>{{\App\Packages::find($package->package_id)->price}}</td>
                                <td>{{ $package->created_at }}</td>
                                <td>{{\Carbon\Carbon::parse($package->created_at)->addDays((\App\Packages::find($package->package_id))->expire_in_days) }}</td>
                                <td>
                                    <a href="javascript:;" onclick="extendFor({{$package->package_id}}, 'package')">Extend</a>
                                </td>
                                <td>
                                    <a href="{{route('remove.user.package', [$user->id, $package->package_id])}}">Remove</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


@endsection

@section('jscode')
    <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
    <script src="{{asset('assets/js/pages/crud/datatables/data-sources/html.js')}}"></script>
    <script>
        function extendFor(item_id, item_type){
            html = `
                <div class="form-group  row mb-0 ">
                    <label class="col-12 col-form-label" style="text-align: left;" for="example-text-input">Enter Number of Days:</label>
                </div>
                <div class="form-group  row mb-0 ">
                    <div class="col-12">
                        <input class="form-control" type="text" placeholder="days" id="n_days"/>
                    </div>
                </div>
            `;

            swal({
                html,
                confirmButtonText: 'Confirm',
                showCancelButton: true,
                preConfirm: function() {
                    return new Promise((resolve, reject) => {
                        // get your inputs using their placeholder or maybe add IDs to them
                        resolve({
                            n_days : $('input[id="n_days"]').val(),
                        });
                        // maybe also reject() on some condition
                    });
                }
            }).then((data) => {
                // your input data object will be usable from here
                if(data.dismiss != 'cancel'){

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}',
                        },
                    });
                    $.ajax({
                        async: true,
                        url: '{{route('admin.user.manual.time.extends')}}',
                        method: 'POST',
                        data: {
                            user_id: '{{$user->id}}',
                            n_days: data.value.n_days,
                            item_type,
                            item_id,
                        },
                        success:function(res){
                            swal({
                                type: 'info',
                                title:'Info',
                                text: res.message,
                                confirmButtonText: 'Ok',
                            });
                        },
                        error: function(error){
                            console.log('Error: ', error);
                        }

                    });
                }

            });
        }
    </script>
@endsection

