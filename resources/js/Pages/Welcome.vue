<script setup>
import { Link, Head, usePage } from '@inertiajs/vue3';
import { computed, ref, onMounted } from 'vue';
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import LocaleSwitcher from "@/Components/LocaleSwitcher.vue";
import { useTranslations } from '@/composables/useTranslations';

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

const { t } = useTranslations();
const page = usePage();

const hero = computed(() => props.pageConfig.hero || {
    title: t('welcome.title', 'Welcome to EduCore'),
    subtitle: t('welcome.subtitle', 'Transform Your Educational Institution'),
    description: t('welcome.description', 'The complete educational management system for modern learning institutions. Streamline operations, enhance communication, and empower your educational ecosystem.'),
    cta_primary: t('welcome.cta_primary', 'Get Started'),
    cta_secondary: t('welcome.cta_secondary', 'Learn More'),
});

const features = computed(() => props.pageConfig.features || {
    title: t('welcome.features_title', 'Why Choose EduCore?'),
    subtitle: t('welcome.features_subtitle', 'Comprehensive Features for Modern Education'),
    features: [],
});

const stats = computed(() => props.pageConfig.stats || {
    title: t('welcome.stats_title', 'Trusted by Institutions Worldwide'),
    stats: [],
});

// Animation state
const isVisible = ref(false);

onMounted(() => {
    setTimeout(() => {
        isVisible.value = true;
    }, 100);
});

// Icon mapping for features
const getFeatureIcon = (iconName) => {
    const icons = {
        dashboard: 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
        attendance: 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4',
        analytics: 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z',
        security: 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z',
        parent: 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z',
        support: 'M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z',
    };
    return icons[iconName] || 'M5 13l4 4L19 7';
};
</script>

