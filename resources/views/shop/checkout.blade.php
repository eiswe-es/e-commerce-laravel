@extends('shop.layout')

@section('content')
    <h1 class="mb-4">Checkout</h1>
    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card shadow-sm"><div class="card-body">
                <form action="{{ route('checkout.place') }}" method="POST">
                    @csrf
                    <label class="form-label" for="shipping_address">Shipping address</label>
                    <textarea class="form-control @error('shipping_address') is-invalid @enderror" id="shipping_address" name="shipping_address" rows="5" required>{{ old('shipping_address') }}</textarea>
                    @error('shipping_address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <button class="btn btn-primary mt-3" type="submit">Place order</button>
                </form>
            </div></div>
        </div>
        <div class="col-lg-5"><div class="card shadow-sm"><div class="card-body">
            <h5>Order summary</h5>
            @foreach ($cart as $item)
                <div class="d-flex justify-content-between border-bottom py-2"><span>{{ $item['name'] }} x {{ $item['quantity'] }}</span><span>${{ number_format($item['price'] * $item['quantity'], 2) }}</span></div>
            @endforeach
            <div class="d-flex justify-content-between pt-3"><strong>Total</strong><strong>${{ number_format($total, 2) }}</strong></div>
        </div></div></div>
    </div>
@endsection