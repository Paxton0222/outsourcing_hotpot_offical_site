<script lang="ts" setup>
import { Head } from "@inertiajs/vue3"
import BaseLayout from "@/Layouts/BaseLayout.vue"
import RegisterForm from "@/Components/Form/RegisterForm.vue"
</script>

<template>
    <BaseLayout>
        <template #header>
            <Head title="Register" />
        </template>
        <div class="layout-center">
            <RegisterForm class="w-full xl:w-1/3" />
        </div>
    </BaseLayout>
</template>
