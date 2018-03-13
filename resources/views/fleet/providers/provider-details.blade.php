@extends('fleet.layout.base')

@section('title', 'Provider Details ')

@section('content')

    <div class="content-area py-1">
        <div class="container-fluid">
            <div class="box box-block bg-white">
            	<h4>Provider Details</h4>
            	<div class="row">
            		<div class="col-md-12">
						<div class="box bg-white user-1">
						<?php $background = asset('admin/assets/img/photos-1/4.jpg'); ?>
							<div class="u-img img-cover" style="background-image: url({{$background}});"></div>
							<div class="u-content">
								<div class="avatar box-64">
									<img class="b-a-radius-circle shadow-white" src="{{img($provider->picture)}}" alt="">
									<i class="status bg-success bottom right"></i>
								</div>
								<p class="text-muted">
									@if($provider->is_approved == 1)
										<span class="tag tag-success">Approved</span>
									@else
										<span class="tag tag-success">Not Approved</span>
									@endif
								</p>
								<h5><a class="text-black" href="#">{{$provider->first_name}} {{$provider->last_name}}</a></h5>
								<p class="text-muted">Email : {{$provider->email}}</p>
								<p class="text-muted">Mobile : {{$provider->mobile}}</p>
								<p class="text-muted">Gender : {{$provider->gender}}</p>
								<p class="text-muted">Address : {{$provider->address}}</p>
								<p class="text-muted">
									@if($provider->is_activated == 1)
										<span class="tag tag-warning">Activated</span>
									@else
										<span class="tag tag-warning">Not Activated</span>
									@endif
								</p>
							</div>
						</div>
					</div>
            	</div>

            </div>
        </div>
    </div>

@endsection
