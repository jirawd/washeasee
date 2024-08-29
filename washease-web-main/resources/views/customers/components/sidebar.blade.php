<!-- Left Sidebar Start -->
<div class="leftside-menu">

    <!-- Logo Light -->
    <a href="{{ route('customer.dashboard') }}" class="logo logo-light">
                    <span class="logo-lg">
                          <img src="{{ asset('assets/img/dark-mode-washease.png') }}" style="width: 150px; height: 150px;"/>
                    </span>
        <span class="logo-sm">
                        WES
                    </span>
    </a>

    <!-- Logo Dark -->
    <a href="{{ route('customer.dashboard') }}" class="logo logo-dark">
                    <span class="logo-lg">
                       <img src="{{ asset('assets/img/dark-mode-washease.png') }}" style="width: 150px; height: 150px;"/>
                    </span>
        <span class="logo-sm">
                       WES
                    </span>
    </a>

    <!-- Sidebar -->
    <div data-simplebar>
        <ul class="side-nav">
            <li class="side-nav-title">Main</li>

            <li class="side-nav-item">
                <a href="{{ route('customer.dashboard') }}" class="side-nav-link">
                    <i class="ri-dashboard-2-line"></i>
                    <span> Dashboard </span>
                    <span class="badge bg-success float-end">9+</span>
                </a>
            </li>

            <li class="side-nav-title">Modules</li>

            <li class="side-nav-item">
                <a href="{{ route('customer.laundry.shop') }}" class="side-nav-link">
                    <i class="ri-calendar-line"></i>
                    <span> Schedule a Laundry </span>

                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('customer.my-laundry') }}" class="side-nav-link">
                    <i class="ri-calendar-line"></i>
                    <span> My Laundry </span>

                </a>
            </li>

        </ul>
    </div>
</div>
<!-- Left Sidebar End -->
