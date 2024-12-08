<script setup lang="ts">
import InputError from "@/Components/Form/Components/InputError.vue"
import InputLabel from "@/Components/Form/Components/InputLabel.vue"
import PrimaryButton from "@/Components/Button/PrimaryButton.vue"
import TextInput from "@/Components/Form/Components/Input.vue"
import { Link, useForm } from "@inertiajs/vue3"
import Card from "@/Components/Card.vue"
import ApplicationLogoWithLink from "@/Components/Logo/ApplicationLogoWithLink.vue"

const form = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
})

const submit = () => {
    form.post(route("register"), {
        onFinish: () => {
            form.reset("password", "password_confirmation")
        },
    })
}
</script>

<template>
    <form @submit.prevent="submit">
        <Card>
            <div class="w-full flex justify-center items-center">
                <ApplicationLogoWithLink />
            </div>
            <div>
                <InputLabel for="name" value="使用者名稱" />

                <TextInput
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="電子郵件" />

                <TextInput
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="mt-1 block w-full"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="密碼" />

                <TextInput
                    id="password"
                    v-model="form.password"
                    type="password"
                    class="mt-1 block w-full"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel for="password_confirmation" value="確認密碼" />

                <TextInput
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    required
                    autocomplete="new-password"
                />

                <InputError
                    :message="form.errors.password_confirmation"
                    class="mt-2"
                />
            </div>

            <template #actions>
                <div class="mt-4">
                    <Link :href="route('login')" class="link">
                        已經註冊過帳號?
                    </Link>

                    <PrimaryButton
                        :loading="form.processing"
                        :disabled="form.processing"
                        class="ms-4"
                    >
                        註冊帳號
                    </PrimaryButton>
                </div>
            </template>
        </Card>
    </form>
</template>
