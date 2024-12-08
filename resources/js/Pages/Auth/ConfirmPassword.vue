<script lang="ts" setup>
import InputError from "@/Components/Form/Components/InputError.vue"
import InputLabel from "@/Components/Form/Components/InputLabel.vue"
import PrimaryButton from "@/Components/Button/PrimaryButton.vue"
import TextInput from "@/Components/Form/Components/Input.vue"
import { Head, useForm } from "@inertiajs/vue3"
import BaseLayout from "@/Layouts/BaseLayout.vue"
import Card from "@/Components/Card.vue"
import ApplicationLogoWithLink from "@/Components/Logo/ApplicationLogoWithLink.vue"

const form = useForm({
    password: "",
})

const submit = () => {
    form.post(route("password.confirm"), {
        onFinish: () => {
            form.reset()
        },
    })
}
</script>

<template>
    <BaseLayout>
        <template #header>
            <Head title="Confirm Password" />
        </template>
        <div class="w-full h-full flex justify-center items-center">
            <form @submit.prevent="submit">
                <Card>
                    <div class="flex justify-center items-center">
                        <ApplicationLogoWithLink />
                    </div>
                    <div
                        class="my-4 text-center text-sm text-gray-600 dark:text-gray-400"
                    >
                        這是應用程式的安全區域。 請在繼續之前確認您的密碼。
                    </div>
                    <div>
                        <InputLabel for="password" value="密碼" />
                        <TextInput
                            id="password"
                            v-model="form.password"
                            type="password"
                            class="mt-1 block w-full"
                            required
                            autocomplete="current-password"
                            autofocus
                        />
                        <InputError
                            class="mt-2"
                            :message="form.errors.password"
                        />
                    </div>

                    <template #actions>
                        <div class="flex justify-end mt-4">
                            <PrimaryButton
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing"
                                class="ms-4"
                            >
                                確認
                            </PrimaryButton>
                        </div>
                    </template>
                </Card>
            </form>
        </div>
    </BaseLayout>
</template>
