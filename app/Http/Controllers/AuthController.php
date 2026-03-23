<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'password.required' => 'Password is required.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'is_active' => true])) {
            $user = Auth::user();
            $userId = $user->user_id;

            $request->session()->regenerate();

            // Merge guest cart from session to database
            $this->mergeGuestCartToUser($userId, $request);

            if (!$user->hasVerifiedEmail()) {
                return redirect()->route('verification.notice')
                    ->with('warning', 'Please verify your email address before continuing.');
            }

            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('orders.index');
        }

        return back()->withErrors(['email' => 'Invalid credentials or account is inactive.'])->withInput();
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => [
                'required',
                'string',
                'min:3',
                'max:50',
                'alpha_dash',                   // letters, numbers, hyphens, underscores only
                'unique:users,username',
            ],
            'full_name' => [
                'required',
                'string',
                'min:2',
                'max:100',
                'regex:/^[\pL\s\'\-\.]+$/u',    // letters, spaces, apostrophes, hyphens, dots
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers(),
            ],
            'contact_number' => [
                'nullable',
                'string',
                'max:20',
                'regex:/^[0-9\+\-\s\(\)]+$/',  // digits, +, -, spaces, parentheses only
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
                'max:2048',
            ],
        ], [
            'username.required' => 'Username is required.',
            'username.min' => 'Username must be at least 3 characters.',
            'username.max' => 'Username cannot exceed 50 characters.',
            'username.alpha_dash' => 'Username may only contain letters, numbers, hyphens, and underscores.',
            'username.unique' => 'This username is already taken.',
            'full_name.required' => 'Full name is required.',
            'full_name.min' => 'Full name must be at least 2 characters.',
            'full_name.max' => 'Full name cannot exceed 100 characters.',
            'full_name.regex' => 'Full name may only contain letters, spaces, apostrophes, hyphens, and dots.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'An account with this email already exists.',
            'password.required' => 'Password is required.',
            'password.confirmed' => 'Passwords do not match.',
            'contact_number.max' => 'Contact number cannot exceed 20 characters.',
            'contact_number.regex' => 'Contact number may only contain digits, +, -, spaces, and parentheses.',
            'address.min' => 'Address must be at least 5 characters.',
            'address.max' => 'Address cannot exceed 500 characters.',
            'profile_picture.image' => 'Profile picture must be a valid image.',
            'profile_picture.mimes' => 'Profile picture must be JPG, PNG, or WEBP.',
            'profile_picture.max' => 'Profile picture must not exceed 2MB.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $profilePicturePath = null;
        if ($request->hasFile('profile_picture')) {
            $profilePicturePath = $request->file('profile_picture')->store('profile_pictures', 'public');
        }

        $user = User::create([
            'username' => $request->username,
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'customer',
            'contact_number' => $request->contact_number,
            'address' => $request->address,
            'is_active' => true,
            'profile_picture' => $profilePicturePath,
        ]);

        Auth::login($user);

        $user->sendEmailVerificationNotification();

        return redirect()->route('verification.notice');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Merge guest cart from session to authenticated user's database cart.
     */
    private function mergeGuestCartToUser($userId, $request)
    {
        $sessionCart = $request->session()->get('guest_cart', []);

        if (empty($sessionCart)) {
            return; // No guest cart to merge
        }

        foreach ($sessionCart as $productId => $quantity) {
            $existingCartItem = Cart::where('user_id', $userId)
                ->where('product_id', $productId)
                ->first();

            if ($existingCartItem) {
                // Add guest cart quantity to existing user cart quantity
                $existingCartItem->quantity += $quantity;
                $existingCartItem->save();
            } else {
                // Create new cart item for user
                Cart::create([
                    'user_id' => $userId,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                ]);
            }
        }

        // Clear the guest cart from session
        $request->session()->forget('guest_cart');
    }
}
