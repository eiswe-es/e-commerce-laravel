@extends('shop.layout')

@section('content')
    <h1 class="mb-4">Your cart</h1>
    @if (empty($cart))
        <div class="alert alert-info">Your cart is empty. <a href="{{ route('shop') }}">Continue shopping</a>.</div>
    @else
        <form action="{{ route('cart.update') }}" method="POST">
            @csrf
            <div class="card shadow-sm mb-3">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead><tr><th>Product</th><th>Price</th><th style="width: 130px">Quantity</th><th>Subtotal</th><th></th></tr></thead>
                        <tbody>
                            @foreach ($cart as $productId => $item)
                                <tr>
                                    <td>{{ $item['name'] }}</td>
                                    <td>${{ number_format($item['price'], 2) }}</td>
                                    <td><input class="form-control" type="number" min="0" name="quantities[{{ $productId }}]" value="{{ $item['quantity'] }}"></td>
                                    <td>${{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                                    <td><button class="btn btn-link text-danger p-0" formaction="{{ route('cart.remove', $productId) }}" formmethod="POST" name="_method" value="DELETE">Remove</button></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <button class="btn btn-outline-dark" type="submit">Update cart</button>
                <div class="text-md-end"><h4>Total: ${{ number_format($total, 2) }}</h4><a class="btn btn-primary" href="{{ route('checkout') }}">Proceed to checkout</a></div>
            </div>
        </form>
    @endif
@endsection