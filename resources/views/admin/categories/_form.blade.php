@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet"/>

@endsection
@forelse($languages as  $language)
    @if(isset($category))
        @foreach($category->translations as $category_translation )
            @if($language->id == $category_translation['language_id'])
                <div class="col-md-6">
                    <span class="text-dark"> ({{$language->name}}) </span>
                    <x-form.input type="text" name="name[{{$language->id}}]" value="{{$category_translation['name']}}"
                                  label="{{ trans('admin.categories.name') }}" required/>
                </div>
            @endif
        @endforeach
    @else
        <div class="col-md-6">
            <span class="text-dark"> ({{$language->name}}) </span>
            <x-form.input type="text" name="name[{{$language->id}}]" value=""
                          label="{{ trans('admin.categories.name') }}" required/>
        </div>
    @endif

@empty

@endforelse
<div class="col-md-6">
    <x-form.select_categories name="parent_id" :options="$categories" label="{{ trans('admin.categories.main') }}" level="" selected="{{$category->parent_id ?? ''}}"></x-form.select_categories>
</div>

<div class="col-lg-6">

    <x-form.input type="file" name="image" value="{{$category->image ?? ''}}"
                  label="{{ trans('admin.categories.image') }}" accept="image/png, image/jpeg, image/gif" />
    @if(isset($category->image))
    <div class="p-1">
        <img src="{{ $category->image }}" alt="" height="120" width="120">
    </div>
    @endif
</div> <!-- end col -->
<div class="col-md-6">
    <x-form.radio name="status" value="{{$category->status ?? ''}}" label="{{trans('admin.status')}}"
                  :options="['active'=>'نشط','inactive'=>'غير نشط']" required checked="{{$category->status ?? ''}}"/>
</div>
<button type="submit" class="btn btn-lg btn-primary">{{$button_label ?? 'Save'}}</button>
@section('script')
    <script src="{{ URL::asset('build/libs/dropzone/dropzone-min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
    <script src="{{ URL::asset('build/js/pages/form-validation.init.js') }}"></script>
    <script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
