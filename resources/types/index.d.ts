import type { LucideIcon } from 'lucide-vue-next';
import type { Config } from 'ziggy-js';

// Utility Types
export type Nullable<T> = T | null;
export type Optional<T> = T | undefined;
export type Callable<T = void, U extends any[] = []> = (...args: U) => T;
export type VoidCallable<U extends any[] = []> = Callable<void, U>;

// Application Specific Types
export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon;
    isActive?: boolean;
}

export type AppPageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    ziggy: Config & { location: string };
    sidebarOpen: boolean;
};

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
}

export type BreadcrumbItemType = BreadcrumbItem;
