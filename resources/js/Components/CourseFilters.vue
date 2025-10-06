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
    <div class="mb-8 p-6 bg-white rounded-2xl shadow-lg border border-gray-200">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-4">
            <!-- Search -->
            <div class="relative col-span-1 md:col-span-2">
                <input
                    v-model="search"
                    type="text"
                    placeholder="Search courses..."
                    @keyup.enter="applyFilters"
                    class="w-full p-3 pl-10 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition duration-200 placeholder-gray-400"
                />
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3.5" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.9 14.32a8 8 0 111.414-1.414l4.387 4.386a1 1 0 01-1.414 1.415l-4.387-4.387zM8 14a6 6 0 100-12 6 6 0 000 12z" clip-rule="evenodd"/></svg>
            </div>

            <!-- Category -->
            <select
                v-model="category"
                @change="applyFilters"
                class="w-full p-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition duration-200"
            >
                <option value="">All Categories</option>
                <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
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

            <!-- Price Range -->
            <div class="flex gap-2">
                <input
                    v-model="priceMin"
                    type="number"
                    placeholder="Min Price"
                    @change="applyFilters"
                    class="w-full p-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition duration-200"
                />
                <input
                    v-model="priceMax"
                    type="number"
                    placeholder="Max Price"
                    @change="applyFilters"
                    class="w-full p-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition duration-200"
                />
            </div>
        </div>
    </div>
</template>

<style scoped>
input:hover, select:hover {
    border-color: #60a5fa; /* Tailwind blue-400 */
}
</style>
