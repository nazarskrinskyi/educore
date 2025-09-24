<script setup>
import { usePage } from '@inertiajs/vue3'
import CourseCard from '@/Components/CourseCard.vue'
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import CourseFilters from "@/Components/CourseFilters.vue";
import Pagination from "@/Components/Pagination.vue";

const props = defineProps({
    courses: Object,
    filters: Object
})
</script>

<template>
    <Head title="Courses" />

    <AuthenticatedLayout>
        <CourseFilters :filters="filters" />

        <div class="container mx-auto py-6">
            <!-- Courses grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <CourseCard v-for="course in courses.data" :course="course.data" :cart="usePage().props.cart"
                />
            </div>

            <Pagination :elems="courses" />
        </div>
    </AuthenticatedLayout>
</template>
