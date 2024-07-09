<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserTokenController extends Controller
{
    public function generateToken()
    {
        $user = auth()->user();

        return $user->createToken('innove-api')->plainTextToken;
    }
}
