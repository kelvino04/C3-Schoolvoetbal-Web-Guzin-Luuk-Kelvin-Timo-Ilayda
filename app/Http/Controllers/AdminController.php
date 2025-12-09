<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard with all users.
     */
    public function index()
    {
        $users = User::all(); // Get all users
        return view('admin.index', compact('users'));
    }

    /**
     * Update a user's role.
     */
    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:admin,user'
        ]);

        $user->role = $request->role;
        $user->save();

        return back()->with('success', 'User role updated successfully.');
    }
}

