@extends('layouts.master')
@section('title')
    @lang('admin.orders.orders_public')
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
            @lang('admin.orders.orders')
        @endslot
        @slot('title')
            @lang('admin.orders.orders_public')
        @endslot
    @endcomponent
    <form>
        <div class="row g-3">
            <div class="col-xxl-4 col-sm-6">
                <div class="search-box">
                    <select name="status" class="form-select" dir="rtl" data-choices
                            data-choices-removeItem required>
                        <option value="registered">@lang('admin.orders.orderStatus.registered')</option>
                        <option value="accepted_by_vendor">@lang('admin.orders.orderStatus.accepted_by_vendor')</option>
                        <option value="ready_for_30">@lang('admin.orders.orderStatus.ready_for_30')</option>
                        <option value="paid">@lang('admin.orders.orderStatus.paid')</option>
                        <option value="completed">@lang('admin.orders.orderStatus.completed')</option>
                    </select>
                    <span class="invalid-feedback" id="vendor-id-error" role="alert">
                        <strong> @lang('admin.required') </strong>
                    </span>
                </div>
            </div>
            <div class="col-xxl-4 col-sm-6">
                <div class="search-box">
                    <input name="created_at" type="text" class="form-control flatpickr-input active"
                           value="{{ request()->get('created_at') }}" data-provider="flatpickr"
                           data-date-format="Y-m-d" placeholder="@lang('admin.orders.created_at')">
                </div>
            </div>
            <div class="col-xxl-2 col-sm-4">
                <div>
                    <button type="submit" class="btn btn-secondary w-100"
                            onclick="vendorValidation('vendor-id-error')">
                        <i class="ri-search-line search-icon"></i>
                        @lang('admin.search')
                    </button>
                </div>
            </div>
            <!--end col-->
        </div>
        <!--end row-->
    </form>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <table id="buttons-datatables" class="display table table-bordered" style="width:100%">
                        <thead class="text-muted table-light">
                        <tr>
                            <th>@lang('admin.orders.id')</th>
                            <th>@lang('admin.orders.client_name')</th>
                            <th>@lang('admin.orders.payment_method')</th>
                            <th>@lang('admin.orders.status')</th>
                            <th>@lang('admin.orders.total')</th>
                            <th>@lang('admin.actions')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($orders as  $order)
                            <tr>
                                <td>{{$order->id}}</td>
                                <td>{{$order->client->name}}</td>
                                <td>{{$order->payment_method}}</td>
                                <td>{{ \App\Enums\OrderStatus::getStatusWithClass($order->status)["name"] }}</td>
                                <td>{{$order->total}}</td>
                                <td>
                                    <div class="dropdown d-inline-block">
                                        <button class="btn btn-soft-secondary btn-sm dropdown " type="button"
                                                data-bs-toggle="dropdown" aria-expanded="true">
                                            <i class="ri-equalizer-fill"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end " data-popper-placement="top-end"
                                            style="position: absolute; inset: auto 0px 0px auto; margin: 0px; transform: translate(0px, -31px);">
                                            <li><a href="{{route('dashboard.orders.show',$order->id)}}"
                                                   class="dropdown-item edit-item-btn"><i
                                                        class="ri-eye-2-fill align-bottom me-2 text-muted"></i>
                                                    @lang('admin.show')</a></li>
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
                            <div class="modal fade flip"
                                 id="deleteCategory-{{ $order->id }}"
                                 tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body p-5 text-center">
                                            <lord-icon
                                                src="https://cdn.lordicon.com/gsqxdxog.json"
                                                trigger="loop"
                                                colors="primary:#25a0e2,secondary:#00bd9d"
                                                style="width:50px !important;height:50px !important;">
                                            </lord-icon>
                                            <div class="mt-4 text-center">
                                                <h4>@lang('admin.orders.delete_modal.title')</h4>
                                                <p class="text-muted fs-15 mb-4">@lang('admin.orders.delete_modal.description')</p>
                                                <div class="hstack gap-2 justify-content-center remove">
                                                    <button
                                                        class="btn btn-link link-primary fw-medium text-decoration-none"
                                                        data-bs-dismiss="modal"
                                                        id="deleteRecord-close">
                                                        <i class="ri-close-line me-1 align-middle"></i>
                                                        @lang('admin.close')
                                                    </button>
                                                    <form action="{{route('dashboard.orders.destroy',$order->id)}}"
                                                          method="post">
                                                        @csrf
                                                        @method("DELETE")
                                                        <button type="submit"
                                                                class="btn btn-primary"
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
