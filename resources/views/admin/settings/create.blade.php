@extends('layouts.master')
@section('title')
    @lang('admin.settings.add')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('admin.settings.settings')
        @endslot
        @slot('title')
            @lang('admin.settings.manage_settings')
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <!-- form start -->
                    <form class="row g-3 needs-validation" novalidate action="{{route('dashboard.settings.updateSetting')}}"
                        method="post" enctype="multipart/form-data">
                        @csrf
                        @include('admin.settings._form',[
                            'button_label' => trans("admin.save")
                        ])
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
