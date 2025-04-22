@extends('layouts.master')
@section('title')
    @lang('admin.orders.add')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('admin.orders.orders')
        @endslot
        @slot('title')
            @lang('admin.orders.manage_orders')
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <!-- form start -->
                    <form class="row g-3 needs-validation" novalidate action="{{route('dashboard.orders.store')}}"
                          method="post" enctype="multipart/form-data">
                        @csrf

                        @include('admin.orders._form',[
                            'button_label' => trans("admin.save")
                        ])
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
