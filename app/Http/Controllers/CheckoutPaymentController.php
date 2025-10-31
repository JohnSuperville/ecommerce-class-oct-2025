<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Helpers\ShippingHelper;
use App\Helpers\StripeCheckout;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CheckoutPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($payment)
    {

        // Get groups check to see if user is logged in
        $group_ids = Auth::check() ? Auth::user()->getGroups() : [1];

        // Get user that login
        $user = Auth::user();

        // Create variables
        $shipping_helper = new ShippingHelper();
        $stripe_checkout = new StripeCheckout();
        $order = new Order();
        $insert_data = [];
        $completed = false;

        // Get products
        $cart_data = $user->products()->withPrices()->get();


        // Check if cart is empty
        if ($cart_data->isEmpty()) {
            return redirect()->route('cart.index')->with('message', 'Your cart is empty');
        }

        // Get Subtotal
        $cart_data->calculateSubtotal();



        // Determine payment
        switch ($payment) {

            case 'stripe':
                #code...
                break;

            default:
                $insert_data = [
                    'payment_provider' => 'testing',
                    'payment_id' => 'tesing',
                ];
                $completed = true;
                break;
        }

        // Validate
        if (!$completed || empty($insert_data)) {
            dd('Payment incomplete or checkout is missing');
        }

        // Create order
        $order->user_id = $user->id;
        $order->order_no = '123';
        $order->subtotal = $cart_data->getSubtotal();
        $order->total = $cart_data->getTotal();
        $order->payment_provider = $insert_data['payment_provider'];
        $order->payment_id = $insert_data['payment_id'];
        $order->shipping_id = 1;
        $order->shipping_address_id = 1;
        $order->billing_address_id = 1;
        $order->payment_status = 'unpaid';
        $order->save();


        // Create order details
        $records = [];

        foreach ($cart_data as $data) {
            array_push(
                $records,
                new OrderProduct(
                    [
                        'product_id' => $data->id,
                        'user_id' => $data->id,
                        'price' => $data->getPrice(),
                        'quantity' => $data->pivot->quantity,
                    ]
                )
            );
        }
        // For each item in the cart, insert the data into order products.
        $order->order_products()->saveMany($records);

        // Redirect

    }
}
