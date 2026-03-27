<?php

namespace App\Http\Controllers;

use App\Models\Cart;
//use App\App\Traits\PhpFlasher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    //Add flasher here
    //use PhpFlasher;

    /**
     * This gets all the products the user adds to the carts.
     */
    public function index()
    {
        /**
         * This checks if the user is login.
         */
        $group_ids = Auth::check() ? Auth::user()->getGroups() : [1];

        $user = Auth::user();

        /** * This all the products adds to the cart. */
        $cart_data = $user->products()->withPrices()->get();

        $cart_data->calculateSubTotal();

        return view('pages.default.cartpage', compact('cart_data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * Functionality on datails page to add to cart.
     * If it finds the values, it updates. If it doesnt, it will then insert.
     * Looks for product from the specific user, if yes it then updates the quantity. IF not, it inserts
     */
    public function store(Request $request)
    {

        //dd($request);
        Cart::updateOrCreate(
            ['user_id' => Auth::id(), 'product_id' => $request->product_id],
            ['quantity' => DB::raw('quantity + ' . $request->quantity), 'updated_at' => now()]
        );

        //$this->flashSuccess('Product added to cart');

        return redirect()->route('cart.index')->with('message', 'Product added to cart');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Cart::destroy($id);

        return redirect()->route('cart.index')->with('message', 'Product remove to cart');
    }

    /**
     * Adds quantity by 1,
     */
    public function addToCartFromStore(Request $request)
    {
        //dd($request);
        Cart::updateOrCreate(
            ['user_id' => Auth::id(), 'product_id' => $request->id],
            ['quantity' => DB::raw('quantity + ' . 1), 'updated_at' => now()]
        );
        //$this->flashSuccess('Product added to cart');

        return redirect()->route('cart.index')->with('message', 'Product added to cart');
    }
}
