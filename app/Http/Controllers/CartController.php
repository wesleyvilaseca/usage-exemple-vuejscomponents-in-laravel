<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function store(Request $request)
    {
        $product = Product::find($request->get('product_id'));

        $productFoundInCart = Cart::where('product_id', $request->get('product_id'))->pluck('id');

        if (!$productFoundInCart->isEmpty()) {
            Cart::where('product_id', $request->get('product_id'))->increment('quantity');

            return response()->json(['message' => 'product add to cart'], 200);
        }

        $result = Cart::create([
            'product_id'    => $product->id,
            'quantity'      => 1,
            'price'         => $product->sale_price,
            'user_id'       => auth()->user()->id
        ]);

        if (!$result)
            return response()->json(['message' => 'error on requisition'], 203);

        return response()->json(['message' => 'product add to cart'], 200);
    }
}
