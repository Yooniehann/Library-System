<?php

namespace App\Http\Controllers\Kid;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class KidProfileController extends Controller
{
    /**
     * Show the profile edit form.
     */
    public function edit()
    {
        $user = Auth::user(); // Get the currently logged-in user
        return view('dashboard.kid.kidprofile', compact('user'));
    }

    /**
     * Update the user's profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validate input
        $request->validate([
            'fullname' => 'required|string|max:255',
            'password' => 'nullable|string|min:6|confirmed', // password confirmation must match
        ]);

        // Update fullname
        $user->fullname = $request->fullname;

        // Update password only if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Save changes
        $user->save();

        return back()->with('success', 'Profile updated successfully!');
    }
}
