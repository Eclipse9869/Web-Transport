<?php

namespace App\Http\Controllers\Owner;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class StaffController extends Controller
{
    //
    public function index()
    {
        // if (Auth::check()) {
        $users = User::where('role', 'staff')->get();
        return view('owner.data-staff', compact('users'));   
        // }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            // 'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        $users = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => 'Staff',
            'password' => Hash::make($request->password),
        ]);
    }

    public function show($id)
    {
        $users = User::findOrFail($id);
        return response()->json($users);
    }


    public function update(Request $request, $id)
    {
        $users = User::findOrFail($id);
        $request->validate([
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $updateData = [
            'name' => $request->name,
            'phone' => $request->phone,
        ];
    
        // Jika password diisi, update password
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }
        return response()->json($users);
    }

    public function destroy($id)
    {
        $users = User::findOrFail($id);
        $users->delete();
        return response()->json(['success' => 'Staff Account deleted successfully']);
    }
}
