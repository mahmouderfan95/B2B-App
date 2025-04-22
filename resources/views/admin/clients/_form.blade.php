@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet"/>

@endsection
<div class="col-md-6">
    <x-form.input type="text" name="name" value="{{$client->name ?? ''}}" label="{{ trans('admin.clients.name') }}" required />
</div>
<div class="col-md-6">
    <x-form.input type="text" name="phone" value="{{$client->phone ?? ''}}" label="{{ trans('admin.clients.phone') }}"  />
</div>

<div class="col-md-6">
    <x-form.input type="text" name="another_phone" value="{{$client->another_phone ?? ''}}" label="{{ trans('admin.clients.another_phone') }}"  />
</div>

<div class="col-md-6">
    <x-form.input type="email" name="email" value="{{$client->email ?? ''}}" label="{{ trans('admin.email') }}" required />
</div>
<div class="col-lg-6">
    <x-form.input type="file" name="logo" value="{{$client->image ?? ''}}"
                  label="{{ trans('admin.clients.image') }}" accept="image/png, image/jpeg, image/gif" />
    @if(isset($client->image))
    <div class="p-1">
        <img src="{{ $client->image }}" alt="" height="120" width="120">
    </div>
    @endif
</div> <!-- end col -->
<div class="col-md-6">
    <x-form.radio name="status" value="{{$client->status ?? ''}}" label="{{trans('admin.status')}}"
                  :options="['accepted'=>'نشط','refused'=>'غير نشط','pending'=>' جاري']" required checked="{{$client->status ?? ''}}" selected="{{$client->status ?? ''}}"/>
</div>
<button type="submit" class="btn btn-lg btn-primary">{{$button_label ?? 'Save'}}</button>
@section('script')
    <script src="{{ URL::asset('build/libs/dropzone/dropzone-min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
    <script src="{{ URL::asset('build/js/pages/form-validation.init.js') }}"></script>
    <script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
@endsection
