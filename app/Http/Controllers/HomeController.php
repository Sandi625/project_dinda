<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
public function index()
{
    $beritaTerbaru = Berita::where('status', 1)
        ->latest()
        ->take(6)
        ->get();

    return view('index', compact('beritaTerbaru'));
}
}
