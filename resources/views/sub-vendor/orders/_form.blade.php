@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet"/>

@endsection
<div class="col-md-6">
    <x-form.select name="country_id" :options="$countries" label="{{ trans('admin.countries.name') }}"
                   selected="{{$order->country_id ?? ''}}" required></x-form.select>
</div>
<div class="col-md-6">
    <x-form.select name="bank_id" :options="$banks" label="{{ trans('admin.banks.name') }}"
                   selected="{{$order->bank_id ?? ''}}" required></x-form.select>
</div>

<div class="col-md-6">
    <x-form.input type="text" name="name" value="{{$order->name ?? ''}}" label="{{ trans('admin.orders.name') }}"
                  required/>
</div>

<div class="col-md-6">
    <x-form.input type="text" name="street" value="{{$order->street ?? ''}}" label="{{ trans('admin.orders.street') }}"
                  required/>
</div>

<div class="col-md-6">
    <x-form.input type="number" name="bank_account_number" value="{{$order->bank_account_number ?? ''}}"
                  label="{{ trans('admin.orders.bank_account_number') }}" required/>
</div>

<div class="col-md-6">
    <x-form.input type="number" name="iban" value="{{$order->iban ?? ''}}" label="{{ trans('admin.orders.iban') }}"
                  required/>
</div>

<div class="col-md-6">
    <x-form.input type="text" name="phone" value="{{$order->phone ?? ''}}" label="{{ trans('admin.orders.phone') }}"
                  required/>
</div>

<div class="col-md-6">
    <x-form.input type="text" name="another_phone" value="{{$order->another_phone ?? ''}}"
                  label="{{ trans('admin.orders.another_phone') }}" required/>
</div>

<div class="col-md-6">
    <x-form.input type="email" name="email" value="{{$order->email ?? ''}}" label="{{ trans('admin.orders.email') }}"
                  required/>
</div>

<div class="col-md-6">
    <x-form.input type="url" name="website" value="{{$order->website ?? ''}}"
                  label="{{ trans('admin.orders.website') }}"/>
</div>

<div class="col-md-6">
    <x-form.input type="text" name="description" value="{{$order->description ?? ''}}"
                  label="{{ trans('admin.orders.description') }}" required/>
</div>

<div class="col-md-6">
    <x-form.input type="number" name="commercial_registration_number"
                  value="{{$order->commercial_registration_number ?? ''}}"
                  label="{{ trans('admin.orders.commercial_registration_number') }}" required/>
</div>

<div class="col-md-6">
    <x-form.input type="date" name="expire_date_commercial_registration"
                  value="{{ \Carbon\Carbon::parse($order->expire_date_commercial_registration)->format('Y-m-d') ?? ''}}"
                  label="{{ trans('admin.orders.expire_date_commercial_registration') }}" required/>
</div>

<div class="col-lg-6">
    <x-form.input type="file" name="logo" value="{{$order->logo ?? ''}}"
                  label="{{ trans('admin.orders.image') }}" accept="image/png, image/jpeg, image/gif"/>
    @if(isset($order->logo))
        <div class="p-1">
            <img src="{{ $order->logo }}" alt="" height="120" width="120">
        </div>
    @endif
</div> <!-- end col -->
<div class="col-lg-6">
    <x-form.input type="file" name="image_commercial" value="{{$order->image_commercial ?? ''}}"
                  label="{{ trans('admin.orders.image_commercial') }}" accept="image/png, image/jpeg, image/gif"/>
    @if(isset($order->image_commercial))
        <div class="p-1">
            <img src="{{ $order->image_commercial }}" alt="" height="120" width="120">
        </div>
    @endif
</div> <!-- end col -->
<div class="col-lg-6">
    <x-form.input type="file" name="image_iban" value="{{$order->image_iban ?? ''}}"
                  label="{{ trans('admin.orders.image_iban') }}" accept="image/png, image/jpeg, image/gif"/>
    @if(isset($order->image_iban))
        <div class="p-1">
            <img src="{{ $order->image_iban }}" alt="" height="120" width="120">
        </div>
    @endif
</div> <!-- end col -->
<div class="col-lg-6">
    <x-form.input type="file" name="image_mark" value="{{$order->image_mark ?? ''}}"
                  label="{{ trans('admin.orders.image_mark') }}" accept="image/png, image/jpeg, image/gif"/>
    @if(isset($order->image_mark))
        <div class="p-1">
            <img src="{{ $order->image_mark }}" alt="" height="120" width="120">
        </div>
    @endif
</div> <!-- end col -->
<div class="col-lg-6">
    <x-form.input type="file" name="image_tax" value="{{$order->image_tax ?? ''}}"
                  label="{{ trans('admin.orders.image_tax') }}" accept="image/png, image/jpeg, image/gif"/>
    @if(isset($order->image_tax))
        <div class="p-1">
            <img src="{{ $order->image_tax }}" alt="" height="120" width="120">
        </div>
    @endif
</div> <!-- end col -->

<div class="col-md-6">
    <x-form.radio name="status" value="{{$order->status ?? ''}}" label="{{trans('admin.status')}}"
                  :options="['approved'=>'نشط','not_approved'=>'غير نشط','pending'=>' جاري']" required
                  checked="{{$order->status ?? ''}}" selected="{{$order->status ?? ''}}"/>
</div>
<button type="submit" class="btn btn-lg btn-primary">{{$button_label ?? 'Save'}}</button>
@section('script')
    <script src="{{ URL::asset('build/libs/dropzone/dropzone-min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
    <script src="{{ URL::asset('build/js/pages/form-validation.init.js') }}"></script>
    <script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
