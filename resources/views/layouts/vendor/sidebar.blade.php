<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="{{  route('vendor.root') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ URL::asset('build/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('build/images/logo-dark.png') }}" alt="" height="17">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="{{  route('vendor.root') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ URL::asset('build/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('build/images/logo-light.png') }}" alt="" height="17">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span>@lang('translation.menu')</span></li>
                @php $root = \Illuminate\Support\Facades\Auth::guard('vendor')->check() ? route('vendor.root') : route('sub-vendor.root') @endphp
                <li class="nav-item">
                    <a href="{{  $root }}" class="nav-link"><i data-feather="home" class="icon-dual"></i> <span>@lang('translation.ecommerce')</span></a>
                </li>
                @auth('vendor')
                    <li class="nav-item">
                        <a href="{{ route('vendor.quotations.index') }}" class="nav-link"><i data-feather="home" class="icon-dual"></i> <span>
                        @lang('translation.quotations')</span></a>
                    </li>
                @endauth

                <li class="menu-title"><i class="ri-more-fill"></i> <span>@lang('translation.pages')</span></li>
                @php $agreements = \Illuminate\Support\Facades\Auth::guard('vendor')->check() ? route('vendor.agreements.index') : route('sub-vendor.agreements.index'); @endphp
                @can('show-agreements')
                    <li class="nav-item">
                        <a href="{{  $agreements }}" class="nav-link"><i data-feather="grid" class="icon-dual"></i <span>@lang('admin.vendors-agreements')</span></a>
                    </li>
                @endcan
                @php $walletRoute = \Illuminate\Support\Facades\Auth::guard('vendor')->check() ? route('vendor.my_wallet') : route('sub-vendor.my_wallet') @endphp
                @can('show-my_wallet')
                    <li class="nav-item">
                        <a href="{{  $walletRoute }}" class="nav-link"><i data-feather="grid" class="icon-dual"></i <span>@lang('vendor.vendorWallets.myVendorWallets')</span></a>
                    </li>
                @endcan
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarOrders" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarOrders">
                        <i data-feather="grid" class="icon-dual"></i> <span>@lang('admin.orders.orders')</span>
                    </a>
                    @php
                        $orderRoute = \Illuminate\Support\Facades\Auth::guard('vendor')->check() ? route('vendor.orders.index') : route('sub-vendor.orders.index');
                        $publicOrderRoute = \Illuminate\Support\Facades\Auth::guard('vendor')->check() ? route('vendor.orders.public') : route('sub-vendor.orders.public');
                        $specialOrderRoute = \Illuminate\Support\Facades\Auth::guard('vendor')->check() ? route('vendor.orders.special') : route('sub-vendor.orders.special');
                    @endphp
                    <div class="collapse menu-dropdown" id="sidebarOrders">
                        <ul class="nav nav-sm flex-column">
                            @can('show-orders')
                                <li class="nav-item">
                                    <a href="{{$orderRoute}}" class="nav-link">@lang('admin.orders.orders_sample')</a>
                                </li>
                            @endcan
                            @can('show-public-orders','sub_vendor')
                                <li class="nav-item">
                                    <a href="{{$publicOrderRoute}}" class="nav-link">@lang('admin.orders.orders_public')</a>
                                </li>
                                @endcan
                                @can('show-special-orders','sub_vendor')
                                    <li class="nav-item">
                                        <a href="{{$specialOrderRoute}}" class="nav-link">@lang('admin.orders.orders_special')</a>
                                    </li>
                                @endcan
                        </ul>
                    </div>
                </li> <!-- end categories Menu -->

               @php $productRote = \Illuminate\Support\Facades\Auth::guard('vendor')->check() ? route('vendor.products.index') : route('sub-vendor.products.index'); @endphp
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarProducts" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarProducts">
                        <i data-feather="grid" class="icon-dual"></i> <span>@lang('admin.products.products')</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarProducts">
                        <ul class="nav nav-sm flex-column">
                            @can('show-products','sub_vendor')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{$productRote}}">
                                         <span>@lang('admin.products.products')</span>
                                    </a>
                                </li> <!-- end certificates Menu -->
                            @endcan
                        </ul>
                    </div>
                </li> <!-- end sidebarProducts Menu -->

{{--                @can('create-Product')--}}
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarSubvendors" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarProducts">
                        <i data-feather="grid" class="icon-dual"></i> <span>@lang('vendor.sub.page_title')</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarSubvendors">
                        <ul class="nav nav-sm flex-column">
                            @php $subVendorRoute = \Illuminate\Support\Facades\Auth::guard('vendor')->check() ? route('vendor.sub.list') : route('sub-vendor.sub.list') @endphp
                            @can('show-sub_vendors','sub_vendor')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{$subVendorRoute}}">
                                        <span>@lang('vendor.sub.sub_title')</span>
                                    </a>
                                </li> <!-- end certificates Menu -->
                            @endcan
                        </ul>
                    </div>
                </li> <!-- end sidebarProducts Menu -->
                @auth('vendor')
                    <li class="nav-item"> <!-- Role And Permissions -->
                        <a class="nav-link menu-link" href="#sidebarRolesPermissions" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarCountries">
                            <i data-feather="grid" class="icon-dual"></i> <span>@lang('admin.roles_permissions.page_title')</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarRolesPermissions">
                            <ul class="nav nav-sm flex-column">
                                @can('show-role','sub_vendor')
                                    <li class="nav-item">
                                        <a href="{{route('vendor.role.index')}}" class="nav-link">@lang('admin.roles_permissions.roles')</a>
                                    </li>
                                @endcan
                                @can('show-permission')
                                    <li class="nav-item">
                                        <a href="{{route('vendor.permission.index')}}" class="nav-link">@lang('admin.roles_permissions.permissions')</a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li> <!-- End Role And Permissions -->
                @endauth
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>
