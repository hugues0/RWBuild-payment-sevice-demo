<?php

use App\Http\Controllers\MurugoLoginController;
use App\Models\Role;
use Illuminate\Support\Facades\Route;

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



Route::get('/', function () {
  return view('welcome');
});

Route::get('/dashboard', function () {
  return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';



//admin role group
Route::group(['middleware' => 'role:'.Role::IS_SUPER_ADMIN], function() {  
  Route::put('/users/{user}','App\Http\Controllers\UserController@update');
});


Route::group(['middleware' => 'role:'.Role::IS_USER], function() {  
  Route::get('/payments','App\Http\Controllers\PaymentController@processPayment')->name('payments');
});

Route::group(['middleware' => 'role:'.Role::IS_ADMIN], function() {  
  Route::resource('/configurations','App\Http\Controllers\ConfigurationController');
});

//Murugo authentication routes

Route::get('/murugo-login', 'App\Http\Controllers\MurugoLoginController@redirectToMurugo')->name('murugo.login');

Route::get('/murugo-callback', 'App\Http\Controllers\MurugoLoginController@murugoCallback')->name('murugo.callback');


// murugo sites services routes 

Route::get('/site-services/approved-organizations', 'App\Http\Controllers\SiteServiceController@getApprovedOrganizations');
Route::get('/site-services/approved-locations', 'App\Http\Controllers\SiteServiceController@getApprovedLocations');
Route::get('/site-services/search-location', 'App\Http\Controllers\SiteServiceController@searchLocation');
Route::get('/site-services/search-organization', 'App\Http\Controllers\SiteServiceController@searchOrganization');


