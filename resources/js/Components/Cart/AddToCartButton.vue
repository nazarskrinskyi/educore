<script setup>
import {router} from "@inertiajs/vue3";
import {computed} from "vue";

const {course, cart} = defineProps({
    course: {type: Object, required: true},
    cart: {type: Object, default: () => ({})},
});

const isInCart = computed(() => !!cart[course.id]);

function addToCart(e) {
    e.stopPropagation()

    if (isInCart.value) return;

    router.post(route("cart.add"), {course_id: course.id}, {
        preserveScroll: true,
        preserveState: true,
    });
}
</script>

<template>
    <div v-if="course.owned">
        <span class="text-green-600 font-semibold">Already Purchased</span>
    </div>
    <div v-else>
        <button
            @click="addToCart"
            :disabled="course.is_free || course.in_cart"
            class="px-4 py-2 rounded text-white"
            :class="{
                        'bg-blue-600 hover:bg-blue-700': !course.is_free && !course.in_cart,
                        'bg-gray-400 cursor-not-allowed': course.is_free || course.in_cart
                    }"
        >
            {{ course.is_free ? 'Безкоштовний' : (course.in_cart ? 'У корзині' : 'Купити') }}
        </button>
    </div>
</template>
