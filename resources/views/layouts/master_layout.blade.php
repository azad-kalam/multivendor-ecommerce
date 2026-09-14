<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO Meta Tags -->
    <title>{{ $title ?? 'Ecommerce' }}</title>
    <meta name="description" content="@yield('meta_description', 'Genuity Ecommerce 24/7')" />
    <meta name="keywords" content="@yield('meta_keywords', '')" />
    <meta name="author" content="@yield('meta_author', '')" />

    <!-- All styles link -->
    @include('partials.stylesheet.style_link')
    @stack('styles')

    @routes
</head>

<body>
    <!-- Main Content -->
    @yield('content')

    <!-- All scripts link -->
    @include('partials.scripts.script_link')

    <!-- Global CSRF-TOKEN -->
    @include('partials.CSRF-token.csrf-token')
    @include('CSRF.csrf_token')

    <!-- toastr configuration -->
    @include('partials.toastr_options.toastr_option')

    <!-- toastr errorHandler -->
    @include('partials.error_options.errorHandler')


    <!-- AJAX role includes (only role‑aware) -->
    @include('partials.AJAX.Ajax')

    <!-- Slick + Custom + Homepage + Frontend AJAX + Admin + Main scripts -->
    @include('partials.scripts.custom_script')

    <!-- All message -->
    @include('partials.alerts.all_alert')

    @stack('scripts')
</body>

</html>
