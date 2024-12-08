<script setup lang="ts">
import ApplicationLogoWithLink from "@/Components/Logo/ApplicationLogoWithLink.vue"
import TextInput from "@/Components/Form/Components/Input.vue"
import InputError from "@/Components/Form/Components/InputError.vue"
import PrimaryButton from "@/Components/Button/PrimaryButton.vue"
import InputLabel from "@/Components/Form/Components/InputLabel.vue"
import Card from "@/Components/Card.vue"
import { useForm } from "@inertiajs/vue3"

const props = defineProps<{
    email: string
    token: string
}>()

const form = useForm({
    token: props.token,
    email: props.email,
    password: "",
    password_confirmation: "",
})

const submit = () => {
    form.post(route("password.store"), {
        onFinish: () => {
            form.reset("password", "password_confirmation")
        },
    })
}
</script>

<template>
    <form @submit.prevent="submit">
        <Card>
            <div class="flex w-full gap-4 justify-center">
                <ApplicationLogoWithLink />
            </div>
            <div>
                <InputLabel for="email" value="電子郵件" />

                <TextInput
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="mt-1 block w-full"
                    required
                    autofocus
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="新密碼" />

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
                <InputLabel for="password_confirmation" value="確認新密碼" />

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
                <div class="flex items-center justify-end mt-4">
                    <PrimaryButton
                        :class="{ 'input-error': form.processing }"
                        :disabled="form.processing"
                    >
                        重設密碼
                    </PrimaryButton>
                </div>
            </template>
        </Card>
    </form>
</template>

<style scoped></style>
