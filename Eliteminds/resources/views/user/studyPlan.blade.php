@extends('layouts.layoutV2')

@section('head')
    <link rel="stylesheet" type="text/css" href="{{asset('assetsV2/syntax-highlighter/styles/shCore.css')}}" media="all">
    <link rel="stylesheet" type="text/css" href="{{asset('assetsV2/syntax-highlighter/styles/shCoreMidnight.css')}}" media="all">
    <style>
        .gutter,
        .toolbar {
            display: none
        }

        .syntaxhighlighter {
            padding: 15px 20px;
        }

        .syntaxhighlighter {
            margin-top: 0 !important;
            margin-bottom: 0 !important;
            padding: 0 !important;
            padding-top: 18px !important;
        }
    </style>
@endsection
@section('content')
    <div class="uk-grid-collapse" uk-grid>
        <div class=" bg-white" style="width: 100%;">

            <ul id="video-slider" class="uk-switcher">
                @if(count($plans))
                    @php $index = 0; @endphp
                    @foreach($plans as $plan)
                        <li @if($index == 0) class="uk-active" @endif>
                            <!-- to autoplay video uk-video="automute: true" -->
                            <h1 style="padding: 5px 0 10px 20px;">{{$plan->title}}</h1>
                            <div class="embed-video">
                                <video oncontextmenu="return false;" width="100%" height="380" controls controlsList="nodownload">
                                    <source src="{{url('storage/studyPlan/'.basename($plan->video_url) )}}" type="video/mp4">
                                </video>
                            </div>
                            <div class="container mx-auto" style=" padding: 20px 0 30px 0;">
                                {{$plan->description}}
                            </div>

                        </li>
                        @php $index++; @endphp
                    @endforeach
                @endif

            </ul>

        </div>
    </div>


@endsection

@section('jscode')
    <script type="text/javascript" src="{{asset('assetsV2/syntax-highlighter/scripts/shCore.js')}}"></script>
    <script type="text/javascript" src="{{asset('assetsV2/syntax-highlighter/scripts/shBrushJScript.js')}}"></script>
    <script type="text/javascript" src="{{asset('assetsV2/syntax-highlighter/scripts/shBrushXml.js')}}"></script>
    <script type="text/javascript">
        SyntaxHighlighter.all()
    </script>
@endsection
