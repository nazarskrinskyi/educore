import mitt from 'mitt'

// Create a global event bus for cross-component communication
export const eventBus = mitt()

// Export as mitt for backward compatibility
export { eventBus as mitt }
