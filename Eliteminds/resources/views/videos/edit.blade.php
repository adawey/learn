@extends('layouts.app-1')
@section('pageTitle') Edit Video @endsection
@section('subheaderTitle') Edit Video @endsection
@section('subheaderNav')
    <!--begin::Button-->
    <a href="#" onclick="app.submit()" class="btn btn-fh btn-white btn-hover-primary font-weight-bold px-2 px-lg-5 mr-2">
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
    <a href="#" onclick="AVUtil().redirectionConfirmation('{{route('video.index')}}')" class="btn btn-fh btn-white btn-hover-primary font-weight-bold px-2 px-lg-5 mr-2">
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
        <p class="details" style="display:none;"></p>
        <div class="progress" style="display:none">
            <div class="progress-bar progress-bar-striped" id="progress_bar" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">60%</div>
        </div>

        <div class="note note-danger" style="display:none;">
            <p id="note_text" style="font-size: 15px; font-weight: bold; color: crimson;"></p>

        </div>

        <form class="vueform">
            <div class="card-body">

                <div class="form-group-lg py-5 my-1 row border-1 border-light-success" style="border-style: solid; border-radius: 3px;">
                    <label class="col-2 col-form-label py-1">Video Title</label>
                    <div class="col-10 py-1">
                        <input class="form-control" type="text" placeholder="Title" name="title" v-model="title"/>
                    </div>
                    <label class="col-2 col-form-label py-1">Description</label>
                    <div class="col-10 py-1">
                        <textarea class="form-control" placeholder="Description" rows="5" name="description" v-model="description"></textarea>
                    </div>
                </div>
                


                <div class="form-group row">
                    <label class="col-2 col-form-label" for="exampleSelectd1">Course</label>
                    <div class="col-10">
                        <select class="form-control" name="course" v-on:change="searchCourse" v-model="course" id="exampleSelectd1">
                            <option> Choose one</option>
                            @foreach($course_select as $k => $v)
                                <option value="{{$k}}"> {{$v}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-2 col-form-label" for="exampleSelectd2">Chapter</label>
                    <div class="col-10">
                        <select class="form-control" id="exampleSelectd2" v-model="chapter" name="chapter">
                            <option disabled value="">Choose one </option>
                            <option v-for="i in chapter_data" :value="i.id">@{{i.name}}</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-2 col-form-label" for="exampleSelectd3">Event</label>
                    <div class="col-10">
                        <select class="form-control" id="exampleSelectd3" v-model="event_id" name = "event_id">
                            <option disabled value="" selected>--</option>
                            @foreach(\App\Event::all() as $event)
                                <option value="{{$event->id}}">{{$event->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group-lg py-5 row">
                    <label class="col-2 col-form-label">Video Vimeo ID </label>
                    <div class="col-10">
                        <input class="form-control" type="text" placeholder="vimeo_id" name="vimeo_id" v-model="vimeo_id"/>
                    </div>
                </div>

                <div class="form-group-lg py-5 row">
                    <label class="col-2 col-form-label">Video WhiteReflect ID </label>
                    <div class="col-10">
                        <input class="form-control" type="text" placeholder="WhiteReflect ID" name="wr_id" v-model="wr_id"/>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-2 col-form-label">Attachment File :</label>
                    <div></div>
                    <div class="col-10">
                        <select v-model="material_id" name="attachment" id="attachment" class="form-control">
                            <option value="0" selected>none</option>
                            @foreach(\App\Material::orderBy('created_at', 'desc')->get() as $m)
                                <option value="{{$m->id}}">{{$m->title}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!-- <div class="form-group-lg  row">
                 <label  class="col-2 col-form-label">Vimeo ID </label>
                 <div class="col-10">
                  <input class="form-control" type="text" placeholder="Vimeo ID" id="example-text-input"/>
                 </div>
                </div> -->

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
                    <label class="col-2 col-form-label">Show After Chapters' Quiz</label>
                    <div class="col-10">
                        <span class="switch switch-icon">
                         <label>
                          <input type="checkbox" name="after_chapter_quiz" v-model="after_chapter_quiz"/>
                          <span></span>
                         </label>
                        </span>
                    </div>
                </div>

            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-2">
                    </div>
                    <div class="col-10">
                        <button v-on:click.prevent="submit" class="btn btn-success mr-2">Submit</button>
                        <a onclick="AVUtil().redirectionConfirmation('{{route('video.index')}}')" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('jscode')

    <script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>
    <script>

        var app = new Vue({
            el: '.vueform',
            data:{
                test:'',
                course:'{{$course_id}}',

                chapter:'{{$video->chapter}}',         // ###

                title: '',          // ###
                description: '',     // ###
                title_ar: '',          // ###
                description_ar: '',     // ###
                title_fr: '',          // ###
                description_fr: '',     // ###

                chapter_data: [],
                material_id: @if($video->attachment_url != null) {{\App\Material::where('file_url','=',$video->attachment_url)->get()->first()->id}} @else 0 @endif,
                demo: {{$video->demo}},
                duration: '{{$video->duration}}',
                vimeo_id: '{{$video->vimeo_id}}',
                wr_id: '{{$video->wr_id}}',
                event_id: '',
                after_chapter_quiz: {{$video->after_chapter_quiz}},


                //
            },
            mounted(){
                this.getChapters();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    }
                });

                $.ajax ({
                    type: 'POST',
                    url: '{{ route('render.video.data')}}',
                    data: {
                        video_id: {{$video->id}}
                    },
                    success: function(res){
                        app.title = res['title'];
                        app.description = res['description'];
                        app.title_ar = res['title_ar'];
                        app.description_ar = res['description_ar'];
                        app.title_fr = res['title_fr'];
                        app.description_fr = res['description_fr'];

                    },
                    error: function(res){
                        console.log('Error:', res);
                    }
                });


            },
            methods:{
                getChapters:async function(){
                    this.chapter_data = await this.fetchLibrary(this.course, 'chapter');
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
                searchCourse: function(e){
                    this.process_group_data = [];
                    this.pmg_data = [];
                    $("#pmg").attr('disabled','disabled');
                    Data = {
                        id : this.course
                    };


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
                _: function(el){
                    return document.getElementById(el);
                },
                submit: function(){

                    error = 0;

                    var video = null;
                    // var video = this._("video").files[0];
                    // var attachment = this._("attachment").files[0];

                    if(video){
                        if(video.type != 'video/mp4'){
                            $('.note').show();
                            this._('note_text').innerHTML = 'Only accept `MP4` Format !';
                            error =1;
                        }
                    }

                    if(!video && this.vimeo_id == '' && this.wr_id == ''){
                        $('.note').show();
                        this._('note_text').innerHTML = 'Video file, Vimeo ID or WhiteReflect ID is required';
                        error =1;
                    }







                    if(this.chapter == ''){
                        $('.note').show();
                        this._('note_text').innerHTML = 'Chapter is required !';
                        error =1;
                    }

                    if(this.description == ''){
                        $('.note').show();
                        this._('note_text').innerHTML = 'Description is required !';
                        error =1;
                    }

                    if(this.title == ''){
                        $('.note').show();
                        this._('note_text').innerHTML = 'Title is required !';
                        error =1;
                    }

                    // if(this.duration == ''){
                    //     $('.note').show();
                    //     this._('note_text').innerHTML = 'Duration is required !';
                    //     error =1;
                    // }





                    if(!error){
                        $(".note").hide();
                        $(".progress").show();
                        $('.vueform').hide();
                        $('.details').show();
                        if(video){
                            $('.details').html('Title: '+this.title+'</br>Size: '+Math.round(video.size/1000000)+' MB');
                        }else{
                            $('.details').html('Title: '+this.title+'</br>');
                        }



                        // alert(file.name+"|"+file.size/1000+"KB|"+file.type);

                        var formdata = new FormData();

                        formdata.append('_token', '{{ csrf_token() }}');
                        formdata.append('title', this.title);
                        formdata.append('description', this.description);
                        formdata.append('title_ar', this.title_ar);
                        formdata.append('description_ar', this.description_ar);
                        formdata.append('title_fr', this.title_fr);
                        formdata.append('description_fr', this.description_fr);
                        formdata.append('chapter', this.chapter);
                        formdata.append('attachment', this.material_id);
                        formdata.append('demo', this.demo);
                        formdata.append('course_id', this.course);
                        formdata.append('vimeo_id', this.vimeo_id);
                        formdata.append('wr_id', this.wr_id);
                        formdata.append('material_id', this.material_id);
                        formdata.append('event_id', this.event_id);
                        formdata.append('after_chapter_quiz', this.after_chapter_quiz);

                        var ajax = new XMLHttpRequest();
                        ajax.upload.addEventListener("progress", this.progressHandler, false); // progress handler
                        ajax.addEventListener('load', this.completeHandler, false); // complete event
                        ajax.addEventListener('error', this.errorHandler, false);
                        ajax.addEventListener('abort', this.abortHandler, false);

                        ajax.open("POST" ,"{{ route('video.update', $video->id) }}");
                        ajax.send(formdata);
                    }
                },
                progressHandler: function(event){
                    // this._('progress_bar').innerHTML = "Uploaded "+event.loaded+" bytes of "+event.total;
                    var percent = (event.loaded / event.total) * 100;
                    // this._('progressBar').value = Math.round(percent);
                    $('.progress-bar').attr('aria-valuenow', percent);
                    $('.progress-bar').attr('style', 'width: '+percent+'%');
                    this._('progress_bar').innerHTML = percent.toString().substr(0,5)+' %';

                },
                completeHandler: function(event){
                    if(event.target.responseText == 'ok'){
                        window.location.href = "{{ route('video.index') }}";
                    }else{
                        console.log(JSON.parse(event.target.responseText));
                        $('.progress').hide();
                        $('.vueform').show();
                        this._('note_text').innerHTML = event.target.responseText;
                        $('.note').show();
                    }
                },
                errorHandler: function(){
                    alert('error ! contact to customer services');
                },
                abortHandler: function(){
                    alert('error !');
                }

            }
        });
    </script>
@endsection
