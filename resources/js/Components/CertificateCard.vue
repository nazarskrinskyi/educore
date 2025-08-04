<script setup>
defineProps({
    title: {
        type: String,
    },
    text: {
        type: String,
    },
    image: {
        type: String,
    },
    tags: {
        type: Array,
        default: () => []
    },
    height: {
        type: String,
        default: '100%'
    },
    maxWidth: {
        type: String,
        default: '100%'
    }
})
</script>

<template>
    <div class="certificate w-4/12 bg-white rounded-xl p-4 shadow-xl">
        <img class="mx-auto" :src="image" alt="">
        <div class="text-center">
            <h3 class="text-secondary font-bold text-center text-3xl">{{ title }}</h3>
            <p class="text-primary text-lg font-normal my-6 text-center">{{ text }}</p>
            <div class="flex justify-center gap-4">
                <span class="text-primary text-lg font-normal px-4 py-2 bg-[#00C0FE3D] rounded-full inline-block mb-3" v-for="tag in tags">
                  {{ tag }}
                </span>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
