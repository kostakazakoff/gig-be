<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\UpdatePasswordRequest;
use App\Http\Requests\Settings\UpdateProfileRequest;

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
            $updater->update($request->user(), $profileData);
            return redirect()->back()->with('status', 'profile-updated');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Грешка при актуализиране на профила.']);
        }
    }

    public function updatePassword(UpdatePasswordRequest $request, UpdateUserPassword $updater)
    {
        $passwordData = $request->validated();

        try {
            $updater->update($request->user(), $passwordData);
            return redirect()->back()->with('status', 'password-updated');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Грешка при актуализиране на паролата.']);
        }
    }
}
