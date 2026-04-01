<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\reviews\ReviewFilter;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class DetailController extends Controller
{

    public function index($id)
    {
        //checking to see if person is login, and what group the user belongs to
        $group_ids = Auth::check() ? Auth::user()->getGroups() : [1];

        $data = Product::singleProduct($id)->withPrices()->get()->first();

        //To get all the reviews for a specific product

        $product = $data;
        $review_data = ReviewFilter::forProduct($id)
            ->filterReviews([])
            ->limit(4)
            ->get();

        //Too get average rating
        $average_rating = ReviewFilter::averageOnly($product->id);

        //Too get percentage with ratings
        $rating_data = ReviewFilter::calculateRatings($product->id);

        $total_reviews = ReviewFilter::forProduct($product->id)->count();

        //this line fetch single product base on ID number from products table
        $data = Product::singleProduct($id)->withPrices()->get()->first();
        //passes the data to the details page.
        return view('pages.default.detailspage', compact('data', 'review_data', 'average_rating', 'rating_data', 'total_reviews'));
    }
}
