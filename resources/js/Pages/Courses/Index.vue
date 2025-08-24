<script setup>
import { ref } from 'vue'
import { router, usePage } from '@inertiajs/vue3'
import CourseCard from '@/Components/CourseCard.vue'
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const props = defineProps({
    courses: Object,
    filters: Object
})

const search = ref(props.filters.search || '')
const category = ref(props.filters.category || '')
const rating = ref(props.filters.rating || '')
const priceMin = ref(props.filters.price_min || '')
const priceMax = ref(props.filters.price_max || '')

function applyFilters() {
    router.get(route('courses.index'), {
        search: search.value,
        category: category.value,
        rating: rating.value,
        price_min: priceMin.value,
        price_max: priceMax.value,
    }, {
        preserveState: true,
        replace: true
    })
}

</script>

<template>
    <Head title="Courses" />

    <AuthenticatedLayout>
        <div class="container mx-auto py-6">
            <!-- Filters -->
            <div class="mb-6 grid grid-cols-1 md:grid-cols-5 gap-4">
                <input v-model="search" type="text" placeholder="Search courses..."
                       class="border rounded p-2 w-full" @keyup.enter="applyFilters" />

                <select v-model="category" class="border rounded p-2 w-full" @change="applyFilters">
                    <option value="">All Categories</option>
                    <option value="1">Web Development</option>
                    <option value="2">Design</option>
                    <option value="3">Marketing</option>
                </select>

                <select v-model="rating" class="border rounded p-2 w-full" @change="applyFilters">
                    <option value="">All Ratings</option>
                    <option value="4">4★ & up</option>
                    <option value="3">3★ & up</option>
                    <option value="2">2★ & up</option>
                </select>

                <input v-model="priceMin" type="number" placeholder="Min Price"
                       class="border rounded p-2 w-full" @change="applyFilters" />
                <input v-model="priceMax" type="number" placeholder="Max Price"
                       class="border rounded p-2 w-full" @change="applyFilters" />
            </div>

            <!-- Courses grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <CourseCard v-for="course in courses.data" :course="course.data" :cart="usePage().props.cart"
                />
            </div>

            <!-- Pagination -->
            <div class="mt-6 flex justify-center space-x-2">
                <button
                    v-for="link in courses.links"
                    :key="link.label"
                    v-html="link.label"
                    :disabled="!link.url"
                    @click="router.get(link.url, {}, { preserveState: true, replace: true })"
                    class="px-3 py-1 border rounded"
                    :class="{'bg-gray-200': link.active}"
                />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
