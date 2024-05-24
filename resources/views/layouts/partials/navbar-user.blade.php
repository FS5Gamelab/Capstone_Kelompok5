<header class="mb-5">
    <div class="header-top">
        <div class="container">
            <div class="logo tw-hidden xl:tw-block">
                <a href="#"><img src="{{ asset('/static/images/logo/logo.svg') }}" alt="Logo"></a>
            </div>
            <div class="header-top-right">
                <div class="me-2">
                    <a class="nav-link position-relative me-4" href="/cart">
                        <i class="bi bi-cart bi-sub fs-4 text-gray-600 "></i>

                        <span class="position-absolute top-40 start-100 translate-middle-x badge rounded-pill bg-danger"
                            id="cartCount">
                            {{ $cartCount }}
                        </span>

                    </a>
                </div>
                <div class="theme-toggle d-flex gap-2 align-items-center mt-2 me-4">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                        aria-hidden="true" role="img" class="iconify iconify--system-uicons" width="20"
                        height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 21 21">
                        <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path
                                d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2"
                                opacity=".3"></path>
                            <g transform="translate(-210 -1)">
                                <path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>
                                <circle cx="220.5" cy="11.5" r="4"></circle>
                                <path d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2"></path>
                            </g>
                        </g>
                    </svg>
                    <div class="form-check form-switch fs-6">
                        <input class="form-check-input  me-0" type="checkbox" id="toggle-dark" style="cursor: pointer">
                        <label class="form-check-label"></label>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                        aria-hidden="true" role="img" class="iconify iconify--mdi" width="20" height="20"
                        preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z">
                        </path>
                    </svg>
                </div>
                @if (auth()->user())
                    <div class="dropdown !tw-absolute !tw-right-20 xl:!tw-static ">
                        <a href="#" id="topbarUserDropdown"
                            class="user-dropdown d-flex align-items-center dropend dropdown-toggle "
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="avatar avatar-md2">
                                <img src="{{ asset('/static/images/faces/1.jpg') }}" alt="Avatar">
                            </div>
                            <div class="text tw-hidden sm:tw-block">
                                <h6 class="user-dropdown-name">{{ auth()->user()->name }}</h6>
                                <p class="user-dropdown-status text-sm text-muted text-capitalize">
                                    {{ auth()->user()->role }}</p>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg" aria-labelledby="topbarUserDropdown">
                            <li><a class="dropdown-item" href="#">My Account</a></li>
                            <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="/logout" method="post" class="dropdown-item">
                                    @csrf
                                    <i class="icon-mid bi bi-box-arrow-left me-2"></i>
                                    <button type="submit"
                                        class="border-0 bg-transparent tw-text-gray-950 dark:tw-text-gray-400">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="/login" class="btn btn-primary !tw-absolute !tw-right-20 xl:!tw-static ">Login</a>
                @endif


                <a href="#" class="burger-btn d-block d-xl-none tw-absolute tw-right-10" id="trigger-burger">
                    <i class="bi bi-justify fs-3"></i>
                </a>

                <!-- Burger button responsive -->
            </div>
        </div>
    </div>
    <nav class="main-navbar" id="main-navbar">
        <div class="container d-flex align-items-center justify-content-center">
            <ul>
                <li class="menu-item">
                    <a href="/" class='menu-link'>
                        Home
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class='menu-link'>
                        About
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class='menu-link'>
                        Menu
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class='menu-link'>
                        Delivery
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class='menu-link'>
                        Private Dining
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class='menu-link'>
                        Blog
                    </a>
                </li>


                {{-- <div
                    class="submenu">
                    <!-- Wrap to submenu-group-wrapper if you want 3-level submenu. Otherwise remove it. -->
                    <div class="submenu-group-wrapper">
                        <ul class="submenu-group">
                            
                            <li
                                class="submenu-item">
                                <a href="#"
                                    class='submenu-link'></a>
                                <!-- 3 Level Submenu -->
                                <ul class="subsubmenu">
                                    
                                    <li class="subsubmenu-item ">
                                        <a href="#" class="subsubmenu-link"></a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div> --}}
            </ul>
            <ul class="ms-auto mb-lg-0">
                <li class="menu-item tw-ms-0 xl:tw-ms-auto">
                    <a href="#" class='menu-link'>
                        001 (313) 324 567
                        <span
                            class=" tw-bg-white rounded dark:tw-bg-gray-700 tw-shadow tw-p-1 d-flex align-items-center">
                            <i class="bi bi-telephone-fill tw-text-gray-500 dark:tw-text-white tw-text-xs ms-1"></i>
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</header>
