<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import AppMeta from '@/Components/AppMeta.vue';

const props = defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    username: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <AppMeta>
        <link rel="icon" :href="`/storage/${props.setting?.logo}`" type="image/x-icon" />
    </AppMeta>

    <GuestLayout>
        <Head title="Log in" />

        <div v-if="status" class="alert alert-success mb-4">
            {{ status }}
        </div>

        <form @submit.prevent="submit" >
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input
                    id="username"
                    type="text"
                    class="form-control"
                    v-model="form.username"
                    required
                    autofocus
                    autocomplete="username"
                />
                <div class="text-danger mt-1 small" v-if="form.errors.username">{{ form.errors.username }}</div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input
                    id="password"
                    type="password"
                    class="form-control"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                />
                <div class="text-danger mt-1 small" v-if="form.errors.password">{{ form.errors.password }}</div>
            </div>

            <div class="d-flex justify-content-end">
                <button
                    type="submit"
                    class="btn btn-primary"
                    :class="{ 'disabled': form.processing }"
                    :disabled="form.processing"
                >
                    Log in
                </button>
            </div>
        </form>
    </GuestLayout>
</template>
