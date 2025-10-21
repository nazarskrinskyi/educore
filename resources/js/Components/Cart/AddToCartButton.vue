<script setup>
import { router } from "@inertiajs/vue3";
import { computed } from "vue";

const { course, cart } = defineProps({
    course: { type: Object, required: true },
    cart: { type: Object, default: () => ({}) },
});

const isInCart = computed(() => !!cart[course.id]);

function handleClick(e) {
    e.stopPropagation();

    if (course.owned) return;

    if (course.is_free) {
        router.post(route("courses.enroll", { course: course.id }), {}, {
            preserveScroll: true,
            preserveState: true,
        });
    } else {
        if (isInCart.value || course.in_cart) return;

        router.post(route("cart.add"), { course_id: course.id }, {
            preserveScroll: true,
            preserveState: true,
        });
    }
}
</script>

<template>
    <div v-if="course.owned">
        <span class="text-green-600 font-semibold">Already Purchased</span>
    </div>
    <div v-else>
        <button
            @click="handleClick"
            class="px-4 py-2 rounded text-white"
            :class="{
                'bg-blue-600 hover:bg-blue-700': !course.in_cart,
                'bg-gray-400 cursor-not-allowed': course.in_cart
            }"
        >
            {{ course.is_free ? 'Почати Курс' : (course.in_cart ? 'У корзині' : 'Купити') }}
        </button>
    </div>
</template>
