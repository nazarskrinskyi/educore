/**
 * Click Away Directive
 *
 * A Vue 3 directive that detects clicks outside of an element.
 * Useful for closing dropdowns, modals, and other UI elements.
 *
 * Usage:
 * <div v-click-away="onClickAway">
 *   Content here
 * </div>
 */

export const clickAway = {
    mounted(el, binding) {
        el.clickAwayEvent = function(event) {
            // Check if the click was outside the element and its children
            if (!(el === event.target || el.contains(event.target))) {
                // Call the provided method
                binding.value(event);
            }
        };

        // Add event listener with a slight delay to avoid immediate triggering
        setTimeout(() => {
            document.addEventListener('click', el.clickAwayEvent);
        }, 0);
    },

    unmounted(el) {
        // Clean up the event listener when the element is unmounted
        document.removeEventListener('click', el.clickAwayEvent);
    }
};
