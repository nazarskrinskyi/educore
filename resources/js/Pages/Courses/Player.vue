<script setup>
import { ref } from "vue";
import {Head, router} from "@inertiajs/vue3";
import CommentSection from "@/Components/CommentSection.vue";
import TestCard from "@/Components/TestCard.vue";

const props = defineProps({
    course: Object,
    lesson: Object,
});

const activeTab = ref("overview");
const completed = ref(!!props.lesson.completed_at);

function toggleCompletion(lessonItem) {
    router.post(
        route("lessons.toggle", lessonItem.id),
        {},
        {
            preserveScroll: true,
            onSuccess: () => {
                lessonItem.completed = !lessonItem.completed;
            },
        }
    );
}

function markCompleted() {
    router.post(route("lessons.complete", props.lesson.id), {}, {
        preserveScroll: true,
        onSuccess: () => completed.value = true,
    });
}

function onVideoProgress(e) {
    const video = e.target;
    if (!completed.value && video.currentTime / video.duration > 0.9) {
        markCompleted();
    }
}
</script>

<template>
    <Head :title="`${props.course.title} | ${props.lesson.title}`" />

    <div class="flex h-screen bg-gray-100">
        <!-- Video Section -->
        <div class="flex-1 flex flex-col">
            <div class="flex-1 bg-black flex items-center justify-center">
                <video
                    class="w-full h-full"
                    controls
                    :src="props.lesson.video_path ? `/storage/${props.lesson.video_path}` : ''"
                    @timeupdate="onVideoProgress"
                ></video>
            </div>

            <!-- Tabs (bottom bar) -->
            <div class="bg-white shadow px-6 py-3 border-t">
                <div class="flex space-x-6 text-gray-600">
                    <button
                        @click="activeTab = 'overview'"
                        :class="activeTab === 'overview' ? 'font-bold text-indigo-600' : ''"
                    >
                        Overview
                    </button>
                    <button
                        @click="activeTab = 'comments'"
                        :class="activeTab === 'comments' ? 'font-bold text-indigo-600' : ''"
                    >
                        Comments
                    </button>
                    <button
                        @click="activeTab = 'tests'"
                        :class="activeTab === 'tests' ? 'font-bold text-indigo-600' : ''"
                    >
                        Tests
                    </button>
                </div>
            </div>

            <!-- Tab content -->
            <div class="p-6 overflow-y-auto h-64 bg-white">
                <div v-if="activeTab === 'overview'">
                    <h2 class="text-xl font-semibold mb-2">About this course</h2>
                    <p>{{ props.course.description }}</p>
                </div>
                <div v-if="activeTab === 'comments'">
                    <CommentSection
                        :reviews="lesson.reviews"
                        :model-id="lesson.id"
                        type="lessons"
                        :owned="course.owned"
                        :user-id="$page.props.auth.user.id"
                        :is_rated="false"
                    />
                </div>
                <div v-if="activeTab === 'tests'">
                    <h2 class="text-xl font-semibold mb-4">Tests</h2>

                    <div v-if="lesson.tests.length" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <TestCard
                            v-for="test in lesson.tests"
                            :key="test.id"
                            :test="test"
                        />
                    </div>

                    <div v-else class="text-gray-500">Тестів поки немає.</div>
                </div>
            </div>
        </div>

        <!-- Sidebar (Sections & Lessons) -->
        <div class="w-80 bg-white border-l overflow-y-auto">
            <div class="p-4 border-b">
                <h2 class="text-lg font-semibold">{{ props.course.title }}</h2>
            </div>
            <div>
                <div v-for="section in props.course.sections" :key="section.id" class="border-b">
                    <h3 class="px-4 py-2 font-medium bg-gray-50">{{ section.title }}</h3>
                    <ul>
                        <li
                            v-for="lessonItem in section.lessons"
                            :key="lessonItem.id"
                            class="px-4 py-2 hover:bg-gray-100 flex items-center justify-between"
                        >
                            <!-- Lesson link -->
                            <a
                                :href="route('courses.player', { course: props.course.slug, lesson: lessonItem.slug })"
                                class="flex-1 text-sm"
                                :class="lessonItem.id === props.lesson.id ? 'font-semibold text-indigo-600' : ''"
                            >
                                {{ lessonItem.title }}
                            </a>

                            <!-- Checkbox -->
                            <input
                                type="checkbox"
                                v-model="lessonItem.completed"
                                :checked="lessonItem.completed_at !== null"
                                @change="toggleCompletion(lessonItem)"
                            />
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>
