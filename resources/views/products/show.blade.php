@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col">
                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Back to Products
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-5">
                @if($product->image)
                    <img src="{{ asset('images/' . $product->image) }}" class="img-fluid rounded" alt="{{ $product->name }}">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center rounded" style="height: 300px;">
                        <span class="text-muted">No image</span>
                    </div>
                @endif
            </div>
            <div class="col-md-7">
                <h1>{{ $product->name }}</h1>
                <div class="mb-3">
                <span class="badge bg-{{ $product->stock > 0 ? 'success' : 'danger' }} mb-2">
                    {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                </span>
                    @if($product->stock > 0)
                        <small class="text-muted ms-2">{{ $product->stock }} items available</small>
                    @endif
                </div>

                <h3 class="text-primary mb-4">${{ $product->price }}</h3>

                <div class="mb-4">
                    <h5>Description</h5>
                    <p>{{ $product->description }}</p>
                </div>

                @auth
                    <div class="d-grid gap-2 d-md-block">
                        <button class="btn btn-lg btn-primary add-to-cart"
                                onclick="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->price }})"
                            {{ $product->stock <= 0 ? 'disabled' : '' }}>
                            <i class="bi bi-cart-plus"></i> Add to Cart
                        </button>
                    </div>
                @else
                    <div class="alert alert-info">
                        <a href="{{ route('login') }}">Login</a> or <a href="{{ route('register') }}">Register</a> to purchase this product.
                    </div>
                @endauth
            </div>
        </div>
    </div>
@endsection
