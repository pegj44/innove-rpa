<?php

use App\Http\Controllers\FunderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TradingCredentialsController;
use App\Http\Controllers\TradingIndividualController;
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

    Route::controller(TradingUnitController::class)->group(function()
    {
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

    Route::controller(FunderController::class)->group(function()
    {
        Route::get('/funder/list', 'index')->name('funders');
        Route::get('/funder/add', 'create')->name('funder.create');
        Route::post('/funder', 'store')->name('funder.store');
        Route::get('/funder/{id}', 'edit')->name('funder.edit');
        Route::post('/funder/{id}', 'update')->name('funder.update');
        Route::delete('/funder/{id}', 'destroy')->name('funder.delete');
    });

    Route::prefix('trading-account')->name('trading-account.')->group(function()
    {
        Route::controller(TradingIndividualController::class)->group(function()
        {
            Route::get('/individual/list', 'getIndividuals')->name('individual.list');
            Route::get('/individual/add', 'create')->name('individual.create');
            Route::get('/individual/{id}', 'edit')->name('individual.edit');
            Route::delete('/individual/{id}', 'destroy')->name('individual.delete');
            Route::post('/individual/{id}', 'update')->name('individual.update');
            Route::post('/individual', 'store')->name('individual.store');
        });

        Route::controller(TradingCredentialsController::class)->group(function()
        {
            Route::get('/credential/list', 'getCredentials')->name('credential.list');
            Route::get('/credential/add', 'create')->name('credential.create');
            Route::post('/credential', 'store')->name('credential.store');
        });
    });

});

require __DIR__.'/auth.php';
