@extends('layouts.master')
@section('title')
    @lang('admin.send-vendor-agreement')
@endsection
@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet"/>

@endsection
@section('content')
@component('components.breadcrumb')
        @slot('li_1')
            @lang('admin.vendors.vendors')
        @endslot
        @slot('title')
        @lang('admin.vendors-agreements')
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-8 offset-2">
            <div class="card">
                <div class="card-body">
                    @if(session()->has("error"))
                        <div class="alert alert-danger mt-3"> {{ session()->get("error") }} </div>
                    @endif
                    @if(session()->has("success"))
                        <div class="alert alert-success mt-3"> {{ session()->get("success") }} </div>
                    @endif
                    <form class="needs-validation row"
                          method="POST"
                          action="{{ route('dashboard.vendors-agreements.send') }}"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="form-control mb-3" style="border: none">
                            <label for="bank_id" class="form-label">
                                @lang('admin.vendors-agreements-keys.vendor-name') <span class="text-danger">*</span>
                            </label>
                            <select class="form-control" name="vendor_id" data-choices data-choices-search-true>
                                <option value=""> @lang('admin.vendors-agreements-keys.select-vendor') </option>
                                @foreach ($vendors ?? [] as $vendor)
                                    <option value="{{ $vendor->id }}" @selected($vendor->id == old('vendor_id'))>
                                        {{ $vendor->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('vendor_id')
                                <span class="text-danger" role="alert"> <strong>{{ $message }}</strong> </span>
                            @enderror
                        </div>
                        <div class="form-control mb-3" style="border: none">
                            <label for="username" class="form-label">
                                @lang('admin.vendors-agreements-keys.agreement') <span class="text-danger">*</span>
                            </label>
                            <input type="file" class="form-control" name="agreement_pdf">
                            @error('agreement_pdf')
                                <span class="text-danger" role="alert"> <strong>{{ $message }}</strong> </span>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">@lang('admin.vendors-agreements-keys.send')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('build/libs/dropzone/dropzone-min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
    <script src="{{ URL::asset('build/js/pages/form-validation.init.js') }}"></script>
    <script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
