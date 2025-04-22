@extends('layouts.master')
@section('title')
    @lang('admin.banks.manage_banks')
@endsection
@section('css')
    <!--datatable css-->
    <link href="{{URL::asset('build/datatables/dataTables.bootstrap5.min.css')}}"  rel="stylesheet" type="text/css"/>
    <!--datatable responsive css-->
    <link href="{{URL::asset('build/datatables/responsive.bootstrap.min.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{URL::asset('build/datatables/buttons.dataTables.min.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('admin.banks.banks')
        @endslot
        @slot('title')
            @lang('admin.banks.manage_banks')
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">

                    <a href="{{route('dashboard.banks.create')}}" class="btn btn-success">
                        <i class="ri-add-line align-bottom me-1"></i>@lang('admin.banks.add')</a>
                </div>
                <div class="card-body">
                    <table id="buttons-datatables" class="display table table-bordered" style="width:100%">
                        <thead class="text-muted table-light">
                        <tr>
                            <th>@lang('admin.banks.id')</th>
                            <th>@lang('admin.image')</th>
                            <th>@lang('admin.banks.name')</th>
                            <th>@lang('admin.actions')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($banks as  $bank)
                            <tr>
                                <td>{{$bank->id}}</td>
                                <td><img src="{{ $bank->image }}" alt="{{ $bank->name }}" height="70" width="50"></td>
                                <td>{{ $bank->translations[0]->name  ?? ''}}</td>

                                <td>
                                    <div class="dropdown d-inline-block">
                                        <button class="btn btn-soft-secondary btn-sm dropdown " type="button"
                                                data-bs-toggle="dropdown" aria-expanded="true">
                                            <i class="ri-equalizer-fill"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end " data-popper-placement="top-end"
                                            style="position: absolute; inset: auto 0px 0px auto; margin: 0px; transform: translate(0px, -31px);">
                                            <li><a href="{{route('dashboard.banks.edit',$bank->id)}}"
                                                   class="dropdown-item edit-item-btn"><i
                                                        class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                    @lang('admin.edit')</a></li>

                                            <li class="list-inline-item" data-bs-toggle="tooltip"
                                                data-bs-trigger="hover" data-bs-placement="top" title="  @lang('admin.delete')">
                                                <a class="text-danger dropdown-item edit-item-btn" data-bs-toggle="modal" href="#deleteCategory-{{ $bank->id }}">
                                                    <i class="ri-delete-bin-5-fill fs-16"></i>  @lang('admin.delete')
                                                </a>
                                            </li>

                                        </ul>
                                    </div>
                                </td>
                            </tr>

                            <!-- Start Delete Modal -->
                            <div class="modal fade flip"
                                 id="deleteCategory-{{ $bank->id }}"
                                 tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body p-5 text-center">
                                            <lord-icon
                                                src="https://cdn.lordicon.com/gsqxdxog.json"
                                                trigger="loop"
                                                colors="primary:#25a0e2,secondary:#00bd9d"
                                                style="width:50px !important;height:50px !important;">
                                            </lord-icon>
                                            <div class="mt-4 text-center">
                                                <h4>@lang('admin.banks.delete_modal.title')</h4>
                                                <p class="text-muted fs-15 mb-4">@lang('admin.banks.delete_modal.description')</p>
                                                <div class="hstack gap-2 justify-content-center remove">
                                                    <button class="btn btn-link link-primary fw-medium text-decoration-none"
                                                            data-bs-dismiss="modal"
                                                            id="deleteRecord-close">
                                                        <i class="ri-close-line me-1 align-middle"></i>
                                                        @lang('admin.close')
                                                    </button>
                                                    <form action="{{route('dashboard.banks.destroy',$bank->id)}}"
                                                          method="post">
                                                        @csrf
                                                        @method("DELETE")
                                                        <button type="submit"
                                                                class="btn btn-primary"
                                                                id="delete-record">
                                                            @lang('admin.delete')
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Delete Modal -->
                        @empty
                            <td>@lang('admin.empty_data')</td>
                        @endforelse
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script src="{{URL::asset('build/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('build/datatables/dataTables.bootstrap5.min.js')}}"></script>
    <script src="{{URL::asset('build/datatables/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('build/datatables/dataTables.buttons.min.js')}}"></script>
    <script src="{{URL::asset('build/datatables/buttons.print.min.js')}}"></script>
    <script src="{{URL::asset('build/datatables/buttons.html5.min.js')}}"></script>
    <script src="{{URL::asset('build/datatables/vfs_fonts.js')}}"></script>
    <script src="{{URL::asset('build/datatables/pdfmake.min.js')}}"></script>
    <script src="{{URL::asset('build/datatables/jszip.min.js')}}"></script>
    <script src="{{ URL::asset('build/js/pages/datatables.init.js') }}"></script>

    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/sweetalerts.init.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>

@endsection
<x-form.alert-data></x-form.alert-data>
