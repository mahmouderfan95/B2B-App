@extends('layouts.shipping.master')
@section('title')
    @lang('admin.shippingWallets.manage_shippingWallets')
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
            @lang('admin.shippingWallets.shippingWallets')
        @endslot
        @slot('title')
            @lang('admin.shippingWallets.manage_shippingWallets')
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <table id="buttons-datatables" class="display table table-bordered" style="width:100%">
                        <thead class="text-muted table-light">
                        <tr>
                            <th>@lang('admin.shippingWallets.id')</th>
                            <th>@lang('admin.shippingWallets.shipping_method')</th>
                            <th>@lang('admin.shippingWallets.balance')</th>
                            <th>@lang('admin.shippingWallets.shipping_wallet_transactions')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($shippingWallets as  $shippingWallet)
                            <tr>
                                <td>{{$shippingWallet->id}}</td>
                                <td>{{$shippingWallet->shipping_method->translations[0]->name}}</td>
                                <td>{{$shippingWallet->balance}}</td>
                                <td>
                                    <a href="{{route('dashboard.shipping-wallets.show',$shippingWallet->id)}}"
                                       class="dropdown-item edit-item-btn"><i
                                            class="ri-eye-2-fill align-bottom me-2 text-muted"></i>
                                        @lang('admin.show')</a>
                                </td>
                            </tr>
                        @empty
                            <td>@lang('admin.empty_data')</td>
                        @endforelse
                    </table>
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
