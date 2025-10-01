<script setup>
import {usePage} from "@inertiajs/vue3";
import CourseCard from "@/Components/CourseCard.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Navigation from "@/Pages/Profile/Partials/Navigation.vue";

defineProps({
    courses: Object,
})
</script>

<template>
    <AuthenticatedLayout>
        <Navigation />
        <div v-if="courses.data.length" class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <CourseCard v-for="course in courses.data" :course="course.data" :cart="usePage().props.cart"
            />
        </div>

        <div v-else class="text-gray-500">Курсів поки немає</div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
