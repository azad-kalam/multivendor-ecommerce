<aside id="sidebar" class="sidebar mt-3">
    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <!-- Admin menu start here -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#admin-nav" data-bs-toggle="collapse" href="#">
                <i class="fa-solid fa-user-tie text-danger"></i>
                <span>Admin</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="admin-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('admin.details.index') }}">
                        <i class="bi bi-circle"></i><span>All Admin</span>
                    </a>
                </li>
            </ul>
        </li>
        <!-- Admin menu end here -->

        <!-- Vendor menu start here -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#vendor-nav" data-bs-toggle="collapse" href="#">
                <i class="fa-solid fa-user"></i>
                <span>Vendors</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="vendor-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('admin.all_vendor.index') }}">
                        <i class="bi bi-circle"></i><span>All Vendor</span>
                    </a>
                </li>
            </ul>
        </li>
        <!-- Vendor menu end here -->

        <!-- Customer menu start here -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#customer-nav" data-bs-toggle="collapse" href="#">
                <i class="fa-regular fa-user"></i>
                <span>Customers</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="customer-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('admin.all_user.index') }}">
                        <i class="bi bi-circle"></i><span>All Customer</span>
                    </a>
                </li>
            </ul>
        </li>
        <!-- Customer menu end here -->

        <!-- banner menu start here -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#banner-nav" data-bs-toggle="collapse" href="#">

                <i class="fa-solid fa-photo-film"></i>
                <span>Banners</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="banner-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('admin.banners.CRUD.index') }}">
                        <i class="bi bi-circle"></i>
                        <span>All Banners</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.banners.CRUD.create') }}">
                        <i class="bi bi-circle"></i>
                        <span>Add Banner</span>
                    </a>
                </li>
            </ul>
        </li>
        <!-- banner menu end here -->

        <!-- brand menu start here -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#brand-nav" data-bs-toggle="collapse" href="#">
                <i class="fa-brands fa-apple" style="font-size:22px;"></i>
                <span>Brands</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="brand-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('admin.brands.CRUD.index') }}">
                        <i class="bi bi-circle"></i>
                        <span>All Brands</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.brands.CRUD.create') }}">
                        <i class="bi bi-circle"></i>
                        <span>Add Brand</span>
                    </a>
                </li>
            </ul>
        </li>
        <!-- brand menu end here -->

        <!-- category menu start here -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-menu-button-wide"></i>
                <span>Categories</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">

                <li>
                    <a href="{{ route('admin.categories.CRUD.index') }}">
                        <i class="bi bi-circle"></i>
                        <span>All Category</span>
                    </a>
                </li>

                <li>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#admin_createCategory_modal">
                        <i class="bi bi-circle"></i>
                        <span>Add Category</span>
                    </a>
                </li>

                <li>
                    <a href="#" class="editIcon">
                        <i class="bi bi-circle"></i>
                        <span>Edit Category</span>
                    </a>
                </li>

                <li>
                    <a href="#" class="editIcon">
                        <i class="bi bi-circle"></i>
                        <span>Delete Category</span>
                    </a>
                </li>

            </ul>
        </li>
        <!-- category menu end here -->

        <!-- sub-category menu start here -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-journal-text"></i>
                <span>Sub-Categories</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('admin.sub_categories.CRUD.index') }}">
                        <i class="bi bi-circle"></i>
                        <span>All Sub-Category</span>
                    </a>
                </li>

                <li>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#admin_createSubCategory_modal">
                        <i class="bi bi-circle"></i>
                        <span>Add Sub-Category</span>
                    </a>
                </li>

                <li>
                    <a href="#" class="subCatEditIcon editIcon" id="subCatEditIcon">
                        <i class="bi bi-circle"></i>
                        <span>Edit Sub-Category</span>
                    </a>
                </li>

                <li>
                    <a href="#" class="subCatDeleteIcon" id="subCatDeleteIcon">
                        <i class="bi bi-circle"></i>
                        <span>Delete Sub-Category</span>
                    </a>
                </li>
            </ul>
        </li>
        <!-- sub-category menu end here -->

        <!-- color menu start here -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#color-nav" data-bs-toggle="collapse" href="#">
                <i class="fa-solid fa-layer-group" style="font-size:19px;"></i>
                <span>Colors</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="color-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('admin.colors.CRUD.index') }}">
                        <i class="bi bi-circle"></i>
                        <span>All Colors</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.colors.CRUD.create') }}">
                        <i class="bi bi-circle"></i>
                        <span>Add Color</span>
                    </a>
                </li>
            </ul>
        </li>
        <!-- color menu end here -->

        <!-- model menu start here -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#product_model_nav" data-bs-toggle="collapse"
                href="#">
                <i class="fa-solid fa-cube"></i>
                <span>Models</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="product_model_nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('admin.product_models.CRUD.index') }}">
                        <i class="bi bi-circle"></i>
                        <span>All Models</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.product_models.CRUD.create') }}">
                        <i class="bi bi-circle"></i>
                        <span>Add Models</span>
                    </a>
                </li>
            </ul>
        </li>
        <!-- model menu end here -->

        <!-- product menu end here -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#my-products" data-bs-toggle="collapse" href="#">
                <i class="bi bi-layout-text-window-reverse"></i>
                <span>Products</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="my-products" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('admin.products.CRUD.index') }}">
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
        <!-- product menu end here -->

        <!-- size menu start here -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#size-nav" data-bs-toggle="collapse" href="#">
                <i class="fa-solid fa-ruler-combined"></i>
                <span>Sizes</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="size-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('admin.sizes.CRUD.index') }}">
                        <i class="bi bi-circle"></i>
                        <span>All Size</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.sizes.CRUD.create') }}">
                        <i class="bi bi-circle"></i>
                        <span>Add Size</span>
                    </a>
                </li>
            </ul>
        </li>
        <!-- size menu end here -->

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-bar-chart"></i><span>Orders</span><i class="bi bi-chevron-down ms-auto"></i>
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

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-gem"></i><span>Shipping</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="icons-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="icons-bootstrap.html">
                        <i class="bi bi-circle"></i><span>Bootstrap Icons</span>
                    </a>
                </li>
                <li>
                    <a href="icons-remix.html">
                        <i class="bi bi-circle"></i><span>Remix Icons</span>
                    </a>
                </li>
                <li>
                    <a href="icons-boxicons.html">
                        <i class="bi bi-circle"></i><span>Boxicons</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Icons Nav -->

        <li class="nav-heading">Pages</li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="users-profile.html">
                <i class="bi bi-person"></i>
                <span>Profile</span>
            </a>
        </li><!-- End Profile Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="pages-faq.html">
                <i class="bi bi-question-circle"></i>
                <span>F.A.Q</span>
            </a>
        </li><!-- End F.A.Q Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="pages-contact.html">
                <i class="bi bi-envelope"></i>
                <span>Contact</span>
            </a>
        </li><!-- End Contact Page Nav -->

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

        <li class="nav-item">
            <a class="nav-link collapsed" href="pages-error-404.html">
                <i class="bi bi-dash-circle"></i>
                <span>Error 404</span>
            </a>
        </li><!-- End Error 404 Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="pages-blank.html">
                <i class="bi bi-file-earmark"></i>
                <span>Blank</span>
            </a>
        </li><!-- End Blank Page Nav -->

    </ul>

</aside>
