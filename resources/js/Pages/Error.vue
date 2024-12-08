<script setup>
import { computed } from "vue"
import { Head } from "@inertiajs/vue3"
import PrimaryButton from "@/Components/Button/PrimaryButton.vue"

// eslint-disable-next-line vue/require-default-prop
const props = defineProps({ status: Number })

const title = computed(() => {
    return {
        503: "503: 服務無法使用",
        500: "500: 伺服器錯誤",
        404: "404: 頁面未找到",
        403: "403: 禁止訪問",
        401: "401: 沒有訪問權限",
    }[props.status]
})

const description = computed(() => {
    return {
        503: "抱歉，我們正在進行維護。請稍後再試。",
        500: "哎呀，我們的伺服器出現了一些問題。",
        404: "抱歉，您查找的頁面無法找到。",
        403: "抱歉，您無權訪問此頁面或功能。",
        401: "抱歉，您無權訪問此頁面或功能。",
    }[props.status]
})
</script>

<template>
    <Head :title="title" />
    <div
        class="flex justify-center items-center h-screen w-screen flex-col gap-4"
    >
        <div>{{ description }}</div>
        <div>
            <PrimaryButton class="min-w-6" onclick="history.back()">
                回上一頁
            </PrimaryButton>
        </div>
    </div>
</template>
