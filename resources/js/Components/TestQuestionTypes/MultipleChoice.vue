<script setup>
const props = defineProps({
    question: { type: Object, required: true },
    value: { type: Object, required: true }
})
const emit = defineEmits(['update'])

function choose(answerId) {
    emit('update', { question_id: props.question.id, selected_answer_id: answerId })
}
</script>

<template>
    <div class="space-y-2">
        <label
            v-for="a in question.answers"
            :key="a.id"
            class="flex items-center gap-3 p-3 border rounded-xl hover:bg-gray-50 cursor-pointer"
        >
            <input
                type="radio"
                class="accent-indigo-600"
                :name="`q-${question.id}`"
                :checked="value?.selected_answer_id === a.id"
                @change="choose(a.id)"
            />
            <span>{{ a.answer_text }}</span>
        </label>
    </div>
</template>
