@extends('layouts.app-1')
@section('header')
    <link href="{{asset('assets/css/pages/wizard/wizard-2.css')}}" rel="stylesheet" type="text/css" />
@endsection
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
            <a href="#" class="text-muted">Create</a>
        </li>
    </ul>
    <!--end::Breadcrumb-->
@endsection
@section('subheaderNav')
    <a href="#" onclick="AVUtil().redirectionConfirmation('{{route('library.index')}}')" class="btn btn-fh btn-white btn-hover-primary font-weight-bold px-2 px-lg-5 mr-2">
    <span class="svg-icon svg-icon-success svg-icon-lg">
        <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Add-user.svg-->
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <rect x="0" y="0" width="24" height="24"></rect>
                <path d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z" fill="#F64E60"></path>
                <rect fill="#F64E60" opacity="0.3" transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)" x="16.3255682" y="2.94551858" width="3" height="18" rx="1"></rect>
            </g>
        </svg>
        <!--end::Svg Icon-->
    </span>Library</a>
@endsection

@section('content')
    <div class="card card-custom" id="app-1">
        <div class="card-body p-0">
            <!--begin: Wizard-->
            <div class="wizard wizard-2" id="kt_wizard_v2" data-wizard-state="first" data-wizard-clickable="false">
                <!--begin: Wizard Nav-->
                <div class="wizard-nav border-right py-8 px-8 py-lg-20 px-lg-10">
                    <!--begin::Wizard Step 1 Nav-->
                    <div class="wizard-steps">
                        <div class="wizard-step" data-wizard-type="step" data-wizard-state="current">
                            <div class="wizard-wrapper">
                                <div class="wizard-icon">
                                    <span class="svg-icon svg-icon-2x">
                                        <!--begin::Svg Icon | path:assets/media/svg/icons/General/User.svg-->
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                                <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                                                <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero"></path>
                                            </g>
                                        </svg>
                                        <!--end::Svg Icon-->
                                    </span>
                                </div>
                                <div class="wizard-label">
                                    <h3 class="wizard-title">Setup a {{config('library.course.en')}}</h3>
                                    <div class="wizard-desc">enter {{config('library.course.en')}} titles</div>
                                </div>
                            </div>
                        </div>
                        <!--end::Wizard Step 1 Nav-->
                        <!--begin::Wizard Step 2 Nav-->
                        <div class="wizard-step" data-wizard-type="step" data-wizard-state="pending">
                            <div class="wizard-wrapper">
                                <div class="wizard-icon">
                                    <span class="svg-icon svg-icon-2x">
                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Map/Compass.svg-->
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"></rect>
                                                <path d="M12,21 C7.02943725,21 3,16.9705627 3,12 C3,7.02943725 7.02943725,3 12,3 C16.9705627,3 21,7.02943725 21,12 C21,16.9705627 16.9705627,21 12,21 Z M14.1654881,7.35483745 L9.61055177,10.3622525 C9.47921741,10.4489666 9.39637436,10.592455 9.38694497,10.7495509 L9.05991526,16.197949 C9.04337012,16.4735952 9.25341309,16.7104632 9.52905936,16.7270083 C9.63705011,16.7334903 9.74423017,16.7047714 9.83451193,16.6451626 L14.3894482,13.6377475 C14.5207826,13.5510334 14.6036256,13.407545 14.613055,13.2504491 L14.9400847,7.80205104 C14.9566299,7.52640477 14.7465869,7.28953682 14.4709406,7.27299168 C14.3629499,7.26650974 14.2557698,7.29522855 14.1654881,7.35483745 Z" fill="#000000"></path>
                                            </g>
                                        </svg>
                                        <!--end::Svg Icon-->
                                    </span>
                                </div>
                                <div class="wizard-label">
                                    <h3 class="wizard-title">Define {{config('library.chapter.en')}}</h3>
                                    <div class="wizard-desc">attach {{config('library.chapter.en')}} to courses</div>
                                </div>
                            </div>
                        </div>
                        <!--end::Wizard Step 2 Nav-->
                        <!--begin::Wizard Step 3 Nav-->
                        <div class="wizard-step" data-wizard-type="step" data-wizard-state="pending">
                            <div class="wizard-wrapper">
                                <div class="wizard-icon">
                                    <span class="svg-icon svg-icon-2x">
                                        <!--begin::Svg Icon | path:assets/media/svg/icons/General/Like.svg-->
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"></rect>
                                                <path d="M9,10 L9,19 L10.1525987,19.3841996 C11.3761964,19.7920655 12.6575468,20 13.9473319,20 L17.5405883,20 C18.9706314,20 20.2018758,18.990621 20.4823303,17.5883484 L21.231529,13.8423552 C21.5564648,12.217676 20.5028146,10.6372006 18.8781353,10.3122648 C18.6189212,10.260422 18.353992,10.2430672 18.0902299,10.2606513 L14.5,10.5 L14.8641964,6.49383981 C14.9326895,5.74041495 14.3774427,5.07411874 13.6240179,5.00562558 C13.5827848,5.00187712 13.5414031,5 13.5,5 L13.5,5 C12.5694044,5 11.7070439,5.48826024 11.2282564,6.28623939 L9,10 Z" fill="#000000"></path>
                                                <rect fill="#000000" opacity="0.3" x="2" y="9" width="5" height="11" rx="1"></rect>
                                            </g>
                                        </svg>
                                        <!--end::Svg Icon-->
                                    </span>
                                </div>
                                <div class="wizard-label">
                                    <h3 class="wizard-title">Completed!</h3>
                                    <div class="wizard-desc">Review and Submit</div>
                                </div>
                            </div>
                        </div>
                        <!--end::Wizard Step 3 Nav-->
                    </div>
                </div>
                <!--end: Wizard Nav-->
                <!--begin: Wizard Body-->
                <div class="wizard-body py-8 px-8 py-lg-20 px-lg-10">
                    <!--begin: Wizard Form-->
                    <div class="row">
                        <div class="offset-xxl-2 col-xxl-8">
                            <form class="form fv-plugins-bootstrap fv-plugins-framework" id="kt_form">
                                <!--begin: Wizard Step 1-->
                                <div class="pb-5" data-wizard-type="step-content" data-wizard-state="current">
                                    <h4 class="mb-10 font-weight-bold text-dark">Setup a {{config('library.course.en')}}</h4>
                                    <!--begin::Input-->
                                    <div class="form-group fv-plugins-icon-container">
                                        <label>{{config('library.course.en')}} Title</label>
                                        <input type="text" class="form-control form-control-solid form-control-lg" name="course_title" v-model="course_title" placeholder="{{config('library.course.en')}} Title" value="">
                                        <span class="form-text text-muted">Please enter {{config('library.course.en')}} title in english.</span>

                                        <div class="form-group mt-5">
                                            <label>Private</label>
                                            <span class="switch" style="width: 100%;">
                                            <label>
                                                <input type="checkbox" v-model="course_private">
                                                <span></span>
                                            </label>
                                        </span>
                                        </div>

                                        <div class="fv-plugins-message-container"></div>
                                        <h4 class="mb-10 font-weight-bold text-dark">Setup a Course Details</h4>
                                        <!--begin::Input-->
                                        <div class="form-group fv-plugins-icon-container">
                                            <label>Title</label>
                                            <input type="text" class="form-control form-control-solid form-control-lg" v-model="details_title" placeholder="Title">
                                            <span class="form-text text-muted">Please enter Topic title.</span>
                                            <div class="fv-plugins-message-container"></div>
                                        </div>
                                        <div class="form-group fv-plugins-icon-container">
                                            <label>Description</label>
                                            <div id="topic_description"></div>
                                            <span class="form-text text-muted">Please enter Topic Description.</span>
                                        </div>
                                        <button class="btn btn-success font-weight-bold text-uppercase px-9 py-4" @click.prevent="addDetails">Attach</button>

                                        <hr>

                                        <div class="accordion accordion-light accordion-light-borderless accordion-svg-toggle" id="accordionExample7">
                                            <div class="card" v-for="i, idx in course_details">
                                                <div class="card-header" id="headingOne7">
                                                    <div class="card-title" data-toggle="collapse" :data-target="'#collapse_'+idx">
                                                    <span class="svg-icon svg-icon-primary">
                                                     <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                      <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                       <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                                       <path d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z" fill="#000000" fill-rule="nonzero"></path>
                                                       <path d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) "></path>
                                                      </g>
                                                     </svg>
                                                    </span>
                                                        <div class="card-label pl-4">@{{ i.title }}</div>
                                                    </div>
                                                </div>
                                                <div :id="'collapse_'+idx" class="collapse" :class="{'show': idx == 0}" data-parent="#accordionExample7">
                                                    <div class="card-body pl-12 d-flex">
                                                        <div v-html="i.description" class="flex-grow-1"></div>
                                                        <div class="d-flex flex-column px-2">
                                                            <a href="javascript:;" class="my-2" @click.prevent="editDetails(idx)"><i class="fa fa-edit text-warning"></i></a>
                                                            <a href="javascript:;" class="my-2" @click.prevent="removeDetails(idx)"><i class="fa fa-trash text-danger"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <!--end::Input-->
                                    <!--begin::Input-->

                                </div>
                                <!--end: Wizard Step 1-->
                                <!--begin: Wizard Step 2-->
                                <div class="pb-5" data-wizard-type="step-content">
                                    <h4 class="mb-10 font-weight-bold text-dark">Define {{config('library.chapter.en')}}</h4>
                                    <div class="from-group row">
                                        <div class="col-xl-12">
                                            <!--begin::Input-->
                                            <div class="form-group fv-plugins-icon-container">
                                                <label>{{config('library.chapter.en')}} Title</label>
                                                <input type="text" class="form-control form-control-solid form-control-lg" v-model="chapter_title" placeholder="{{config('library.chapter.en')}} ..">
                                                <span class="form-text text-muted">Please enter {{config('library.chapter.en')}} title in english.</span>
                                                <div class="fv-plugins-message-container"></div>
                                                <button @click.prevent="addChapter" class="btn btn-light-primary font-weight-bold text-uppercase px-9 py-4 float-right">Attach</button>
                                            </div>
                                            <!--end::Input-->

                                            <table class="table table-hover table-striped">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Title EN</th>
                                                    <th>Delete</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(i,index) in chapters">
                                                        <td>@{{ index + 1 }}</td>
                                                        <td>@{{ i.title }}</td>
                                                        <td>
                                                            <a href="#" @click.prevent="removeChapter(index)">
                                                                <i class="la la-trash" style="color: #9d223c;"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>

                                </div>
                                <!--end: Wizard Step 2-->
                                <!--begin: Wizard Step 6-->
                                <div class="pb-5" data-wizard-type="step-content">
                                    <!--begin::Section-->
                                    <h4 class="mb-10 font-weight-bold text-dark">Review your Details and Submit</h4>
                                    <div>
                                        @{{ course_title }}
                                        <ul>
                                            <li v-for="chapter in chapters">
                                                @{{ chapter.title }}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!--end: Wizard Step 6-->
                                <!--begin: Wizard Actions-->
                                <div class="d-flex justify-content-between border-top mt-5 pt-10">
                                    <div class="mr-2">
                                        <button class="btn btn-light-primary font-weight-bold text-uppercase px-9 py-4" data-wizard-type="action-prev">Previous</button>
                                    </div>
                                    <div>
                                        <button class="btn btn-success font-weight-bold text-uppercase px-9 py-4" @click.prevent="store" data-wizard-type="action-submit">Submit</button>
                                        <button class="btn btn-primary font-weight-bold text-uppercase px-9 py-4" data-wizard-type="action-next">Next Step</button>
                                    </div>
                                </div>
                                <!--end: Wizard Actions-->
                                <div></div><div></div><div></div><div></div><div></div></form>
                        </div>
                        <!--end: Wizard-->
                    </div>
                </div>
                <!--end: Wizard Body-->
            </div>
            <!--end: Wizard-->
        </div>
    </div>
