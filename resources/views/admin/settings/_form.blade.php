@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet"/>

@endsection
<div class="col-md-6">
    <x-form.input type="text" name="config_setting_name" value="{{$setting['config_setting_name']['value'] ?? ''}}"
                  label="{{ trans('admin.settings.name') }}" required/>
</div>
<div class="col-lg-6">

    <x-form.input type="file" name="config_setting_logo" value="{{$setting['config_setting_logo']['value'] ?? ''}}"
                  label="{{ trans('admin.settings.logo') }}" accept="image/png, image/jpeg, image/gif"/>
    @if(isset($setting['config_setting_logo']['value'] ))
        <div class="p-1">
            <img src="{{ asset('storage/uploads/settings/'.$setting['config_setting_logo']['value'])  }}" alt=""
                 height="120" width="120">
        </div>
    @endif
</div>
<div class="col-md-6">
    <x-form.input type="text" name="config_setting_phone" value="{{$setting['config_setting_phone']['value'] ?? ''}}"
                  label="{{ trans('admin.settings.phone') }}" required/>
</div>
<div class="col-md-6">
    <x-form.input type="email" name="config_setting_email" value="{{$setting['config_setting_email']['value'] ?? ''}}"
                  label="{{ trans('admin.settings.email') }}" required/>
</div>
<div class="col-md-6">
    <x-form.input type="text" name="config_setting_facebook"
                  value="{{$setting['config_setting_facebook']['value'] ?? ''}}"
                  label="{{ trans('admin.settings.facebook') }}" required/>
</div>
<div class="col-md-6">
    <x-form.input type="text" name="config_setting_twitter"
                  value="{{$setting['config_setting_twitter']['value'] ?? ''}}"
                  label="{{ trans('admin.settings.twitter') }}" required/>
</div>
<div class="col-md-6">
    <x-form.input type="text" name="config_setting_instagram"
                  value="{{$setting['config_setting_instagram']['value'] ?? ''}}"
                  label="{{ trans('admin.settings.instagram') }}" required/>
</div>
<div class="col-md-6">
    <x-form.input type="text" name="config_setting_linkedin"
                  value="{{$setting['config_setting_linkedin']['value'] ?? ''}}"
                  label="{{ trans('admin.settings.linkedin') }}" required/>
</div>
<button type="submit" class="btn btn-lg btn-primary">{{$button_label ?? 'Save'}}</button>
@section('script')
    <script src="{{ URL::asset('build/libs/dropzone/dropzone-min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
    <script src="{{ URL::asset('build/js/pages/form-validation.init.js') }}"></script>
    <script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
<x-form.alert-data></x-form.alert-data>
