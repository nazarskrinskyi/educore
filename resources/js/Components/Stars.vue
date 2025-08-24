<script setup>
import { computed } from 'vue'

const props = defineProps({
    rating: {
        type: Number,
        required: true,
        default: 0,
    },
    max: {
        type: Number,
        default: 5,
    },
})

const filledStars = computed(() => Math.floor(props.rating));
const hasHalfStar = computed(() => props.rating % 1 >= 0.5);
const emptyStars = computed(() => props.max - filledStars.value - (hasHalfStar.value ? 1 : 0));
</script>

<template>
    <div class="flex space-x-1">
        <!-- Full stars -->
        <svg v-for="i in filledStars" :key="'full-' + i" class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.947a1 1 0 00.95.69h4.15c.969 0 1.371 1.24.588 1.81l-3.36 2.44a1 1 0 00-.364 1.118l1.286 3.947c.3.921-.755 1.688-1.54 1.118l-3.36-2.44a1 1 0 00-1.176 0l-3.36 2.44c-.784.57-1.838-.197-1.539-1.118l1.285-3.947a1 1 0 00-.364-1.118L2.034 9.374c-.783-.57-.38-1.81.588-1.81h4.15a1 1 0 00.95-.69l1.286-3.947z"/>
        </svg>

        <!-- Half star -->
        <svg v-if="hasHalfStar" class="w-5 h-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
            <defs>
                <linearGradient id="half-grad">
                    <stop offset="50%" stop-color="currentColor"/>
                    <stop offset="50%" stop-color="transparent"/>
                </linearGradient>
            </defs>
            <path fill="url(#half-grad)" d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.947a1 1 0 00.95.69h4.15c.969 0 1.371 1.24.588 1.81l-3.36 2.44a1 1 0 00-.364 1.118l1.286 3.947c.3.921-.755 1.688-1.54 1.118l-3.36-2.44a1 1 0 00-1.176 0l-3.36 2.44c-.784.57-1.838-.197-1.539-1.118l1.285-3.947a1 1 0 00-.364-1.118L2.034 9.374c-.783-.57-.38-1.81.588-1.81h4.15a1 1 0 00.95-.69l1.286-3.947z"/>
        </svg>

        <!-- Empty stars -->
        <svg v-for="i in emptyStars" :key="'empty-' + i" class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.947a1 1 0 00.95.69h4.15c.969 0 1.371 1.24.588 1.81l-3.36 2.44a1 1 0 00-.364 1.118l1.286 3.947c.3.921-.755 1.688-1.54 1.118l-3.36-2.44a1 1 0 00-1.176 0l-3.36 2.44c-.784.57-1.838-.197-1.539-1.118l1.285-3.947a1 1 0 00-.364-1.118L2.034 9.374c-.783-.57-.38-1.81.588-1.81h4.15a1 1 0 00.95-.69l1.286-3.947z"/>
        </svg>
    </div>
</template>
