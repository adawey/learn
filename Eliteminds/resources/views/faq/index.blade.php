@extends('layouts.layoutV2')

@section('content')
    <div class="container">
        <!-- Title Start -->
        <div class="page-title-container">
            <div class="row">
                <div class="col-12 col-md-7">
                    <h1 class="mb-0 pb-0 display-4" id="title">FAQ</h1>
                    <nav class="breadcrumb-container d-inline-block" aria-label="breadcrumb">
                        <ul class="breadcrumb pt-0">
                            <li class="breadcrumb-item"><a href="{{route('user.dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="javascript:;">FAQ</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Title End -->

        <div class="row">
            <!-- Left Side Start -->
            <div class="col-12 col-xl-12 col-xxl-12 mb-5">
                <div id="accordionCards">
                    <div class="mb-n2">
                        @foreach(\App\FAQ::orderBy('created_at', 'desc')->get() as $q)

                            @php
                                $faq = Transcode::evaluate($q);
                            @endphp
                            <div class="card d-flex mb-2">
                                <div class="d-flex flex-grow-1 collapsed" role="button" data-bs-toggle="collapse" data-bs-target="#collapseOneCards-{{$q->id}}" aria-expanded="false" aria-controls="collapseOneCards-{{$q->id}}">
                                    <div class="card-body py-4">
                                        <div class="btn btn-link list-item-heading p-0">{{$faq['title']}}</div>
                                    </div>
                                </div>
                                <div id="collapseOneCards-{{$q->id}}" class="collapse" data-bs-parent="#accordionCards" style="">
                                    <div class="card-body accordion-content pt-0">
                                        <p class="m-0">
                                            {!! $faq['contant'] !!}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach


                    </div>
                </div>
            </div>
            <!-- Left Side End -->

        </div>
    </div>

@endsection

@section('jscode')
@endsection
