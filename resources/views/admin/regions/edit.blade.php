@extends('layouts.master')
@section('title')
    @lang('admin.regions.add')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('admin.regions.regions')
        @endslot
        @slot('title')
            @lang('admin.regions.manage_regions')
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <!-- form start -->
                    <form class="row g-3 needs-validation" novalidate action="{{route('dashboard.regions.update',$region->id)}}"
                          method="post" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        @include('admin.regions._form',[
                            'button_label' => trans("admin.save")
                        ])
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
