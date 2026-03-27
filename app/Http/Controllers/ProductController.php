<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of all the products or resources.
     * check if user is login
     * Get all products from products table.
     * Pass the infomation to the page called productspage
     */


    public function index()
    {
        //checking to see if person is login, and what group the user belongs to
        $group_ids = Auth::check() ? Auth::user()->getGroups() : [1];

        //this line fetch all products from products table
        $product_data = Product::withPrices()->get();

        //pass product info to view or browser
        return view('pages.default.productspage', compact('product_data'));
    }
}
