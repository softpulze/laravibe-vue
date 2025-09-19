import type { ToastPayload } from '@/components/toast';
import type { PageMeta } from '@/types/data';
import type { LucideIcon } from 'lucide-vue-next';
import type { Config } from 'ziggy-js';
import type { User } from './models';

// Utility Types
export type Nullable<T> = T | null;
export type Optional<T> = T | undefined;
export type Callable<T = void, U extends any[] = []> = (...args: U) => T;
export type VoidCallable<U extends any[] = []> = Callable<void, U>;

// Application Specific Types
export interface Auth {
    user: Nullable<User>;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon;
    isActive?: boolean | Callable<boolean>;
}

export type AppPageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    ziggy: Config & { location: string };
    sidebarOpen: boolean;
    meta?: PageMeta;
    toasts: ToastPayload[];
};

export type BreadcrumbItemType = BreadcrumbItem;
