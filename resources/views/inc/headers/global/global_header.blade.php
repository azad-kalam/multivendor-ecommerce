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
                     <a class="nav-link" href="{{ route('homepage.index') }}">Home <span
                             class="visually-hidden">(current)</span>
                     </a>
                 </li>

                 <li class="nav-item dropdown custom_dropdown">
                     <a class="nav-link dropdown-toggle" href="#" id="productDropdown" role="button"
                         data-bs-toggle="dropdown" aria-expanded="false">
                         All Categories
                     </a>

                     <ul class="dropdown-menu custom_dropdown_menu" aria-labelledby="productDropdown">
                         @foreach ($categories as $category)
                             <li class="dropdown-submenu text-start">
                                 <a class="dropdown-item dropdown-toggle" href="#" role="button"
                                     data-bs-toggle="dropdown">
                                     {{ $category->name }}
                                 </a>

                                 <ul class="dropdown-menu text-start"
                                     style="width: 176px; max-height: 45vh; overflow-y: auto; scroll-behavior: smooth;">
                                     @forelse ($category->subcategories as $subcategory)
                                         <li class="text-start">
                                             <a class="dropdown-item" href="#">
                                                 {{ $subcategory->subcategory_name }}
                                             </a>
                                         </li>
                                     @empty
                                         <li class="text-start">
                                             <a class="dropdown-item" href="#">No subcategories</a>
                                         </li>
                                     @endforelse
                                 </ul>
                             </li>
                         @endforeach
                     </ul>
                 </li>

                 <li class="nav-item dropdown custom_dropdown">
                     <a class="nav-link dropdown-toggle" href="#" id="productDropdown" role="button"
                         data-bs-toggle="dropdown" aria-expanded="false">
                         Pages
                     </a>

                     <ul class="dropdown-menu custom_dropdown_menu" aria-labelledby="productDropdown"
                         style="width: 100px;">
                         <li class="text-start"><a class="dropdown-item" href="#">About Us</a></li>
                         <li class="text-start"><a class="dropdown-item" href="#">Contact Us</a></li>
                     </ul>
                 </li>

                 <li class="nav-item">
                     <a class="nav-link" href="#">
                         <i class="fas fa-cart-shopping" style="font-size: 23px; color: #333;"></i>
                     </a>
                 </li>

                 <!-- Action start here-->
                 <li class="nav-item dropdown custom_dropdown">
                     <a class="nav-link dropdown-toggle text-danger" href="#" id="userDropdownToggle"
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




 {{-- <li class="nav-item dropdown custom_dropdown">
     <a class="nav-link dropdown-toggle" href="#" id="productDropdown" role="button"
         data-bs-toggle="dropdown" aria-expanded="false">
         All Categories
     </a>

     <ul class="dropdown-menu custom_dropdown_menu" aria-labelledby="productDropdown">
         <!-- Men's -->
         <li class="dropdown-submenu text-start">
             <a class="dropdown-item dropdown-toggle" href="#" id="mensDropdown" role="button"
                 data-bs-toggle="dropdown" aria-expanded="false">
                 Men's
             </a>

             <ul class="dropdown-menu text-start"
                 style="width: 176px; height: 45vh; overflow-y: auto; scroll-behavior: smooth; scrollbar-width: thin;"
                 aria-labelledby="mensDropdown">

                 <li class="text-start"><a class="dropdown-item" href="#">Blazers & Suits</a></li>
                 <li class="text-start"><a class="dropdown-item" href="#">T-Shirts</a></li>
                 <li class="text-start"><a class="dropdown-item" href="#">Shirts</a></li>
                 <li class="text-start"><a class="dropdown-item" href="#">Jackets</a></li>
                 <li class="text-start"><a class="dropdown-item" href="#">Jeans</a></li>
             </ul>
         </li>

         <!-- Women's -->
         <li class="dropdown-submenu text-start">
             <a class="dropdown-item dropdown-toggle" href="#" id="womensDropdown" role="button"
                 data-bs-toggle="dropdown" aria-expanded="false">
                 Women's
             </a>

             <ul class="dropdown-menu text-start"
                 style="width: 176px; height: 45vh; overflow-y: auto; scroll-behavior: smooth; scrollbar-width: thin;"
                 aria-labelledby="womensDropdown">

                 <li class="text-start"><a class="dropdown-item" href="#">Salwar Kameez</a></li>
                 <li class="text-start"><a class="dropdown-item" href="#">Jackets & Shrugs</a>
                 </li>
                 <li class="text-start"><a class="dropdown-item" href="#">Kurtis & Tunics</a></li>
                 <li class="text-start"><a class="dropdown-item" href="#">Sarees</a></li>
                 <li class="text-start"><a class="dropdown-item" href="#">Nightwear</a></li>
             </ul>
         </li>

         <!-- Kids -->
         <li class="dropdown-submenu text-start">
             <a class="dropdown-item dropdown-toggle" href="#" id="kidsDropdown" role="button"
                 data-bs-toggle="dropdown" aria-expanded="false">
                 Kids
             </a>

             <ul class="dropdown-menu text-start"
                 style="width: 176px; height: 45vh; overflow-y: auto; scroll-behavior: smooth; scrollbar-width: thin;"
                 aria-labelledby="kidsDropdown">

                 <li class="text-start"><a class="dropdown-item" href="#">Frocks & Dresses</a>
                 </li>
                 <li class="text-start"><a class="dropdown-item" href="#">Jackets &
                         Sweaters</a>
                 </li>
                 <li class="text-start"><a class="dropdown-item" href="#">Sleepwear</a></li>
                 <li class="text-start"><a class="dropdown-item" href="#">T-Shirts</a></li>
                 <li class="text-start"><a class="dropdown-item" href="#">Shirts</a></li>
             </ul>
         </li>

         <!-- Accessories -->
         <li class="dropdown-submenu text-start">
             <a class="dropdown-item dropdown-toggle" href="#" id="accessoriesDropdown" role="button"
                 data-bs-toggle="dropdown" aria-expanded="false">
                 Accessories
             </a>

             <ul class="dropdown-menu text-start"
                 style="width: 176px; height: 45vh; overflow-y: auto; scroll-behavior: smooth; scrollbar-width: thin;"
                 aria-labelledby="accessoriesDropdown">

                 <li class="text-start"><a class="dropdown-item" href="#">Ties & Cufflinks</a>
                 </li>
                 <li class="text-start"><a class="dropdown-item" href="#">Caps & Hats</a></li>
                 <li class="text-start"><a class="dropdown-item" href="#">Belts</a></li>
                 <li class="text-start"><a class="dropdown-item" href="#">Watches</a></li>
                 <li class="text-start"><a class="dropdown-item" href="#">Socks</a></li>
             </ul>
         </li>

         <!-- Beauty & Grooming -->
         <li class="dropdown-submenu text-start">
             <a class="dropdown-item dropdown-toggle" href="#" id="kidsDropdown" role="button"
                 data-bs-toggle="dropdown" aria-expanded="false">
                 Beauty & Grooming
             </a>

             <ul class="dropdown-menu text-start"
                 style="width: 176px; height: 45vh; overflow-y: auto; scroll-behavior: smooth; scrollbar-width: thin;"
                 aria-labelledby="kidsDropdown">

                 <li class="text-start"><a class="dropdown-item" href="#">Men’s Grooming</a>
                 </li>
                 <li class="text-start"><a class="dropdown-item" href="#">Women’s Beauty</a>
                 </li>
                 <li class="text-start"><a class="dropdown-item" href="#">Skincare</a></li>
                 <li class="text-start"><a class="dropdown-item" href="#">Haircare</a></li>
                 <li class="text-start"><a class="dropdown-item" href="#">Makeup</a></li>
             </ul>
         </li>
     </ul>
 </li> --}}
