@extends('layouts.app-1')

@section('pageTitle') Promotion @endsection
@section('header')

@endsection
@section('subheaderNav')

    <!--begin::Button-->
    <a href="{{route('showAllUsers')}}" class="btn btn-fh btn-white btn-hover-primary font-weight-bold px-2 px-lg-5 mr-2">
    <span class="svg-icon svg-icon-success svg-icon-lg">
        <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Add-user.svg-->
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <polygon points="0 0 24 0 24 24 0 24"/>
                <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero"/>
            </g>
        </svg>
        <!--end::Svg Icon-->
    </span>All Users</a>
    <!--end::Button-->
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PORTLET-->
            <div class="card card-custom">
                <div class="card-header">
                    <div class="card-title">
                    <span class="card-icon">
                        <i class="icon-2x  text-primary flaticon2-bell  "></i>
                    </span>
                        <h3 class="card-label">Promotion</h3>
                    </div>
                </div>
                <div class="card-body">



                    <form class="form-horizontal form-bordered" method="POST" action="{{route('promotion.send')}}">
                        @csrf

                        <div class="form-body">
                            <div class="form-group last">
                                <label class="control-label col-md-2">Send To All Users</label>
                                <div class="col-md-10">
                                    <span class="switch switch-icon">
                                        <label><input type="checkbox" name="all_users"> <span></span></label>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-body">
                            <div class="form-group last">
                                <label class="control-label col-md-2">Package</label>
                                <div class="col-md-10">
                                    <select name="package_id" id="package" class="form-control">
                                        <option value="" selected disabled>--</option>
                                        @foreach(\App\Packages::orderBy('created_at', 'desc')->get() as $package)
                                            <option value="{{$package->id}}">{{$package->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-body">
                            <div class="form-group last">
                                <label class="control-label col-md-2">Mail Subject</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="subject" />
                                </div>
                            </div>
                        </div>
                        <div class="form-body">
                            <div class="form-group last">
                                <label class="control-label col-md-2">Massage</label>
                                <div class="col-md-10">
                                    <textarea name="msg" id="kt-ckeditor-11" style="width: 100%; height:120;" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="offset-md-10 col-md-2">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fa fa-check"></i> Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>


            </div>
            <!-- END PORTLET-->
        </div>
    </div>

@endsection

@section('jscode')
    <script src="{{asset('assets/plugins/custom/ckeditor/ckeditor-classic.bundle.js?v=7.0.4')}}"></script>
    <!--<script src="{{asset('assets/js/pages/crud/forms/editors/ckeditor-classic.js?v=7.0.4')}}"></script>-->
    <script>
        "use strict";
        // Class definition
        
        var KTCkeditor = function () {    
            // Private functions
            var demos = function () {
                ClassicEditor
        			.create( document.querySelector( '#kt-ckeditor-1' ) )
        			.then( editor => {
        				console.log( editor );
        			} )
        			.catch( error => {
        				// console.error( error );
        			} );
            }
        
            return {
                // public functions
                init: function() {
                    demos(); 
                }
            };
        }();
        
        // Initialization
        jQuery(document).ready(function() {
            KTCkeditor.init();
        });

    </script>
@endsection
