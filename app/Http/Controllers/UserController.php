<?php

namespace App\Http\Controllers;

use App\Models\ParentInvite;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function invites(Request $request)
    {
        $user = $request->user();

        return ParentInvite::with('baby')->where('email', $user->email)->get();
    }
}
