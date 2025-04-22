@extends('layouts.vendor.master')
@section('title')
    @lang('admin.orders.manage_orders')
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
            @lang('admin.orders.show_orders')
        @endslot
        @slot('title')
            @lang('admin.orders.show_orders')
        @endslot
    @endcomponent
<!-- Default Modals -->
<div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel"> @lang('admin.orders.order_status_change')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
            </div>
            @if ($order->status == App\Enums\OrderStatus::REGISTERD)
                <div class="modal-body">
                    {{-- <h5 class="fs-15"> Overflowing text to show scroll behavior </h5> --}}
                    {{-- <div class="row">
                        <div class="col-sm-2">
                            <form action="{{ route('vendor.orders.public.approve', $order->id )}}" method="post">
                                @csrf
                                <button class="btn btn-success" type="submit"> @lang('admin.btn.approve') </button>
                            </form>
                        </div>
                        <div class="col-sm-2">
                            <form action="{{ route('vendor.orders.public.reject', $order->id )}}" method="post">
                                @csrf
                                <button class="btn btn-danger" type="submit"> @lang('admin.btn.reject') </button>
                            </form>
                        </div>
                    </div> --}}

                    <div class="row">
                        <form action="{{ route('vendor.orders.public.approve', $order->id )}}" method="post">
                            @csrf
                            <input type="text" name="quotation_price">
                            <input type="date" name="expect_date_from">
                            <input type="date" name="expect_date_to">
                            <button class="btn btn-success" type="submit"> @lang('admin.btn.approve') </button>
                        </form>
                    </div>
                    <div class="col-sm-2">
                        <form action="{{ route('vendor.orders.public.reject', $order->id )}}" method="post">
                            @csrf
                            <button class="btn btn-danger" type="submit"> @lang('admin.btn.reject') </button>
                        </form>
                    </div>

                </div>
                @elseif ($order->status != App\Enums\OrderStatus::PAID30)
                    <div class="modal-body">

                        <div class="col-sm-4">
                            <form action="{{ route('vendor.orders.public.getshippingReady', $order->id )}}" method="post">
                                @csrf
                                <button class="btn btn-success" type="submit"> @lang('admin.btn.shipping-ready') </button>
                            </form>
                        </div>
                    </div>
                @endif
            <div class="modal-footer">
                {{-- <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button> --}}
                {{-- <button type="button" class="btn btn-primary ">Save Changes</button> --}}
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
    <div class="row">
        <div class="col-xl-9">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title flex-grow-1 mb-0">@lang('admin.orders.show_orders') #{{$order->id}}</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive table-card">
                        <table class="table table-nowrap align-middle table-borderless mb-0">
                            <thead class="table-light text-muted">
                            <tr>
                                <th scope="col">@lang('admin.orders.product_details')</th>
                                <th scope="col">@lang('admin.orders.price_unit') </th>
                                <th scope="col">@lang('admin.orders.quantity')</th>
                                <th scope="col" class="text-end">@lang('admin.orders.price_total')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $total_vendor_price = 0;
                            @endphp
                            @foreach($order->products as $product)

                                <tr>
                                    <td>
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 avatar-md bg-light rounded p-1">
                                                <img src="{{ $product->image }}" alt=""
                                                     class="img-fluid d-block">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h5 class="fs-15">
                                                    {{$product->translations[0]->name}}

                                                </h5>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{$product->pivot->unit_price}}</td>
                                    <td>{{$product->pivot->quantity}}</td>
                                    <td class="fw-medium text-end">
                                        {{$product->pivot->total}}
                                    </td>
                                    @php $total_vendor_price += $product->pivot->total @endphp
                                </tr>
                            @endforeach
                            <tr class="border-top border-top-dashed">
                                <td colspan="3"></td>
                                <td colspan="2" class="fw-medium p-0">
                                    <table class="table table-borderless mb-0">
                                        <tbody>
                                       {{-- <tr>
                                            <td>@lang('admin.orders.sub_total') :</td>
                                            <td class="text-end">{{$order->sub_total}}</td>
                                        </tr>
                                        <tr>
                                            <td>@lang('admin.orders.tax') :</td>
                                            <td class="text-end">{{$order->tax}}</td>
                                        </tr>
                                        <tr>
                                            <td>@lang('admin.orders.vat') :</td>
                                            <td class="text-end">{{$order->vat}}</td>
                                        </tr>--}}
                                        <tr class="border-top border-top-dashed">
                                            <th scope="row">@lang('admin.orders.total') :</th>
                                            <td class="text-end">{{$total_vendor_price}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--end card-->
            <div class="card">
                <div class="card-header">
                    <div class="d-sm-flex align-items-center">
                        <h5 class="card-title flex-grow-1 mb-0">@lang('admin.orders.order_status') </h5>
                        <div class="flex-shrink-0 mt-2 mt-sm-0">
                            <a href="javasccript:void(0;)"
                            class="btn btn-soft-primary btn-sm mt-2 mt-sm-0"
                            type="button"
                            data-bs-toggle="modal"
                            data-bs-target="#myModal">
                            <i class="ri-map-pin-line align-middle me-1"></i> @lang('admin.orders.order_status_change')  </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="profile-timeline">
                        <div class="accordion accordion-flush" id="accordionFlushExample">
                            <div class="accordion-item border-0">
                                <div class="accordion-header" id="headingFive">
                                    <a class="accordion-button p-2 shadow-none" data-bs-toggle="collapse"
                                       href="#collapseFile" aria-expanded="false">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 avatar-xs">
                                                <div class="avatar-title bg-light text-primary rounded-circle">
                                                    <i class="mdi mdi-package-variant"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="fs-14 mb-0 fw-semibold">{{$order->status}}</h6>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!--end accordion-->
                    </div>
                </div>
            </div>
            <!--end card-->
        </div>
        <!--end col-->
        <div class="col-xl-3">

            <div class="card">
                <div class="card-header">
                    <div class="d-flex text-center">
                        <h5 class="card-title flex-grow-1 mb-0"> @lang('admin.orders.client_details')</h5>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0 vstack gap-3">
                        <li>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <img src="{{$order->client->image}}" alt=""
                                         class="avatar-sm rounded">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="fs-14 mb-1">{{$order->client->name}}</h6>
                                    <p class="text-muted mb-0"> @lang('admin.orders.shipping_details') </p>
                                </div>
                            </div>
                        </li>
                        <li><i class="ri-mail-line me-2 align-middle text-muted fs-16"></i> {{$order->client->email}}</li>
                        <li><i class="ri-phone-line me-2 align-middle text-muted fs-16"></i>{{$order->client->phone}}</li>
                    </ul>
                </div>
            </div>
            <!--end card-->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="ri-map-pin-line align-middle me-1 text-muted"></i>  @lang('admin.orders.shipping_details')</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled vstack gap-2 fs-13 mb-0">
                        <li class="fw-medium fs-14">{{$order->client->name}}</li>
                        <li>{{$order->client_address->phone}}</li>
                        <li>{{$order->client_address->address}}</li>
                    </ul>
                </div>
            </div>
            <!--end card-->

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="ri-secure-payment-line align-bottom me-1 text-muted"></i>
                        @lang('admin.orders.payment_details')</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="flex-shrink-0">
                            <p class="text-muted mb-0">@lang('admin.orders.transactions'): </p>
                        </div>
                        <div class="flex-grow-1 ms-2">
                            <h6 class="mb-0">{{$order->transaction_id}}</h6>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <div class="flex-shrink-0">
                            <p class="text-muted mb-0">@lang('admin.orders.payment_method'):</p>
                        </div>
                        <div class="flex-grow-1 ms-2">
                            <h6 class="mb-0">{{$order->payment_method}}</h6>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <p class="text-muted mb-0">@lang('admin.orders.total'):</p>
                        </div>
                        <div class="flex-grow-1 ms-2">
                            <h6 class="mb-0">{{$order->total}}</h6>
                        </div>
                    </div>
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
