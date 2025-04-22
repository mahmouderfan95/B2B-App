@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet"/>

@endsection
@forelse($languages as  $language)
    @if(isset($shippingMethod))
        @foreach($shippingMethod->translations as $shippingMethod_translation )
            @if($language->id == $shippingMethod_translation['language_id'])
                <div class="col-md-6">
                    <span class="text-dark"> ({{$language->name}}) </span>
                    <x-form.input type="text" name="name[{{$language->id}}]" value="{{$shippingMethod_translation['name']}}"
                                  label="{{ trans('admin.shippingMethods.name') }}" required/>
                </div>
            @endif
        @endforeach
    @else
        <div class="col-md-6">
            <span class="text-dark"> ({{$language->name}}) </span>
            <x-form.input type="text" name="name[{{$language->id}}]" value=""
                          label="{{ trans('admin.shippingMethods.name') }}" required/>
        </div>
    @endif

@empty

@endforelse

<div class="col-md-6">
    <x-form.input type="email" name="email" value="{{$shippingMethod->email ?? ''}}" label="{{ trans('admin.email') }}" required />
</div>
<div class="col-lg-6">
    <x-form.input type="file" name="logo" value="{{$shippingMethod->logo ?? ''}}"
                  label="{{ trans('admin.image') }}" accept="image/png, image/jpeg, image/gif" />
    @if(isset($shippingMethod->logo))
        <div class="p-1">
            <img src="{{ $shippingMethod->logo }}" alt="" height="120" width="120">
        </div>
    @endif
</div> <!-- end col -->
@if(!isset($shippingMethod))
<div class="col-md-6">
    <x-form.input type="password" name="password" value="{{$shippingMethod->password ?? ''}}" label="{{ trans('admin.password') }}" required />
</div>
@endif
<div class="col-md-6">
    <x-form.radio name="status" value="{{$shippingMethod->status ?? ''}}" label="{{trans('admin.status')}}"
                  :options="['active'=>'نشط','inactive'=>'غير نشط']" required checked="{{$shippingMethod->status ?? ''}}" selected="{{$shippingMethod->status ?? ''}}"/>
</div>


<button type="submit" class="btn btn-lg btn-primary">{{$button_label ?? 'Save'}}</button>
@section('script')
    <script src="{{ URL::asset('build/libs/dropzone/dropzone-min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
    <script src="{{ URL::asset('build/js/pages/form-validation.init.js') }}"></script>
    <script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
