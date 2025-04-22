@extends('layouts.master')
@section('title')
    @lang('admin.privacy_policy.edit')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('admin.privacy_policy.page_title')
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
                    <form class="row g-3 needs-validation" novalidate action="{{route('dashboard.privacy-policy.update', $data->id)}}"
                          method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @include('admin.privacy_policy._form',[
                            'button_label' => trans("admin.save")
                        ])
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
