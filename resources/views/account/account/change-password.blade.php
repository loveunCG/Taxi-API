@extends('account.layout.base')

@section('title', 'Change Password ')

@section('content')

<div class="content-area py-1">
    <div class="container-fluid">
    	<div class="box box-block bg-white">

			<h5 style="margin-bottom: 2em;">Change Password</h5>

            <form class="form-horizontal" action="{{route('account.password.update')}}" method="POST" role="form">
            	{{csrf_field()}}

            	<div class="form-group row">
					<label for="old_password" class="col-xs-12 col-form-label">Old Password</label>
					<div class="col-xs-10">
						<input class="form-control" type="password" name="old_password" id="old_password" placeholder="Old Password">
					</div>
				</div>

				<div class="form-group row">
					<label for="password" class="col-xs-12 col-form-label">Password</label>
					<div class="col-xs-10">
						<input class="form-control" type="password" name="password" id="password" placeholder="New Password">
					</div>
				</div>

				<div class="form-group row">
					<label for="password_confirmation" class="col-xs-12 col-form-label">Password Confirmation</label>
					<div class="col-xs-10">
						<input class="form-control" type="password" name="password_confirmation" id="password_confirmation" placeholder="Re-type New Password">
					</div>
				</div>

				<div class="form-group row">
					<label for="zipcode" class="col-xs-12 col-form-label"></label>
					<div class="col-xs-10">
						<button type="submit" class="btn btn-primary">Change Password</button>
					</div>
				</div>

			</form>
		</div>
    </div>
</div>

@endsection
