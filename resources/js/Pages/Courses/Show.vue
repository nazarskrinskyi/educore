<script setup>
import {computed, ref} from 'vue'
import {Link} from '@inertiajs/vue3'
import AddToCartButton from '@/Components/Cart/AddToCartButton.vue'
import Stars from '@/Components/Stars.vue'
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import CommentSection from "@/Components/CommentSection.vue";

const props = defineProps({
    course: { type: Object, required: true },
    cart: { type: [Object, Array], default: () => ({}) }
})

const totalStudents = computed(() => props.course?.students?.length || 0)

const openSections = ref([])

function toggleSection(sectionId) {
    if (openSections.value.includes(sectionId)) {
        openSections.value = openSections.value.filter(id => id !== sectionId)
    } else {
        openSections.value.push(sectionId)
    }
}

const allLessons = computed(() => {
    if (!props.course?.sections) return []
    return props.course.sections.flatMap(s => s.lessons || [])
})
const totalLessons = computed(() => allLessons.value.length)
</script>

<template>
    <Head :title="course.title" />

    <AuthenticatedLayout>
        <div class="bg-gray-50 min-h-screen">
            <!-- Hero Header -->
            <div class="bg-gray-900 text-white py-10 px-6">
                <div class="max-w-6xl mx-auto">
                    <h1 class="text-3xl font-bold mb-3">{{ course.title }}</h1>
                    <p class="text-lg mb-4">{{ course.description?.slice(0, 150) }}...</p>

                    <div class="flex items-center gap-4 text-sm text-gray-300">
              <span class="flex items-center gap-1">
               <Stars :rating="course.rating" :size="14"/>
              </span>
                        <span>({{ course.reviews?.length || 0 }} reviews)</span>
                        <span>{{ totalStudents }} students enrolled</span>
                        <span>• {{ course.category?.name }}</span>
                    </div>
                    <p class="mt-2">Instructor: <strong>{{ course.instructor?.name }}</strong></p>
                </div>
            </div>

            <!-- Main Content -->
            <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8 py-8 px-6">
                <!-- Left Column -->
                <div class="md:col-span-2 space-y-8">
                    <!-- Video Preview -->
                    <div v-if="course.video_path" class="aspect-video rounded-lg overflow-hidden bg-black">
                        <video controls class="w-full h-full">
                            <source :src="course.video_path" type="video/mp4" />
                            Your browser does not support the video tag.
                        </video>
                    </div>

                    <!-- Description -->
                    <section>
                        <h2 class="text-xl font-semibold mb-2">Course Description</h2>
                        <p class="text-gray-700">{{ course.description }}</p>
                    </section>

                    <!-- Lessons Accordion -->
                    <section>
                        <h2 class="text-xl font-semibold mb-2">Course Content ({{ totalLessons }} lessons)</h2>
                        <div class="space-y-2">
                            <div v-for="section in course.sections" :key="section.id" class="border rounded-lg bg-white">
                                <!-- Section Title -->
                                <button
                                    class="w-full text-left p-3 flex justify-between items-center font-semibold"
                                    @click="toggleSection(section.id)"
                                >
                                    {{ section.title }}
                                    <span>{{ openSections.includes(section.id) ? '-' : '+' }}</span>
                                </button>

                                <!-- Lessons List -->
                                <ul v-show="openSections.includes(section.id)" class="border-t divide-y">
                                    <li
                                        v-for="lesson in section.lessons"
                                        :key="lesson.id"
                                        class="p-3 flex items-center justify-between"
                                    >
                                        <span>{{ lesson.title }}</span>
                                        <span class="text-sm text-gray-500">{{ lesson.views }} views</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </section>

                    <!-- Tags -->
                    <section>
                        <h2 class="text-xl font-semibold mb-2">Tags</h2>
                        <div class="flex flex-wrap gap-2">
                            <Link
                                v-for="tag in course.tags"
                                :key="tag.id"
                                class="bg-gray-200 px-2 py-1 text-xs rounded"
                                href="#"
                            >
                                {{ tag.name }}
                            </Link>
                        </div>
                    </section>

                    <!-- Reviews Section -->
                    <CommentSection
                        :reviews="course.reviews"
                        :model-id="course.id"
                        type="courses"
                        :owned="course.owned"
                        :user-id="$page.props.auth.user.id"
                    />
                </div>

                <!-- Right Sidebar -->
                <div class="space-y-6">
                    <div class="bg-white border rounded-lg shadow p-6 sticky top-6">
                        <img :src="course.image_url" alt="Course image" class="w-full h-40 object-cover rounded mb-4" />
                        <p class="text-2xl font-bold mb-2">
                            UAH {{ course.is_free ? 'Free' : course.price_formatted }}
                        </p>
                        <div v-if="course.owned" class="mb-5">
                            <Link
                                :href="route('courses.player', { course: course.slug, lesson: course.sections[0].lessons[0].slug })"
                                class="px-3 py-2 bg-green-500 text-white rounded hover:bg-green-600"
                            >
                                Go to Course
                            </Link>
                        </div>
                        <div v-else>
                            <AddToCartButton :course="course" :cart="cart" class="w-full mb-3" />
                        </div>
                        <p class="text-sm text-gray-500">30-Day Money-Back Guarantee</p>
                    </div>

                    <!-- Extra Info -->
                    <div class="bg-white border rounded-lg p-6">
                        <h3 class="font-semibold mb-2">Course Details</h3>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li>📊 Level: {{ course.level }}</li>
                            <li>⏱ Duration: {{ course.duration }}</li>
                            <li>👨‍🎓 Students: {{ totalStudents }}</li>
                            <li>👀 Views: {{ course.views }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
