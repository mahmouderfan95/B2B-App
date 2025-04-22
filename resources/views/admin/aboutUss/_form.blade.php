@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet"/>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

@endsection

@forelse($languages as  $language)
    @if(isset($aboutUs))
        @foreach($aboutUs->translations as $aboutUs_translation )
            @if($language->id == $aboutUs_translation['language_id'])
                 <div class="col-md-6" style="height: 200%" name>
                    <span class="text-dark"> ({{$language->name}}) </span>

                    <textarea class="ckeditor form-control"  name="name[{{$language->id}}]">{{$aboutUs_translation['name']}}</textarea>
                    {{-- <x-form.textarea type="text" name="name[{{$language->id}}]" value="{{$aboutUs_translation['name']}}"
                                  label="{{ trans('admin.aboutUss.name') }}" rows="10"  required/> --}}
                </div>
            @endif
        @endforeach
    @else
        <div class="col-md-6">
            <span class="text-dark"> ({{$language->name}}) </span>
            <x-form.textarea type="text" name="name[{{$language->id}}]" value=""
                          label="{{ trans('admin.aboutUss.name') }}" rows="10" required/>
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
