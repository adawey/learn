@extends('layouts.app-1')
@section('pageTitle') Library @endsection
@section('subheaderTitle')
        <!--begin::Page Title-->
        <h2 class="subheader-title text-dark font-weight-bold my-2 mr-3">
            <span class="card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect x="0" y="0" width="24" height="24"></rect>
                        <path d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z" fill="#F64E60"></path>
                        <rect fill="#F64E60" opacity="0.3" transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)" x="16.3255682" y="2.94551858" width="3" height="18" rx="1"></rect>
                    </g>
                </svg>
            </span>
            <h3 class="card-label pr-2">Library </h3>
        </h2>
        <!--end::Page Title-->
        <!--begin::Breadcrumb-->
        <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold my-2 p-0">
            <li class="breadcrumb-item">
                <a href="{{route('admin.dashboard')}}" class="text-muted">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="#" class="text-muted">All Course</a>
            </li>
        </ul>
        <!--end::Breadcrumb-->
@endsection
@section('subheaderNav')
    <a href="{{route('library.create')}}" class="btn btn-fh btn-white btn-hover-primary font-weight-bold px-2 px-lg-5 mr-2">
    <span class="svg-icon svg-icon-success svg-icon-lg">
        <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Add-user.svg-->
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <polygon points="0 0 24 0 24 24 0 24"></polygon>
                <path d="M18,8 L16,8 C15.4477153,8 15,7.55228475 15,7 C15,6.44771525 15.4477153,6 16,6 L18,6 L18,4 C18,3.44771525 18.4477153,3 19,3 C19.5522847,3 20,3.44771525 20,4 L20,6 L22,6 C22.5522847,6 23,6.44771525 23,7 C23,7.55228475 22.5522847,8 22,8 L20,8 L20,10 C20,10.5522847 19.5522847,11 19,11 C18.4477153,11 18,10.5522847 18,10 L18,8 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                <path d="M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" fill="#000000" fill-rule="nonzero"></path>
            </g>
        </svg>
        <!--end::Svg Icon-->
    </span>Add New Course</a>
    <a href="#" onclick="app.AddExam()" class="btn btn-fh btn-white btn-hover-primary font-weight-bold px-2 px-lg-5 mr-2">
    <span class="svg-icon svg-icon-success svg-icon-lg">
        <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Add-user.svg-->
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <polygon points="0 0 24 0 24 24 0 24"></polygon>
                <path d="M18,8 L16,8 C15.4477153,8 15,7.55228475 15,7 C15,6.44771525 15.4477153,6 16,6 L18,6 L18,4 C18,3.44771525 18.4477153,3 19,3 C19.5522847,3 20,3.44771525 20,4 L20,6 L22,6 C22.5522847,6 23,6.44771525 23,7 C23,7.55228475 22.5522847,8 22,8 L20,8 L20,10 C20,10.5522847 19.5522847,11 19,11 C18.4477153,11 18,10.5522847 18,10 L18,8 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                <path d="M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" fill="#000000" fill-rule="nonzero"></path>
            </g>
        </svg>
        <!--end::Svg Icon-->
    </span>Add New {{config('library.exam.en')}}</a>
    <a href="#" onclick="app.AddSection()" class="btn btn-fh btn-white btn-hover-primary font-weight-bold px-2 px-lg-5 mr-2">
    <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Code\Plus.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
            <rect x="0" y="0" width="24" height="24"/>
            <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10"/>
            <path d="M11,11 L11,7 C11,6.44771525 11.4477153,6 12,6 C12.5522847,6 13,6.44771525 13,7 L13,11 L17,11 C17.5522847,11 18,11.4477153 18,12 C18,12.5522847 17.5522847,13 17,13 L13,13 L13,17 C13,17.5522847 12.5522847,18 12,18 C11.4477153,18 11,17.5522847 11,17 L11,13 L7,13 C6.44771525,13 6,12.5522847 6,12 C6,11.4477153 6.44771525,11 7,11 L11,11 Z" fill="#000000"/>
        </g>
    </svg></span>Add New Blog Section</a>
