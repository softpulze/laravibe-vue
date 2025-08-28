import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

export const useAuth = () => ({
    authenticated: computed(() => !!usePage().props.auth?.user),
    authUser: computed(() => usePage().props.auth?.user),
});
