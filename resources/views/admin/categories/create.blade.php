@extends('layouts.master')
@section('title')
    @lang('admin.categories.add')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('admin.categories.categories')
        @endslot
        @slot('title')
            @lang('admin.categories.manage_categories')
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <!-- form start -->
                    <form class="row g-3 needs-validation" novalidate action="{{route('dashboard.categories.store')}}"
                        method="post" enctype="multipart/form-data">
                        @csrf
                        @include('admin.categories._form',[
                            'button_label' => trans("admin.save")
                        ])
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
