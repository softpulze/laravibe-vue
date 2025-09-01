<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Flash, FlashAction } from '@/types/data';
import { useClipboard, useDebounceFn } from '@vueuse/core';
import { CheckCheck, Copy, SquareArrowOutUpRight } from 'lucide-vue-next';
import { computed } from 'vue';

defineProps<{ flash: Flash }>();

const { copy, copied } = useClipboard();

const actionIcons = {
    copy: Copy,
    redirect: SquareArrowOutUpRight,
};

const actionComponent = {
    copy: 'button',
    redirect: 'a',
};

const flashAction = computed(() => (action: FlashAction) => {
    const copyable = action.type === 'copy';
    const isCopoed = copyable && copied.value;
    return {
        copy: useDebounceFn(() => copyable && copy(action.payload), 100),
        component: actionComponent[action.type],
        icon: isCopoed ? CheckCheck : actionIcons[action.type],
        label: isCopoed ? 'COPIED' : action.label || action.type.toUpperCase(),
    };
});
</script>

<template>
    <div class="grid w-full! grid-cols-1 gap-1.5 text-sm">
        <p class="font-medium">{{ flash.message }}</p>
        <div v-if="flash.actions?.length" class="flex gap-1">
            <template v-for="(action, index) in flash.actions" :key="index">
                <Button size="sm" class="h-5 cursor-pointer px-2 text-xs! font-medium" as-child>
                    <component
                        :is="flashAction(action).component"
                        @click="flashAction(action).copy()"
                        :href="action.payload"
                        target="_blank"
                        rel="noopener noreferrer"
                    >
                        <component :is="flashAction(action).icon" class="size-3" />
                        {{ flashAction(action).label }}
                    </component>
                </Button>
            </template>
        </div>
    </div>
</template>
