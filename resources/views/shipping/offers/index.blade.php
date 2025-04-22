@extends('layouts.shipping.master')
@section('title')
    @lang('shipping.offers.offers')
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
            @lang('shipping.offers.offers')
        @endslot
        @slot('title')
            @lang('shipping.offers.offers')
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    {{--  <a href="{{ route('shipping.offers.create') }}" class="btn btn-success">
                        <i class="ri-add-line align-bottom me-1"></i>@lang('admin.shippingMethods.add_offer')</a>  --}}
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
                            @forelse($offers as  $offer)
                                <tr>
                                    <td>{{ $offer->id }}</td>
                                    <td>{{ $offer->order->client->name }}</td>
                                    <td>{{ $offer->order_id }}</td>
                                    <td>{{ $offer->quotation_price }}</td>
                                    <td>
                                        @if ($offer->status == 'accept')
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