@endsection

@section('content')
    <div class="row" id="app-1">

        <div class="col-12">
            <div class="card card-custom mt-5">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">Courses</h3>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover table-checkable" id="kt_datatable1" style="margin-top: 13px !important">
                        <thead>
                        <tr>
                            <td>#</td>
                            <td>Course Title (EN)</td>
                            <td>Show</td>
                            <td>Edit</td>
                            <td>Delete</td>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($courses as $i)
                                <tr>
                                    <td>{{$i->id}}</td>
                                    <td>{{$i->title}}</td>
                                    <td>
                                        <button class="btn btn-outline-info" @click="getCourse('{{$i->id}}')">
                                            <i class="fa fa-eye"></i> Show
                                        </button>
                                    </td>
                                    <td>
                                        <button class="btn btn-outline-warning" onclick="window.location.href='{{route('library.edit', $i->id)}}'">
                                            <i class="fa fa-edit"></i> Edit
                                        </button>
                                    </td>
                                    <td>
                                        <button class="btn btn-outline-danger" onclick="AVUtil().deleteConfirmation('{{route('library.destroy', $i->id)}}', function(url){window.location.href = url;})">
                                            <i class="fa fa-trash"></i> Delete
                                        </button>
                                    </td>
                                </tr>
                            @endforeach


                        </tbody>

                    </table>
                </div>
            </div>
        </div>
        <div class="modal fade" id="pathView" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{config('library.course.en')}}: @{{ course_title }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body" style="height: 300px;">
                        <ul>
                            <li v-for="(chapter) in courses.chapters">
                                @{{ chapter.title }}
                                </li>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-12">
            <div class="card card-custom mt-5">
                <div class="card-body">
                    <table class="table table-bordered table-hover table-checkable" id="kt_datatable1" style="margin-top: 13px !important">

                        <thead>
                        <tr>
                            <td>#</td>
                            <td>Exam Name</td>
                            <td>Exam Duration</td>
                            <td>Edit</td>
                            <td>Delete</td>
                        </tr>
                        </thead>

                        <tbody>


                        <tr v-for="i in exams">
                            <td>@{{i.id}}</td>
                            <td>@{{i.name}}</td>
                            <td>@{{ i.duration?  i.duration + ' mins': '--'}}</td>
                            <td>
                                <button class="btn btn-outline-warning" @click="EditExam(i.id)">
                                    <i class="fa fa-edit"></i> Edit
                                </button>
                            </td>
                            <td>
                                <button class="btn btn-outline-danger" @click="deleteExam(i.id)">
                                    <i class="fa fa-trash"></i> Delete
                                </button>
                            </td>
                        </tr>



                        </tbody>

                    </table>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card card-custom mt-5">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">Sections</h3>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover table-checkable" id="kt_datatable1" style="margin-top: 13px !important">

                        <thead>
                        <tr>
                            <td>#</td>
                            <td>Section Title (EN)</td>
                            <td>Edit</td>
                            <td>Delete</td>
                        </tr>
                        </thead>

                        <tbody>


                        <tr v-for="i in sections">
                            <td>@{{i.id}}</td>
                            <td>@{{i.title}}</td>
                            <td>
                                <button class="btn btn-outline-warning" @click="EditSection(i.id)">
                                    <i class="fa fa-edit"></i> Edit
                                </button>
                            </td>
                            <td>
                                <button class="btn btn-outline-danger" @click="deleteSection(i.id)">
                                    <i class="fa fa-trash"></i> Delete
                                </button>
                            </td>
                        </tr>



                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('jscode')
    @if(env('APP_ENV') == 'local')
        <script src="{{asset('helper/js/vue-dev.js')}}"></script>
    @else
        <script src="{{asset('helper/js/vue-prod.min.js')}}"></script>
    @endif
    <script>
        app = new Vue({
            el: '#app-1',
            data: {
                course_title: '',
                courses: [],
                exams: [],
                domains: [],
                sections: [],
            },
            mounted() {
                this.getExams();
                this.getDomains();
                this.getSections();
            },
            methods: {
                getCourse: function(course_id){
                    KTApp.blockPage();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}',
                        }
                    });

                    $.ajax ({
                        type: 'POST',
                        url: '{{ route('library.show', '')}}/' + course_id,
                        success: function (res) {
                            app.courses = res;
                            app.course_title = res.title;
                            $('#pathView').modal('show');
                            console.log(res);
                            KTApp.unblockPage();
                        },
                        error: function(err){console.log('Error:', err);}
                    });

                },

                EditExam: function(id){
                    Swal.fire({
                        title: 'Enter New Exam Title',
                        input: 'text',
                        inputAttributes: {
                            autocapitalize: 'off'
                        },
                        showCancelButton: true,
                        confirmButtonText: 'Continue',
                        showLoaderOnConfirm: true,
                        preConfirm:(ExamTitle) => {
                            Swal.fire({
                                title: 'Enter Exam Time in Minutes',
                                input: 'text',
                                inputAttributes: {
                                    autocapitalize: 'off'
                                },
                                showCancelButton: true,
                                confirmButtonText: 'Update',
                                showLoaderOnConfirm: true,
                                allowOutsideClick: () => !Swal.isLoading(),
                                preConfirm: (examDuration) => {
                                    return fetch('{{route('library.exam.update', '')}}/'+ id, {
                                        method: 'POST',
                                        headers: {
                                            "Content-Type": "application/json",
                                            'X-CSRF-TOKEN': '{{csrf_token()}}',
                                        },
                                        body: JSON.stringify({
                                            exam_title: ExamTitle,
                                            duration: examDuration,
                                        }),
                                    })
                                        .then(response => {
                                            if (!response.ok) {
                                                // make the promise be rejected if we didn't get a 2xx response
                                                console.log(response);
                                                throw new Error(`${response.statusText}`)
                                            } else {
                                                return response.json();
                                            }
                                        })
                                        .catch(error => {
                                            Swal.showValidationMessage(
                                                `Request failed: ${error}`
                                            )
                                        });
                                }
                            }).then((result) => {
                                if(result.dismiss == 'cancel'){
                                    swal({
                                        text: "Cancelled.",
                                        type: "success",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, got it!",
                                        confirmButtonClass: "btn font-weight-bold btn-light"
                                    });
                                }else{
                                    swal({
                                        text: "Updated.",
                                        type: "success",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, got it!",
                                        confirmButtonClass: "btn font-weight-bold btn-light"
                                    }).then(() => {
                                        app.getExams();
                                    });
                                }
                            });


                        },
                        allowOutsideClick: () => !Swal.isLoading()
                    }).then((result) => {
                        if(result.dismiss == 'cancel'){
                            swal({
                                text: "Cancelled.",
                                type: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                confirmButtonClass: "btn font-weight-bold btn-light"
                            });
                        }
                    })
                },
                deleteExam: function(id){
                    AVUtil().deleteConfirmation('{{route('library.exam.destroy', '')}}'+'/'+id, function(url){
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': '{{csrf_token()}}',
                            }
                        });
                        $.ajax ({
                            type: 'GET',
                            url,
                            success: function(){
                                window.location.reload();
                            }
                        });
                    })
                },
                AddExam: function(){
                    Swal.fire({
                        title: 'Enter New Exam Title',
                        input: 'text',
                        inputAttributes: {
                            autocapitalize: 'off'
                        },
                        showCancelButton: true,
                        confirmButtonText: 'Continue',
                        showLoaderOnConfirm: true,
                        allowOutsideClick: () => !Swal.isLoading(),
                        preConfirm:(ExamTitle) => {
                            Swal.fire({
                                title: 'Enter Exam Time in Minutes',
                                input: 'text',
                                inputAttributes: {
                                    autocapitalize: 'off'
                                },
                                showCancelButton: true,
                                confirmButtonText: 'Create',
                                showLoaderOnConfirm: true,
                                allowOutsideClick: () => !Swal.isLoading(),
                                preConfirm: (examDuration) => {
                                    return fetch('{{route('library.exam.store')}}', {
                                        method: 'POST',
                                        headers: {
                                            "Content-Type": "application/json",
                                            'X-CSRF-TOKEN': '{{csrf_token()}}',
                                        },
                                        body: JSON.stringify({
                                            exam_title: ExamTitle,
                                            duration: examDuration,
                                        }),
                                    })
                                        .then(response => {
                                            if (!response.ok) {
                                                // make the promise be rejected if we didn't get a 2xx response
                                                console.log(response);
                                                throw new Error(`${response.statusText}`)
                                            } else {
                                                return response.json();

                                            }
                                        })
                                        .catch(error => {
                                            Swal.showValidationMessage(
                                                `Request failed: ${error}`
                                            )
                                        });

                                }
                            }).then((result) => {
                                if(result.dismiss == 'cancel'){
                                    swal({
                                        text: "Cancelled.",
                                        type: "success",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, got it!",
                                        confirmButtonClass: "btn font-weight-bold btn-light"
                                    });
                                }else{
                                    swal({
                                        text: "Added.",
                                        type: "success",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, got it!",
                                        confirmButtonClass: "btn font-weight-bold btn-light"
                                    }).then(() => {
                                        app.getExams();
                                    });
                                }
                            });

                        },
                    }).then((result) => {
                        if(result.dismiss == 'cancel'){
                            swal({
                                text: "Cancelled.",
                                type: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                confirmButtonClass: "btn font-weight-bold btn-light"
                            });
                        }
                    })
                },
                getExams: function(){
                    KTApp.blockPage();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}',
                        }
                    });
                    $.ajax ({
                        type: 'POST',
                        url: '{{ route('library.exam.index')}}',
                        success: function (res) {
                            console.log(res);
                            app.exams = res;
                            KTApp.unblockPage();
                        },
                        error: function(err){console.log('Error:', err);}
                    });
                },

                AddSection: function(){
                    Swal.fire({
                        title: 'Enter New Section Title (EN)',
                        input: 'text',
                        inputAttributes: {
                            autocapitalize: 'off'
                        },
                        showCancelButton: true,
                        confirmButtonText: 'Continue',
                        showLoaderOnConfirm: true,
                        allowOutsideClick: () => !Swal.isLoading(),
                        preConfirm:(SectionTitle) => {

                            return fetch('{{route('library.section.store')}}', {
                                method: 'POST',
                                headers: {
                                    "Content-Type": "application/json",
                                    'X-CSRF-TOKEN': '{{csrf_token()}}',
                                },
                                body: JSON.stringify({
                                    section_title: SectionTitle,
                                }),
                            })
                                .then(response => {
                                    if (!response.ok) {
                                        // make the promise be rejected if we didn't get a 2xx response
                                        console.log(response);
                                        throw new Error(`${response.statusText}`)
                                    } else {
                                        return response.json();

                                    }
                                })
                                .catch(error => {
                                    Swal.showValidationMessage(
                                        `Request failed: ${error}`
                                    )
                                });
                        },
                    }).then((result) => {
                        if(result.dismiss == 'cancel'){
                            swal({
                                text: "Cancelled.",
                                type: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                confirmButtonClass: "btn font-weight-bold btn-light"
                            });
                        }
                        app.getSections();
                    })
                },
                deleteSection: function(id){
                    AVUtil().deleteConfirmation('{{route('library.section.destroy', '')}}'+'/'+id, function(url){
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': '{{csrf_token()}}',
                            }
                        });
                        $.ajax ({
                            type: 'GET',
                            url,
                            success: function(){
                                window.location.reload();
                            }
                        });
                    })
                },
                EditSection: function(id){
                    Swal.fire({
                        title: 'Enter New Section Title (EN)',
                        input: 'text',
                        inputAttributes: {
                            autocapitalize: 'off'
                        },
                        showCancelButton: true,
                        confirmButtonText: 'Continue',
                        showLoaderOnConfirm: true,
                        preConfirm:(SectionTitle) => {
                            return fetch('{{route('library.section.update', '')}}/'+ id, {
                                method: 'POST',
                                headers: {
                                    "Content-Type": "application/json",
                                    'X-CSRF-TOKEN': '{{csrf_token()}}',
                                },
                                body: JSON.stringify({
                                    section_title: SectionTitle,
                                }),
                            }).then(response => {
                                if (!response.ok) {
                                    // make the promise be rejected if we didn't get a 2xx response
                                    console.log(response);
                                    throw new Error(`${response.statusText}`)
                                } else {
                                    return response.json();
                                }
                            })
                                .catch(error => {
                                    Swal.showValidationMessage(
                                        `Request failed: ${error}`
                                    )
                                });
                        },
                        allowOutsideClick: () => !Swal.isLoading()
                    }).then((result) => {
                        if(result.dismiss == 'cancel'){
                            swal({
                                text: "Cancelled.",
                                type: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                confirmButtonClass: "btn font-weight-bold btn-light"
                            });
                        }
                        app.getSections();
                    })
                },
                getSections: function(){
                    KTApp.blockPage();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}',
                        }
                    });
                    $.ajax ({
                        type: 'POST',
                        url: '{{ route('library.section.index')}}',
                        success: function (res) {
                            console.log(res);
                            app.sections = res;
                            KTApp.unblockPage();
                        },
                        error: function(err){console.log('Error:', err);}
                    });
                },

                EditDomain: function(id){
                    Swal.fire({
                        title: 'Enter New Domain Title (EN)',
                        input: 'text',
                        inputAttributes: {
                            autocapitalize: 'off'
                        },
                        showCancelButton: true,
                        confirmButtonText: 'Continue',
                        showLoaderOnConfirm: true,
                        preConfirm:(DomainTitle) => {
                            Swal.fire({
                                title: 'Enter New Domain Title (AR)',
                                input: 'text',
                                inputAttributes: {
                                    autocapitalize: 'off'
                                },
                                showCancelButton: true,
                                confirmButtonText: 'Continue',
                                showLoaderOnConfirm: true,
                                preConfirm:(DomainTitleAR) => {
                                    Swal.fire({
                                        title: 'Enter New Domain Title (FR)',
                                        input: 'text',
                                        inputAttributes: {
                                            autocapitalize: 'off'
                                        },
                                        showCancelButton: true,
                                        confirmButtonText: 'Continue',
                                        showLoaderOnConfirm: true,
                                        preConfirm:(DomainTitleFR) => {
                                            return fetch('{{route('library.domain.update', '')}}/'+ id, {
                                                method: 'POST',
                                                headers: {
                                                    "Content-Type": "application/json",
                                                    'X-CSRF-TOKEN': '{{csrf_token()}}',
                                                },
                                                body: JSON.stringify({
                                                    domain_title: DomainTitle,
                                                    domain_title_ar: DomainTitleAR,
                                                    domain_title_fr: DomainTitleFR,
                                                }),
                                            })
                                                .then(response => {
                                                    if (!response.ok) {
                                                        // make the promise be rejected if we didn't get a 2xx response
                                                        console.log(response);
                                                        throw new Error(`${response.statusText}`)
                                                    } else {
                                                        return response.json();
                                                    }
                                                })
                                                .catch(error => {
                                                    Swal.showValidationMessage(
                                                        `Request failed: ${error}`
                                                    )
                                                });
                                        }
                                    }).then(res => {
                                        if(res.dismiss == 'cancel'){
                                            swal({
                                                text: "Cancelled.",
                                                type: "success",
                                                buttonsStyling: false,
                                                confirmButtonText: "Ok, got it!",
                                                confirmButtonClass: "btn font-weight-bold btn-light"
                                            });
                                        }else{
                                            swal({
                                                text: "Updated.",
                                                type: "success",
                                                buttonsStyling: false,
                                                confirmButtonText: "Ok, got it!",
                                                confirmButtonClass: "btn font-weight-bold btn-light"
                                            }).then(() => {
                                                app.getDomains();
                                            });
                                        }
                                    });;
                                }
                            });
                        },
                        allowOutsideClick: () => !Swal.isLoading()
                    }).then((result) => {
                        if(result.dismiss == 'cancel'){
                            swal({
                                text: "Cancelled.",
                                type: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                confirmButtonClass: "btn font-weight-bold btn-light"
                            });
                        }
                    })
                },
                deleteDomain: function(id){
                    AVUtil().deleteConfirmation('{{route('library.domain.destroy', '')}}'+'/'+id, function(url){
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': '{{csrf_token()}}',
                            }
                        });
                        $.ajax ({
                            type: 'GET',
                            url,
                            success: function(){
                                window.location.reload();
                            }
                        });
                    })
                },
                AddDomain: function(){
                    Swal.fire({
                        title: 'Enter New Domain Title (EN)',
                        input: 'text',
                        inputAttributes: {
                            autocapitalize: 'off'
                        },
                        showCancelButton: true,
                        confirmButtonText: 'Continue',
                        showLoaderOnConfirm: true,
                        allowOutsideClick: () => !Swal.isLoading(),
                        preConfirm:(DomainTitle) => {
                            Swal.fire({
                                title: 'Enter New Domain Title (AR)',
                                input: 'text',
                                inputAttributes: {
                                    autocapitalize: 'off'
                                },
                                showCancelButton: true,
                                confirmButtonText: 'Continue',
                                showLoaderOnConfirm: true,
                                allowOutsideClick: () => !Swal.isLoading(),
                                preConfirm:(DomainTitleAR) => {
                                    Swal.fire({
                                        title: 'Enter New Domain Title (FR)',
                                        input: 'text',
                                        inputAttributes: {
                                            autocapitalize: 'off'
                                        },
                                        showCancelButton: true,
                                        confirmButtonText: 'Continue',
                                        showLoaderOnConfirm: true,
                                        allowOutsideClick: () => !Swal.isLoading(),
                                        preConfirm:(DomainTitleFR) => {
                                            return fetch('{{ route('library.domain.store') }}', {
                                                method: 'POST',
                                                headers: {
                                                    "Content-Type": "application/json",
                                                    'X-CSRF-TOKEN': '{{csrf_token()}}',
                                                },
                                                body: JSON.stringify({
                                                    domain_title: DomainTitle,
                                                    domain_title_ar: DomainTitleAR,
                                                    domain_title_fr: DomainTitleFR,
                                                }),
                                            })
                                                .then(response => {
                                                    if (!response.ok) {
                                                        // make the promise be rejected if we didn't get a 2xx response
                                                        console.log(response);
                                                        throw new Error(`${response.statusText}`)
                                                    } else {
                                                        return response.json();

                                                    }
                                                })
                                                .catch(error => {
                                                    Swal.showValidationMessage(
                                                        `Request failed: ${error}`
                                                    )
                                                });
                                        }
                                    }).then(res => {
                                        if(res.dismiss == 'cancel'){
                                            swal({
                                                text: "Cancelled.",
                                                type: "success",
                                                buttonsStyling: false,
                                                confirmButtonText: "Ok, got it!",
                                                confirmButtonClass: "btn font-weight-bold btn-light"
                                            });
                                        }else{
                                            swal({
                                                text: "Added.",
                                                type: "success",
                                                buttonsStyling: false,
                                                confirmButtonText: "Ok, got it!",
                                                confirmButtonClass: "btn font-weight-bold btn-light"
                                            }).then(() => {
                                                app.getDomains();
                                            });
                                        }
                                    });
                                }
                            });
                        },
                    }).then((result) => {
                        if(result.dismiss == 'cancel'){
                            swal({
                                text: "Cancelled.",
                                type: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                confirmButtonClass: "btn font-weight-bold btn-light"
                            });
                        }
                    })
                },
                getDomains: function(){
                    KTApp.blockPage();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}',
                        }
                    });
                    $.ajax ({
                        type: 'POST',
                        url: '{{ route('library.domain.index')}}',
                        success: function (res) {
                            console.log(res);
                            app.domains = res;
                            KTApp.unblockPage();
                        },
                        error: function(err){console.log('Error:', err);}
                    });
                },
            }
        });
    </script>
@endsection
