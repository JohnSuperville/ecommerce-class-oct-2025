<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class DetailController extends Controller
{

    public function index($id)
    {
        //checking to see if person is login, and what group the user belongs to
        $group_ids = Auth::check() ? Auth::user()->getGroups() : [1];

        //this line fetch single product base on ID number from products table
        $data = Product::singleProduct($id)->withPrices()->get()->first();
        //passes the data to the details page.
        return view('pages.default.detailspage', compact('data'));
    }
}
