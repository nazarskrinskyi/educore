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

const filledStars = computed(() => Math.floor(props.rating))
const hasHalfStar = computed(() => props.rating % 1 >= 0.5)
const emptyStars = computed(
    () => props.max - filledStars.value - (hasHalfStar.value ? 1 : 0)
)
</script>

<template>
    <div class="flex items-center">
        <!-- Full stars -->
        <span v-for="i in filledStars.value" :key="'full-' + i" class="text-yellow-500">★</span>

        <!-- Half star -->
        <span v-if="hasHalfStar.value" class="text-yellow-500">☆</span>

        <!-- Empty stars -->
        <span v-for="i in emptyStars.value" :key="'empty-' + i" class="text-gray-300">★</span>

        <!-- Rating number -->
        <span class="ml-2 text-sm text-gray-600">({{ rating.toFixed(1) }})</span>
    </div>
</template>
