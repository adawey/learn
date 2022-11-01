@extends('layouts.app-1')
@section('pageTitle') Feedback @endsection
@section('header')
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
@endsection
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
    <div class="row">
        <div class="col-md-12">

            <div class="card card-custom">
                <div class="card-header">
                    <div class="card-title">
                    <span class="card-icon">
                        <i class="icon-2x  text-primary flaticon-search"></i>
                    </span>
                        <h3 class="card-label">Search </h3>
                    </div>
                </div>
                <form class="card-body row" method="GET" action="">
                    <div class="col-md-1">
                        <label for="stars">Stars</label>
                    </div>
                    <div class="form-group col-md-4">

                        <input type="number" min="1" max="5" step="1" value="5" required name="stars" id="stars" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <input type="submit" value="Search" class="btn btn-primary">
                    </div>
                </form>
            </div>

            <div class="card card-custom mt-5">
                <div class="card-header">
                    <div class="card-title">
                    <span class="card-icon">
                        <i class="icon-2x  text-primary flaticon-user"></i>
                    </span>
                        <h3 class="card-label">Feedback</h3>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover table-checkable" id="kt_datatable1" style="margin-top: 13px !important">
                        <thead>
                        <tr>
                            <th> # </th>
                            <th> Name </th>
                            <th>Email</th>
                            <th>FeedBack</th>
                            <th>Stars Count</th>
                            <th>status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            if(request()->stars){
                                $feedback =  \App\Feedback::orderBy('created_at','desc')
                                    ->where('rate', request()->stars)->get();
                            }else{
                                $feedback =  \App\Feedback::orderBy('created_at','desc')->get();
                            }

                        @endphp
                        @foreach($feedback as $feed)
                            @if(\App\User::find($feed->user_id))

                            <tr>
                                <td></td>
                                <td>
                                    {{\App\User::find($feed->user_id)->name}}
                                </td>
                                <td>
                                    {{\App\User::find($feed->user_id)->email}}
                                </td>
                                <td>
                                    {{$feed->feedback}}
                                </td>
                                <td>
                                    {{$feed->rate}}star
                                </td>
                                <td>
                                    @if($feed->disable == 1)
                                        Disabled
                                    @else
                                        Active
                                    @endif
                                </td>
                                <td>
                                    <a href="{{route('users.feedback.disable.toggle', $feed->id)}}">
                                        @if($feed->disable == 1)
                                            Enable
                                        @else
                                            Disable
                                        @endif
                                    </a>
                                </td>
                            </tr>
                            @endif
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
    <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.4')}}"></script>s
@endsection
