@extends('layouts.master')
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

    <!-- form start -->
    <form class="row g-3 needs-validation" novalidate
          action="{{route('dashboard.products.update',$product->id)}}"
          method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.products._form',[
            'button_label' => trans("admin.save")
        ])
    </form>


@endsection
