<?php

namespace App\Http\Controllers;

use App\Helpers\PointsHelper;
use App\Helpers\ShippingHelper;
use App\Models\points\PointsDiscount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CheckoutController extends Controller

{
    public function index(Request $request)

    {
        // Check if the user is logged in and which groups
        $group_ids = Auth::check() ? Auth::user()->getGroups() : [1];

        // Get the user who is logged in
        $user = Auth::user();

        // Get products the user added to the cart
        $cart_data = $user->products()->withPrices($group_ids)->get();

        //Check to see if cart is empty
        if ($cart_data->isEmpty()) {
            return redirect()->route('cart.index')->with('message', 'Your cart is empty');
        }
        //Calculate Subtotal
        $cart_data->calculateSubtotal();

        //To collect shipping data
        $shipping_helper = new ShippingHelper($group_ids);
        $shipping_data = $shipping_helper->getGroupShippingOptions($group_ids);

        // To determine correct address to load, and check if none was set to default
        $address = $user->addresses()
            ->where('addresses.type', '3')
            ->where('addresses.is_default', 1)
            ->first();


        $points_helper = new PointsHelper($cart_data->getSubtotal(), $user->total_points, $group_ids);
        $discount_data = PointsDiscount::all();
        //Reload the checkout page
        return view(
            'pages.default.checkoutpage',
            compact('cart_data', 'shipping_data', 'address', 'points_helper', 'discount_data')
        );
    }

    public function points(Request $request)
    {
        $message = PointsHelper::exchangePoints($request->points_exchanged);

        return redirect()->route('checkout.index')->with('message', $message);
    }
}
