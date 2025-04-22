@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet"/>

@endsection
@forelse($languages as  $language)
    @if(isset($country))
        @foreach($country->translations as $country_translation )
            @if($language->id == $country_translation['language_id'])
                <div class="col-md-6">
                    <span class="text-dark"> ({{$language->name}}) </span>
                    <x-form.input type="text" name="name[{{$language->id}}]" value="{{$country_translation['name']}}"
                                  label="{{ trans('admin.countries.name') }}" required/>
                </div>
            @endif
        @endforeach
    @else
        <div class="col-md-6">
            <span class="text-dark"> ({{$language->name}}) </span>
            <x-form.input type="text" name="name[{{$language->id}}]" value=""
                          label="{{ trans('admin.countries.name') }}" required/>
        </div>
    @endif

@empty

@endforelse
<div class="col-lg-6">

    <x-form.input type="text" name="code" value="{{$country->code ?? ''}}" maxlength="3"
                  label="{{ trans('admin.countries.code') }}" required />
</div>
<div class="col-lg-6">

    <x-form.input type="number" name="vat" value="{{$country->vat ?? ''}}" maxlength="3"
                  label="{{ trans('admin.countries.vat') }}" required />
</div>

<div class="col-lg-6">

    <x-form.input type="file" name="flag" value="{{$country->flag ?? ''}}" required
                  label="{{ trans('admin.countries.image') }}" accept="image/png, image/jpeg, image/gif"/>
    @if(isset($country->flag))
        <div class="p-1">
            <img src="{{ $country->flag }}" alt="" height="120" width="120">
        </div>
    @endif
</div> <!-- end col -->

<button type="submit" class="btn btn-lg btn-primary">{{$button_label ?? 'Save'}}</button>
@section('script')
    <script src="{{ URL::asset('build/libs/dropzone/dropzone-min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
    <script src="{{ URL::asset('build/js/pages/form-validation.init.js') }}"></script>
    <script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script>
        $('#validationDefaultcode').keypress(function (e) {
            var regex = new RegExp("^[a-zA-Z]+$");
            var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
            if (regex.test(str)) {
                return true;
            }
            else
            {
                e.preventDefault();
                return false;
            }
        });
    </script>
@endsection
