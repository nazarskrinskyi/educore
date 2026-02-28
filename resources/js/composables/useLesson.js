import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import { mitt } from '@/utils/eventBus'

/**
 * Composable for managing lesson functionality
 * @param {Object} initialLesson - The lesson object
 * @returns {Object} Lesson state and methods
 */
export function useLesson(initialLesson) {
    const completed = ref(!!initialLesson.completed_at)
    const activeTab = ref('overview')

    /**
     * Toggle lesson completion status
     * @param {Object} lessonItem - The lesson to toggle
     */
    function toggleCompletion(lessonItem) {
        router.post(
            route('lessons.toggle', lessonItem.id),
            {},
            {
                preserveScroll: true,
                onSuccess: () => {
                    lessonItem.completed = !lessonItem.completed
                    // Emit event to update progress
                    mitt.emit('lesson-completed')
                },
                onError: (errors) => {
                    console.error('Failed to toggle lesson completion:', errors)
                }
            }
        )
    }

    /**
     * Mark lesson as completed
     */
    function markCompleted() {
        if (completed.value) return

        router.post(route('lessons.complete', initialLesson.id), {}, {
            preserveScroll: true,
            onSuccess: () => {
                completed.value = true
                // Emit event to update progress
                mitt.emit('lesson-completed')
            },
            onError: (errors) => {
                console.error('Failed to mark lesson as completed:', errors)
            }
        })
    }

    /**
     * Handle video progress and auto-complete at 90%
     * @param {Event} e - Video progress event
     */
    function onVideoProgress(e) {
        const video = e.target
        if (!completed.value && video.duration > 0) {
            const progress = video.currentTime / video.duration
            if (progress > 0.9) {
                markCompleted()
            }
        }
    }

    return {
        completed,
        activeTab,
        toggleCompletion,
        markCompleted,
        onVideoProgress
    }
}
