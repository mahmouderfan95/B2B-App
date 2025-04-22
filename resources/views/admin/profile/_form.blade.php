@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet"/>

@endsection
<div class="col-md-6">
    <x-form.input type="text" name="name" value="{{$admin->name ?? ''}}" label="{{ trans('admin.profile.name') }}" required />
</div>

<div class="col-md-6">
    <x-form.input type="email" name="email" value="{{$admin->email ?? ''}}" label="{{ trans('admin.vendors.email') }}" required />
</div>

<div class="col-lg-6">
    <x-form.input type="file" name="avatar" value="{{$admin->avatar ?? ''}}"
                  label="{{ trans('admin.profile.avatar') }}" accept="image/png, image/jpeg, image/gif" />
    @if(isset($admin->avatar))
    <div class="p-1">
        <img src="{{ asset('storage/uploads/users/' . $admin->avatar) }}" alt="" height="120" width="120">
    </div>
    @endif
</div> <!-- end col -->
<div class="row">
    <div class="col-lg-6">
        <button type="submit" class="btn btn-lg btn-primary">{{$button_label ?? 'Save'}}</button>
    </div>
</div>
@section('script')
    <script src="{{ URL::asset('build/libs/dropzone/dropzone-min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
    <script src="{{ URL::asset('build/js/pages/form-validation.init.js') }}"></script>
    <script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
