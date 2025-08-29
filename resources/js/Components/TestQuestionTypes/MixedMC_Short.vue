<script setup>
import { ref, watch } from 'vue'
const props = defineProps({ question: Object, value: Object })
const emit = defineEmits(['update'])

function choose(id) {
    emit('update', { question_id: props.question.id, selected_answer_id: id })
}
const text = ref(props.value?.text ?? '')
watch(text, (v) => emit('update', { question_id: props.question.id, text: v }))
</script>

<template>
    <div class="space-y-6">
        <div class="space-y-2">
            <label v-for="a in question.answers" :key="a.id" class="flex items-center gap-3 p-3 border rounded-xl hover:bg-gray-50 cursor-pointer">
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

        <div>
            <div class="text-sm font-medium mb-2">Explain:</div>
            <textarea v-model="text" rows="4" class="w-full rounded-xl border p-3" placeholder="Why did you choose this?" />
        </div>
    </div>
</template>
