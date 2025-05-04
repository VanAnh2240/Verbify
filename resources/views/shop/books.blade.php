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
