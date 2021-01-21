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

Route::get('/', 'PageController@index');

Route::group(['middleware' => 'csrf'], function () {
    // Password reset link request routes...
    Route::get('password/email', 'Auth\PasswordController@getEmail');
    Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
    Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
    Route::post('password/reset', 'Auth\PasswordController@postReset');

    Route::controllers([
        'auth' => 'Auth\AuthController',
        'password' => 'Auth\PasswordController',
        'corn' => 'CornController'
    ]);
});

Route::group(['middleware' => ['auth'], 'prefix' => 'webpanel'], function () {
    Route::get('/', ['as' => 'dashboard', function () {
        return redirect()->to('webpanel/dashboard');
    }]);

    Route::get('unauthorized', function () {
        return view('webpanel.unauthorized');
    });
     // new changes
    Route::get('contact', 'Admin\UsersController@contact');
    Route::post('contact', 'Admin\UsersController@contact');
    // stop new changes
    Route::controller('dashboard', 'Admin\DashboardController');

    Route::get('my/profile', array('uses' => 'Admin\UsersController@getProfile'));
    Route::post('my/profile', array('as' => 'admin.profile.update', 'uses' => 'Admin\UsersController@postProfile'));

    Route::get('my/password', array('uses' => 'Admin\UsersController@getChangePassword'));
    Route::post('my/password', array('uses' => 'Admin\UsersController@postChangePassword'));

    Route::resource('users', 'Admin\UsersController');
    Route::controller('users', 'Admin\UsersController');

    Route::resource('products', 'Admin\ProductsController');
    Route::controller('products', 'Admin\ProductsController');
    Route::get('products-orders', 'Admin\ProductsController@getOrders');

    Route::controller('charts', 'Admin\ChartsController');

    Route::resource('orders', 'Admin\OrdersController');
    Route::controller('orders', 'Admin\OrdersController');

    Route::resource('colors', 'Admin\ColorsController');
    Route::controller('colors', 'Admin\ColorsController');

    Route::get('commissions', 'Admin\InvoicesController@getCommissions');
    Route::resource('invoices', 'Admin\InvoicesController');
    Route::controller('invoices', 'Admin\InvoicesController');

    Route::resource('withdraws', 'Admin\WithdrawsController');
    Route::controller('withdraws', 'Admin\WithdrawsController');

    Route::controller('emails', 'Admin\EmailsController');

    Route::controller('stats', 'Admin\StatsController');
    Route::controller('refunds', 'Admin\RefundsController');


    Route::resource('factoryorders', 'Admin\FactoryOrdersController');
    Route::controller('factoryorders', 'Admin\FactoryOrdersController');

    Route::controller('memo','Admin\MemoController');

    Route::resource('creditnotes', 'Admin\CreditNotesController');
    Route::controller('creditnotes', 'Admin\CreditNotesController');

    Route::resource('currencies', 'Admin\CurrenciesController');
    Route::controller('currencies', 'Admin\CurrenciesController');

});
