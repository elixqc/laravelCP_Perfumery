<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class UserAccountController extends Controller
{
    public function show()
    {
        return view('user.account');
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'username' => [
                'required',
                'string',
                'min:3',
                'max:50',
                'alpha_dash',                                          // only letters, numbers, - and _
                "unique:users,username,{$user->user_id},user_id",     // unique but ignore own record
            ],
            'full_name' => [
                'required',
                'string',
                'min:2',
                'max:100',
                'regex:/^[\pL\s\'\-\.]+$/u',                          // letters, spaces, apostrophes, hyphens, dots
            ],
            'contact_number' => [
                'nullable',
                'string',
                'max:20',
                'regex:/^[0-9\+\-\s\(\)]+$/',                         // digits, +, -, spaces, parentheses only
            ],
            'address' => [
                'nullable',
                'string',
                'min:5',
                'max:500',
            ],
            'profile_picture' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',                                            // 2MB max
            ],
        ], [
            'username.required'      => 'Username is required.',
            'username.min'           => 'Username must be at least 3 characters.',
            'username.max'           => 'Username cannot exceed 50 characters.',
            'username.alpha_dash'    => 'Username may only contain letters, numbers, hyphens, and underscores.',
            'username.unique'        => 'This username is already taken.',
            'full_name.required'     => 'Full name is required.',
            'full_name.min'          => 'Full name must be at least 2 characters.',
            'full_name.max'          => 'Full name cannot exceed 100 characters.',
            'full_name.regex'        => 'Full name may only contain letters, spaces, apostrophes, hyphens, and dots.',
            'contact_number.max'     => 'Contact number cannot exceed 20 characters.',
            'contact_number.regex'   => 'Contact number may only contain digits, +, -, spaces, and parentheses.',
            'address.min'            => 'Address must be at least 5 characters.',
            'address.max'            => 'Address cannot exceed 500 characters.',
            'profile_picture.image'  => 'Profile picture must be a valid image.',
            'profile_picture.mimes'  => 'Profile picture must be JPG, PNG, or WEBP.',
            'profile_picture.max'    => 'Profile picture must not exceed 2MB.',
        ]);

        $user->username       = $request->username;
        $user->full_name      = $request->full_name;
        $user->contact_number = $request->contact_number;
        $user->address        = $request->address;

        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            $user->profile_picture = $request->file('profile_picture')->store('profile_pictures', 'public');
        }

        $user->save();

        return back()->with('success', 'Account updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'current_password' => [
                'required',
            ],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers(),
            ],
        ], [
            'current_password.required' => 'Current password is required.',
            'password.required'         => 'New password is required.',
            'password.confirmed'        => 'Passwords do not match.',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Current password is incorrect.',
            ]);
        }

        // Prevent reusing the same password
        if (Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'New password must be different from your current password.',
            ]);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password changed successfully.');
    }
}