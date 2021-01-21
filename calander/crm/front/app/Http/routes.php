<?php
if (version_compare(PHP_VERSION, '7.2.0', '>=')) {
    // Ignores notices and reports all other kinds... and warnings
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
    // error_reporting(E_ALL ^ E_WARNING); // Maybe this is enough
}
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::any('/', 'FrontController@index');
Route::any('/en', 'FrontController@index');
Route::any('/hi', 'FrontController@index');
Route::any('/ru', 'FrontController@index');
Route::any('/it', 'FrontController@index');
Route::any('/gr', 'FrontController@index');
Route::any('/shipping-policy', 'FrontController@index');
Route::get('/shipping-policy', function () {
    return view('webpanel.front.shipping-policy');
});


// new group route
 
 $url= explode('/',Request::url());

 // echo '<pre>';print_r($url[5]);
 // die;
 Route::group(['prefix' => $url[5]], function()  
{

Route::any('/', 'FrontController@index');  
Route::any('/products', 'FrontController@products');
Route::any('/blog', 'FrontController@products');
//Route::any('/blog', 'FrontController@products');
Route::any('/contact', 'FrontController@contact');
Route::any('/user-login', 'FrontController@userLogin');
Route::any('/user-register', 'FrontController@userRegister');
Route::get('/shipping-policy', function () {
    return view('webpanel.front.shipping-policy');
});
  
}); 
 
Route::get('/user-login', 'FrontController@userLogin');
Route::post('/user-login', 'FrontController@userLogin');

//03-01-2020
Route::any('/forgot', 'FrontController@forgotPass');
Route::any('/reset/{id}', 'FrontController@resetPass');
Route::any('/check-guest', 'FrontController@checkGuest');
Route::any('/register-guest', 'FrontController@registerGuest');
//03-01-2020

Route::get('/user-register', 'FrontController@userRegister');
Route::post('/user-register', 'FrontController@userRegister');
Route::any('/check-email', 'FrontController@checkEmail');
Route::any('/logout', 'FrontController@logout');

Route::any('/product-info', 'FrontController@productInfo');
Route::any('/add-to-cart', 'Admin\OrdersController@postAddToCart');
Route::any('/add-cart', 'Admin\OrdersController@postAddToCart2');
Route::get('/single/{id}', 'Admin\ProductsController@getItemForOrder');
Route::get('/checkout', 'Admin\ProductsController@getItemForOrder');

Route::resource('orders', 'Admin\OrdersController');
Route::controller('orders', 'Admin\OrdersController');

Route::get('/orders/delete-cart-item/{id}', 'Admin\OrdersController@getDeleteCartItem');
Route::any('/post-cart', 'Admin\OrdersController@postCart');
Route::any('/order-history', 'Admin\OrdersController@orderHistory');
Route::any('/edit-profile', 'FrontController@editProfile');
Route::any('/update-profile', 'FrontController@updateProfile');

// for new letter
Route::any('/news-letter', 'FrontController@newsLetter');
Route::any('/unsubscribe/{email}', 'FrontController@unsubscribe');
Route::any('/unsubscribe-email', 'FrontController@unsubscribeEmail');


Route::any('/paypal-transaction', 'FrontController@paypalTransaction');

Route::any('/products', 'FrontController@products');
Route::post('/user-rating', 'FrontController@userRating');
Route::any('/contact', 'FrontController@contact');

// 22 Apr

Route::any('/apply-coupon', 'FrontController@applyCoupon');


Route::any('/invoice/{id}', 'Admin\OrdersController@getDownload');

Route::group(['prefix' => ''], function() {
    define('IMGPATH','https://crm.morettimilano.com');
    define('NO_IMG','https://morettimilano.com/shop/public/front/images/no_image.jpg');
});
Route::any('/page-not-found', function () {
    return view('webpanel.front.page-notfound');
});










