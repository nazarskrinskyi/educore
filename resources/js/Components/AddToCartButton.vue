<script setup>
import { router } from "@inertiajs/vue3";
import { computed } from "vue";

const { courseId, cart } = defineProps({
    courseId: { type: Number, required: true },
    cart: { type: Object, default: () => ({}) },
});

const isInCart = computed(() => !!cart[courseId]);

function addToCart() {
    if (isInCart.value) return;

    router.post(route("cart.add"), { course_id: courseId }, {
        preserveScroll: true,
        preserveState: true,
    });
}
</script>

<template>
    <button
        @click="addToCart"
        :disabled="isInCart"
        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 disabled:bg-gray-400 disabled:cursor-not-allowed"
    >
        {{ isInCart ? "In Cart" : "Add to Cart" }}
    </button>
</template>
