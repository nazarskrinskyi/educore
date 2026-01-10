import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import axios from 'axios'

/**
 * Composable for managing Stripe payment integration
 * @param {string} clientSecret - Stripe client secret for payment intent
 * @returns {Object} Stripe state and methods
 */
export function useStripe(clientSecret) {
    const cardElement = ref(null)
    const isProcessing = ref(false)
    const error = ref(null)
    let stripe = null
    let card = null

    /**
     * Initialize Stripe elements
     * @param {string} stripeKey - Stripe publishable key
     */
    function initStripe(stripeKey) {
        try {
            stripe = Stripe(stripeKey)
            const elements = stripe.elements()

            card = elements.create('card', {
                style: {
                    base: {
                        fontSize: '16px',
                        color: '#32325d',
                        fontFamily: '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif',
                        '::placeholder': { color: '#a0aec0' }
                    },
                    invalid: {
                        color: '#e53e3e',
                        iconColor: '#e53e3e'
                    }
                }
            })

            if (cardElement.value) {
                card.mount(cardElement.value)

                // Listen for card validation errors
                card.on('change', (event) => {
                    error.value = event.error ? event.error.message : null
                })
            }
        } catch (err) {
            console.error('Failed to initialize Stripe:', err)
            error.value = 'Failed to initialize payment system'
        }
    }

    /**
     * Handle payment submission
     * @returns {Promise<void>}
     */
    async function handleSubmit() {
        if (!stripe || !card) {
            error.value = 'Payment system is not ready yet'
            return
        }

        if (isProcessing.value) return

        isProcessing.value = true
        error.value = null

        try {
            const { error: stripeError, paymentIntent } = await stripe.confirmCardPayment(clientSecret, {
                payment_method: { card }
            })

            if (stripeError) {
                console.error('Stripe payment error:', stripeError)
                error.value = stripeError.message
                return
            }

            if (paymentIntent?.status === 'succeeded') {
                try {
                    const res = await axios.post(route('checkout.order'), {
                        payment_intent_id: paymentIntent.id
                    })

                    if (res.data.error) {
                        error.value = 'Something went wrong while saving the order'
                    } else {
                        router.visit(route('checkout.success'))
                    }
                } catch (err) {
                    console.error('Order creation error:', err)
                    error.value = 'Error while saving the order'
                }
            }
        } catch (err) {
            console.error('Payment processing error:', err)
            error.value = 'An unexpected error occurred'
        } finally {
            isProcessing.value = false
        }
    }

    return {
        cardElement,
        isProcessing,
        error,
        initStripe,
        handleSubmit
    }
}
