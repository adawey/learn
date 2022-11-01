@extends('layouts.app-1')

@section('pageTitle')
    Chapters Manager
@endsection

@section('header')
    <style>
        h3.card-label , h3.card-label small {
            color: white !important;
        }

        .card-header-custum {
            background-color: #1BC5BD !important;
        }
        li {
            margin: 10px;
        }
        ul {
            list-style-type: none;
            max-width: 500px;
        }
        li > i {
            float: right;
            color: #1BC5BD;
        }
    </style>
@endsection
@section('content')
    <div class="container" id = "app-1">

        <div class="card card-custom">

            <div class="card-header card-header-custum">
                <div class="card-title">
                    <h3 class="card-label">
                        Knowledge Area & Proccess Group Settings
                        <small>Manager</small>
                    </h3>
                </div>
            </div>


            <div class="card-body">
                <div class="container" id="error-msg"></div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-custom gutter-b">
                            <div class="card-header card-header-custum">
                                <div class="card-title">
                                    <h3 class="card-label">
                                        Courses
                                        <small>Manager</small>
                                    </h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <ul class="Proccess_Group">
                                    <li v-for="(i, index) in courses_data">
                                        <strong v-if="locale == 'ar'">@{{i.title_ar}}</strong>
                                        <strong v-if="locale == 'en'">@{{i.title_en}}</strong>
                                        <i class="fa fa-edit" v-on:click="UpdateTopic(i, 'course', index)"></i>
                                    </li>

                                </ul>
                                <form class="card-body add_pgroup_form">

                                    <div class="form-group ">
                                        <label for="course_new"> Add New Course: </label>
                                        <br>
                                        <input type="text" id="course_new" v-model="course_new" class="form-control" placeholder="English">
                                        <br>
                                        <input type="text" id="course_new_ar" v-model="course_new_ar" class="form-control" placeholder="عربي">
                                        <br>
                                        <select class="form-control" v-model="private">
                                            <option value="1">Private</option>
                                            <option value="0">Public</option>
                                        </select>
                                        <br>

                                        <a v-on:click="add('course')" class="btn btn-outline-primary" >Add</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-custom gutter-b">
                            <div class="card-header card-header-custum">
                                <div class="card-title">
                                    <h3 class="card-label">
                                        Exam
                                        <small>Manager</small>
                                    </h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <ul class="Proccess_Group">
                                    <li v-for="i in Exam_data">
                                        <strong v-if="locale == 'ar'">@{{i.title_ar}}</strong>
                                        <strong v-if="locale == 'en'">@{{i.title_en}}</strong>
                                        <i class="fa fa-edit" v-on:click="UpdateTopic(i, 'exam')"></i>
                                    </li>

                                </ul>
                                <form class="card-body add_pgroup_form">
                                    <div class="form-group">
                                        <label for="Exam_new"> Add Exam: </label>
                                        <br>
                                        <input type="text" id="Exam_new" v-model="Exam_new" class="form-control" placeholder="English">
                                        <br>
                                        <input type="text" id="Exam_new" v-model="Exam_new_ar" class="form-control" placeholder="عربي">
                                        <br>
                                        <a v-on:click="add('exam')" class="btn btn-outline-primary" >Add</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-custom gutter-b">
                            <div class="card-header card-header-custum">
                                <div class="card-title">
                                    <h3 class="card-label">
                                        Chapter
                                        <small>Manager</small>
                                    </h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <ul class="knowledgeArea">
                                    <li v-for="i in Karea_data">
                                        <strong v-if="locale == 'ar'">@{{i.title_ar}}</strong>
                                        <strong v-if="locale == 'en'">@{{i.title_en}}</strong>
                                        <i class="fa fa-edit" v-on:click="UpdateTopic(i, 'chapter')"></i>
                                    </li>
                                </ul>
                                <form class="card-body add_karea_form">

                                    <div class="form-group " class="add_karea_form">
                                        <label for="Karea_new"> Add Chapter: </label>
                                        <br>
                                        <input type="text" v-model="Karea_new" class="form-control" placeholder="English">
                                        <br>
                                        <input type="text" v-model="Karea_new_ar" class="form-control" placeholder="عربي">
                                        <br>
                                        <div class="">
                                            <label class="form-check-label">
                                                Knowledge Area :
                                                <input type="checkbox" class="form-check-input" v-model="checkedCK" style="margin-left: 10px;">
                                                @{{checkedCK}}
                                            </label>
                                            <br><br>
                                            <div class="form-group">
                                                <label for="list3"> Attach to Course : </label>
                                                <select v-model="selected3" class="form-control" id="list3" >
                                                    <option disabled value="">Choose Course</option>
                                                    <option v-if="locale == 'ar'" v-for="i in courses_data">@{{i.title_ar}}</option>
                                                    <option v-if="locale == 'en'" v-for="i in courses_data" :value="i.id">@{{i.title_en}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <a v-on:click="add('chapter')" class="btn btn-outline-primary">Add</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-custom gutter-b">
                            <div class="card-header card-header-custum">
                                <div class="card-title">
                                    <h3 class="card-label">
                                        Process Group
                                        <small>Manager</small>
                                    </h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <ul class="Proccess_Group">
                                    <li v-for="i in PGroup_data">
                                        <strong v-if="locale == 'ar'">@{{i.title_ar}}</strong>
                                        <strong v-if="locale == 'en'">@{{i.title_en}}</strong>
                                        <i class="fa fa-edit" v-on:click="UpdateTopic(i, 'process_group')"></i>
                                    </li>

                                </ul>
                                <form class="card-body add_pgroup_form">
                                    <div class="form-group">
                                        <label for="PGroup_new"> Add Proccess Group: </label>
                                        <br>
                                        <input type="text" v-model="PGroup_new" class="form-control" placeholder="English">
                                        <br>
                                        <input type="text" v-model="PGroup_new_ar" class="form-control" placeholder="عربي">
                                        <br>
                                        <a v-on:click="add('process_group')" class="btn btn-outline-primary" >Add</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>


                </div>


                <div class="row save-data">
                    <div class="card-body" >
                        {{-- <a v-on:click="save" class="btn btn-primary">Save</a> --}}
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="update-topic-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">@{{ modal_title }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label >English: </label>
                            <input type="text" v-model="modal_textBox_value" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label >Arabic: </label>
                            <input type="text" v-model="modal_textBox_value_ar" class="form-control" placeholder="عربي"/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="SubmitUpdateTopic">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>




@endsection

@section('jscode')
    <script src="https://unpkg.com/sweetalert2@7.8.2/dist/sweetalert2.all.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>
    <script>
        // $all { chapters, process groups, project management group } (0,1,2)
        var app = new Vue({
            el: '#app-1',
            data: {
                locale: '{{$locale}}',
                selected1: '',
                selected2:'',
                selected3: '',
                PGroup_new: '',
                PGroup_new_ar: '',
                PGroup_data: [], // data
                Karea_new: '',
                Karea_new_ar: '',
                checkedCK: '',
                Karea_data: [], // data
                course_new: '',
                course_new_ar: '',
                courses_data: [], // data
                private: 1,
                Exam_new: '',
                Exam_new_ar: '',
                Exam_data: [], // data

                // Edit Modal
                modal_title: '',
                modal_textBox_value: '',
                modal_textBox_value_ar: '',
                modal_edit_id: '',
                modal_edit_type: '',
                modal_edit_index: '',


            },
            mounted(){

                this.load();

            },
            methods: {
                load: function(){
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax ({
                        type: 'POST',
                        url: '{{ route('chapterManager.load')}}',
                        success: function(res){
                            console.log('Response: ', res);
                            app.PGroup_data = res.process_groups;
                            app.courses_data = res.courses;
                            app.Karea_data = res.chapters;
                            app.Exam_data = res.exams;

                        },
                        error: function(res){
                            console.log('Error:', res);
                        }
                    });
                },

                SubmitUpdateTopic: function(e){
                    // this.modal_edit_type
                    // this.modal_edit_id
                    // this.modal_textBox_value, _ar

                    if( this.modal_textBox_value == '' || this.modal_textBox_value_ar == ''){
                        swal({
                            title: 'All Fields Are Required',
                            type: 'error',
                            //   confirmButtonColor: '#DD6B55',
                            confirmButtonText: 'Ok',
                        });
                        return;
                    }

                    var Data = {
                        value_en: this.modal_textBox_value,
                        value_ar: this.modal_textBox_value_ar,
                        type: this.modal_edit_type,
                        id: this.modal_edit_id,
                    };


                    $.ajax ({
                        type: 'PUT',
                        url: '{{ route('chapterManager.update')}}',
                        data: Data,
                        success: function(res){
                            app.load();
                            $("#update-topic-modal").modal('hide');

                        },
                        error: function(res){
                            console.log('Error:', res);
                        }
                    });



                },
                UpdateTopic: function(i, type, index){
                    $("#update-topic-modal").modal('show');
                    this.locale == 'en' ? this.modal_title = i.title_en: this.modal_title = i.title_ar;
                    this.modal_textBox_value = i.title_en;
                    this.modal_textBox_value_ar = i.title_ar;
                    this.modal_edit_type = type;
                    this.modal_edit_id = i.id;
                    this.modal_edit_index = index;
                },
                addNewExam: function(e){
                    if (this.Exam_new == '')
                    {
                        alert("It's Rquired")
                    }else{
                        this.Exam_data.push(this.Exam_new);
                        var Data = {
                            value: this.Exam_new,
                            type: 'exam'
                        };

                        this.Exam_new = '';



                        $.ajax ({
                            type: 'POST',
                            url: '{{ route('chapterManager.add')}}',
                            data: Data,
                            success: function(res){
                                // do nothing
                                // console.log(res);

                            },
                            error: function(res){
                                console.log('Error:', res);
                            }
                        });
                    }
                },
                removeExam: function(item){
                    i = this.Exam_data.indexOf(item);
                    if(i > -1){
                        this.Exam_data.splice(i, 1);
                    }
                    console.log("deleted");
                },
                DeleteExam: function(item){

                    var Data= {
                        value: item,
                        type: 'exam'
                    };

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax ({
                        type: 'DELETE',
                        url: '{{ route('chapterManager.delete')}}',
                        data: Data,
                        success: function(res){
                            // do nothing
                            console.log(res);
                            if( res != '300'){
                                app.removeExam(item);
                                $("#error-msg").removeClass('alert alert-danger').html('');
                            }else{
                                // cant delete it (alert)
                                var err = $("#error-msg").addClass('alert alert-danger');
                                err.html('<strong>Error : </strong> You can\'t Delete it, It\'s already in use ! ');
                            }

                        },
                        error: function(res){
                            console.log('Error:', res);
                        }
                    });
                },

                add: function(type){
                    // validation & data picker
                    if(type == 'course'){
                        // validation
                        if(this.course_new == '' || this.course_new_ar == ''){
                            swal({
                                title: 'Course data are required !',
                                type: 'error',
                                //   confirmButtonColor: '#DD6B55',
                                confirmButtonText: 'Ok',
                            });
                            return;
                        }

                        // pick data up
                        Data = {
                            value_en: this.course_new,
                            value_ar: this.course_new_ar,
                            private: this.private,
                            type: type
                        }

                    }

                    if(type == 'exam'){
                        // validation
                        if(this.Exam_new == '' || this.Exam_new_ar == ''){
                            swal({
                                title: 'Exam data are required !',
                                type: 'error',
                                //   confirmButtonColor: '#DD6B55',
                                confirmButtonText: 'Ok',
                            });
                            return;
                        }

                        // pick data up
                        Data = {
                            value_en: this.Exam_new,
                            value_ar: this.Exam_new_ar,
                            type: type
                        }

                    }

                    if(type == 'chapter'){
                        // validation
                        if(this.Karea_new == '' || this.selected3 == '') {
                            swal({
                                title: 'Chapter data are required !',
                                type: 'error',
                                //   confirmButtonColor: '#DD6B55',
                                confirmButtonText: 'Ok',
                            });
                            return;
                        }

                        // pick data up
                        Data = {
                            value_en: this.Karea_new,
                            value_ar: this.Karea_new_ar,
                            CK: this.checkedCK,
                            course: this.selected3,
                            type: type

                        };

                    }

                    if(type == 'process_group'){
                        // validation
                        if(this.PGroup_new == '' || this.PGroup_new_ar == '') {
                            swal({
                                title: 'Process Group data are required !',
                                type: 'error',
                                //   confirmButtonColor: '#DD6B55',
                                confirmButtonText: 'Ok',
                            });
                            return;
                        }

                        // pick data up
                        Data = {
                            value_en: this.PGroup_new,
                            value_ar: this.PGroup_new_ar,
                            type: type
                        };

                    }



                    // send data
                    $.ajax ({
                        type: 'POST',
                        url: '{{ route('chapterManager.add')}}',
                        data: Data,
                        success: function(res){
                            console.log('Response: ', res, 'Type: ', type);
                            // update list
                            if(res){
                                if(type == 'course'){
                                    app.courses_data.push(res);
                                }

                                if(type == 'exam'){
                                    app.Exam_data.push(res);
                                }

                                if(type == 'chapter'){
                                    app.Karea_data.push(res);
                                }

                                if(type == 'process_group'){
                                    app.PGroup_data.push(res);
                                }
                            }




                        },
                        error: function(res){
                            console.log('Error:', res);
                        }
                    });



                },
                remove_course: function(item){
                    i = this.courses_data.indexOf(item);
                    if(i > -1){
                        this.courses_data.splice(i, 1);
                    }
                    console.log("deleted");
                },
                DeleteCourse: function(item){
                    var Data= {
                        value: item,
                        type: 'course'
                    };

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax ({
                        type: 'DELETE',
                        url: '{{ route('chapterManager.delete')}}',
                        data: Data,
                        success: function(res){
                            // do nothing
                            console.log(res);
                            if( res != '300'){
                                app.remove_course(item);
                                $("#error-msg").removeClass('alert alert-danger').html('');
                            }else{
                                // cant delete it (alert)
                                var err = $("#error-msg").addClass('alert alert-danger');
                                err.html('<strong>Error : </strong> You can\'t Delete it, It\'s already in use ! ');
                            }

                        },
                        error: function(res){
                            console.log('Error:', res);
                        }
                    });
                },


                remove_PGroup: function(item){
                    i = this.PGroup_data.indexOf(item);
                    if(i > -1){
                        this.PGroup_data.splice(i, 1);
                    }
                    console.log("deleted");
                },
                DeletePGroup: function(item){

                    var Data= {
                        value: item,
                        type: 'process_group'
                    };

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax ({
                        type: 'DELETE',
                        url: '{{ route('chapterManager.delete')}}',
                        data: Data,
                        success: function(res){
                            // do nothing
                            console.log(res);
                            if( res != '300'){
                                app.remove_PGroup(item);
                                $("#error-msg").removeClass('alert alert-danger').html('');
                            }else{
                                // cant delete it (alert)
                                var err = $("#error-msg").addClass('alert alert-danger');
                                err.html('<strong>Error : </strong> You can\'t Delete it, It\'s already in use ! ');
                            }

                        },
                        error: function(res){
                            console.log('Error:', res);
                        }
                    });
                },

                remove_PMG: function(item){
                    i = this.projectMGroup_data.indexOf(item);
                    if(i > -1){
                        this.projectMGroup_data.splice(i, 1);
                    }
                    console.log("deleted");
                },
                DeletePMG: function(item){

                    var Data= {
                        value: item,
                        type: 'PMG'
                    };

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax ({
                        type: 'DELETE',
                        url: '{{ route('chapterManager.delete')}}',
                        data: Data,
                        success: function(res){
                            // do nothing
                            console.log(res);
                            if( res != '300'){
                                app.remove_PMG(item);
                                $("#error-msg").removeClass('alert alert-danger').html('');
                            }else{
                                // cant delete it (alert)
                                var err = $("#error-msg").addClass('alert alert-danger');
                                err.html('<strong>Error : </strong> You can\'t Delete it, It\'s already in use ! ');
                            }

                        },
                        error: function(res){
                            console.log('Error:', res);
                        }
                    });
                },

                remove_chapter: function(item){
                    i = this.Karea_data.indexOf(item);
                    if(i > -1){
                        this.Karea_data.splice(i, 1);
                    }
                    console.log('deleted');
                },
                DeleteKarea: function(item){
                    var Data= {
                        value: item,
                        type: 'knowledge'
                    };

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax ({
                        type: 'DELETE',
                        url: '{{ route('chapterManager.delete')}}',
                        data: Data,
                        success: function(res){
                            // do nothing
                            console.log(res);
                            if( res != '300'){
                                app.remove_chapter(item);
                                $("#error-msg").removeClass('alert alert-danger').html('');
                            }else{
                                // cant delete it (alert)
                                var err = $("#error-msg").addClass('alert alert-danger');
                                err.html('<strong>Error : </strong> You can\'t Delete it, It\'s already in use ! ');
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
