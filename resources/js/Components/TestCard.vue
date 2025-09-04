<script setup>
defineProps({
    test: {
        type: Object,
        required: true,
    },
    is_passed: {
        type: Boolean,
        default: false
    }
});
</script>

<template>
    <div class="border rounded-lg shadow p-4 bg-white hover:shadow-lg transition relative">
        <img
            v-if="test.image_url"
            :src="test.image_url"
            alt="Test image"
            class="w-full h-32 object-cover rounded mb-3"
        />
        <h3 class="text-lg font-bold mb-2">{{ test.title }}</h3>
        <p class="text-sm text-gray-600 mb-2 line-clamp-2">{{ test.description }}</p>
        <p class="text-xs text-gray-500 mb-3">⏱ {{ test.duration }} хв</p>

        <a
            v-if="!is_passed"
            :href="route('tests.show', test.slug)"
            class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 transition inline-block"
        >
            Перейти до тесту
        </a>

        <a
            v-else
            :href="route('tests.result', test.id)"
            class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 transition inline-block"
        >
            Переглянути результат
        </a>

        <div
            v-if="is_passed"
            class="absolute inset-0 bg-white bg-opacity-50 rounded-lg pointer-events-none"
        ></div>
    </div>
</template>
