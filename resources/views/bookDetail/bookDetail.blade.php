
<link rel="stylesheet" href="{{asset('frontend/css/product_detail.css')}}">
@extends('layout.user_MainStructure')
@section('title', $books->NAME)
@section('content')
    @if($books)
      <section class="intro py-5 mb-5">
        <div class="container">
          <div class="row g-5 mt-1">
            <div class="img col-md-6 col-12">
                <div class=" book-img col-12">
                  <img id="mainImage" src="{{$books->IMAGE_LINK}}" alt="img"></div>
                  <div class="row g-2 mt-1">
                    @foreach($booksImage as $bookIMG)
                      <button class="product-img col-3" data-img-src="{{$bookIMG->IMAGE_LINK}}" onclick="changeImage(this)">
                        <img src="{{$bookIMG->IMAGE_LINK}}" alt="img">
                      </button>
                    @endforeach
                  </div>
                </div>
            <div class="text col-md-6 col-12">
                <h1 class = "title display-3 mb-5">{{$books->NAME}}</h1>
                <p class = "subtitle h5 mb-4">{{$books->DESCRIPTION}}</p>
                <p class="book-price display-5 mb-4" >${{$books->PRICE}}</p>
                <div class=" info row mb-4">
                  <div class="col-6">
                      <div>
                          ISBN <span class="isbn">{{$books->ISBN}}</span>
                      </div>
                      <div>
                          Author: <span class="at">{{$books->AUTHOR}}</span>
                      </div>
                  </div>
                  <div class="col-6">
                      <div>
                          Release year <span class="isbn">{{$books->RELEASE_YEAR}}</span>
                      </div>
                      <div>
                          Page Quantity: <span class="at">{{$books->PAGE_QUANTITY}}</span>
                      </div>
                  </div>
                </div>
            <div class="quantity-container col-3 mb-5">
                <button class="quantity-button col-4" id="decrease">-</button>
                <input type="number" id="quantity" class="quantity-input col-4" value="1" min="1">
                <button class="quantity-button col-4" id="increase">+</button>
            </div>
            <div class="button1">
                <a href="{{route('login')}}">
              <button class="cart-btn col-5" style="margin-right: 1.5rem"> <svg xmlns="http://www.w3.org/2000/svg" width="30" height="25" viewBox="0 0 35 36" fill="none">
                  <path d="M15.3125 30.9585C16.5206 30.9585 17.5 29.9791 17.5 28.771C17.5 27.5629 16.5206 26.5835 15.3125 26.5835C14.1044 26.5835 13.125 27.5629 13.125 28.771C13.125 29.9791 14.1044 30.9585 15.3125 30.9585Z" fill="#FCFCFC"/>
                  <path d="M25.5205 30.9585C26.7286 30.9585 27.708 29.9791 27.708 28.771C27.708 27.5629 26.7286 26.5835 25.5205 26.5835C24.3124 26.5835 23.333 27.5629 23.333 28.771C23.333 29.9791 24.3124 30.9585 25.5205 30.9585Z" fill="#FCFCFC"/>
                  <path d="M18.9581 19.2919H21.8747V14.9314H26.2352V12.0148H21.8747V7.66895H18.9581V12.0148H14.5977V14.9314H18.9581V19.2919Z" fill="#FCFCFC"/>
                  <path d="M14.5837 25.1252H26.2503C26.5441 25.1243 26.8308 25.0347 27.0728 24.8682C27.3148 24.7017 27.5008 24.4659 27.6066 24.1918L31.7337 13.4585H28.6128L25.2441 22.2085H15.5607L9.01283 6.50225C8.79082 5.97005 8.41603 5.5156 7.93583 5.19633C7.45563 4.87706 6.89156 4.7073 6.31491 4.7085H2.91699V7.62517H6.31491L13.242 24.221C13.3514 24.4873 13.5372 24.7153 13.7759 24.8762C14.0147 25.0371 14.2957 25.1237 14.5837 25.1252Z" fill="#FCFCFC"/>
                  </svg> Add to cart
                </button>

              <button class="buy-btn col-5">Buy now</button>
                </a>
            </div>

            </div>
          </div>
        </div>
      </section>

      <script>
            document.getElementById('increase').addEventListener('click', function() {
            let quantityInput = document.getElementById('quantity');
            quantityInput.value = parseInt(quantityInput.value) + 1;
          });

          document.getElementById('decrease').addEventListener('click', function() {
              let quantityInput = document.getElementById('quantity');
              if (quantityInput.value > 1) {
                  quantityInput.value = parseInt(quantityInput.value) - 1;
              }
          });
      </script>
      <!--=============== SIMILAR ===============-->
      <section class="genres">
          <div class="container p-2 p-md-4 mb-5">
              <div class="section_title mb-3">
                <p class="title">Similar Books</p>
                <hr class="hr1">
              </div>
              <div class="row ">
                @foreach ($booksSimilar as $book)
                  <div class="col">
                    <div class="book_item">
                        <a href="{{route('book.detail',$book->BOOK_ID)}}"  class="book_img"><img src="{{$book->IMAGE_LINK}}" alt="img"></a>
                        <div class="book_info px-4 py-2">
                          <div class="book_title fs-5"><a href="{{route('book.detail',$book->BOOK_ID)}}">{{$book->NAME}}</a></div>
                          <div class="book_author fs-5">{{$book->AUTHOR}}</div>
                          <div class="book_price fs-5">${{$book->PRICE}}</div>
                        </div>
                      </div>
                  </div>
                @endforeach
              </div>
          </div>
      </section>
      <!--=============== INFORMATION ===============-->
      <section class="information">
          <div class="container p-2 p-md-4 mb-5">
              <div class="section_title mb-3">
                <p class="title">Book Information</p>
                <hr>
              </div>
              <div class=" book_detail">
                  <div> Author: {{$books->AUTHOR}}</div>
                  <div> Language: {{$books->LANGUAGE}}</div>
                  <div> Release Year: {{$books->RELEASE_YEAR}}</div>
                  <hr class="hr2 mb-4">
              </div>
              <div class="mb-3">{{$books->DESCRIPTION}}
              </div>
          </div>
      </section>
      <!--=============== REVIEW ===============-->
      <section class="review">
          <div class="container p-2 p-md-4 mb-5">
              <div class="section_title mb-5">
                <p class="title">Review</p><hr>
              </div>
              <div class="rate row g-4">
                  <div class="point col col-3 display-1"> {{$point}}/5</div>
                  <div class=" rate_detail col col-9 col-md-5 ">
                    @foreach ($percentages as $key => $percentage)
                      <div class = "star">
                        <div class = "fs-6">{{($key) }} stars</div>
                        <div class="progress">
                          <div class="progress-bar" role="progressbar" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100" style="width:{{ $percentage }}%"></div>
                        </div>
                        <div class = "fs-6">{{ $percentage }}%</div>
                      </div>
                    @endforeach
                  </div>
                  <div class="reminder col">Only registered users can write reviews. <br>Please, <a href="{{route('login')}}">login</a> or <a href="{{route('register')}}">register</a></div>
              </div>
              <hr class="hr3 mb-4">

              <div class="book_review mb-3">
                @foreach($customerReview as $review)
                  <div class="customer_1 row mb-5 ">
                      <div class="customer-info col-3">
                          <img class="avatar" src="https://static.vecteezy.com/system/resources/previews/014/194/216/original/avatar-icon-human-a-person-s-badge-social-media-profile-symbol-the-symbol-of-a-person-vector.jpg">
                          <div class="name">{{$review->USERNAME}}</div>
                      </div>
                      <div class="customer_review col-9">
                          <p class="customer_1_rate">
                            @for ($i = 0; $i < $review->RATING_STAR; $i++)
                              <svg xmlns="http://www.w3.org/2000/svg" width="40" height="41" viewBox="0 0 40 41" fill="none">
                                <path d="M36.5781 16.25C36.4733 15.9415 36.2805 15.6703 36.0234 15.4701C35.7663 15.2699 35.4562 15.1493 35.1314 15.1234L25.6297 14.3684L21.5181 5.26668C21.3871 4.97354 21.1741 4.72455 20.9048 4.54978C20.6355 4.37501 20.3213 4.28191 20.0003 4.28174C19.6792 4.28156 19.3649 4.37431 19.0954 4.54879C18.8259 4.72326 18.6127 4.97202 18.4814 5.26502L14.3697 14.3684L4.86805 15.1234C4.54881 15.1486 4.24362 15.2654 3.98898 15.4596C3.73434 15.6538 3.54104 15.9172 3.43221 16.2184C3.32337 16.5196 3.30361 16.8457 3.37529 17.1579C3.44697 17.47 3.60705 17.7548 3.83639 17.9784L10.8581 24.8234L8.37472 35.5767C8.29931 35.9022 8.32348 36.2428 8.44408 36.5544C8.56469 36.866 8.77616 37.1342 9.05106 37.3241C9.32595 37.514 9.65158 37.6169 9.98569 37.6194C10.3198 37.622 10.647 37.5241 10.9247 37.3384L19.9997 31.2884L29.0747 37.3384C29.3586 37.5268 29.6934 37.6239 30.0341 37.6164C30.3748 37.6089 30.705 37.4973 30.9804 37.2966C31.2557 37.0958 31.463 36.8155 31.5743 36.4935C31.6857 36.1714 31.6957 35.823 31.6031 35.495L28.5547 24.8284L36.1147 18.025C36.6097 17.5784 36.7914 16.8817 36.5781 16.25Z" fill="#EEA61A"/>
                              </svg>
                            @endfor
                          </p>
                          <div class="customer_1_review">{{$review->DESCRIPTION}}</div>
                      </div>
                  </div>
                @endforeach
              </div>
          </div>
      </section>
    @endif

  <script src="{{asset('frontend/js/product_detail.js')}}"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    function changeImage(button) {
        var imgUrl = button.getAttribute('data-img-src');
        var mainImage = document.getElementById('mainImage');
        mainImage.src = imgUrl;
  }
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
@endsection
