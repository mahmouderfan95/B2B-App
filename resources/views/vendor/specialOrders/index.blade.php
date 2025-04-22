@extends('layouts.vendor.master')
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
            @lang('admin.orders.orders')
        @endslot
        @slot('title')
            @lang('admin.orders.orders_special')
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <table id="buttons-datatables" class="display table table-bordered" style="width:100%">
                        <thead class="text-muted table-light">
                            <tr>
                                <th>@lang('admin.orders.id')</th>
                                <th>@lang('admin.orders.vendor_name')</th>
                                <th>@lang('admin.orders.client_name')</th>
                                <th>@lang('admin.orders.status')</th>
                                <th>@lang('admin.actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($specialOrders as  $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->vendor->name }}</td>
                                    <td>{{ $order->client->name }}</td>
                                    <td>{{ \App\Enums\OrderStatus::getStatusWithClass($order->status)['name'] }}</td>
                                    <td>
                                        <div class="dropdown d-inline-block">
                                            <button class="btn btn-soft-secondary btn-sm dropdown " type="button"
                                                data-bs-toggle="dropdown" aria-expanded="true">
                                                <i class="ri-equalizer-fill"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end " data-popper-placement="top-end"
                                                style="position: absolute; inset: auto 0px 0px auto; margin: 0px; transform: translate(0px, -31px);">
                                                <li><a href="{{ route('vendor.orders.special.show', $order->id) }}"
                                                        class="dropdown-item edit-item-btn"><i
                                                            class="ri-eye-2-fill align-bottom me-2 text-muted"></i>
                                                        @lang('admin.show')</a></li>
                                                @if ($order->status == \App\Enums\OrderStatus::REGISTERD)
                                                    <li class="list-inline-item" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top"
                                                        title="  @lang('admin.accepted')">
                                                        <a class="text-muted dropdown-item edit-item-btn"
                                                            data-bs-toggle="modal" href="#acceptOrder-{{ $order->id }}">
                                                            <i class="ri-check-fill fs-16"></i> @lang('vendor.order_accepted')
                                                        </a>
                                                    </li>
                                                @endif
                                                <li class="list-inline-item" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-placement="top"
                                                    title="  @lang('admin.delete')">
                                                    <a class="text-danger dropdown-item edit-item-btn"
                                                        data-bs-toggle="modal" href="#deleteCategory-{{ $order->id }}">
                                                        <i class="ri-delete-bin-5-fill fs-16"></i> @lang('admin.delete')
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Start Delete Modal -->
                                <div class="modal fade flip" id="deleteCategory-{{ $order->id }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-body p-5 text-center">
                                                <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                                    colors="primary:#25a0e2,secondary:#00bd9d"
                                                    style="width:50px !important;height:50px !important;">
                                                </lord-icon>
                                                <div class="mt-4 text-center">
                                                    <h4>@lang('admin.orders.delete_modal.title')</h4>
                                                    <p class="text-muted fs-15 mb-4">@lang('admin.orders.delete_modal.description')</p>
                                                    <div class="hstack gap-2 justify-content-center remove">
                                                        <button
                                                            class="btn btn-link link-primary fw-medium text-decoration-none"
                                                            data-bs-dismiss="modal" id="deleteRecord-close">
                                                            <i class="ri-close-line me-1 align-middle"></i>
                                                            @lang('admin.close')
                                                        </button>
                                                        <form
                                                            action="{{ route('vendor.orders.special.destroy', $order->id) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-primary"
                                                                id="delete-record">
                                                                @lang('admin.delete')
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Delete Modal -->
                                <!-- Start Delete Modal -->
                                <div class="modal fade flip" id="acceptOrder-{{ $order->id }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-body p-5 text-center">
                                                <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                                    colors="primary:#25a0e2,secondary:#00bd9d"
                                                    style="width:50px !important;height:50px !important;">
                                                </lord-icon>
                                                <div class="mt-4 text-center">
                                                    <h4>@lang('vendor.accept_modal.title')</h4>
                                                    {{--                                                <p class="text-muted fs-15 mb-4">@lang('admin.orders.delete_modal.description')</p> --}}
                                                    <div class="hstack gap-2 justify-content-center remove">
                                                        <button
                                                            class="btn btn-link link-primary fw-medium text-decoration-none"
                                                            data-bs-dismiss="modal" id="acceptRecord-close">
                                                            <i class="ri-close-line me-1 align-middle"></i>
                                                            @lang('admin.close')
                                                        </button>
                                                        <form
                                                            action="{{ route('vendor.orders.special.accepted', $order->id) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit" class="btn btn-primary"
                                                                id="accept-record">
                                                                @lang('admin.accepted')
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Delete Modal -->
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
