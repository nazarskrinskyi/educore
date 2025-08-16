<script setup>
import { onMounted, ref, defineProps } from 'vue'
import { loadStripe } from '@stripe/stripe-js'

defineProps(['cart', 'client_secret'])

const stripe = ref(null)
const elements = ref(null)
const card = ref(null)

onMounted(async () => {
    stripe.value = await loadStripe(import.meta.env.VITE_STRIPE_KEY)
    elements.value = stripe.value.elements()
    card.value = elements.value.create('card')
    card.value.mount('#card-element')
})

async function pay() {
    const {error} = await stripe.value.confirmCardPayment(client_secret, {
        payment_method: {card: card.value}
    })

    if(error) alert(error.message)
    else axios.post(route('cart.checkout')).then(r => console.log(r))
}
</script>

<template>
    <div>
        <h1>Checkout</h1>
        <p>Total: {{ cart.total }}$</p>
        <form @submit.prevent="pay">
            <div id="card-element"></div>
            <button type="submit">Pay</button>
        </form>
    </div>
</template>


