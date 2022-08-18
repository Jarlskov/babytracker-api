<?php

namespace App\Http\Controllers;

use App\Models\ParentInvite;
use Illuminate\Http\Request;

class ParentInviteController extends Controller
{
    public function accept(Request $request, ParentInvite $invite)
    {
        return $invite->baby->parents()->save($request->user());
    }

    public function decline(Request $request, ParentInvite $invite)
    {
        // TODO: Decline invite
    }
}
