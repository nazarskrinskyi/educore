<script setup>
import Navigation from "@/Components/Navigation.vue"
import QMultipleChoice from '@/Components/TestQuestionTypes/MultipleChoice.vue'
import QMultipleAnswer from '@/Components/TestQuestionTypes/MultipleAnswer.vue'
import QTrueFalse from '@/Components/TestQuestionTypes/TrueFalse.vue'
import QShortAnswer from '@/Components/TestQuestionTypes/ShortAnswer.vue'
import { useTest } from '@/composables/useTest'

const props = defineProps({
    test: { type: Object, required: true },
    previousAnswers: { type: [Array, Object, null], default: null },
    now: { type: String, default: null }
})

const {
    idx,
    total,
    current,
    answers,
    answeredCount,
    progress,
    submitting,
    QUESTION_TYPES,
    next,
    prev,
    jump,
    updateAnswer,
    handleSubmit,
    secondsToClock
} = useTest(props.test, props.previousAnswers)

const questionComponents = {
    [QUESTION_TYPES.MultipleChoice]: QMultipleChoice,
    [QUESTION_TYPES.MultipleAnswer]: QMultipleAnswer,
    [QUESTION_TYPES.TrueFalse]: QTrueFalse,
    [QUESTION_TYPES.ShortAnswer]: QShortAnswer,
}
</script>

<template>
    <div class="min-h-screen bg-gray-50">
        <!-- Header -->
        <header class="sticky top-0 z-10 bg-white border-b">
            <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
                <Navigation :links="[
                    {name: props.test.course.title, href: route('courses.show', props.test.course.slug)},
                    {name: props.test.lesson.title, href: route('courses.player', {course: props.test.course.slug, lesson: props.test.lesson.slug})}
                ]" />
                <div class="flex items-center gap-3">
                    <div v-if="test.image_url" class="w-10 h-10 overflow-hidden rounded-xl">
                        <img :src="test.image_url" alt="" class="w-full h-full object-cover" />
                    </div>
                    <div>
                        <h1 class="text-xl font-semibold">{{ test.title }}</h1>
                    </div>
                </div>
                <div class="flex items-center gap-6">
                    <div class="w-56">
                        <div class="text-xs text-gray-500 mb-1">Progress</div>
                        <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-2 rounded-full" :style="{ width: progress + '%' }" />
                        </div>
                        <div class="text-xs text-gray-600 mt-1">{{ answeredCount }} / {{ total }}</div>
                    </div>
                    <div v-if="hasTimer" class="px-3 py-2 rounded-xl border font-mono text-sm">
                        <span class="text-gray-500">Time:</span>
                        <span class="ml-1">
                            {{ secondsToClock(Math.max(0, totalSeconds - elapsed)) }}
                        </span>
                    </div>
                    <button
                        class="px-4 py-2 rounded-xl bg-indigo-600 text-white hover:bg-indigo-700 disabled:opacity-50"
                        :disabled="submitting"
                        @click="handleSubmit"
                    >
                        Submit
                    </button>
                </div>
            </div>
        </header>

        <!-- Main -->
        <main class="max-w-6xl mx-auto px-4 py-6 grid grid-cols-12 gap-6">
            <!-- Question content -->
            <section class="col-span-12 lg:col-span-9">
                <div v-if="current" class="bg-white rounded-2xl shadow p-6">
                    <div class="flex items-start justify-between mb-4">
                        <h2 class="text-lg font-semibold">
                            Question {{ idx + 1 }} of {{ total }}
                        </h2>
                        <div class="text-xs text-gray-500 uppercase tracking-wider">
                            Type #{{ current.question_type }}
                        </div>
                    </div>

                    <div class="prose max-w-none mb-4">
                        <p class="text-gray-800 whitespace-pre-line">{{ current.question_text }}</p>
                    </div>

                    <div v-if="current.image_url" class="mb-4">
                        <img :src="current.image_url" class="rounded-xl max-h-64 object-contain"  alt=""/>
                    </div>

                    <component
                        :is="questionComponents[current.question_type]"
                        :question="current"
                        :value="answers[current.id] || { question_id: current.id }"
                        @update="updateAnswer"
                    />

                    <div class="flex items-center justify-between mt-8">
                        <button class="px-4 py-2 rounded-xl border hover:bg-gray-50" @click="prev" :disabled="idx === 0">
                            Previous
                        </button>
                        <div class="text-sm text-gray-500">Answered: {{ answeredCount }} / {{ total }}</div>
                        <button class="px-4 py-2 rounded-xl border hover:bg-gray-50" @click="next" :disabled="idx === total - 1">
                            Next
                        </button>
                    </div>
                </div>
            </section>

            <!-- Navigator -->
            <aside class="col-span-12 lg:col-span-3">
                <div class="bg-white rounded-2xl shadow p-4">
                    <div class="text-sm font-semibold mb-3">Questions</div>
                    <div class="grid grid-cols-5 gap-2">
                        <button
                            v-for="(q, i) in test.questions"
                            :key="q.id"
                            @click="jump(i)"
                            class="h-10 rounded-xl border text-sm"
                            :class="[
                                i === idx ? 'ring-2 ring-indigo-500 border-indigo-500' : '',
                                answers[q.id] ? 'bg-green-50 border-green-400' : 'hover:bg-gray-50'
                            ]"
                        >
                            {{ i + 1 }}
                        </button>
                    </div>
                    <div class="mt-4 text-xs text-gray-500">
                        <div class="flex items-center gap-2"><span class="w-3 h-3 rounded bg-green-100 border border-green-400"></span> Answered</div>
                        <div class="flex items-center gap-2 mt-1"><span class="w-3 h-3 rounded border"></span> Not answered</div>
                        <div class="flex items-center gap-2 mt-1"><span class="w-3 h-3 rounded ring-2 ring-indigo-500 border-indigo-500"></span> Current</div>
                    </div>
                </div>
            </aside>
        </main>
    </div>
</template>

<style scoped>
header .h-2 > div { background: currentColor; color: #4f46e5; }
</style>
