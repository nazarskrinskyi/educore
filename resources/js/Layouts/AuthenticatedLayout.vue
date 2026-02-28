<script setup>
import { computed, ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import { Link, usePage } from '@inertiajs/vue3';
import MapCard from "@/Components/MapCard.vue";
import ScrollToTop from "@/Components/ScrollToTop.vue";
import Cart from "@/Components/Cart/Cart.vue";
import LocaleSwitcher from "@/Components/LocaleSwitcher.vue";

const showingNavigationDropdown = ref(false);
const page = usePage();
const cart = computed(() => Object.values(page.props.cart ?? {}));

const closeMenu = () => {
    showingNavigationDropdown.value = false;
};
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100">
            <nav class="border-b border-gray-100 bg-white shadow sticky top-0 z-50">
                <!-- Primary Navigation Menu -->
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="flex h-20 justify-between items-center">
                        <!-- Logo -->
                        <div class="flex items-center">
                            <Link :href="route('dashboard')">
                                <ApplicationLogo class="block h-18 w-auto fill-current text-gray-800" />
                            </Link>
                        </div>

                        <!-- Desktop Navigation -->
                        <div class="hidden sm:flex sm:space-x-8 sm:ms-10 items-center">
                            <NavLink :href="route('dashboard')" :active="route().current('dashboard')">Home</NavLink>
                            <NavLink :href="route('about')" :active="route().current('about')">About</NavLink>
                            <NavLink :href="route('courses.index')" :active="route().current('courses.index')" v-if="$page.props.auth.is_student">Courses</NavLink>
                            <NavLink :href="route('contact')" :active="route().current('contact')">Contact</NavLink>
                            <Cart :cart="cart" v-if="$page.props.auth.is_student"/>
                        </div>

                        <!-- Desktop Profile Dropdown & Language Switcher -->
                        <div class="hidden sm:flex sm:items-center sm:ms-6 sm:gap-3">
                            <LocaleSwitcher />
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                    <button class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm text-gray-500 hover:text-gray-700">
                                        {{ $page.props.auth.user?.name ?? 'Guest' }}
                                        <svg class="-me-0.5 ms-2 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                </template>
                                <template #content>
                                    <DropdownLink :href="route('profile.edit')">Profile</DropdownLink>
                                    <DropdownLink :href="route('filament.admin.pages.dashboard')" v-if="$page.props.auth.is_student === false">Admin</DropdownLink>
                                    <DropdownLink :href="route('logout')" method="post" as="button">Log Out</DropdownLink>
                                </template>
                            </Dropdown>
                        </div>

                        <!-- Hamburger Menu & Mobile Language Switcher -->
                        <div class="sm:hidden flex items-center gap-2">
                            <LocaleSwitcher />
                            <button
                                @click="showingNavigationDropdown = !showingNavigationDropdown"
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:bg-gray-100 hover:text-gray-500 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-purple-500"
                                aria-label="Toggle navigation menu"
                                :aria-expanded="showingNavigationDropdown"
                            >
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path v-if="!showingNavigationDropdown" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                    <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Mobile Menu -->
                    <transition name="slide-fade">
                        <div
                            v-if="showingNavigationDropdown"
                            class="fixed inset-0 z-50 bg-white bg-opacity-95 backdrop-blur-md flex flex-col p-6 space-y-6"
                            role="dialog"
                            aria-modal="true"
                            aria-label="Mobile navigation menu"
                        >
                            <!-- Close Button -->
                            <div class="flex justify-end">
                                <button
                                    @click="closeMenu"
                                    class="p-2 text-gray-500 hover:text-gray-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-purple-500 rounded-md"
                                    aria-label="Close menu"
                                >
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>

                            <!-- Navigation Links -->
                            <nav class="flex flex-col space-y-4 text-lg font-medium" role="navigation">
                                <NavLink @click="closeMenu" :href="route('dashboard')" :active="route().current('dashboard')">Home</NavLink>
                                <NavLink @click="closeMenu" :href="route('about')" :active="route().current('about')">About</NavLink>
                                <NavLink @click="closeMenu" :href="route('courses.index')" :active="route().current('courses.index')">Courses</NavLink>
                                <NavLink @click="closeMenu" :href="route('contact')" :active="route().current('contact')">Contact</NavLink>
                                <Cart :cart="cart" />
                            </nav>

                            <hr class="border-gray-200 my-4" />

                            <!-- Profile Links -->
                            <div class="flex flex-col space-y-2">
                                <DropdownLink @click="closeMenu" :href="route('profile.edit')">Profile</DropdownLink>
                                <DropdownLink @click="closeMenu" :href="route('filament.admin.pages.dashboard')" v-if="$page.props.auth.is_admin">Admin</DropdownLink>
                                <DropdownLink @click="closeMenu" :href="route('logout')" method="post" as="button">Log Out</DropdownLink>
                            </div>
                        </div>
                    </transition>
                </div>
            </nav>

            <!-- Page Heading -->
            <header
                class="bg-white shadow"
                v-if="$slots.header"
            >
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <ScrollToTop />
                <slot />
            </main>

            <footer class="border-t border-gray-200 bg-gradient-to-b from-white via-gray-50 to-white shadow-md">
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 flex flex-col lg:flex-row gap-10 lg:gap-20">
                    <!-- Left: Logo + Description + Socials -->
                    <div class="flex flex-col lg:w-1/2 gap-5">
                        <ApplicationLogo class="w-60" />
                        <p class="text-gray-700 text-sm sm:text-base">
                            Educore is an educational management system that serves as a
                            core system for nurseries, early learning centers, primary
                            schools, and early intervention centers. Flexible enough to cater
                            for any setting, easy to use and backed up by a great team of
                            professionals who fully understand the childcare industry.
                        </p>

                        <!-- Social Links -->
                        <div class="flex flex-wrap gap-3 mt-3">
                            <a href="https://www.facebook.com/educoreme/" target="_blank" rel="noopener noreferrer" class="p-2 rounded-full bg-gray-200 hover:bg-purple-600 hover:text-white transition-all transform hover:scale-110" aria-label="Facebook">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </a>
                            <a href="https://www.linkedin.com/company/ieducore/" target="_blank" rel="noopener noreferrer" class="p-2 rounded-full bg-gray-200 hover:bg-purple-600 hover:text-white transition-all transform hover:scale-110" aria-label="LinkedIn">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                </svg>
                            </a>
                            <a href="https://twitter.com/educore" target="_blank" rel="noopener noreferrer" class="p-2 rounded-full bg-gray-200 hover:bg-purple-600 hover:text-white transition-all transform hover:scale-110" aria-label="Twitter">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                </svg>
                            </a>
                            <a href="https://www.youtube.com/@educoresystemstechnologies8012" target="_blank" rel="noopener noreferrer" class="p-2 rounded-full bg-gray-200 hover:bg-purple-600 hover:text-white transition-all transform hover:scale-110" aria-label="YouTube">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                </svg>
                            </a>
                            <a href="https://www.instagram.com/educoresystemstechnologies/" target="_blank" rel="noopener noreferrer" class="p-2 rounded-full bg-gray-200 hover:bg-purple-600 hover:text-white transition-all transform hover:scale-110" aria-label="Instagram">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Center: Useful Links -->
                    <div class="flex flex-col lg:w-1/4 gap-5 mt-6 lg:mt-0">
                        <h3 class="text-2xl font-bold">Useful Links</h3>
                        <ul class="flex flex-col gap-2 text-gray-700 text-sm sm:text-base">
                            <li><Link :href="route('dashboard')" class="hover:text-purple-600 transition-colors">Home</Link></li>
                            <li><Link :href="route('about')" class="hover:text-purple-600 transition-colors">About Us</Link></li>
                            <li><Link :href="route('courses.index')" class="hover:text-purple-600 transition-colors">Courses</Link></li>
                            <li><Link :href="route('contact')" class="hover:text-purple-600 transition-colors">Contact Us</Link></li>
                            <li><Link :href="route('profile.edit')" class="hover:text-purple-600 transition-colors">My Profile</Link></li>
                            <li><Link v-if="$page.props.auth.is_student === false" :href="route('filament.admin.pages.dashboard')" class="hover:text-purple-600 transition-colors">Admin Panel</Link></li>
                        </ul>
                    </div>

                    <!-- Right: Map / Contact Card -->
                    <div class="lg:w-1/4 mt-6 lg:mt-0">
                        <MapCard
                            image="/images/download.png"
                            mail="support@educore.com"
                            phone="+1 (555) 123-4567"
                            address="123 Education Street, Learning City, ED 12345"
                            width="100%"
                        />
                    </div>
                </div>
            </footer>
        </div>
    </div>
</template>
<style scoped>
.slide-fade-enter-active {
    transition: all 0.3s ease;
}
.slide-fade-leave-active {
    transition: all 0.3s ease;
}
.slide-fade-enter-from {
    transform: translateX(100%);
    opacity: 0;
}
.slide-fade-enter-to {
    transform: translateX(0%);
    opacity: 1;
}
.slide-fade-leave-from {
    transform: translateX(0%);
    opacity: 1;
}
.slide-fade-leave-to {
    transform: translateX(100%);
    opacity: 0;
}
</style>
