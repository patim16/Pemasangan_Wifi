<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function superAdminDashboard() {
        return view('superadmin.dashboard');
    }
}
