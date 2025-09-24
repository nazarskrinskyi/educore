<script setup>
import { onMounted } from 'vue'
import { useStripe } from '@/composables/useStripe'

const props = defineProps({
    cart: { type: [Array, Object], default: () => [] },
    client_secret: { type: String, required: true },
    total: { type: Number, default: 0 }
})

const { cardElement, initStripe, handleSubmit } = useStripe(props.client_secret)

onMounted(() => {
    initStripe(import.meta.env.VITE_STRIPE_KEY)
})
</script>

<template>
    <div class="max-w-lg mx-auto mt-10 p-6 bg-white shadow rounded">
        <h1 class="text-xl font-bold mb-4">Оформлення замовлення</h1>

        <ul class="mb-4">
            <li v-for="item in cart" :key="item.id" class="flex justify-between py-2 border-b">
                <span>{{ item.name }}</span>
                <span>{{ item.price }} ₴</span>
            </li>
        </ul>

        <div class="text-right font-bold mb-4">
            Всього: {{ total }} ₴
        </div>

        <div ref="cardElement" class="p-3 border rounded mb-4"></div>

        <button @click="handleSubmit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
            Оплатити {{ total }} ₴
        </button>
    </div>
</template>
