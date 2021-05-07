<?php

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
    if(\Illuminate\Support\Facades\Auth::guest()) {
        return view('auth.login');
    }
    return view('dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::resource('company', \App\Http\Controllers\CompanyController::class)->middleware(['auth']);
Route::resource('employee', \App\Http\Controllers\EmployeeController::class)->middleware(['auth']);

require __DIR__.'/auth.php';
