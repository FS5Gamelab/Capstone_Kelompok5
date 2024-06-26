<nav class="navbar navbar-expand navbar-light navbar-top">
    <div class="container-fluid">
        <a href="#" class="burger-btn d-block">
            <i class="bi bi-justify fs-3"></i>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-lg-0">
            </ul>
            <div class="dropdown">
                <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="user-menu d-flex">
                        <div class="user-name text-end me-3 tw-hidden sm:tw-block">
                            <h6 class="mb-0 text-gray-600">{{ Auth::user()->name }}</h6>
                            <p class="mb-0 text-sm text-gray-600 text-capitalize">{{ Auth::user()->role }}</p>
                        </div>
                        <div class="user-img d-flex align-items-center">
                            <div class="avatar avatar-md">
                                @if (Auth::user()->profile_image)
                                    <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" alt="Avatar"
                                        class="nav-img">
                                @else
                                    <img src="{{ asset('/static/images/faces/1.jpg') }}" alt="Avatar" class="nav-img">
                                @endif
                            </div>
                        </div>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton"
                    style="min-width: 11rem;">
                    <li>
                        <a class="dropdown-item" href="/homepage"><i class="icon-mid bi bi-house-fill me-2"></i>
                            Homepage
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="/profile"><i class="icon-mid bi bi-person me-2"></i> My
                            Profile
                        </a>
                    </li>

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
        </div>
    </div>
</nav>
