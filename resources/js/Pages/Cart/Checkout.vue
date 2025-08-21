<script setup>
import { onMounted, ref } from 'vue'
import axios from 'axios'

const props = defineProps({
    cart: Array,
    client_secret: String,
    total: Number,
})

const cardElement = ref(null)
let stripe, elements, card

onMounted(() => {
    stripe = Stripe(import.meta.env.VITE_STRIPE_KEY)
    elements = stripe.elements()

    card = elements.create('card', {
        style: { base: { fontSize: '16px', color: '#32325d' } }
    })
    card.mount(cardElement.value)
})

async function handleSubmit() {
    const { error, paymentIntent } = await stripe.confirmCardPayment(props.client_secret, {
        payment_method: { card: card }
    })

    if (error) {
        alert(error.message)
        return
    }

    if (paymentIntent.status === 'succeeded') {
        await axios.post(route('checkout.order'), {
            payment_intent_id: paymentIntent.id
        })

        window.location.href = route('checkout.success')
    }
}
</script>

<template>
    <div class="max-w-lg mx-auto mt-10 p-6 bg-white shadow rounded">
        <h1 class="text-xl font-bold mb-4">Оформлення замовлення</h1>

        <ul class="mb-4">
            <li v-for="item in cart" :key="item.id" class="flex justify-between py-2 border-b">
                <span>{{ item.name }}</span>
                <span>${{ item.price }}</span>
            </li>
        </ul>

        <div class="text-right font-bold mb-4">
            Всього: ${{ total }}
        </div>

        <div ref="cardElement" class="p-3 border rounded mb-4"></div>

        <button @click="handleSubmit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
            Оплатити ${{ total }}
        </button>
    </div>
</template>
