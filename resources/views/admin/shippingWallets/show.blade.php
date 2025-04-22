@extends('layouts.master')
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
            @lang('admin.shippingWallets.show_shippingWallet')
        @endslot
        @slot('title')
            @lang('admin.shippingWallets.show_shippingWallet')
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-sm-flex align-items-center">
                        <div class="flex-shrink-0 mt-2 mt-sm-0" style="margin-left: 2px">
                            <div class="flex-shrink-0 mt-2 mt-sm-0">
                                <a href="javasccript:void(0;)"
                                   class="btn btn-soft-success btn-sm mt-2 mt-sm-0"
                                   type="button"
                                   data-bs-toggle="modal"
                                   data-bs-target="#myModalIn">
                                    <i class="ri-add-line align-middle me-1"></i> @lang('admin.shippingWallets.add_balance')
                                </a>
                            </div>
                        </div>
                        <div class="flex-shrink-0 mt-2 mt-sm-0">
                            <div class="flex-shrink-0 mt-2 mt-sm-0">
                                <a href="javasccript:void(0;)"
                                   class="btn btn-soft-danger btn-sm mt-2 mt-sm-0"
                                   type="button"
                                   data-bs-toggle="modal"
                                   data-bs-target="#myModalOut">
                                    <i class="ri-subtract-line align-middle me-1"></i> @lang('admin.shippingWallets.balance_deduction')
                                </a>
                            </div>
                        </div>
                        <br>
                    </div>
                </div>
            </div>
            <!-- Default Modals -->
            <div id="myModalIn" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
                 style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myModalLabel"> @lang('admin.vendorWallets.add_balance')</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            {{-- <h5 class="fs-15"> Overflowing text to show scroll behavior </h5> --}}
                            <div class="row">
                                <div class="col-sm-12">
                                    <form action="{{ route('dashboard.shipping-wallets.add_balance') }}" method="post">
                                        @csrf
                                        <input type="number" name="amount" class="form-control mb-2" required>
                                        <input type="hidden" name="shipping_wallet_id"
                                               value="{{ $shippingWallet->id }}">
                                        <button class="btn btn-success" type="submit"> @lang('admin.btn.add') </button>
                                    </form>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            {{-- <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button> --}}
                            {{-- <button type="button" class="btn btn-primary ">Save Changes</button> --}}
                        </div>

                    </div><!-- /.modal-content -->
                </div>
            </div>
            <div id="myModalOut" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
                 style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"
                                id="myModalLabel"> @lang('admin.vendorWallets.balance_deduction')</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            {{-- <h5 class="fs-15"> Overflowing text to show scroll behavior </h5> --}}
                            <div class="row">
                                <div class="col-sm-12">
                                    <form action="{{ route('dashboard.shipping-wallets.balance_deduction') }}"
                                          method="post">
                                        @csrf
                                        <input type="hidden" name="shipping_wallet_id"
                                               value="{{ $shippingWallet->id }}">

                                        <input type="number" name="amount" class="form-control mb-2" required>
                                        <button class="btn btn-danger"
                                                type="submit">  @lang('admin.shippingWallets.balance_deduction')  </button>
                                    </form>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            {{-- <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button> --}}
                            {{-- <button type="button" class="btn btn-primary ">Save Changes</button> --}}
                        </div>

                    </div><!-- /.modal-content -->
                </div>
            </div>
            <div class="card-body">
                <h5 class="card-title flex-grow-1 mb-0">@lang('admin.shippingWallets.shipping_method')
                    : {{$shippingWallet->shipping_method->translations[0]->name}} </h5>
                <h5 class="card-title flex-grow-1 mb-0">@lang('admin.shippingWallets.balance')
                    : {{$shippingWallet->balance}} </h5>
                <hr>

                <table id="buttons-datatables" class="display table table-bordered" style="width:100%">
                    <thead class="text-muted table-light">
                    <tr>
                        <th>@lang('admin.shippingWallets.shipping_wallet_id')</th>
                        <th>@lang('admin.shippingWallets.amount')</th>
                        <th>@lang('admin.shippingWallets.operation_type')</th>
                        <th>@lang('admin.shippingWallets.receipt_url')</th>
                        <th>@lang('admin.shippingWallets.reference')</th>
                        <th>@lang('admin.shippingWallets.reference_id')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($shippingWallet->shipping_wallet_transactions as  $transaction)
                        <tr>
                            <td>{{$transaction->shipping_wallet_id}}</td>
                            <td>{{$transaction->amount}}</td>
                            <td>
                                @if($transaction->operation_type == "in")
                                   <span class="text-success"> @lang('admin.btn.add')</span>
                                @else
                                    <span class="text-danger"> @lang('admin.shippingWallets.balance_deduction')</span>
                                @endif
                                    </td>
                            <td>{{$transaction->receipt_url}}</td>
                            <td>{{$transaction->reference}}</td>
                            <td>{{$transaction->reference_id}}</td>
                        </tr>
                    @empty
                        <td>@lang('admin.empty_data')</td>
                    @endforelse
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
