<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\products\ProductFilter;
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
        $values = $request->query();
        //checking to see if person is login, and what group the user belongs to
        $group_ids = Auth::check() ? Auth::user()->getGroups() : [1];

        //this line fetch all products from products table
        $product_data = Product::withPrices()->get();
        $product_data = ProductFilter::withPrices()->filter($values)->get();

        $product_details = $this->filterProducts($request);


        $category_details = Product::select('category')->distinct()->get();


        // $product_data = ProductFilter::withPrices()->filter($values)->get();
        // pass product info to view or browser

        // // return view('template0_pages.storage', [
        // //     'product_details' => $product_details,
        // //     'category_details' => $category_details,
        // // ]);
        return view('pages.default.productspage', compact('product_data'));
    }

    public function filterProducts(Request $request)
    {

        $params = $request->query();
        $product_details = Product::where('id', '>', 1);


        foreach ($params as $key => $value) {
            # code...
            if (empty($value)) {
                continue;
            }


            switch ($key) {
                case 'category':
                    $product_details->where('category', $value);
                    break;
                case 'search':
                    $product_details->where('title', 'LIKE', '%' . $value . '%');
                    break;
                case 'min_price':
                    $product_details->where('price', '>=', $value);
                    break;
                case 'max_price':
                    $product_details->where('price', '<=', $value);
                    break;

                // http://example-app.test/store/sort=title
                case 'sort':
                    $keyValues = $this->orderBy($value);
                    $product_details->orderBy($keyValues[0], $keyValues[1]);


                    break;

                default:
                    # code...
                    break;
            }
        }



        return $product_details->get();
    }

    public function orderBy($value)
    {
        // looking for keywords - sort, value = title
        // http://example-app.test/store/sort=title

        switch ($value) {
            case 'title':
                return ['title', 'ASC'];
                break;
            case 'title-desc':
                return ['title', 'DESC'];
                break;
            case 'price':
                return ['price', 'ASC'];
                break;
            case 'price-desc':
                return ['price', 'DESC'];

                break;
            case 'value':
                // OTHER SORT FEATURES GO HERE
                break;
            default:
                return ['title', 'ASC'];
                break;
        }
    }
}
