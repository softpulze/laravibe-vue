<script setup lang="ts">
import { LayoutContent, LayoutShell } from './';

interface Props {
    initiallyIsSidebarOpen?: boolean;
}

withDefaults(defineProps<Props>(), { initiallyIsSidebarOpen: true });
</script>

<template>
    <LayoutShell variant="sidebar" :initiallyIsSidebarOpen="initiallyIsSidebarOpen">
        <slot name="sidebar" />

        <LayoutContent variant="sidebar" class="overflow-x-hidden">
            <slot name="header" />

            <slot />
        </LayoutContent>
    </LayoutShell>
</template>
