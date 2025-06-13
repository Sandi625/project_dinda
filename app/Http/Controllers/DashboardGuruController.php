<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardGuruController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:guru']);
    }

    public function index()
    {
        return view('dashboard.guru');
    }
}
