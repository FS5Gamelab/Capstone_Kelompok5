<div id="sidebar" class="active sidebar-desktop">
    <div class="sidebar-wrapper !tw-static !tw-h-full !tw-w-full active rounded-4 ">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between align-items-center ">
                <div class="logo !tw-hidden md:!tw-flex">
                    <a href="/template"><img src="{{ asset('/static/images/logo/logo.svg') }}" alt="Logo"
                            srcset=""></a>
                </div>
                <div class="sidebar-title md:!tw-hidden !tw-flex tw-text-lg">Checkout History</div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu tw-inline-flex !tw-overflow-auto md:tw-block">
                <li class="sidebar-title md:!tw-block !tw-hidden">Checkout History</li>
                <li
                    class="sidebar-item !tw-text-nowrap {{ Route::currentRouteName() == 'checkout-index' ? 'active' : '' }}">
                    <a href="/checkout" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>All</span>
                    </a>
                </li>
                <li
                    class="sidebar-item !tw-text-nowrap {{ Route::currentRouteName() == 'checkout-pending' ? 'active' : '' }}">
                    <a href="/checkout/pending" class='sidebar-link'>
                        <i class="bi bi-cash-stack"></i>
                        <span>Waiting for Payment</span>
                    </a>
                </li>
                <li
                    class="sidebar-item !tw-text-nowrap {{ Route::currentRouteName() == 'checkout-failed' ? 'active' : '' }}">
                    <a href="/checkout/failed" class='sidebar-link'>
                        <i class="bi bi-x-circle-fill"></i>
                        <span>Failed</span>
                    </a>
                </li>
                <li
                    class="sidebar-item !tw-text-nowrap {{ Route::currentRouteName() == 'checkout-prepare' ? 'active' : '' }}">
                    <a href="/checkout/prepare" class='sidebar-link'>
                        <i class="bi bi-clock-fill"></i>
                        <span>Prepared</span>
                        <span class="mx-3">-</span>
                        <i class="bi bi-scooter"></i>
                        <span>Deliver</span>
                    </a>
                </li>
                <li
                    class="sidebar-item !tw-text-nowrap {{ Route::currentRouteName() == 'checkout-success' ? 'active' : '' }}">
                    <a href="/checkout/success" class='sidebar-link'>
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Success</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
