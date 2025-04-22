@extends('layouts.master')
@section('title')
    @lang('admin.roles_permissions.roles')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('admin.roles_permissions.roles')
        @endslot
        @slot('title')
            @lang('admin.roles_permissions.page_title')
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <!-- form start -->
                    <form class="row g-3 needs-validation" novalidate action="{{route('dashboard.role.store')}}"
                        method="post" enctype="multipart/form-data">
                        @csrf
                        @include('admin.roles._form',[
                            'button_label' => trans("admin.save")
                        ])
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
