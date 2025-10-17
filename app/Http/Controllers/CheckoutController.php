<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller

{
    public function index()

    {
        // Check if the user is logged in and which groups
        $group_ids = Auth::check() ? Auth::user()->getGroups() : [1];

        // Get the user who is logged in
        $user = Auth::user();

        // Get products the user added to the cart
        $cart_data = $user->products()->withPrices()->get();

        //Check to see if cart is empty
        if ($cart_data->isEmpty()) {
            return redirect()->route('cart.index')->with('message', 'Your cart is empty');
        }
        //Calculate Subtotal
        $cart_data->calculateSubtotal();

        //Reload the checkout page
        return view('pages.default.checkoutpage', compact('cart_data'));
    }
}
