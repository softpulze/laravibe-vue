import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

export const usePageMeta = () => computed(() => (usePage().props.meta || {}));
