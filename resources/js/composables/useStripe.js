import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import axios from 'axios'

export function useStripe(clientSecret) {
    const cardElement = ref(null)
    let stripe = null
    let card = null

    function initStripe(stripeKey) {
        stripe = Stripe(stripeKey)
        const elements = stripe.elements()

        card = elements.create('card', {
            style: {
                base: {
                    fontSize: '16px',
                    color: '#32325d',
                    '::placeholder': { color: '#a0aec0' }
                }
            }
        })

        if (cardElement.value) {
            card.mount(cardElement.value)
        }
    }

    async function handleSubmit() {
        if (!stripe || !card) {
            alert('Платіжна система ще не готова')
            return
        }

        const { error, paymentIntent } = await stripe.confirmCardPayment(clientSecret, {
            payment_method: { card }
        })

        if (error) {
            console.error(error)
            alert(error.message)
            return
        }

        if (paymentIntent?.status === 'succeeded') {
            try {
                const res = await axios.post(route('checkout.order'), {
                    payment_intent_id: paymentIntent.id
                })

                if (res.data.error) {
                    alert('Щось пішло не так при збереженні замовлення')
                } else {
                    router.visit(route('checkout.success'))
                }
            } catch (e) {
                console.error(e)
                alert('Помилка при збереженні замовлення')
            }
        }
    }

    return { cardElement, initStripe, handleSubmit }
}
