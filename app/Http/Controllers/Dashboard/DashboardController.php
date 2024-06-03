<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Home');
    }

    public function users()
    {
        $users = User::all();
        return Inertia::render('Admin/User/Index', ['users' => $users]);
    }
}
