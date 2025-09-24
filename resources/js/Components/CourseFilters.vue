<script setup lang="ts">
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
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
</template>

<style scoped>

</style>
