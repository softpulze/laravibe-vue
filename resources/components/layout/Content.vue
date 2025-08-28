<script setup lang="ts">
import { SidebarInset } from '@/components/ui/sidebar';
import { cn } from '@/lib/utils';

interface Props {
    variant?: 'header' | 'sidebar';
    className?: string;
}

withDefaults(defineProps<Props>(), {
    variant: 'sidebar',
});
</script>

<template>
    <SidebarInset v-if="variant === 'sidebar'" :class="className">
        <slot />
    </SidebarInset>
    <main v-else :class="cn('mx-auto flex h-full w-full max-w-7xl flex-1 flex-col gap-4 rounded-xl', className)">
        <slot />
    </main>
</template>
