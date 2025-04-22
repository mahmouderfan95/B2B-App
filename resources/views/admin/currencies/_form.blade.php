<div class="col-md-6">
    <x-form.input type="text" name="name" value="{{$currency->name ?? ''}}"
                  label="{{ trans('admin.currencies.name') }}" required/>
</div>
<div class="col-md-6">
    <x-form.input type="text" name="code" value="{{$currency->code ?? ''}}"
                  label="{{ trans('admin.currencies.code') }}" required/>
</div>
<div class="col-md-6">
    <x-form.input type="number" name="value" value="{{$currency->value ?? ''}}"
                  label="{{ trans('admin.currencies.value') }}" placeholder="1.00" required/>
</div>
<div class="col-md-6">
    <x-form.radio name="status" value="{{ $currency->status ?? ''}}" label="{{trans('admin.status')}}"
                  :options="['active'=>'نشط','inactive'=>'غير نشط']"  required checked="{{$currency->status ?? ''}}"/>
</div>
<button type="submit" class="btn btn-lg btn-primary">{{$button_label ?? 'Save'}}</button>
@section('script')
    <script src="{{ URL::asset('build/js/pages/form-validation.init.js') }}"></script>
    <script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/sweetalerts.init.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>

@endsection
