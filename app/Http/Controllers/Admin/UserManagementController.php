<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserManagementRequest;
use App\Models\admin\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Rules\Password;

class UserManagementController extends Controller
{

    public function index()
    {
        $users = User::where('is_admin', '0')->with('department')->get();
        $departments = Department::all();
        return view('admin.user.index', compact('users', 'departments'));
    }

    public function store(UserManagementRequest $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'department_id' => $request->department_id,
        ]);
        return redirect()->route('admin.user.index')->with('success', 'User Added Successfully');
    }

    public function update(UserManagementRequest $request, User $user)
    {
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'department_id' => $request->department_id,
        ]);
        return redirect()->route('admin.user.index')->with('success', 'User Updated Successfully');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.user.index')->with('success', 'User Deleted Successfully');
    }

    public function resetPassword(Request $request, User $user)
    {
        $request->validate([
            'password' => ['required','string', new Password,'confirmed'],
        ]);
        $user->update([
            'password' => Hash::make($request->password),
        ]);
        return redirect()->route('admin.user.index')->with('success', 'User Password Reset Successfully');
    }
}
