<template>
    <div class="max-w-4xl mx-auto p-4">
        <h1 class="text-2xl font-bold">Test Result: {{ test.title }}</h1>
        <p>Score: {{ result.score }}%</p>
        <p>Status: {{ result.passed ? 'Passed' : 'Failed' }}</p>

        <div v-if="detail.length">
            <h2 class="mt-4 font-semibold">Question Details</h2>
            <ul>
                <li v-for="d in detail" :key="d.question_id">
                    Question ID: {{ d.question_id }},
                    Awarded: {{ d.awarded }}/{{ d.max_score }}
                </li>
            </ul>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    test: Object,
    result: Object,
    detail: Array
})
</script>
