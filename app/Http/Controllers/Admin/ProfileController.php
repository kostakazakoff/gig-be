<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\UpdatePasswordRequest;
use App\Http\Requests\Settings\UpdateProfileRequest;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('admin.profile');
    }


    public function update(UpdateProfileRequest $request)
    {
        $profileData = $request->validated();

        $user = auth()->user();
        if ($user) {
            $user->update([
                'name' => $profileData['name'],
                'email' => $profileData['email'],
            ]);
        } else {
            return redirect()->back()->withErrors(['user' => __('messages.user_not_found')]);
        }

        return redirect()->back()->with('status', 'profile-updated');
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $newPassword = $request->input('password');

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return redirect()->back()->withErrors(['current_password' => __('messages.password_incorrect')]);
        }

        if ($request->current_password === $newPassword) {
            return redirect()->back()->withErrors(['password' => __('messages.new_password_must_be_different')]);
        }
        
        if ($newPassword !== $request->password_confirmation) {
            return redirect()->back()->withErrors(['password_confirmation' => __('messages.password_confirmation_must_match')]);
        }

        auth()->user()->update([
            'password' => bcrypt($newPassword),
        ]);

        return redirect()->route('admin.profile.edit')->with('status', 'password-updated');
    }
}
