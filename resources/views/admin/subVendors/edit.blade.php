@extends('layouts.master')
@section('title')
    {{ __('vendor.setting')  }}
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            {{ __('vendor.setting')  }}
        @endslot
        @slot('title')
            {{ ('vendor.sub.edit')  }}
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <!-- form start -->
                    <form class="row g-3 needs-validation" novalidate action="{{ route('dashboard.sub-vendors.update',$subVendor->id) }}"
                          method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @include('admin.subVendors._form',[
                            'button_label' => trans("admin.save")
                        ])
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
