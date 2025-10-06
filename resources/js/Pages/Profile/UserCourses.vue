<script setup>
import { usePage } from "@inertiajs/vue3";
import CourseCard from "@/Components/CourseCard.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Navigation from "@/Pages/Profile/Partials/Navigation.vue";

defineProps({
    courses: Object,
});
</script>

<template>
    <Head title="Courses" />

    <AuthenticatedLayout>
        <template #header>
            <Navigation />
        </template>

        <section class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-purple-50 px-6 py-10">
            <div class="max-w-7xl mx-auto">
                <h1
                    class="text-3xl md:text-4xl font-bold text-gray-800 text-center mb-10 tracking-tight"
                >
                    🎓 Твої курси
                </h1>

                <transition-group
                    name="fade"
                    tag="div"
                    class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8"
                >
                    <CourseCard
                        v-for="course in courses.data"
                        :key="course.id"
                        :course="course"
                        :cart="usePage().props.cart"
                        class="transform transition duration-300 hover:scale-[1.03] hover:shadow-2xl"
                    />
                </transition-group>

                <div
                    v-if="!courses.data.length"
                    class="flex flex-col items-center justify-center mt-20 text-gray-500 text-lg"
                >
                    <img
                        src="https://cdn-icons-png.flaticon.com/512/4076/4076504.png"
                        alt="No courses"
                        class="w-24 h-24 mb-4 opacity-70"
                    />
                    <p>Курсів поки немає -_-</p>
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
