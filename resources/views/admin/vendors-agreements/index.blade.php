@extends('layouts.master')
@section('title')
    @lang('admin.vendors-agreements')
@endsection
@section('css')
    <!--datatable css-->
    <link href="{{URL::asset('build/datatables/dataTables.bootstrap5.min.css')}}" rel="stylesheet" type="text/css"/>
    <!--datatable responsive css-->
    <link href="{{URL::asset('build/datatables/responsive.bootstrap.min.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{URL::asset('build/datatables/buttons.dataTables.min.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css"/>
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
        <div class="col-lg-12">

            @if(session()->has("error"))
                <div class="alert alert-danger mt-3"> {{ session()->get("error") }} </div>
            @endif
            @if(session()->has("success"))
                <div class="alert alert-success mt-3"> {{ session()->get("success") }} </div>
            @endif
            <div class="card">
                <div class="card-header">

                    <a class="btn btn-primary" href="{{ route('dashboard.vendors-agreements.send-form') }}"><i class="bx bx-cross"></i>@lang('admin.send-vendor-agreement')</a>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form>
                        <div class="row g-3">
                            <div class="col-xxl-3 col-sm-4">
                                <select name="vendor" class="form-control" data-choices data-choices-search-true>
                                    <option value=""> @lang("admin.vendors-agreements-keys.select-vendor") </option>
                                    @foreach($vendors ?? [] as $vendor)
                                        <option value="{{ $vendor->id }}" @selected($vendor->id == request()->get('vendor'))>
                                            {{ $vendor->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-xxl-3 col-sm-4">
                                <select name="status" class="form-control" data-choices data-choices-search-false name="choices-single-default">
                                    <option value=""> @lang("admin.vendors-agreements-keys.select-status") </option>
                                    @foreach($statuses ?? [] as $key => $value)
                                        <option value="{{ $key }}" @selected($key == request()->get('status'))>
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-xxl-1 col-sm-4">
                                <div>
                                    <button type="submit" class="btn btn-secondary w-100">
                                        <i class="ri-equalizer-fill me-1 align-bottom"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <table class="table table-nowrap align-middle" id="productsTable">
                        <thead class="text-muted table-light">
                        <tr class="text-uppercase">
                            <th scope="col">#</th>
                            <th scope="col">@lang('admin.vendors-agreements-keys.vendor-name')</th>
                            <th scope="col">@lang('admin.vendors-agreements-keys.status')</th>
                            <th scope="col">@lang('admin.vendors-agreements-keys.agreement-pdf')</th>
                            <th scope="col">@lang('admin.vendors-agreements-keys.agreement-approved-pdf')</th>
                            <th scope="col">@lang('admin.vendors-agreements-keys.approved-at')</th>
                            <th scope="col">@lang('admin.vendors-agreements-keys.approved-by')</th>
                            <th scope="col">@lang('admin.actions')</th>
                        </tr>
                        </thead>
                         <tbody class="list form-check-all">
                        @foreach ($collection ?? [] as $row)
                            <tr>
                                <td>{{ $row->id }}</td>
                                <td>{{ $row->vendor?->name }}</td>
                                <td>{{ __('admin.vendors-agreements-keys.'. $row->status) }}</td>
                                <td>
                                    <a href="{{ $row->agreement_pdf }}" target="_blank">
                                        @lang('admin.vendors-agreements-keys.download') {{ $row->agreement_pdf_name }}
                                    </a>
                                </td>
                                <td>
                                    @if($row->approved_pdf)
                                        <a href="{{ $row->approved_pdf }}" target="_blank">
                                            @lang('admin.vendors-agreements-keys.download') {{ $row->approved_pdf_name }}
                                        </a>
                                    @else
                                        {{ __("admin.no_data") }}
                                    @endif
                                </td>
                                <td>{{ $row->approved_at?->format("Y-m-d H:s") ?? __("admin.no_data") }}</td>
                                <td>{{ $row->approvedBy?->name ?? __("admin.no_data") }}</td>
                                <td>
                                    @if($row->status == \App\Enums\VendorAgreementEnum::PENDING)
                                        <form method="POST" action="{{ route("dashboard.vendors-agreements.cancel", ['agreement' => $row]) }}">
                                            @csrf
                                            @method("PUT")
                                            <button class="btn btn-danger" title="@lang('admin.vendors-agreements-keys.cancel-agreement')">
                                                <i class="ri-forbid-fill"></i>
                                            </button>
                                        </form>
                                    @endif
                                    @if($row->status == \App\Enums\VendorAgreementEnum::CANCELED)
                                        <form method="POST" action="{{ route("dashboard.vendors-agreements.resend", ['agreement' => $row]) }}">
                                            @csrf
                                            @method("PUT")
                                            <button class="btn btn-info" title="@lang('admin.vendors-agreements-keys.resend-agreement')">
                                                <i class="ri-send-backward"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{-- {{ $collection->appends(request()->query())->links() }} --}}
                </div>

                <div class="d-flex justify-content-end">
                    <div class="pagination-wrap hstack gap-2">
                        {{ $collection->appends(request()->query())->links("pagination::bootstrap-4") }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script src="{{URL::asset('build/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('build/datatables/dataTables.bootstrap5.min.js')}}"></script>
    <script src="{{URL::asset('build/datatables/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('build/datatables/dataTables.buttons.min.js')}}"></script>
    <script src="{{URL::asset('build/datatables/buttons.print.min.js')}}"></script>
    <script src="{{URL::asset('build/datatables/buttons.html5.min.js')}}"></script>
    <script src="{{URL::asset('build/datatables/vfs_fonts.js')}}"></script>
    <script src="{{URL::asset('build/datatables/pdfmake.min.js')}}"></script>
    <script src="{{URL::asset('build/datatables/jszip.min.js')}}"></script>
    <script src="{{ URL::asset('build/js/pages/datatables.init.js') }}"></script>

    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/sweetalerts.init.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>

@endsection
<x-form.alert-data></x-form.alert-data>
