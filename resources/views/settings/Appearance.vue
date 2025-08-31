<script setup lang="ts">
import HeadingSmall from '@/components/HeadingSmall.vue';
import AppearanceTabs from './partial/AppearanceTabs.vue';

import SettingsLayout from '@/layouts/settings/Layout.vue';
</script>

<template>
    <SettingsLayout>
        <div class="space-y-6">
            <HeadingSmall title="Appearance settings" description="Update your account's appearance settings" />
            <AppearanceTabs />
        </div>
    </SettingsLayout>
</template>
