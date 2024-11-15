export const useFlash = () => {
    return {
        success: (message) => {
            window.dispatchEvent(new CustomEvent('flash', { detail: { type: 'success', message: message } }))
        },
        error: (message) => {
            window.dispatchEvent(new CustomEvent('flash', { detail: { type: 'error', message: message } }))
        }
    }
}
