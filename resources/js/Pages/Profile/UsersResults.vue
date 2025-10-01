<script setup lang="ts">
import TestCard from "@/Components/TestCard.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Navigation from "@/Pages/Profile/Partials/Navigation.vue";

defineProps({
    tests: [Array, Object],
})
</script>

<template>
    <AuthenticatedLayout>
        <Navigation />
        <div v-if="tests.length" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <TestCard
                v-for="test in tests"
                :key="test.id"
                :test="test"
                :is_passed="test.is_passed"
            />
        </div>

        <div v-else class="text-gray-500">Тестів поки немає</div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
