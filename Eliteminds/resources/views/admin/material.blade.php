@extends('layouts.app-1')

@section('pageTitle') Add Material @endsection
@section('subheaderTitle') Material @endsection
@section('subheaderNav')
    <!--begin::Button-->
    <a href="#" onclick="document.getElementById('materialForm').submit()" class="btn btn-fh btn-white btn-hover-primary font-weight-bold px-2 px-lg-5 mr-2">
    <span class="svg-icon svg-icon-success svg-icon-lg">
        <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Add-user.svg-->
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <rect x="0" y="0" width="24" height="24"/>
                <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10"/>
                <path d="M11,11 L11,7 C11,6.44771525 11.4477153,6 12,6 C12.5522847,6 13,6.44771525 13,7 L13,11 L17,11 C17.5522847,11 18,11.4477153 18,12 C18,12.5522847 17.5522847,13 17,13 L13,13 L13,17 C13,17.5522847 12.5522847,18 12,18 C11.4477153,18 11,17.5522847 11,17 L11,13 L7,13 C6.44771525,13 6,12.5522847 6,12 C6,11.4477153 6.44771525,11 7,11 L11,11 Z" fill="#000000"/>
            </g>
        </svg>
        <!--end::Svg Icon-->
    </span>Submit</a>
    <!--end::Button-->

@endsection

@section('content')
    <div class="card card-custom">

        <form action="{{route('material.add')}}" method="post" id="materialForm" class="form-horizontal form-bordered" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="card-header">
                    <h3>Add Material</h3>
                </div>
                <div class="form-group-lg py-5 row">
                    <label class="col-md-1 col-form-label">Title</label>
                    <div class="col-md-5">
                        <input class="form-control" type="text" placeholder="Title" name="title"/>
                    </div>

                    <label class="col-md-1 col-form-label">Course</label>
                    <div class="col-md-5">
                        <select name="course_id" id="course_id" class="form-control">
                            @foreach(\App\Course::all() as $q)
                                <option value="{{$q->id}}">{{$q->title}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group-lg py-5 row">
                    <label class="col-md-1 col-form-label">Material File</label>
                    <div class="col-md-5">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="file">
                            <label class="custom-file-label" for="img_medium">Choose file</label>
                        </div>
                    </div>

                    <label class="col-md-1 col-form-label">Cover Img</label>
                    <div class="col-md-5">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="cover">
                            <label class="custom-file-label" for="img_medium">Choose file</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-2">
                    </div>
                    <div class="col-10">
                        <button type="submit" class="btn btn-success mr-2">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="card card-custom mt-5">


        <div class="card-body">
            <div class="card-header">
                <h3>Materials</h3>
            </div>
            <div class="form-horizontal form-md-line-input" style="background: white; padding: 30px 15px; margin-top:20px;">
                <table class="table table-bordered table-hover table-checkable" id="kt_datatable" style="margin-top: 13px !important">
                    <thead>
                    <th>#</th>
                    <th>Title</th>
                    <th>Course</th>
                    <th>Date</th>
                    <th>update cover</th>
                    <td>Action</td>
                    </thead>
                    <tbody>
                    @foreach($materials as $q)
                        <tr>
                            <td></td>
                            <td>{{$q->title}}</td>
                            <td>{{$q->course_title}}</td>
                            <td>{{$q->created_at}}</td>
                            <td>
                                <form action="{{route('material.update')}}" enctype="multipart/form-data" style="display:inline-block;" method="POST">
                                    @csrf
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="cover" onchange="this.form.submit()">
                                        <label class="custom-file-label" for="img_medium">Choose file</label>
                                    </div>
                                    <input type="hidden" name="material_id" value="{{$q->id}}" style="display:inline-block;">
                                </form>
                            </td>
                            <td>
                                <a href="{{route('material.delete', $q->id)}}">Delete</a>
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
@endsection