<template>
    <Head title="Welcome to EduCore" />
    <div class="bg-gradient-to-br from-indigo-50 via-white to-purple-50 min-h-screen">
        <!-- Header -->
        <header class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-gray-200 shadow-sm">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-20 items-center justify-between">
                    <!-- Logo -->
                    <Link :href="route('dashboard', { locale: $page.props.locale })" class="flex items-center">
                        <ApplicationLogo class="h-12 w-auto" />
                    </Link>

                    <!-- Desktop Navigation -->
                    <nav class="hidden md:flex items-center space-x-8">
                        <Link :href="route('dashboard', { locale: $page.props.locale })" class="text-gray-700 hover:text-purple-600 font-medium transition-colors">
                            {{ t('nav.home', 'Home') }}
                        </Link>
                        <Link :href="route('about', { locale: $page.props.locale })" class="text-gray-700 hover:text-purple-600 font-medium transition-colors">
                            {{ t('nav.about', 'About') }}
                        </Link>
                        <Link :href="route('courses.index', { locale: $page.props.locale })" class="text-gray-700 hover:text-purple-600 font-medium transition-colors">
                            {{ t('nav.courses', 'Courses') }}
                        </Link>
                        <Link :href="route('contact', { locale: $page.props.locale })" class="text-gray-700 hover:text-purple-600 font-medium transition-colors">
                            {{ t('nav.contact', 'Contact') }}
                        </Link>
                    </nav>

                    <!-- Auth Buttons -->
                    <div v-if="canLogin" class="flex items-center space-x-4">
                        <!-- Locale Switcher -->
                        <LocaleSwitcher />

                        <Link
                            v-if="$page.props.auth.user"
                            :href="route('dashboard', { locale: $page.props.locale })"
                            class="rounded-lg px-6 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 shadow-md hover:shadow-lg transition-all duration-300"
                        >
                            {{ t('nav.dashboard', 'Dashboard') }}
                        </Link>

                        <template v-else>
                            <!-- Login Dropdown -->
                            <div class="relative group">
                                <button class="hidden sm:block rounded-lg px-6 py-2.5 text-sm font-semibold text-gray-700 hover:text-purple-600 transition-colors">
                                    {{ t('nav.login', 'Log in') }}
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
                                    {{ t('nav.get_started', 'Get Started') }}
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
            <!-- Animated Background -->
            <div class="absolute inset-0 -z-10 overflow-hidden">
                <div class="absolute -top-40 -right-40 w-80 h-80 bg-purple-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob"></div>
                <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-indigo-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-2000"></div>
                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-pink-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-4000"></div>
            </div>

            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <!-- Admin Edit Button -->
                    <div v-if="$page.props.auth.is_admin" class="mb-4 flex justify-center">
                        <Link
                            :href="route('filament.admin.resources.page-configurations.edit', { record: 'welcome-hero' })"
                            class="inline-flex items-center gap-2 rounded-lg bg-gray-800 px-4 py-2 text-sm text-white hover:bg-gray-700 transition-colors"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit Hero Section
                        </Link>
                    </div>

                    <h1
                        class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl md:text-6xl lg:text-7xl transition-all duration-1000"
                        :class="{ 'opacity-0 translate-y-4': !isVisible, 'opacity-100 translate-y-0': isVisible }"
                    >
                        <span class="block">{{ hero.title }}</span>
                    </h1>
                    <p
                        class="mt-6 text-xl sm:text-2xl font-semibold bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent transition-all duration-1000 delay-150"
                        :class="{ 'opacity-0 translate-y-4': !isVisible, 'opacity-100 translate-y-0': isVisible }"
                    >
                        {{ hero.subtitle }}
                    </p>
                    <p
                        class="mx-auto mt-6 max-w-3xl text-lg text-gray-600 leading-relaxed transition-all duration-1000 delay-300"
                        :class="{ 'opacity-0 translate-y-4': !isVisible, 'opacity-100 translate-y-0': isVisible }"
                    >
                        {{ hero.description }}
                    </p>
                    <div
                        class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4 transition-all duration-1000 delay-500"
                        :class="{ 'opacity-0 translate-y-4': !isVisible, 'opacity-100 translate-y-0': isVisible }"
                    >
                        <template v-if="!$page.props.auth.user">
                            <Link
                                :href="route('student.register')"
                                class="group w-full sm:w-auto rounded-lg px-8 py-4 text-base font-semibold text-white bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 hover:scale-105"
                            >
                                <span class="flex items-center justify-center gap-2">
                                    {{ t('auth.register', 'Register') }} as Student
                                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                    </svg>
                                </span>
                            </Link>
                            <Link
                                :href="route('instructor.register')"
                                class="group w-full sm:w-auto rounded-lg px-8 py-4 text-base font-semibold text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 hover:scale-105"
                            >
                                <span class="flex items-center justify-center gap-2">
                                    {{ t('auth.register', 'Register') }} as Instructor
                                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                    </svg>
                                </span>
                            </Link>
                        </template>
                        <Link
                            :href="route('about', { locale: $page.props.locale })"
                            class="w-full sm:w-auto rounded-lg px-8 py-4 text-base font-semibold text-purple-600 bg-white border-2 border-purple-600 hover:bg-purple-50 shadow-md hover:shadow-lg transition-all duration-300 hover:scale-105"
                        >
                            {{ hero.cta_secondary }}
                        </Link>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section v-if="features.features.length > 0" class="py-20 bg-white relative overflow-hidden">
            <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-5">
                <div class="absolute inset-0" style="background-image: radial-gradient(circle at 1px 1px, rgb(99 102 241) 1px, transparent 0); background-size: 40px 40px;"></div>
            </div>

            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative">
                <!-- Admin Edit Button -->
                <div v-if="$page.props.auth.is_admin" class="mb-4 flex justify-center">
                    <Link
                        :href="route('filament.admin.resources.page-configurations.edit', { record: 'welcome-features' })"
                        class="inline-flex items-center gap-2 rounded-lg bg-gray-800 px-4 py-2 text-sm text-white hover:bg-gray-700 transition-colors"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Features Section
                    </Link>
                </div>

                <div class="text-center mb-16">
                    <h2 class="text-3xl font-bold text-gray-900 sm:text-4xl mb-2">
                        {{ features.title }}
                    </h2>
                    <div class="w-24 h-1 bg-gradient-to-r from-purple-600 to-indigo-600 mx-auto mb-4 rounded-full"></div>
                    <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">
                        {{ features.subtitle }}
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div
                        v-for="(feature, index) in features.features"
                        :key="index"
                        class="group relative p-8 bg-white rounded-2xl shadow-md hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-gray-100 hover:border-purple-200"
                    >
                        <!-- Gradient overlay on hover -->
                        <div class="absolute inset-0 bg-gradient-to-br from-purple-50 to-indigo-50 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

                        <div class="relative z-10">
                            <div class="flex items-center justify-center w-14 h-14 mb-6 rounded-xl bg-gradient-to-br from-purple-600 to-indigo-600 text-white shadow-lg group-hover:scale-110 transition-transform duration-500">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="getFeatureIcon(feature.icon)"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-purple-600 transition-colors duration-300">
                                {{ feature.title }}
                            </h3>
                            <p class="text-gray-600 leading-relaxed">
                                {{ feature.description }}
                            </p>
                        </div>

                        <!-- Decorative corner -->
                        <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-purple-100 to-transparent rounded-bl-full opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section v-if="stats.stats.length > 0" class="py-20 bg-gradient-to-br from-purple-600 via-indigo-600 to-purple-700 relative overflow-hidden">
            <!-- Animated background elements -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-0 left-0 w-96 h-96 bg-white rounded-full filter blur-3xl animate-pulse"></div>
                <div class="absolute bottom-0 right-0 w-96 h-96 bg-white rounded-full filter blur-3xl animate-pulse animation-delay-2000"></div>
            </div>

            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative">
                <!-- Admin Edit Button -->
                <div v-if="$page.props.auth.is_admin" class="mb-4 flex justify-center">
                    <Link
                        :href="route('filament.admin.resources.page-configurations.edit', { record: 'welcome-stats' })"
                        class="inline-flex items-center gap-2 rounded-lg bg-white/20 backdrop-blur-sm px-4 py-2 text-sm text-white hover:bg-white/30 transition-colors"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Stats Section
                    </Link>
                </div>

                <h2 class="text-3xl font-bold text-center text-white mb-4">
                    {{ stats.title }}
                </h2>
                <div class="w-24 h-1 bg-white/50 mx-auto mb-12 rounded-full"></div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                    <div
                        v-for="(stat, index) in stats.stats"
                        :key="index"
                        class="text-center group"
                    >
                        <div class="relative inline-block">
                            <div class="text-4xl sm:text-5xl font-extrabold text-white mb-2 group-hover:scale-110 transition-transform duration-300">
                                {{ stat.value }}
                            </div>
                            <!-- Underline animation -->
                            <div class="h-1 bg-white/30 rounded-full w-0 group-hover:w-full transition-all duration-500 mx-auto"></div>
                        </div>
                        <div class="text-lg text-purple-100 mt-3 font-medium">
                            {{ stat.label }}
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-20 bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 relative overflow-hidden">
            <!-- Decorative elements -->
            <div class="absolute inset-0 opacity-30">
                <div class="absolute top-10 left-10 w-72 h-72 bg-purple-200 rounded-full mix-blend-multiply filter blur-xl animate-blob"></div>
                <div class="absolute top-10 right-10 w-72 h-72 bg-indigo-200 rounded-full mix-blend-multiply filter blur-xl animate-blob animation-delay-2000"></div>
                <div class="absolute -bottom-8 left-1/2 transform -translate-x-1/2 w-72 h-72 bg-pink-200 rounded-full mix-blend-multiply filter blur-xl animate-blob animation-delay-4000"></div>
            </div>

            <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 text-center relative">
                <div class="bg-white/60 backdrop-blur-sm rounded-3xl shadow-2xl p-12 border border-white/50">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-purple-600 to-indigo-600 rounded-full mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>

                    <h2 class="text-3xl font-bold text-gray-900 sm:text-4xl mb-4">
                        {{ t('welcome.cta_section_title', 'Ready to Transform Your Institution?') }}
                    </h2>
                    <div class="w-24 h-1 bg-gradient-to-r from-purple-600 to-indigo-600 mx-auto mb-6 rounded-full"></div>
                    <p class="text-lg text-gray-600 mb-10 max-w-2xl mx-auto leading-relaxed">
                        {{ t('welcome.cta_section_description', 'Join hundreds of educational institutions already using EduCore to streamline their operations and enhance learning experiences.') }}
                    </p>
                    <div v-if="!$page.props.auth.user" class="flex flex-col sm:flex-row items-center justify-center gap-4">
                        <Link
                            :href="route('student.register')"
                            class="group inline-flex items-center justify-center gap-2 rounded-xl px-8 py-4 text-base font-semibold text-white bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 hover:scale-105"
                        >
                            Register as Student
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </Link>
                        <Link
                            :href="route('instructor.register')"
                            class="group inline-flex items-center justify-center gap-2 rounded-xl px-8 py-4 text-base font-semibold text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 hover:scale-105"
                        >
                            Register as Instructor
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </Link>
                    </div>
                    <div v-else class="text-gray-600">
                        <p class="text-lg">Welcome back! Visit your dashboard to continue your learning journey.</p>
                        <Link
                            :href="route('dashboard', { locale: $page.props.locale })"
                            class="inline-flex items-center justify-center gap-2 mt-6 rounded-xl px-8 py-4 text-base font-semibold text-white bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1"
                        >
                            {{ t('nav.dashboard', 'Go to Dashboard') }}
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </Link>
                    </div>
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
                            {{ t('footer.empowering', 'Empowering educational institutions with innovative management solutions.') }}
                        </p>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4">{{ t('footer.quick_links', 'Quick Links') }}</h3>
                        <ul class="space-y-2 text-sm">
                            <li><Link :href="route('dashboard', { locale: $page.props.locale })" class="text-gray-400 hover:text-white transition-colors">{{ t('nav.home', 'Home') }}</Link></li>
                            <li><Link :href="route('about', { locale: $page.props.locale })" class="text-gray-400 hover:text-white transition-colors">{{ t('nav.about', 'About') }}</Link></li>
                            <li><Link :href="route('courses.index', { locale: $page.props.locale })" class="text-gray-400 hover:text-white transition-colors">{{ t('nav.courses', 'Courses') }}</Link></li>
                            <li><Link :href="route('contact', { locale: $page.props.locale })" class="text-gray-400 hover:text-white transition-colors">{{ t('nav.contact', 'Contact') }}</Link></li>
                        </ul>
                    </div>

                    <!-- Contact -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4">{{ t('footer.contact', 'Contact') }}</h3>
                        <ul class="space-y-2 text-sm text-gray-400">
                            <li>support@educore.com</li>
                            <li>+1 (555) 123-4567</li>
                        </ul>
                    </div>
                </div>

                <div class="mt-8 pt-8 border-t border-gray-800 text-center text-sm text-gray-400">
                    <p>&copy; {{ new Date().getFullYear() }} EduCore. {{ t('footer.rights_reserved', 'All rights reserved.') }}</p>
                </div>
            </div>
        </footer>
    </div>
</template>
