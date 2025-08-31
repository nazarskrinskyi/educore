<script setup>
const props = defineProps({
    question: { type: Object, required: true },
    value: { type: Object, required: true }
})
const emit = defineEmits(['update'])

function toggle(answerId) {
    const current = Array.isArray(props.value.selected_answer_ids)
        ? props.value.selected_answer_ids
        : []

    const selected = new Set(current)

    if (selected.has(answerId)) {
        selected.delete(answerId)
    } else {
        selected.add(answerId)
    }

    emit('update', {
        question_id: props.question.id,
        selected_answer_ids: Array.from(selected)
    })
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
                type="checkbox"
                class="accent-indigo-600"
                :checked="value?.selected_answer_ids?.includes(a.id)"
                @change="toggle(a.id)"
            />
            <span>{{ a.answer_text }}</span>
        </label>
    </div>
</template>
