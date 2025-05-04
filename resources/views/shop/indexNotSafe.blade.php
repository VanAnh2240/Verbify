<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/css/styles_1.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/products.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--=============== BOXICONS ===============-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
</head>
<body>

    <div class="">

       @include('layout.header')

        <div class="d-flex flex-lg-row">

    <aside class="filter-sidebar col-12 col-md-2 mb-0 mb-md-0">
        <h3>Filter</h3>
        <hr>
        <div class="filter-section">
                <h4>Genres</h4>
                <ul>
                    @foreach($genres as $index => $genre)
                        @if($index < 5)
                            <li>
                                @if($genre->GENRES_NAME=="Psychology") @continue @endif
                                <input type="checkbox" id="genre{{ $index }}" name="genres[]" value="{{ $genre->GENRES_NAME }}">
                                <label for="genre{{ $index }}">{{ $genre->GENRES_NAME }}</label>
                            </li>
                        @else
                            @if($index == 5)
                                <div class="collapse" id="moreGenres">
                            @endif
                                <li>
                                    <input type="checkbox" id="genre{{ $index }}" name="genres[]" value="{{ $genre->GENRES_NAME }}">
                                    <label for="genre{{ $index }}">{{ $genre->GENRES_NAME }}</label>
                                </li>
                            @if($index == count($genres) - 1)
                                </div>
                            @endif
                        @endif
                    @endforeach
                </ul>
                <button class="toggleButton btn btn-link" type="button" data-toggle="collapse" data-target="#moreGenres" aria-expanded="false" aria-controls="moreGenres" onclick="toggleShowMore(this)">
                    Show more <i class="fas fa-chevron-down"></i>
                </button>

                <h4>Release Year</h4>
                <ul>
                    @foreach($releaseYears as $index => $year)
                        @if($index < 5)
                            <li>
                                <input type="checkbox" id="year{{ $index }}" name="release_year[]" value="{{ $year->RELEASE_YEAR }}">
                                <label for="year{{ $index }}">{{ $year->RELEASE_YEAR }}</label>
                            </li>
                        @else
                            @if($index == 5)
                                <div class="collapse" id="moreYears">
                            @endif
                                <li>
                                    <input type="checkbox" id="year{{ $index }}" name="release_year[]" value="{{ $year->RELEASE_YEAR }}">
                                    <label for="year{{ $index }}">{{ $year->RELEASE_YEAR }}</label>
                                </li>
                            @if($index == count($releaseYears) - 1)
                                </div>
                            @endif
                        @endif
                    @endforeach
                </ul>
                <button class="toggleButton btn btn-link" type="button" data-toggle="collapse" data-target="#moreYears" aria-expanded="false" aria-controls="moreYears" onclick="toggleShowMore(this)">
                    Show more <i class="fas fa-chevron-down"></i>
                </button>
            </div>

            <div class="filter-section">
                <h4>Price</h4>
                <ul>
                    <li><input type="checkbox" id="price1" name="price" value="0-10"  @if( $selectedPrice === '0-10') checked = "checked" @endif> <label for="price1">Under $10</label></li>
                    <li><input type="checkbox" id="price2" name="price" value="10-20" @if( $selectedPrice === '10-20') checked = "checked" @endif> <label for="price1"> <label for="price2">$10 - $20</label></label></li>
                    <li><input type="checkbox" id="price3" name="price" value="20-30" > <label for="price3">$20 - $30</label></li>
                    <div class="collapse" id="morePriceFilters">
                        <ul>
                            <li><input type="checkbox" id="price4" name="price" value="30-40" > <label for="price4">$30 - $40</label></li>
                            <li><input type="checkbox" id="price5" name="price" value="40-50" > <label for="price5">$40 - $50</label></li>
                            <li><input type="checkbox" id="price6" name="price" value="50-1000000000000" > <label for="price6">Above $50</label></li>
                        </ul>
                    </div>
                    <button class="toggleButton btn btn-link" type="button" data-toggle="collapse" data-target="#morePriceFilters" aria-expanded="false" aria-controls="morePriceFilters" onclick="toggleShowMore(this)">
                        Show more <i class="fas fa-chevron-down"></i>
                    </button>
                </ul>
            </div>
    </aside>


    <div class="main-content mt-5 ml-2">
        <div class="row d-flex justify-content-end mb-3 ">
            <div class="sort-dropdown1">
                <div class="dropdown">
                    <button class="btn dropdown-toggle" type="button" id="sortDropdown" data-bs-toggle="dropdown" aria-expanded="false" onClick="toggleShowMore(this)">Sort By: Newest</button>
                    <ul class="dropdown-menu" aria-labelledby="sortDropdown">
                        <li><a class="dropdown-item" href="#" data-value="Newest">Newest</a></li>
                        <li><a class="dropdown-item" href="#" data-value="Price (low to high)">Price (low to high)</a></li>
                        <li><a class="dropdown-item" href="#" data-value="Price (high to low)">Price (high to low)</a></li>
                        <li><a class="dropdown-item" href="#" data-value="Most popular">Most popular</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container" id="book-list">
            <div class = "row">
                    @foreach ($books as $book)
                        <div class="col book-item bg-grey m-4 col-3" >
                            @if (!empty($book->IMAGE_LINK))
                                <a href="{{ route('book.detail', $book->BOOK_ID) }}" class="book_img"><img src="{{ $book->IMAGE_LINK }}" alt="{{ $book->NAME }}"></a>
                            @else
                                <a href="{{ route('book.detail', $book->BOOK_ID) }}" class="book_img"><img src="https://via.placeholder.com/150" alt="{{ $book->NAME }}"></a>
                            @endif
                            <div class="book_info px-4 py-2">
                                <span class="book_title fs-5"><a href="#">{{$book->NAME}}</a></span>
                                <span class="book_author fs-5">{{ $book->AUTHOR }}</span>
                                <span class="book_price fs-5">${{ number_format($book->PRICE, 2) }}</span>
                            </div>
                        </div>
                    @endforeach
            </div>
        </div>
    </div>
