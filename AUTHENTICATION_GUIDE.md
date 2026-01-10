# Authentication System Documentation

## Overview

This application now has a **separate authentication system** for **Students** and **Instructors**. Each user type has dedicated registration and login flows with role-based access control.

## User Roles

The system supports three user roles (defined in `app/Enums/RoleEnum.php`):

- **STUDENT**: Regular users who enroll in courses
- **INSTRUCTOR**: Users who create and manage courses
- **ADMIN**: System administrators with full access

## Authentication Routes

### Student Routes

- **Registration**: `/student/register` (GET/POST)
  - Route name: `student.register`
  - Controller: `App\Http\Controllers\Auth\Student\RegisteredStudentController`
  - View: `resources/js/Pages/Auth/Student/Register.vue`

- **Login**: `/student/login` (GET/POST)
  - Route name: `student.login`
  - Controller: `App\Http\Controllers\Auth\Student\AuthenticatedStudentController`
  - View: `resources/js/Pages/Auth/Student/Login.vue`

### Instructor Routes

- **Registration**: `/instructor/register` (GET/POST)
  - Route name: `instructor.register`
  - Controller: `App\Http\Controllers\Auth\Instructor\RegisteredInstructorController`
  - View: `resources/js/Pages/Auth/Instructor/Register.vue`

- **Login**: `/instructor/login` (GET/POST)
  - Route name: `instructor.login`
  - Controller: `App\Http\Controllers\Auth\Instructor\AuthenticatedInstructorController`
  - View: `resources/js/Pages/Auth/Instructor/Login.vue`

### Role Selection Page

- **Choose Role**: `/auth/choose-role`
  - Route name: `auth.choose-role`
  - View: `resources/js/Pages/Auth/ChooseRole.vue`
  - A landing page where users can choose to register/login as Student or Instructor

### Legacy Routes (Backward Compatibility)

- `/register` → Redirects to `/student/register`
- `/login` → Redirects to `/student/login`

## Controllers

### Student Controllers

1. **RegisteredStudentController** (`app/Http/Controllers/Auth/Student/RegisteredStudentController.php`)
   - Handles student registration
   - Automatically sets role to `STUDENT`
   - Redirects to dashboard after registration

2. **AuthenticatedStudentController** (`app/Http/Controllers/Auth/Student/AuthenticatedStudentController.php`)
   - Handles student login
   - Uses `StudentLoginRequest` for validation
   - Verifies user has student role

### Instructor Controllers

1. **RegisteredInstructorController** (`app/Http/Controllers/Auth/Instructor/RegisteredInstructorController.php`)
   - Handles instructor registration
   - Automatically sets role to `INSTRUCTOR`
   - Redirects to admin panel after registration

2. **AuthenticatedInstructorController** (`app/Http/Controllers/Auth/Instructor/AuthenticatedInstructorController.php`)
   - Handles instructor login
   - Uses `InstructorLoginRequest` for validation
   - Verifies user has instructor or admin role

## Login Request Classes

### StudentLoginRequest (`app/Http/Requests/Auth/StudentLoginRequest.php`)

- Validates credentials
- Ensures user has `STUDENT` role
- Logs out and shows error if user tries to login with instructor/admin account
- Rate limiting: 5 attempts per email/IP combination

### InstructorLoginRequest (`app/Http/Requests/Auth/InstructorLoginRequest.php`)

- Validates credentials
- Ensures user has `INSTRUCTOR` or `ADMIN` role
- Logs out and shows error if user tries to login with student account
- Rate limiting: 5 attempts per email/IP combination

## Middleware

### RedirectIfAuthenticated (`app/Http/Middleware/RedirectIfAuthenticated.php`)

- Redirects authenticated users based on their role:
  - **ADMIN/INSTRUCTOR** → `/admin` (admin panel)
  - **STUDENT** → `/dashboard`

### EnsureUserIsStudent (`app/Http/Middleware/EnsureUserIsStudent.php`)

- Protects routes that should only be accessible to students
- Usage: `->middleware('student')`
- Redirects to student login if not authenticated
- Returns 403 error if user is not a student

### EnsureUserIsInstructor (`app/Http/Middleware/EnsureUserIsInstructor.php`)

- Protects routes that should only be accessible to instructors
- Usage: `->middleware('instructor')`
- Redirects to instructor login if not authenticated
- Returns 403 error if user is not an instructor or admin

## Google OAuth Integration

The Google OAuth controller (`app/Http/Controllers/Auth/GoogleAuthController.php`) has been updated to:

