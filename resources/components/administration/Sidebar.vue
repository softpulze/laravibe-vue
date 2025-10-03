<script setup lang="ts">
import Logo from '@/components/Logo.vue';
import LogoIcon from '@/components/LogoIcon.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
    useSidebar,
} from '@/components/ui/sidebar';
import { cn } from '@/lib/utils';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { CircleGauge, FolderGit } from 'lucide-vue-next';
import NavFooter from './NavFooter.vue';
import NavMain from './NavMain.vue';
import NavUser from './NavUser.vue';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: '/administration/dashboard',
        icon: CircleGauge,
    },
];

const footerNavItems: NavItem[] = [
    {
        title: 'Github Repo',
        href: 'https://github.com/softpulze/laravibe-vue',
        icon: FolderGit,
    },
];

const { open } = useSidebar();
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton
                        size="lg"
                        as-child
                        :class="cn('items-center justify-center [&>svg]:w-auto', open ? '[&>svg]:h-7' : '[&>svg]:h-5')"
                    >
                        <Link :href="route('administration.dashboard')">
                            <Logo v-if="open" />
                            <LogoIcon v-else />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