</div>

<div class="">
    {{ $paginator->onEachSide(5)->links('shop.my-paginate') }}
</div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script>
        function toggleShowMore(button) {
            var target = $(button).data('target');
            $(target).collapse('toggle');
            $(target).on('shown.bs.collapse', function () {
                $(button).html('Show less <i class="fas fa-chevron-up"></i>');
            });
            $(target).on('hidden.bs.collapse', function () {
                $(button).html('Show more <i class="fas fa-chevron-down"></i>');
            });

        }
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('input[name="genres[]"], input[name="release_year[]"], input[name="price"]').on('change', function(){
                filterBook();
            });
            $('.dropdown-item').click(function() {
                var selectedText = $(this).data('value');
                $('#sortDropdown').text('Sort By: ' + selectedText);
                filterBook();
            });

            function filterBook() {
                var selectedGenres = [];
                $('input[name="genres[]"]:checked').each(function() {
                    selectedGenres.push($(this).val());
                });

                var selectedYears = [];
                $('input[name="release_year[]"]:checked').each(function() {
                    selectedYears.push($(this).val());
                });

                var selectedPrice = $('input[name="price"]:checked').val();
                var sortOption = $('#sortDropdown').text().replace('Sort By: ', '');

                $.ajax({
                    url: '{{ route("shop.filter") }}',
                    method: 'POST',
                    data: {
                        genres: selectedGenres,
                        release_year: selectedYears,
                        price: selectedPrice,
                        sort: sortOption
                    },
                    success: function(response) {
                        $('#book-list').html(response.html);
                        const params = new URLSearchParams(window.location.search);
                        params.set('genres[]', selectedGenres);
                        if(selectedGenres == ''){
                            params.delete('genres[]');
                        }
                        params.set('release_year[]', selectedYears);
                        if(selectedYears == ''){
                            params.delete('release_year[]');
                        }
                        if (selectedPrice) {
                            params.set('price', selectedPrice);
                        } else {
                            params.delete('price');
                        }
                        if(sortOption != ''){
                            params.set('sort', sortOption);
                        }
                        window.history.replaceState({}, "", decodeURIComponent(`${window.location.pathname}?${params}`));
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        console.error('Status:', status);
                        console.error('Response:', xhr.responseText);
                    }
                });
              }
        });
    </script>
    @include('layout.footer')

</body>
</html>
