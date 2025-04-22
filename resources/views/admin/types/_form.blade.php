@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet"/>

@endsection
@forelse($languages as  $language)
    @if(isset($type))
        @foreach($type->translations as $type_translation )
            @if($language->id == $type_translation['language_id'])
                <div class="col-md-6">
                    <span class="text-dark"> ({{$language->name}}) </span>
                    <x-form.input type="text" name="name[{{$language->id}}]" value="{{$type_translation['name']}}"
                                  label="{{ trans('admin.types.name') }}" required/>
                </div>
            @endif
        @endforeach
    @else
        <div class="col-md-6">
            <span class="text-dark"> ({{$language->name}}) </span>
            <x-form.input type="text" name="name[{{$language->id}}]" value=""
                          label="{{ trans('admin.types.name') }}" required/>
        </div>
    @endif

@empty

@endforelse


<button type="submit" class="btn btn-lg btn-primary">{{$button_label ?? 'Save'}}</button>
@section('script')
    <script src="{{ URL::asset('build/libs/dropzone/dropzone-min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
    <script src="{{ URL::asset('build/js/pages/form-validation.init.js') }}"></script>
    <script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
