@extends('layouts.app')

@section('title', 'Products')

@section('content')
    <div class="row mb-4">
        <div class="col">
            <h1>Products</h1>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach($products as $product)
            <div class="col">
                <div class="card h-100 product-card">
                    @if($product->image)
                        <img src="{{ asset('images/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                    @else
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                            <span class="text-muted">No image</span>
                        </div>
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold text-primary">${{ $product->price }}</span>
                            <span class="badge bg-{{ $product->stock > 0 ? 'success' : 'danger' }}">
                        {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                    </span>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-outline-primary">View Details</a>
                        @auth
                            <button class="btn btn-sm btn-primary add-to-cart"
                                    onclick="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->price }})"
                                {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                Add to Cart
                            </button>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-sm btn-secondary">Login to Purchase</a>
                        @endauth
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
