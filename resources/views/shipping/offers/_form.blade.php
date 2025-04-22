@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet"/>

@endsection
<div class="col-md-6">
    <div class="col-md-12">
        <x-form.select name="order_id" :options="$orders" label="{{ trans('admin.vendors.name') }}"
                       selected="{{$offer->order_id ?? ''}}"></x-form.select>
    </div>
</div>
<div class="col-md-6">
    <x-form.input type="text" name="price" value="{{$offer->price ?? ''}}"
                  label="{{ trans('shipping.offers.price') }}" required/>
</div>
<button type="submit" class="btn btn-lg btn-primary">{{$button_label ?? 'Save'}}</button>
@section('script')
    <script src="{{ URL::asset('build/libs/dropzone/dropzone-min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
    <script src="{{ URL::asset('build/js/pages/form-validation.init.js') }}"></script>
    <script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
