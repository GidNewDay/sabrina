import { ref } from 'vue'

const message = ref('')
const show = ref(false)

export function useToast() {

    const success = (msg) => {
        message.value = msg
        show.value = true

        setTimeout(() => {
            show.value = false
        }, 2000)
    }

    return {
        message,
        show,
        success
    }
}