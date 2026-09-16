<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::query()
            ->where('is_active', true)
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->input('search');
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('shop.index', compact('products'));
    }

    public function addToCart(Product $product)
    {
        abort_unless($product->is_active, 404);

        $cart = session('cart', []);
        $quantity = ($cart[$product->id]['quantity'] ?? 0) + 1;

        if ($quantity > $product->stock) {
            return back()->withErrors(['cart' => 'This product does not have enough stock.']);
        }

        $cart[$product->id] = [
            'name' => $product->name,
            'price' => (float) $product->price,
            'quantity' => $quantity,
            'image' => $product->image,
        ];

        session(['cart' => $cart]);

        return back()->with('success', 'Product added to cart.');
    }

    public function cart()
    {
        $cart = session('cart', []);
        $total = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        return view('shop.cart', compact('cart', 'total'));
    }

    public function updateCart(Request $request)
    {
        $quantities = $request->validate([
            'quantities' => 'required|array',
            'quantities.*' => 'integer|min:0',
        ])['quantities'];
        $cart = session('cart', []);

        foreach ($quantities as $productId => $quantity) {
            if (!isset($cart[$productId])) {
                continue;
            }

            if ($quantity === 0) {
                unset($cart[$productId]);
                continue;
            }

            $product = Product::find($productId);
            if (!$product || $quantity > $product->stock) {
                return back()->withErrors(['cart' => 'One or more quantities exceed available stock.']);
            }

            $cart[$productId]['quantity'] = $quantity;
        }

        session(['cart' => $cart]);

        return redirect()->route('cart')->with('success', 'Cart updated.');
    }

    public function removeFromCart(Product $product)
    {
        $cart = session('cart', []);
        unset($cart[$product->id]);
        session(['cart' => $cart]);

        return redirect()->route('cart');
    }

    public function checkout()
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('shop')->withErrors(['cart' => 'Your cart is empty.']);
        }

        $total = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        return view('shop.checkout', compact('cart', 'total'));
    }

    public function placeOrder(Request $request)
    {
        $validated = $request->validate([
            'shipping_address' => 'required|string|max:500',
        ]);
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('shop')->withErrors(['cart' => 'Your cart is empty.']);
        }

        $order = DB::transaction(function () use ($cart, $validated) {
            $total = 0;
            $orderItems = [];

            foreach ($cart as $productId => $item) {
                $product = Product::whereKey($productId)->lockForUpdate()->firstOrFail();
                if (!$product->is_active || $item['quantity'] > $product->stock) {
                    abort(422, 'One or more products are no longer available in the requested quantity.');
                }

                $subtotal = $product->price * $item['quantity'];
                $total += $subtotal;
                $orderItems[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $item['quantity'],
                    'subtotal' => $subtotal,
                ];
                $product->decrement('stock', $item['quantity']);
            }

            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $total,
                'status' => 'pending',
                'shipping_address' => $validated['shipping_address'],
            ]);
            $order->items()->createMany($orderItems);

            return $order;
        });

        session()->forget('cart');

        return redirect()->route('orders')->with('success', "Order #{$order->id} placed successfully.");
    }

    public function orders()
    {
        $orders = Auth::user()->orders()->with('items')->latest()->paginate(10);

        return view('shop.orders', compact('orders'));
    }
}