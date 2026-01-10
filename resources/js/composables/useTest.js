import { ref, reactive, computed, onMounted, onUnmounted } from 'vue'
import { router } from '@inertiajs/vue3'
import axios from 'axios'

/**
 * Composable for managing test/quiz functionality
 * @param {Object} test - The test object containing questions and configuration
 * @param {Array|null} previousAnswers - Previously saved answers if resuming
 * @returns {Object} Test state and methods
 */
export function useTest(test, previousAnswers = null) {
    const QUESTION_TYPES = Object.freeze({
        MultipleChoice: 1,
        MultipleAnswer: 2,
        TrueFalse: 3,
        ShortAnswer: 4,
    })

    const idx = ref(0)
    const answers = reactive({})
    const submitting = ref(false)

    const hasTimer = computed(() => (test.duration ?? 0) > 0)
    const totalSeconds = computed(() => (test.duration ?? 0) * 60)
    const elapsed = ref(0)
    let ticker = null
    let autosaveTimer = null

    const total = computed(() => test.questions.length)
    const current = computed(() => test.questions[idx.value])

    const answeredCount = computed(() =>
        Object.values(answers).filter(a => {
            const boolVal = a.bool !== undefined ? Boolean(a.bool) : undefined
            return a.selected_answer_id !== null || a.text || boolVal !== undefined
        }).length
    )

    const progress = computed(() => (answeredCount.value / total.value) * 100)

    function go(n) {
        idx.value = Math.min(Math.max(0, n), total.value - 1)
    }
    const next = () => go(idx.value + 1)
    const prev = () => go(idx.value - 1)
    const jump = (i) => go(i)

    function updateAnswer(payload) {
        answers[payload.question_id] = { ...answers[payload.question_id], ...payload }
    }

    function secondsToClock(s) {
        const t = Math.max(0, s)
        const m = Math.floor(t / 60).toString().padStart(2, '0')
        const sec = Math.floor(t % 60).toString().padStart(2, '0')
        return `${m}:${sec}`
    }

    async function handleSubmit() {
        if (submitting.value) return
        submitting.value = true

        const formattedAnswers = Object.values(answers).map(a => ({
            question_id: a.question_id,
            selected_answer_id: a.selected_answer_id ?? null,
            selected_answer_ids: a.selected_answer_ids ?? null,
            bool: a.bool !== undefined ? Boolean(a.bool) : null,
            text: a.text ?? null
        }))

        router.post(route('tests.submit', test.id), {
            answers: formattedAnswers,
            elapsed_seconds: elapsed.value,
            is_completed: true
        }, {
            preserveScroll: true,
            onFinish: () => { submitting.value = false }
        })
    }

    onMounted(async () => {
        try {
            // Load previous answers if provided
            if (previousAnswers && Array.isArray(previousAnswers)) {
                previousAnswers.forEach(a => { answers[a.question_id] = a })
            }

            // Fetch saved progress from server
            const response = await axios.get(route('tests.progress.get', test.id))
            if (response.data) {
                elapsed.value = response.data.elapsed_seconds ?? 0
                if (response.data.answers && Array.isArray(response.data.answers)) {
                    response.data.answers.forEach(a => { answers[a.question_id] = a })
                }
            }

            // Start timer if test has duration
            if (hasTimer.value) {
                ticker = setInterval(() => {
                    elapsed.value += 1
                    if (elapsed.value >= totalSeconds.value) handleSubmit()
                }, 1000)
            }

            // Auto-save progress every 15 seconds
            autosaveTimer = setInterval(() => {
                router.post(route('tests.progress', test.id), {
                    answers: Object.values(answers),
                    elapsed_seconds: elapsed.value
                }, { preserveScroll: true, preserveState: true })
            }, 15000)
        } catch (error) {
            console.error('Error loading test progress:', error)
        }
    })

    onUnmounted(() => {
        if (ticker) clearInterval(ticker)
        if (autosaveTimer) clearInterval(autosaveTimer)
    })

    return {
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
        secondsToClock,
        hasTimer,
        totalSeconds,
        elapsed,
    }
}
