<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TradingUnitController;
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
    return redirect('dashboard');
});

Route::middleware(['auth_api'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::controller(TradingUnitController::class)->group(function() {
        Route::get('/trading-units/units', 'index')->name('trading-unit.units');
        Route::get('/trading-units/settings', 'settings')->name('trading-unit.settings');

        Route::post('/register-unit', 'store')->name('trading-unit.create');
        Route::get('/register-unit', function() {
            return redirect('dashboard');
        });

        Route::post('/trading-unit/{id}', 'update')->name('trading-unit.update');
        Route::get('/trading-unit/{id}', function() {
            return redirect('dashboard');
        });

        Route::delete('/trading-unit/{id}', 'destroy')->name('trading-unit.delete');

        Route::post('/trading-unit/settings/set-password', 'setUnitPassword')->name('trading-unit.settings.set-password');
        Route::get('/trading-unit/settings/set-password', function() {
            return redirect('dashboard');
        });

        Route::post('/trading-unit/settings/update-password', 'updateUnitPassword')->name('trading-unit.settings.update-password');
        Route::get('/trading-unit/settings/update-password', function() {
            return redirect('dashboard');
        });
    });
});

require __DIR__.'/auth.php';
