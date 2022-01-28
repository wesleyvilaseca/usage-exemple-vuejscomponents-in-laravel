<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function itens(Request $request)
    {
        if (!auth()->user()) {
            return response()->json([
                'message' => 'ok',
                'cartItens' => 0
            ], 200);
        }

        $userItens = Cart::where([
            'user_id' => auth()->user()->id
        ])->sum('quantity');

        return response()->json([
            'message' => 'ok',
            'cartItens' => $userItens
        ], 200);
    }

    public function store(Request $request)
    {
        $product = Product::find($request->get('product_id'));

        $productFoundInCart = Cart::where('product_id', $request->get('product_id'))->pluck('id');

        if (!$productFoundInCart->isEmpty()) {
            Cart::where('product_id', $request->get('product_id'))->increment('quantity');

            return response()->json([
                'message' => 'product add to cart',
                'cartItens' => Cart::where('user_id', auth()->user()->id)->sum('quantity')
            ], 200);
        }

        $result = Cart::create([
            'product_id'    => $product->id,
            'quantity'      => 1,
            'price'         => $product->sale_price,
            'user_id'       => auth()->user()->id
        ]);

        if (!$result)
            return response()->json(['message' => 'error on requisition'], 203);


        return response()->json([
            'message' => 'product add to cart',
            'cartItens' => Cart::where('user_id', auth()->user()->id)->sum('quantity')
        ], 200);
    }

    public function checkout(Request $request)
    {
        return view('pages.checkout');
    }

    public function getCartItens(Request $request)
    {
        $cartIntens = Cart::select('carts.*', 'products.name', 'products.sale_price')
            ->join('products', 'products.id', 'carts.product_id')
            ->where('user_id', auth()->user()->id)
            ->get();

        return response()->json(['message' => 'ok', 'cartItens' => $cartIntens], 200);
    }
}
