@extends('layouts.vendor.master')
@section('title')
    @lang('vendor.vendorWallets.manage_vendorWallets')
@endsection
@section('css')
    <!--datatable css-->
    <link href="{{ URL::asset('build/datatables/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <!--datatable responsive css-->
    <link href="{{ URL::asset('build/datatables/responsive.bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('build/datatables/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('vendor.vendorWallets.show_vendorWallet')
        @endslot
        @slot('title')
            @lang('vendor.vendorWallets.show_vendorWallet')
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-sm-flex align-items-center">
                        <div class="flex-shrink-0 mt-2 mt-sm-0">
                            <a href="javasccript:void(0;)" class="btn btn-soft-primary btn-sm mt-2 mt-sm-0"><i
                                    class="ri-map-pin-line align-middle me-1"></i> @lang('vendor.vendorWallets.manage_vendorWallets') </a>
                        </div><br>

                    </div>
                </div>
                <div class="card-body">
                    <h5 class="card-title flex-grow-1 mb-0">@lang('admin.vendorWallets.vendor') : {{ $vendor->name ?? '' }} </h5>
                    <h5 class="card-title flex-grow-1 mb-0">@lang('admin.vendorWallets.balance') : {{ $vendorWallet->balance ?? 0 }} </h5>
                    <hr>

                    <table id="buttons-datatables" class="display table table-bordered" style="width:100%">
                        <thead class="text-muted table-light">
                            <tr>
                                <th>@lang('admin.vendorWallets.vendor_wallet_id')</th>
                                <th>@lang('admin.vendorWallets.amount')</th>
                                <th>@lang('admin.vendorWallets.operation_type')</th>
                                {{--  <th>@lang('admin.vendorWallets.receipt_url')</th>
                            <th>@lang('admin.vendorWallets.reference')</th>
                            <th>@lang('admin.vendorWallets.reference_id')</th>  --}}
                            </tr>
                        </thead>
                        <tbody>
                            @if ($vendorWallet)
                                @if ($vendorWallet->vendor_wallet_transactions->count() > 0)
                                    @foreach ($vendorWallet->vendor_wallet_transactions as $vendorWalletTransaction)
                                        <tr>
                                            <td>{{ $vendorWalletTransaction->vendor_wallet_id }}</td>
                                            <td>{{ $vendorWalletTransaction->amount }}</td>
                                            <td>{{ \App\Enums\VendorWallet::getTypeWithClass($vendorWalletTransaction->operation_type)['name'] }}
                                            </td>
                                            {{--  <td>{{$vendorWalletTransaction->receipt_url}}</td>
                                        <td>{{$vendorWalletTransaction->reference}}</td>
                                        <td>{{$vendorWalletTransaction->reference_id}}</td>  --}}
                                        </tr>
                                    @endforeach
                                @else
                                    <td>@lang('admin.empty_data')</td>
                                @endif
                            @endif
                    </table>
                </div>
            </div>
            <!--end card-->
        </div>
        <!--end col-->
    </div>
    <!--end row-->
@endsection
@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script src="{{ URL::asset('build/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('build/datatables/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ URL::asset('build/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('build/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('build/datatables/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('build/datatables/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('build/datatables/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('build/datatables/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('build/datatables/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/datatables.init.js') }}"></script>

    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/sweetalerts.init.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
<x-form.alert-data></x-form.alert-data>
