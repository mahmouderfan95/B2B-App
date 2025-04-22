@extends('layouts.shipping.master')
@section('title')
    @lang('shipping.edit_profile')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('admin.setting')
        @endslot
        @slot('title')
            @lang('shipping.edit_profile')
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <!-- form start -->
                    <form class="row g-3 needs-validation" novalidate action="{{route('shipping.profile.update')}}"
                          method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @include('shipping.profile._form',[
                            'button_label' => trans("admin.save")
                        ])
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
