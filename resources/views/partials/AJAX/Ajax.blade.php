@php
    $role = Auth::user()->role ?? null;
@endphp

@if ($role === 'admin')
    @include('admin.ajax.ajaxCRUD')
    @include('admin.ajax.ajaxPagination')
    @include('admin.ajax.ajaxLiveSearch')
    @include('admin.ajax.ajaxDependent')
@elseif ($role === 'vendor')
    @include('vendor.AJAX.AJAX_depencency')
@endif