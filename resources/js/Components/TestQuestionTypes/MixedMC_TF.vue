<script setup>
const props = defineProps({ question: Object, value: Object })
const emit = defineEmits(['update'])

function chooseMC(id) {
    emit('update', { question_id: props.question.id, selected_answer_id: id })
}
function chooseTF(val) {
    const tfTrue = props.question.answers.find(a => (a.answer_text || '').toLowerCase().trim() === 'true')
    const tfFalse = props.question.answers.find(a => (a.answer_text || '').toLowerCase().trim() === 'false')
    const id = val ? tfTrue?.id : tfFalse?.id
    emit('update', { question_id: props.question.id, bool: !!val, selected_answer_id: (value?.selected_answer_id ?? null) }) // keep MC as is, bool separately
    emit('update', { question_id: props.question.id, bool: !!val })
}
</script>

<template>
    <div class="space-y-6">
        <div class="space-y-2">
            <label v-for="a in question.answers.filter(a => (a.answer_text || '').toLowerCase().trim() !== 'true' && (a.answer_text || '').toLowerCase().trim() !== 'false')" :key="a.id"
                   class="flex items-center gap-3 p-3 border rounded-xl hover:bg-gray-50 cursor-pointer">
                <input type="radio" class="accent-indigo-600" :name="`mc-${question.id}`"
                       :checked="value?.selected_answer_id === a.id"
                       @change="chooseMC(a.id)" />
                <span>{{ a.answer_text }}</span>
            </label>
        </div>

        <div class="flex gap-3">
            <button class="px-4 py-2 rounded-xl border hover:bg-gray-50" :class="value?.bool === true ? 'ring-2 ring-indigo-500' : ''" @click="chooseTF(true)">True</button>
            <button class="px-4 py-2 rounded-xl border hover:bg-gray-50" :class="value?.bool === false ? 'ring-2 ring-indigo-500' : ''" @click="chooseTF(false)">False</button>
        </div>
    </div>
</template>
