 <!-- global header start here -->
 <header class="container-fluid py-2 fixed-top bg-white" style="box-shadow: 0px 0px 1px red;">
     <nav class="navbar navbar-expand-lg custom_nav-container">
         <!-- logo -->
         <a href="" class="navbar-brand d-flex align-items-center justify-content-center">
             <img src="{{ asset('assets/images/homepage/img/logo.png') }}" class="w-10 ms-1" alt="home Logo" />
             <small class="bg-info border border-1 border-dark rounded-2 px-1 ms-1">MART</small>
         </a>

         <div class="container-fluid d-flex justify-content-between align-items-center p-0">
             <!-- offcanvas trigger button -->
             <button class="btn btn-outline-primary ms-0 ms-lg-5 me-5 px-3 py-1" type="button"
                 data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions"
                 aria-controls="offcanvasWithBothOptions">
                 <i class="fa-solid fa-bars"></i>
             </button>

             <!-- collapsible button -->
             <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                 data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                 aria-label="Toggle navigation">
                 <span class="navbar-toggler-icon"></span>
             </button>
         </div>

         <div class="collapse navbar-collapse" id="navbarSupportedContent">
             <ul class="navbar-nav ms-auto mb-lg-0">
                 <li class="nav-item active">
                     <a class="navbar_btn nav-link" href="{{ route('homepage.index') }}">Home <span
                             class="visually-hidden">(current)</span>
                     </a>
                 </li>

                 <li class="nav-item dropdown custom_dropdown">
                     <a class="navbar_btn nav-link dropdown-toggle" href="#" id="productDropdown" role="button"
                         data-bs-toggle="dropdown" aria-expanded="false">
                         All Categories
                     </a>

                     <ul class="dropdown-menu custom_dropdown_menu" aria-labelledby="productDropdown">
                         @foreach ($global_categories as $category)
                             <li class="dropdown-submenu text-start">

                                 <a class="dropdown-item dropdown-toggle"
                                     href="{{ route('frontend.category_wise_product_show', ['id' => $category->id, 'name' => $category->name]) }}">
                                     {{ $category->name }}
                                 </a>

                                 <ul class="dropdown-menu text-start"
                                     style="width:176px; max-height:45vh; overflow-y:auto;">
                                     @foreach ($category->subcategories as $subcategory)
                                         <li>
                                             <a class="dropdown-item"
                                                 href="{{ route('frontend.subcategory_wise_product_show', ['id' => $subcategory->id, 'name' => $subcategory->subcategory_name]) }}">
                                                 {{ $subcategory->subcategory_name }}
                                             </a>
                                         </li>
                                     @endforeach
                                 </ul>
                             </li>
                         @endforeach
                     </ul>
                 </li>

                 <li class="nav-item dropdown custom_dropdown">
                     <a class="navbar_btn nav-link dropdown-toggle" href="#" id="productDropdown" role="button"
                         data-bs-toggle="dropdown" aria-expanded="false">
                         Pages
                     </a>

                     <ul class="dropdown-menu custom_dropdown_menu" aria-labelledby="productDropdown"
                         style="width: 100px;">
                         <li class="text-start"><a class="dropdown-item" href="#">About Us</a></li>
                         <li class="text-start"><a class="dropdown-item" href="#">Contact Us</a></li>
                     </ul>
                 </li>

                 <li class="nav-item position-relative">
                     <a class="navbar_btn nav-link position-relative" href="{{ route('frontend.carts.index') }}">
                         <i class="fas fa-cart-shopping" style="font-size: 23px; color: #333;"></i>

                         @if (cart_item_quantity())
                             @if (cart_item_quantity() > 0)
                                 <span class="cart-count cart_badge">
                                     {{ cart_item_quantity() }}
                                 </span>
                             @endif
                         @endif
                     </a>
                 </li>

                 <!-- Action start here-->
                 <li class="nav-item dropdown custom_dropdown">
                     <a class="navbar_btn nav-link dropdown-toggle text-danger" href="#" id="userDropdownToggle"
                         data-bs-toggle="dropdown" aria-expanded="false">
                         Action
                     </a>
                     @include('partials.auth.action')
                 </li>
                 <!-- Action end here-->
             </ul>
         </div>
     </nav>
 </header>
 <!-- global header end here -->

 @include('auth.login')
 @include('auth.register')
 @include('auth.confirm-password')
 @include('auth.forgot-password')
 {{-- @include('auth.reset-password') --}}
 @include('auth.verify-email')
