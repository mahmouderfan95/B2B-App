@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet"/>

@endsection
@forelse($languages as  $language)
    @if(isset($data))
        @foreach($data->translations as $fag_translation )
            @if($language->id == $fag_translation['language_id'])
                <div class="col-md-6">

                    <span class="text-dark"> ({{$language->name}}) </span>

                    <x-form.tinymce-editor
                        name="question[{{$language->id}}]"
                        value="{{$fag_translation['question']}}"
                        label="{{ trans('admin.fags.question') }}"
                        required
                    />

                </div>

                <div class="col-md-6">

                    <span class="text-dark"> ({{$language->name}}) </span>

                    <x-form.tinymce-editor
                        name="answer[{{$language->id}}]"
                        value="{{$fag_translation['answer']}}"
                        label="{{ trans('admin.fags.answer') }}"
                        required
                    />

                </div>
            @endif
        @endforeach
    @else
        <div class="col-md-6">
            <span class="text-dark"> ({{$language->name}}) </span>
            <x-form.tinymce-editor
                name="question[{{$language->id}}]"
                value=""
                label="{{ trans('admin.fags.question') }}"
                required
            />
        </div>
        <div class="col-md-6">
            <span class="text-dark"> ({{$language->name}}) </span>
            <x-form.tinymce-editor
                name="answer[{{$language->id}}]"
                value=""
                label="{{ trans('admin.fags.answer') }}"
                required
            />
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
