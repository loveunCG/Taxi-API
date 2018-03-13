@extends('admin.layout.base')

@section('title', 'Fleets ')

@section('content')
<div class="content-area py-1">
    <div class="container-fluid">
        <div class="box box-block bg-white">
            <h5 class="mb-1">
                @lang('admin.fleet.fleet_owners')
                @if(Setting::get('demo_mode', 0) == 1)
                <span class="pull-right">(*personal information hidden in demo)</span>
                @endif
            </h5>
            <a href="{{ route('admin.fleet.create') }}" style="margin-left: 1em;" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> @lang('admin.fleet.add_new_fleet_owner')</a>
            <table class="table table-striped table-bordered dataTable" id="table-2">
                <thead>
                    <tr>
                        <th>@lang('admin.id')</th>
                        <th>@lang('admin.account-manager.full_name')</th>
                        <th>@lang('admin.fleet.company_name')</th>
                        <th>@lang('admin.email')</th>
                        <th>@lang('admin.mobile')</th>
                        <th>@lang('admin.action')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($fleets as $index => $fleet)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $fleet->name }}</td>
                        <td>{{ $fleet->company }}</td>
                        @if(Setting::get('demo_mode', 0) == 1)
                        <td>{{ substr($fleet->email, 0, 3).'****'.substr($fleet->email, strpos($fleet->email, "@")) }}</td>
                        @else
                        <td>{{ $fleet->email }}</td>
                        @endif
                        @if(Setting::get('demo_mode', 0) == 1)
                        <td>+919876543210</td>
                        @else
                        <td>{{ $fleet->mobile }}</td>
                        @endif
                        <td><img src="{{img($fleet->logo)}}" style="height: 100px;"></td>
                        <td>
                            <form action="{{ route('admin.fleet.destroy', $fleet->id) }}" method="POST">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="DELETE">
                                <a href="{{ route('admin.provider.index') }}?fleet={{$fleet->id}}" class="btn btn-info"> @lang('admin.fleet.show_provider')</a>
                                 <a href="{{ route('admin.fleet.edit', $fleet->id) }}" class="btn btn-info"><i class="fa fa-pencil"></i> @lang('admin.edit')</a>
                                <button class="btn btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i> @lang('admin.delete')</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>@lang('admin.id')</th>
                        <th>@lang('admin.account-manager.full_name')</th>
                        <th>@lang('admin.fleet.company_name')</th>
                        <th>@lang('admin.email')</th>
                        <th>@lang('admin.mobile')</th>
                        <th>@lang('admin.action')</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection