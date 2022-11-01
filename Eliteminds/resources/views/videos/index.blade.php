@extends('layouts.app-1')
@section('pageTitle') Videos @endsection
@section('content')

    <div class="row">
        <div class="col-md-12" id="searchForm">
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
                    {!! Form::open(['action'=>'VideoController@search', 'method'=>'GET', 'class'=>'', 'style'=>'margin: 10px 0 20px 0;']) !!}
                    <div class="row">
                        <div class="form-group col-md-12" style="">
                            <div class="row">
                                <div class="col-sm-2">
                                    <strong>{{Form::label('word','Search :')}}</strong>
                                </div>
                                <div class="col-sm-10">
                                    <input type="text" name="word" placeholder="Text.." class="form-control form-control-sm mr-3">
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
                                    <select class="form-control" id="course_id" name="course_id" v-on:change="getChapters" v-model="course">
                                        <option value="">{{config('library.course.en')}}</option>
                                        @foreach(\App\Course::all() as $course)
                                            <option value="{{$course->id}}">{{$course->title}}</option>
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
                                    <strong>{{Form::label('chapter','knowledge Area :')}}</strong>
                                </div>
                                <div class="col-sm-10">
                                    <select class="form-control form-control-sm mr-3" name="chapter" v-model="chapter">
                                        <option value="">{{config('library.chapter.en')}}</option>
                                        <option v-for="i in chapter_data" :value="i.id">@{{i.name}}</option>
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
           
            <div class="card card-custom mt-5">
                <div class="card-header">
                    <div class="card-title">
                    <span class="card-icon">
                        <i class="text-primary fas fa-video"></i>
                    </span>
                        <h3 class="card-label">Videos</h3>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover table-checkable" id="kt_datatable1" style="margin-top: 13px !important">

                        <thead>
                        <tr>
                            <td>No.</td>
                            <td>Title</td>
                            <td>Course</td>
                            <td>Chapter</td>
                            <td>Edit</td>
                            <td>Delete</td>
                        </tr>
                        </thead>

                        <tbody>

                        @foreach($videos as $q)
                            <tr>
                                <td>{{$q->id}}</td>
                                <td><strong>{{substr($q->title, 0, 80)}}</strong></td>
                                <td>
                                    {{\App\Course::find(\App\Chapters::find($q->chapter)->course_id)->title}}
                                </td>
                                <td>
                                    @if($q->chapter != '')
                                        {{\App\Chapters::where('id','=',$q->chapter)->get()->first()->name }}
                                    @else
                                        --
                                    @endif
                                </td>

                                <td><a style="border:0;" href="{{ route('video.edit', $q->id) }}" class="btn btn-outline-info" style="margin-right: 10px;"> <i class="fa fa-edit"></i> </a></td>
                                <td><a style="border:0;" href="#" class="btn btn-outline-danger" data-toggle="modal" data-target="#DeleteModal-{{$q->id}}"> <i style="color: red;" class="fa fa-trash"></i> </a></td>
                            </tr>

                        @endforeach
                        


                        </tbody>

                    </table>
                    {{ $videos->appends(Request::input())->links() }}
                </div>
            </div>
        </div>
    </div>
    @foreach($videos as $q)
    <div class="modal fade" id="DeleteModal-{{$q->id}}" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="text-align: left;">
                    <h4 class="modal-title">Are You Sure ?</h4>
                </div>
                <div class="modal-body">
                    <p>{{$q->title}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="float:right;">Close</button>
                    <form action="{{route('video.destroy', $q->id)}}" method="POST">
                        @csrf
                        <input type="hidden" name="_method" value="DELETE" />
                        <input type="submit" class="btn btn-danger" style="float:right;" />
                    </form>
                </div>
            </div>

        </div>
    </div>
    @endforeach
@endsection
@section('jscode')
    <script src="{{asset('assets/js/pages/crud/datatables/extensions/buttons.js?v=7.0.4')}}"></script>
    <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.4')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>
    <script>
        var searchApp = new Vue({
            el: '#searchForm',
            data:{
                course:'{{request()->course_id}}',
                chapter:'{{request()->chapter}}',
                chapter_data: [],
            },
            mounted(){
                this.getChapters();
            },
            methods: {
                getChapters:async function(){
                    this.chapter_data = await this.fetchLibrary(this.course, 'chapter');
                },
                fetchLibrary: function(parent_topic_id, topic_required){
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}'
                        }
                    });
                    return $.ajax ({
                        type: 'POST',
                        url: '{{ route('library.fetch')}}',
                        data: {
                            parent_topic_id,
                            topic_required,
                        },
                    });
                },
            },
        });
    </script>
@endsection

