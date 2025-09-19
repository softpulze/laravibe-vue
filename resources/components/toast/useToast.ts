import { router, usePage } from '@inertiajs/vue3';
import { markRaw } from 'vue';
import { toast as vueSoonerToast } from 'vue-sonner';
import { Toast, type ToastPayload } from './';

export const pushToast = (toast: ToastPayload) =>
    vueSoonerToast[toast.type](markRaw(Toast), { componentProps: { toast }, classes: { content: 'flex-1' } });

export const registerToaster = () => {
    usePage().props.toasts.forEach(pushToast);
    router.on('finish', () => usePage().props.toasts.forEach(pushToast));
};

export const useToast = () => ({ register: registerToaster, push: pushToast });
