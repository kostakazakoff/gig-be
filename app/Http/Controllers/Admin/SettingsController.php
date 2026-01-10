<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\UpdatePasswordRequest;
use App\Http\Requests\Settings\UpdateProfileRequest;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    public function edit()
    {
        return view('admin.settings');
    }

    public function update(UpdateProfileRequest $request)
    {
        $profileData = $request->validated();

        auth()->user()->update([
            'name' => $profileData['name'],
            'email' => $profileData['email'],
        ]);

        return redirect()->back()->with('status', 'profile-updated');
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $newPassword = $request->input('password');

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return redirect()->back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        auth()->user()->update([
            'password' => bcrypt($newPassword),
        ]);

        return redirect()->route('admin.settings.edit')->with('status', 'password-updated');
    }
}