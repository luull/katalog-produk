<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        if (empty(session('backend-session'))) {
            return redirect('/login/backend');
        }

        return view('backend.pages.dashboard');
    }
}
