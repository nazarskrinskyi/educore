<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <GuestLayout>
        <Head title="Choose Your Role" />

        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-900">Welcome to EduCore</h2>
            <p class="mt-3 text-lg text-gray-600">Choose how you'd like to get started</p>
        </div>

        <div class="grid md:grid-cols-2 gap-6">
            <!-- Student Card -->
            <div class="bg-white border-2 border-gray-200 rounded-lg p-8 hover:border-indigo-500 transition-colors">
                <div class="text-center">
                    <div class="mx-auto h-16 w-16 bg-indigo-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="h-8 w-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-900 mb-3">I'm a Student</h3>
                    <p class="text-gray-600 mb-6">
                        Explore courses, learn new skills, and advance your career with our comprehensive learning platform.
                    </p>
                    <div class="space-y-3">
                        <Link :href="route('student.register')" class="block">
                            <PrimaryButton class="w-full justify-center">
                                Register as Student
                            </PrimaryButton>
                        </Link>
                        <Link :href="route('student.login')" class="block text-sm text-indigo-600 hover:text-indigo-800 underline">
                            Already have a student account? Login
                        </Link>
                    </div>
                </div>
            </div>

            <!-- Instructor Card -->
            <div class="bg-white border-2 border-gray-200 rounded-lg p-8 hover:border-green-500 transition-colors">
                <div class="text-center">
                    <div class="mx-auto h-16 w-16 bg-green-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-900 mb-3">I'm an Instructor</h3>
                    <p class="text-gray-600 mb-6">
                        Share your expertise, create courses, and inspire students around the world with your knowledge.
                    </p>
                    <div class="space-y-3">
                        <Link :href="route('instructor.register')" class="block">
                            <PrimaryButton class="w-full justify-center bg-green-600 hover:bg-green-700 focus:bg-green-700 active:bg-green-900">
                                Register as Instructor
                            </PrimaryButton>
                        </Link>
                        <Link :href="route('instructor.login')" class="block text-sm text-green-600 hover:text-green-800 underline">
                            Already have an instructor account? Login
                        </Link>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8 text-center text-sm text-gray-600">
            <p>Not sure which one to choose? You can always create both accounts with different email addresses.</p>
        </div>
    </GuestLayout>
</template>
