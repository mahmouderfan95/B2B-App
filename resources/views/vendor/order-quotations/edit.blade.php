@extends('layouts.vendor.master')
@section('title')
    @lang('vendor.order-quotations.order-quotations')
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
            @lang('vendor.order-quotations.order-quotations')
        @endslot
        @slot('title')
            @lang('vendor.order-quotations.order-quotations')
        @endslot
    @endcomponent

    <!-- form start -->
    <form class="row g-3 needs-validation" novalidate
        action="{{route('vendor.quotations.send.replay',$orderQuotation->id)}}"
        method="post" enctype="multipart/form-data">
        @csrf
        @include('vendor.order-quotations._form',[
            'button_label' => trans("admin.save")
        ])
    </form>


@endsection
