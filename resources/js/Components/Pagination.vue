<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
    filters: Object,
    categories: Array,
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
    <!-- Filters -->
    <div class="mb-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-4">
        <!-- Search -->
        <input
            v-model="search"
            type="text"
            placeholder="Search courses..."
            @keyup.enter="applyFilters"
            class="w-full p-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition duration-200 placeholder-gray-400"
        />

        <!-- Category -->
        <select
            v-model="category"
            @change="applyFilters"
            class="w-full p-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition duration-200"
        >
            <option value="">All Categories</option>
            <option value="{{ category.id }}" v-for="category in categories">{{ category.name }}</option>
        </select>

        <!-- Rating -->
        <select
            v-model="rating"
            @change="applyFilters"
            class="w-full p-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition duration-200"
        >
            <option value="">All Ratings</option>
            <option value="4">4★ & up</option>
            <option value="3">3★ & up</option>
            <option value="2">2★ & up</option>
        </select>

        <!-- Min Price -->
        <input
            v-model="priceMin"
            type="number"
            placeholder="Min Price"
            @change="applyFilters"
            class="w-full p-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition duration-200"
        />

        <!-- Max Price -->
        <input
            v-model="priceMax"
            type="number"
            placeholder="Max Price"
            @change="applyFilters"
            class="w-full p-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition duration-200"
        />
    </div>
</template>

<style scoped>
input:hover, select:hover {
    border-color: #60a5fa; /* Tailwind blue-400 */
}
</style>
