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

Route::post('get/closest_location', 'LabController@closestLocation')->name('closest_location');



Route::prefix('admin')->middleware('admin')->group(function(){
    Route::get('/dashboard', 'AdminController@index')->name('admin_dashboard');

    Route::get('/users', 'UserController@index')->name('user_index');
    Route::put('/users/{user}/assign', 'UserController@assignLab')->name('assign_lab');
    Route::put('/users/{user}/unassign', 'UserController@unassignLab')->name('unassign_lab');
    Route::put('/users/{user}/approve', 'UserController@approveLab')->name('approve_lab');
    Route::put('/users/{user}/unapprove', 'UserController@unapproveLab')->name('unapprove_lab');
    Route::delete('/users/{user}', 'UserController@destroy')->name('delete_user');
    
    
    
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

    Route::post('/labs/{lab}/tests', 'TestController@store')->name('store_test');

    Route::get('/labs/{lab}/link_tests', 'LabController@linkTests')->name('link_lab_tests_to_group');
    Route::get('/labs/{lab}/linked_tests', 'LabController@linkedTests')->name('manage_linked_lab_tests');
    
    Route::get('/labs/{lab}/tests/{test}/edit', 'TestController@edit')->name('edit_lab_test');
    Route::delete('/labs/{lab}/tests/{test}', 'LabController@deleteTest')->name('delete_lab_test');
    Route::post('/labs/{lab}/scrape', 'LabController@scrape')->name('scrape_lab_tests');
    Route::delete('/labs/{lab}', 'LabController@destroy')->name('delete_lab');
    Route::get('/labs/{lab}/edit', 'LabController@edit')->name('edit_lab');
    Route::get('/labs/{lab}/locations', 'LabController@showLocations')->name('show_lab_locations');
    Route::put('/labs/{lab}', 'LabController@update')->name('update_lab');


    Route::get('/labs/{lab}/get_tests', 'LabController@labTestsJson')->name('get_lab_tests');
    Route::put('/labs/{lab}/tests/{test}', 'TestController@update')->name('update_test_group');
    
    Route::put('/labs/{lab}/groups/{group}', 'TestController@updateGroupTest')->name('update_group_test');
    
    Route::post('/labs/{lab}/location', 'LocationController@store')->name('store_location');
    Route::delete('/locations/{location}', 'LocationController@destroy')->name('delete_location');
    
    Route::put('/labs/{lab}/logo', 'LabController@updateLogo')->name('update_lab_logo');
    
    Route::get('/labs/{lab}/edit_bio', 'LabController@editBio')->name('edit_lab_bio');
    Route::put('/labs/{lab}/bio', 'LabController@updateBio')->name('update_lab_bio');
    Route::put('/labs/{lab}/bio_image', 'LabController@updateBioImage')->name('update_lab_bio_image');

    Route::get('/labs/{lab}/teams', 'LabController@teams')->name('manage_lab_teams');
    Route::post('/labs/{lab}/teams', 'LabController@addTeam')->name('add_team_member');
    Route::delete('/labs/{lab}/teams/{team}', 'LabController@deleteTeam')->name('delete_team_member');
    
    Route::get('/labs/{lab}/packages', 'LabController@packages')->name('manage_lab_packages');
    Route::delete('/labs/{lab}/packages/{package}', 'LabController@deletePackage')->name('delete_lab_package');
    Route::put('/labs/{lab}/packages/{package}', 'LabController@updatePackage')->name('update_lab_package');
    Route::get('/labs/{lab}/packages/{package}/edit', 'LabController@editPackage')->name('edit_lab_package');
    Route::post('/labs/{lab}/packages', 'LabController@storePackage')->name('add_lab_package');
    
    Route::get('/labs/{lab}/gallery', 'LabController@gallery')->name('manage_lab_gallery');
    Route::post('/labs/{lab}/gallery', 'LabController@addGalleryImage')->name('add_gallery_image');
    Route::get('/labs/{lab}/images/{image}', 'LabController@editGalleryImage')->name('edit_gallery_image');
    Route::put('/labs/{lab}/images/{image}', 'LabController@updateGalleryImage')->name('update_gallery_image');
    Route::delete('/labs/{lab}/images/{image}', 'LabController@deleteGalleryImage')->name('delete_gallery_image');
    

});
Route::prefix('user')->middleware(['auth'])->group(function(){

    Route::post('/lab/create', 'LabController@store')->name('store_lab');

    Route::get('/create_lab', 'LabController@createLab')->name('user_create_lab')->middleware('hasNoLab');

    Route::group(['middleware' => ['owner', 'auth']], function () {
    
        Route::get('/{lab}', 'LabController@show')->name('user_show_lab');
        
        Route::get('/{lab}/tests', 'LabController@tests')->name('user_show_lab_tests');
        Route::get('/{lab}/link_tests', 'LabController@linkTests')->name('user_link_lab_tests_to_group');
        Route::get('/{lab}/linked_tests', 'LabController@linkedTests')->name('user_manage_linked_lab_tests');
        
        Route::get('/{lab}/edit', 'LabController@edit')->name('user_edit_lab');
        
        Route::get('/{lab}/tests/{test}/edit', 'TestController@edit')->name('user_edit_lab_test');
        Route::get('/{lab}/locations', 'LabController@showLocations')->name('user_show_lab_locations');
        
        Route::get('/{lab}/edit_bio', 'LabController@editBio')->name('user_edit_lab_bio');
        Route::get('/{lab}/teams', 'LabController@teams')->name('user_manage_lab_teams');
        
        Route::get('/{lab}/packages', 'LabController@packages')->name('user_manage_lab_packages');
        Route::get('/{lab}/packages/{package}/edit', 'LabController@editPackage')->name('user_edit_lab_package');
        Route::get('/{lab}/gallery', 'LabController@gallery')->name('user_manage_lab_gallery');
        
        Route::get('/{lab}/get_tests', 'LabController@labTestsJson')->name('user_get_lab_tests');
    });
    

});


Route::get('/labs/{lab}', 'LabController@page')->name('lab_page');

Route::post('/cart', 'CartController@index')->name('show_cart');
Route::post('/cart/add', 'CartController@addToCart')->name('add_to_cart');
Route::post('/cart/remove', 'CartController@removeFromCart')->name('remove_from_cart');

