@extends('layouts.app-1')
@section('pageTitle') All Questions @endsection

@section('content')

    <div class="row" id="app-1">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    {!! Form::open(['action'=>'QuestionsController@index', 'method'=>'GET', 'class'=>'', 'style'=>'margin: 10px 0 20px 0;']) !!}
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
                                    {{ Form::select('chapter', $ch_select,'', ['class' => 'form-control'] ) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="form-group col-md-12" style="margin: 10px 0;">
                            <div class="row">
                                <div class="col-sm-2">
                                    <strong>{{Form::label('exam','Exam :')}}</strong>
                                </div>
                                <div class="col-sm-10">
                                    <select class="form-control" name="exam">
                                        <option value=""></option>
                                        @foreach(\App\Exam::all() as $exam)
                                            <option value="{{$exam->id}}">{{$exam->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="search" value="1">

                    </div>
                    <div class="row">
                        <div class="form-group col-md-1 offset-md-11">
                            {{Form::submit('search', ['class'=>'btn btn-success float-right', 'style'=>''])}}
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>

            <br>

            <div class="card card-custom card-sticky" id="kt_page_sticky_card">
                <div class="card-header">
                    <div class="card-title">
                        <h3>Questions</h3>
                    </div>
                    <div class="card-toolbar">
                        <a href="#" class="btn btn-light-danger font-weight-bolder mr-2" v-if="selectedQuestions.length > 0" @click.prevent="deleteSelectedQuestions">
                            <i class="fa fa-trash"></i>Delete</a>
                    </div>
                </div>
                <div class="card-body">
                @foreach($questions_data as $question)
                    <!--begin::Card-->
                        <div class="card card-custom gutter-b">
                            <div class="card-body">
                                <!--begin::Top-->
                                <div class="d-flex">
                                    <!--begin::Pic-->
                                    <div class="flex-shrink-0 mr-7">
                                        <div class="symbol symbol-50 symbol-lg-120 symbol-light-danger">
                                            <span class="font-size-h3 symbol-label font-weight-boldest" style="line-height: 75%">{{$question->course}}</span>
                                        </div>
                                    </div>
                                    <!--end::Pic-->
                                    <!--begin: Info-->
                                    <div class="flex-grow-1">
                                        <!--begin::Title-->
                                        <div class="d-flex align-items-center justify-content-between flex-wrap mt-2">
                                            <!--begin::User-->
                                            <div class="mr-3">

                                                <!--begin::Contacts-->
                                                <div class="d-flex flex-wrap my-2">
                                                    <a href="#" class="text-muted text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2">
                                                    <span class="svg-icon svg-icon-md svg-icon-gray-500 mr-1">
                                                        <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo3\dist/../src/media/svg/icons\Home\Book-open.svg-->
                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <rect x="0" y="0" width="24" height="24"/>
                                                            <path d="M13.6855025,18.7082217 C15.9113859,17.8189707 18.682885,17.2495635 22,17 C22,16.9325178 22,13.1012863 22,5.50630526 L21.9999762,5.50630526 C21.9999762,5.23017604 21.7761292,5.00632908 21.5,5.00632908 C21.4957817,5.00632908 21.4915635,5.00638247 21.4873465,5.00648922 C18.658231,5.07811173 15.8291155,5.74261533 13,7 C13,7.04449645 13,10.79246 13,18.2438906 L12.9999854,18.2438906 C12.9999854,18.520041 13.2238496,18.7439052 13.5,18.7439052 C13.5635398,18.7439052 13.6264972,18.7317946 13.6855025,18.7082217 Z" fill="#000000"/>
                                                            <path d="M10.3144829,18.7082217 C8.08859955,17.8189707 5.31710038,17.2495635 1.99998542,17 C1.99998542,16.9325178 1.99998542,13.1012863 1.99998542,5.50630526 L2.00000925,5.50630526 C2.00000925,5.23017604 2.22385621,5.00632908 2.49998542,5.00632908 C2.50420375,5.00632908 2.5084219,5.00638247 2.51263888,5.00648922 C5.34175439,5.07811173 8.17086991,5.74261533 10.9999854,7 C10.9999854,7.04449645 10.9999854,10.79246 10.9999854,18.2438906 L11,18.2438906 C11,18.520041 10.7761358,18.7439052 10.4999854,18.7439052 C10.4364457,18.7439052 10.3734882,18.7317946 10.3144829,18.7082217 Z" fill="#000000" opacity="0.3"/>
                                                        </g>
                                                    </svg><!--end::Svg Icon--></span>
                                                        {{$question->course}}
                                                    </a>
                                                    <a href="#" class="text-muted text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2">
                                                    <span class="svg-icon svg-icon-md svg-icon-gray-500 mr-1">
                                                        <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo3\dist/../src/media/svg/icons\Navigation\Arrow-from-left.svg-->
                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <polygon points="0 0 24 0 24 24 0 24"/>
                                                            <rect fill="#000000" opacity="0.3" transform="translate(14.000000, 12.000000) rotate(-90.000000) translate(-14.000000, -12.000000) " x="13" y="5" width="2" height="14" rx="1"/>
                                                            <rect fill="#000000" opacity="0.3" x="3" y="3" width="2" height="18" rx="1"/>
                                                            <path d="M11.7071032,15.7071045 C11.3165789,16.0976288 10.6834139,16.0976288 10.2928896,15.7071045 C9.90236532,15.3165802 9.90236532,14.6834152 10.2928896,14.2928909 L16.2928896,8.29289093 C16.6714686,7.914312 17.281055,7.90106637 17.675721,8.26284357 L23.675721,13.7628436 C24.08284,14.136036 24.1103429,14.7686034 23.7371505,15.1757223 C23.3639581,15.5828413 22.7313908,15.6103443 22.3242718,15.2371519 L17.0300721,10.3841355 L11.7071032,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(16.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-16.999999, -11.999997) "/>
                                                        </g>
                                                    </svg><!--end::Svg Icon--></span>
                                                        {{$question->chapter}}
                                                    </a>
                                                </div>
                                                <!--end::Contacts-->
                                            </div>
                                            <!--begin::User-->
                                            <!--begin::Actions-->
                                            <div class="my-lg-0 my-1">
                                                <div class="d-flex align-items-center">

                                                    <!--begin::Dropdown-->
                                                    <div class="dropdown dropdown-inline ml-2" data-toggle="tooltip" title="" data-placement="left" data-original-title="Quick Actions">
                                                        <a href="#" class="btn btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="svg-icon svg-icon-success svg-icon-2x">
                                                        <span class="svg-icon svg-icon-success svg-icon-2x">
                                                            <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo3\dist/../src/media/svg/icons\Text\Menu.svg-->
                                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24"/>
                                                                <rect fill="#000000" x="4" y="5" width="16" height="3" rx="1.5"/>
                                                                <path d="M5.5,15 L18.5,15 C19.3284271,15 20,15.6715729 20,16.5 C20,17.3284271 19.3284271,18 18.5,18 L5.5,18 C4.67157288,18 4,17.3284271 4,16.5 C4,15.6715729 4.67157288,15 5.5,15 Z M5.5,10 L18.5,10 C19.3284271,10 20,10.6715729 20,11.5 C20,12.3284271 19.3284271,13 18.5,13 L5.5,13 C4.67157288,13 4,12.3284271 4,11.5 C4,10.6715729 4.67157288,10 5.5,10 Z" fill="#000000" opacity="0.3"/>
                                                            </g>
                                                        </svg><!--end::Svg Icon--></span>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                        </a>
                                                        <div class="dropdown-menu p-0 m-0 dropdown-menu-md dropdown-menu-right" style="">
                                                            <!--begin::Naviigation-->
                                                            <ul class="navi">
                                                                <li class="navi-header font-weight-bold py-5">
                                                                    <span class="font-size-lg">Quick Actions:</span>
                                                                </li>
                                                                <li class="navi-separator mb-3 opacity-70"></li>
                                                                <li class="navi-item">
                                                                    <a href="#" class="navi-link">
                                                                <span class="navi-icon">
                                                                    <i class="fa fa-language"></i>
                                                                </span>
                                                                        <span class="navi-text">Translate</span>
                                                                    </a>
                                                                </li>
                                                                <li class="navi-item">
                                                                    <a href="{{route('question.editV2', $question->id)}}" class="navi-link">
                                                                <span class="navi-icon">
                                                                    <i class="fa fa-edit"></i>
                                                                </span>
                                                                        <span class="navi-text">Edit</span>
                                                                    </a>
                                                                </li>
                                                                <li class="navi-item">
                                                                    <a href="#" class="navi-link" data-toggle="modal" data-target="#DeleteModal-{{$question->id}}">
                                                                <span class="navi-icon">
                                                                    <i class="fa fa-trash"></i>
                                                                </span>
                                                                        <span class="navi-text">Delete</span>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                            <!--end::Naviigation-->
                                                        </div>
                                                    </div>
                                                    <!--end::Dropdown-->
                                                    <!--begin::Button-->
                                                    <div class="checkbox-inline">
                                                        <label class="checkbox checkbox-outline checkbox-success">
                                                            <input type="checkbox" value="{{$question->id}}" v-model="selectedQuestions"/>
                                                            <span></span>
                                                            Select
                                                        </label>
                                                    </div>
                                                    <!--end::Button-->
                                                </div>
                                            </div>
                                            <!--end::Actions-->
                                        </div>
                                        <!--end::Title-->
                                        <!--begin::Content-->
                                        <div class="d-flex align-items-center flex-wrap justify-content-between">
                                            <!--begin::Description-->
                                            <div class="flex-grow-1 font-weight-bold text-dark-50 py-2 py-lg-2 mr-5"  style="width: 100%;">
                                                <small style="color:black; font-weight: bold;">Question</small>
                                                <div class="row">
                                                    <div class="col-md-12">{!! $question->question_title !!}</div>
                                                </div>
                                            </div>
                                            <!--end::Description-->
                                        </div>
                                        <!--end::Content-->
                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::Top-->
                                <!--begin::Separator-->
                                <div class="separator separator-solid my-7"></div>
                                <!--end::Separator-->
                                <!--begin::Bottom-->
                                <div class="d-flex align-items-center flex-wrap">

                                    <!--begin: Item-->
                                    <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
                                    <span class="mr-4">
                                        <i class="flaticon-pie-chart icon-2x text-muted font-weight-bold"></i>
                                    </span>
                                        <div class="d-flex flex-column text-dark-75">
                                            <span class="font-weight-bolder font-size-sm">Question Type</span>
                                            <span class="font-weight-bolder font-size-h5">
                                            {{\App\QuestionType::find($question->question_type_id)->title}}
                                        </span>
                                        </div>
                                    </div>
                                    <!--end: Item-->
                                    <!--begin: Item-->
                                    <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
                                    <span class="mr-4">
                                        <span class="svg-icon svg-icon-2x"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo3\dist/../src/media/svg/icons\Shopping\Gift.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"/>
                                                <path d="M4,6 L20,6 C20.5522847,6 21,6.44771525 21,7 L21,8 C21,8.55228475 20.5522847,9 20,9 L4,9 C3.44771525,9 3,8.55228475 3,8 L3,7 C3,6.44771525 3.44771525,6 4,6 Z M5,11 L10,11 C10.5522847,11 11,11.4477153 11,12 L11,19 C11,19.5522847 10.5522847,20 10,20 L5,20 C4.44771525,20 4,19.5522847 4,19 L4,12 C4,11.4477153 4.44771525,11 5,11 Z M14,11 L19,11 C19.5522847,11 20,11.4477153 20,12 L20,19 C20,19.5522847 19.5522847,20 19,20 L14,20 C13.4477153,20 13,19.5522847 13,19 L13,12 C13,11.4477153 13.4477153,11 14,11 Z" fill="#000000"/>
                                                <path d="M14.4452998,2.16794971 C14.9048285,1.86159725 15.5256978,1.98577112 15.8320503,2.4452998 C16.1384028,2.90482849 16.0142289,3.52569784 15.5547002,3.83205029 L12,6.20185043 L8.4452998,3.83205029 C7.98577112,3.52569784 7.86159725,2.90482849 8.16794971,2.4452998 C8.47430216,1.98577112 9.09517151,1.86159725 9.5547002,2.16794971 L12,3.79814957 L14.4452998,2.16794971 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                            </g>
                                        </svg><!--end::Svg Icon--></span>
                                    </span>
                                        <div class="d-flex flex-column text-dark-75">
                                            <span class="font-weight-bolder font-size-sm">Demo</span>
                                            <span class="font-weight-bolder font-size-h5">
                                            {{$question->demo ? 'Yes': 'No'}}
                                        </span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
                                    <span class="mr-4">
                                        <i class="flaticon-file-2 icon-2x text-muted font-weight-bold"></i>
                                    </span>
                                        <div class="d-flex flex-column flex-lg-fill">
                                            <span class="text-dark-75 font-weight-bolder font-size-sm">Question Details</span>
                                            <a href="#" @click.prevent="loader('{{$question->id}}')" class="text-primary font-weight-bolder">View</a>
                                        </div>
                                    </div>
                                    <!--end: Item-->

                                </div>
                                <!--end::Bottom-->
                            </div>
                        </div>
                        <!--end::Card-->

                        <div class="modal fade" id="DeleteModal-{{$question->id}}" role="dialog">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header" style="text-align: left;">
                                        <h4 class="modal-title">Are You Sure ?</h4>
                                    </div>
                                    <div class="modal-body">
                                        <p>{{$question->question_title}}</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        {!! Form::open(['action'=>['QuestionsController@destroy', $question->id], 'method'=>'POST']) !!}
                                        {{Form::hidden('_method', 'DELETE')}}
                                        {{Form::submit('Delete', ['class'=>'btn btn-danger'])}}
                                        {!! Form::close() !!}
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="modal fade" id="questionDetails" role="dialog">
                <div class="modal-dialog modal-lg">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-body">
                            <p>

                                <div class="flex-grow-1 p-20 pb-10 card-rounded flex-grow-1 bgi-no-repeat" style="background-color: #1B283F; background-position: calc(100% + 0.5rem) bottom; background-size: 50% auto;">
                                    <h4 class="text-primary font-weight-bolder m-0">
                                        Question
                                    </h4>
                                    <p class="text-white my-5 font-size-xl font-weight-bold">
                                        <small class="text-primary">English: </small>
                                        <br>
                                        <span v-html="question_title"></span>
                                        <br>
                                    </p>
                                    <a :href="edit_link" class="btn btn-primary font-weight-bold py-2 px-6">
                                        Edit
                                    </a>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>

                                <table class="table table-hover table-bordered table-striped my-4" v-if="!isMatchingToRight && !isMatchingToCenter">
                                    <thead>
                                    <tr>
                                        <th>Answer</th>
                                        <th>Correct ?</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="i,index in answers_arr">
                                        <td v-html="i.answer"></td>
                                        <td v-if="i.is_correct">Correct</td>
                                        <td v-if="!i.is_correct">Incorrect</td>
                                    </tr>
                                    </tbody>
                                </table>

                                <table class="table table-hover table-bordered table-striped my-4" v-if="isMatchingToRight">
                                    <thead>
                                    <tr>
                                        <th>Left Item</th>
                                        <th>Right Item</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="i,index in drags_arr">
                                        <td v-html="i.left_sentence"></td>
                                        <td v-html="i.right_sentence"></td>
                                    </tr>
                                    </tbody>
                                </table>

                                <table class="table table-hover table-bordered table-striped my-4" v-if="isMatchingToCenter">
                                <thead>
                                <tr>
                                    <th>Correct Sentence</th>
                                    <th>Center Sentence</th>
                                    <th>Wrong Sentence</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="i,index in dragsCenter_arr">
                                        <td v-html="i.correct_sentence"></td>
                                        <td v-html="i.center_sentence"></td>
                                        <td v-html="i.wrong_sentence"></td>
                                    </tr>
                                    </tbody>
                                </table>

                                <div class="flex-grow-1 p-20 pb-10 card-rounded flex-grow-1 bgi-no-repeat" style="background-position: calc(100% + 0.5rem) bottom; background-size: 50% auto;">
                                    <!--begin::Body-->
                                    <div class="card-body d-flex align-items-center">
                                        <div class="py-2">
                                            <h3 class="text-black font-weight-bolder mb-3">Feedback</h3>
                                            <p class="text-black font-size-lg">
                                                <small class="text-primary">English: </small><br>
                                                <span v-html="feedback"></span>
                                                <br>
                                            </p>
                                        </div>
                                    </div>
                                    <!--end::Body-->
                                </div>

                            </p>
                        </div>
                    </div>

                </div>
            </div>

            <!--begin::Pagination-->
            <div class="card card-custom">
                <div class="card-body">
                    <!--begin::Pagination-->
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div class="d-flex flex-wrap mr-3">
                            <!-- Pagination here -->
                            {{$questionsModel->appends(request()->all())->links()}}
                        </div>
                        <form class="d-flex align-items-center" method="GET" action="{{route('question.index')}}">
                            <select class="form-control form-control-sm text-primary font-weight-bold mr-4 border-0 bg-light-primary" style="width: 75px;" name="pagination" onchange="this.form.submit()">
                                <option value="10" {{request()->pagination == 10 ? 'selected': ''}}>10</option>
                                <option value="20" {{request()->pagination == 20 ? 'selected': ''}}>20</option>
                                <option value="30" {{request()->pagination == 30 ? 'selected': ''}}>30</option>
                                <option value="50" {{request()->pagination == 50 ? 'selected': ''}}>50</option>
                                <option value="100" {{request()->pagination == 100 ? 'selected': ''}}>100</option>
                            </select>
                            <span class="text-muted">Displaying {{$result_counter}} of {{$questionsModel->total()}} records</span>
                        </form>
                    </div>
                    <!--end:: Pagination-->
                </div>
            </div>
            <!--end::Pagination-->
        </div>
    </div>


@endsection

@section('jscode')
    <script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>
    <script>

        var app = new Vue({
            el: '#app-1',
            data:{
                // Multiple Choice || Multiple Response || Fill in the blank
                answers_arr: [],
                answer: '',
                answer_ar: '',
                is_correct: false,

                // Drag to Right
                drags_arr: [],
                left_sentence: '',
                left_sentence_ar: '',
                right_sentence: '',
                right_sentence_ar: '',

                // Drag to Center
                dragsCenter_arr: [],
                center_sentence: '',
                center_sentence_ar: '',
                correct_sentence: '',
                correct_sentence_ar: '',
                wrong_sentence: '',
                wrong_sentence_ar: '',

                question_title: '',
                question_title_ar: '',
                question_type_id: '',
                correct_answers_required: 1,

                course:'',
                chapter:'',
                process_group: '',
                demo: '',
                exam_num: [],
                feedback: '',
                feedback_ar: '',
                edit_link: '',
                selectedQuestions: [],
            },
            mounted(){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    }
                });
            },
            computed:{
                isMatchingToCenter: function(){
                    return this.question_type_id == 5;
                },
                isFillInTheBlank: function(){
                    return this.question_type_id == 4;
                },
                isMatchingToRight: function(){
                    return this.question_type_id == 3;
                },
                isMultipleResponses: function(){
                    return this.question_type_id == 2;
                },
                isMultipleChoice: function(){
                    return this.question_type_id == 1;
                },
            },
            methods:{
                deleteSelectedQuestions: function(){
                    if(this.selectedQuestions.length){

                        Swal.fire({
                            icon: 'warning',
                            title: 'Deleting Multiple Questions',
                            text: 'you are about to delete '+app.selectedQuestions.length+' question, are you sure?',
                            showCancelButton: true,
                            confirmButtonText: 'Delete',
                        }).then(async (res) => {
                            if(res.value){
                                const res = await app.deleteQuestionRequest();
                                console.log(res);
                                if(res.error){
                                    swal('Error', res.error, 'error'); return;
                                }
                                window.location.reload();
                            }
                        });
                    }else{
                        swal('No question selected', '', 'info');
                    }
                },
                deleteQuestionRequest:async function(){
                    return $.ajax ({
                        type: 'POST',
                        url: '{{ route('question.batchDestory')}}',
                        data: {
                            questions: app.selectedQuestions,
                        },
                    });
                },
                loader: function(question_id){
                    this.answers_arr = [];
                    this.drags_arr = [];
                    this.dragsCenter_arr = [];
                    KTApp.blockPage();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}'
                        }
                    });
                    $.ajax ({
                        type: 'POST',
                        url: '{{ route('question.edit.loader')}}',
                        data: {
                            question_id
                        },
                        success: function(res){
                            console.log(res);
                            question = res['question'];
                            console.log(question);
                            app.chapter_data = res['chapters'];
                            app.question_title = question['question_title'];
                            app.question_title_ar = question['question_title_ar'];
                            app.question_type_id = question['question_type_id'];
                            app.correct_answers_required = question['correct_answers_required'];

                            if(app.isMultipleChoice || app.isMultipleResponses || app.isFillInTheBlank){
                                if(question['answers']){
                                    question['answers'].forEach(ele => {
                                        app.answers_arr.push({
                                            id: ele['id'],
                                            answer: ele['answer'],
                                            answer_ar: ele['transcodes']['answer'],
                                            is_correct: ele['is_correct'],
                                        });
                                    });
                                }
                            }else if(app.isMatchingToRight){
                                question['drag_right'].forEach(ele => {
                                    app.drags_arr.push({
                                        id: ele['id'],
                                        left_sentence: ele['left_sentence'],
                                        left_sentence_ar: ele['transcodes']['left_sentence'],
                                        right_sentence: ele['right_sentence'],
                                        right_sentence_ar: ele['transcodes']['right_sentence'],
                                    });
                                });
                            }else if(app.isMatchingToCenter){
                                question['drag_center'].forEach(ele => {
                                    app.dragsCenter_arr.push({
                                        id: ele['id'],
                                        correct_sentence: ele['correct_sentence'],
                                        correct_sentence_ar: ele['transcodes']['correct_sentence'],
                                        wrong_sentence: ele['wrong_sentence'],
                                        wrong_sentence_ar: ele['transcodes']['wrong_sentence'],
                                        center_sentence: ele['center_sentence'],
                                        center_sentence_ar: ele['transcodes']['center_sentence'],
                                    });
                                });
                            }

                            app.course = question['course_id'];
                            app.chapter = question['chapter_id'];
                            app.process_group = question['process_group'];
                            app.demo = question['demo'];
                            app.exam_num = question['exam_num']? question['exam_num'].split(','): [];
                            app.feedback = question['feedback'];
                            app.feedback_ar = question['feedback_ar'];
                            KTApp.unblockPage();
                            $("#questionDetails").modal('show');

                            app.edit_link = '{{route('question.editV2', '')}}/'+question['id'];

                        },
                        error: function(err){
                            console.log(err);
                        }
                    });
                },
                // Multiple Choice || Multiple Response || Fill in the blank
            }
        });
    </script>
@endsection

