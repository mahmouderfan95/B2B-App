@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet"/>

@endsection
<div class="col-md-6">
    <x-form.select name="country_id" :options="$countries" label="{{ trans('admin.countries.name') }}"  selected="{{$vendor->country_id ?? ''}}" required></x-form.select>
</div>
<div class="col-md-6">
    <x-form.select name="bank_id" :options="$banks" label="{{ trans('admin.banks.name') }}"  selected="{{$vendor->bank_id ?? ''}}" required></x-form.select>
</div>

<div class="col-md-6">
    <x-form.input type="text" name="name" value="{{$vendor->name ?? ''}}" label="{{ trans('admin.vendors.name') }}" required />
</div>

<div class="col-md-6">
    <x-form.input type="text" name="street" value="{{$vendor->street ?? ''}}" label="{{ trans('admin.vendors.street') }}"  required/>
</div>

<div class="col-md-6">
    <x-form.input type="number" name="bank_account_number" value="{{$vendor->bank_account_number ?? ''}}" label="{{ trans('admin.vendors.bank_account_number') }}" required />
</div>

<div class="col-md-6">
    <x-form.input type="number" name="iban" value="{{$vendor->iban ?? ''}}" label="{{ trans('admin.vendors.iban') }}"  required/>
</div>

<div class="col-md-6">
    <x-form.input type="text" name="phone" value="{{$vendor->phone ?? ''}}" label="{{ trans('admin.vendors.phone') }}" required />
</div>

<div class="col-md-6">
    <x-form.input type="text" name="another_phone" value="{{$vendor->another_phone ?? ''}}" label="{{ trans('admin.vendors.another_phone') }}"  required/>
</div>

<div class="col-md-6">
    <x-form.input type="email" name="email" value="{{$vendor->email ?? ''}}" label="{{ trans('admin.vendors.email') }}" required />
</div>

<div class="col-md-6">
    <x-form.input type="url" name="website" value="{{$vendor->website ?? ''}}" label="{{ trans('admin.vendors.website') }}" />
</div>

<div class="col-md-6">
    <x-form.input type="text" name="description" value="{{$vendor->description ?? ''}}" label="{{ trans('admin.vendors.description') }}" required />
</div>

<div class="col-md-6">
    <x-form.input type="number" name="commercial_registration_number" value="{{$vendor->commercial_registration_number ?? ''}}" label="{{ trans('admin.vendors.commercial_registration_number') }}" required />
</div>

<div class="col-md-6">
    <x-form.input type="date" name="expire_date_commercial_registration" value="{{ \Carbon\Carbon::parse($vendor->expire_date_commercial_registration)->format('Y-m-d') ?? ''}}" label="{{ trans('admin.vendors.expire_date_commercial_registration') }}" required />
</div>

<div class="col-lg-6">
    <x-form.input type="file" name="logo" value="{{$vendor->logo ?? ''}}"
                  label="{{ trans('admin.vendors.image') }}" accept="image/png, image/jpeg, image/gif" />
    @if(isset($vendor->logo))
    <div class="p-1">
        <img src="{{ $vendor->logo }}" alt="" height="120" width="120">
    </div>
    @endif
</div> <!-- end col -->
<div class="col-lg-6">
    <x-form.input type="file" name="image_commercial" value="{{$vendor->image_commercial ?? ''}}"
                  label="{{ trans('admin.vendors.image_commercial') }}" accept="image/png, image/jpeg, image/gif" />
    @if(isset($vendor->image_commercial))
    <div class="p-1">
        <img src="{{ $vendor->image_commercial }}" alt="" height="120" width="120">
    </div>
    @endif
</div> <!-- end col -->
<div class="col-lg-6">
    <x-form.input type="file" name="image_iban" value="{{$vendor->image_iban ?? ''}}"
                  label="{{ trans('admin.vendors.image_iban') }}" accept="image/png, image/jpeg, image/gif" />
    @if(isset($vendor->image_iban))
    <div class="p-1">
        <img src="{{ $vendor->image_iban }}" alt="" height="120" width="120">
    </div>
    @endif
</div> <!-- end col -->
<div class="col-lg-6">
    <x-form.input type="file" name="image_mark" value="{{$vendor->image_mark ?? ''}}"
                  label="{{ trans('admin.vendors.image_mark') }}" accept="image/png, image/jpeg, image/gif" />
    @if(isset($vendor->image_mark))
    <div class="p-1">
        <img src="{{ $vendor->image_mark }}" alt="" height="120" width="120">
    </div>
    @endif
</div> <!-- end col -->
<div class="col-lg-6">
    <x-form.input type="file" name="image_tax" value="{{$vendor->image_tax ?? ''}}"
                  label="{{ trans('admin.vendors.image_tax') }}" accept="image/png, image/jpeg, image/gif" />
    @if(isset($vendor->image_tax))
    <div class="p-1">
        <img src="{{ $vendor->image_tax }}" alt="" height="120" width="120">
    </div>
    @endif
</div> <!-- end col -->

<div class="col-md-6">
    <x-form.radio name="status" value="{{$vendor->status ?? ''}}" label="{{trans('admin.status')}}"
                  :options="['approved'=>'نشط','not_approved'=>'غير نشط','pending'=>' جاري']" required checked="{{$vendor->status ?? ''}}" selected="{{$vendor->status ?? ''}}"/>
</div>
<button type="submit" class="btn btn-lg btn-primary">{{$button_label ?? 'Save'}}</button>
@section('script')
    <script src="{{ URL::asset('build/libs/dropzone/dropzone-min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
    <script src="{{ URL::asset('build/js/pages/form-validation.init.js') }}"></script>
    <script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
