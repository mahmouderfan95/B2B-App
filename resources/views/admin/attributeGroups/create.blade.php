@extends('layouts.master')
@section('title')
    @lang('admin.attributeGroups.add')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('admin.attributeGroups.attributeGroups')
        @endslot
        @slot('title')
            @lang('admin.attributeGroups.manage_attributeGroups')
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <!-- form start -->
                    <form class="row g-3 needs-validation" novalidate action="{{route('dashboard.attributeGroups.store')}}"
                        method="post" enctype="multipart/form-data">
                        @csrf
                        @include('admin.attributeGroups._form',[
                            'button_label' => trans("admin.save")
                        ])
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
