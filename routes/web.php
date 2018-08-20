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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::get('/labs', 'HomeController@labs')->name('labs');



Route::prefix('admin')->middleware('admin')->group(function(){
    Route::get('/dashboard', 'AdminController@index')->name('admin_dashboard');


    Route::get('/groups', 'GroupController@index')->name('group_index');
    Route::get('/groups/create', 'GroupController@create')->name('create_group');
    Route::post('/groups/create', 'GroupController@store')->name('store_group');
    Route::get('/groups/{group}', 'GroupController@show')->name('show_group');
    Route::get('/groups/{group}/edit', 'GroupController@edit')->name('edit_group');
    Route::put('/groups/{group}', 'GroupController@update')->name('update_group');
    Route::delete('/groups/{group}', 'GroupController@destroy')->name('delete_group');


    Route::get('/categories', 'CategoryController@index')->name('category_index');
    Route::post('/category/create', 'CategoryController@store')->name('store_category');
    Route::get('/categories/{category}', 'CategoryController@show')->name('show_category');
    Route::delete('/categories/{category}', 'CategoryController@destroy')->name('delete_category');
    Route::get('/categories/{category}/edit', 'CategoryController@edit')->name('edit_category');
    Route::put('/categories/{category}', 'CategoryController@update')->name('update_category');

    Route::get('/labs', 'LabController@index')->name('lab_index');
    Route::post('/lab/create', 'LabController@store')->name('store_lab');
    Route::get('/labs/{lab}', 'LabController@show')->name('show_lab');
    Route::get('/labs/{lab}/tests', 'LabController@tests')->name('show_lab_tests');

    Route::get('/labs/{lab}/link_tests', 'LabController@linkTests')->name('link_lab_tests_to_group');
    Route::get('/labs/{lab}/linked_tests', 'LabController@linkedTests')->name('manage_linked_lab_tests');
    
    Route::delete('/labs/{lab}/tests/{test}', 'LabController@deleteTest')->name('delete_lab_test');
    Route::post('/labs/{lab}/scrape', 'LabController@scrape')->name('scrape_lab_tests');
    Route::delete('/labs/{lab}', 'LabController@destroy')->name('delete_lab');
    Route::get('/labs/{lab}/edit', 'LabController@edit')->name('edit_lab');
    Route::get('/labs/{lab}/locations', 'LabController@showLocations')->name('show_lab_locations');
    Route::put('/labs/{lab}', 'LabController@update')->name('update_lab');


    Route::get('/labs/{lab}/get_tests', 'LabController@labTestsJson')->name('get_lab_tests');
    Route::put('/labs/{lab}/tests/{test}', 'TestController@update')->name('update_test_group');
    
    Route::put('/labs/{lab}/groups/{group}', 'TestController@updateGroupTest')->name('update_group_test');

    
    // Route::get('/labs', 'LabController@index')->name('lab_index');
    // Route::post('/lab/create', 'LabController@store')->name('store_lab');
    // Route::get('/labs/{lab}', 'LabController@show')->name('show_lab');
    
    Route::post('/labs/{lab}/location', 'LocationController@store')->name('store_location');
    Route::delete('/locations/{location}', 'LocationController@destroy')->name('delete_location');
    
    Route::put('/labs/{lab}/logo', 'LabController@updateLogo')->name('update_lab_logo');
    
    Route::get('/labs/{lab}/edit_bio', 'LabController@editBio')->name('edit_lab_bio');
    Route::put('/labs/{lab}/bio', 'LabController@updateBio')->name('update_lab_bio');
    Route::put('/labs/{lab}/bio_image', 'LabController@updateBioImage')->name('update_lab_bio_image');

    Route::get('/labs/{lab}/teams', 'LabController@teams')->name('manage_lab_teams');
    Route::post('/labs/{lab}/teams', 'LabController@addTeam')->name('add_team_member');
    
    Route::get('/labs/{lab}/packages', 'LabController@packages')->name('manage_lab_packages');
    Route::delete('/labs/{lab}/packages/{package}', 'LabController@deletePackage')->name('delete_lab_package');
    Route::put('/labs/{lab}/packages/{package}', 'LabController@updatePackage')->name('update_lab_package');
    Route::get('/labs/{lab}/packages/{package}/edit', 'LabController@editPackage')->name('edit_lab_package');
    Route::post('/labs/{lab}/packages', 'LabController@storePackage')->name('add_lab_package');

    
    Route::get('/labs/{lab}/gallery', 'LabController@gallery')->name('manage_lab_gallery');
    Route::post('/labs/{lab}/gallery', 'LabController@addGalleryImage')->name('add_gallery_image');

});

Route::get('/labs/{lab}', 'LabController@page')->name('lab_page');

Route::post('/cart', 'CartController@index')->name('show_cart');
Route::post('/cart/add', 'CartController@addToCart')->name('add_to_cart');
Route::post('/cart/remove', 'CartController@removeFromCart')->name('remove_from_cart');

