<!-- Navbar Area -->
<div class="navbar-area fixed-top">
    <!-- Menu For Mobile Device -->
    <div class="mobile-nav">
        <a href="" class="logo">
            WashEase Laundry
        </a>
    </div>

    <!-- Menu For Desktop Device -->
    <div class="main-nav">
        <div class="container">
            <nav class="navbar navbar-expand-md navbar-light">
                <a class="navbar-brand" href="{{ route('home') }}">
                    <img src="{{ asset('assets/img/dark-mode-washease.png') }}" class="w-25">
                </a>
                <div class="collapse navbar-collapse mean-menu" id="navbarSupportedContent">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="{{ route('home') }}" class="nav-link">Home</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('about') }}" class="nav-link">About</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('services') }}" class="nav-link">Services</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('contact') }}" class="nav-link">Contact</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link dropdown-toggle">Sign in as  <i class='bx bx-chevron-down'></i></a>
                            <ul class="dropdown-menu">
                                <li class="nav-item">
                                    <a href="{{ route('customer.login') }}" class="nav-link">Customer</a>
                                    <a href="{{ route('filament.laundry-shop.auth.login') }}" class="nav-link">Laundry Shop</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <div class="side-nav">
                        <a href="{{ route('register') }}">Signup Here</a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
<!-- End Navbar Area -->
