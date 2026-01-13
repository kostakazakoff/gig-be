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
            return redirect()->back()->withErrors(['user' => 'Потребителят не е намерен']);
        }

        return redirect()->back()->with('status', 'profile-updated');
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $newPassword = $request->input('password');

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Текущата парола е неправилна']);
        }

        auth()->user()->update([
            'password' => bcrypt($newPassword),
        ]);

        return redirect()->route('admin.profile.edit')->with('status', 'password-updated');
    }
}
