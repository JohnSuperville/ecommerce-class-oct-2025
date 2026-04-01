<x-mylayouts.layout-default>





    <div class="container my-3">

        <div class="container my-5">
            <div class="block-content text-center">
                <h1>Edit a review</h1>
            </div>
        </div>


        <form action="{{ route('reviews.update', ['review' => $review->id]) }}" method="POST">
            @csrf
            @method('PUT')


            @for ($star = 1; $star <= 5; $star++) <div class="form-check-inline">
                <label class="form-check-label">
                    <input @if($star==$review->rating)checked @endif
                    type="radio" class="form-check-input"
                    value="{{ $star }}"
                    name="rating">
                    {{ $star }} {{ $star == 1 ? 'star' : 'stars' }}
                </label>
    </div>
    @endfor



    <div class="form-group">
        <label for="title">Title:</label>
        <input type="text" class="form-control" id="title" name="title" value="{{ $review->title }}">
    </div>


    <div class="form-group">
        <label for="description">Description:</label>
        <textarea class="form-control" rows="5" id="description" name="description">
                    {{ $review->description }}
                </textarea>
    </div>

    <button class="btn btn-primary btn-lg">Submit</button>
    <a class="btn btn-danger btn-lg" href="{{ route('shop.details', ['id' => $review->product_id]) }}">Return</a>



    </form>
    </div>




</x-mylayouts.layout-default>
