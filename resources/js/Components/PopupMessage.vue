<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
    message: { type: String, default: '' },
    type: { type: String, default: 'success' },
    duration: { type: Number, default: 4000 }
})

const visible = ref(false)
const localMessage = ref('')

// слідкуємо за зміни пропса
watch(
    () => props.message,
    (newVal) => {
        if (newVal && newVal.length > 0) {
            localMessage.value = newVal
            visible.value = true
            setTimeout(() => {
                visible.value = false
                localMessage.value = ''
            }, props.duration)
        }
    }
)
</script>

<template>
    <transition name="fade">
        <div
            v-if="visible"
            :class="[
                'fixed top-5 right-5 z-50 px-6 py-4 rounded-lg shadow-lg text-white font-semibold',
                props.type === 'success' ? 'bg-green-500' : '',
                props.type === 'error' ? 'bg-red-500' : '',
                props.type === 'info' ? 'bg-blue-500' : ''
            ]"
        >
            {{ localMessage }}
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
