@extends('fleet.layout.base')

@section('title', 'Scheduled Rides ')

@section('content')

    <div class="content-area py-1">
        <div class="container-fluid">
            
            <div class="box box-block bg-white">
                <h5 class="mb-1">Scheduled Rides</h5>
                @if(count($requests) != 0)
                <table class="table table-striped table-bordered dataTable" id="table-2">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Booking Id</th>
                            <th>User Name</th>
                            <th>Provider Name</th>
                            <th>Scheduled Date & Time</th>
                            <th>Status</th>
                            <th>Payment Mode</th>
                            <th>Payment Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($requests as $index => $request)
                        <tr>
                            <td>{{$index + 1}}</td>

                            <td>{{$request->booking_id}}</td>
                            <td>{{$request->user->first_name}} {{$request->user->last_name}}</td>
                            <td>
                                @if($request->provider_id)
                                    {{$request->provider->first_name}} {{$request->provider->last_name}}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>{{$request->schedule_at}}</td>
                            <td>
                                {{$request->status}}
                            </td>

                            <td>{{$request->payment_mode}}</td>
                            <td>
                                @if($request->paid)
                                    Paid
                                @else
                                    Not Paid
                                @endif
                            </td>
                            <td>
                                <div class="input-group-btn">
                                  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">Action
                                    <span class="caret"></span>
                                  </button>
                                  <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{ route('fleet.requests.show', $request->id) }}" class="btn btn-default"><i class="fa fa-search"></i> More Details</a>
                                    </li>
                                  </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Request Id</th>
                            <th>User Name</th>
                            <th>Provider Name</th>
                            <th>Scheduled Date & Time</th>
                            <th>Status</th>
                            <th>Payment Mode</th>
                            <th>Payment Status</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
                @else
                    <h6 class="no-result">No results found</h6>
                @endif 
            </div>
            
        </div>
    </div>
@endsection