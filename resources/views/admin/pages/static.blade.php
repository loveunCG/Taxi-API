@extends('admin.layout.base')

@section('title', 'Pages ')

@section('content')
<div class="content-area py-1">
    <div class="container-fluid">
        <div class="box box-block bg-white">
            <h5>@lang('admin.pages.pages')</h5>

            <div className="row">
                <form action="{{ route('admin.pages.update') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="page" value="page_privacy">

                    <div class="row">
                        <div class="col-xs-12">
                            <textarea name="content" id="myeditor">{{ Setting::get('page_privacy') }}</textarea>
                        </div>
                    </div>

                    <br>

                    <div class="row">
                        <div class="col-xs-12 col-md-3">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-danger btn-block">Cancel</a>
                        </div>
                        <div class="col-xs-12 col-md-3 offset-md-6">
                            <button type="submit" class="btn btn-primary btn-block">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
<script type="text/javascript">
    CKEDITOR.replace('myeditor');
</script>
@endsection