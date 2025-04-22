@extends('layouts.vendor.master')
@section('title')
    @lang('admin.vendors.profile')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('admin.setting')
        @endslot
        @slot('title')
            @lang('admin.vendors.edit_profile')
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <!-- form start -->
                    <form class="row g-3 needs-validation" novalidate action="{{route('vendor.profile.update')}}"
                          method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @include('admin.vendors._form',[
                            'button_label' => trans("admin.save")
                        ])
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
