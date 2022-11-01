@extends('layouts.app-1')
@section('pageTitle') Explanation @endsection
@section('subheaderTitle') Explanation @endsection
@section('subheaderNav')
    <!--begin::Button-->
    <a href="#" onclick="AVUtil().redirectionConfirmation('{{route('explanation.create')}}')" class="btn btn-fh btn-white btn-hover-primary font-weight-bold px-2 px-lg-5 mr-2">
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
    </span>New</a>
    <!--end::Button-->

@endsection
@section('content')



    <div class="row" id="app-1" style="">
        <div class="col-md-12">
            <div class="card card-custom">
                <div class="card-header">
                    <div class="card-title">
                    <span class="card-icon">
                        <i class="icon-2x  text-primary flaticon-search"></i>
                    </span>
                        <h3 class="card-label">Search</h3>
                    </div>
                </div>
                <div class="card-body">
                    {!! Form::open(['action'=>'ExplanationController@index', 'method'=>'GET', 'class'=>'', 'style'=>'margin: 10px 0 20px 0;']) !!}
                    <div class="row">
                        <div class="form-group col-md-12" style="">
                            <div class="row">
                                <div class="col-sm-2">
                                    <strong>{{Form::label('word','Search :')}}</strong>
                                </div>
                                <div class="col-sm-10">
                                    {{Form::text('word', '', ['class' => 'form-control', 'placeholder'=>'Search'])}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12" style="margin: 10px 0;">
                            <div class="row">
                                <div class="col-sm-2">
                                    <strong>{{Form::label('course_id','Course :')}}</strong>
                                </div>
                                <div class="col-sm-10">
                                    <select class="form-control" id="course_id" name="course_id">
                                        <option></option>
                                        @foreach(\App\Course::all() as $course)
                                            <option value="{{$course->id}}" @if(request()->course_id == $course->id) selected @endif>{{$course->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12" style="margin: 10px 0;">
                            <div class="row">
                                <div class="col-sm-2">
                                    <strong>{{Form::label('chapter','Chapter :')}}</strong>
                                </div>
                                <div class="col-sm-10">
                                    <select class="form-control" id="course_id" name="chapter_id">
                                        <option></option>
                                        @foreach(\App\Chapters::all() as $chapter)
                                            <option value="{{$chapter->id}}" @if(request()->chapter_id == $chapter->id) selected @endif>{{$chapter->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-1 offset-md-11">
                            {{Form::submit('search', ['class'=>'btn btn-success float-right', 'style'=>''])}}
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <div class="col-md-12 my-10">
            <div class="card card-custom">
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Course</th>
                            <th>Chapter</th>
                            <th>Created</th>
                            <th>Last Updated</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($explanations as $explanation)
                        <tr>
                            <td>{{$explanation->id}}</td>
                            <td>{{$explanation->title}}</td>
                            <td>{{$explanation->course_title}}</td>
                            <td>{{$explanation->chapter_title}}</td>
                            <td>{{$explanation->created_at}}</td>
                            <td>{{$explanation->updated_at}}</td>
                            <td>
                                <a href="{{route('explanation.edit', $explanation->id)}}">Edit</a>
                            </td>
                            <td>
                                <a href="javascript:;" onclick="AVUtil().deleteConfirmation('{{route('explanation.destroy', $explanation->id)}}')">Delete</a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{$explanations->appends(request()->all())->links()}}
                </div>
            </div>
        </div>
    </div>



@endsection
