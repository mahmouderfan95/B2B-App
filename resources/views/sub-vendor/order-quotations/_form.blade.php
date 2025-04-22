@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet"/>
@endsection
<div class="col-md-6">
    <x-form.input type="number" name="quotation_price" value="{{$orderQuotation->quotation_price ?? ''}}" label="{{ trans('vendor.order-quotations.quotation_price') }}" required />
</div>
<div class="col-md-6">
    <x-form.radio name="status" value="{{$orderQuotation->status ?? ''}}" label="{{trans('admin.status')}}"
    :options="['accepted'=>'قبول','refused'=>'رفض','pending'=>' جاري']" required checked="{{$orderQuotation->status ?? ''}}" selected="{{$orderQuotation->status ?? ''}}"/>
</div>
<button type="submit" class="btn btn-lg btn-primary">{{$button_label ?? 'Save'}}</button>
@section('script')
    <script src="{{ URL::asset('build/libs/dropzone/dropzone-min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
    <script src="{{ URL::asset('build/js/pages/form-validation.init.js') }}"></script>
    <script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
