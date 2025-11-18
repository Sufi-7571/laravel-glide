<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserController extends Controller
{

public function index(Request $request)
{
    $users = User::latest()->paginate(8); 
    
    if ($request->ajax()) {
        return response()->json([
            'users' => view('users.partials.user-cards', compact('users'))->render(),
            'has_more' => $users->hasMorePages()
        ]);
    }
    
    return view('users.index', compact('users'));
}

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'bio' => 'nullable|string|max:500',
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB max
            'password' => 'required|string|min:8',
        ]);

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $filename = Str::uuid() . '.' . $avatar->getClientOriginalExtension();

            // Store in storage/app/public/uploads/avatars/
            $path = $avatar->storeAs('uploads/avatars', $filename, 'public');

            // Save just the relative path (avatars/filename.ext)
            $validated['avatar'] = 'avatars/' . $filename;
        }

        $validated['password'] = bcrypt($validated['password']);

        User::create($validated);

        return redirect()->route('users.index')
            ->with('success', 'User created successfully!');
    }


    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function destroy(User $user)
    {
        // Delete avatar file
        if ($user->avatar) {
            Storage::disk('public')->delete('uploads/' . $user->avatar);
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully!');
    }
}
