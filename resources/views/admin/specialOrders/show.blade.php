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
                        <h5 class="card-title flex-grow-1 mb-0">@lang('admin.orders.show_orders')
                            #{{ $specialOrder->id }}</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive table-card">
                        <table class="table table-nowrap align-middle table-borderless mb-0">
                            <thead class="table-light text-muted">
                                <tr>
                                    <th scope="col">@lang('admin.orders.product_details')</th>
                                    <th scope="col">@lang('admin.products.price') </th>
                                    <th scope="col">@lang('admin.orders.quantity')</th>
                                    <th scope="col" class="text-end">@lang('admin.orders.price_total')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($specialOrder->products as $product)
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
                                        <td>{{ $product->price }}</td>
                                        <td>{{ $product->pivot->quantity }}</td>
                                        <td class="fw-medium text-end">
                                            {{ $product->price * $product->pivot->quantity }}
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
                                                    <td class="text-end">{{ $specialOrder->sub_total }}</td>
                                                </tr>
                                                <tr>
                                                    <td>@lang('admin.orders.delivery_fees') :</td>
                                                    <td class="text-end">{{ $specialOrder->delivery_fees ?? 0 }}</td>
                                                </tr>
                                                {{--  <tr>
                                                    <td>@lang('admin.orders.vat') :</td>
                                                    <td class="text-end">{{ $specialOrder->vat }}</td>
                                                </tr>  --}}
                                                <tr class="border-top border-top-dashed">
                                                    <th scope="row">@lang('admin.orders.total') :</th>
                                                    <td class="text-end">{{ $specialOrder->total }}</td>
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
                        <h5 class="card-title flex-grow-1 mb-0">@lang('admin.orders.status') </h5>
                        <div class="flex-shrink-0 mt-2 mt-sm-0">
                            <a href="javasccript:void(0;)" class="btn btn-soft-primary btn-sm mt-2 mt-sm-0"><i
                                    class="ri-map-pin-line align-middle me-1"></i>
                                {{ \App\Enums\OrderStatus::getStatusWithClass($specialOrder->status)['name'] }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!--end card-->


            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="ri-secure-payment-line align-bottom me-1 text-muted"></i>
                        @lang('admin.quotations.quotations')</h5>
                </div>
                <div class="card-body">
                    <table id="buttons-datatables" class="display table table-boffered" style="width:100%">
                        <thead class="text-muted table-light">
                            <tr>
                                <th>@lang('admin.quotations.id')</th>
                                <th>@lang('admin.quotations.order')</th>
                                <th>@lang('admin.quotations.price')</th>
                                <th>@lang('admin.quotations.expect_date_from')</th>
                                <th>@lang('admin.quotations.expect_date_to')</th>
                                <th>@lang('admin.quotations.status')</th>
                                <th>@lang('admin.quotations.sender')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($specialOrder->order_quotations as  $order_quotation)
                                <tr>
                                    <td>{{ $order_quotation->id }}</td>
                                    <td>{{ $order_quotation->special_order_id }}</td>
                                    <td>{{ $order_quotation->quotation_price }}</td>
                                    <td>{{ $order_quotation->expect_date_from }}</td>
                                    <td>{{ $order_quotation->expect_date_to }}</td>
                                    <td>
                                        @if ($order_quotation->status == 'accepted')
                                            <span class="badge badge-soft-success">@lang('admin.active')</span>
                                        @elseif($order_quotation->status == 'pending')
                                            <span class="badge badge-soft-primary">@lang('admin.pending')</span>
                                        @else
                                            <span class="badge badge-soft-danger">@lang('admin.inactive')</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($order_quotation->sender_type == 'vendor')
                                            <span class="badge badge-soft-success">@lang('admin.quotations.vendors')</span>
                                        @else
                                            <span class="badge badge-soft-primary">@lang('admin.quotations.clients')</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <td>@lang('admin.empty_data')</td>
                            @endforelse
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="ri-secure-payment-line align-bottom me-1 text-muted"></i>
                        @lang('shipping.offers.offers')</h5>
                </div>
                <div class="card-body">
                    <table id="buttons-datatables" class="display table table-boffered" style="width:100%">
                        <thead class="text-muted table-light">
                            <tr>
                                <th>@lang('shipping.offers.id')</th>
                                <th>@lang('shipping.offers.client')</th>
                                <th>@lang('shipping.offers.orders')</th>
                                <th>@lang('shipping.offers.price')</th>
                                <th>@lang('shipping.offers.status')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($specialOrder->shipping_special_offers as  $offer)
                                <tr>
                                    <td>{{ $offer->id }}</td>
                                    <td>{{ $offer->special_order->client->name }}</td>
                                    <td>{{ $offer->special_order_id }}</td>
                                    <td>{{ $offer->price }}</td>
                                    <td>
                                        @if ($offer->status == 'accepted')
                                            <span class="badge badge-soft-success">@lang('admin.active')</span>
                                        @elseif($offer->status == 'pending')
                                            <span class="badge badge-soft-primary">@lang('admin.pending')</span>
                                        @else
                                            <span class="badge badge-soft-danger">@lang('admin.inactive')</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <td>@lang('admin.empty_data')</td>
                            @endforelse
                    </table>
                </div>
            </div>
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
                                    <img src="{{ $specialOrder->client->image }}" alt="" class="avatar-sm rounded">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="fs-14 mb-1">{{ $specialOrder->client->name }}</h6>
                                    <p class="text-muted mb-0"> @lang('admin.orders.shipping_details') </p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <i class="ri-mail-line me-2 align-middle text-muted fs-16"></i>
                            {{ $specialOrder->client->email }}
                        </li>
                        <li>
                            <i
                                class="ri-phone-line me-2 align-middle text-muted fs-16"></i>{{ $specialOrder->client->phone }}
                        </li>
                    </ul>
                </div>
            </div>
            <!--end card-->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="ri-map-pin-line align-middle me-1 text-muted"></i>
                        @lang('admin.orders.shipping_details')
                    </h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled vstack gap-2 fs-13 mb-0">
                        <li class="fw-medium fs-14">{{ $specialOrder->client->name }}</li>
                        <li>{{ $specialOrder->client_address->phone }}</li>
                        <li>{{ $specialOrder->client_address->address }}</li>
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
                            <h6 class="mb-0">{{ $specialOrder->transaction_id }}</h6>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <div class="flex-shrink-0">
                            <p class="text-muted mb-0">@lang('admin.orders.payment_method'):</p>
                        </div>
                        <div class="flex-grow-1 ms-2">
                            <h6 class="mb-0">{{ $specialOrder->payment_method }}</h6>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <p class="text-muted mb-0">@lang('admin.orders.total'):</p>
                        </div>
                        <div class="flex-grow-1 ms-2">
                            <h6 class="mb-0">{{ $specialOrder->total }}</h6>
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
