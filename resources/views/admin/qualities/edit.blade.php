@extends('layouts.master')
@section('title')
    @lang('admin.qualities.add')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('admin.qualities.qualities')
        @endslot
        @slot('title')
            @lang('admin.qualities.manage_qualities')
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <!-- form start -->
                    <form class="row g-3 needs-validation" novalidate action="{{route('dashboard.qualities.update',$quality->id)}}"
                          method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @include('admin.qualities._form',[
                            'button_label' => trans("admin.save")
                        ])
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
