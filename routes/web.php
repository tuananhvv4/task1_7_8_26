<?php

use App\Http\Controllers\BillController;
use Illuminate\Support\Facades\Route;

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
});

Route::prefix('/bill')->group(
    function () {
        Route::post('/archive', [BillController::class, 'archive'])->name('bill.archive');
        Route::post("/check-bill", [BillController::class, 'checkBill'])->name('bill.check');
        Route::patch("/mass-update", [BillController::class, 'massUpdate'])->name('bill.massupdate');
    }
);

Route::resource('bill', BillController::class);