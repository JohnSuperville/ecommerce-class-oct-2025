<x-mylayouts.layout-default>


    @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
    @endforeach




    {{-- Start Product Preview --}}
    <div class="container my-5">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-1">
                        <img class="img-fluid" src="{{ $product->getImage() }}" alt="Product Image">
                    </div>
                    <div class="col-md-11">
                        <h3>{{ $product->title }}</h3>
                        <p>{{ $product->short_description }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- End Product Preview --}}


    {{-- Start Reviews Filters --}}
    <div class="container my-5">
        <div class="card">
            <div class="card-body">
                <form action="" method="GET">

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="sort">Sort By:</label>
                                <select class="form-control" id="sort" name="sort">
                                    <option value="recent">Most Recent</option>
                                    <option value="oldest">Oldest</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="verified">verified:</label>
                                <select class="form-control" id="verified" name="verified">
                                    <option value="all">All Reviews</option>
                                    <option value="verified">Verified Purchased</option>
                                    <option value="all">Reviews by others</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="rating">Ratings:</label>
                                <select class="form-control" id="rating" name="rating">
                                    <option value="0">All Stars</option>
                                    <option value="5">5 Stars</option>
                                    <option value="4">4 Stars</option>
                                    <option value="3">3 Stars</option>
                                    <option value="2">2 Stars</option>
                                    <option value="1">1 Star</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <button class="btn btn-success">Apply</button>
                                <a href="#" class="btn btn-danger">Clear</a>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
    {{-- End Reviews Filters --}}

    {{-- Start Reviews Panel --}}
    <div class="container my-5">
        <div class="card">
            <div class="card-body">


                <div class="container1">

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
                            <a href="{{ route('single-product.reviews.create', ['single_product' => $product->id]) }}">Write
                                a customer
                                review</a>
                        </div>
                        <div class="col-md-8">
                            <div class="reviews-preview-right">

                                @if ($review_data->isEmpty())
                                    <div class="jumbotron">
                                        <h1>No Reviews Found</h1>
                                        <p>Try viewing all reviews</p>
                                    </div>
                                @endif

                                @foreach ($review_data as $review)
                                    <div class="reviews-preview-review mb-3">
                                        <div class="review-user d-flex flex-wrap">
                                            <img class="rounded-circle border" src="https://placehold.co/40x40"
                                                alt="">
                                            <div class="align-self-baseline mx-3">{{ $review->users->name }}</div>
                                        </div>
                                        <div>Review on {{ app('CustomHelper')->dateToReadable($review->created_at) }}</div>
                                        {{-- <div>Review on {{ CustomHelper::dateToReadable($review->created_at) }}</div> --}}
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
                                        href="{{ route('single-product.reviews.index', ['single_product' => $product->id]) }}">See
                                        more
                                        reviews</a></p>
                                {{-- {!! $review_data->withQueryString()->links() !!} --}}
                            </div>

                        </div>
                    </div>


                </div>


            </div>
        </div>
    </div>
    {{-- End Reviews Panel --}}




</x-mylayouts.layout-default>
