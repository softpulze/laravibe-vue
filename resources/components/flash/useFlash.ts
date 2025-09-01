import { Flash } from '@/types/data';
import { router, usePage } from '@inertiajs/vue3';
import { markRaw } from 'vue';
import { toast } from 'vue-sonner';
import { Flash as FlashComponent } from '.';

export const pushFlash = (flash: Flash) => toast[flash.type](markRaw(FlashComponent), { componentProps: { flash }, classes: { content: 'flex-1' } });

export const registerFlash = () => {
    usePage().props.flash.forEach(pushFlash);
    router.on('finish', () => usePage().props.flash.forEach(pushFlash));
};

export const useFlash = () => ({ register: registerFlash, push: pushFlash });
