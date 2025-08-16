<script setup>
import { ref, computed } from 'vue'
import { Link, router } from '@inertiajs/vue3'

const { cart } = defineProps({
    cart: { type: Array, default: () => [] }
});

const open = ref(false);
const cartCount = computed(() => cart.length);
const total = computed(() =>
    cart.reduce((sum, i) => Number(sum) + Number(i.price), 0)
);

function removeFromCart(id) {
    router.post(route('cart.remove', id), {}, { preserveScroll: true })
}
</script>

<template>
    <div class="relative">
        <button @click="open = !open" class="flex items-center bg-gray-800 text-white px-4 py-2 rounded">
            🛒 Корзина ({{ cartCount }})
        </button>

        <div v-if="open" class="absolute right-0 mt-2 w-[400px] bg-white shadow-xl rounded-lg p-4 z-50">
            <div v-if="cart.length">
                <div
                    v-for="item in cart"
                    :key="item.id"
                    class="flex mb-4 border-b pb-3"
                >
                    <!-- Картинка курсу -->
                    <img
                        :src="item.image"
                        alt="Course image"
                        class="w-24 h-16 object-cover rounded mr-3"
                    />

                    <div class="flex-1">
                        <!-- Назва -->
                        <span class="block font-semibold text-gray-800 line-clamp-2">
                            {{ item.name }}
                        </span>

                        <!-- Автор -->
                        <span class="block text-sm text-gray-600">
                            Автор: {{ item.instructor }}
                        </span>

                        <!-- Рейтинг і кількість відгуків -->
                        <div class="flex items-center text-yellow-500 text-sm">
                            ⭐ {{ item.rating }} <span class="text-gray-500 ml-1">({{ item.reviews_count }} оцінок)</span>
                        </div>

                        <!-- Тривалість -->
                        <span class="block text-xs text-gray-500">
                            {{ item.duration }}
                        </span>
                    </div>

                    <!-- Ціна і видалення -->
                    <div class="flex flex-col items-end">
                        <span class="font-bold">${{ Number(item.price) }}</span>
                        <button
                            @click="removeFromCart(item.id)"
                            class="text-red-500 hover:text-red-700 text-sm mt-2"
                        >
                            ✕
                        </button>
                    </div>
                </div>

                <!-- Total -->
                <div class="mt-2 font-bold text-right">
                    Всього: ${{ total }}
                </div>

                <!-- Checkout -->
                <Link
                    :href="route('cart.checkout')"
                    class="block mt-3 bg-blue-600 text-white text-center py-2 rounded hover:bg-blue-700"
                >
                    Перейти до оформлення
                </Link>
            </div>
            <div v-else class="text-gray-600">
                <p>Ваша корзина порожня</p>
            </div>
        </div>
    </div>
</template>
