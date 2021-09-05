<?php

use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Config;
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
$namespace = 'App\Modules\Home\Controllers';
Route::group(
    ['namespace' => $namespace, 'prefix'=>'', 'middleware' => ['web']],
    function() {
        Route::get('', 'HomeController@Index')->name('Home');
        Route::get('/{lang?}', 'HomeController@Index')->name('home.lang');
    }
);
