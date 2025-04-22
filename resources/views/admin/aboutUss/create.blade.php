@extends('layouts.master')
@section('title')
    @lang('admin.aboutUss.add')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('admin.aboutUss.aboutUss')
        @endslot
        @slot('title')
            @lang('admin.aboutUss.manage_aboutUss')
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <!-- form start -->
                    <form class="row g-3 needs-validation" novalidate action="{{route('dashboard.aboutUss.store')}}"
                        method="post" enctype="multipart/form-data">
                        @csrf
                        @include('admin.aboutUss._form',[
                            'button_label' => trans("admin.save")
                        ])
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
