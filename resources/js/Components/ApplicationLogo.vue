<script setup>
    defineProps({
        styles: {
            type: String,
            default: "w-auto fill-current",
        },
    });
</script>
<template>
    <img
        :class="styles"
        src="../assets/logo.png"
        alt="logo"
    />
</template>
