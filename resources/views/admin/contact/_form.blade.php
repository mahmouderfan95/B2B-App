@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet"/>

@endsection
@forelse($languages as  $language)
    @if(isset($data))
        @foreach($data->translations as $contact_translation )
            @if($language->id == $contact_translation['language_id'])
                <div class="col-md-6">
                    <span class="text-dark"> ({{$language->name}}) </span>
                    <x-form.input type="text" name="address[{{$language->id}}]" value="{{$contact_translation['address']}}"
                                  label="{{ trans('admin.contact.address') }}" required/>
                </div>
            @endif
        @endforeach

    @else
        <div class="col-md-6">
            <span class="text-dark"> ({{$language->name}}) </span>
            <x-form.input type="text" name="address[{{$language->id}}]" value=""
                          label="{{ trans('admin.contact.address') }}" required/>
        </div>
    @endif

@empty

@endforelse
<div class="col-md-6">
    <x-form.input type="number" name="phone" value="{{ $data->phone ?? ''  }}"
                  label="{{ trans('admin.phone') }}" required/>
</div>
<div class="col-md-6">
    <x-form.input type="email" name="email" value="{{ $data->email ?? ''  }}"
                  label="{{ trans('admin.email') }}" required/>
</div>
<div class="col-md-6">
    <x-form.input type="text" name="work_time" value="{{ $data->work_time ?? ''  }}"
                  label="{{ trans('admin.contact.work_time') }}" required/>
</div>
<div class="col-md-6">
    <x-form.input type="text" name="facebook_link" value="{{ $data->facebook_link ?? ''  }}"
                  label="{{ trans('admin.contact.facebook_link') }}" required/>
</div>
<div class="col-md-6">
    <x-form.input type="text" name="instagram_link" value="{{ $data->instagram_link ?? ''  }}"
                  label="{{ trans('admin.contact.instagram_link') }}" required/>
</div>
<div class="col-md-6">
    <x-form.input type="text" name="twitter_link" value="{{ $data->twitter_link ?? ''  }}"
                  label="{{ trans('admin.contact.twitter_link') }}" required/>
</div>
<div class="col-md-6">
    <x-form.input type="text" name="whatsapp_link" value="{{ $data->whatsapp_link ?? ''  }}"
                  label="{{ trans('admin.contact.whatsapp_link') }}" required/>
</div>

<button type="submit" class="btn btn-lg btn-primary">{{$button_label ?? 'Save'}}</button>
@section('script')
    <script src="{{ URL::asset('build/libs/dropzone/dropzone-min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
    <script src="{{ URL::asset('build/js/pages/form-validation.init.js') }}"></script>
    <script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
