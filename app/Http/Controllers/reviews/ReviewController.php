<?php

namespace App\Http\Controllers\reviews;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewFilterRequest;
use App\Models\Product;
use App\Models\reviews\Review;
use App\Models\reviews\ReviewFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ReviewController extends Controller
{

    public function index($product_id, ReviewFilterRequest $request)
    { //validate info Ensures inputs (rating filters, sorting,) are correct
        $validated = $request->validated();

        //fetches product the product from DB
        $product = Product::findOrFail($product_id);

        //get reviews
        $review_data = ReviewFilter::forProduct($product_id)
            ->filterReview($validated)
            ->paginate(4);

        //Calculates the average rating
        $average_rating = ReviewFilter::averageOnly($product->id);

        //Calculates the rating with percentage
        $rating_data = ReviewFilter::calculateRatings($product->id);

        //total reviews
        $total_reviews = ReviewFilter::forProduct($product->id)->count();

        //load page template
        return view(
            'pages.additional.reviews.reviews-show-all',
            compact('product', 'review_data', 'average_rating', 'rating_data', 'total_reviews')
        );
    }

    public function create($product_id)
    {
        $review = Review::where('product_id', $product_id)
            ->where('user_id', Auth::id())
            ->latest()
            ->first();

        if ($review) {
            return redirect()->route('reviews.edit', ['review' => $review->id])->with('message', 'You can only post one review');
        }
        return view('pages.additional.reviews.reviews-write', compact('product_id'));
    }

    public function edit(string $id)
    {
        $review = Review::findorFail($id);

        return view('pages.additional.reviews.reviews-edit', compact('review'));
    }


    public function store(Request $request, $product_id)
    {
        $review = new Review();
        $review->user_id =  Auth::id();
        $review->product_id =  $product_id;
        $review->rating = $request->rating;
        $review->title = $request->title;
        $review->description = $request->description;
        $review->save();

        // TODO: TO DETERMINE IF REVIEW IS VERIFIED
        return redirect()->route('shop.details', ['id' => $product_id]);
    }

    public function update(Request $request, string $id)
    {
        $review = Review::findOrFail($id);
        $review->rating = $request->rating;
        $review->title = $request->title;
        $review->description = $request->description;
        $review->save();

        // TODO: TO DETERMINE IF REVIEW IS VERIFIED
        return redirect()->route('shop.details', ['id' => $review->product_id]);
    }
}
