<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pmweb_Orders_StatsController;
 

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

Route::get(
    '/getStaticOrdersByDate',
    [
        Pmweb_Orders_StatsController::class,
        'getStaticOrdersByDate'
    ]
);

Route::get(
    '/getOrdersByDate',
    [
        Pmweb_Orders_StatsController::class,
        'getOrdersByDate'
    ]
);
