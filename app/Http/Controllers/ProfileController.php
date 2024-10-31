<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show($username)
    {
        $user = User::where('username', $username)->firstOrFail();
        $followersCount = $user->followers()->count();
        $followingCount = $user->following()->count();
        return view('profiles.show', compact('user', 'followersCount', 'followingCount'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profiles.edit', compact('user'));
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = Auth::user();
        $data = $request->validated();

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::delete($user->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars');
        }

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        return redirect()->route('profile.show', $user->username)->with('success', 'Profile updated successfully.');
    }

    public function follow($username)
    {
        $userToFollow = User::where('username', $username)->firstOrFail();
        Auth::user()->following()->attach($userToFollow);
        return back()->with('success', "You are now following {$userToFollow->name}.");
    }

    public function unfollow($username)
    {
        $userToUnfollow = User::where('username', $username)->firstOrFail();
        Auth::user()->following()->detach($userToUnfollow);
        return back()->with('success', "You have unfollowed {$userToUnfollow->name}.");
    }
}
?>