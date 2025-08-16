<script setup>
import Cart from "@/Components/Cart.vue"
import { usePage } from "@inertiajs/vue3"
import { computed } from "vue"
import CourseCard from "@/Components/CourseCard.vue";

defineProps({
    courses: {
        type: Object,
        default: () => ({}),
    },
});


const page = usePage()
const cart = computed(() => Object.values(page.props.cart ?? {}))
</script>

<template>
    <Head title="About" />

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <CourseCard
            v-for="course in courses"
            :key="course.id"
            :course="course"
            :cart="cart"
        />
    </div>

    <Cart :cart="cart" />
</template>
