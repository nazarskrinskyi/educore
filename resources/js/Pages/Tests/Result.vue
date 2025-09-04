<template>
    <div class="max-w-4xl mx-auto p-6">
        <Navigation :links="[{name: props.lessonName, href: props.lessonLink}]" />
        <!-- Заголовок тесту -->
        <h1 class="text-3xl font-bold text-gray-800 mb-4 mt-5">
            Test Result: <span class="text-purple-600">{{ test.title }}</span>
        </h1>

        <!-- Результат -->
        <div
            class="bg-white shadow-md rounded-xl p-6 flex items-center justify-between border"
            :class="result.passed ? 'border-green-400' : 'border-red-400'"
        >
            <div>
                <p class="text-lg font-medium text-gray-600">Your Score</p>
                <p
                    class="text-4xl font-bold"
                    :class="result.passed ? 'text-green-600' : 'text-red-600'"
                >
                    {{ result.score }}%
                </p>
            </div>
            <div>
        <span
            class="px-4 py-2 text-lg font-semibold rounded-full"
            :class="result.passed
            ? 'bg-green-100 text-green-700'
            : 'bg-red-100 text-red-700'"
        >
          {{ result.passed ? 'Passed ✅' : 'Failed ❌' }}
        </span>
            </div>
        </div>

        <!-- Деталі питань -->
        <div v-if="detail.length" class="mt-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">
                Question Breakdown
            </h2>

            <div class="space-y-4">
                <div
                    v-for="d in detail"
                    :key="d.question_id"
                    class="bg-white shadow-sm border rounded-lg p-4 flex justify-between items-center"
                >
                    <div>
                        <p class="font-medium text-gray-700">
                            Question #{{ d.question_id }}
                        </p>
                        <p class="text-sm text-gray-500">
                            Score: {{ d.awarded }}/{{ d.max_score }}
                        </p>
                    </div>
                    <span
                        class="px-3 py-1 text-sm font-semibold rounded-full"
                        :class="d.awarded === d.max_score
              ? 'bg-green-100 text-green-700'
              : d.awarded > 0
                ? 'bg-yellow-100 text-yellow-700'
                : 'bg-red-100 text-red-700'"
                    >
            {{ d.awarded === d.max_score
                        ? 'Correct'
                        : d.awarded > 0
                            ? 'Partial'
                            : 'Wrong' }}
          </span>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import Navigation from "@/Components/Navigation.vue";

const props = defineProps({
    test: Object,
    result: Object,
    detail: Array,
    lessonLink: String,
    lessonName: String
})
</script>
