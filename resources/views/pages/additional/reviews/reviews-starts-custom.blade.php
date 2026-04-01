<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>
    .star {}

    .star-color {
        color: gold;
    }
</style>


<div class="mystars">
    @php($average_rating = round($data->average_rating, 1))
    @for ($star = 1; $star <= 5; $star++) @if ($star <=$average_rating) <i class="fa-solid fa-star  star star-color">
        </i>
        @elseif ($star - .5 == $average_rating)
        <i class="fa-solid fa-star star star-color"></i>
        @else
        <i class="fa-regular fa-star star"></i>
        @endif
        @endfor
</div>


{{-- <p>{{ $data->total_reviews }} Avg rating</p> --}}
{{-- <p>{{ $data->total_reviews }} Total reviews</p> --}}
