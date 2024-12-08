<script lang="ts" setup>
import BaseLayout from "@/Layouts/BaseLayout.vue"
import { Head } from "@inertiajs/vue3"
</script>

<template>
    <BaseLayout>
        <template #header>
            <Head title="後台管理" />
        </template>
        <div class="py-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-base-200 overflow-hidden shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        你已經成功登入！
                    </div>
                </div>
            </div>
        </div>
    </BaseLayout>
</template>
