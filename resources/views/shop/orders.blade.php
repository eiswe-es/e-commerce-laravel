@extends('shop.layout')

@section('content')
    <h1 class="mb-4">My orders</h1>
    @forelse ($orders as $order)
        <div class="card shadow-sm mb-3"><div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-3"><div><h5 class="mb-1">Order #{{ $order->id }}</h5><small class="text-muted">{{ $order->created_at->format('M d, Y H:i') }}</small></div><span class="badge bg-secondary">{{ ucfirst($order->status) }}</span></div>
            @foreach ($order->items as $item)
                <div class="d-flex justify-content-between"><span>{{ $item->product_name }} x {{ $item->quantity }}</span><span>${{ number_format($item->subtotal, 2) }}</span></div>
            @endforeach
            <hr><div class="d-flex justify-content-between"><strong>Total</strong><strong>${{ number_format($order->total_amount, 2) }}</strong></div>
        </div></div>
    @empty
        <div class="alert alert-info">You have not placed any orders yet.</div>
    @endforelse
    {{ $orders->links() }}
@endsection