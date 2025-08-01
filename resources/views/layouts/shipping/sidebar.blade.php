<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="{{ route('shipping.root') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ URL::asset('build/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('build/images/logo-dark.png') }}" alt="" height="17">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="{{ route('shipping.root') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ URL::asset('build/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('build/images/logo-light.png') }}" alt="" height="17">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span>@lang('translation.menu')</span></li>

                <li class="nav-item">
                    <a href="{{ route('shipping.root') }}" class="nav-link"><i data-feather="home"
                            class="icon-dual"></i> <span>@lang('translation.ecommerce')</span></a>
                </li>


                <li class="menu-title"><i class="ri-more-fill"></i> <span>@lang('translation.pages')</span></li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarOrders" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarOrders">
                        <i data-feather="grid" class="icon-dual"></i> <span>@lang('admin.orders.orders')</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarOrders">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('shipping.orders.sample') }}" class="nav-link">@lang('admin.orders.orders_sample')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('shipping.orders.public') }}" class="nav-link">@lang('admin.orders.orders_public')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('shipping.special-orders.index') }}"
                                    class="nav-link">@lang('admin.orders.orders_special')</a>
                            </li>
                        </ul>
                    </div>
                </li> <!-- end categories Menu -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('shipping.offers.index') }}">
                        <i data-feather="grid" class="icon-dual"></i> <span>@lang('shipping.offers.offers')</span>
                    </a>
                </li> <!-- end banners Menu -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('shipping.special-offers.index') }}">
                        <i data-feather="grid" class="icon-dual"></i> <span>@lang('shipping.offers.sp_offers')</span>
                    </a>
                </li> <!-- end banners Menu -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('shipping.shipping-wallets.show') }}">
                        <i data-feather="grid" class="icon-dual"></i> <span>@lang('admin.shippingWallets.show_shippingWallet')</span>
                    </a>
                </li> <!-- end banners Menu -->
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>
