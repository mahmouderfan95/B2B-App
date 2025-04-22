@extends('layouts.master')
@section('title')
    @lang('admin.types.add')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('admin.types.types')
        @endslot
        @slot('title')
            @lang('admin.types.manage_types')
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <!-- form start -->
                    <form class="row g-3 needs-validation" novalidate action="{{route('dashboard.types.update',$type->id)}}"
                          method="post" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        @include('admin.types._form',[
                            'button_label' => trans("admin.save")
                        ])
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
