<script setup lang="ts">
import { Link, usePage } from "@inertiajs/vue3";

const page = usePage();

function linkClass(routeName: string) {
    const isActive = page.component === routeName || route().current(routeName);
    return [
        "px-4 py-2 rounded-lg font-medium transition-colors duration-200",
        isActive ? "bg-indigo-500 text-white" : "text-gray-700 hover:bg-indigo-500 hover:text-white"
    ].join(" ");
}
</script>

<template>
    <nav class="flex space-x-4">
        <Link
            :href="route('profile.edit')"
            :class="linkClass('profile.edit')"
        >
            Profile
        </Link>

        <Link
            :href="route('profile.show.courses')"
            :class="linkClass('profile.show.courses')"
        >
            Courses
        </Link>

        <Link
            :href="route('profile.show.tests')"
            :class="linkClass('profile.show.tests')"
        >
            Tests
        </Link>
    </nav>
</template>

<style scoped>
</style>
