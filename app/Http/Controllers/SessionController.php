<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function session(Request $request)
    {
        return [
            'isLoggedIn' => $request->user() !== null,
            'user' => $request->user(),
        ];
    }
}
