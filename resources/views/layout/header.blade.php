<!--==============HEADER==================-->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
<link rel="stylesheet" href="{{ asset('css/default-font.css') }}">
<link rel="stylesheet" href="{{asset('frontend/css/header.css')}}">

<header class="header container-fluid">
    <ul class="nav navbar container">
        <li>
            <a href="{{route('home')}}" class="nav_brand hihi">
                <h1 class = "display-5">Verbify</h1>
            </a>
        </li>

        <li class = "col-5 d-md-inline d-none search_box">
            <form action = "{{route('shop.search')}}" method="POST" class="py-1 px-3">
                @csrf
                <input name="search" id = "searchbox" placeholder="Snow White and the Seven Dwarfs..." maxlength="100">
                <button type="submit" class = "search-btn fs-5 pt-1">
                    <i class = "bx bx-search-alt"></i>
                </button>
            </form>
        </li>


        <li class="header_icons col-md-auto text-end gx-2">
            <div id="search-btn" class = "p-1 d-md-none d-inline">
                <i class = "bx bx-search-alt fs-4"></i>
            </div>
            <div id="cart-btn" class = "p-1">
                <a href="{{route('cart.index')}}">
                <i class = "bx bx-cart-alt fs-4"></i>
                </a>
            </div>
            <div id="user-btn" class = "p-1">
                <a href="{{route('profile')}}"><i class = "@if(Auth::check()) bx bxs-user-circle @else bx bx-user-circle @endif fs-4 "></i></a>
            </div>
        </li>
        @if(Auth::check())

        <li class="dropdown dropdown1 p-2 px-md-3 shadow" id="dropdown">
            @foreach(DB::select('CALL get_cart_items_by_cart_id(?)', [Auth::user()->CART_ID]) as $book)
            <div class="cart-item p-1">
                <div class="cart_img col-3">
                    <a href="#"><img src ="{{$book->IMAGE_LINK}}" class="img-fluid" alt="img"></a>
                </div>
                <span class="book_title col-5"><a href="#">{{$book->NAME}}</a></span>
                <span class="book_price col-3">{{$book->PRICE*$book->QUANTITY}}$</span>
                <span class="book_price col-3">x{{$book->QUANTITY}}</span>
            </div>
            @endforeach
            <div class="summary mt-2">
                <a href="/cart">
                <button class="btn-order">Go to cart</button>
                </a>
            </div>
        </li>
        @endif
        @if(Auth::check())
        <li class="profile p-3 px-md-3 shadow" id="profile">
            <div class = "d-flex flex-column justify-content-around">
                <a href="{{route('profile')}}"><img src="https://static.vecteezy.com/system/resources/previews/014/194/216/original/avatar-icon-human-a-person-s-badge-social-media-profile-symbol-the-symbol-of-a-person-vector.jpg" alt="img"></a>
                <a class = "h4 align-self-center name" href="{{route('profile')}}">{{Auth::user()->USERNAME}}</a>
            </div>
            <div class = "row g-4">
                <a class= "col fs-6 btn-order" href="{{route('profile.order')}}">Order</a>
                <a href="{{route('logout')}}" class="col btn-logout">Logout</a>
            </div>
        </li>
        @endif
    </ul>
</header>

<script>
        /*=============== SHOW SEARCH ===============*/
        let dropdown = document.getElementById('dropdown');
        let search = document.querySelector('.header .nav .search_box_hide');
        document.querySelector('#search-btn').onclick = () =>{
        search.classList.toggle('active');
        dropdown.classList.remove('show');
        }

        /*=============== SHOW CART ===============*/
        document.addEventListener('DOMContentLoaded', function () {
            const cartIcon = document.getElementById('cart-btn');
            const dropdown = document.getElementById('dropdown');
            const summary = document.querySelector('.summary p');

            const toggleDropdown = (show) => {
                dropdown.classList.toggle('show', show);
                search.classList.remove('active');
            };

            cartIcon.addEventListener('mouseenter', () => toggleDropdown(true));
            cartIcon.addEventListener('mouseleave', () => toggleDropdown(false));
            dropdown.addEventListener('mouseenter', () => toggleDropdown(true));
            dropdown.addEventListener('mouseleave', () => toggleDropdown(false));

            const updateTotalProducts = () => {
                const totalProducts = document.querySelectorAll('.cart-item').length;
                const productText = totalProducts >= 2 ? 'products' : 'product';
                summary.innerHTML = `Total ${totalProducts} ${productText}`;
            };

            document.querySelectorAll('.bxs-trash-alt').forEach(button => {
                button.addEventListener('click', (event) => {
                    const cartItem = event.target.closest('.cart-item');
                    if (cartItem) {
                        cartItem.classList.add('fade-out');
                        setTimeout(() => {
                            cartItem.remove();
                            updateTotalProducts();
                        }, 300);
                    }
                });
            });

            updateTotalProducts();
        });
        /*=================SHOW PROFILE==================*/
        document.addEventListener('DOMContentLoaded', function () {
            const userIcon = document.getElementById('user-btn');
            const profile = document.getElementById('profile');
            const toggleDropdown = (show) => {
                profile.classList.toggle('show', show);
                search.classList.remove('active');
                dropdown.classList.remove('show');
            };

            userIcon.addEventListener('mouseenter', () => toggleDropdown(true));
            userIcon.addEventListener('mouseleave', () => toggleDropdown(false));
            profile.addEventListener('mouseenter', () => toggleDropdown(true));
            profile.addEventListener('mouseleave', () => toggleDropdown(false));
        });
</script>
