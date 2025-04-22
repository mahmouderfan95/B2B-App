@extends('layouts.vendor.master')
@section('title')
    @lang('vendor.sub.page_title')
@endsection
@section('css')
    <!-- datatable css -->
    <link href="{{URL::asset('build/datatables/dataTables.bootstrap5.min.css')}}" rel="stylesheet" type="text/css"/>
    <!--datatable responsive css -->
    <link href="{{URL::asset('build/datatables/responsive.bootstrap.min.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{URL::asset('build/datatables/buttons.dataTables.min.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            {{$vendor->name}}
        @endslot
        @slot('title')
            @lang('vendor.sub.page_title')
        @endslot
    @endcomponent

    <div class="row">


        <div class="col-lg-12">
            <div class="col-auto mb-4">
                <a href="{{route('sub-vendor.sub.create.form')}}">
                    <button type="button" class="btn btn-soft-primary"><i class="ri-add-circle-line align-middle me-1"></i>
                        @lang('vendor.sub.add')</button>
                </a>
            </div>

            <div class="card">
                <div class="card-body">
                    @if($vendor->subVendor)
                        <table id="buttons-datatables" class="display table table-bordered" style="width:100%">
                            <thead>
                            <tr>
                                <th>@lang('vendor.sub.id')</th>
                                <th>@lang('vendor.sub.name')</th>
                                <th>@lang('vendor.sub.email')</th>
                                <th>@lang('vendor.sub.phone')</th>
                                <th>@lang('admin.roles_permissions.roles')</th>
                                <th>@lang('admin.actions')</th>
                            </tr>
                            </thead>
                            <tbody>


                            @forelse($vendor->subVendor as  $sub)
                                <tr>
                                    <td class="text-center">{{$sub->id}}</td>
                                    <td>{{$sub->name}}</td>
                                    <td>{{$sub->email}}</td>
                                    <td>{{$sub->phone}}</td>
                                    <td>
                                        @foreach($sub->roles as $role)
                                            {{ $role->name }}
                                        @endforeach
                                    </td>
                                    <td>
                                        <div class="dropdown d-inline-block">
                                            <button class="btn btn-soft-secondary btn-sm dropdown " type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="true">
                                                <i class="ri-equalizer-fill"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end " data-popper-placement="top-end"
                                                style="position: absolute; inset: auto 0px 0px auto; margin: 0px; transform: translate(0px, -31px);">
                                                <li><a href="{{route('sub-vendor.sub.edit.form', $sub->id)}}"
                                                       class="dropdown-item edit-item-btn"><i
                                                            class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                        @lang('admin.edit')</a></li>
                                                <li class="list-inline-item" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-placement="top"
                                                    title="  @lang('admin.delete')">
                                                    <a class="text-danger dropdown-item edit-item-btn"
                                                       data-bs-toggle="modal" href="#deleteSubVendor-{{ $sub->id  }}">
                                                        <i class="ri-delete-bin-5-fill fs-16"></i> @lang('vendor.sub.delete')
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Start Delete Modal -->
                                <div class="modal fade flip"
                                     id="deleteSubVendor-{{ $sub->id }}"
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
                                                    <h4>@lang('vendor.sub.delete_modal.title')</h4>
                                                    <p class="text-muted fs-15 mb-4">@lang('vendor.sub.delete_modal.description')</p>
                                                    <div class="hstack gap-2 justify-content-center remove">
                                                        <button
                                                            class="btn btn-link link-primary fw-medium text-decoration-none"
                                                            data-bs-dismiss="modal"
                                                            id="deleteRecord-close">
                                                            <i class="ri-close-line me-1 align-middle"></i>
                                                            @lang('admin.close')
                                                        </button>
                                                        <form action="{{ route('sub-vendor.sub.delete', $sub->id)  }}"
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
                    @else
                        <div class="text-center">
                            @lang('vendor.sub.tableEmpty')
                            <a  href="{{ route('sub-vendor.sub.create.form') }}">@lang('vendor.sub.addNewVendor')</a>
                        </div>
                    @endif
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
