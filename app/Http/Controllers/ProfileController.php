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

    public function showCertificates(): Response
    {
        $certificates = auth()->user()->certificates()
            ->with(['course', 'user'])
            ->orderBy('issued_at', 'desc')
            ->get()
            ->map(function ($certificate) {
                return [
                    'id' => $certificate->id,
                    'certificate_number' => $certificate->certificate_number,
                    'issued_at' => $certificate->issued_at->format('d.m.Y'),
                    'course_title' => $certificate->course->title,
                    'course_description' => $certificate->course->description,
                    'user_name' => $certificate->user->name,
                    'view_url' => route('certificates.show', $certificate->id),
                    'download_url' => route('certificates.show', $certificate->id),
                ];
            });

        return Inertia::render('Profile/UserCertificates', [
            'certificates' => $certificates,
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
