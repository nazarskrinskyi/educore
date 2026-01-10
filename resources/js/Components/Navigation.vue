<script setup>
import { Link } from '@inertiajs/vue3'
import ApplicationLogo from "@/Components/ApplicationLogo.vue";

const props = defineProps({
    links: {
        type: Array,
        required: true,
        validator: (value) => {
            return value.every((link) => typeof link === 'object' && 'name' in link && 'href' in link)
        },
    },
})

const isActive = (href) => {
    return window.location.pathname.startsWith(href)
}
</script>

<template>
    <nav class="bg-white shadow-md sticky top-0 z-50" role="navigation" aria-label="Main navigation">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center">
                    <Link
                        href="/"
                        class="text-xl font-bold text-purple-600 hover:text-purple-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-purple-500 rounded-md"
                        aria-label="Go to homepage"
                    >
                        <ApplicationLogo />
                    </Link>
                </div>

                <div class="flex space-x-8 items-center">
                    <Link
                        v-for="(link, i) in props.links"
                        :key="i"
                        :href="link.href"
                        class="text-gray-700 hover:text-purple-600 font-medium transition-all duration-200 py-2 border-b-2 border-transparent hover:border-purple-300 focus:outline-none focus:ring-2 focus:ring-purple-500 rounded-sm"
                        :class="{
                            'text-purple-600 font-semibold border-purple-600': isActive(link.href)
                        }"
                        :aria-current="isActive(link.href) ? 'page' : undefined"
                    >
                        {{ link.name }}
                    </Link>
                </div>
            </div>
        </div>
    </nav>
</template>
