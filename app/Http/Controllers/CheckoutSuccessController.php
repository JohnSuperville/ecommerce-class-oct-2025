<?php

namespace App\Http\Controllers;

use App\Helpers\StripeCheckoutSuccess;

class CheckoutSuccessController extends Controller
{


    public function index($id)
    {
        $stripe_check = new StripeCheckoutSuccess();
        $succesfull = $stripe_check->updateCheckoutOrder($id);
        if (!$succesfull) {
            abort(404);
        }
        return view('pages.default.checkout-successpage');
    }
}
