@extends('layouts.master')
@section('title')
    @lang('admin.how-to-negotiate-price.edit')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('admin.how-to-negotiate-price.page_title')
        @endslot
        @slot('title')
            @lang('admin.how-to-negotiate-price.manage_fast_shipping')
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <!-- form start -->
                    <form class="row g-3 needs-validation" novalidate
                        action="{{ route('dashboard.how-to-negotiate-price.update', $data->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @include('admin.how_to_negotiate._form', [
                            'button_label' => trans('admin.save'),
                        ])
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
