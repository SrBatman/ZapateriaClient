<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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
Route::get('/', function () {
    return view('welcome');
})->name('home');


Route::get('inicio', function () {
    return view('index');
})->name('inicio')->middleware('auth.token');

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'create'])->name('register');
    Route::post('/register', [AuthController::class, 'store'])->name('register.submit');
    Route::get('/login', [AuthController::class, 'index'])->name('auth.login'); 
    Route::post('/login', [AuthController::class, 'getLogin'])->name('login.submit'); 
});


Route::middleware('auth.token')->group(function () {
    // Route::get();
    Route::controller(App\Http\Controllers\ProvidersController::class)->group(function () {
        Route::get('/providers', 'index')->name('providers.index');
        Route::get('/providers/create', 'create');
        Route::post('/providers/save','store');
        Route::get('/providers/edit/{product}', 'edit');
        Route::put('/providers/{product}', 'update');
        Route::delete('/providers/{product}', 'destroy');
    });
});






// Route::get('/admins/edit', [SessionsController::class,'create']);

// Route::get('/admins',[SessionsController::class,'index']);
// Route::get('/admins/create', [SessionsController::class,'create']);
// Route::get('/admins/edit', [SessionsController::class,'create']);



// Route::get('/providers',[SessionsController::class,'index']);
// Route::get('/providers/create', [SessionsController::class,'create']);
// Route::get('/providers/edit', [SessionsController::class,'create']);

// Route::get('/sessions/show', [SessionsController::class,'show']);
// Route::delete('/sessions/delete/{pos}',[SessionsController::class,'delete']);
// Route::put('/sessions/encrypt/{pos}',[SessionsController::class,'encrypt']);