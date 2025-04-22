@extends('layouts.master')
@section('title')
    @lang('admin.reports.title')
@endsection
@section('css')
    <!--datatable css-->
    <link href="{{ URL::asset('build/datatables/dataTables.bootstrap5.min.css') }}" rel="stylesheet" region="text/css" />
    <!--datatable responsive css-->
    <link href="{{ URL::asset('build/datatables/responsive.bootstrap.min.css') }}" rel="stylesheet" region="text/css" />
    <link href="{{ URL::asset('build/datatables/buttons.dataTables.min.css') }}" rel="stylesheet" region="text/css" />
    <link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" region="text/css" />
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('admin.reports.title')
        @endslot
        @slot('title')
            @lang('admin.reports.vendors-orders.title')
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form>
                        <div class="row g-3">
                            <div class="col-xxl-3 col-sm-6">
                                <div class="search-box">
                                    <select name="vendor" class="form-select" dir="rtl" data-choices
                                        data-choices-removeItem required>
                                        <option value="">@lang('admin.reports.select-vendor')</option>
                                        @foreach ($vendors ?? [] as $vendor)
                                            <option value='{{ $vendor['id'] }}' @selected($vendor['id'] == request()->get('vendor'))>
                                                {{ $vendor['name'] }} </option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback" id="vendor-id-error" role="alert">
                                        <strong> @lang('admin.required') </strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-xxl-3 col-sm-6">
                                <div class="search-box">
                                    <input name="from" type="date" class="form-control flatpickr-input active"
                                        value="{{ request()->get('from') }}" data-provider="flatpickr"
                                        data-date-format="Y-m-d" placeholder="@lang('admin.reports.date-from')">
                                </div>
                            </div>
                            <div class="col-xxl-3 col-sm-6">
                                <div class="search-box">
                                    <input name="to" type="text" class="form-control flatpickr-input active"
                                        value="{{ request()->get('to') }}" data-provider="flatpickr"
                                        data-date-format="Y-m-d" placeholder="@lang('admin.reports.date-to')">
                                </div>
                            </div>
                            <div class="col-xxl-1 col-sm-4">
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
                </div>
            </div>
            <div class="card mt-5">
                @if (session()->has('error'))
                    <div class="alert alert-danger"> {{ session('error') }} </div>
                @endif
                <div class="card-body d-flex flex-column gap-4">
                    {{--  @if (request()->has('vendor'))
                        <div>
                            <button type="button" onclick="openExcel()" class="btn btn-success"> @lang('reports.excel') </button>
                            <button type="button" onclick="openPrint()" class="btn btn-info"> @lang('reports.print') </button>
                            <button type="button" onclick="openPdf()" class="btn btn-primary"> @lang('reports.pdf') </button>
                        </div>
                    @endif  --}}
                    <div>
                        <div class="table-responsive table-card mb-1">
                            <table class="table table-nowrap align-middle">
                                <thead class="text-muted table-light">
                                    <tr class="text-uppercase">
                                        <th>#</th>
                                        <th>@lang('admin.reports.vendors-orders.vendor')</th>
                                        <th>@lang('admin.reports.vendors-orders.order-code')</th>
                                        <th>@lang('admin.reports.vendors-orders.order-id')</th>
                                        <th>@lang('admin.reports.vendors-orders.created-at')</th>
                                        {{--  <th>@lang('admin.reports.vendors-orders.delivered-at')</th>  --}}
                                        <th>@lang('admin.reports.vendors-orders.vendor-amount')</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @foreach ($data ?? [] as $row)
                                        @include('admin.reports.vendor-order-row', ['row' => $row])
                                    @endforeach
                                    @if ($data->isEmpty())
                                        <tr>
                                            <td colspan = "11">
                                                <center>
                                                    @lang('admin.reports.vendors-orders.no-orders')
                                                </center>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div>
                        <div class="d-flex justify-content-end">
                            <div class="pagination-wrap hstack gap-2">
                                {{-- check instance only for making sure it has a pagination, collection can be an empty support collection --}}
                                @if ($data instanceof Illuminate\Contracts\Pagination\LengthAwarePaginator)
                                    {{ $data->appends(request()->query()) }}
                                @endif
                            </div>
                        </div>
                    </div>
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
