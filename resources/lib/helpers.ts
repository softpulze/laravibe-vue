import AccountLayout from '@/layouts/AccountLayout.vue';
import AuthLayout from '@/layouts/AuthLayout.vue';
import DashboardLayout from '@/layouts/DashboardLayout.vue';
import GuestLayout from '@/layouts/GuestLayout.vue';
import type { Callable, VoidCallable } from '@/types';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import type { DefineComponent } from 'vue';

const resolveLayout = (name: string) => {
    if (name.startsWith('dashboard')) return DashboardLayout;
    if (name.startsWith('account')) return AccountLayout;
    if (name.startsWith('auth')) return AuthLayout;
    return GuestLayout;
};

export const resolveView = (name: string) => {
    const pageComponent = resolvePageComponent(`../views/${name}.vue`, import.meta.glob<DefineComponent>('../views/**/*.vue'));
    pageComponent.then((pc) => (pc.default.layout = pc.default.layout || resolveLayout(name)));
    return pageComponent;
};

export const isCallable = (value: unknown): value is Callable | VoidCallable => typeof value === 'function';
