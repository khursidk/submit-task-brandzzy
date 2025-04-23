<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class SuperAdminController extends Controller
{
    public function index()
    {
        return view('super-admin.dashboard');
    }

    public function addAdmin(Request $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

        return redirect()->back()->with('success', 'Admin added successfully');
    }

    public function addSuperAdmin(Request $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'super-admin',
        ]);

        return redirect()->back()->with('success', 'Super Admin added successfully');
    }
}
