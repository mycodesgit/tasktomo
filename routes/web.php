<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DailyTaskController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['middleware'=>['guest']],function(){
    Route::get('/', function () {
        return view('login');
    });

    //Login
    Route::get('/login',[LoginController::class,'getLogin'])->name('getLogin');
    Route::post('/login',[LoginController::class,'postLogin'])->name('postLogin');
});

//Middleware
Route::group(['middleware'=>['login_auth']],function(){
    Route::get('/view/all',[DashboardController::class,'index'])->name('index.dashboard');
    Route::post('/logout',[DashboardController::class,'logout'])->name('logout');
    
    Route::get('/activity/dates', [DashboardController::class, 'fetchActivityDates'])->name('fetch.activity.dates');
    
    Route::prefix('daily/task')->group(function () {
        Route::get('/list/view', [DailyTaskController::class, 'index'])->name('index.task');
        Route::post('/list/add', [DailyTaskController::class, 'store'])->name('store.task');
        Route::get('/list/fetch', [DailyTaskController::class, 'show'])->name('fetch.tasks');
    });
});
