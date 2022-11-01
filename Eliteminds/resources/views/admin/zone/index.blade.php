
@extends('layouts.app-1')
@section('pageTitle') Zones @endsection
@section('subheaderTitle') Zones @endsection

@section('content')

    <div class="row" style="background-color: white; padding: 0 0;">
        <div class="col-md-12">
            <div class="card card-custom">

                <div class="card-body">
                    <table class="table table-bordered table-hover table-checkable" id="kt_datatable1" style="margin-top: 13px !important">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Created At</th>
                            <th>Action</th>

                        </tr>
                        </thead>
                        <tbody>
                        @if(count($zones))
                            @foreach($zones as $zone)
                                <tr>
                                    <td>{{ $zone->id }}</td>
                                    <td>{{ $zone->name }}</td>
                                    <td>{{ $zone->created_at }}</td>
                                    <td>
                                        <a href="{{route('zone.edit', $zone->id)}}">Edit</a>
                                        <a href="javascript:;" onclick="AVUtil().deleteConfirmation('{{route('zone.destroy', $zone->id)}}', deleteZone)">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <p>noting to show !</p>

                        @endif
                        </tbody>
                    </table>


                </div>
            </div>
        </div>
    </div>

@endsection


@section('jscode')
    <script src="{{asset('assets/js/pages/crud/datatables/extensions/buttons.js?v=7.0.4')}}"></script>
    <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.4')}}"></script>
    <script>
        function deleteZone(url){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                }
            });

            $.ajax ({
                type: 'POST',
                data: {'_method' : 'DELETE'},
                url: url,
                success: function(res){
                    location.reload();
                },
                error: function(res){
                    console.log('Error:', res);
                }
            });

        }
    </script>

@endsection
