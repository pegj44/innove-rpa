<?php

use App\Http\Controllers\FunderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TradeController;
use App\Http\Controllers\TradeReportController;
use App\Http\Controllers\TradingCredentialsController;
use App\Http\Controllers\TradingIndividualController;
use App\Http\Controllers\TradingUnitController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Pusher\Pusher;

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

Route::post('/pusher/broadcasting/unit-presence-auth', function (Request $request)
{
    $channelName = $request->input('channel_name');
    $socketId = $request->input('socket_id');
    info(print_r([
        '$channelName' => $channelName,
    ], true));
    if (strpos($channelName, 'presence-unit.') === 0) {
        $currentUserId = Session::get('api_user_data');
        $channelNameArr = explode('.', $channelName);
        $unitId = (int) $channelNameArr[1];

        if ($currentUserId['accountId'] !== $unitId) {
            return response()->json(['message' => 'Forbidden'], 403);
        }
    }

    $pusher = new Pusher(
        config('broadcasting.connections.pusher.key'),
        config('broadcasting.connections.pusher.secret'),
        config('broadcasting.connections.pusher.app_id'),
        [
            'cluster' => config('broadcasting.connections.pusher.options.cluster'),
            'useTLS' => true,
        ]
    );

    // Authenticate the private channel
    $authResponse = $pusher->authorizeChannel($channelName, $socketId);

    return response($authResponse, 200);
});

Route::post('/pusher/broadcasting/auth', function (Request $request)
{
    $channelName = $request->input('channel_name');
    $socketId = $request->input('socket_id');

    info(print_r([
        'requests' => $request->all(),
        'userData' => Session::get('api_user_data'),
        'innove_auth_api' => Session::get('innove_auth_api')
    ], true));

    if (strpos($channelName, 'private-unit.') === 0) {
        $currentUserId = Session::get('api_user_data');
        $unitId = (int) str_replace('private-unit.', '', $channelName);
        if ($currentUserId['accountId'] !== $unitId) {
            return response()->json(['message' => 'Forbidden!'], 403);
        }
    }

    $pusher = new Pusher(
        config('broadcasting.connections.pusher.key'),
        config('broadcasting.connections.pusher.secret'),
        config('broadcasting.connections.pusher.app_id'),
        [
            'cluster' => config('broadcasting.connections.pusher.options.cluster'),
            'useTLS' => true,
        ]
    );

    // Authenticate the private channel
    $authResponse = $pusher->authorizeChannel($channelName, $socketId);

    return response($authResponse, 200);
});

Route::middleware(['auth_api'])->group(function () {
    Route::controller(\App\Http\Controllers\DashboardController::class)->group(function()
    {
        Route::get('/dashboard', 'dashboard')->name('dashboard');
    });

});

Route::middleware(['auth_api', 'investor'])->group(function ()
{
    Route::controller(\App\Http\Controllers\InvestorController::class)->group(function()
    {
        Route::get('/trade-history', 'tradeHistory')->name('investor.trade-history');
        Route::get('/profit-report', 'profitReport')->name('investor.profit-report');
        Route::get('/funders', 'funders')->name('investor.funders');
    });
});

Route::middleware(['auth_api', 'admin'])->group(function () {

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
            Route::post('/individuals', 'uploadIndividuals')->name('individuals.store');
        });

        Route::controller(TradingCredentialsController::class)->group(function()
        {
            Route::get('/credential/list', 'getCredentials')->name('credential.list');
            Route::get('/credential/add', 'create')->name('credential.create');
            Route::get('/credential/{id}', 'edit')->name('credential.edit');

            Route::post('/credential/{id}', 'update')->name('credential.update');
            Route::delete('/credential/{id}', 'destroy')->name('credential.delete');
            Route::post('/credential', 'store')->name('credential.store');

            Route::get('/credential/funders/accounts', 'getFunderAccountCredentials')->name('credential.funders.accounts');
            Route::get('/credential/funders/accounts/add', 'createFunderAccountCredential')->name('credential.funders.accounts.add');
            Route::get('/credential/funders/accounts/{id}', 'editFunderAccountCredential')->name('credential.funders.accounts.edit');

            Route::patch('/credential/funders/accounts/{id}', 'updateFunderAccountCredential')->name('credential.funders.accounts.update');
            Route::delete('/credential/funders/accounts/{id}', 'deleteFunderAccountCredential')->name('credential.funders.accounts.delete');
            Route::post('/credential/funders/accounts/', 'storeFunderAccountCredential')->name('credential.funders.accounts.create');
        });
    });

    Route::prefix('trade/')->name('trade.')->group(function()
    {
       Route::controller(TradeController::class)->group(function()
       {
           Route::get('play', 'index')->name('play');
           Route::post('pair', 'pairAccounts')->name('pair');
           Route::delete('pair', 'clearPairing')->name('pair.clear');

           Route::post('initiate', 'initiateTrade')->name('initiate');

           Route::post('pair-manual', 'pairManual')->name('pair-manual');
           Route::delete('pair/{id}/remove', 'removePair')->name('remove-pair');
       });

        Route::controller(TradeReportController::class)->group(function()
        {
            Route::get('report','index')->name('report');
            Route::get('report/create','create')->name('report.create');
            Route::get('report/{id}', 'edit')->name('report.edit');
            Route::post('report/{id}', 'update')->name('report.update');
            Route::delete('report/{id}', 'destroy')->name('report.delete');
            Route::post('report','store')->name('report.store');

            Route::post('update-trade-report-settings', 'updateTradeSettings')->name('update-trade-report-settings');
        });
    });
});




require __DIR__.'/auth.php';
