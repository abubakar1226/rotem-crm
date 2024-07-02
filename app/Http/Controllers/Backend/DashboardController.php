<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index() {
        $usersCount = User::where('user_type', 'user')->count();
        return view('backend.dashboard', compact('usersCount'));
    }
}
