<aside id="sidebar" class="sidebar mt-3">
    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('vendor.dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        {{-- <li class="nav-item"> --}}
        <li class="nav-item {{ Request::is('vendor/details*') ? 'active' : '' }}">
            <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
                <i class="fa-solid fa-user"></i>
                <span>Vendor</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('vendor.details.index') }}">
                        <i class="bi bi-circle"></i><span>All Vendor</span>
                    </a>
                </li>
            </ul>
        </li>

        {{-- product toggle start here --}}
        <li class="nav-item {{ Request::is('vendor/products*') ? 'active' : '' }}">
            <a class="nav-link collapsed" data-bs-target="#vendor-products" data-bs-toggle="collapse" href="#">
                <i class="bi bi-layout-text-window-reverse"></i>
                <span>Products</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="vendor-products" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('vendor.products.index') }}">
                        <i class="bi bi-circle"></i><span>All Products</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.products.CRUD.create') }}">
                        <i class="bi bi-circle"></i><span>Add Product</span>
                    </a>
                </li>
            </ul>
        </li>
        {{-- product toggle end here --}}


        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-bar-chart"></i><span>Discount %</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="charts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="charts-chartjs.html">
                        <i class="bi bi-circle"></i><span>Chart.js</span>
                    </a>
                </li>
                <li>
                    <a href="charts-apexcharts.html">
                        <i class="bi bi-circle"></i><span>ApexCharts</span>
                    </a>
                </li>
                <li>
                    <a href="charts-echarts.html">
                        <i class="bi bi-circle"></i><span>ECharts</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-heading">Pages</li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="users-profile.html">
                <i class="bi bi-person"></i>
                <span>Profile</span>
            </a>
        </li><!-- End Profile Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="pages-register.html">
                <i class="bi bi-card-list"></i>
                <span>Register</span>
            </a>
        </li><!-- End Register Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="pages-login.html">
                <i class="bi bi-box-arrow-in-right"></i>
                <span>Login</span>
            </a>
        </li><!-- End Login Page Nav -->

    </ul>
</aside>
