<script setup>
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps({
    canLogin: {
        type: Boolean,
        default: true,
    },
    canRegister: {
        type: Boolean,
        default: true,
    },
    laravelVersion: {
        type: String,
        required: false,
        default: '',
    },
    phpVersion: {
        type: String,
        required: false,
        default: '',
    },
    pageConfig: {
        type: Object,
        default: () => ({}),
    },
});

const hero = computed(() => props.pageConfig.hero || {
    title: 'Welcome to EduCore',
    subtitle: 'Transform Your Educational Institution',
    description: 'The complete educational management system for modern learning institutions.',
    cta_primary: 'Get Started',
    cta_secondary: 'Learn More',
});

const features = computed(() => props.pageConfig.features || {
    title: 'Why Choose EduCore?',
    subtitle: 'Comprehensive Features for Modern Education',
    features: [],
});

const stats = computed(() => props.pageConfig.stats || {
    title: 'Trusted by Institutions Worldwide',
    stats: [],
});
</script>

<template>
    <Head title="Welcome to EduCore" />
    <div class="bg-gradient-to-br from-indigo-50 via-white to-purple-50 min-h-screen">
        <!-- Header -->
        <header class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-gray-200 shadow-sm">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-20 items-center justify-between">
                    <!-- Logo -->
                    <Link :href="route('dashboard')" class="flex items-center">
                        <ApplicationLogo class="h-12 w-auto" />
                    </Link>

                    <!-- Desktop Navigation -->
                    <nav class="hidden md:flex items-center space-x-8">
                        <Link :href="route('dashboard')" class="text-gray-700 hover:text-purple-600 font-medium transition-colors">
                            Home
                        </Link>
                        <Link :href="route('about')" class="text-gray-700 hover:text-purple-600 font-medium transition-colors">
                            About
                        </Link>
                        <Link :href="route('courses.index')" class="text-gray-700 hover:text-purple-600 font-medium transition-colors">
                            Courses
                        </Link>
                        <Link :href="route('contact')" class="text-gray-700 hover:text-purple-600 font-medium transition-colors">
                            Contact
                        </Link>
                    </nav>

                    <!-- Auth Buttons -->
                    <div v-if="canLogin" class="flex items-center space-x-4">
                        <Link
                            v-if="$page.props.auth.user"
                            :href="route('dashboard')"
                            class="rounded-lg px-6 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 shadow-md hover:shadow-lg transition-all duration-300"
                        >
                            Dashboard
                        </Link>

                        <template v-else>
                            <!-- Login Dropdown -->
                            <div class="relative group">
                                <button class="hidden sm:block rounded-lg px-6 py-2.5 text-sm font-semibold text-gray-700 hover:text-purple-600 transition-colors">
                                    Log in
                                </button>
                                <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                                    <Link
                                        :href="route('student.login')"
                                        class="block px-4 py-3 text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-600 rounded-t-lg transition-colors"
                                    >
                                        Student Login
                                    </Link>
                                    <Link
                                        :href="route('instructor.login')"
                                        class="block px-4 py-3 text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-600 rounded-b-lg transition-colors"
                                    >
                                        Instructor Login
                                    </Link>
                                </div>
                            </div>

                            <!-- Register Dropdown -->
                            <div v-if="canRegister" class="relative group">
                                <button class="rounded-lg px-6 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 shadow-md hover:shadow-lg transition-all duration-300">
                                    Get Started
                                </button>
                                <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                                    <Link
                                        :href="route('student.register')"
                                        class="block px-4 py-3 text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-600 rounded-t-lg transition-colors"
                                    >
                                        Register as Student
                                    </Link>
                                    <Link
                                        :href="route('instructor.register')"
                                        class="block px-4 py-3 text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-600 rounded-b-lg transition-colors"
                                    >
                                        Register as Instructor
                                    </Link>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="relative overflow-hidden py-20 sm:py-32">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl md:text-6xl lg:text-7xl">
                        {{ hero.title }}
                    </h1>
                    <p class="mt-6 text-xl sm:text-2xl font-semibold text-purple-600">
                        {{ hero.subtitle }}
                    </p>
                    <p class="mx-auto mt-6 max-w-3xl text-lg text-gray-600 leading-relaxed">
                        {{ hero.description }}
                    </p>
                    <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
                        <template v-if="!$page.props.auth.user">
                            <Link
                                :href="route('student.register')"
                                class="w-full sm:w-auto rounded-lg px-8 py-4 text-base font-semibold text-white bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5"
                            >
                                Register as Student →
                            </Link>
                            <Link
                                :href="route('instructor.register')"
                                class="w-full sm:w-auto rounded-lg px-8 py-4 text-base font-semibold text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5"
                            >
                                Register as Instructor →
                            </Link>
                        </template>
                        <Link
                            :href="route('about')"
                            class="w-full sm:w-auto rounded-lg px-8 py-4 text-base font-semibold text-purple-600 bg-white border-2 border-purple-600 hover:bg-purple-50 shadow-md hover:shadow-lg transition-all duration-300"
                        >
                            {{ hero.cta_secondary }}
                        </Link>
                    </div>
                </div>
            </div>

            <!-- Decorative Elements -->
            <div class="absolute top-0 left-0 -z-10 transform-gpu blur-3xl" aria-hidden="true">
                <div class="aspect-[1155/678] w-[72.1875rem] bg-gradient-to-tr from-purple-300 to-indigo-300 opacity-20"></div>
            </div>
        </section>

        <!-- Features Section -->
        <section v-if="features.features.length > 0" class="py-20 bg-white">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl font-bold text-gray-900 sm:text-4xl">
                        {{ features.title }}
                    </h2>
                    <p class="mt-4 text-lg text-gray-600">
                        {{ features.subtitle }}
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div
                        v-for="(feature, index) in features.features"
                        :key="index"
                        class="relative p-8 bg-gradient-to-br from-purple-50 to-indigo-50 rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1"
                    >
                        <div class="flex items-center justify-center w-12 h-12 mb-4 rounded-lg bg-gradient-to-r from-purple-600 to-indigo-600 text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">
                            {{ feature.title }}
                        </h3>
                        <p class="text-gray-600">
                            {{ feature.description }}
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section v-if="stats.stats.length > 0" class="py-20 bg-gradient-to-r from-purple-600 to-indigo-600">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-center text-white mb-12">
                    {{ stats.title }}
                </h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                    <div
                        v-for="(stat, index) in stats.stats"
                        :key="index"
                        class="text-center"
                    >
                        <div class="text-4xl sm:text-5xl font-extrabold text-white mb-2">
                            {{ stat.value }}
                        </div>
                        <div class="text-lg text-purple-100">
                            {{ stat.label }}
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-20 bg-gradient-to-br from-indigo-50 to-purple-50">
            <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl font-bold text-gray-900 sm:text-4xl mb-6">
                    Ready to Transform Your Institution?
                </h2>
                <p class="text-lg text-gray-600 mb-8">
                    Join hundreds of educational institutions already using EduCore to streamline their operations.
                </p>
                <div v-if="!$page.props.auth.user" class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <Link
                        :href="route('student.register')"
                        class="inline-block rounded-lg px-8 py-4 text-base font-semibold text-white bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5"
                    >
                        Register as Student →
                    </Link>
                    <Link
                        :href="route('instructor.register')"
                        class="inline-block rounded-lg px-8 py-4 text-base font-semibold text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5"
                    >
                        Register as Instructor →
                    </Link>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white py-12">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <!-- Company Info -->
                    <div class="col-span-1 md:col-span-2">
                        <ApplicationLogo class="h-10 w-auto mb-4 brightness-0 invert" />
                        <p class="text-gray-400 text-sm">
                            Empowering educational institutions with innovative management solutions.
                        </p>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                        <ul class="space-y-2 text-sm">
                            <li><Link :href="route('dashboard')" class="text-gray-400 hover:text-white transition-colors">Home</Link></li>
                            <li><Link :href="route('about')" class="text-gray-400 hover:text-white transition-colors">About</Link></li>
                            <li><Link :href="route('courses.index')" class="text-gray-400 hover:text-white transition-colors">Courses</Link></li>
                            <li><Link :href="route('contact')" class="text-gray-400 hover:text-white transition-colors">Contact</Link></li>
                        </ul>
                    </div>

                    <!-- Contact -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Contact</h3>
                        <ul class="space-y-2 text-sm text-gray-400">
                            <li>support@educore.com</li>
                            <li>+1 (555) 123-4567</li>
                        </ul>
                    </div>
                </div>

                <div class="mt-8 pt-8 border-t border-gray-800 text-center text-sm text-gray-400">
                    <p>&copy; {{ new Date().getFullYear() }} EduCore. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>
</template>
