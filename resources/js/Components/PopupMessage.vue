<script setup>
import {ref, watch, defineProps} from 'vue';

defineProps({
    message: String,
    type: {
        type: String,
        default: 'success',
    },
    duration: {
        type: Number,
        default: 4000,
    }
});

const visible = ref(false);

watch(
    () => message,
    (newVal) => {
        if (newVal) {
            visible.value = true;
            setTimeout(() => visible.value = false, duration);
        }
    }
);
</script>

<template>
    <transition name="fade">
        <div v-if="visible"
             :class="[
                'fixed top-5 right-5 z-50 px-6 py-4 rounded-lg shadow-lg text-white font-semibold',
                type === 'success' ? 'bg-green-500' : '',
                type === 'error' ? 'bg-red-500' : '',
                type === 'info' ? 'bg-blue-500' : ''
             ]">
            {{ message }}
        </div>
    </transition>
</template>

<style scoped>
.fade-enter-active, .fade-leave-active {
    transition: opacity 0.4s ease;
}
.fade-enter-from, .fade-leave-to {
    opacity: 0;
}
</style>
