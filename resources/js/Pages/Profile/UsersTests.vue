<script setup lang="ts">
import TestCard from "@/Components/TestCard.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Navigation from "@/Pages/Profile/Partials/Navigation.vue";
import { Head } from "@inertiajs/vue3";

defineProps({
    tests: [Array, Object],
});
</script>

<template>
    <Head title="Tests" />

    <AuthenticatedLayout>
        <template #header>
            <Navigation />
        </template>

        <section class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50 px-6 py-10">
            <div class="max-w-7xl mx-auto">
                <h1
                    class="text-3xl md:text-4xl font-bold text-gray-800 text-center mb-10 tracking-tight"
                >
                    🧩 Тести для перевірки знань
                </h1>

                <transition-group
                    name="fade"
                    tag="div"
                    class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8"
                >
                    <TestCard
                        v-for="test in tests.data"
                        :key="test.id"
                        :test="test"
                        :is_passed="test.is_passed"
                        :show_course="true"
                        class="transform transition duration-300 hover:scale-[1.03] hover:shadow-2xl"
                    />
                </transition-group>

                <div
                    v-if="!tests.data.length"
                    class="flex flex-col items-center justify-center mt-20 text-gray-500 text-lg"
                >
                    <img
                        src="https://cdn-icons-png.flaticon.com/512/4076/4076504.png"
                        alt="No tests"
                        class="w-24 h-24 mb-4 opacity-70"
                    />
                    <p>Тестів поки немає — але вони вже готуються 🧠</p>
                </div>
            </div>
        </section>
    </AuthenticatedLayout>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: all 0.4s ease;
}
.fade-enter-from {
    opacity: 0;
    transform: translateY(20px);
}
.fade-leave-to {
    opacity: 0;
    transform: translateY(-10px);
}
</style>
