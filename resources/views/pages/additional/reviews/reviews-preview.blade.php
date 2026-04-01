@if ($review_data->isEmpty())

    @include('pages.additional.reviews.reviews-empty')
@else
    <div class="container">

        <div class="row">
            <div class="col-md-4">
                <div class="reviews-preview-left">
                    <p class="font-weight-bold">Custom Reviews</p>
                    <p>Average: <span class="font-weight-bold">{{ $average_rating }} out of 5</span> </p>
                    <hr>
                    @foreach ($rating_data as $rating => $percentage)
                        <p>{{ $rating }} Stars: {{ $percentage }}%</p>
                    @endforeach

                </div>

                <p>Review this product</p>
                <a href="{{ route('single-product.reviews.create', ['single_product' => $data->id]) }}">Write a customer
                    review</a>
            </div>
            <div class="col-md-8">
                <div class="reviews-preview-right">

                    @foreach ($review_data as $review)
                        <div class="reviews-preview-review mb-3">
                            <div class="review-user d-flex flex-wrap">
                                <img class="rounded-circle border" src="https://placehold.co/40x40" alt="">
                                <div class="align-self-baseline mx-3">{{ $review->users->name }}</div>
                            </div>

                            <div> Review on {{ app('CustomHelper')->dateToReadable($review->created_at) }}</div>
                            <div class="review-title">
                                <span>{{ $review->rating }} Stars</span>
                                <span class="font-weight-bold">{{ $review->title }}</span>
                            </div>
                            @if ($review->verified)
                                <div class="review-verified">
                                    <span class="text-danger">Verified Purchase</span>
                                </div>
                            @endif
                            <div class="review-body">
                                {{ $review->description }}
                            </div>
                            <hr>
                        </div>
                    @endforeach


                    <p class="text-center"><a
                            href="{{ route('single-product.reviews.index', ['single_product' => $data->id]) }}">See more
                            reviews</a></p>
                </div>

            </div>
        </div>


    </div>
@endif
