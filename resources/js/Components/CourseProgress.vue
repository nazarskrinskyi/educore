<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const props = defineProps({
    courseId: Number
});

const progress = ref(0);

const fetchProgress = async () => {
    const res = await axios.get(`/api/courses/${props.courseId}/progress`);
    progress.value = res.data.progress_percent || 0;
};

onMounted(fetchProgress);
</script>

<template>
    <div class="w-full bg-gray-200 rounded-lg h-4 mt-2">
        <div
            class="bg-green-500 h-4 rounded-lg"
            :style="{ width: progress + '%' }"
        ></div>
    </div>
    <p class="text-sm text-gray-700 mt-1">{{ progress }}%</p>
</template>
