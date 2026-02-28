{{-- @if (Auth::check())
    @switch(Auth::user()->role)
        @case('admin')
            @include('inc.headers.admin.admin_header')
            @include('inc.asidebar.admin.admin_asidebar')
        @break

        @case('vendor')
            @include('inc.headers.vendor.vendor_header')
            @include('inc.asidebar.vendor.vendor_asidebar')
        @break

        @case('customer')
            @include('inc.headers.customer.customer_header')
            @include('inc.asidebar.customer.customer_asidebar')
        @break

        @default
            <script>
                toastr.error("Unknown Role: Unable to load user panel.");
            </script>
    @endswitch
@else
    <script>
        toastr.error("You are not authenticated.");
    </script>
@endif --}}
