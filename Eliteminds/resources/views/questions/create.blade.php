@extends('layouts.app-1')
@section('pageTitle') Add Question @endsection

@section('subheaderTitle') Add Question @endsection
@section('subheaderNav')
    <!--begin::Button-->
    <a href="#" onclick="app.store()" class="btn btn-fh btn-white btn-hover-primary font-weight-bold px-2 px-lg-5 mr-2">
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
        <div id="questionAddForm" class="vueform">
            <div class="card-body">
                <div class="form-group-lg py-5 row">
                    <label class="col-2 col-form-label">Question</label>
                    <div class="col-10">
                        <textarea id="titleEditor"></textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-2 col-form-label" for="exampleSelectd1">Question Type</label>
                    <div class="col-10">
                        <select class="form-control" id="exampleSelectd1" v-model="question_type_id">
                            @foreach(\App\QuestionType::all() as $type)
                                <option value="{{$type->id}}"> {{$type->title}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Correct Answers Count --}}
                <div class="form-group row" v-if="isMultipleResponses || isFillInTheBlank">
                    <label class="col-2 col-form-label" for="exampleSelectd1">Correct Answers Required</label>
                    <div class="col-10">
                        <input type="number" v-model="correct_answers_required" class="form-control">
                    </div>
                </div>

                {{-- Add Answers --}}
                <div class="form-group  row" v-if="!isMatchingToRight && !isMatchingToCenter">
                    <label class="col-2 col-form-label">Answers :</label>
                    <div class="col-8">
                        <textarea class="form-control " id="answerEditor" placeholder="An Answer !" rows="5" v-model="answer"></textarea>
                    </div>
                    <div class="col-1">
                        <label for="correct">Correct?</label>
                        <input type="checkbox" id="correct" v-model="is_correct">
                    </div>
                    <div class="col-1">
                        <button @click.prevent="addAnswer" class="btn btn-outline-success">Add</button>
                    </div>
                </div>
                <div class="form-group row" v-if="!isMatchingToRight && !isMatchingToCenter">
                    <div class="col-2"></div>
                    <div class="col-10">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Answer</th>
                                <th>Correct ?</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="i,index in answers_arr">
                                <td v-html="i.answer"></td>
                                <td v-if="i.is_correct">Correct</td>
                                <td v-if="!i.is_correct">Incorrect</td>
                                <td>
                                    <button @click.prevent="editAnswer(index)" class="btn btn-outline-warning">
                                        <i class="fa fa-edit"></i> Edit
                                    </button>
                                </td>
                                <td>
                                    <button @click.prevent="removeAnswer(index)" class="btn btn-outline-danger">
                                        <i class="fa fa-trash"></i> Delete
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Matching to Right --}}
                <div class="row form-group" v-if="isMatchingToRight">
                    <label class="col-2 col-form-label">Left Item :</label>
                    <div class="col-8">
                        <textarea class="form-control " placeholder="english" rows="5" v-model="left_sentence"></textarea>
                    </div>
                </div>
                <div class="row form-group" v-if="isMatchingToRight">
                    <label class="col-2 col-form-label">Right Item :</label>
                    <div class="col-8">
                        <textarea class="form-control " placeholder="english" rows="5" v-model="right_sentence"></textarea>
                    </div>
                </div>
                <div class="row form-group" v-if="isMatchingToRight">
                    <div class="col-10"></div>
                    <div class="col-1">
                        <button @click.prevent="addDrag" class="btn btn-outline-success">Add</button>
                    </div>
                </div>
                <div class="form-group row" v-if="isMatchingToRight">
                    <div class="col-2"></div>
                    <div class="col-10">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Left Item</th>
                                <th>Right Item</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="i,index in drags_arr">
                                <td v-html="i.left_sentence"></td>
                                <td v-html="i.right_sentence"></td>
                                <td>
                                    <button @click.prevent="editDrag(index)" class="btn btn-outline-warning">
                                        <i class="fa fa-edit"></i> Edit
                                    </button>
                                </td>
                                <td>
                                    <button @click.prevent="removeDrag(index)" class="btn btn-outline-danger">
                                        <i class="fa fa-trash"></i> Delete
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Matching to Center --}}
                <div class="row form-group" v-if="isMatchingToCenter">
                    <label class="col-2 col-form-label">Correct Sentence :</label>
                    <div class="col-8">
                        <textarea class="form-control " placeholder="english" rows="5" v-model="correct_sentence"></textarea>
                    </div>
                </div>
                <div class="row form-group" v-if="isMatchingToCenter">
                    <label class="col-2 col-form-label">Center Sentence :</label>
                    <div class="col-8">
                        <textarea class="form-control " placeholder="english" rows="5" v-model="center_sentence"></textarea>
                    </div>
                </div>
                <div class="row form-group" v-if="isMatchingToCenter">
                    <label class="col-2 col-form-label">Wrong Sentence :</label>
                    <div class="col-8">
                        <textarea class="form-control " placeholder="english" rows="5" v-model="wrong_sentence"></textarea>
                    </div>
                </div>
                <div class="row form-group" v-if="isMatchingToCenter">
                    <div class="col-10"></div>
                    <div class="col-1">
                        <button @click.prevent="addDragCenter" class="btn btn-outline-success">Add</button>
                    </div>
                </div>
                <div class="form-group row" v-if="isMatchingToCenter">
                    <div class="col-2"></div>
                    <div class="col-10">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Correct Sentence</th>
                                <th>Center Sentence</th>
                                <th>Wrong Sentence</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="i,index in dragsCenter_arr">
                                <td v-html="i.correct_sentence"></td>
                                <td v-html="i.center_sentence"></td>
                                <td v-html="i.wrong_sentence"></td>
                                <td>
                                    <button @click.prevent="editDragCenter(index)" class="btn btn-outline-warning">
                                        <i class="fa fa-edit"></i> Edit
                                    </button>
                                </td>
                                <td>
                                    <button @click.prevent="removeDragCenter(index)" class="btn btn-outline-danger">
                                        <i class="fa fa-trash"></i> Delete
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-2 col-form-label" for="exampleSelectd1">Course</label>
                    <div class="col-10">
                        <select class="form-control" id="exampleSelectd1" v-on:change="getChapters" v-model="course">
                            <option value=""> Choose one</option>
                            @foreach(\App\Course::where('private', 0)->get() as $course)
                                <option value="{{$course->id}}"> {{$course->title}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 col-form-label" for="exampleSelectd2">chapter</label>
                    <div class="col-10">
                        <select class="form-control chapter" id="exampleSelectd3"  v-model="chapter" @change="showProcess" name="chapter" disabled>
                            <option value="">Choose one </option>
                            <option v-for="i in chapter_data" :value="i.id">@{{i.name}}</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-2 col-form-label">Exam Number</label>
                    <div class=" col-10">
                        <select class="form-control" id="" v-model="exam_num" multiple>
                            <optgroup>
                                @foreach(\App\Exam::all() as $exam)
                                    <option value="{{$exam->id}}">{{$exam->name}}</option>
                                @endforeach
                            </optgroup>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-2 col-form-label">Is demo</label>
                    <div class="col-10">
                <span class="switch switch-icon">
                    <label>
                        <input type="checkbox" v-model="demo"/>
                        <span></span>
                    </label>
                </span>
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
                    <div class="col-10">
                        <textarea id="feedbackEditor"></textarea>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-2">
                    </div>
                    <div class="col-10">
                        <button class="btn btn-success mr-2" @click.prevent="store">Submit</button>
                        <a onclick="AVUtil().redirectionConfirmation('{{route('question.index')}}')" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
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
    <!--<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>-->
    <script src="{{ asset('helper/js/ckeditor/ckeditor.js')}}"></script>

    <script>

        var KTDropzoneDemo = function () {
            var uploadedDocumentMap = {};
            var uploadedDocumentArray = [];
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
                        uploadedDocumentMap[file.name] = response.name;
                        uploadedDocumentArray.push(
                            response.name
                        );
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
                },
                uploadedDocumentMap,
                uploadedDocumentArray,
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
                test:'',
                chapter_data: [],
                process_group_data: [],

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

                titleEditor: '',
                titleEditorAr: '',
                question_type_id: 1,
                correct_answers_required: 1,

                course:'',
                chapter:'',
                process_group: '',
                demo: '',
                exam_num: [],
                feedbackEditor: '',
                feedbackEditorAr: '',

                answer_editing_id: null,
                drag_editing_id: null,
                dragCenter_editing_id: null,
            },
            mounted(){
                this.titleEditor = this.initEditor('titleEditor', 280);
                // this.titleEditorAr = this.initEditor('titleEditorAr', 280);
                this.feedbackEditor = this.initEditor('feedbackEditor', 280);
                // this.feedbackEditorAr = this.initEditor('feedbackEditorAr', 280);
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
                initEditor: function(element_id, height){
                    return CKEDITOR.replace(element_id, {
                        filebrowserUploadUrl: '{{route('ckeditor.upload', ['_token' => csrf_token()])}}',
                        filebrowserUploadMethod: 'form',
                        height,
                        extraPlugins: 'colorbutton',
                    });
                },
                store:async function(){
                    validation = this.validate();
                    if(validation.hasError){
                        this.showError(validation.error);
                        return;
                    }
                    KTApp.blockPage();
                    await this.storeRequest().then((res) => {
                        KTApp.unblockPage();
                        if(res.error != ''){
                            app.showError(res.error);
                            console.log(res);
                            return;
                        }
                        swal({
                            text: 'Question Added.',
                            type: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            confirmButtonClass: "btn font-weight-bold btn-light"
                        }).then(function () {
                            window.location.reload();
                        });
                    });
                },
                storeRequest: function(){
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}'
                        }
                    });
                    return $.ajax ({
                        type: 'POST',
                        url: '{{ route('question.store')}}',
                        data: {
                            question_title: app.titleEditor.getData(),
                            question_title_ar: app.titleEditorAr,

                            question_type_id: app.question_type_id,
                            correct_answers_required: app.correct_answers_required,

                            answers: app.answers_arr,
                            drags: app.drags_arr,
                            dragsCenter: app.dragsCenter_arr,

                            course_id: app.course,
                            chapter_id: app.chapter,
                            process_group: app.process_group,
                            exam_num :app.exam_num,

                            demo: app.demo,

                            feedback: app.feedbackEditor.getData(),
                            feedback_ar: app.feedbackEditorAr,

                            images: KTDropzoneDemo.uploadedDocumentArray,
                        },
                        error: function(err){
                            KTApp.unblockPage()
                            console.log(err);
                            app.showError(err);
                        }
                    });
                },
                validate: function(){
                    validation = {
                        hasError: true,
                        error: '',
                    };
                    /** Validate question field */
                    if(this.titleEditor.getData() == ''){
                        validation.error = 'Question Is required !';
                        return validation;
                    }

                    if(this.feedbackEditor.getData() == ''){
                        validation.error = 'Feedback Is required !';
                        return validation;
                    }


                    /** Question Type */
                    if(this.question_type == ''){
                        validation.error = 'Question type is required';
                        return validation;
                    }

                    /** Validate correct answrs required */
                    if(this.correct_answers_required < 1){
                        validation.error = 'Correct Answers Required can not be less than 1';
                        return validation;
                    }

                    if(this.isMatchingToRight){
                        /** validate the Matching to Right */
                        if(this.drags_arr.length < 2){
                            validation.error = 'you need at least 2 Matching Sentences !';
                            return validation;
                        }
                    }else if(this.isMatchingToCenter){
                        /** validate the Matching to Center */
                        if(this.dragsCenter_arr.length < 1){
                            validation.error = 'you need at least 1 Matching Sentence !';
                            return validation;
                        }
                    }else{
                        /** validate answers */
                        if(this.answers_arr.length <= 1){
                            validation.error = 'At least Two(2) Answers of which One(1) is correct are required !';
                            return validation;
                        }
                        correct_answer = this.answers_arr.filter(function(item){
                            return item.is_correct;
                        });


                        if(correct_answer.length != this.correct_answers_required){
                            validation.error = this.correct_answers_required+' correct answer is required !';
                            return validation;
                        }

                    }

                    /** validate courses */
                    // if(this.course == ''){
                    //     validation.error = 'Course is required !';
                    //     return validation;
                    // }

                    /** validate chapter */
                    // if(this.chapter == ''){
                    //     validation.error = 'Chapter is required';
                    //     return validation;
                    // }

                    validation.hasError = false;
                    return validation;
                },
                showError: function(err){
                    swal({
                        text: err,
                        type: "warning",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        confirmButtonClass: "btn font-weight-bold btn-light"
                    }).then(function () {
                        KTUtil.scrollTop();
                    });
                },
                // Multiple Choice || Multiple Response || Fill in the blank
                addAnswer: function(){
                    console.log(this.is_correct);
                    this.answers_arr.push({
                        id: this.answer_editing_id ? this.answer_editing_id: null,
                        answer: this.answer,
                        answer_ar: this.answer_ar,
                        is_correct: this.is_correct ? 1: 0,
                    });
                    this.is_correct = false;
                    this.answer = '';
                    this.answer_ar = '';
                },
                removeAnswer: function(idx){
                    this.answers_arr.splice(idx, 1);
                },
                editAnswer: function(idx){
                    current_answer = this.answers_arr[idx];
                    this.answers_arr.splice(idx, 1);
                    this.answer_editing_id = current_answer.id;
                    this.answer = current_answer.answer;
                    this.answer_ar = current_answer.answer_ar;
                    this.is_correct = current_answer.is_correct;
                },
                // Drag to Right
                addDrag: function(){
                    this.drags_arr.push({
                        id: this.drag_editing_id ? this.drag_editing_id: null,
                        left_sentence: this.left_sentence,
                        left_sentence_ar: this.left_sentence_ar,
                        right_sentence: this.right_sentence,
                        right_sentence_ar: this.right_sentence_ar,
                    });
                    this.left_sentence = ''; this.right_sentence = '';
                    this.left_sentence_ar = ''; this.right_sentence_ar = '';
                },
                removeDrag: function(idx){
                    this.drags_arr.splice(idx, 1);
                },
                editDrag: function(idx){
                    current_drag = this.drags_arr[idx];
                    this.drags_arr.splice(idx, 1);
                    this.drag_editing_id = current_drag.id;
                    this.left_sentence = current_drag.left_sentence;
                    this.left_sentence_ar = current_drag.left_sentence_ar;
                    this.right_sentence = current_drag.right_sentence;
                    this.right_sentence_ar = current_drag.right_sentence_ar;
                },

                // Drag to Center
                addDragCenter: function(){
                    this.dragsCenter_arr.push({
                        id: this.dragCenter_editing_id ? this.dragCenter_editing_id: null,
                        correct_sentence: this.correct_sentence,
                        correct_sentence_ar: this.correct_sentence_ar,
                        wrong_sentence: this.wrong_sentence,
                        wrong_sentence_ar: this.wrong_sentence_ar,
                        center_sentence: this.center_sentence,
                        center_sentence_ar: this.center_sentence_ar,
                    });
                    this.correct_sentence = ''; this.wrong_sentence = '';
                    this.correct_sentence_ar = ''; this.wrong_sentence_ar = '';
                    this.center_sentence = ''; this.center_sentence_ar = '';
                },
                removeDragCenter: function(idx){
                    this.dragsCenter_arr.splice(idx, 1);
                },
                editDragCenter: function(idx){
                    current_dragCenter = this.dragsCenter_arr[idx];
                    this.dragsCenter_arr.splice(idx, 1);
                    this.drag_editing_id = current_dragCenter.id;
                    this.correct_sentence = current_dragCenter.correct_sentence;
                    this.correct_sentence_ar = current_dragCenter.correct_sentence_ar;
                    this.wrong_sentence = current_dragCenter.wrong_sentence;
                    this.wrong_sentence_ar = current_dragCenter.wrong_sentence_ar;
                    this.center_sentence = current_dragCenter.center_sentence;
                    this.center_sentence_ar = current_dragCenter.center_sentence_ar;
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

                            app.process_group_data = res;
                            $("#process_group").removeAttr("disabled");

                        },
                        error: function(res){
                            console.log('Error:', res);
                        }
                    });
                },
                getChapters:async function(){
                    this.chapter_data = await this.fetchLibrary(this.course, 'chapter');
                    $("#exampleSelectd3").removeAttr("disabled");
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
                }
            }
        });
    </script>
@endsection
