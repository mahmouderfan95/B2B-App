@extends('layouts.master')
@section('title')
    @lang('admin.privacy_policy.add')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('admin.privacy_policy.privacy_policy')
        @endslot
        @slot('title')
            @lang('admin.privacy_policy.manage_privacy_policy')
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <!-- form start -->
                    <form class="row g-3 needs-validation" novalidate action="{{route('dashboard.privacy-policy.store')}}"
                        method="post">
                        @csrf
                        @include('admin.privacy_policy._form',[
                            'button_label' => trans("admin.save")
                        ])
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
