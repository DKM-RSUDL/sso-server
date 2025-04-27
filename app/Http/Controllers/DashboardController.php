<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $tokenExpiresAt = request()->cookie('sso_tok_expired');
        $loginExpiresAt = date('M d, Y H:i', $tokenExpiresAt);
        return view('dashboard', compact('loginExpiresAt'));
    }
}
