<div class="container">


    <form action="{{ route('store.index') }}" method="GET">


        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Search" name="search" value="{{ old('Search') }}">
            <div class="input-group-append">
                <button class="btn btn-success" type="submit">Proteus Search</button>
            </div>
        </div>




    </form>
</div>
