@extends('layouts.vendor.master')
@section('title')
    @lang('admin.products.add')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('admin.products.products')
        @endslot
        @slot('title')
            @lang('admin.products.manage_products')
        @endslot
    @endcomponent

    <form class="row g-3 needs-validation" novalidate action="{{route('sub-vendor.products.store')}}"
          method="post" enctype="multipart/form-data">
        @csrf
        @include('vendor.products._form',[
            'button_label' => trans("admin.save")
        ])
    </form>
@endsection
