<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Resources\CourseResource;
use App\Http\Resources\TestResource;
use App\Models\Course;
use App\Models\Test;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    public function showTests(): Response
    {
        $tests = Test::whereHas('course.users', function ($query) {
            $query->where('users.id', auth()->id());
        })
            ->with('course')
            ->get();

        return Inertia::render('Profile/UsersTests', [
            'tests' => TestResource::collection($tests),
        ]);
    }

    public function showCourses(): Response
    {
        $courses = Course::whereHas('users', function ($query) {
            $query->where('users.id', auth()->id());
        })
            ->with('users')
            ->get();

        return Inertia::render('Profile/UserCourses', [
            'courses' => CourseResource::collection($courses),
        ]);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
