<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return true;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return true;
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return true;
    }


    public function addToCartFromStore(Request $request)
    {

        Cart::updateOrCreate(
            ['user_id' => Auth::id(), 'product_id' => $request->product_id],
            ['quantity' => DB::raw('quantity + ' . 1), 'updated_at' => now()]
        );

        return redirect()->route('cart.index')->with('message', 'Product added to cart');
    }
}
