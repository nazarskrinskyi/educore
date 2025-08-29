<script setup>
import { ref, watch } from 'vue'
const props = defineProps({ question: Object, value: Object })
const emit = defineEmits(['update'])
const text = ref(props.value?.text ?? '')
watch(text, (v) => emit('update', { question_id: props.question.id, text: v }))
</script>

<template>
    <input
        v-model="text"
        type="text"
        class="w-full rounded-xl border p-3"
        placeholder="Your short answer..."
    />
</template>
