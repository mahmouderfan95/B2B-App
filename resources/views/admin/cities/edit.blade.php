@extends('layouts.master')
@section('title')
    @lang('admin.cities.add')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('admin.cities.cities')
        @endslot
        @slot('title')
            @lang('admin.cities.manage_cities')
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <!-- form start -->
                    <form class="row g-3 needs-validation" novalidate action="{{route('dashboard.cities.update',$city->id)}}"
                          method="post" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        @include('admin.cities._form',[
                            'button_label' => trans("admin.save")
                        ])
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
