@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet"/>

@endsection
@forelse($languages as  $language)
    @if(isset($data))
        @foreach($data->translations as $policy_translation )
            @if($language->id == $policy_translation['language_id'])
                <div class="col-md-6">

                    <span class="text-dark"> ({{$language->name}}) </span>
                    <textarea class="ckeditor form-control"
                      name="term_and_condition[{{$language->id}}]">{{$policy_translation['term_and_condition']}}</textarea>

                    {{-- <x-form.tinymce-editor
                        name="policy[{{$language->id}}]"
                        value="{{$policy_translation['policy']}}"
                        label="{{ trans('admin.privacy_policy.privacy_policy') }}"
                        required
                    /> --}}

                </div>
            @endif
        @endforeach
    @else
        <div class="col-md-6">
            <span class="text-dark"> ({{$language->name}}) </span>
            <textarea class="ckeditor form-control"
                      name="term_and_condition[{{$language->id}}]"></textarea>
            {{-- <x-form.tinymce-editor
                name="policy[{{$language->id}}]"
                value=""
                label="{{ trans('admin.privacy_policy.privacy_policy') }}"
                required
            /> --}}
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

    <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {

                $('.ckeditor').ckeditor();
            });
            </script>

@endsection
