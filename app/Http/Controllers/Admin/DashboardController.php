<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::user()->is_admin) {
            return redirect()->route('home')->with('error', 'Unauthorized access.');
        }

        return view('admin.dashboard');
    }
}
