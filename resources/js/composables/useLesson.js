import { ref } from 'vue'
import { router } from '@inertiajs/vue3'

export function useLesson(initialLesson) {
    const completed = ref(!!initialLesson.completed_at)
    const activeTab = ref('overview')

    function toggleCompletion(lessonItem) {
        router.post(
            route('lessons.toggle', lessonItem.id),
            {},
            {
                preserveScroll: true,
                onSuccess: () => {
                    lessonItem.completed = !lessonItem.completed
                }
            }
        )
    }

    function markCompleted() {
        router.post(route('lessons.complete', initialLesson.id), {}, {
            preserveScroll: true,
            onSuccess: () => {
                completed.value = true
            }
        })
    }

    function onVideoProgress(e) {
        const video = e.target
        if (!completed.value && video.currentTime / video.duration > 0.9) {
            markCompleted()
        }
    }

    return {
        activeTab,
        toggleCompletion,
        onVideoProgress
    }
}
