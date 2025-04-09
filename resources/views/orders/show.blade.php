
@extends('layouts.php')

@section('title', 'Order Details #'.$order->id)

@section('content')

    <div class="row mb-4">
        <div class="col">
            @if(Auth::user()->isAdmin())
                <a href="{{ route('admin.orders') }}" class="btn btn-outline-secondary">Back to Orders</a>
            @else
                <a href="{{ route('orders.my') }}" class="btn btn-outline-secondary">Back to My Orders</a>
            @endif
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="mb-0">Order #{{ $order->id }}</h3>
            <span class="badge
                        @if($order->status == 'pending') bg-warning
                        @elseif($order->status) == 'processing' bg-info
                        @elseif($order->status) == 'completed' bg-success
                        @elseif($order->status) == 'cancelled' bg-danger
                        @endif">{{ ucfirst($order->status) }}</span>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5>Order Information</h5>
                    <p><strong>Order Date:</strong> {{ $order->created_at }}</p>
                    <p><strong>Customer Name:</strong> {{ $order->user->name }}</p>
                    <p><strong>Email:</strong> {{ $order->user->email }}</p>
                </div>
                <div class="col-md-6">
                    <h5>Shipping Address</h5>
                    <p>{{ $order->shipping_address }}</p>
                </div>
            </div>
        </div>
    </div>

    <h5 class="mb-3">Order Items</h5>

    <div class="table-responsive">
        <table class="table table-stripped">
            <thead>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
            </thead>
            <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td>{{$item->product->name}}</td>
                    <td>{{$item->price}}</td>
                    <td>{{$item->quantity}}</td>
                    <td>{{$item->price * $order->quantity}}</td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <th colspan="3" class="text-center">Total:</th>
                <th class="text-end">{{ $order->total_amount }}</th>
            </tr>
            </tfoot>
        </table>
@endsection
