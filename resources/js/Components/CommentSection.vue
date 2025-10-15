<script setup>
import { computed, ref } from 'vue'
import { router } from '@inertiajs/vue3'
import Stars from '@/Components/Stars.vue'

const props = defineProps({
    reviews: { type: Array, default: () => [] },
    modelId: { type: Number, required: true },
    type: { type: String, required: true },
    owned: { type: Boolean, default: false },
    userId: { type: Number, required: true },
    is_rated: { type: Boolean, default: true },
})

const reviewComment = ref('')
const reviewRating = ref(0)
const editingReview = ref(null)
const hoverRating = ref(0)

const userReview = computed(() =>
    props.reviews.find(r => r.user_id === props.userId)
)

function submitReview() {
    let key = props.type === 'lessons' ? 'lesson_id' : 'course_id'
    if (!props.owned) return

    router.post(route(`${props.type}.reviews.store`, props.modelId), {
        [key]: props.modelId,
        comment: reviewComment.value,
        rating: reviewRating.value
    }, {
        preserveScroll: true,
        onSuccess: () => {
            reviewComment.value = ''
            reviewRating.value = 0
        }
    })
}

function updateReview(review) {
    router.put(route(`${props.type}.reviews.update`, review.id), {
        comment: review.comment,
        rating: review.rating
    }, {
        preserveScroll: true,
        onSuccess: () => editingReview.value = null
    })
}

function deleteReview(review) {
    router.delete(route(`${props.type}.reviews.destroy`, review.id), { preserveScroll: true })
}
</script>

<template>
    <section>
        <h2 class="text-xl font-semibold mb-4">Reviews</h2>

        <!-- List -->
        <div v-if="reviews?.length" class="space-y-4 mb-4">
            <div
                v-for="review in reviews"
                :key="review.id"
                class="p-4 bg-white border rounded-lg"
            >
                <p class="font-semibold">{{ review.user?.name || 'Anonymous' }}</p>
                <Stars :rating="review.rating" :size="14" v-if="is_rated" />

                <div v-if="editingReview === review.id">
                    <textarea
                        v-model="review.comment"
                        class="border rounded px-2 py-1 w-full mt-2"
                        rows="3"
                    ></textarea>

                    <div v-if="is_rated" class="flex items-center gap-1 mt-2">
                        <template v-for="star in 5" :key="star">
                            <svg
                                @click="review.rating = star"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                class="w-6 h-6 cursor-pointer transition-colors"
                                :class="star <= review.rating ? 'fill-yellow-400 text-yellow-400' : 'fill-gray-200 text-gray-300'"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.5"
                                    d="M11.48 3.499a.562.562 0 011.04 0l2.184 4.422a.563.563 0 00.424.308l4.882.709a.562.562 0 01.312.959l-3.531 3.446a.563.563 0 00-.162.498l.833 4.864a.562.562 0 01-.816.592l-4.37-2.296a.563.563 0 00-.524 0l-4.37 2.296a.562.562 0 01-.816-.592l.833-4.864a.563.563 0 00-.162-.498L2.68 9.897a.562.562 0 01.312-.959l4.882-.709a.563.563 0 00.424-.308l2.183-4.422z"
                                />
                            </svg>
                        </template>
                    </div>

                    <button
                        @click="updateReview(review)"
                        class="bg-green-500 text-white px-3 py-1 mt-2 rounded"
                    >
                        Save
                    </button>
                    <button
                        @click="editingReview = null"
                        class="ml-2 text-gray-600"
                    >
                        Cancel
                    </button>
                </div>

                <p v-else class="text-gray-600 mt-2">{{ review.comment }}</p>

                <!-- Actions -->
                <div v-if="review.user_id === userId" class="mt-2 flex gap-2">
                    <button
                        @click="editingReview = review.id"
                        class="text-blue-500"
                    >
                        Edit
                    </button>
                    <button
                        @click="deleteReview(review)"
                        class="text-red-500"
                    >
                        Delete
                    </button>
                </div>
            </div>
        </div>

        <p v-else class="text-gray-500 mb-4">No reviews yet.</p>

        <!-- Add Review -->
        <div v-if="owned" class="p-4 bg-white border rounded-lg">
            <h3 class="font-semibold mb-2">Add Your Review</h3>

            <div v-if="userReview">
                <p class="text-gray-600">
                    ✅ You already left a review. You can edit or delete it below.
                </p>
            </div>

            <div v-else class="flex flex-col gap-2">
                <div v-if="is_rated">
                    <p class="mb-1 font-medium">Your Rating:</p>
                    <div class="flex items-center gap-1">
                        <template v-for="star in 5" :key="star">
                            <svg
                                @mouseenter="hoverRating = star"
                                @mouseleave="hoverRating = 0"
                                @click="reviewRating = star"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                class="w-8 h-8 cursor-pointer transition-colors"
                                :class="star <= (hoverRating || reviewRating) ? 'fill-yellow-400 text-yellow-400' : 'fill-gray-200 text-gray-300'"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.5"
                                    d="M11.48 3.499a.562.562 0 011.04 0l2.184 4.422a.563.563 0 00.424.308l4.882.709a.562.562 0 01.312.959l-3.531 3.446a.563.563 0 00-.162.498l.833 4.864a.562.562 0 01-.816.592l-4.37-2.296a.563.563 0 00-.524 0l-4.37 2.296a.562.562 0 01-.816-.592l.833-4.864a.563.563 0 00-.162-.498L2.68 9.897a.562.562 0 01.312-.959l4.882-.709a.563.563 0 00.424-.308l2.183-4.422z"
                                />
                            </svg>
                        </template>
                    </div>
                </div>

                <textarea
                    v-model="reviewComment"
                    class="border rounded px-2 py-1 w-full"
                    rows="3"
                    placeholder="Write your review..."
                ></textarea>

                <button
                    @click="submitReview"
                    class="bg-blue-500 text-white px-3 py-2 rounded hover:bg-blue-600 mt-1"
                >
                    Submit
                </button>
            </div>
        </div>
    </section>
</template>
