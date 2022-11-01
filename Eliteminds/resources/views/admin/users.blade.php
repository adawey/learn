@extends('layouts.app-1')
@section('pageTitle') All Users @endsection
@section('header')
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
@endsection

@section('content')
    <div class="row">
        <!-- BEGIN PAGE TITLE-->
        <div class="col-md-12">

            <div class="card card-custom">
                <div class="card-header">
                    <div class="card-title">
                    <span class="card-icon">
                        <i class="icon-2x  text-primary flaticon-search-magnifier-interface-symbol"></i>
                    </span>
                        <h3 class="card-label">Search </h3>
                    </div>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('search.user.by.email') }}" class="" style=" background-color: white; padding: 20px 20px;">
                        @csrf
                        <div class="form-group row">
                            <lable class="col-md-2">E-Mail:</lable>
                            <input type="text" name="email" placeholder="Email .."  class="col-md-6 form-control">
                            <input type="submit" value="Search" class="btn btn-success offset-md-1 col-md-1">
                        </div>
                    </form>

                    <form method="GET" action="{{ route('search.user.by.package') }}"  style=" background-color: white; padding: 20px 20px;">
                        @csrf

                        <div class="form-group row">
                            <lable class="col-md-2">Package:</lable>
                            <select class="col-md-6 form-control" name="package_id" id="package_id">
                                <option></option>
                                @foreach(\App\Packages::where('active','=', 1)->get() as $package)
                                    <option
                                            @if($package->id == Illuminate\Support\Facades\Input::get('package_id'))
                                            selected
                                            @endif
                                            value="{{$package->id}}">{{$package->name}}</option>
                                @endforeach
                            </select>
                            <input type="submit" value="Search" class="btn btn-success offset-md-1 col-md-1">
                        </div>
                    </form>

                    <form method="GET" action="{{ route('search.user.by.event') }}"  style=" background-color: white; padding: 20px 20px;">
                        @csrf

                        <div class="form-group row">
                            <lable class="col-md-2">Event:</lable>
                            <select class="col-md-6 form-control" name="event_id" id="event_id">
                                @foreach(\App\Event::all() as $event)
                                    <option
                                            @if($event->id == Illuminate\Support\Facades\Input::get('event_id'))
                                            selected
                                            @endif
                                            value="{{$event->id}}">{{$event->name}}</option>
                                @endforeach
                            </select>
                            <input type="submit" value="Search" class="btn btn-success offset-md-1 col-md-1">
                        </div>
                    </form>



                </div>
            </div>




            <div class="card card-custom mt-5">
                <div class="card-header">
                    <div class="card-title">
                    <span class="card-icon">
                        <i class="icon-2x  text-primary flaticon-users-1"></i>
                    </span>
                        <h3 class="card-label">Users </h3>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover table-checkable" id="kt_datatable1" style="margin-top: 13px !important">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>

                            <th>Email</th>
                            <th>Country</th>
                            <th>City</th>
                            <th>Phone</th>
                            <th>Last IP</th>
                            <th>Last Sever IP</th>
                            <th>Last Action</th>
                            <th>Last Login</th>
                            <th>Sales Status</th>
                            <th>Created At</th>
                            <th>--</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!count($users))
                            <p>nothing !</p>
                        @endif
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td class="editableEmail" data-key="{{$user->id}}">{{ $user->email }}</td>
                                <td>{{ $user->country }}</td>
                                <td>{{ $user->city }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>{{ $user->last_ip }}</td>
                                <td>{{ $user->last_server_ip }}</td>
                                <td>{{ $user->last_action }}</td>
                                <td>
                                    @if($user->last_login != '')
                                        {{\Carbon\Carbon::parse($user->last_login)->diffForHumans()}}
                                    @else
                                        --
                                    @endif
                                </td>
                                <td>
                                    <i class="fa fa-dollar-sign"
                                       @if(\App\Payments::where('user_id','=', $user->id)->get()->first())
                                       style="color: goldenrod"
                                            @endif
                                    ></i>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($user->created_at)->diffForHumans() }}</td>
                                <td>
                                    <a href="{{route('admin.user.disable', $user->id)}}">Disable</a> -
                                    <a href="{{route('admin.user.manual.add.package', $user->id)}}">Add Package</a> -
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <center>

                    </center>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('jscode')
    <script src="{{asset('assets/js/pages/crud/datatables/extensions/buttons.js?v=7.0.4')}}"></script>
    <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.4')}}"></script>
    <script src="https://unpkg.com/sweetalert2@7.8.2/dist/sweetalert2.all.js"></script>
    <script src="{{asset('js/jquery.editable.min.js')}}"></script>
    <script>
        $(function(){
            $(".editableEmail").editable({
                event: 'dblclick',
                touch: true,
                closeOnEnter: true,
                lineBreaks: false,
                emptyMessage: 'enter Email',
                callback: function(data){

                    newEmailValue = data.$el[0].textContent;
                    userId = data.$el[0].attributes['data-key'].nodeValue;
                    thisEle = $("[data-key="+userId+"]")[0]; // .innerText



                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}'
                        }
                    });

                    $.ajax ({
                        type: 'POST',
                        url: '{{ route('update.email')}}',
                        data: {
                            newEmailValue: newEmailValue,
                            userId: userId,
                        },
                        success: function (res) {
                            swal({
                                title: res[0].code == 200 ? res[0].success : res[0].error,
                                type: res[0].code == 200 ? 'success':'warning',
                                confirmButtonText: 'Ok'
                            });
                            thisEle.innerText = res[0].data['email'];
                        },
                        error: function (error) {
                            console.log('Error: ', error);
                        }
                    });


                }
            });
        });
    </script>
@endsection
