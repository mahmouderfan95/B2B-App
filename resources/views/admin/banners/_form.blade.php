@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet"/>

@endsection
<div class="col-md-6">
    <x-form.input type="url" name="url" value="{{$banner->url ?? ''}}"
                  label="{{ trans('admin.banners.url') }}" required/>
</div>
<div class="col-lg-6">

    <x-form.input type="file" name="image" value="{{$banner->image ?? ''}}"
                  label="{{ trans('admin.banners.image') }}" accept="image/png, image/jpeg, image/gif" required/>
    @if(isset($banner->image))
        <div class="p-1">
            <img src="{{ $banner->image }}" alt="" height="120" width="120">
        </div>
    @endif
</div> <!-- end col -->
{{--<div class="col-md-6">
    <x-form.input type="number" name="sort_order" value="{{$banner->sort_order ?? ''}}"
                  label="{{ trans('admin.sort_order') }}" required/>
</div>--}}
<button type="submit" class="btn btn-lg btn-primary">{{$button_label ?? 'Save'}}</button>
@section('script')
    <script src="{{ URL::asset('build/libs/dropzone/dropzone-min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
    <script src="{{ URL::asset('build/js/pages/form-validation.init.js') }}"></script>
    <script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
