<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardKepsekController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:kepala_sekolah']);
    }

    public function index()
    {
        return view('dashboard.kepsek');
    }
}
