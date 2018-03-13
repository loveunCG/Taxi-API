@extends('admin.layout.base')

@section('title', 'Update Document ')

@section('content')

<div class="content-area py-1">
    <div class="container-fluid">
    	<div class="box box-block bg-white">
    	    <a href="{{ route('admin.document.index') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i> @lang('admin.back')</a>

			<h5 style="margin-bottom: 2em;">@lang('admin.document.update_document')</h5>

            <form class="form-horizontal" action="{{route('admin.document.update', $document->id )}}" method="POST" enctype="multipart/form-data" role="form">
            	{{csrf_field()}}
            	<input type="hidden" name="_method" value="PATCH">
				<div class="form-group row">
					<label for="name" class="col-xs-2 col-form-label">@lang('admin.document.document_name')</label>
					<div class="col-xs-10">
						<input class="form-control" type="text" value="{{ $document->name }}" name="name" required id="name" placeholder="Document Name">
					</div>
				</div>

                <div class="form-group row">
                    <label for="name" class="col-xs-2 col-form-label">@lang('admin.document.document_type')</label>
                    <div class="col-xs-10">
                        <select name="type">
                            <option value="DRIVER" @if($document->type == 'DRIVER') selected @endif>@lang('admin.document.driver_review')</option>
                            <option value="VEHICLE" @if($document->type == 'VEHICLE') selected @endif>@lang('admin.document.vehicle_review')</option>
                        </select>
                    </div>
                </div>

				<div class="form-group row">
					<label for="zipcode" class="col-xs-2 col-form-label"></label>
					<div class="col-xs-10">
						<button type="submit" class="btn btn-primary">@lang('admin.document.update_document')</button>
						<a href="{{route('admin.document.index')}}" class="btn btn-default">@lang('admin.cancel')</a>
					</div>
				</div>
			</form>
		</div>
    </div>
</div>

@endsection
