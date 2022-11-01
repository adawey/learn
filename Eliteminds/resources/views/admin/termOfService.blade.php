



@extends('layouts.app-1')

@section('pageTitle') Term Of Service @endsection
@section('subheaderTitle') Term Of Service @endsection
@section('subheaderNav')
    <!--begin::Button-->
    <a href="#" onclick="document.getElementById('termForm').submit()" class="btn btn-fh btn-white btn-hover-primary font-weight-bold px-2 px-lg-5 mr-2">
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

@endsection

@section('content')
    <div class="card card-custom">

        <form action="{{route('admin.terms.store')}}" method="POST" class="form-horizontal" id="termForm">
            @csrf
            <div class="card-body">
                <div class="card-header">
                    <h3>Edit Term Of Service</h3>
                </div>

                <div class="form-group-lg py-5 row">
                    <div class="col-md-12">
                        <textarea class="form-control" maxlength="250" rows="2" name="terms" id="kt-ckeditor-1">{!! \App\PaypalConfig::all()->first()->term_of_service !!}</textarea>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="card-header">
                    <h3>Refund polices</h3>
                </div>

                <div class="form-group-lg py-5 row">
                    <div class="col-md-12">
                        <textarea class="form-control" maxlength="250" rows="2" name="refund" id="kt-ckeditor-2">{!! \App\PaypalConfig::all()->first()->Refund_polices !!}</textarea>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="card-header">
                    <h3>Privacy & Policy</h3>
                </div>

                <div class="form-group-lg py-5 row">
                    <div class="col-md-12">
                        <textarea class="form-control" maxlength="250" rows="2" name="policy" id="kt-ckeditor-3">{!! \App\PaypalConfig::all()->first()->Privacy_Policy !!}</textarea>
                    </div>
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