@endsection


@section('jscode')
    <script src="{{ asset('helper/js/ckeditor/ckeditor.js')}}"></script>
    @if(env('APP_ENV') == 'local')
        <script src="{{asset('helper/js/vue-dev.js')}}"></script>
    @else
        <script src="{{asset('helper/js/vue-prod.min.js')}}"></script>
    @endif
    <script>

        var KTWizard2 = function () {
            // Base elements
            var _wizardEl;
            var _formEl;
            var _wizard;
            var _validations = [];

            var app = new Vue({
                el: '#app-1',
                data: {
                    details_title: '',
                    details_description: null,
                    course_details: [],
                    course_title: '',
                    course_title_ar: '',
                    course_private: false,
                    chapter_title: '',
                    chapter_title_ar: '',

                    chapters: [],
                    chapter_index: '',

                },
                mounted(){
                    this.details_description = this.initEditor('topic_description', 200);
                },
                methods: {
                    removeDetails: function(idx){
                        this.course_details.splice(idx, 1);
                    },
                    editDetails: function(idx){
                        this.details_title = this.course_details[idx].title;
                        this.details_description.setData(this.course_details[idx].description);
                        this.removeDetails(idx);
                    },
                    addDetails: function(){
                        if(this.is_empty(this.details_title, 'Detail title is required !')){
                            return;
                        }
                        if(this.is_empty(this.details_description.getData(), 'Detail Description is required.')){
                            return;
                        }
                        this.course_details.push({
                            title: this.details_title,
                            description: this.details_description.getData(),
                        });
                        this.details_title = ''; this.details_description.setData('');

                    },
                    initEditor: function(element_id, height){
                        return CKEDITOR.replace(element_id, {
                            height,
                            extraPlugins: 'colorbutton',
                            filebrowserUploadUrl: '{{route('ckeditor.upload', ['_token' => csrf_token()])}}',
                            filebrowserUploadMethod: 'form',
                        });
                    },
                    store: function(){
                        KTApp.blockPage();
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': '{{csrf_token()}}',
                            }
                        });

                        $.ajax ({
                            type: 'POST',
                            data: {
                                course_title: app.course_title,
                                course_title_ar: app.course_title_ar,
                                course_private: app.course_private? 1: 0,
                                chapters: app.chapters,
                                course_details: app.course_details,
                            },
                            url: '{{ route('library.store')}}',
                            success: function(res){
                                console.log(res);
                                KTApp.unblockPage();
                                swal({
                                    text: '{{config('library.course.en')}} setup completed.',
                                    type: "success",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, thank you",
                                    confirmButtonClass: "btn font-weight-bold btn-light"
                                }).then(function () {
                                    window.location.href = '{{route('library.index')}}';
                                });
                            },
                            error: function(err){
                                KTApp.unblockPage();
                                swal({
                                    text: err,
                                    type: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    confirmButtonClass: "btn font-weight-bold btn-light"
                                }).then(function () {
                                    KTApp.scrollTop();
                                });
                            }
                        });

                    },
                    removeChapter: function(chapter_index){
                        this.chapters.splice(chapter_index, 1);
                    },
                    addChapter: function(){
                        if(this.is_empty(this.chapter_title, '{{config('library.chapter.en')}} title in English is required !')){
                            return;
                        }
                        this.chapters.push({
                            title: this.chapter_title,
                            title_ar: this.chapter_title_ar,
                        });
                        this.chapter_title = '';
                        this.chapter_title_ar = '';
                    },
                    is_empty: function(val, err){
                        if(val === '' || val === null){
                            swal({
                                text: err,
                                type: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                confirmButtonClass: "btn font-weight-bold btn-light"
                            }).then(function () {
                                KTUtil.scrollTop();
                            });
                            return true;
                        }
                        return false;

                    },
                },
            });

            // Private functions
            var initWizard = function () {
                // Initialize form wizard
                _wizard = new KTWizard(_wizardEl, {
                    startStep: 1, // initial active step number
                    clickableSteps: true // to make steps clickable this set value true and add data-wizard-clickable="true" in HTML for class="wizard" element
                });

                // Validation before going to next page
                _wizard.on('beforeNext', function (wizard) {
                    _validations[wizard.getStep() - 1].validate().then(function (status) {
                        if (status == 'Valid') {
                            _wizard.goNext();
                            KTUtil.scrollTop();
                        } else {
                            swal({
                                text: "Sorry, looks like there are some errors detected, please try again.",
                                type: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                confirmButtonClass: "btn font-weight-bold btn-light"
                            }).then(function () {
                                KTUtil.scrollTop();
                            });
                        }
                    });

                    _wizard.stop();  // Don't go to the next step
                });

                // Change event
                _wizard.on('change', function (wizard) {
                    KTUtil.scrollTop();
                });
            }

            var initValidation = function () {
                // Step 1
                _validations.push(FormValidation.formValidation(
                    _formEl,
                    {
                        fields: {
                            /** Step 1 */
                            course_title: {
                                validators: {
                                    notEmpty: {
                                        message: '{{config('library.course.en')}} Title in English is required.'
                                    }
                                }
                            },
                        },
                        plugins: {
                            trigger: new FormValidation.plugins.Trigger(),
                            bootstrap: new FormValidation.plugins.Bootstrap()
                        }
                    }
                ));

                // Step 2
                _validations.push(FormValidation.formValidation(
                    _formEl,
                    {
                        fields: {

                        },
                        plugins: {
                            trigger: new FormValidation.plugins.Trigger(),
                            bootstrap: new FormValidation.plugins.Bootstrap()
                        }
                    }
                ));

                // Step 3
                _validations.push(FormValidation.formValidation(
                    _formEl,
                    {
                        fields: {

                        },
                        plugins: {
                            trigger: new FormValidation.plugins.Trigger(),
                            bootstrap: new FormValidation.plugins.Bootstrap()
                        }
                    }
                ));

                // Step 4
                _validations.push(FormValidation.formValidation(
                    _formEl,
                    {
                        fields: {

                        },
                        plugins: {
                            trigger: new FormValidation.plugins.Trigger(),
                            bootstrap: new FormValidation.plugins.Bootstrap()
                        }
                    }
                ));

                // Step 5
                _validations.push(FormValidation.formValidation(
                    _formEl,
                    {
                        fields: {

                        },
                        plugins: {
                            trigger: new FormValidation.plugins.Trigger(),
                            bootstrap: new FormValidation.plugins.Bootstrap()
                        }
                    }
                ));
            }

            return {
                // public functions
                init: function () {
                    _wizardEl = KTUtil.getById('kt_wizard_v2');
                    _formEl = KTUtil.getById('kt_form');

                    initWizard();
                    initValidation();
                },
                app
            };
        }();

        jQuery(document).ready(function () {
            KTWizard2.init();
        });
    </script>
@endsection
