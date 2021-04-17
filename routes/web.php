<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', ["uses"=>"ProductsController@index", 'as'=>'allProducts']);

// toate produsele
Route::get('products', ["uses"=>"ProductsController@index", 'as'=>'allProducts']);

// produse type laptop
Route::get('products/laptop', ["uses"=>"ProductsController@laptopProducts", 'as'=>'laptopProducts']);

// produse type desktop
Route::get('products/desktop', ["uses"=>"ProductsController@desktopProducts", 'as'=>'desktopProducts']);

// produse type accesorii
Route::get('products/accesorii', ["uses"=>"ProductsController@accesoriiProducts", 'as'=>'accesoriiProducts']);

//search
Route::get('search', ["uses"=>"ProductsController@search", 'as'=>'searchProducts']);

// adauga in cos
Route::get('product/addToCart/{id}', ['uses'=>'ProductsController@addProductToCart', 'as'=>'AddToCartProduct']);

// pagina de cos
Route::get('cart', ["uses"=>"ProductsController@showCart", 'as'=>'cartproducts']);

// sterge produs din cos
Route::get('product/deleteItemFromCart/{id}', ['uses'=>'ProductsController@deleteItemFromCart', 'as'=>'DeleteItemFromCart']);


// autentificare
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// interfata administrator
Route::get('admin/products', ["uses"=>"Admin\AdminProductsController@index", 'as'=>'adminDisplayProducts'])->middleware('restrictToAdmin');

// afiseaza formularul de editare produse
Route::get('admin/editProductForm/{id}', ["uses"=>"Admin\AdminProductsController@editProductForm", 'as'=>'adminEditProductForm']);

// afiseaza form de editare imagine produs
Route::get('admin/editProductImageForm/{id}', ["uses"=>"Admin\AdminProductsController@editProductImageForm", 'as'=>'adminEditProductImageForm']);

// schimba imagine produs
Route::post('admin/updateProductImage/{id}', ["uses"=>"Admin\AdminProductsController@updateProductImage", 'as'=>'adminUpdateProductImage']);

// schimba detalii produs
Route::post('admin/updateProduct/{id}', ["uses"=>"Admin\AdminProductsController@updateProduct", 'as'=>'adminUpdateProduct']);

// afiseaza formularul adaugare produse
Route::get('admin/createProductForm', ["uses"=>"Admin\AdminProductsController@createProductForm", 'as'=>'adminCreateProductForm']);

// adauga produs nou in db
Route::post('admin/sendCreateProductForm', ["uses"=>"Admin\AdminProductsController@sendCreateProductForm", 'as'=>'adminSendCreateProductForm']);

// sterge produs
Route::get('admin/deleteProduct/{id}', ["uses"=>"Admin\AdminProductsController@deleteProduct", 'as'=>'adminDeleteProduct']);
