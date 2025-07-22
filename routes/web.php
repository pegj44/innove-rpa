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
    return redirect('dashboard/live-accounts');
});

Route::get('/dashboard', function () {
    return redirect('dashboard/live-accounts');
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
    Route::controller(\App\Http\Controllers\DashboardController::class)->prefix('dashboard/')->name('dashboard.')->group(function()
    {
        Route::get('live-accounts', 'dashboard')->name('live-accounts');
        Route::get('audition-accounts', 'auditionDashboard')->name('audition-accounts');
    });

});

Route::middleware(['auth_api', 'investor'])->group(function ()
{
    Route::post('/template', [\App\Http\Controllers\AjaxController::class, 'getHtmlTemplate'])->name('template');

    Route::controller(\App\Http\Controllers\InvestorController::class)->group(function()
    {
        Route::get('/trade-accounts', 'tradeAccounts')->name('investor.trade-accounts');
        Route::get('/trade-history', 'tradeHistory')->name('investor.trade-history');
        Route::get('/profit-report', 'profitReport')->name('investor.profit-report');
//        Route::get('/funders', 'funders')->name('investor.funders');

//        Route::get('accounts/users', 'userAccounts')->name('accounts.users');
        Route::get('accounts/funders', 'funderAccounts')->name('accounts.funders');
    });

    Route::controller(\App\Http\Controllers\UserSettingsController::class)->prefix('user/settings')->group(function()
    {
        Route::get('', 'getSettings')->name('user.settings');
        Route::post('', 'store')->name('user.settings.add');
        Route::put('update', 'update')->name('user.settings.update');
        Route::delete('{id}', 'destroy')->name('user.settings.delete');
    });
});

Route::middleware(['auth_api', 'admin'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::controller(\App\Http\Controllers\PayoutController::class)->group(function()
    {
        Route::get('trade/payouts', 'index')->name('trade.payouts');
        Route::get('trade/payouts/add', 'create')->name('trade.payouts.create');
        Route::get('trade/payout/{id}', 'edit')->name('trade.payout.edit');

        Route::post('trade/payout', 'store')->name('trade.payouts.store');
        Route::put('trade/payout/{id}', 'update')->name('trade.payout.update');
        Route::delete('trade/payout/{id}', 'destroy')->name('trade.payout.destroy');
    });

    Route::controller(TradingUnitController::class)->group(function()
    {
        Route::get('/trading-units/units', 'index')->name('trading-unit.units');
        Route::get('/trading-units/settings', 'settings')->name('trading-unit.settings');

        Route::post('/register-unit', 'store')->name('trading-unit.create');
        Route::get('/register-unit', function() {
            return redirect('dashboard/live-accounts');
        });

        Route::post('/trading-unit/{id}', 'update')->name('trading-unit.update');
        Route::get('/trading-unit/{id}', function() {
            return redirect('dashboard/live-accounts');
        });

        Route::delete('/trading-unit/{id}', 'destroy')->name('trading-unit.delete');

        Route::post('/trading-unit/settings/set-password', 'setUnitPassword')->name('trading-unit.settings.set-password');
        Route::get('/trading-unit/settings/set-password', function() {
            return redirect('dashboard/live-accounts');
        });

        Route::post('/trading-unit/settings/update-password', 'updateUnitPassword')->name('trading-unit.settings.update-password');
        Route::get('/trading-unit/settings/update-password', function() {
            return redirect('dashboard/live-accounts');
        });
    });

    Route::controller(FunderController::class)->group(function()
    {
        Route::get('/funder/list', 'index')->name('funders');
        Route::get('/funder/add', 'create')->name('funder.create');
        Route::get('/funders/packages', 'fundersPackages')->name('funders.packages');

        Route::get('/funder/packages/create', 'createFunderPackage')->name('funders.packages.create');
        Route::get('/funder/package/{id}', 'editFunderPackage')->name('funders.packages.edit');
        Route::post('/funder/packages/store', 'storeFunderPackage')->name('funders.packages.store');
        Route::post('/funder/package/{id}', 'updateFunderPackage')->name('funders.packages.update');
        Route::delete('/funder/package/{id}', 'deleteFunderPackage')->name('funders.packages.delete');

        Route::post('/funders/packages', 'storeFundersPackages')->name('funders.packages.store');
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

            Route::patch('/credential/funders/account/{id}', 'updateFunderAccountCredential')->name('credential.funders.accounts.update');
            Route::delete('/credential/funders/account/{id}', 'deleteFunderAccountCredential')->name('credential.funders.accounts.delete');
            Route::post('/credential/funders/account/', 'storeFunderAccountCredential')->name('credential.funders.accounts.create');
        });
    });

    Route::prefix('trade/')->name('trade.')->group(function()
    {
       Route::controller(TradeController::class)->group(function()
       {
           Route::get('history', 'getTradeHistoryView')->name('history');
           Route::get('history/add', 'createHistory')->name('history.create');
           Route::get('history/{id}', 'editHistory')->name('history.edit');
           Route::post('history', 'storeHistory')->name('history.store');
           Route::put('history/{id}', 'updateHistory')->name('history.update');
           Route::delete('history/{id}', 'destroyHistory')->name('history.destroy');


           Route::get('/remove-all-pairs', 'removeAllPairs');

           Route::get('play', 'index')->name('play');
           Route::post('pair', 'pairAccounts')->name('pair');
           Route::delete('pair', 'clearPairing')->name('pair.clear');

           Route::post('initiate', 'initiateTrade')->name('initiate');
           Route::post('initiate-v2', 'initiateTradeV2')->name('initiate-v2');
           Route::post('re-initialize', 'reInitializeTrade')->name('re-initialize');
           Route::post('start', 'startTrade')->name('start');

           Route::post('pair-manual', 'pairManual')->name('pair-manual');
           Route::delete('pair/{id}/remove', 'removePair')->name('remove-pair');

           Route::post('pair-units', 'getPairData')->name('pair-units');

           Route::post('magic-pair', 'magicPair')->name('magic-pair');

           Route::post('recover', 'recoverTrade')->name('recover');
       });

        Route::controller(TradeReportController::class)->group(function()
        {
            Route::get('reports', 'getReports')->name('reports');
            Route::get('report/latest', 'getLatestTrades')->name('report.latest');
            Route::get('report','index')->name('report');
            Route::get('report/create','create')->name('report.create');
            Route::get('report/{id}', 'edit')->name('report.edit');
            Route::post('report/{id}', 'update')->name('report.update');
            Route::delete('report/{id}', 'destroy')->name('report.delete');
            Route::post('report','store')->name('report.store');

            Route::post('update-trade-report-settings', 'updateTradeSettings')->name('update-trade-report-settings');

            Route::post('history/{id}/update-item/{itemId}', 'updateQueueReport')->name('history.update-item');
        });
    });
});


Route::get('/profile-images/{filename}', function ($filename) {
    $path = storage_path('profile/' . $filename);

    if (!file_exists($path)) {
        abort(404);
    }

    $file = file_get_contents($path);
    $type = mime_content_type($path);

    return response($file, 200)->header("Content-Type", $type);
});

Route::get('/test/trading-news', [\App\Http\Controllers\TestController::class, 'tradingNews']);

require __DIR__.'/auth.php';
