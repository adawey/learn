@extends('layouts.app-1')
@section('pageTitle') New Explanation @endsection
@section('subheaderTitle') New Explanation @endsection
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
    <a href="#" onclick="AVUtil().redirectionConfirmation('{{route('explanation.index')}}')" class="btn btn-fh btn-white btn-hover-primary font-weight-bold px-2 px-lg-5 mr-2">
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



    <div class="row" id="app-1" style="background-color: white; padding: 0 0;">
        <div class="col-md-12">

            <div class="form-horizontal" style="background: white; padding: 30px 15px;">

                <div class="form-group row">
                    <label class="col-2 col-form-label" for="title" >Title :</label>
                    <div class="col-10">
                        <input type="text" class="form-control input-sm" name="title" v-model="title"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 col-form-label" for="exampleSelectd1">Course</label>
                    <div class="col-10">
                        <select class="form-control" id="exampleSelectd1" v-on:change="getChapters" v-model="course">
                            <option> Choose one</option>
                            @foreach(\App\Course::where('private', 0)->get() as $course)
                                <option value="{{$course->id}}"> {{$course->title}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 col-form-label" for="exampleSelectd2">chapter</label>
                    <div class="col-10">
                        <select class="form-control chapter" id="exampleSelectd3"  v-model="chapter" name="chapter" disabled>
                            <option disabled value="">Choose one </option>
                            <option v-for="i in chapter_data" :value="i.id">@{{i.name}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group form-md-line-input">
                    <div id="contentEditor"></div>
                </div>

                <div class="form-group control-label">
                    <div class="col-md-2">
                        <input type="submit" value="Save" @click="store" class="btn btn-success">
                    </div>
                </div>
            </div>
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
        const app = new Vue({
            el: '#app-1',
            data: {
                title: '',
                contentEditor: '',
                course: '',
                chapter: '',
                chapter_data: [],

            },
            mounted() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    }
                });
                this.contentEditor = this.initEditor('contentEditor', 280);
            },
            methods: {
                validate: function(){
                    let validation = {
                        hasError: true,
                        error: '',
                    };

                    if(this.title === ""){
                        validation.error = 'Title is required.';
                        return validation;
                    }

                    if(this.contentEditor.getData() === ""){
                        validation.error = 'Content of the explanation is required.';
                        return validation;
                    }

                    validation.hasError = false;
                    return validation;
                },
                store: async function(){
                    const validation = this.validate();
                    if(validation.hasError){
                        this.showError(validation.error);
                        return;
                    }
                    KTApp.blockPage();
                    await app.storeRequest().then(() => {
                        KTApp.unblockPage();
                        swal({
                            text: 'Explanation Has been saved.',
                            type: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            confirmButtonClass: "btn font-weight-bold btn-light"
                        }).then(function () {
                            window.location.replace('{{route('explanation.index')}}');
                        });
                    });
                },
                storeRequest: async function(){
                    return $.ajax ({
                        type: 'POST',
                        url: '{{ route('explanation.store')}}',
                        data: {
                            title: app.title,
                            explanation: app.contentEditor.getData(),
                            chapter_id: app.chapter,
                            course_id: app.course,
                        },
                        error: function(err){
                            KTApp.unblockPage();
                            console.log(err);
                            app.showError('ops, something went wrong.');
                        }
                    });
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
                initEditor: function(element_id, height){
                    return CKEDITOR.replace(element_id, {
                        filebrowserUploadUrl: '{{route('ckeditor.upload', ['_token' => csrf_token()])}}',
                        filebrowserUploadMethod: 'form',
                        height,
                        extraPlugins: 'colorbutton',
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
