<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import { Link } from '@inertiajs/vue3';
import MapCard from "@/Components/MapCard.vue";
import ScrollToTop from "@/Components/ScrollToTop.vue";

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100">
            <nav
                class="border-b border-gray-100 bg-white shadow"
            >
                <!-- Primary Navigation Menu -->
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="flex h-20 justify-between">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="flex shrink-0 items-center">
                                <Link :href="route('dashboard')">
                                    <ApplicationLogo
                                        class="block h-18 w-auto fill-current text-gray-800"
                                    />
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div
                                class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex"
                            >
                                <NavLink
                                    :href="route('dashboard')"
                                    :active="route().current('dashboard')"
                                >
                                    Home
                                </NavLink>
                                <NavLink
                                    :href="route('about')"
                                    :active="route().current('about')"
                                >
                                    About
                                </NavLink>
                                <Dropdown align="center" width="48" class="mt-6">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none"
                                            >
                                                Services
                                                <svg
                                                    class="-me-0.5 ms-2 h-4 w-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                >
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"
                                                    />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <DropdownLink
                                            :href="route('profile.edit')"
                                        >
                                            Courses
                                        </DropdownLink>
                                        <DropdownLink
                                            :href="route('logout')"
                                            method="post"
                                            as="button"
                                        >
                                            Lessons
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                                <NavLink
                                    :href="route('contact')"
                                    :active="route().current('contact')"
                                >
                                    Contact
                                </NavLink>
                            </div>
                        </div>

                        <div class="hidden sm:ms-6 sm:flex sm:items-center">
                            <!-- Settings Dropdown -->
                            <div class="relative ms-3">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none"
                                            >
                                                {{ $page.props.auth.user.name }}

                                                <svg
                                                    class="-me-0.5 ms-2 h-4 w-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                >
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"
                                                    />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <DropdownLink
                                            :href="route('profile.edit')"
                                        >
                                            Profile
                                        </DropdownLink>
                                        <DropdownLink
                                            :href="route('logout')"
                                            method="post"
                                            as="button"
                                        >
                                            Log Out
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-me-2 flex items-center sm:hidden">
                            <button
                                @click="
                                    showingNavigationDropdown =
                                        !showingNavigationDropdown
                                "
                                class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 transition duration-150 ease-in-out hover:bg-gray-100 hover:text-gray-500 focus:bg-gray-100 focus:text-gray-500 focus:outline-none"
                            >
                                <svg
                                    class="h-6 w-6"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex':
                                                !showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex':
                                                showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
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

            <footer class="border-t border-gray-100 bg-gradient-to-b from-purple-50 to-pink-50 shadow">
                <div class="flex flex-row justify-between mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 self-start gap-5">
                    <div class="info flex flex-row gap-5">
                        <div class="flex flex-col w-1/2 gap-5">
                            <ApplicationLogo styles="w-60" />
                            <div>
                                Educore is an educational management system that serves as a
                                core system for nurseries, early learning centers, primary
                                schools and early intervention centers. Flexible enough to cater
                                for any setting, easy to use and backed up by a great team of
                                professionals who fully understand the childcare industry.
                            </div>
                            <div class="flex flex-row justify-center max-w-7xl px-4 py-6 sm:px-6 lg:px-8  space-x-2 mt-auto">
                                <a href="https://www.facebook.com/educoreme/?ref=bookmarks&amp;utm_source=iEducore%20-%20News&amp;utm_campaign=d1eff8d5f8-EMAIL_CAMPAIGN_2020_03_17_01_56&amp;utm_medium=email&amp;utm_term=0_96f0db6526-d1eff8d5f8-" target="_blank">
                                    <svg class="icon transition-all duration-300 ease-in-out" xmlns="http://www.w3.org/2000/svg" width="62" height="62" viewBox="0 0 62 62" fill="none">
                                        <circle class="circle transition-all duration-300 ease-in-out" cx="31" cy="31" r="30.5" stroke="url(#paint0_linear_2371_6234)"></circle>
                                        <path class="icon-path transition-all duration-300 ease-in-out" d="M27.4974 23.7926V27.2001H25V31.3665H27.4974V43.7491H32.6235V31.3677H36.0645C36.0645 31.3677 36.3869 29.3701 36.5431 27.1852H32.6446V24.3357C32.6446 23.9104 33.2026 23.3375 33.7556 23.3375H36.5506V19H32.7512C27.3696 19 27.4974 23.1701 27.4974 23.7926Z" fill="#0A2240"></path>
                                        <defs>
                                            <linearGradient id="paint0_linear_2371_6234" x1="-5.50001" y1="-7.69995e-07" x2="66.0001" y2="77.5002" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#0A2240"></stop>
                                                <stop offset="0.46" stop-color="#0A2240" stop-opacity="0"></stop>
                                                <stop offset="0.965" stop-color="#0A2240"></stop>
                                            </linearGradient>
                                        </defs>
                                    </svg>
                                </a>
                                <a href="https://www.linkedin.com/company/ieducore/?utm_source=iEducore+-+News&amp;utm_campaign=d1eff8d5f8-EMAIL_CAMPAIGN_2020_03_17_01_56&amp;utm_medium=email&amp;utm_term=0_96f0db6526-d1eff8d5f8-" target="_blank">
                                    <svg class="icon transition-all duration-300 ease-in-out" xmlns="http://www.w3.org/2000/svg" width="62" height="62" viewBox="0 0 62 62" fill="none">
                                        <circle class="circle transition-all duration-300 ease-in-out" cx="31" cy="31" r="30.5" stroke="url(#paint0_linear_2371_6235)"></circle>
                                        <path class="icon-path transition-all duration-300 ease-in-out" d="M23.96 22.4812C23.9597 23.139 23.6981 23.7696 23.2327 24.2345C22.7674 24.6993 22.1365 24.9603 21.4788 24.96C20.821 24.9597 20.1904 24.6981 19.7255 24.2327C19.2606 23.7674 18.9997 23.1365 19 22.4788C19.0003 21.821 19.2619 21.1904 19.7273 20.7255C20.1926 20.2606 20.8235 19.9997 21.4812 20C22.139 20.0003 22.7696 20.2619 23.2345 20.7273C23.6993 21.1926 23.9603 21.8235 23.96 22.4812ZM24.0344 26.7964H19.0744V42.3212H24.0344V26.7964ZM31.8712 26.7964H26.936V42.3212H31.8216V34.1744C31.8216 29.636 37.7364 29.2144 37.7364 34.1744V42.3212H42.6343V32.488C42.6343 24.8372 33.88 25.1224 31.8216 28.8796L31.8712 26.7964Z" fill="#0A2240"></path>
                                        <defs>
                                            <linearGradient id="paint0_linear_2371_6235" x1="-5.50001" y1="-7.69995e-07" x2="66.0001" y2="77.5002" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#0A2240"></stop>
                                                <stop offset="0.46" stop-color="#0A2240" stop-opacity="0"></stop>
                                                <stop offset="0.965" stop-color="#0A2240"></stop>
                                            </linearGradient>
                                        </defs>
                                    </svg>
                                </a>
                                <a href="#">
                                    <svg class="icon transition-all duration-300 ease-in-out" xmlns="http://www.w3.org/2000/svg" width="62" height="62" viewBox="0 0 62 62" fill="none">
                                        <circle class="circle transition-all duration-300 ease-in-out" cx="31" cy="31" r="30.5" stroke="url(#paint0_linear_2371_6236)"></circle>
                                        <path class="icon-path transition-all duration-300 ease-in-out" d="M38.5312 20H42.3343L34.0263 29.455L43.7999 42.32H36.1467L30.1538 34.5166L23.2954 42.32H19.4886L28.3756 32.2078L19 20H26.8467L32.2655 27.1325L38.5312 20ZM37.197 40.0532H39.305L25.7009 22.1477H23.4392L37.197 40.0532Z" fill="#0A2240"></path>
                                        <defs>
                                            <linearGradient id="paint0_linear_2371_6236" x1="-5.50001" y1="-7.69995e-07" x2="66.0001" y2="77.5002" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#0A2240"></stop>
                                                <stop offset="0.46" stop-color="#0A2240" stop-opacity="0"></stop>
                                                <stop offset="0.965" stop-color="#0A2240"></stop>
                                            </linearGradient>
                                        </defs>
                                    </svg>
                                </a>
                                <a href="https://www.youtube.com/@educoresystemstechnologies8012" target="_blank">
                                    <svg class="icon transition-all duration-300 ease-in-out" xmlns="http://www.w3.org/2000/svg" width="62" height="62" viewBox="0 0 62 62" fill="none">
                                        <circle class="circle transition-all duration-300 ease-in-out" cx="31" cy="31" r="30.5" stroke="url(#paint0_linear_2371_6237)"></circle>
                                        <path class="icon-path transition-all duration-300 ease-in-out" d="M28.5997 34.7198L35.0352 30.9998L28.5997 27.2798V34.7198ZM42.934 25.0106C43.0952 25.5934 43.2068 26.3746 43.2812 27.3666C43.368 28.3586 43.4052 29.2142 43.4052 29.9582L43.4796 30.9998C43.4796 33.7154 43.2812 35.7118 42.934 36.989C42.624 38.105 41.9048 38.8242 40.7888 39.1342C40.206 39.2954 39.1396 39.407 37.5028 39.4814C35.8908 39.5682 34.4153 39.6054 33.0513 39.6054L31.0797 39.6798C25.8841 39.6798 22.6477 39.4814 21.3705 39.1342C20.2545 38.8242 19.5353 38.105 19.2253 36.989C19.0641 36.4062 18.9525 35.625 18.8781 34.633C18.7913 33.641 18.7541 32.7854 18.7541 32.0414L18.6797 30.9998C18.6797 28.2842 18.8781 26.2878 19.2253 25.0106C19.5353 23.8946 20.2545 23.1754 21.3705 22.8654C21.9533 22.7042 23.0197 22.5926 24.6565 22.5182C26.2685 22.4314 27.7441 22.3942 29.1081 22.3942L31.0797 22.3198C36.2752 22.3198 39.5116 22.5182 40.7888 22.8654C41.9048 23.1754 42.624 23.8946 42.934 25.0106Z" fill="#0A2240"></path>
                                        <defs>
                                            <linearGradient id="paint0_linear_2371_6237" x1="-5.50001" y1="-7.69995e-07" x2="66.0001" y2="77.5002" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#0A2240"></stop>
                                                <stop offset="0.46" stop-color="#0A2240" stop-opacity="0"></stop>
                                                <stop offset="0.965" stop-color="#0A2240"></stop>
                                            </linearGradient>
                                        </defs>
                                    </svg>
                                </a>
                                <a href="https://www.instagram.com/educoresystemstechnologies/?utm_source=iEducore+-+News&amp;utm_campaign=d1eff8d5f8-EMAIL_CAMPAIGN_2020_03_17_01_56&amp;utm_medium=email&amp;utm_term=0_96f0db6526-d1eff8d5f8-" target="_blank">
                                    <svg class="icon transition-all duration-300 ease-in-out" xmlns="http://www.w3.org/2000/svg" width="62" height="62" viewBox="0 0 62 62" fill="none">
                                        <circle class="circle transition-all duration-300 ease-in-out" cx="31" cy="31" r="30.38" stroke="url(#paint0_linear_2371_6238)" stroke-width="1.24"></circle>
                                        <path class="icon-path transition-all duration-300 ease-in-out" d="M26.231 18.6001H36.647C40.615 18.6001 43.839 21.8241 43.839 25.7921V36.2081C43.839 38.1155 43.0813 39.9448 41.7325 41.2936C40.3838 42.6423 38.5545 43.4 36.647 43.4H26.231C22.2631 43.4 19.0391 40.176 19.0391 36.2081V25.7921C19.0391 23.8846 19.7968 22.0553 21.1455 20.7066C22.4943 19.3578 24.3236 18.6001 26.231 18.6001ZM25.983 21.0801C24.7991 21.0801 23.6637 21.5504 22.8265 22.3876C21.9894 23.2247 21.5191 24.3602 21.5191 25.5441V36.4561C21.5191 38.9237 23.5155 40.92 25.983 40.92H36.895C38.0789 40.92 39.2144 40.4497 40.0515 39.6126C40.8887 38.7754 41.359 37.64 41.359 36.4561V25.5441C41.359 23.0765 39.3626 21.0801 36.895 21.0801H25.983ZM37.949 22.9401C38.3601 22.9401 38.7544 23.1034 39.045 23.3941C39.3357 23.6848 39.499 24.079 39.499 24.4901C39.499 24.9012 39.3357 25.2954 39.045 25.5861C38.7544 25.8768 38.3601 26.0401 37.949 26.0401C37.5379 26.0401 37.1437 25.8768 36.853 25.5861C36.5623 25.2954 36.399 24.9012 36.399 24.4901C36.399 24.079 36.5623 23.6848 36.853 23.3941C37.1437 23.1034 37.5379 22.9401 37.949 22.9401ZM31.439 24.8001C33.0834 24.8001 34.6604 25.4533 35.8231 26.616C36.9858 27.7787 37.639 29.3557 37.639 31.0001C37.639 32.6444 36.9858 34.2214 35.8231 35.3841C34.6604 36.5468 33.0834 37.2001 31.439 37.2001C29.7947 37.2001 28.2177 36.5468 27.055 35.3841C25.8923 34.2214 25.239 32.6444 25.239 31.0001C25.239 29.3557 25.8923 27.7787 27.055 26.616C28.2177 25.4533 29.7947 24.8001 31.439 24.8001ZM31.439 27.2801C30.4524 27.2801 29.5062 27.672 28.8086 28.3696C28.111 29.0673 27.719 30.0135 27.719 31.0001C27.719 31.9867 28.111 32.9329 28.8086 33.6305C29.5062 34.3281 30.4524 34.7201 31.439 34.7201C32.4256 34.7201 33.3718 34.3281 34.0695 33.6305C34.7671 32.9329 35.159 31.9867 35.159 31.0001C35.159 30.0135 34.7671 29.0673 34.0695 28.3696C33.3718 27.672 32.4256 27.2801 31.439 27.2801Z" fill="#0A2240"></path>
                                        <defs>
                                            <linearGradient id="paint0_linear_2371_6238" x1="-5.50001" y1="-7.69995e-07" x2="66.0001" y2="77.5002" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#0A2240"></stop>
                                                <stop offset="0.46" stop-color="#0A2240" stop-opacity="0"></stop>
                                                <stop offset="0.965" stop-color="#0A2240"></stop>
                                            </linearGradient>
                                        </defs>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div class="flex flex-col w-1/2 sm:mt-10 gap-5">
                            <div class="text-2xl bold">Useful Links</div>
                            <ul class="flex flex-col gap-4 list-disc ml-5">
                                <li>Home</li>
                                <li>Services</li>
                                <li>Products</li>
                                <li>Blog</li>
                                <li>About Us</li>
                                <li>Contact Us</li>
                            </ul>
                        </div>
                    </div>
                    <div class="map ">
                        <MapCard image="/images/download.png" mail="nazarharosh@gmail.com" phone="+380730291182" address="naklsnangasjhgasjkghasjkg aklsaqghalsgh" width="500px"/>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</template>
