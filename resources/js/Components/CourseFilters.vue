<script setup>
import { ref, watch, computed } from 'vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
    filters: Object,
    categories: Array,
    priceRange: Object,
    difficulties: Object
})

const search = ref(props.filters.search || '')
const category = ref(props.filters.category || '')
const priceMin = ref(props.filters.price_min ?? props.priceRange.min)
const priceMax = ref(props.filters.price_max ?? props.priceRange.max)
const free = ref(!!props.filters.is_free)
const difficulty = ref(props.filters.difficulty || '')
const sort = ref(props.filters.sorting || '')

function applyFilters() {
    router.get(route('courses.index'), {
        search: search.value,
        category: category.value,
        price_min: free.value ? '' : priceMin.value,
        price_max: free.value ? '' : priceMax.value,
        free: free.value,
        difficulty: difficulty.value,
        sorting: sort.value,
    }, {
        preserveState: true,
        replace: true,
    })
}

watch([priceMin, priceMax], ([min, max]) => {
    priceMin.value = Math.max(props.priceRange.min, Math.min(min, max - 1));
    priceMax.value = Math.min(props.priceRange.max, Math.max(max, min + 1));
    applyFilters();
});

watch([free, category, difficulty, sort], applyFilters)

const rangeProgress = computed(() => {
    const total = props.priceRange.max - props.priceRange.min
    const left = ((priceMin.value - props.priceRange.min) / total) * 100
    const right = ((priceMax.value - props.priceRange.min) / total) * 100
    return { left, right }
})
</script>

<template>
    <div class="mb-8 p-6 bg-white rounded-2xl shadow-lg border border-gray-100">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-4">
            <!-- Search -->
            <div class="relative col-span-1 md:col-span-2">
                <input
                    v-model="search"
                    type="text"
                    placeholder="Search courses..."
                    @keyup.enter="applyFilters"
                    class="w-full p-3 pl-10 border border-gray-200 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition duration-200 placeholder-gray-400"
                />
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M12.9 14.32a8 8 0 111.414-1.414l4.387 4.386a1 1 0 01-1.414 1.415l-4.387-4.387zM8 14a6 6 0 100-12 6 6 0 000 12z" clip-rule="evenodd"/>
                </svg>
            </div>

            <!-- Category -->
            <select
                v-model="category"
                class="w-full p-3 border border-gray-200 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition duration-200"
            >
                <option value="">All Categories</option>
                <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
            </select>

            <!-- Sorting -->
            <select
                v-model="sort"
                class="w-full p-3 border border-gray-200 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition duration-200"
            >
                <option value="">Sort by</option>
                <option value="rating_asc">Rating: Worst → Best</option>
                <option value="rating_desc">Rating: Best → Worst</option>
                <option value="price_asc">Price: Low → High</option>
                <option value="price_desc">Price: High → Low</option>
                <option value="newest">Newest</option>
            </select>

            <!-- Difficulty -->
            <select
                v-model="difficulty"
                class="w-full p-3 border border-gray-200 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition duration-200"
            >
                <option value="">All Levels</option>
                <option v-for="diff in difficulties" :value="diff.value">{{ diff.name }}</option>
            </select>

            <!-- Price Range -->
            <div class="col-span-1 sm:col-span-2">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm text-gray-600">Price Range</span>
                    <label class="flex items-center gap-1 text-sm">
                        <input type="checkbox" v-model="free" class="rounded border-gray-300 focus:ring-blue-400" />
                        Free only
                    </label>
                </div>

                <div class="relative flex flex-col gap-3">
                    <div class="flex justify-between text-sm text-gray-500">
                        <span>₴{{ priceMin }}</span>
                        <span>₴{{ priceMax }}</span>
                    </div>

                    <div class="relative h-2">
                        <div class="absolute h-2 rounded-full bg-gray-200 w-full"></div>
                        <div
                            class="absolute h-2 rounded-full bg-blue-500 transition-all duration-200"
                            :style="{
                                left: rangeProgress.left + '%',
                                right: (100 - rangeProgress.right) + '%'
                            }"
                        ></div>

                        <!-- Sliders -->
                        <input
                            type="range"
                            v-model="priceMin"
                            :min="props.priceRange.min"
                            :max="props.priceRange.max"
                            step="1"
                            class="range-thumb"
                        />
                        <input
                            type="range"
                            v-model="priceMax"
                            :min="props.priceRange.min"
                            :max="props.priceRange.max"
                            step="1"
                            class="range-thumb"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.range-thumb {
    position: absolute;
    width: 100%;
    appearance: none;
    height: 6px;
    background: transparent;
}
.range-thumb::-webkit-slider-thumb {
    appearance: none;
    height: 18px;
    width: 18px;
    background: white;
    border: 2px solid #2563eb;
    border-radius: 50%;
    cursor: pointer;
    box-shadow: 0 0 2px rgba(0,0,0,0.2);
    transition: transform 0.2s, background 0.2s;
}
.range-thumb::-webkit-slider-thumb:hover {
    background: #2563eb;
    transform: scale(1.15);
}
.range-thumb::-moz-range-thumb {
    height: 18px;
    width: 18px;
    background: white;
    border: 2px solid #2563eb;
    border-radius: 50%;
    cursor: pointer;
    transition: transform 0.2s;
}
.range-thumb::-moz-range-thumb:hover {
    background: #2563eb;
    transform: scale(1.15);
}
</style>
