<x-mylayouts.layout-default>





    <div class="container my-3">

        <div class="container my-5">
            <div class="block-content text-center">
                <h1>Write a review</h1>
            </div>
        </div>


        <form action="{{ route('single-product.reviews.store', ['single_product' => $product_id]) }}" method="POST">
            @csrf
            @method('POST')

            <div class="form-check-inline">
                <label class="form-check-label">
                    <input type="radio" class="form-check-input" value="1" name="rating">1 Star
                </label>
            </div>
            <div class="form-check-inline">
                <label class="form-check-label">
                    <input type="radio" class="form-check-input" value="2" name="rating">2 Stars
                </label>
            </div>
            <div class="form-check-inline">
                <label class="form-check-label">
                    <input type="radio" class="form-check-input" value="3" name="rating">3 Stars
                </label>
            </div>
            <div class="form-check-inline">
                <label class="form-check-label">
                    <input type="radio" class="form-check-input" value="4" name="rating" checked>4 Stars
                </label>
            </div>
            <div class="form-check-inline">
                <label class="form-check-label">
                    <input type="radio" class="form-check-input" value="5" name="rating">5 Stars
                </label>
            </div>

            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" class="form-control" id="title" name="title">
            </div>


            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" rows="5" id="description" name="description"></textarea>
            </div>

            <button class="btn btn-primary btn-lg">Submit</button>
            <a class="btn btn-danger btn-lg" href="{{ route('shop.details', ['id' => $product_id]) }}">Return</a>



        </form>
    </div>




</x-mylayouts.layout-default>
