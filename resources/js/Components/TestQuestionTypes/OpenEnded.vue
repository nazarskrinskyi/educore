<script setup>
import { ref, watch } from 'vue'
const props = defineProps({ question: Object, value: Object })
const emit = defineEmits(['update'])
const text = ref(props.value?.text ?? '')
watch(text, (v) => emit('update', { question_id: props.question.id, text: v }))
</script>

<template>
  <textarea
      v-model="text"
      rows="6"
      class="w-full rounded-xl border p-3"
      placeholder="Type your answer..."
  />
</template>
