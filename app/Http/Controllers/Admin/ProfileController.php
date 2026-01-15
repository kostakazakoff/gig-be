<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\UpdatePasswordRequest;
use App\Http\Requests\Settings\UpdateProfileRequest;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // TODO: Use Action Classes for handling profile and password updates
    public function edit()
    {
        return view('auth.profile');
    }

    public function update(UpdateProfileRequest $request, UpdateUserProfileInformation $updater)
    {
        $profileData = $request->validated();

        try {
            $updater->update(auth()->user(), $profileData);
            return redirect()->back()->with('status', 'profile-updated');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Грешка при актуализиране на профила.']);
        }
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $newPassword = $request->input('password');

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return redirect()->back()->withErrors(['current_password' => __('auth.password')]);
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

        return redirect()->route('auth.edit')->with('status', 'password-updated');
    }
}
