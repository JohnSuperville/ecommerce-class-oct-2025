<div class="card p-3 my-3">

    <h4>Points</h4>
    <hr>
    <p>Available Points: {{ $points_helper->getUserPoints() }}</p>
    <p>Points multiplier: x{{ $points_helper->getPoints() }}
        ({{ $points_helper->displayUserGroup('name') }})
    </p>
    <p>Points to be gained: {{ $points_helper->getPointsGained() }}</p>
    <p>Discount Applied: {{ $points_helper->getPointsDiscountApplied() }}%</p>
    @if ($points_helper->isDiscountApplied())
        <p>Discounted Total:

            ${{ app('CustomHelper')->calculateDiscountedPrice(
                $cart_data->getSubtotal(),
                $points_helper->getPointsDiscountApplied(),
            ) }}


        </p>
    @endif

    <form action="{{ route('checkout.points') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="points_exchanged">
                <h5>Exchange Points</h5>
            </label>
            <select class="form-control" id="points_exchanged" name="points_exchanged">
                <option>Select your discount</option>

                @foreach ($discount_data as $data)
                    <option value="{{ $data->points_needed }}">{{ $data->points_needed }} points for
                        {{ $data->discount_percent }}% OFF</option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-primary btn-block" type="submit">Exchange</button>
    </form>


</div>
