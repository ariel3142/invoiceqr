<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DashboardController;

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
    return view('welcome-secure'); // atau redirect ke halaman lain
});


Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('orders/{order}/pay', [OrderController::class, 'markPaid']);
Route::get('orders/{order}/invoice', [OrderController::class, 'invoice'])->name('orders.invoice');
Route::get('pickup/{code}', [OrderController::class, 'pickup'])->name('orders.pickup');
Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');



require __DIR__.'/auth.php';
