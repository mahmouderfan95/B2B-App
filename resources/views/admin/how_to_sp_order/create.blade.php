@extends('layouts.master')
@section('title')
    @lang('admin.how-to-special-order.add')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('admin.how-to-special-order.fast_shipping')
        @endslot
        @slot('title')
            @lang('admin.how-to-special-order.manage_fast_shipping')
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <!-- form start -->
                    <form class="row g-3 needs-validation" novalidate
                        action="{{ route('dashboard.how-to-special-order.store') }}" method="post">
                        @csrf
                        @include('admin.how_to_sp_order._form', [
                            'button_label' => trans('admin.save'),
                        ])
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
