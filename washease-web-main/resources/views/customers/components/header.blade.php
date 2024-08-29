<!-- ========== Topbar Start ========== -->
<div class="navbar-custom">
    <div class="topbar container-fluid">
        <div class="d-flex align-items-center gap-1">

            <!-- Topbar Brand Logo -->
            <div class="logo-topbar">
                <!-- Logo light -->
                <a href="{{ route('customer.dashboard') }}" class="logo-light">
                    <span class="logo-lg">
                        <img src="{{ asset('assets/img/dark-mode-washease.png') }}"/>
                    </span>
                    <span class="logo-sm">
                        <img src="{{ asset('assets/img/dark-mode-washease.png') }}"/>
                    </span>
                </a>

                <!-- Logo Dark -->
                <a href="{{ route('customer.dashboard') }}" class="logo-dark">
                    <span class="logo-lg">
                         <img src="{{ asset('assets/img/dark-mode-washease.png') }}"/>
                    </span>
                    <span class="logo-sm">
                       <img src="{{ asset('assets/img/dark-mode-washease.png') }}"/>
                    </span>
                </a>
            </div>

            <!-- Sidebar Menu Toggle Button -->
            <button class="button-toggle-menu">
                <i class="mdi mdi-menu"></i>
            </button>

            <!-- Page Title -->
            <h4 class="page-title d-none d-sm-block">{{ $title ?? 'Dashboard' }}</h4>
        </div>

        <ul class="topbar-menu d-flex align-items-center gap-3">


            <li class="d-none d-sm-inline-block">
                <div class="nav-link" id="light-dark-mode">
                    <i class="ri-moon-line fs-22"></i>
                </div>
            </li>

            <li class="dropdown">
                <a class="nav-link dropdown-toggle arrow-none nav-user" data-bs-toggle="dropdown" href="#"
                   role="button" aria-haspopup="false" aria-expanded="false">
                    <span class="account-user-avatar">
                        <img src="{{ Auth::user()->avatar }}" alt="user-image" width="32" class="rounded-circle">
                    </span>
                    <span class="d-lg-block d-none">
                        <h5 class="my-0 fw-normal">{{ Auth::user()->name }}<i
                                class="ri-arrow-down-s-line fs-22 d-none d-sm-inline-block align-middle"></i></h5>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated profile-dropdown">
                    <!-- item-->
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">Welcome !</h6>
                    </div>

                    <!-- item-->
                    <a href="{{ route('customer.my.profile', Auth::id()) }}" class="dropdown-item">
                        <i class="ri-account-pin-circle-line fs-16 align-middle me-1 "></i>
                        <span>My Account</span>
                    </a>

                    <!-- item-->
                    <a href="{{ route('auth.logout.web') }}" class="dropdown-item">
                        <i class="ri-logout-circle-r-line align-middle me-1"></i>
                        <span>Logout</span>
                    </a>
                </div>
            </li>
        </ul>
    </div>
</div>
<!-- ========== Topbar End ========== -->
