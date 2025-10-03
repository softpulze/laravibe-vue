import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

export const useAuth = () => ({
    authUser: computed(() => usePage().props.auth?.user),
});
