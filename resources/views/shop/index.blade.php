@extends('shop.layout')

@section('content')
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="mb-1">Shop everyday essentials</h1>
            <p class="text-muted mb-0">Simple products, clear prices, easy checkout.</p>
        </div>
        <form action="{{ route('shop') }}" method="GET" class="d-flex">
            <input class="form-control me-2" type="search" name="search" value="{{ request('search') }}" placeholder="Search products">
            <button class="btn btn-dark" type="submit">Search</button>
        </form>
    </div>

    <div class="row g-4">
        @forelse ($products as $product)
            <div class="col-sm-6 col-lg-4">
                <div class="card product-card h-100 shadow-sm">
                    @if ($product->image)
                        <img src="{{ $product->image }}" class="card-img-top product-image" alt="{{ $product->name }}">
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text text-muted flex-grow-1">{{ $product->description }}</p>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="price">${{ number_format($product->price, 2) }}</span>
                            <small class="text-muted">{{ $product->stock }} in stock</small>
                        </div>
                        <form action="{{ route('cart.add', $product) }}" method="POST">
                            @csrf
                            <button class="btn btn-primary w-100" type="submit" {{ $product->stock < 1 ? 'disabled' : '' }}>Add to cart</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12"><div class="alert alert-info">No products found.</div></div>
        @endforelse
    </div>

    <div class="mt-4">{{ $products->links() }}</div>
@endsection