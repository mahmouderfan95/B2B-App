@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet"/>

@endsection
<div class="col-md-6">
    <x-form.input type="text" name="rate" value="{{$review->rate ?? ''}}"
                  label="{{ trans('admin.reviews.rate') }}" disabled/>
</div>
<div class="col-md-6">
    <x-form.input type="text" name="client" value="{{$review->client->name ?? ''}}"
                  label="{{ trans('admin.reviews.client') }}" disabled/>
</div>
<div class="col-md-6">
    <x-form.input type="text" name="product_id" value="{{$review->product->translations[0]->name ?? ''}}"
                  label="{{ trans('admin.reviews.product') }}" disabled/>
</div>
<div class="col-md-6">
    <x-form.input type="text" name="comment" value="{{$review->comment ?? ''}}"
                  label="{{ trans('admin.reviews.comment') }}" disabled/>
</div>
<div class="col-md-4">
    <x-form.radio name="status" value="{{$review->status ?? ''}}" label="{{trans('admin.status')}}"
                  :options="['accepted'=>'نشط','pending'=>' جاري','refused'=>'غير نشط']" required checked="{{$review->status ?? ''}}"/>
</div>
<button type="submit" class="btn btn-lg btn-primary">{{$button_label ?? 'Save'}}</button>
@section('script')
    <script src="{{ URL::asset('build/libs/dropzone/dropzone-min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
    <script src="{{ URL::asset('build/js/pages/form-validation.init.js') }}"></script>
    <script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
