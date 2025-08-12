<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LandingpageController extends Controller
{
    public function index()
    {
        // Jika pengguna sudah login, alihkan ke dashboard
        if (Auth::check()) {
            return redirect()->route('dashboard.index');
        }

        // Jika belum login, tampilkan halaman welcome
        return view('welcome');
    }
}
