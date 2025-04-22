@extends('layouts.master')
@section('title')
    @lang('admin.packages.add')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('admin.packages.packages')
        @endslot
        @slot('title')
            @lang('admin.packages.manage_packages')
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <!-- form start -->
                    <form class="row g-3 needs-validation" novalidate action="{{route('dashboard.packages.store')}}"
                        method="post" enctype="multipart/form-data">
                        @csrf
                        @include('admin.packages._form',[
                            'button_label' => trans("admin.save")
                        ])
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
