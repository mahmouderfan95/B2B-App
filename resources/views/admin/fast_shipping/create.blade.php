@extends('layouts.master')
@section('title')
    @lang('admin.fast_shipping.add')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('admin.fast_shipping.fast_shipping')
        @endslot
        @slot('title')
            @lang('admin.fast_shipping.manage_fast_shipping')
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <!-- form start -->
                    <form class="row g-3 needs-validation" novalidate action="{{route('dashboard.fast-shipping.store')}}"
                        method="post">
                        @csrf
                        @include('admin.fast_shipping._form',[
                            'button_label' => trans("admin.save")
                        ])
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
