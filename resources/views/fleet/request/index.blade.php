@extends('fleet.layout.base')

@section('title', 'Request History ')

@section('content')

<div class="content-area py-1">
    <div class="container-fluid">
        <div class="box box-block bg-white">
            <h5 class="mb-1">Request History</h5>
            @if(count($requests) != 0)
            <table class="table table-striped table-bordered dataTable" id="table-2">
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>User Name</th>
                        <th>Provider Name</th>
                        <th>Date &amp; Time</th>
                        <th>Status</th>
                        <th>Amount</th>
                        <th>Payment Mode</th>
                        <th>Payment Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($requests as $index => $request)
                    <tr>
                        <td>{{ $request->booking_id }}</td>
                        <td>{{ $request->user->first_name }} {{ $request->user->last_name }}</td>
                        <td>
                            @if($request->provider)
                                {{ $request->provider->first_name }} {{ $request->provider->last_name }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ $request->created_at }}</td>
                        <td>{{ $request->status }}</td>
                        <td>
                            @if($request->payment != "")
                                {{ currency($request->payment->total) }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ $request->payment_mode }}</td>
                        <td>
                            @if($request->paid)
                                Paid
                            @else
                                Not Paid
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-primary waves-effect dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    Action
                                </button>
                                <div class="dropdown-menu">
                                    <a href="{{ route('fleet.requests.show', $request->id) }}" class="dropdown-item">
                                        <i class="fa fa-search"></i> More Details
                                    </a>
                                    <form action="{{ route('fleet.requests.destroy', $request->id) }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type="submit" class="dropdown-item">
                                            <i class="fa fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>User Name</th>
                        <th>Provider Name</th>
                        <th>Date &amp; Time</th>
                        <th>Status</th>
                        <th>Amount</th>
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