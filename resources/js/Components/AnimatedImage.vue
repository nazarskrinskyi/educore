<script setup>
defineProps({
    background: {
        type: String,
        required: false,
        default: '',
    },
    backgroundImage: {
        type: String,
        required: true,
    },
    gifImage: {
        type: String,
        required: true,
    },
})
</script>

<template>
    <div class="w-full">
        <div class="relative">
            <img v-if="background" class="object-contain mx-auto w-full z-0" :src="background" alt="">
            <img class="absolute top-0 object-contain mx-auto w-full z-10" :src="backgroundImage" alt="">
            <img class="absolute bottom-0 object-contain mx-auto w-full z-10" :src="gifImage" alt="">
        </div>
    </div>
</template>

<style scoped>

</style>
