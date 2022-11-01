@extends('layouts.layoutV2')

@section('content')

    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
                <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN SAMPLE TABLE PORTLET-->
                            <div class="portlet light bordered">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-doc font-green"></i>
                                        <span class="caption-subject font-green bold uppercase">Flash Cards</span>
                                    </div>
                                    
                                </div>
                                <div class="portlet-body">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                             @foreach(\App\FlashCard::orderBy('created_at', 'desc')->get() as $f)
                                            <h4 class="panel-title" style="color: blue">
                                                <a class="accordion-toggle"  href="{{route('flashCard.show', $f->id)}}" style="font-size: 20px">{{$f->title}}  </a>
                                            </h4>
                                             @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END SAMPLE TABLE PORTLET-->
                        </div>
                    </div>
            
        </div>
    </div>

@endsection
@section('jscode')


@endsection
