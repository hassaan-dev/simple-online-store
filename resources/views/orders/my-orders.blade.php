
@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
    <div class="row mb-4">
        <div class="col">
            <h1>My Orders</h1>
        </div>
    </div>


    @if($orders->isEmpty())
        <div class="alert alert-info">
            You don't have any orders yet. <a href="{{ route('products.index') }}">Start Shopping</a>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-stripped">
                <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>{{$order->id}}</td>
                    <td>{{$order->created_at}}</td>
                    <td>{{$order->total_amount}}</td>
                    <td><span class="badge
                        @if($order->status == 'pending') bg-warning
                        @elseif($order->status) == 'processing' bg-info
                        @elseif($order->status) == 'completed' bg-success
                        @elseif($order->status) == 'cancelled' bg-danger
                        @endif">{{ ucfirst($order->status) }}</span></td>
                    <td><a href="{{route('orders.show', $order)}}" class="btn btn-sm btn-outline-primary">View Details</a></td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection
