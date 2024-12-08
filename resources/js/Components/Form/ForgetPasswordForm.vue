<script setup lang="ts">
import { useForm } from "@inertiajs/vue3"
import InputError from "@/Components/Form/Components/InputError.vue"
import InputLabel from "@/Components/Form/Components/InputLabel.vue"
import PrimaryButton from "@/Components/Button/PrimaryButton.vue"
import TextInput from "@/Components/Form/Components/Input.vue"
import Card from "@/Components/Card.vue"
import ApplicationLogoWithLink from "@/Components/Logo/ApplicationLogoWithLink.vue"

defineProps<{
    status?: string
}>()

const form = useForm({
    email: "",
})

const submit = () => {
    form.post(route("password.email"))
}
</script>

<template>
    <form @submit.prevent="submit">
        <Card>
            <div class="w-full flex justify-center">
                <ApplicationLogoWithLink />
            </div>

            <div
                class="my-4 text-sm text-gray-600 dark:text-gray-400 text-center"
            >
                忘記密碼？沒關係，只要記得電子郵件，<br />可以發送信件重新找回失去的帳號。
            </div>

            <div
                v-if="status"
                class="mb-4 text-center font-medium text-sm text-green-600 dark:text-green-400"
            >
                {{ status }}
            </div>
            <div>
                <InputLabel for="email" value="電子郵件" />

                <TextInput
                    id="email"
                    v-model="form.email"
                    :class="[{ 'input-error': form.errors.email }]"
                    autocomplete="username"
                    autofocus
                    class="mt-1 block w-full"
                    required
                    type="email"
                />

                <InputError :message="form.errors.email" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <PrimaryButton
                    :disabled="form.processing"
                    :loading="form.processing"
                >
                    重設密碼
                </PrimaryButton>
            </div>
        </Card>
    </form>
</template>
