@php
    $is_vendor = Auth::guard('vendor')->check();
    $form_route = $is_vendor ? route('vendor.sub.update',$subVendor->id) : route('sub-vendor.profile.update');
@endphp

@extends('layouts.vendor.master')
@section('title')
    {{ $is_vendor ? __('vendor.sub.edit') . $subVendor->name : __('vendor.sub.edit_profile')  }}
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            {{ $is_vendor ? __('vendor.sub.page_title') . $subVendor->name : __('vendor.setting')  }}
        @endslot
        @slot('title')
            {{ $is_vendor ? __('vendor.sub.edit') . $subVendor->name : __('vendor.sub.edit_profile')  }}
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <!-- form start -->
                    <form class="row g-3 needs-validation" novalidate action="{{ $form_route }}"
                          method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @include('vendor.subVendors._form',[
                            'button_label' => trans("admin.save")
                        ])
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
