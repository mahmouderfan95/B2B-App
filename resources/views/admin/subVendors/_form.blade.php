@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet"/>

@endsection

@php
    $is_vendor = auth()->guard('vendor')->check();
@endphp

<div class="col-md-6">
    <x-form.input type="text" name="name" value="{{$subVendor->name ?? ''}}" label="{{ trans('vendor.sub.name') }}"
                  required/>
</div>

<div class="col-md-6">
    <x-form.input type="email" name="email" value="{{$subVendor->email ?? ''}}"
                  label="{{ trans('admin.vendors.email') }}" required/>
</div>

<div class="col-md-6">
    <x-form.input type="number" name="phone" value="{{$subVendor->phone ?? ''}}"
                  label="{{ trans('admin.vendors.phone') }}" required/>
</div>
<div class="col-md-6">
    <x-form.select name="vendor_id" :options="$vendors" label="{{ trans('admin.vendors.name') }}"
                   selected="{{$subVendor->vendor_id ?? ''}}" :required="true"></x-form.select>
</div>

<div class="col-md-6">
    <x-form.select name="role" :options="$roles"
                   label="{{ trans('admin.roles_permissions.page_title') }}"
                   selected="" required></x-form.select>
</div>

<div class="col-md-6">
    <x-form.input type="password" name="password" value="" label="{{ trans('vendor.password') }}" placeholder=""/>
</div>


<button type="submit" class="btn btn-lg btn-primary">{{$button_label ?? 'Save'}}</button>
@section('script')
    <script src="{{ URL::asset('build/libs/dropzone/dropzone-min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
    <script src="{{ URL::asset('build/js/pages/form-validation.init.js') }}"></script>
    <script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>

    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
