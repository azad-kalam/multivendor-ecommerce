@extends('layouts.master_layout', ['title' => 'Shopping Cart'])
@include('inc.headers.global.global_header')

@section('content')
    <section class="page-header container-fluid">
        <h1> SHOPPING CART</h1>

        <div class="breadcrumb">
            <a href="{{ url()->previous() }}" class="btn btn-dark text-white back ms-2 px-1 py-0" aria-label="Go back">
                <i class="fa-solid fa-arrow-left me-1"></i> Back
            </a>
            <a class="active" href="{{ url('/') }}"> Home </a>

            <span>−</span>
            <span>Shopping Cart</span>
        </div>
    </section>

    <main class="cart-container container-fluid">
        <div class="row g-4">
            <section class="cart-products col-12 col-md-9">
                <div class="cart-table border border-1 border-danger rounded-2">
                    @include('frontend.carts.table.cart_table')
                </div>
            </section>

            <aside class="col-12 col-md-3">
                <div class="card coupon-details border border-1 border-danger rounded-2">
                    @include('frontend.carts.summary.cart_summary')
                </div>
            </aside>
        </div>
    </main>
@endsection
