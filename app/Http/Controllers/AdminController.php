<?php

namespace App\Http\Controllers;

use App\Models\ParliamentMember;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('admin/index', [
            'users' => User::all(),
            'parliamentMembers' => ParliamentMember::all(),
        ]);
    }
}
