<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of all the products or resources.
     * check if user is login
     * Get all products from products table.
     * Pass the infomation to the page called productspage
     */


    public function index(Request $request)
    {
        //checking to see if person is login, and what group the user belongs to
        $group_ids = Auth::check() ? Auth::user()->getGroups() : [1];

        //this line fetch all products from products table
        $product_data = Product::withPrices()->get();

        $product_details = $this->filterProducts($request);

        //pass product info to view or browser
        return view('pages.default.productspage', compact('product_data'));
    }

    public function filterProducts(Request $request)
    {

        $params = $request->query;
        $product_details = Product::where('id', '>', 1);


        foreach ($params as $key => $value) {

            if (empty($value)) {
                continue;
            }

            switch ($key) {
                case 'category':
                    $product_details->where('product_category', $value);
                    break;
                case 'search':
                    $product_details->where('product_category', $value);
                    break;
                case 'min_price':
                    $product_details->where('product_price', '>=', $value);
                    break;
                case 'max_price':
                    $product_details->where('product_price', '<=', $value);
                    break;
                case 'value':
                    $product_details->where('product_category', $value);
                    break;

                default:
                    //code
                    break;
            }
        }


        return $product_details->get();
    }
}
