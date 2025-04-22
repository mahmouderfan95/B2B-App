<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="{{ route('root') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ URL::asset('build/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('build/images/logo-dark.png') }}" alt="" height="17">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="index" class="logo logo-light">
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
                    <a href="{{ route('root') }}" class="nav-link"><i data-feather="home" class="icon-dual"></i>
                        <span>@lang('translation.ecommerce')</span></a>
                </li>


                <li class="menu-title"><i class="ri-more-fill"></i> <span>@lang('translation.pages')</span></li>
                @can('show-agreements')
                    <li class="nav-item">
                        <a href="{{ route('admin.vendors-agreements.index') }}" class="nav-link"><i data-feather="grid"
                                class="icon-dual"></i <span>@lang('admin.vendors-agreements')</span></a>
                    </li>
                @endcan
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarOrders" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarOrders">
                        <i data-feather="grid" class="icon-dual"></i> <span>@lang('admin.orders.orders')</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarOrders">
                        <ul class="nav nav-sm flex-column">
                            @can('sample-order')
                                <li class="nav-item">
                                    <a href="{{ route('dashboard.orders.index') }}" class="nav-link">@lang('admin.orders.orders_sample')</a>
                                </li>
                            @endcan
                            @can('public-order')
                                <li class="nav-item">
                                    <a href="{{ route('dashboard.orders.public') }}" class="nav-link">@lang('admin.orders.orders_public')</a>
                                </li>
                            @endcan
                            @can('special-order')
                                <li class="nav-item">
                                    <a href="{{ route('dashboard.special-orders.index') }}"
                                        class="nav-link">@lang('admin.orders.orders_special')</a>
                                </li>
                            @endcan
                        </ul>
                    </div>
                </li> <!-- end categories Menu -->
                @can('banners')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard.banners.index') }}">
                            <i data-feather="grid" class="icon-dual"></i> <span>@lang('admin.banners.banners')</span>
                        </a>
                    </li> <!-- end banners Menu -->
                @endcan
                @can('banks')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard.banks.index') }}">
                            <i data-feather="grid" class="icon-dual"></i> <span>@lang('admin.banks.banks')</span>
                        </a>
                    </li> <!-- end banks Menu -->
                @endcan
                @can('clients')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard.clients.index') }}">
                            <i data-feather="grid" class="icon-dual"></i> <span>@lang('admin.clients.clients')</span>
                        </a>
                    </li> <!-- end banks Menu -->
                @endcan
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarReports" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarCategories">
                        <i data-feather="grid" class="icon-dual"></i> <span>@lang('admin.reports.title')</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarReports">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('dashboard.reports.vendors-orders') }}"
                                    class="nav-link">@lang('admin.reports.vendors-orders.title')</a>
                            </li>
                        </ul>
                    </div>
                </li> <!-- end categories Menu -->
                @can('user-permissions')
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebaruserPermissions" data-bs-toggle="collapse"
                            role="button" aria-expanded="false" aria-controls="sidebarCategories">
                            <i data-feather="grid" class="icon-dual"></i> <span>@lang('admin.user_permissions.users.users')</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebaruserPermissions">
                            <ul class="nav nav-sm flex-column">
                                @can('users')
                                    <li class="nav-item">
                                        <a href="{{ route('dashboard.users.index') }}"
                                            class="nav-link">@lang('admin.user_permissions.users.users')</a>
                                    </li>
                                @endcan
                                @can('roles-permissions')
                                    <li class="nav-item">
                                        <a href="{{ route('dashboard.role.index') }}" class="nav-link">@lang('admin.user_permissions.users.user_roles')</a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li> <!-- end categories Menu -->
                @endcan
                @can('categories')
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarCategories" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="sidebarCategories">
                            <i data-feather="grid" class="icon-dual"></i> <span>@lang('admin.categories.categories')</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarCategories">
                            <ul class="nav nav-sm flex-column">
                                @can('categories')
                                    <li class="nav-item">
                                        <a href="{{ route('dashboard.categories.index') }}"
                                            class="nav-link">@lang('admin.categories.categories')</a>
                                    </li>
                                @endcan
                                <li class="nav-item">
                                    <a href="{{ route('dashboard.categories.trashes') }}"
                                        class="nav-link">@lang('admin.categories.categories_deleted')</a>
                                </li>
                            </ul>
                        </div>
                    </li> <!-- end categories Menu -->
                @endcan
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarProducts" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarProducts">
                        <i data-feather="grid" class="icon-dual"></i> <span>@lang('admin.products.products')</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarProducts">
                        <ul class="nav nav-sm flex-column">
                            @can('products')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('dashboard.products.index') }}">
                                        <span>@lang('admin.products.products')</span>
                                    </a>
                                </li> <!-- end certificates Menu -->
                            @endcan
                            @can('certificates')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('dashboard.certificates.index') }}">
                                        <span>@lang('admin.certificates.certificates')</span>
                                    </a>
                                </li> <!-- end certificates Menu -->
                            @endcan
                            @can('product-types')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('dashboard.types.index') }}">
                                        <span>@lang('admin.types.types')</span>
                                    </a>
                                </li> <!-- end certificates Menu -->
                            @endcan
                            @can('attributeGroups')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('dashboard.attributeGroups.index') }}">
                                        <span>@lang('admin.attributeGroups.attributeGroups')</span>
                                    </a>
                                </li> <!-- end certificates Menu -->
                            @endcan
                            @can('attributes')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('dashboard.attributes.index') }}">
                                        <span>@lang('admin.attributes.attributes')</span>
                                    </a>
                                </li> <!-- end certificates Menu -->
                            @endcan
                            @can('units')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('dashboard.units.index') }}">
                                        <span>@lang('admin.units.units')</span>
                                    </a>
                                </li> <!-- end certificates Menu -->
                            @endcan
                            @can('packages')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('dashboard.packages.index') }}">
                                        <span>@lang('admin.packages.packages')</span>
                                    </a>
                                </li> <!-- end certificates Menu -->
                            @endcan
                            @can('sizes')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('dashboard.sizes.index') }}">
                                        <span>@lang('admin.sizes.sizes')</span>
                                    </a>
                                </li> <!-- end certificates Menu -->
                            @endcan
                            @can('qualities')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('dashboard.qualities.index') }}">
                                        <span>@lang('admin.qualities.qualities')</span>
                                    </a>
                                </li> <!-- end certificates Menu -->
                            @endcan
                            @can('reviews')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('dashboard.reviews.index') }}">
                                        <span>@lang('admin.reviews.reviews')</span>
                                    </a>
                                </li> <!-- end reviews Menu -->
                            @endcan
                        </ul>
                    </div>
                </li> <!-- end sidebarProducts Menu -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarVendors" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarProducts">
                        <i data-feather="grid" class="icon-dual"></i> <span>@lang('admin.vendors.manage_vendors')</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarVendors">
                        <ul class="nav nav-sm flex-column">
                            @can('vendors')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('dashboard.vendors.index') }}">
                                        <span>@lang('admin.vendors.vendor_shop')</span>
                                    </a>
                                </li> <!-- end certificates Menu -->
                            @endcan
                            @can('sub-vendors')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('dashboard.sub-vendors.index') }}">
                                        <span>@lang('vendor.sub.sub_title')</span>
                                    </a>
                                </li> <!-- end certificates Menu -->
                            @endcan
                            @can('vendor-wallet')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('dashboard.vendorWallets.index') }}">
                                        <span>@lang('admin.vendorWallets.vendorWallets')</span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </div>
                </li> <!-- end sidebarProducts Menu -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarVendorss" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarVendorss">
                        <i data-feather="grid" class="icon-dual"></i> <span>@lang('admin.transactions.transactions_all')</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarVendorss">
                        <ul class="nav nav-sm flex-column">
                            @can('transactions')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('dashboard.transactions.index') }}">
                                        <span>@lang('admin.transactions.transactions')</span>
                                    </a>
                                </li> <!-- end certificates Menu -->
                            @endcan
                        </ul>
                    </div>
                </li> <!-- end sidebarProducts Menu -->

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarShipping" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarShipping">
                        <i data-feather="grid" class="icon-dual"></i> <span>@lang('admin.shippingMethods.shippingMethods')</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarShipping">
                        <ul class="nav nav-sm flex-column">
                            @can('shipping-methods')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('dashboard.shippingMethods.index') }}">
                                        <span>@lang('admin.shippingMethods.shippingMethods')</span>
                                    </a>
                                </li> <!-- end certificates Menu -->
                            @endcan
                            @can('shipping-wallet')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('dashboard.shipping-wallets') }}">
                                        <span>@lang('admin.shippingWallets.shippingWallets')</span>
                                    </a>
                                </li> <!-- end certificates Menu -->
                            @endcan
                        </ul>
                    </div>
                </li> <!-- end sidebarProducts Menu -->
                <li class="menu-title"><span>@lang('translation.menu_general')</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarCountries" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarCountries">
                        <i data-feather="grid" class="icon-dual"></i> <span>@lang('admin.countries.countries_and_regions')</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarCountries">
                        <ul class="nav nav-sm flex-column">
                            @can('countries')
                                <li class="nav-item">
                                    <a href="{{ route('dashboard.countries.index') }}"
                                        class="nav-link">@lang('admin.countries.countries')</a>
                                </li>
                            @endcan
                            @can('regions')
                                <li class="nav-item">
                                    <a href="{{ route('dashboard.regions.index') }}"
                                        class="nav-link">@lang('admin.regions.regions')</a>
                                </li>
                            @endcan
                            @can('cities')
                                <li class="nav-item">
                                    <a href="{{ route('dashboard.cities.index') }}"
                                        class="nav-link">@lang('admin.cities.cities')</a>
                                </li>
                            @endcan
                        </ul>
                    </div>
                </li> <!-- end categories Menu -->
                @can('currencies')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard.currencies.index') }}">
                            <i data-feather="grid" class="icon-dual"></i> <span>@lang('admin.currencies.currencies')</span>
                        </a>
                    </li> <!-- end categories Menu -->
                @endcan
                @can('languages')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard.languages.index') }}">
                            <i data-feather="grid" class="icon-dual"></i> <span>@lang('admin.languages.languages')</span>
                        </a>
                    </li> <!-- end languages Menu -->
                @endcan


                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarFrontPages" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarCountries">
                        <i data-feather="grid" class="icon-dual"></i> <span>@lang('admin.front_pages')</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarFrontPages">
                        <ul class="nav nav-sm flex-column">
                            @can('aboutUss')
                                <li class="nav-item">
                                    <a href="{{ route('dashboard.aboutUss.index') }}"
                                        class="nav-link">@lang('admin.about.page_title')</a>
                                </li>
                            @endcan
                            @can('contact')
                                <li class="nav-item">
                                    <a href="{{ route('dashboard.contact.index') }}"
                                        class="nav-link">@lang('admin.contacts.page_title')</a>
                                </li>
                            @endcan
                            @can('privacy-policy')
                                <li class="nav-item">
                                    <a href="{{ route('dashboard.privacy-policy.index') }}"
                                        class="nav-link">@lang('admin.privacy_policy.page_title')</a>
                                </li>
                            @endcan
                            @can('terms-conditions')
                                <li class="nav-item">
                                    <a href="{{ route('dashboard.terms-conditions.index') }}"
                                        class="nav-link">@lang('admin.terms-conditions.page_title')</a>
                                </li>
                            @endcan

                            @can('fags')
                                <li class="nav-item">
                                    <a href="{{ route('dashboard.fags.index') }}" class="nav-link">@lang('admin.fags.page_title')</a>
                                </li>
                            @endcan
                            <li class="nav-item">
                                <a href="{{ route('dashboard.fast-shipping.index') }}"
                                    class="nav-link">@lang('admin.fast_shipping.page_title')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('dashboard.how-to-special-order.index') }}"
                                    class="nav-link">@lang('admin.how-to-special-order.page_title')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('dashboard.how-to-negotiate-price.index') }}"
                                    class="nav-link">@lang('admin.how-to-negotiate-price.page_title')</a>
                            </li>
                        </ul>
                    </div>
                </li> <!-- end Front Pages Menu -->
                @can('settings')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard.settings.show') }}">
                            <i data-feather="grid" class="icon-dual"></i> <span>@lang('admin.settings.settings')</span>
                        </a>
                    </li> <!-- end languages Menu -->
                @endcan

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>
