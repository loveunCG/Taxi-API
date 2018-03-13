@extends('user.layout.base')

@section('title', 'Profile ')

@section('content')

<div class="col-md-9">
    <div class="dash-content">
        <div class="row no-margin">
            <div class="col-md-12">
                <h4 class="page-title">@lang('user.profile.edit_information')</h4>
            </div>
        </div>
            @include('common.notify')
        <div class="row no-margin edit-pro">
            <form action="{{url('profile')}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
                <div class="col-md-12">
                    <label>@lang('user.profile.profile_picture')</label>
                    <div class="profile-img-blk">
                        <div class="img_outer">
                            <img class="profile_preview" id="profile_image_preview" src="{{img(Auth::user()->picture)}}" alt="your image"/>
                        </div>
                        <div class="fileUpload up-btn profile-up-btn">                   
                            <input type="file" id="profile_img_upload_btn" name="picture" class="upload" accept="image/x-png, image/jpeg"/>
                        </div>                             
                    </div> 
                </div>
                <div class="form-group col-md-6">
                    <label>@lang('user.profile.first_name')</label>
                    <input type="text" class="form-control" name="first_name" required placeholder="@lang('user.profile.first_name')" value="{{Auth::user()->first_name}}">
                </div>
                <div class="form-group col-md-6">
                    <label>@lang('user.profile.last_name')</label>
                    <input type="text" class="form-control" name="last_name" required placeholder="@lang('user.profile.last_name')" value="{{Auth::user()->last_name}}">
                </div>

                <div class="form-group col-md-6">
                    <label>@lang('user.profile.email')</label>
                    <input type="email" class="form-control" placeholder="@lang('user.profile.email')" readonly value="{{Auth::user()->email}}">
                </div>

                <div class="form-group col-md-6">
                    <label>@lang('user.profile.mobile')</label>
                    <input type="text" class="form-control" name="mobile" required placeholder="@lang('user.profile.mobile')" value="{{Auth::user()->mobile}}">
                </div>
              
                <div class="col-md-6 pull-right">
                    <button type="submit" class="form-sub-btn big">@lang('user.profile.save')</button>
                </div>
            </form>
        </div>

    </div>
</div>

@endsection