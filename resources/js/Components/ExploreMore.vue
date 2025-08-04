<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";

defineProps({
    title: {
        type: String,
    },
    text: {
        type: String,
    },
    usp: {
        type: Array,
        validator(value) {
            return value.every(
                (item) => typeof item === 'string'
            );
        }
    },
    listName: {
        type: String,
    },
    buttonName: {
        type: String,
    },
});
</script>

<template>
    <div class="flex flex-col w-1/2 mt-5">
        <div class="text-2xl bold text-blue-500 mb-3">{{ title }}</div>
        <div class="text-lg">{{ text }}</div>
        <div class="flex flex-col sm:mt-5 gap-3">
            <div class="text-2xl bold justify-self-start font-bold">{{ listName }}</div>
            <ul class="flex flex-col gap-4 list-disc ml-5" v-for="item in usp">
                <li>{{ item }}</li>
            </ul>
        </div>
        <div class="mt-5">
            <PrimaryButton class="gap-2">
                {{ buttonName }}
                <span class="text-xl">→</span>
            </PrimaryButton>
        </div>
    </div>
</template>

<style scoped>

</style>
