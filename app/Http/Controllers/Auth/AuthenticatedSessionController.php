<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $response = Http::post(env('RPA_API_URL'). 'login', [
            'email' => $request->email,
            'password' => $request->password
        ]);

        $responseBody = json_decode($response->body(), true);

//        info(print_r([
//            'authtest' => [
//                '$responseBody' => $responseBody,
//                '$request' => [$request->email, $request->password],
//                'env' => env('RPA_API_URL'),
//                '$response' => $response
//            ]
//        ], true));

        if ($response->successful() && !empty($responseBody['token'])) {

            Session::put('innove_auth_api', $responseBody['token']);
            Session::put('api_user_data', [
                'name' => $responseBody['name'],
                'email' => $responseBody['email'],
                'userId' => $responseBody['userId'],
                'accountId' => $responseBody['accountId'],
                'permissions' => $responseBody['permissions'],
                'isOwner' => $responseBody['isOwner'],
                'profile' => $responseBody['profile']
            ]);

            return redirect()->route('dashboard.live-accounts');
        }

        return redirect()->route('login')
            ->withErrors([
                'errors' => $responseBody['errors']
            ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        Session::flush();
        Session::invalidate();

        return redirect()->route('dashboard.live-accounts');
    }
}
