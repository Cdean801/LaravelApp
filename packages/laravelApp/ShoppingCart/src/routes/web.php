    <?php
Route::get('shopping-cart', function () {
    return 'Hello from the shoppingCart  package';
});



// MyVendor\contactform\src\routes\web.php
Route::group(['namespace' => 'laravelApp\ShoppingCart\Http\Controllers', 'middleware' => ['web']], function () {







/*  cart route starts */
Route::get('/productList', 'ProductController@productList');
Route::post('/getproductListData', 'ProductController@getproductListData');
Route::get('/getproductDiscription/{id}', 'ProductController@getproductDiscription')->name('product_discription');
Route::get('/cartProductList', 'ProductController@getproductListFilterData')->name('product.paginate');
Route::get('/cartProductListSearch', 'ProductController@getproductListSearchData')->name('product.paginate.search');
Route::get('/cart', 'CartController@index')->name('shopping.cart');
Route::get('/add-to-cart/{id}', 'CartController@getAddToCart')->name('add_to.cart');
Route::get('/minus-from-cart/{id}', 'CartController@getMinusFromCart')->name('minus_from.cart');
Route::post('/update_quantity', 'CartController@update_quantity')->name('update_quantity.cart');
Route::post('/add_to_cart_input_ajax/{id}', 'CartController@getAddToCartWithInputAjax')->name('add_to.cart_input_ajax');
Route::post('/add_to_cart_input/{id}', 'CartController@getAddToCartWithInput')->name('add_to.cart_input');
Route::get('/remove-from-cart/{id}', 'CartController@removeFromCart')->name('remove_from.cart');
Route::post('add_to_cart/{id}', 'CartController@addProductToCart')->name('add_to_cart');
/**cart rout ends */

Route::get('/checkout', 'CartController@checkout')->name('checkout');
// Route::get('/selectdate', 'CartController@selectDate')->name('selectDate');
// Route::get('/selectslot', 'CartController@selectSlot')->name('selectSlot');
Route::post('/finalcheckout', 'CartController@finalCheckout')->name('finalCheckout');

/*
|  Frontend Orders routes
 */
Route::resource('orders', 'OrderController');
Route::resource('order_lines', 'OrderLineController');


/*
|  Product routes
 */
Route::post('/product/datatable', 'ProductController@anyData')->name('product.data');
Route::get('/product/create', 'ProductController@index')->name('product.index');
Route::post('/product/create', 'ProductController@create')->name('product.create');
Route::get('/product/list', 'ProductController@paginate')->name('product.list');
Route::get('/product/edit/{id}', 'ProductController@edit')->name('product.edit');
Route::put('/product/update/{id}', 'ProductController@update')->name('product.update');
Route::get('/product/delete/{id}', 'ProductController@destroy')->name('product.delete');
Route::get('/product/getSub', 'ProductController@getSub');
Route::get('/product/getMainCategory/', 'ProductController@getMainCategory');
// Route::get('/product/checksku/{permission}', 'ProductController@checkSku');
Route::get('/product/checkEditSku/', 'ProductController@checkEditSku');

/*
|  admin orders
 */
Route::post('/orders/datatable', 'OrderController@adminIndexData')->name('orders.admin_index_data');
Route::get('/admin_orders', 'OrderController@adminIndex')->name('orders.admin_index');
/*END*/
/*
|  admin subscriptions
 */
Route::post('/subscriptions/datatable', 'AdminSubscription@adminIndexData')->name('subscriptions.admin_index_data');
Route::get('/admin_subscriptions', 'AdminSubscription@adminIndex')->name('subscriptions.admin_index');
/*END*/

/*
|  user orders
 */
Route::post('/my_orders/datatable', 'OrderController@myOrderData')->name('orders.my_orders_data');
Route::get('/user_index', 'OrderController@userIndex')->name('orders.user_index');
/*END*/
/*
|  User Subscription routes
 */
Route::get('/user_subscription/list/', 'UserSubscription@index')->name('user_subscription.index');
Route::post('/user_subscription/datatable', 'UserSubscription@users_data')->name('user_subscription.data');
Route::get('/user_subscription/view/{id}/', 'UserSubscription@show')->name('user_subscription.view');
Route::match(['get', 'post'], '/user_subscription/admincancel/{id}/', 'AdminSubscription@adminCancelSubscription')->name('AdminSubscription.adminCancelSubscription'); /*
/*

|  Report routes
 */
// Route::get('/report/sales/{permission}','ReportController@index')->name('report.index');
Route::get('/report/sales/', 'ReportController@salesReportIndex')->name('report.sales_index');
Route::post('/report/sales', 'ReportController@salesReport')->name('report.sales_report');



/*
|  Category routes
 */
Route::post('/categories/datatable', 'CategoryController@anyData')->name('categories.data');
Route::put('/sub-categories/update/{id}', 'CategoryController@updateSubCategory');
Route::delete('/sub-categories/delete/{id}', 'CategoryController@deleteSubCategory');
Route::get('/categories', 'CategoryController@index')->name('categories.index');
Route::get('/categories/create', 'CategoryController@create')->name('categories.create');
Route::post('/categories', 'CategoryController@store')->name('categories.store');
Route::get('/categories/{id}', 'CategoryController@show')->name('categories.show');
Route::get('/categories/edit/{id}', 'CategoryController@edit')->name('categories.edit');
Route::put('/categories/{id}', 'CategoryController@update')->name('categories.update');
Route::delete('/categories/delete/{id}', 'CategoryController@destroy')->name('categories.delete');

/*END*/



});
?>