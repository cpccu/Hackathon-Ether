<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Make sure this is imported at the top


class AdminController extends Controller
{
    // Display Admin Dashboard with list of users
    public function index()
    {
        $users = User::all();
        return view('admin.dashboard', compact('users'));
    }

    // Promote a user to CR
    public function makeCr(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        // Update user role to 'cr'
        $user->role = 'cr';
        $user->save();

        return redirect()->back()->with('success', "Successfully assigned {$user->name} as CR for Batch {$user->batch_no}!");
    }

    // Remove CR role (demote to normal user)
    public function removeCr($id)
    {
        $user = User::findOrFail($id);
        
        $user->role = 'user';
        $user->save();

        return redirect()->back()->with('success', "Removed CR role from {$user->name}.");
    }



// Add this new method inside AdminController:
public function storeUser(Request $request)
{
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
        'mobile_number' => ['required', 'string', 'max:20'],
        'student_id' => ['required', 'string', 'max:50', 'unique:users'],
        'department' => ['required', 'string', 'max:100'],
        'batch_no' => ['required', 'string', 'max:50'],
        'role' => ['required', 'in:user,cr'],
        'profile_pic' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        'password' => ['required', 'string', 'min:8'],
    ]);

    $profilePicPath = null;
    if ($request->hasFile('profile_pic')) {
        $profilePicPath = $request->file('profile_pic')->store('profile_pics', 'public');
    }

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'mobile_number' => $request->mobile_number,
        'student_id' => $request->student_id,
        'department' => $request->department,
        'batch_no' => $request->batch_no,
        'role' => $request->role,
        'profile_pic' => $profilePicPath,
        'password' => Hash::make($request->password),
    ]);

    return redirect()->back()->with('success', 'New account successfully created!');
}
}