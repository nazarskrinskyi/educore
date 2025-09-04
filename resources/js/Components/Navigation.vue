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
</script>

<template>
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-24">
                <div class="flex items-center">
                    <a href="/" class="text-xl font-bold text-purple-600"><ApplicationLogo/></a>
                </div>

                <div class="flex space-x-6 items-center">
                    <Link
                        v-for="(link, i) in props.links"
                        :key="i"
                        :href="link.href"
                        class="text-gray-700 hover:text-purple-600 font-medium transition"
                        :class="{ 'text-purple-600 font-semibold border-b-2 border-purple-600': $page.url.startsWith(link.href) }"
                    >
                        {{ link.name }}
                    </Link>
                </div>
            </div>
        </div>
    </nav>
</template>
