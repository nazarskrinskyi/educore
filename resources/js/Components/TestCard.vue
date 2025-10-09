<script setup>
defineProps({
    test: {
        type: Object,
        required: true,
    },
    is_passed: {
        type: Boolean,
        default: false
    },
    is_successfully_passed: {
        type: Boolean,
        default: false
    },
    show_course: {
        type: Boolean,
        default: false
    }
});
</script>

<template>
    <div
        class="border rounded-lg shadow p-4 transition relative hover:shadow-lg"
        :class="{
      'bg-green-50 border-green-400': is_passed && is_successfully_passed,
      'bg-red-50 border-red-400': is_passed && !is_successfully_passed,
      'bg-white border-gray-200': !is_passed
    }"
    >
        <!-- Course title -->
        <div v-if="show_course" class="text-xl mb-2 font-bold text-center">
            {{ test.course.title }}
        </div>

        <!-- Image -->
        <img
            v-if="test.image_url"
            :src="test.image_url"
            alt="Test image"
            class="w-full h-32 object-cover rounded mb-3"
        />

        <!-- Test info -->
        <h3 class="text-lg font-bold mb-2">{{ test.title }}</h3>
        <p class="text-sm text-gray-600 mb-2 line-clamp-2">{{ test.description }}</p>
        <p class="text-xs text-gray-500 mb-3">⏱ {{ test.duration }} хв</p>

        <!-- Button -->
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
            :class="[
        'px-3 py-1 rounded inline-block transition',
        is_successfully_passed ? 'bg-green-600 hover:bg-green-700 text-white' : 'bg-red-600 hover:bg-red-700 text-white'
      ]"
        >
            Переглянути результат
        </a>

        <!-- Overlay for passed tests -->
        <div
            v-if="is_passed"
            class="absolute inset-0 rounded-lg pointer-events-none"
            :class="{
        'bg-green-50 opacity-20': is_successfully_passed,
        'bg-red-50 opacity-20': !is_successfully_passed
      }"
        ></div>
    </div>
</template>
