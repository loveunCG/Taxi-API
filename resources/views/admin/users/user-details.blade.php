@extends('admin.layout.base')

@section('title', 'User Details ')

@section('content')

    <div class="content-area py-1">
        <div class="container-fluid">
            <div class="box box-block bg-white">
            	<h4>@lang('admin.users.User_Details')</h4>
            	<div class="row">
            		<div class="col-md-12">
						<div class="box bg-white user-1">
						<?php $background = asset('admin/assets/img/photos-1/4.jpg'); ?>
							<div class="u-img img-cover" style="background-image: url({{$background}});"></div>
							<div class="u-content">
								<div class="avatar box-64">
									<img class="b-a-radius-circle shadow-white" src="{{img($user->picture)}}" alt="">
									<i class="status bg-success bottom right"></i>
								</div>
								<h5><a class="text-black" href="#">{{$user->first_name}} {{$user->last_name}}</a></h5>
								<p class="text-muted">@lang('admin.email') : {{$user->email}}</p>
								<p class="text-muted">@lang('admin.mobile') : {{$user->mobile}}</p>
								<p class="text-muted">@lang('admin.gender') : {{$user->gender}}</p>
								<p class="text-muted">@lang('admin.users.Wallet_Balance') : {{currency($user->wallet_balance)}}</p>
							</div>
						</div>
					</div>
            	</div>

            </div>
        </div>
    </div>

@endsection
