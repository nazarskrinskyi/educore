<script setup>
import {ref, watchEffect} from 'vue'

const props = defineProps({
    message: { type: String, default: '' },
    type: { type: String, default: 'success' },
    duration: { type: Number, default: 4000 }
})


const visible = ref(false)
const localMessage = ref('')

watchEffect(() => {
    if (props.message) {
        localMessage.value = props.message
        visible.value = true
        setTimeout(() => {
            visible.value = false
            localMessage.value = ''
        }, props.duration)
    }
})
</script>

<template>
    <transition name="fade">
        <div
            v-if="visible"
            class="fixed left-1/2 -translate-x-1/2 max-w-[90%] w-auto z-50 px-6 py-4 rounded-lg shadow-lg text-white font-semibold"
            :class="{
            'bg-green-500': props.type === 'success',
            'bg-red-500': props.type === 'error',
            'bg-blue-500': props.type === 'info'
    }"
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
