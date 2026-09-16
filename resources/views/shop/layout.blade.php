<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Ei Swe Store' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f6f7fb; color: #20242b; }
        .navbar-brand { font-weight: 800; letter-spacing: .04em; }
        .product-image { height: 220px; object-fit: cover; }
        .product-card { border: 0; transition: transform .2s ease, box-shadow .2s ease; }
        .product-card:hover { transform: translateY(-4px); box-shadow: 0 .75rem 1.5rem rgba(31, 38, 52, .12); }
        .price { color: #0d6efd; font-size: 1.2rem; font-weight: 700; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('shop') }}">EI SWE STORE</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#storeNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="storeNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item"><a class="nav-link" href="{{ route('shop') }}">Shop</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('cart') }}">Cart ({{ count(session('cart', [])) }})</a></li>
                    @auth
                        <li class="nav-item"><a class="nav-link" href="{{ route('orders') }}">My Orders</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('signout') }}">Logout</a></li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main class="container pb-5">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if ($errors->has('cart'))
            <div class="alert alert-danger">{{ $errors->first('cart') }}</div>
        @endif
        @yield('content')
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>