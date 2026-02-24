@extends('layouts.master_layout')
@section('content')
    @include('inc.headers.global.global_header')
    @include('inc.homepage.sidebar.homepage_offcanvas')
    @include('inc.homepage.body.homepage_body')
    @include('inc.homepage.footer.homepage_footer')
@endsection
