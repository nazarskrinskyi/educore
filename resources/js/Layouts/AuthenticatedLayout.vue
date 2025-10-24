<script setup>
import {computed, ref} from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import {Link, usePage} from '@inertiajs/vue3';
import MapCard from "@/Components/MapCard.vue";
import ScrollToTop from "@/Components/ScrollToTop.vue";
import Cart from "@/Components/Cart/Cart.vue";

const showingNavigationDropdown = ref(false);
const page = usePage()
const cart = computed(() => Object.values(page.props.cart ?? {}))
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
                            <NavLink :href="route('courses.index')" :active="route().current('courses.index')">Courses</NavLink>
                            <NavLink :href="route('contact')" :active="route().current('contact')">Contact</NavLink>
                            <Cart :cart="cart" />
                        </div>

                        <!-- Desktop Profile Dropdown -->
                        <div class="hidden sm:flex sm:items-center sm:ms-6">
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                    <button class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm text-gray-500 hover:text-gray-700">
                                        {{ $page.props.auth.user.name }}
                                        <svg class="-me-0.5 ms-2 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                </template>
                                <template #content>
                                    <DropdownLink :href="route('profile.edit')">Profile</DropdownLink>
                                    <DropdownLink :href="route('filament.admin.pages.dashboard')" v-if="$page.props.auth.is_admin">Admin</DropdownLink>
                                    <DropdownLink :href="route('logout')" method="post" as="button">Log Out</DropdownLink>
                                </template>
                            </Dropdown>
                        </div>

                        <!-- Hamburger Menu -->
                        <div class="sm:hidden flex items-center">
                            <button @click="showingNavigationDropdown = !showingNavigationDropdown"
                                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:bg-gray-100 hover:text-gray-500">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path v-if="!showingNavigationDropdown" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                    <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Mobile Menu -->
                    <transition name="slide-fade">
                        <div v-if="showingNavigationDropdown" class="fixed inset-0 z-50 bg-white bg-opacity-95 backdrop-blur-md flex flex-col p-6 space-y-6">
                            <!-- Close Button -->
                            <div class="flex justify-end">
                                <button @click="showingNavigationDropdown = false" class="p-2 text-gray-500 hover:text-gray-700">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>

                            <!-- Navigation Links -->
                            <div class="flex flex-col space-y-4 text-lg font-medium">
                                <NavLink @click="showingNavigationDropdown=false" :href="route('dashboard')" :active="route().current('dashboard')">Home</NavLink>
                                <NavLink @click="showingNavigationDropdown=false" :href="route('about')" :active="route().current('about')">About</NavLink>
                                <NavLink @click="showingNavigationDropdown=false" :href="route('courses.index')" :active="route().current('courses.index')">Courses</NavLink>
                                <NavLink @click="showingNavigationDropdown=false" :href="route('contact')" :active="route().current('contact')">Contact</NavLink>
                                <Cart :cart="cart" />
                            </div>

                            <hr class="border-gray-200 my-4"/>

                            <!-- Profile Links -->
                            <div class="flex flex-col space-y-2">
                                <DropdownLink @click="showingNavigationDropdown=false" :href="route('profile.edit')">Profile</DropdownLink>
                                <DropdownLink @click="showingNavigationDropdown=false" :href="route('admin')" v-if="$page.props.auth.is_admin">Admin</DropdownLink>
                                <DropdownLink @click="showingNavigationDropdown=false" :href="route('logout')" method="post" as="button">Log Out</DropdownLink>
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
                            <a href="https://www.facebook.com/educoreme/" target="_blank" class="hover:scale-110 transition-transform">
                                <!-- Facebook SVG -->
                            </a>
                            <a href="https://www.linkedin.com/company/ieducore/" target="_blank" class="hover:scale-110 transition-transform">
                                <!-- LinkedIn SVG -->
                            </a>
                            <a href="#" class="hover:scale-110 transition-transform">
                                <!-- Twitter SVG -->
                            </a>
                            <a href="https://www.youtube.com/@educoresystemstechnologies8012" target="_blank" class="hover:scale-110 transition-transform">
                                <!-- YouTube SVG -->
                            </a>
                            <a href="https://www.instagram.com/educoresystemstechnologies/" target="_blank" class="hover:scale-110 transition-transform">
                                <!-- Instagram SVG -->
                            </a>
                        </div>
                    </div>

                    <!-- Center: Useful Links -->
                    <div class="flex flex-col lg:w-1/4 gap-5 mt-6 lg:mt-0">
                        <h3 class="text-2xl font-bold">Useful Links</h3>
                        <ul class="flex flex-col gap-2 text-gray-700 text-sm sm:text-base">
                            <li><a href="#" class="hover:text-gray-900 transition-colors">Home</a></li>
                            <li><a href="#" class="hover:text-gray-900 transition-colors">Services</a></li>
                            <li><a href="#" class="hover:text-gray-900 transition-colors">Products</a></li>
                            <li><a href="#" class="hover:text-gray-900 transition-colors">Blog</a></li>
                            <li><a href="#" class="hover:text-gray-900 transition-colors">About Us</a></li>
                            <li><a href="#" class="hover:text-gray-900 transition-colors">Contact Us</a></li>
                        </ul>
                    </div>

                    <!-- Right: Map / Contact Card -->
                    <div class="lg:w-1/4 mt-6 lg:mt-0">
                        <MapCard
                            image="/images/download.png"
                            mail="nazarharosh@gmail.com"
                            phone="+380730291182"
                            address="naklsnangasjhgasjkghasjkg aklsaqghalsgh"
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
