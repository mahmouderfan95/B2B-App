@extends('layouts.master')
@section('title')
    @lang('admin.products.manage_products')
@endsection
@section('css')
    <!--datatable css-->
    <link href="{{URL::asset('build/datatables/dataTables.bootstrap5.min.css')}}" rel="stylesheet" type="text/css"/>
    <!--datatable responsive css-->
    <link href="{{URL::asset('build/datatables/responsive.bootstrap.min.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{URL::asset('build/datatables/buttons.dataTables.min.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('admin.products.products')
        @endslot
        @slot('title')
            @lang('admin.products.manage_products')
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">

                    <a href="{{route('dashboard.products.create')}}" class="btn btn-success">
                        <i class="ri-add-line align-bottom me-1"></i>@lang('admin.products.add')</a>
                    {{--                    <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                                data-bs-target="#exampleModalgrid">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                 class="feather feather-plus">
                                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                            </svg> @lang('admin.products.quick_add')
                                        </button>--}}
                    <div class="modal fade" id="exampleModalgrid" tabindex="-1" aria-labelledby="exampleModalgridLabel">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalgridLabel">Grid Modals</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="javascript:void(0);">
                                        <div class="row g-3">
                                            <div class="col-xxl-6">
                                                <div>
                                                    <label for="firstName" class="form-label">First Name</label>
                                                    <input type="text" class="form-control" id="firstName"placeholder="Enter firstname">
                                                </div>
                                            </div><!--end col-->
                                            <div class="col-xxl-6">
                                                <div>
                                                    <label for="lastName" class="form-label">Last Name</label>
                                                    <input type="text" class="form-control" id="lastName" placeholder="Enter lastname">
                                                </div>
                                            </div><!--end col-->
                                            <div class="col-lg-12">
                                                <label class="form-label">Gender</label>
                                                <div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                               name="inlineRadioOptions" id="inlineRadio1"
                                                               value="option1">
                                                        <label class="form-check-label" for="inlineRadio1">Male</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                               name="inlineRadioOptions" id="inlineRadio2"
                                                               value="option2">
                                                        <label class="form-check-label"
                                                               for="inlineRadio2">Female</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                               name="inlineRadioOptions" id="inlineRadio3"
                                                               value="option3">
                                                        <label class="form-check-label"
                                                               for="inlineRadio3">Others</label>
                                                    </div>
                                                </div>
                                            </div><!--end col-->
                                            <div class="col-xxl-6">
                                                <label for="emailInput" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="emailInput"
                                                       placeholder="Enter your email">
                                            </div><!--end col-->
                                            <div class="col-xxl-6">
                                                <label for="passwordInput" class="form-label">Password</label>
                                                <input type="password" class="form-control" id="passwordInput"
                                                       value="451326546" placeholder="Enter your email">
                                            </div><!--end col-->
                                            <div class="col-lg-12">
                                                <div class="hstack gap-2 justify-content-end">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                                        Close
                                                    </button>
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                            </div><!--end col-->
                                        </div><!--end row-->
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive table-card mb-1">

                        <table class="table table-nowrap align-middle" id="productsTable">
                            <thead class="text-muted table-light">
                            <tr class="text-uppercase">
                                <th>@lang('admin.products.id')</th>
                                <th>@lang('admin.image')</th>
                                <th>@lang('admin.products.name')</th>
                                <th>@lang('admin.products.price_from_to')</th>
                                <th>@lang('admin.products.quantity')</th>
                                <th>@lang('admin.status')</th>
                                <th>@lang('admin.actions')</th>
                            </tr>
                            </thead>
                            <tbody class="list form-check-all">
                            @forelse($products as  $product)
                                <tr>
                                    <td>{{$product->id}}</td>
                                    <td><img src="{{ $product->image }}" alt="{{ $product->name }}" height="70"
                                             width="50"></td>
                                    <td>{{$product->translations[0]->name ?? ''}}</td>
                                    <td>{{ $product->price}}</td>
                                    <td>{{ $product->quantity }}</td>
                                    <td> @if($product->status == 'accepted')
                                            <span class="badge badge-soft-success">@lang('admin.active')</span>
                                        @else
                                            <span class="badge badge-soft-danger">@lang('admin.inactive')</span>
                                        @endif</td>

                                    <td>
                                        <div class="dropdown d-inline-block">
                                            <button class="btn btn-soft-secondary btn-sm dropdown " type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="true">
                                                <i class="ri-equalizer-fill"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end " data-popper-placement="top-end"
                                                style="position: absolute; inset: auto 0px 0px auto; margin: 0px; transform: translate(0px, -31px);">
                                                <li><a href="{{route('dashboard.products.edit',$product->id)}}"
                                                       class="dropdown-item edit-item-btn"><i
                                                            class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                        @lang('admin.edit')</a></li>

                                                <li class="list-inline-item" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-placement="top"
                                                    title="  @lang('admin.delete')">
                                                    <a class="text-danger dropdown-item edit-item-btn"
                                                       data-bs-toggle="modal" href="#deleteCategory-{{ $product->id }}">
                                                        <i class="ri-delete-bin-5-fill fs-16"></i> @lang('admin.delete')
                                                    </a>
                                                </li>

                                            </ul>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Start Delete Modal -->
                                <div class="modal fade flip"
                                     id="deleteCategory-{{ $product->id }}"
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
                                                    <h4>@lang('admin.products.delete_modal.title')</h4>
                                                    <p class="text-muted fs-15 mb-4">@lang('admin.products.delete_modal.description')</p>
                                                    <div class="hstack gap-2 justify-content-center remove">
                                                        <button
                                                            class="btn btn-link link-primary fw-medium text-decoration-none"
                                                            data-bs-dismiss="modal"
                                                            id="deleteRecord-close">
                                                            <i class="ri-close-line me-1 align-middle"></i>
                                                            @lang('admin.close')
                                                        </button>
                                                        <form
                                                            action="{{route('dashboard.products.destroy',$product->id)}}"
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

                    <div class="d-flex justify-content-end">
                        <div class="pagination-wrap hstack gap-2">
                            {{ $products->appends(request()->query())->links("pagination::bootstrap-4") }}
                        </div>
                    </div>
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
