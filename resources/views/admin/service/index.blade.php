@extends('admin.layout.base')

@section('title', 'Service Types ')

@section('content')
<div class="content-area py-1">
    <div class="container-fluid">
        <div class="box box-block bg-white">
            <h5 class="mb-1">Service Types</h5>
            <a href="{{ route('admin.service.create') }}" style="margin-left: 1em;" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Add New Service</a>
            <table class="table table-striped table-bordered dataTable" id="table-2">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Service Name</th>
                        <th>Provider Name</th>
                        <th>Capacity</th>
                        <th>Base Price</th>
                        <th>Base Distance</th>
                        <th>Distance Price</th>
                        <th>Time Price</th>
                        <th>Price Calculation</th>
                        <th>Service Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($services as $index => $service)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $service->name }}</td>
                        <td>{{ $service->provider_name }}</td>
                        <td>{{ $service->capacity }}</td>
                        <td>{{ currency($service->fixed) }}</td>
                        <td>{{ distance($service->distance) }}</td>
                        <td>{{ currency($service->price) }}</td>
                        <td>{{ currency($service->minute) }}</td>
                        <td>@lang('servicetypes.'.$service->calculator)</td>
                        <td>
                            @if($service->image) 
                                <img src="{{$service->image}}" style="height: 50px" >
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('admin.service.destroy', $service->id) }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <a href="{{ route('admin.service.edit', $service->id) }}" class="btn btn-info btn-block">
                                    <i class="fa fa-pencil"></i> Edit
                                </a>
                                <button class="btn btn-danger btn-block" onclick="return confirm('Are you sure?')">
                                    <i class="fa fa-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Service Name</th>
                        <th>Provider Name</th>
                        <th>Capacity</th>
                        <th>Base Price</th>
                        <th>Base Distance</th>
                        <th>Distance Price</th>
                        <th>Time Price</th>
                        <th>Price Calculation</th>
                        <th>Service Image</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection