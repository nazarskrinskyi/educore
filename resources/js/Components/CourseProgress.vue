<script setup>
import CircleProgress from 'vue3-circle-progress'
import 'vue3-circle-progress/dist/circle-progress.css'
import {ref, onMounted, onUnmounted} from 'vue'
import axios from 'axios'
import { mitt } from '@/utils/eventBus'

const props = defineProps({ courseId: Number })
const progress = ref(0)

const fetchProgress = async () => {
    try {
        const res = await axios.get(`/api/courses/${props.courseId}/progress`)
        progress.value = res.data.progress_percent || 0
    } catch (e) {
        console.error('Failed to fetch progress:', e)
    }
}

onMounted(() => {
    fetchProgress()
    // Listen for lesson completion events
    mitt.on('lesson-completed', fetchProgress)
})

onUnmounted(() => {
    // Clean up event listener
    mitt.off('lesson-completed', fetchProgress)
})
</script>

<template>
    <div class="absolute top-1 right-1">
        <CircleProgress
            :size="56"
            :border-width="6"
            :animation="true"
            :percent="progress"
            empty-color="transparent"
            :is-gradient="true"
            :show-percent="true"
            :text-style="{
        fontSize: '12px',
        fontWeight: '600',
        color: 'var(--color-text)'
      }"
        />
    </div>
</template>

<style scoped>
:root {
    --color-text: #111;
}
.dark {
    --color-text: #f5f5f5;
}
</style>
