@extends('layouts.app-1')

@section('pageTitle') Add Package @endsection
@section('subheaderTitle') Add Package @endsection
@section('subheaderNav')
    <!--begin::Button-->
    <a href="#" onclick="document.getElementById('packageForm').submit()" class="btn btn-fh btn-white btn-hover-primary font-weight-bold px-2 px-lg-5 mr-2">
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
    <a href="#" onclick="AVUtil().redirectionConfirmation('{{route('packages.index')}}')" class="btn btn-fh btn-white btn-hover-primary font-weight-bold px-2 px-lg-5 mr-2">
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
    <div class="card card-custom" id="app1">
        <!--begin::Form-->
        <form method="POST" id="packageForm" action="{{route('packages.store')}}" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="form-group  row mb-0 ">
                    <label class="col-2 col-form-label" for="example-text-input">Package Name</label>
                    <div class="col-10">
                        <input class="form-control" type="text" name="name" placeholder="Package Name" id="example-text-input" value="{{old('name')}}"/>
                    </div>
                </div>
                <div class="form-group  row mb-0">
                    <div class="col-3 form-group mb-0">
                        <strong>
                            <label class=" col-form-label" for="example-text-input3">Expire in (days)</label>
                            <input class="form-control" type="number" name="expire" min="1" step="1" placeholder="Expire in days"
                                   id="example-text-input3" value="{{old('expire')}}"/>
                        </strong>
                    </div>
                    <div class="col-3 form-group mb-0" style="">
                        <strong>
                            <label class=" col-form-label" for="example-text-input4">Extend for (days)</label>
                            <input class="form-control" type="number" name="extension_in_days" value="0" placeholder="Extend for (days) "
                                   id="example-text-input4" value="{{old('extension_in_days')}}"/>
                        </strong>
                    </div>
                    <div class="col-3 form-group mb-0" style="">
                        <strong>
                            <label class=" col-form-label" for="example-text-input5">Max Extension (days) </label>
                            <input class="form-control" type="text" value="0" name="max_extension" placeholder="Max Extension (days) "
                                   id="example-text-input5" value="{{old('max_extension')}}"/>
                        </strong>
                    </div>
                    <div class="col-3 form-group mb-0" style="">
                        <strong>
                            <label class=" col-form-label" for="example-text-input6">Extension Price ($)</label>
                            <input class="form-control" type="text" value="0" name="extension_price" placeholder="Extension Price "
                                   id="example-text-input6" value="{{old('extension_price')}}"/>
                        </strong>
                    </div>
                </div>
                <div class="form-group row mb-0">

                    <div class="col-6 form-group mb-0">
                        <label class="col-md-3 col-form-label" for="contant_type">Content Type</label>
                        <select class="form-control" name="contant_type" id="contant_type" >
                            <option value=""  {{old('contant_type') == '' ? 'selected': ''}}>Choose</option>
                            <option value="question" {{old('contant_type') == 'question' ? 'selected': ''}}>Questions</option>
                            <option value="video" {{old('contant_type') == 'video' ? 'selected': ''}}>Videos</option>
                            <option value="combined" {{old('contant_type') == 'combined' ? 'selected': ''}}>Both</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <div class="col-6 form-group mb-0">
                        <label class="col-md-3 col-form-label" for="course_id">Course </label>
                        <select class="form-control" name="course_id" id="course_id" v-model="course_id" v-on:change="getChapters">
                            <option value="" {{old('course_id') == '' ? 'selected': ''}}>Choose</option>
                            @foreach(\App\Course::all() as $c)
                                <option value="{{$c->id}}" {{old('course_id') == $c->id ? 'selected': ''}}>{{$c->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 form-group mb-0">
                        <label class="col-3 col-form-label" for="lang">Course Language</label>
                        <select class="form-control" name="lang" id="lang">
                            <option value="" {{old('lang') == '' ? 'selected': ''}}>Choose one</option>
                            <option value="English" {{old('lang') == 'English' ? 'selected': ''}}>English</option>
                            <option value="Arabic" {{old('lang') == 'Arabic' ? 'selected': ''}}>Arabic</option>
                            <option value="Arabic & English" {{old('lang') == 'Arabic & English' ? 'selected': ''}}>Arabic & English</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <div class="col-5 form-group mb-0">
                        <label class="col-md-3 col-form-label" for="certification">Certification </label>
                        <select class="form-control" name="certification" id="certification">
                            <option value="1" {{old('certification') == '1' ? 'selected': ''}}>True</option>
                            <option value="0" {{old('certification') == '0' ? 'selected': ''}}>False</option>
                        </select>
                    </div>
                    <div class="col-4 form-group mb-0">
                        <strong>
                            <label class=" col-form-label" for="certification_title">Certification Title (optional) </label>
                            <input class="form-control" type="text" placeholder="Certification Title "
                                   name="certification_title" id="certification_title" value="{{old('certification_title')}}"/>
                        </strong>
                    </div>
                    <div class="col-3 form-group mb-0">
                        <strong>
                            <label class=" col-form-label" for="course_hours">Course Hours</label>
                            <input class="form-control" type="text" placeholder="Certification Title "
                                   name="course_hours" id="course_hours"  value="{{old('course_hours')}}"/>
                        </strong>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <div class="col-6 form-group mb-0">
                        <strong>
                            <label class=" col-form-label">Package Image (large) : </label>
                        </strong>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="img_large" id="img">
                            <label class="custom-file-label" for="img">Choose file</label>
                        </div>
                    </div>
                    <div class="col-6 form-group mb-0">
                        <strong>
                            <label class=" col-form-label">Package Image (medium) : </label>
                        </strong>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="img" id="img_medium">
                            <label class="custom-file-label" for="img_medium">Choose file</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-10">
                    <div class="col-6 form-group mb-10">
                        <strong>
                            <label class=" col-form-label">Package Image (small): </label>
                        </strong>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input"  name="img_small" id="img_small">
                            <label class="custom-file-label" for="img_small">Choose file</label>
                        </div>
                    </div>
                    <div class="col-6 form-group mb-10">
                        <strong>
                            <label class=" col-form-label">Package Preview Video (optional): </label>
                        </strong>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="preview_video" id="preview_video">
                            <label class="custom-file-label" for="preview_video">Choose file</label>
                        </div>
                    </div>
                </div>

                <div class="card card-custom mb-5">
                    <div class="card-header">
                        <h3 class="card-title">
                            Pricing
                        </h3>
                    </div>
                    <div class="card-body">
                        @foreach(\App\Zone::all() as $zone)
                            <div class="form-group  row mb-0">
                                <div class="col-6 form-group mb-0">
                                    <strong>
                                        <label class=" col-form-label" for="example-text-input1"><b>{{$zone->name}}</b> Price</label>
                                        <input class="form-control" type="text" name="price_zone_{{$zone->id}}" value="{{old('price_zone_'.$zone->id)}}" placeholder="Price before the discount"
                                               id="example-text-input1"/>
                                    </strong>
                                </div>
                                <div class="col-6 form-group mb-0">
                                    <strong>
                                        <label class=" col-form-label" for="example-text-input2"><b>{{$zone->name}}</b> Discount (%) </label>
                                        <input class="form-control" type="text" name="discount_zone_{{$zone->id}}" value="{{old('discount_zone_'.$zone->id)}}" placeholder="discount percentage : "
                                               id="example-text-input2"/>
                                    </strong>
                                </div>
                            </div>
                        @endforeach
                        <div class="form-group  row mb-0">
                            <div class="col-6 form-group mb-0">
                                <strong>
                                    <label class=" col-form-label" for="example-text-input1"><b>Default</b> Price</label>
                                    <input class="form-control" type="text" name="price" placeholder="Price before the discount"
                                           id="example-text-input1" value="{{old('price')}}"/>
                                </strong>
                            </div>
                            <div class="col-6 form-group mb-0">
                                <strong>
                                    <label class=" col-form-label" for="example-text-input2"><b>Default</b> Discount (%) </label>
                                    <input class="form-control" type="text" name="discount" placeholder="discount percentage : "
                                           id="example-text-input2" value="{{old('discount')}}"/>
                                </strong>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-custom mb-5">
                    <div class="card-header">
                        <h3 class="card-title">
                            Description:
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <textarea name="description" id="kt-ckeditor-1" placeholder="English">
                                    {!! old('description') !!}
                                </textarea>
                            </div>
                        </div>



                    </div>
                </div>
                <div class="card card-custom  mb-5">
                    <div class="card-header">
                        <h3 class="card-title">
                            What you'll learn:
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <textarea name="what_you_learn" id="kt-ckeditor-2">
                                    {!! old('what_you_learn') !!}
                                </textarea>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="card card-custom  mb-5">
                    <div class="card-header">
                        <h3 class="card-title">
                            Requirement :
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <textarea name="requirement" id="kt-ckeditor-3">
                                    {!! old('requirement') !!}
                                </textarea>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="card card-custom  mb-5">
                    <div class="card-header">
                        <h3 class="card-title">
                            Who this course is for :
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <textarea name="who_course_for" id="kt-ckeditor-4">
                                    {!! old('who_course_for') !!}
                                </textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-custom  mb-5">
                    <div class="card-header">
                        <h3 class="card-title">
                            Enroll Confirmation Email :
                        </h3>
                    </div>
                    <div class="card-body">
                        <textarea name="enroll_msg" id="kt-ckeditor-5">
                            {!! old('enroll_msg') !!}
                        </textarea>
                    </div>
                </div>
                <div class="card card-custom  mb-5">
                    <div class="card-header">
                        <h3 class="card-title">
                            The Package includes :
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-3 col-form-label">Exams</label>
                            <div class="col-3">
                            <span class="switch">
                                <label>
                                    <input type="checkbox" id="exam" name="exam" v-model="exam"/>
                                    <span></span>
                                </label>
                            </span>
                            </div>
                            <label class="col-3 col-form-label">Chapters</label>
                            <div class="col-3">
                                <span class="switch">
                                    <label>
                                        <input type="checkbox" v-model='chapter' id="chapter" name="chapter"/>
                                        <span></span>
                                    </label>
                                </span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group exam_view col-lg-4" style="display:none;" >
                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Exams</label>
                                    <div class=" col-10">
                                        <select class="form-control select2" id="kt_select2_3" name="exams[]" multiple="multiple" style="width: 100%;">
                                            <optgroup>
                                                @foreach(\App\Exam::all() as $exam)
                                                    <option value="{{$exam->id}}">{{$exam->name}}</option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group chapter_view" style="display:none;">
                                <strong>{{Form::label('chapter','Chapters :')}}</strong>
                                <ul class="list-group">
                                    <li class="list-group-item" v-for="i in chapter_data">
                                        <input type="checkbox" :name="'c'+i.id" :id="'c'+i.id" :value="i.name">
                                        <label :for="'c'+i.id">@{{ i.name }}</label>
                                    </li>
                                </ul>

                            </div>
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
                        <a onclick="AVUtil().redirectionConfirmation('{{route('packages.index')}}')" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection


@section('jscode')

    <script src="{{asset('assets/js/pages/crud/forms/widgets/select2.js?v=7.0.4')}}"></script>
    <script src="{{asset('assets/plugins/custom/ckeditor/ckeditor-classic.bundle.js?v=7.0.4')}}"></script>
    <script src="{{asset('assets/js/pages/crud/forms/editors/ckeditor-classic.js?v=7.0.4')}}"></script>

    <script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>
    <script>
        var app = new Vue({
            el: '#app1',
            data:{
                course_id: '{{old('course_id')}}',
                chapter: false,
                exam: false,
                chapter_data: [],
                filter: ''
            },
            mounted(){
                if(this.course_id){
                    this.getChapters();
                }
            },
            methods: {
                getChapters:async function(){
                    this.chapter_data = await this.fetchLibrary(this.course_id, 'chapter');
                    $(".chapter").removeAttr('disabled');
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
                choose: function(){
                    if(this.chapter == true){
                        if(this.filter == 'chapter'){
                            $('.chapter_view').show();
                            $('.process_view').hide();
                        }else if (this.filter == 'process'){
                            $('.chapter_view').hide();
                            $('.process_view').show();
                        }else{
                            $('.chapter_view').show();
                            $('.process_view').show();
                        }
                    }
                }
            },
            watch: {
                chapter: function(){
                    if(this.chapter == true){
                        if(this.filter == 'chapter'){
                            $('.chapter_view').show();
                            $('.process_view').hide();
                        }else if (this.filter == 'process'){
                            $('.chapter_view').hide();
                            $('.process_view').show();
                        }else{
                            $('.chapter_view').show();
                            $('.process_view').show();
                        }

                    }else{
                        $('.chapter_view').hide();
                        $('.process_view').hide();
                    }
                },
                exam:function(){
                    if(this.exam == true){
                        $(".exam_view").show();
                    }else{
                        $(".exam_view").hide();
                    }
                }
            }
        });

    </script>
@endsection
