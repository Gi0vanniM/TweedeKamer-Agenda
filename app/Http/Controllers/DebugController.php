<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class DebugController extends Controller
{
    public function debug(Request $request)
    {
        return Inertia::render('dashboard');
    }
}
