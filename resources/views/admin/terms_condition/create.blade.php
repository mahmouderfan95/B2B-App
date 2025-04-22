@extends('layouts.master')
@section('title')
    @lang('admin.privacy_policy.add')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('admin.terms-conditions.terms-conditions')
        @endslot
        @slot('title')
            @lang('admin.terms-conditions.manage_terms-conditions')
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <!-- form start -->
                    <form class="row g-3 needs-validation" novalidate action="{{route('dashboard.terms-conditions.store')}}"
                        method="post">
                        @csrf
                        @include('admin.terms_condition._form',[
                            'button_label' => trans("admin.save")
                        ])
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
