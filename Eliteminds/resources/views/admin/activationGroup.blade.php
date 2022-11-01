@extends('layouts.app-1')

@section('pageTitle') Activation Group @endsection

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
            <!-- BEGIN PORTLET-->
            <div class="card card-custom">
                <div class="card-header">
                    <div class="card-title">
                    <span class="card-icon">
                        <i class="icon-2x  text-primary flaticon2-bell  "></i>
                    </span>
                        <h3 class="card-label">Activation Group</h3>
                    </div>
                </div>
                <div class="card-body">



                    <form class="form-horizontal form-bordered" method="POST" enctype="multipart/form-data" action="{{route('activation.group.store')}}">
                        @csrf
                        <div class="form-body">
                            <div class="form-group last">
                                <label class="control-label col-md-2">Email/s File (CSV)</label>
                                <div class="col-md-10">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="csv_file" id="csv_file">
                                        <label class="custom-file-label" for="csv_file">Choose file</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-body">
                            <div class="form-group last">
                                <label class="control-label col-md-2">Package</label>
                                <div class="col-md-10">
                                    <select name="package_id" class="form-control">
                                        <option value="">--</option>
                                        @foreach(\App\Packages::orderBy('created_at', 'desc')->get() as $package)
                                            <option value="{{$package->id}}">{{$package->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-body">
                            <div class="form-group last">
                                <label class="control-label col-md-2">Event</label>
                                <div class="col-md-10">
                                    <select name="event_id" class="form-control">
                                        <option value="">--</option>
                                        @foreach(\App\Event::orderBy('created_at', 'desc')->get() as $event)
                                            <option value="{{$event->id}}">{{$event->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="offset-md-10 col-md-2">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fa fa-check"></i> Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>


            </div>
            <!-- END PORTLET-->
        </div>
    </div>

@endsection

@section('jscode')
    <script src="{{asset('assets/plugins/custom/ckeditor/ckeditor-classic.bundle.js?v=7.0.4')}}"></script>
    <script src="{{asset('assets/js/pages/crud/forms/editors/ckeditor-classic.js?v=7.0.4')}}"></script>
@endsection
