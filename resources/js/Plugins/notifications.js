import { router, usePage } from '@inertiajs/vue3'
import { useToast } from 'vue-toastification'

const toast = useToast()

export const notifications = () => {
    router.on('finish', () => {
        const notification = usePage().props.message

        if (notification?.body && notification?.type) {
            toast(notification.body, { type: notification.type })
        }
    })
}
