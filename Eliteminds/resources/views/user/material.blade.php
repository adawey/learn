@extends('layouts.layoutV2')

@section('content')
    <h3> {{\App\Course::find($course_id)->title}} </h3>
    <div class="fluid-container my-5">
        <div class="row">
            @if(\App\Material::where('course_id', '=', $course_id)->get()->first())
                @foreach(\App\Material::where('course_id', '=', $course_id)->get() as $m)
                    <div class="col-md-2 mb-5">
                        <div class="card sh-45 hover-img-scale-up" style="max-height: 200px;">
                            <img src="{{asset('storage/material/'.basename($m->cover_url))}}" class="card-img h-100 scale" alt="card image">
                            <div class="card-img-overlay d-flex flex-column justify-content-between">
                                <div>
                                    <a href="{{route('download.material', $m->id)}}" class="heading text-white stretched-link">{{$m->title}}</a>

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

@endsection
