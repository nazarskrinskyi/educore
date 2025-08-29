<script setup>
import { ref, watch } from 'vue'
const props = defineProps({ question: Object, value: Object })
const emit = defineEmits(['update'])

function pick(val) {
    const tfTrue = props.question.answers.find(a => (a.answer_text || '').toLowerCase().trim() === 'true')
    const tfFalse = props.question.answers.find(a => (a.answer_text || '').toLowerCase().trim() === 'false')
    const id = val ? tfTrue?.id : tfFalse?.id
    emit('update', { question_id: props.question.id, selected_answer_id: id ?? null, bool: !!val })
}
const text = ref(props.value?.text ?? '')
watch(text, (v) => emit('update', { question_id: props.question.id, text: v }))
</script>

<template>
    <div class="space-y-6">
        <div class="flex gap-3">
            <button class="px-4 py-2 rounded-xl border hover:bg-gray-50" :class="value?.bool === true ? 'ring-2 ring-indigo-500' : ''" @click="pick(true)">True</button>
            <button class="px-4 py-2 rounded-xl border hover:bg-gray-50" :class="value?.bool === false ? 'ring-2 ring-indigo-500' : ''" @click="pick(false)">False</button>
        </div>
        <div>
            <div class="text-sm font-medium mb-2">Explain:</div>
            <textarea v-model="text" rows="4" class="w-full rounded-xl border p-3" placeholder="Your explanation..." />
        </div>
    </div>
</template>
