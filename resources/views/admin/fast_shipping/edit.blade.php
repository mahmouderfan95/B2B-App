@extends('layouts.master')
@section('title')
    @lang('admin.fast_shipping.edit')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('admin.fast_shipping.page_title')
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
                    <form class="row g-3 needs-validation" novalidate
                        action="{{ route('dashboard.fast-shipping.update', $data->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @include('admin.fast_shipping._form', [
                            'button_label' => trans('admin.save'),
                        ])
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
