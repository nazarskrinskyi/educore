import { ref, computed } from 'vue'

export function useCourse(course, cart = {}) {
    const openSections = ref([])

    function toggleSection(sectionId) {
        if (openSections.value.includes(sectionId)) {
            openSections.value = openSections.value.filter(id => id !== sectionId)
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

    return {
        openSections,
        toggleSection,
        totalStudents,
        totalLessons,
        cart
    }
}
