<div class="col-md-6">
    <x-form.input type="text" name="name" value="{{$language->name ?? ''}}"
                  label="{{ trans('admin.languages.name') }}" required/>
</div>
<div class="col-md-6">
    <x-form.input type="text" name="code" value="{{$language->code ?? ''}}"
                  label="{{ trans('admin.languages.code') }}" required/>
</div>
<div class="col-lg-6">

    <x-form.input type="file" name="image" value="{{$language->image ?? ''}}"
                  label="{{ trans('admin.languages.image') }}" accept="image/png, image/jpeg, image/gif" />
    @if (isset($language->image))
        <img src="{{$language->image }}" alt="" height="60" class="p-2">
    @endif
</div> <!-- end col -->
<div class="col-md-6">
    <x-form.input type="number" name="sort_order" value="{{$language->sort_order ?? ''}}"
                  label="{{ trans('admin.sort_order') }}" required/>
</div>
<div class="col-md-6">
    <x-form.radio name="status" value="{{ $language->status ?? ''}}" label="{{trans('admin.status')}}"
                  :options="['active'=>'نشط','inactive'=>'غير نشط']"  required checked="{{$language->status ?? ''}}"/>
</div>
<button type="submit" class="btn btn-lg btn-primary">{{$button_label ?? 'Save'}}</button>
@section('script')
    <script src="{{ URL::asset('build/js/pages/form-validation.init.js') }}"></script>
    <script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/sweetalerts.init.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>

@endsection
