@extends('layouts.master')
@section('title')
    @lang('admin.units.add')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('admin.units.units')
        @endslot
        @slot('title')
            @lang('admin.units.manage_units')
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <!-- form start -->
                    <form class="row g-3 needs-validation" novalidate action="{{route('dashboard.units.update',$unit->id)}}"
                          method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @include('admin.units._form',[
                            'button_label' => trans("admin.save")
                        ])
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
