<script lang="ts" setup>
import { Link, useForm } from "@inertiajs/vue3"
import Checkbox from "@/Components/Form/Components/Checkbox.vue"
import InputError from "@/Components/Form/Components/InputError.vue"
import InputLabel from "@/Components/Form/Components/InputLabel.vue"
import PrimaryButton from "@/Components/Button/PrimaryButton.vue"
import TextInput from "@/Components/Form/Components/Input.vue"
import Card from "@/Components/Card.vue"
import ApplicationLogoWithLink from "@/Components/Logo/ApplicationLogoWithLink.vue"

defineProps<{
    canResetPassword?: boolean
    status?: string
}>()

const form = useForm({
    email: "",
    password: "",
    remember: false,
})

const submit = () => {
    form.post(route("login"), {
        onFinish: () => {
            form.reset("password")
        },
    })
}
</script>

<template>
    <form @submit.prevent="submit">
        <Card>
            <div class="w-full flex justify-center">
                <ApplicationLogoWithLink />
            </div>

            <div
                v-if="status"
                class="text-center mb-4 font-medium text-sm text-green-600"
            >
                {{ status }}
            </div>

            <div>
                <InputLabel for="email" value="電子郵件" />

                <TextInput
                    id="email"
                    v-model="form.email"
                    autocomplete="username"
                    autofocus
                    class="mt-1 block w-full"
                    :class="[
                        {
                            'input-error': form.errors.email,
                        },
                    ]"
                    required
                    type="email"
                />

                <InputError :message="form.errors.email" class="mt-2" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="密碼" />

                <TextInput
                    id="password"
                    v-model="form.password"
                    autocomplete="current-password"
                    class="mt-1 block w-full"
                    :class="[
                        {
                            'input-error': form.errors.password,
                        },
                    ]"
                    required
                    type="password"
                />

                <InputError :message="form.errors.password" class="mt-2" />
            </div>

            <div class="form-control max-w-[5rem] mt-4">
                <label class="label cursor-pointer">
                    <Checkbox v-model="form.remember" name="remember" />
                    <span class="label-text">記住我</span>
                </label>
            </div>

            <template #actions>
                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="link"
                >
                    忘記密碼？
                </Link>
                <PrimaryButton
                    :disabled="form.processing"
                    :loading="form.processing"
                >
                    登入
                </PrimaryButton>
            </template>
        </Card>
    </form>
</template>
