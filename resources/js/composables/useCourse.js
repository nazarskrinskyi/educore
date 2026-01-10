import { ref, computed } from 'vue'

/**
 * Composable for managing course functionality
 * @param {Object} course - The course object
 * @param {Object|Array} cart - Shopping cart data
 * @returns {Object} Course state and methods
 */
export function useCourse(course, cart = {}) {
    const openSections = ref([])

    /**
     * Toggle section open/closed state
     * @param {number} sectionId - The section ID to toggle
     */
    function toggleSection(sectionId) {
        const index = openSections.value.indexOf(sectionId)
        if (index > -1) {
            openSections.value.splice(index, 1)
        } else {
            openSections.value.push(sectionId)
        }
    }

    const totalStudents = computed(() => course?.users?.length || 0)

    const allLessons = computed(() => {
        if (!course?.sections) return []
        return course.sections.flatMap(s => s.lessons || [])
    })

    const totalLessons = computed(() => allLessons.value.length)

    const completedLessons = computed(() => {
        return allLessons.value.filter(lesson => lesson.completed).length
    })

    const courseProgress = computed(() => {
        if (totalLessons.value === 0) return 0
        return Math.round((completedLessons.value / totalLessons.value) * 100)
    })

    return {
        openSections,
        toggleSection,
        totalStudents,
        totalLessons,
        completedLessons,
        courseProgress,
        cart
    }
}
