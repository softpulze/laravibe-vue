<script setup lang="ts">
import { Form, Link } from '@inertiajs/vue3';

import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { useAuth } from '@/composables/useAuth';
import SettingsLayout from '@/layouts/AccountLayout.vue';
import { Info, TriangleAlert, User } from 'lucide-vue-next';
import DeleteUser from './partial/DeleteUser.vue';

interface Props {
    mustVerifyEmail: boolean;
    status?: string;
}

defineProps<Props>();

const { authUser } = useAuth();
</script>

<template>
    <SettingsLayout>
        <div class="space-y-6">
            <Card>
                <CardHeader class="pb-4">
                    <CardTitle class="flex items-center gap-2 text-lg font-medium">
                        <User class="size-4 text-primary" />
                        General
                    </CardTitle>
                    <CardDescription class="text-sm text-muted-foreground"> General settings related to your profile. </CardDescription>
                </CardHeader>
                <CardContent>
                    <Form method="patch" :action="route('account.update')" class="space-y-4" v-slot="{ errors, processing, recentlySuccessful }">
                        <div class="space-y-4">
                            <!-- Profile Fields -->
                            <div class="grid gap-4 sm:grid-cols-2">
                                <div class="space-y-2">
                                    <Label for="name" class="text-sm font-medium">Full Name</Label>
                                    <Input
                                        id="name"
                                        class="h-9"
                                        name="name"
                                        :default-value="authUser?.name"
                                        required
                                        autocomplete="name"
                                        placeholder="Enter your full name"
                                    />
                                    <InputError class="text-xs" :message="errors.name" />
                                </div>

                                <div class="space-y-2">
                                    <Label for="email" class="text-sm font-medium">Email Address</Label>
                                    <Input
                                        id="email"
                                        type="email"
                                        class="h-9"
                                        name="email"
                                        :default-value="authUser?.email"
                                        required
                                        autocomplete="username"
                                        placeholder="Enter your email address"
                                    />
                                    <InputError class="text-xs" :message="errors.email" />
                                </div>
                            </div>

                            <!-- Email Verification Notice -->
                            <div
                                v-if="mustVerifyEmail && !authUser?.email_verified_at"
                                class="rounded-md border border-amber-200 bg-amber-50 p-3 dark:border-amber-800 dark:bg-amber-950/50"
                            >
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <TriangleAlert class="size-4 text-amber-500" />
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-amber-800 dark:text-amber-200">Email Verification Required</h3>
                                        <div class="mt-1 text-sm text-amber-700 dark:text-amber-300">
                                            <p>
                                                Your email address is unverified.
                                                <Link
                                                    :href="route('verification.send')"
                                                    method="post"
                                                    as="button"
                                                    class="font-medium underline decoration-amber-400 underline-offset-4 transition-colors duration-200 hover:decoration-amber-600 dark:decoration-amber-300 dark:hover:decoration-amber-100"
                                                >
                                                    Click here to resend the verification email.
                                                </Link>
                                            </p>

                                            <div
                                                v-if="status === 'verification-link-sent'"
                                                class="mt-2 text-sm font-medium text-green-700 dark:text-green-300"
                                            >
                                                A new verification link has been sent to your email address.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Profile Tips -->
                            <div class="rounded-md bg-blue-50 p-3 dark:bg-blue-950/50">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <Info class="size-4 text-blue-500" />
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">Profile Tips</h3>
                                        <div class="mt-1 text-sm text-blue-700 dark:text-blue-300">
                                            <ul class="list-inside list-disc space-y-1">
                                                <li>Use your real name for better recognition</li>
                                                <li>Keep your email address up to date</li>
                                                <li>Verify your email for account security</li>
                                                <li>Changes will be reflected across your profile</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex items-center justify-between border-t pt-4">
                            <div class="flex items-center gap-3">
                                <Button :disabled="processing" size="sm">
                                    {{ processing ? 'Saving...' : 'Save Changes' }}
                                </Button>

                                <Transition
                                    enter-active-class="transition-all duration-300 ease-out"
                                    enter-from-class="opacity-0 translate-y-1"
                                    enter-to-class="opacity-100 translate-y-0"
                                    leave-active-class="transition-all duration-200 ease-in"
                                    leave-from-class="opacity-100 translate-y-0"
                                    leave-to-class="opacity-0 translate-y-1"
                                >
                                    <div v-show="recentlySuccessful" class="flex items-center gap-2 text-sm text-green-600 dark:text-green-400">
                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd"
                                            />
                                        </svg>
                                        Profile updated successfully!
                                    </div>
                                </Transition>
                            </div>
                        </div>
                    </Form>
                </CardContent>
            </Card>

            <DeleteUser />
        </div>
    </SettingsLayout>
</template>
