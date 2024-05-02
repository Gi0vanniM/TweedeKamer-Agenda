<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import AuthenticationCard from '@/views/components/authentication-card.vue';
import Button from '@/views/components/button.vue';
import Input from '@/views/components/input.vue';
import Checkbox from '@/views/components/checkbox.vue';
import Label from '@/views/components/label.vue';
import ValidationErrors from '@/views/components/validation-errors.vue';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post('login', {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Log in" />

    <AuthenticationCard>
        <!-- <template #logo>
            <JetAuthenticationCardLogo />
        </template> -->

        <ValidationErrors class="mb-4" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <Label for="email" value="Email" />
                <Input
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="p-1 pl-2 mt-1 block w-full border-gray-300 border-2"
                    required
                    autofocus
                />
            </div>

            <div class="mt-4">
                <Label for="password" value="Password" />
                <Input
                    id="password"
                    v-model="form.password"
                    type="password"
                    class="p-1 pl-2 mt-1 block w-full border-gray-300 border-2"
                    required
                    autocomplete="current-password"
                />
            </div>

            <div class="block mt-4">
                <label class="flex items-center">
                    <Checkbox v-model:checked="form.remember" name="remember" />
                    <span class="ml-2 text-sm text-gray-600">Remember me</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link href="register" class="underline text-sm text-gray-600 hover:text-gray-900">
                    No account?
                </Link>
                <Link v-if="canResetPassword" href="password-request" class="underline text-sm text-gray-600 hover:text-gray-900">
                    Forgot your password?
                </Link>

                <Button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Log in
                </Button>
            </div>
        </form>
    </AuthenticationCard>
</template>
