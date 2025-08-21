<script setup>
import {computed} from 'vue'
import {Link} from '@inertiajs/vue3'
import AddToCartButton from '@/Components/Cart/AddToCartButton.vue'

/**
 * @typedef {Object} Course
 * @property {number} id
 * @property {string} title
 * @property {string} slug
 * @property {string} image_path
 * @property {boolean} is_free
 * @property {number} price
 * @property {number} rating
 * @property {number} reviews_count
 * @property {{ name: string }} instructor
 * @property {{ name: string }} category
 * @property {{ id?: number, name: string, slug?: string }[]} tags
 * @property {boolean} [is_bestseller]
 */

const props = defineProps({
    /** @type {Course} */
    course: {type: Object, required: true},
    /** cart map or array; passed to AddToCartButton */
    cart: {type: [Object, Array], default: () => ({})},
})

const ratingFormatted = computed(() => (Number(props.course?.rating || 0)).toFixed(1))
const isBestseller = computed(() => {
    const r = Number(props.course?.rating || 0)
    const c = Number(props.course?.reviews_count || 0)
    return !!props.course?.is_bestseller || (r >= 4.6 && c >= 1000)
})

function onImgError(e) {
    e.target.src = 'https://via.placeholder.com/800x480?text=Course'
}

function formatCurrency(value) {
    if (!value) return '$0'
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
        maximumFractionDigits: 0
    }).format(Number(value))
}
</script>

<template>
    <div class="border rounded-2xl shadow-sm hover:shadow-md overflow-hidden bg-white transition group">
        <!-- image -->
        <img :src="course.image_path" alt="course image" class="w-full h-48 object-cover" @error="onImgError"/>

        <div class="p-4">
            <!-- title -->
            <Link class="font-bold text-lg leading-tight mb-1 group-hover:text-blue-600 line-clamp-2" href="/">
                {{ course.title }}
            </Link>

            <!-- tags -->
            <div class="flex flex-wrap gap-1.5 mb-2">
                <Link
                    v-for="tag in (course.tags || [])"
                    :href="tag.slug || '#'"
                    :key="tag.id || tag.name"
                    class="bg-gray-200 text-gray-800 text-[11px] px-2 py-0.5 rounded"
                >
                    {{ tag.name }}
                </Link>
            </div>

            <!-- instructor & category -->
            <p class="text-gray-500 text-sm mb-2">
                by {{ course?.instructor?.name || '—' }}
                <span class="text-gray-400">•</span>
                {{ course?.category?.name || '—' }}
            </p>

            <!-- rating + reviews (score) -->
            <div class="flex items-center gap-2 text-sm mb-2">
                <span class="font-semibold text-yellow-600">⭐ {{ ratingFormatted }}</span>
                <Stars :value="Number(course.rating || 0)" :size="14"/>
                <span class="text-gray-500">({{ course.reviews_count || 0 }} відгуків)</span>
                <span v-if="isBestseller"
                      class="ml-1 inline-flex items-center text-[10px] font-semibold px-1.5 py-0.5 rounded bg-amber-100 text-amber-800 ring-1 ring-amber-200">Лідер продажів</span>
            </div>

            <!-- price + add to cart -->
            <div class="flex items-center justify-between mt-1">
                <p class="font-semibold text-gray-900">
                    {{ course.is_free ? 'Free' : formatCurrency(course.price) }}
                </p>
                <AddToCartButton :course="course" :cart="cart" />
            </div>
        </div>
    </div>
</template>
