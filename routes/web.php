<?php

use App\Http\Controllers\MurugoLoginController;
use App\Models\Role;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteServiceController;

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

Route::controller(MurugoLoginController::class)->group(function(){
  Route::get('/murugo-login','redirectToMurugo')->name('murugo.login');
  Route::get('/murugo-callback', 'murugoCallback')->name('murugo.callback');

});

// murugo sites services routes 

Route::controller(SiteServiceController::class)->group(function(){
  Route::get('/site-services/approved-organizations', 'getApprovedOrganizations');
  Route::get('/site-services/approved-locations', 'getApprovedLocations');
  Route::get('/site-services/search-location', 'searchLocation');
  Route::get('/site-services/search-organization', 'searchOrganization');
  Route::get('/site-services/submit-organization', 'submitOrganization');
  
});