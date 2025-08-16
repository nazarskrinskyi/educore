<script setup>
import { Link } from "@inertiajs/vue3";
import AddToCartButton from "@/Components/AddToCartButton.vue";

/**
 * @typedef {Object} Course
 * @property {number} id
 * @property {string} title
 * @property {string} slug
 * @property {string} image_path
 * @property {boolean} is_free
 * @property {number} price
 * @property {{ name: string }} instructor
 * @property {{ name: string }} category
 * @property {{ name: string }[]} tags
 */

const props = defineProps({
    /** @type {Course} */
    course: Object,
    /** @type {{ [key: number]: Course }} */
    cart: {type: Object, default: () => ({})},
});

console.log(props)

</script>


<template>
    <div class="border rounded-lg shadow hover:shadow-lg overflow-hidden bg-white">
        <!-- Course image -->
        <!--        <Link :href="route('course.show', course.slug)">-->
        <img :src="course.image_path" alt="course image" class="w-full h-48 object-cover">
        <!--        </Link>-->

        <div class="p-4">
            <!-- Title -->
            <!--            <Link :href="route('course.show', course.slug)">-->
            <h3 class="font-bold text-lg mb-1 hover:text-blue-600">{{ course.title }}</h3>
            <!--            </Link>-->

            <!-- Tags -->
            <div class="flex flex-wrap gap-1 mb-2">
                <Link
                   v-for="tag in props.course.tags"
                   :href="tag.slug"
                   :key="tag.id"
                   class="bg-gray-200 text-gray-800 text-xs px-2 py-1 rounded">
                    {{ tag.name }}
                </Link>
            </div>

            <!-- Instructor & Category -->
            <p class="text-gray-500 text-sm mb-2">
                by {{ course.instructor.name }} | {{ course.category.name }}
            </p>

            <!-- Price -->
            <p class="font-semibold text-gray-800 mb-2">
                {{ course.is_free ? 'Free' : '$' + course.price }}
            </p>

            <!-- Add to Cart button -->
            <AddToCartButton :course-id="course.id" :cart="cart"/>
        </div>
    </div>
</template>
