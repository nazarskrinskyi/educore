<script setup>
const props = defineProps({
    question: { type: Object, required: true },
    value: { type: Object, required: true }
})
const emit = defineEmits(['update'])

function pick(val) {
    const tfTrue = props.question.answers.find(a => (a.answer_text || '').toLowerCase().trim() === 'true')
    const tfFalse = props.question.answers.find(a => (a.answer_text || '').toLowerCase().trim() === 'false')
    const id = val ? tfTrue?.id : tfFalse?.id
    emit('update', { question_id: props.question.id, selected_answer_id: id ?? null, bool: !!val })
}
</script>

<template>
    <div class="flex gap-3">
        <button
            class="px-4 py-2 rounded-xl border hover:bg-gray-50"
            :class="value?.bool === true ? 'ring-2 ring-indigo-500' : ''"
            @click="pick(true)"
        >True</button>
        <button
            class="px-4 py-2 rounded-xl border hover:bg-gray-50"
            :class="value?.bool === false ? 'ring-2 ring-indigo-500' : ''"
            @click="pick(false)"
        >False</button>
    </div>
</template>
