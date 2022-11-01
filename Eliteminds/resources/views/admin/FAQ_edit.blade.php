


@extends('layouts.app-1')

@section('pageTitle') Edit FAQ @endsection
@section('subheaderTitle') FAQs @endsection
@section('subheaderNav')
    <!--begin::Button-->
    <a href="#" onclick="document.getElementById('faqForm').submit()" class="btn btn-fh btn-white btn-hover-primary font-weight-bold px-2 px-lg-5 mr-2">
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
    <a href="#" onclick="AVUtil().redirectionConfirmation('{{route('faq.show.admin')}}')" class="btn btn-fh btn-white btn-hover-primary font-weight-bold px-2 px-lg-5 mr-2">
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
    </span>Back</a>
    <!--end::Button-->
@endsection

@section('content')
    <div class="card card-custom">

        <form class="form-horizontal form-bordered" method="POST" action="{{route('faq.update', $q->id)}}" id="faqForm">
            @csrf
            <div class="card-body">
                <div class="card-header">
                    <h3>Edit FAQ</h3>
                </div>
                <div class="form-group-lg py-5 row">
                    <label class="col-md-2 col-form-label">Title</label>
                    <div class="col-md-10 my-2">
                        <input class="form-control" type="text" placeholder="Title" value="{{$q->title}}" name="title"/>
                    </div>
                    <!--<label class="col-md-2 col-form-label"> </label>-->
                    <!--<div class="col-md-10 my-2">-->
                    <!--    <input class="form-control" type="text" placeholder="Title" value="{{Transcode::evaluate($q,'ar', true)['title']}}" name="title_ar"/>-->
                    <!--</div>-->
                    <!--<label class="col-md-2 col-form-label"> </label>-->
                    <!--<div class="col-md-10 my-2">-->
                    <!--    <input class="form-control" type="text" placeholder="French" name="title_fr" value="{{Transcode::evaluate($q,'fr', true)['title']}}"/>-->
                    <!--</div>-->
                </div>
                <div class="form-group-lg py-5 row">
                    <label class="col-md-2 col-form-label">Description</label>
                    <div class="col-md-10 my-2">
                        <textarea id="kt-ckeditor-1" class="form-control" rows="2" name="content" placeholder="English">
                            {!! $q->contant!!}
                        </textarea>
                    </div>
                    <!--<label class="col-md-2 col-form-label"> </label>-->
                    <!--<div class="col-md-10 my-2">-->
                    <!--    <textarea id="kt-ckeditor-2" class="form-control" rows="2" name="content_ar" placeholder="عربي">-->
                    <!--        {!!Transcode::evaluate($q,'ar', true)['contant']!!}-->
                    <!--    </textarea>-->
                    <!--</div>-->
                    <!--<label class="col-md-2 col-form-label"> </label>-->
                    <!--<div class="col-md-10 my-2">-->
                    <!--    <textarea id="kt-ckeditor-3" class="form-control" rows="2" name="content_fr" placeholder="French">-->
                    <!--        {!!Transcode::evaluate($q,'fr', true)['contant']!!}-->
                    <!--    </textarea>-->
                    <!--</div>-->
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-2">
                    </div>
                    <div class="col-10">
                        <button type="submit" class="btn btn-success mr-2">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection

@section('jscode')
    <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
    <script src="{{asset('assets/js/pages/crud/datatables/data-sources/html.js')}}"></script>

    <script src="{{asset('assets/plugins/custom/ckeditor/ckeditor-classic.bundle.js?v=7.0.4')}}"></script>
    <script src="{{asset('assets/js/pages/crud/forms/editors/ckeditor-classic.js?v=7.0.4')}}"></script>
@endsection



