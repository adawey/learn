@extends('layouts.app-1')
@section('pageTitle') Edit Question @endsection

@section('subheaderTitle') Edit Question @endsection
@section('subheaderNav')
    <!--begin::Button-->
    <a href="#" onclick="document.getElementById('editQuestionForm').submit()" class="btn btn-fh btn-white btn-hover-primary font-weight-bold px-2 px-lg-5 mr-2">
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

    <!--begin::Button-->
    <a href="#" onclick="AVUtil().redirectionConfirmation('{{route('question.index')}}')" class="btn btn-fh btn-white btn-hover-primary font-weight-bold px-2 px-lg-5 mr-2">
    <span class="svg-icon svg-icon-success svg-icon-lg">
        <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Add-user.svg-->
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <rect x="0" y="0" width="24" height="24"/>
                <path d="M8.42034438,20 L21,20 C22.1045695,20 23,19.1045695 23,18 L23,6 C23,4.8954305 22.1045695,4 21,4 L8.42034438,4 C8.15668432,4 7.90369297,4.10412727 7.71642146,4.28972363 L0.653241109,11.2897236 C0.260966303,11.6784895 0.25812177,12.3116481 0.646887666,12.7039229 C0.648995955,12.7060502 0.651113791,12.7081681 0.653241109,12.7102764 L7.71642146,19.7102764 C7.90369297,19.8958727 8.15668432,20 8.42034438,20 Z" fill="#000000" opacity="0.3"/>
                <path d="M12.5857864,12 L11.1715729,10.5857864 C10.7810486,10.1952621 10.7810486,9.56209717 11.1715729,9.17157288 C11.5620972,8.78104858 12.1952621,8.78104858 12.5857864,9.17157288 L14,10.5857864 L15.4142136,9.17157288 C15.8047379,8.78104858 16.4379028,8.78104858 16.8284271,9.17157288 C17.2189514,9.56209717 17.2189514,10.1952621 16.8284271,10.5857864 L15.4142136,12 L16.8284271,13.4142136 C17.2189514,13.8047379 17.2189514,14.4379028 16.8284271,14.8284271 C16.4379028,15.2189514 15.8047379,15.2189514 15.4142136,14.8284271 L14,13.4142136 L12.5857864,14.8284271 C12.1952621,15.2189514 11.5620972,15.2189514 11.1715729,14.8284271 C10.7810486,14.4379028 10.7810486,13.8047379 11.1715729,13.4142136 L12.5857864,12 Z" fill="#000000"/>
            </g>
        </svg>
        <!--end::Svg Icon-->
    </span>Cancel</a>
    <!--end::Button-->
