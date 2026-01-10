<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class GoogleAuthController extends Controller
{
    /**
     * Redirect the user to Google’s OAuth page.
     */
    public function redirect(): RedirectResponse
    {
        // Store the intended role in session if provided
        if (request()->has('role')) {
            session(['oauth_intended_role' => request()->get('role')]);
        }

        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle the callback from Google.
     * @throws Throwable
     */
    public function callback(): RedirectResponse
    {
        $user = Socialite::driver('google')->user();

        $existingUser = User::where('email', $user->email)->first();

        if ($existingUser) {
            Auth::login($existingUser);

            // Redirect based on user role
            if ($existingUser->role === RoleEnum::INSTRUCTOR || $existingUser->role === RoleEnum::ADMIN) {
                return redirect()->route('admin.index');
            }

            return redirect()->route('dashboard');
        } else {
            // Get the intended role from session, default to student
            $intendedRole = session('oauth_intended_role', 'student');
            $role = $intendedRole === 'instructor' ? RoleEnum::INSTRUCTOR : RoleEnum::STUDENT;

            // Clear the session
            session()->forget('oauth_intended_role');

            $newUser = User::updateOrCreate([
                'email' => $user->email
            ], [
                'name' => $user->name,
                'password' => bcrypt(Str::random()),
                'email_verified_at' => now(),
                'role' => $role->value,
            ]);
            Auth::login($newUser);

            // Redirect based on role
            if ($role === RoleEnum::INSTRUCTOR) {
                return redirect()->route('admin.index');
            }

            return redirect()->route('dashboard');
        }
    }
}
