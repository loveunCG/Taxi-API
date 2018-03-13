@extends('admin.layout.base')

@section('title', 'Translation ')

@section('content')

    <div class="content-area py-1">
        <div class="container-fluid">
        	<div class="embed-responsive embed-responsive-16by9">
            	<iframe src="{{url('translations')}}" allowfullscreen style="width: 100%;height: 800px;border:none;" class="embed-responsive-item"></iframe>
            </div>
        </div>
    </div>

@endsection
