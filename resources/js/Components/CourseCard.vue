<script setup>
import { computed, toRaw } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import AddToCartButton from '@/Components/Cart/AddToCartButton.vue'
import Stars from "@/Components/Stars.vue";

/**
 * @typedef {Object} Course
 * @property {number} id
 * @property {string} title
 * @property {string} slug
 * @property {string} image_url
 * @property {boolean} is_free
 * @property {number} price_formatted
 * @property {number} rating
 * @property {number} reviews_count
 * @property {{ name: string }} instructor
 * @property {{ name: string }} category
 * @property {{ id?: number, name: string, slug?: string }[]} tags
 * @property {boolean} [is_bestseller]
 */

const props = defineProps({
    /** @type {Course} */
    course: {
        type: Object,
        required: true,
    },
    /** cart map or array; passed to AddToCartButton */
    cart: {
        type: [Object, Array],
        default: () => ({}),
    },
})

const isBestseller = computed(() => {
    const r = Number(props.course?.rating || 0)
    const c = Number(props.course?.reviews_count || 0)
    return !!props.course?.is_bestseller || (r >= 4.6 && c >= 1000)
})

function goToCourse(course) {
    router.visit(route('courses.show', course.slug))
}

function handleKeyPress(event, course) {
    if (event.key === 'Enter' || event.key === ' ') {
        event.preventDefault()
        goToCourse(course)
    }
}
</script>

<template>
    <article
        class="border rounded-2xl shadow-sm hover:shadow-lg overflow-hidden bg-white transition-all duration-300 group cursor-pointer focus-within:ring-2 focus-within:ring-purple-500"
        @click="goToCourse(course)"
        @keypress="handleKeyPress($event, course)"
        tabindex="0"
        role="button"
        :aria-label="`View course: ${course.title}`"
    >
        <!-- Image -->
        <div class="relative overflow-hidden">
            <img
                :src="course.image_url"
                :alt="`${course.title} course thumbnail`"
                class="w-full h-48 object-cover transition-transform duration-300 group-hover:scale-105"
                loading="lazy"
            />
            <div v-if="isBestseller" class="absolute top-2 right-2">
                <span class="inline-flex items-center text-xs font-semibold px-2 py-1 rounded-full bg-amber-500 text-white shadow-md">
                    ⭐ Bestseller
                </span>
            </div>
        </div>

        <div class="p-4">
            <!-- Title -->
            <h3 class="font-bold text-lg leading-tight mb-2 group-hover:text-purple-600 line-clamp-2 transition-colors duration-200">
                {{ course.title }}
            </h3>

            <!-- Tags -->
            <div v-if="course.tags && course.tags.length > 0" class="flex flex-wrap gap-1.5 mb-3">
                <Link
                    v-for="tag in course.tags"
                    :href="tag.slug || '#'"
                    :key="tag.id || tag.name"
                    class="bg-gray-100 text-gray-700 text-xs px-2 py-1 rounded-md hover:bg-purple-100 hover:text-purple-700 transition-colors duration-200"
                    @click.stop
                >
                    {{ tag.name }}
                </Link>
            </div>

            <!-- Instructor & Category -->
            <p class="text-gray-600 text-sm mb-3">
                <span class="font-medium">{{ course?.instructor?.name || 'Unknown Instructor' }}</span>
                <span class="text-gray-400 mx-1">•</span>
                <span>{{ course?.category?.name || 'Uncategorized' }}</span>
            </p>

            <!-- Rating + Reviews -->
            <div class="flex items-center gap-2 text-sm mb-3">
                <Stars :size="16" :rating="Number(course.rating || 0)" />
                <span class="font-medium text-gray-700">{{ Number(course.rating || 0).toFixed(1) }}</span>
                <span class="text-gray-500">({{ course.reviews_count || 0 }} reviews)</span>
            </div>

            <!-- Price + Add to Cart -->
            <div class="flex items-center justify-between mt-4 pt-3 border-t border-gray-100">
                <p class="font-bold text-xl text-gray-900">
                    {{ course.is_free ? 'Free' : `₴${course.price_formatted}` }}
                </p>
                <AddToCartButton :course="toRaw(course)" :cart="cart" @click.stop />
            </div>
        </div>
    </article>
</template>
