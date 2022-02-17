<?php

use App\Http\Controllers\MurugoLoginController;
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
Route::group(['middleware' => 'is_super_admin'], function() {  
  Route::put('/users/{user}','App\Http\Controllers\UserController@update');
});


Route::group(['middleware' => 'auth'], function() {  
  Route::get('/payments','App\Http\Controllers\PaymentController@processPayment')->name('payments');
});

Route::group(['middleware' => 'is_admin'], function() {  
  Route::resource('/configurations','App\Http\Controllers\ConfigurationController');
});


Route::get('/murugo-login', 'App\Http\Controllers\MurugoLoginController@redirectToMurugo')->name('murugo.login');

Route::get('/murugo-callback', 'App\Http\Controllers\MurugoLoginController@murugoCallback')->name('murugo.callback');