1. **Existing Users**: Redirect based on their role
   - Instructors/Admins → Admin panel
   - Students → Dashboard

2. **New Users**: Default to `STUDENT` role and redirect to dashboard

## Database Structure

The `users` table includes a `role` column:

```php
$table->string('role')->default('student');
```

Roles are stored as strings and cast to `RoleEnum` in the User model.

## User Model Methods

The `User` model (`app/Models/User.php`) includes helper methods:

```php
$user->isAdmin();      // Returns true if user is admin
$user->isInstructor(); // Returns true if user is instructor
$user->isStudent();    // Returns true if user is student
```

## Frontend Views

All authentication views are built with Vue 3 and Inertia.js:

### Student Views
- `resources/js/Pages/Auth/Student/Register.vue`
- `resources/js/Pages/Auth/Student/Login.vue`

### Instructor Views
- `resources/js/Pages/Auth/Instructor/Register.vue`
- `resources/js/Pages/Auth/Instructor/Login.vue`

### Role Selection
- `resources/js/Pages/Auth/ChooseRole.vue`

Each view includes:
- Form validation
- Error handling
- Links to switch between student/instructor flows
- Google OAuth integration
- Responsive design

## Usage Examples

### Protecting Routes for Students Only

```php
Route::middleware(['auth', 'student'])->group(function () {
    Route::get('/my-courses', [StudentCourseController::class, 'index']);
});
```

### Protecting Routes for Instructors Only

```php
Route::middleware(['auth', 'instructor'])->group(function () {
    Route::get('/my-teaching', [InstructorCourseController::class, 'index']);
});
```

### Checking User Role in Controllers

```php
if (auth()->user()->isStudent()) {
    // Student-specific logic
}

if (auth()->user()->isInstructor()) {
    // Instructor-specific logic
}

if (auth()->user()->isAdmin()) {
    // Admin-specific logic
}
```

### Checking User Role in Blade/Vue

```php
@if(auth()->user()->isStudent())
    <!-- Student content -->
@endif
```

```vue
<div v-if="$page.props.auth.user.role === 'student'">
    <!-- Student content -->
</div>
```

## Security Features

1. **Role Validation**: Login requests validate that users are logging in through the correct portal
2. **Rate Limiting**: 5 login attempts per email/IP combination
3. **Session Regeneration**: Sessions are regenerated after successful login
4. **CSRF Protection**: All forms are protected with CSRF tokens
5. **Password Hashing**: Passwords are hashed using bcrypt
6. **Email Verification**: Users receive email verification notifications

## Testing the System

### Register as Student
1. Visit `/student/register` or `/auth/choose-role`
2. Fill in the registration form
3. Submit and verify you're redirected to the dashboard
4. Check database: `role` should be `student`

### Register as Instructor
1. Visit `/instructor/register` or `/auth/choose-role`
2. Fill in the registration form
3. Submit and verify you're redirected to the admin panel
4. Check database: `role` should be `instructor`

### Test Role Separation
1. Register as a student
2. Try to login at `/instructor/login` with student credentials
3. Verify you get an error message
4. Login at `/student/login` successfully

## Migration Notes

If you have existing users in the database:

1. All existing users have a `role` field (default: `student`)
2. Update instructor/admin users manually:
   ```sql
   UPDATE users SET role = 'instructor' WHERE email = 'instructor@example.com';
   UPDATE users SET role = 'admin' WHERE email = 'admin@admin.com';
   ```

## Future Enhancements

Potential improvements to consider:

1. **Instructor Approval System**: Require admin approval for new instructor registrations
2. **Role Switching**: Allow users to have multiple roles (e.g., both student and instructor)
3. **Two-Factor Authentication**: Add 2FA for enhanced security
4. **Social Login**: Add more OAuth providers (Facebook, GitHub, etc.)
5. **Instructor Profiles**: Extended profile fields for instructors (bio, expertise, etc.)

## Troubleshooting

### Issue: "These credentials do not match our records"
- Verify you're using the correct login portal (student vs instructor)
- Check the user's role in the database

### Issue: 403 Forbidden Error
- Verify the user has the correct role for the route
- Check middleware configuration

### Issue: Redirected to wrong dashboard
- Check `RedirectIfAuthenticated` middleware
- Verify user role in database

## Support

For questions or issues, please refer to:
- Laravel Documentation: https://laravel.com/docs
- Inertia.js Documentation: https://inertiajs.com
- Project Repository: [Your repository URL]
