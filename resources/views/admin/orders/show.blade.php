@extends('layouts.master')
@section('title')
    @lang('admin.orders.manage_orders')
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
            @lang('admin.orders.show_orders')
        @endslot
        @slot('title')
            @lang('admin.orders.show_orders')
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-xl-9">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title flex-grow-1 mb-0">@lang('admin.orders.show_orders') #{{ $order->id }}</h5>
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
                                    <th scope="col">@lang('admin.vendors.name')</th>
                                    <th scope="col" class="text-end">@lang('admin.orders.price_total')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->products as $product)
                                    <tr>
                                        <td>
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 avatar-md bg-light rounded p-1">
                                                    <img src="{{ $product->image }}" alt=""
                                                        class="img-fluid d-block">
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h5 class="fs-15">
                                                        {{ $product->translations[0]->name }}
                                                    </h5>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $product->pivot->unit_price }}</td>
                                        <td>{{ $product->pivot->quantity }}</td>
                                        <td>{{ $product->vendor->name }}</td>
                                        <td class="fw-medium text-end">
                                            {{ $product->pivot->total }}
                                        </td>
                                    </tr>
                                @endforeach
                                <tr class="border-top border-top-dashed">
                                    <td colspan="3"></td>
                                    <td colspan="2" class="fw-medium p-0">
                                        <table class="table table-borderless mb-0">
                                            <tbody>
                                                <tr>
                                                    <td>@lang('admin.orders.sub_total') :</td>
                                                    <td class="text-end">{{ $order->sub_total }}</td>
                                                </tr>
                                                <tr>
                                                    <td>@lang('admin.orders.delivery_fees') :</td>
                                                    <td class="text-end">{{ $order->delivery_fees ?? 0 }}</td>
                                                </tr>
                                                {{--  <tr>
                                                    <td>@lang('admin.orders.vat') :</td>
                                                    <td class="text-end">{{ $order->vat }}</td>
                                                </tr>  --}}
                                                <tr class="border-top border-top-dashed">
                                                    <th scope="row">@lang('admin.orders.total') :</th>
                                                    <td class="text-end">{{ $order->total }}</td>
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
                            <a class="btn btn-soft-primary btn-sm mt-2 mt-sm-0"data-bs-toggle="modal"
                                data-bs-target="#staticBackdrop"><i class="ri-map-pin-line align-middle me-1"></i>
                                @lang('admin.orders.order_status_change') </a>
                        </div>
                    </div>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
                    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">@lang('admin.orders.order_status')</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('dashboard.orders.update', $order->id) }}" method="POST">
                                    @csrf
                                    @method('put')
                                    <select name="status" class="form-select form-select-md"
                                        aria-label=".form-select-sm example">
                                        @if ($order->status == 'paid' || $order->status == 'delivered' || $order->status == 'shipping_done')
                                            <option @selected($order->status == 'paid') value="paid">@lang('orderStatus.paid')</option>
                                            <option @selected($order->status == 'delivered') value="delivered">@lang('orderStatus.delivered')
                                            </option>
                                            <option @selected($order->status == 'shipping_done') value="shipping_done">@lang('orderStatus.shipping_done')
                                            </option>
                                        @else
                                            <option @selected($order->status == 'registered') value="registered">@lang('orderStatus.registered')
                                            </option>
                                            <option @selected($order->status == 'in_shipping') value="in_shipping">@lang('orderStatus.in_shipping')
                                            </option>
                                            <option @selected($order->status == 'in_delivery') value="in_delivery">@lang('orderStatus.in_delivery')
                                            </option>
                                        @endif
                                        {{--  <option @selected($order->status == 'completed') value="completed">@lang('orderStatus.completed')</option>  --}}
                                    </select>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger"
                                            data-bs-dismiss="modal">@lang('admin.close')</button>
                                        <button type="submit" class="btn btn-primary">@lang('admin.save')</button>
                                    </div>
                                </form>
                            </div>
                        </div>
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
                                    <img src="{{ $order->client->image }}" alt="" class="avatar-sm rounded">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="fs-14 mb-1">{{ $order->client->name }}</h6>
                                    <p class="text-muted mb-0"> @lang('admin.orders.shipping_details') </p>
                                </div>
                            </div>
                        </li>
                        <li><i class="ri-mail-line me-2 align-middle text-muted fs-16"></i> {{ $order->client->email }}
                        </li>
                        <li><i class="ri-phone-line me-2 align-middle text-muted fs-16"></i>{{ $order->client->phone }}
                        </li>
                    </ul>
                </div>
            </div>
            <!--end card-->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="ri-map-pin-line align-middle me-1 text-muted"></i>
                        @lang('admin.orders.shipping_details')</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled vstack gap-2 fs-13 mb-0">
                        <li class="fw-medium fs-14">{{ $order->client->name }}</li>
                        <li>{{ $order->client_address->phone }}</li>
                        <li>{{ $order->client_address->address }}</li>
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
                            <h6 class="mb-0">{{ $order->transaction_id }}</h6>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <div class="flex-shrink-0">
                            <p class="text-muted mb-0">@lang('admin.orders.payment_method'):</p>
                        </div>
                        <div class="flex-grow-1 ms-2">
                            <h6 class="mb-0">{{ $order->payment_method }}</h6>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <p class="text-muted mb-0">@lang('admin.orders.total'):</p>
                        </div>
                        <div class="flex-grow-1 ms-2">
                            <h6 class="mb-0">{{ $order->total }}</h6>
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
