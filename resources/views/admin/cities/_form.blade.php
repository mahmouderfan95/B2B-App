@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet"/>

@endsection
@forelse($languages as  $language)
    @if(isset($city))
        @foreach($city->translations as $city_translation )
            @if($language->id == $city_translation['language_id'])
                <div class="col-md-6">
                    <span class="text-dark"> ({{$language->name}}) </span>
                    <x-form.input type="text" name="name[{{$language->id}}]" value="{{$city_translation['name']}}"
                                  label="{{ trans('admin.cities.name') }}" required/>
                </div>
            @endif
        @endforeach
    @else
        <div class="col-md-6">
            <span class="text-dark"> ({{$language->name}}) </span>
            <x-form.input type="text" name="name[{{$language->id}}]" value=""
                          label="{{ trans('admin.cities.name') }}" required/>
        </div>
    @endif

@empty

@endforelse
<div class="col-md-6">
<x-form.select name="region_id" :options="$regions" label="{{ trans('admin.regions.name') }}"  selected="{{$city->region_id ?? ''}}" required></x-form.select>
</div>
<button type="submit" class="btn btn-lg btn-primary">{{$button_label ?? 'Save'}}</button>
@section('script')
    <script src="{{ URL::asset('build/libs/dropzone/dropzone-min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
    <script src="{{ URL::asset('build/js/pages/form-validation.init.js') }}"></script>
    <script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
