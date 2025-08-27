<script setup lang="ts">
import { LayoutContent, LayoutShell } from './';
</script>

<template>
    <LayoutShell class="flex-col" variant="header">
        <slot name="header" />

        <LayoutContent variant="header">
            <slot />
        </LayoutContent>
    </LayoutShell>
</template>
