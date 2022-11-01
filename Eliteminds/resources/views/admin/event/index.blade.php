@extends('layouts.app-1')
@section('pageTitle') Events @endsection

@section('subheaderTitle') Events @endsection
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card card-custom">
                <div class="card-header">
                    <div class="card-title">
                    <span class="card-icon">
                    </span>
                        <h3 class="card-label">All Online Interactive Courses</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-container">
                        <table class="table table-bordered table-hover table-checkable" id="kt_datatable1" >
                            <thead>
                            <tr>
                                <td>Title</td>
                                <td>Start At</td>
                                <td>End At</td>
                                <td>Course</td>
                                <td>Action</td>
                            </tr>
                            </thead>

                            <tbody>

                            @if(count(\App\Event::all()) > 0)
                                @foreach(\App\Event::all() as $event)
                                    <tr>
                                        <td>{{$event->name}}</td>
                                        <td>{{$event->start}}</td>
                                        <td>{{$event->end}}</td>
                                        <td>{{\App\Course::find($event->course_id)->title}}</td>
                                        <td>
                                            <a href="{{route('event.edit', $event->id)}}">Edit</a> |
                                            <!--<a href="javascript:;" onclick="AVUtil().deleteConfirmation('{{route('event.delete', $event->id)}}', deleteCallback)" >Delete</a>-->
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <p>No Content !</p>
                            @endif


                            </tbody>

                        </table>

                        <div class="modal fade" id="myModal" role="dialog">
                            <div class="modal-dialog">
                                <div id="content-data"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End: life time stats -->
    </div>

@endsection
@section('jscode')
    <script src="{{asset('assets/js/pages/crud/datatables/extensions/buttons.js?v=7.0.4')}}"></script>
    <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.4')}}"></script>
    <script>
        function deleteCallback(url){
            $.ajax({
                type: 'GET',
                url,
                success: function(res){
                    console.log(res);
                }
                
            });
        }
    </script>
@endsection
