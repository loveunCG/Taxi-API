@extends('user.layout.app')

@section('content')
<div class="row gray-section no-margin">
    <div class="container">
        <div class="content-block">
            <h2>{{ $title }}</h2>
            <div class="title-divider"></div>
            <p>{!! Setting::get($page) !!}</p>
        </div>
    </div>
</div>
@endsection