@endsection
@section('content')
    <div class="card card-custom">
        <!--begin::Form-->
        <form method="POST" id="editQuestionForm" class="vueform" enctype="multipart/form-data" action="{{route('question.update', $question->id)}}">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group-lg py-5 row">
                    <label class="col-2 col-form-label">Question</label>
                    <div class="col-5">
                        <textarea name="question" class="form-control " placeholder="Question" rows="5">{{$question->title}}</textarea>
                    </div>
                    <div class="col-5">
                        <textarea name="question_ar" class="form-control " placeholder="السؤال" rows="5">{{$question->transcodes['title']}}</textarea>
                    </div>
                </div>
                <div class="form-group  row">
                    <label class="col-2 col-form-label">Correct Answer :</label>
                    <div class="col-5">
                        <input value="{{$question->correct_answer}}" name="correct_answer" class="form-control" type="text" placeholder="Correct Answer"/>
                    </div>
                    <div class="col-5">
                        <input value="{{$question->transcodes['correct_answer']}}" name="correct_answer_ar" class="form-control" type="text" placeholder="الاجابة الصحيحة"/>
                    </div>
                </div>
                <div class="form-group  row">
                    <label class="col-2 col-form-label">Answer A :</label>
                    <div class="col-5">
                        <input class="form-control" value="{{$question->a}}" name="answer_a" type="text" placeholder="Answer A "/>
                    </div>
                    <div class="col-5">
                        <input class="form-control" value="{{$question->transcodes['a']}}" name="answer_a_ar" type="text" placeholder="الأجابة أ"/>
                    </div>
                </div>
                <div class="form-group  row">
                    <label class="col-2 col-form-label">Answer B :</label>
                    <div class="col-5">
                        <input class="form-control" value="{{$question->b}}" name="answer_b" type="text" placeholder="False Answer "/>
                    </div>
                    <div class="col-5">
                        <input class="form-control" value="{{$question->transcodes['b']}}" name="answer_b_ar" type="text" placeholder="الأجابة ب"/>
                    </div>
                </div>
                <div class="form-group  row">
                    <label class="col-2 col-form-label">Answer C :</label>
                    <div class="col-5">
                        <input class="form-control" value="{{$question->c}}" name="answer_c" type="text" placeholder="False Answer "/>
                    </div>
                    <div class="col-5">
                        <input class="form-control" value="{{$question->transcodes['c']}}" name="answer_c_ar" type="text" placeholder="الأجابة ج"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 col-form-label" for="exampleSelectd1">Course</label>
                    <div class="col-10">
                        <select class="form-control" id="exampleSelectd1" v-on:change="searchCourse" v-model="course">
                            <option> Choose one</option>
                            @foreach($course_select as $k => $v)
                                <option value="{{$k}}">{{$v}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 col-form-label" for="exampleSelectd2">chapter</label>
                    <div class="col-10">
                        <select class="form-control chapter" id="exampleSelectd3" v-model="chapter" v-on:change="searchChapter"  v-model="chapter" name="chapter">
                            <option disabled value="">Choose one </option>
                            <option v-for="i in chapter_data">@{{i}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row" style="">
                    <label class="col-2 col-form-label" for="pmg">Project Management Group</label>
                    <div class="col-10">
                        <select v-model="pmg" class="form-control" id="pmg" v-on:change="searchPMG" name="pmg" disabled>
                            <option disabled value="">Choose one </option>
                            <option v-for="i in chapter_data">@{{i}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 col-form-label" for="exampleSelectd3">Process Group:</label>
                    <div class="col-10">
                        <select v-model="process_group" class="form-control" id="process_group" name="process_group" >
                            <option disabled value="">Choose one </option>
                            <option v-for="i in process_group_data">@{{i}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 col-form-label">Is demo</label>
                    <div class="col-10">
                        <span class="switch switch-icon">
                            <label>
                                <input type="checkbox" name="demo" v-model="demo"/>
                                <span></span>
                            </label>
                        </span>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 col-form-label">Exam Number</label>
                    <div class=" col-10">
                        <select class="form-control select2" id="kt_select2_3" name="exam_num[]" v-model="exam_num" multiple="multiple">
                            <optgroup>
                                @foreach(\App\Exam::all() as $exam)
                                    <option value="{{$exam->id}}">{{$exam->name}}</option>
                                @endforeach
                            </optgroup>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 col-form-label">Image Upload</label>
                    <div class="col-lg-4 col-md-9 col-sm-12">
                        <div class="dropzone dropzone-default dropzone-primary" id="kt_dropzone_2">
                            <div class="dropzone-msg dz-message needsclick">
                                <h3 class="dropzone-msg-title">Drop file here or click to upload.</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group-lg py-5 row">
                    <label class="col-2 col-form-label">Feedback</label>
                    <div class="col-5">
                        <textarea name="feedback" value="" class="form-control " placeholder="Feedback about the correct answer" rows="5">{{$question->feedback}}</textarea>
                    </div>
                    <div class="col-5">
                        <textarea name="feedback_ar" value="" class="form-control " placeholder="عربي" rows="5">{{$question->transcodes['feedback']}}</textarea>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-2">
                    </div>
                    <div class="col-10">
                        <button type="submit" class="btn btn-success mr-2">Submit</button>
                        <a onclick="AVUtil().redirectionConfirmation('{{route('question.index')}}')" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('jscode')
    <!--begin::Page Vendors(used by this page)-->
    <script src="{{asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js?v=7.0.4')}}"></script>
    <!--end::Page Vendors-->
    <!--begin::Page Scripts(used by this page)-->
    <script src="{{asset('assets/js/pages/widgets.js?v=7.0.4')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/darkmode-js@1.5.6/lib/darkmode-js.min.js"></script>
    <script src="{{asset('assets/js/pages/crud/forms/widgets/select2.js?v=7.0.4')}}"></script>
    {{--    <script src="{{asset('assets/js/pages/crud/file-upload/dropzonejs.js?v=7.0.4')}}"></script>--}}
    <script>


        var KTDropzoneDemo = function () {

            var demo1 = function () {
                var uploadedDocumentMap = {};
                $('#kt_dropzone_2').dropzone({
                    url: "{{route('dropzone.handler')}}", // Set the url for your upload script location
                    paramName: "file", // The name that will be used to transfer the file
                    maxFiles: 1,
                    maxFilesize: 10, // MB
                    addRemoveLinks: true,
                    acceptedFiles: "image/*",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    accept: function(file, done) {
                        done();
                    },
                    success: function (file, response) {
                        console.log(response);
                        $('form.vueform').append('<input type="hidden" name="file[]" value="' + response.name + '">')
                        uploadedDocumentMap[file.name] = response.name
                    },
                    removedfile: function (file) {
                        file.previewElement.remove()
                        var name = ''
                        if (typeof file.file_name !== 'undefined') {
                            name = file.file_name
                        } else {
                            name = uploadedDocumentMap[file.name]
                        }
                        $('form').find('input[name="file[]"][value="' + name + '"]').remove()
                    },

                });
            };
            return {
                // public functions
                init: function() {
                    demo1();
                }
            };
        }();
        KTUtil.ready(function() {
            KTDropzoneDemo.init();
        });
        // single file upload

    </script>
    <!--end::Page Scripts-->
    <script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>
    <script>

        var app = new Vue({
            el: '.vueform',
            data:{
                exam_num: [
                    @foreach($exams as $exam)
                    {{$exam}},
                    @endforeach
                ],
                demo:{{$question->demo}},
                chapter:'{{\App\Chapters::find($question->chapter)->name}}',
                chapter_data: [
                    @foreach(\App\Chapters::where('course_id', '=', $course_id)->get() as $ch)
                        '{{$ch->name}}',
                    @endforeach
                ],
                pmg: '{{$pmg_value}}',
                pmg_data: [
                    @if(count($pmg_list)> 0)
                            @foreach($pmg_list as $pmg)
                        '{{$pmg}}',
                    @endforeach
                    @endif

                ],
                process_group: '{{$pgroup_value}}',
                process_group_data: ['{{$pgroup_value}}'],
                course: '{{$course_id}}',


            },
            methods:{
                searchCourse: function(e){
                    this.process_group_data = [];
                    this.pmg_data = [];
                    $("#pmg").attr('disabled','disabled');
                    Data = {
                        id : this.course
                    };

                    e.preventDefault();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax ({
                        type: 'POST',
                        url: '{{ route('question.searchCourse')}}',
                        data: Data,
                        success: function(res){
                            //validate the response
                            // if(res.length > 0){
                            console.log("start");
                            // }
                            //empty the array pmg_data
                            app.chapter_data = [];
                            //store new data
                            res.forEach(function(ele){
                                app.chapter_data.push(ele);
                            });
                            if(res.length > 0){
                                $(".chapter").removeAttr('disabled');
                                console.log(res);
                                console.log('ok');
                            }


                        },
                        error: function(res){
                            console.log('Error:', res);
                        }
                    });
                },
                searchChapter: function(e){

                    Data = {
                        name : this.chapter
                    };

                    e.preventDefault();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax ({
                        type: 'POST',
                        url: '{{ route('question.searchChapter')}}',
                        data: Data,
                        success: function(res){
                            //validate the response
                            // if(res.length > 0){

                            // }
                            //empty the array pmg_data
                            app.pmg_data = [];
                            //store new data
                            res.forEach(function(ele){
                                app.pmg_data.push(ele);
                            });
                            if(res.length > 0){
                                $("#pmg").removeAttr('disabled');
                                console.log(res);
                            }else{
                                $("#pmg").attr('disabled','disabled');
                                app.process_group_data = [];
                                app.pmg_data = [];
                                app.showProcess();
                            }
                            $("#process_group").attr('disabled', 'disabled');

                        },
                        error: function(res){
                            console.log('Error:', res);
                        }
                    });
                },
                showProcess: function(){
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax ({
                        type: 'POST',
                        url: '{{ route('question.showProcess')}}',
                        success: function(res){
                            if(res){
                                res.forEach(i => {
                                    app.process_group_data.push(i);
                                });
                                $("#process_group").removeAttr("disabled");
                            }
                        },
                        error: function(res){
                            console.log('Error:', res);
                        }
                    });
                },
                searchPMG: function(e){
                    Data = {
                        pmg : this.pmg
                    };

                    e.preventDefault();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax ({
                        type: 'POST',
                        url: '{{ route('question.searchPMG')}}',
                        data: Data,
                        success: function(res){
                            if(res){
                                app.process_group_data = [];
                                app.process_group_data.push(res);
                                $("#process_group").removeAttr("disabled");

                            }
                        },
                        error: function(res){
                            console.log('Error:', res);
                        }
                    });
                },

            }
        });
    </script>
@endsection
