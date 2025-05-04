<?php

use App\Http\Controllers\login\LoginController;
use App\Http\Controllers\login\LoginControllerNotSafe;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [LoginController::class, 'showLoginForm']);
Route::get('/login',[App\Http\Controllers\login\LoginController::class,'logon'])->name('login');
Route::post('/login',[App\Http\Controllers\login\LoginController::class,'postLogin'])->name('post.login');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('/register', [LoginController::class, 'showLoginForm'])->name('register');
Route::post('/register', [LoginController::class, 'postRegister'])->name('post.register');

Route::get('/logout',[App\Http\Controllers\login\LoginController::class,'Logout'])->name('logout');
Route::prefix('admin')->middleware(['main.auth','admin.auth'])->group(function () {
    Route::get('/', function () {
        return redirect('/admin/dashboard');
    })->name('dashboard');



/*---------------*/

/* Route::get('/', [LoginControllerNotSafe::class, 'showLoginForm']);
Route::get('/login',[App\Http\Controllers\login\LoginControllerNotSafe::class,'logon'])->name('login');
Route::post('/login',[App\Http\Controllers\login\LoginControllerNotSafe::class,'postLogin'])->name('post.login');


Route::get('/login', [LoginControllerNotSafe::class, 'showLoginForm'])->name('login');
Route::get('/register', [LoginControllerNotSafe::class, 'showLoginForm'])->name('register');
Route::post('/register', [LoginControllerNotSafe::class, 'postRegister'])->name('post.register');

Route::get('/logout',[App\Http\Controllers\login\LoginControllerNotSafe::class,'Logout'])->name('logout');
Route::prefix('admin')->group(function () {
    Route::get('/', function () {
        return redirect('/admin/dashboard');
    })->name('dashboard');
 */

 /*---------------*/

Route::get('/test',[\App\Http\Controllers\test::class,'index']);

    Route::get('/dashboard', [\App\Http\Controllers\admin\AdminController::class,'Dashboard'])->name('dashboard');
    Route::get('/customers', [App\Http\Controllers\admin\AdminController::class, 'Customers'])->name('customers');
    Route::get('/customers/{customer}', [\App\Http\Controllers\admin\AdminController::class, 'CustomerContext'])->name('customers.show');
    Route::get('/orders', [App\Http\Controllers\admin\AdminController::class, 'Orders'])->name('orders');
    Route::get('/orders/{order_id}', [\App\Http\Controllers\admin\AdminController::class, 'OrderContext'])->name('orders.show');
    Route::get('/product_management', [App\Http\Controllers\admin\BookController::class, 'index'])->name('product_management');
    Route::get('/create', [App\Http\Controllers\admin\BookController::class, 'create'])->name('create');
    Route::post('/store', [App\Http\Controllers\admin\BookController::class, 'store'])->name('store');
    Route::get('/{book}/edit', [App\Http\Controllers\admin\BookController::class, 'edit'])->name('edit');
    Route::post('/book/{book}', [App\Http\Controllers\admin\BookController::class, 'update'])->name('update');
    Route::delete('/{book}/delete', [App\Http\Controllers\admin\BookController::class, 'delete'])->name('delete');
});



/*=================BOOK DETAIL========================= */
use App\Http\Controllers\bookDetail\bookDetailController;

Route::get('/book/{book_id}', [App\Http\Controllers\bookDetail\bookDetailController::class, 'bookDetail'])->name('book.detail.guest');
Route::get('/book/user/{book_id}', [App\Http\Controllers\bookDetail\bookDetailCustomerController::class, 'bookDetailCustomer'])->name('book.detail.user');
Route::post('/book/user/{book_id}', [App\Http\Controllers\bookDetail\bookDetailCustomerController::class, 'addbook'])->name('add.book');
Route::get('/book/{book_id}/route', [App\Http\Controllers\bookDetail\bookDetailController::class, 'index'])->name('book.detail');

use App\Http\Controllers\bookDetail\bookDetailCustomerController;
Route::post('/insert-rating', [App\Http\Controllers\bookDetail\bookDetailCustomerController::class, 'insert_rating']);


/*=================HOME========================== */
use App\Http\Controllers\homeController;
Route::get('/', [homeController::class, 'home'])->name('home');

/*=================Shop========================== */

Route::get('/shop', [App\Http\Controllers\shop\ShopController::class, 'index'])->name('shop.index');
Route::post('/shop/filter', [App\Http\Controllers\shop\ShopController::class, 'filter'])->name('shop.filter');
Route::post('/shop', [App\Http\Controllers\shop\ShopController::class, 'search'])->name('shop.search');
Route::post('/shop/add', [App\Http\Controllers\shop\ShopController::class, 'add'])->name('shop.add');

/*---------------*/
/* Route::get('/shop', [App\Http\Controllers\shop\ShopControllerNotSafe::class, 'index'])->name('shop.index');
Route::post('/shop/filter', [App\Http\Controllers\shop\ShopControllerNotSafe::class, 'filter'])->name('shop.filter');
Route::post('/shop', [App\Http\Controllers\shop\ShopControllerNotSafe::class, 'search'])->name('shop.search');
Route::post('/shop/add', [App\Http\Controllers\shop\ShopControllerNotSafe::class, 'add'])->name('shop.add'); */


/*=================Shop========================== */

Route::post('/shop/addBookToUserCard/{$bookid}', [bookDetailCustomerController::class, 'addbook'])->name('shop.additem');


Route::middleware(['main.auth','user.auth'])->group(function () {

    /*=================PROFILE========================== */
    Route::get('/profile',[ProfileController::class,'index'])->name('profile');
Route::get('/profile/order',[ProfileController::class,'listorder'])->name('profile.order');
Route::post('/profile/update/{id}',[ProfileController::class,'update']);
Route::post('/profile/update_pass/{id}',[ProfileController::class,'updatePass']);

    /*=================BOOK DETAIL========================== */
Route::get('/book/user/{book_id}', [App\Http\Controllers\bookDetail\bookDetailCustomerController::class, 'bookDetailCustomer'])->name('book.detail.user');

    /*=================CART========================== */
Route::get('/cart', [App\Http\Controllers\cart\CartController::class, 'showCart'])->name('cart.index');
Route::post('/cart/update/{itemId}', [App\Http\Controllers\cart\CartController::class, 'updateCartItem'])->name('cart.update');
Route::delete('/cart/remove/{itemId}', [App\Http\Controllers\cart\CartController::class, 'removeFromCart'])->name('cart.remove');

    /*=================PAYMENT========================== */
Route::get('/payment/index', [PaymentController::class, 'index']);
Route::post('/payment/submit', [PaymentController::class, 'submit']);

});


