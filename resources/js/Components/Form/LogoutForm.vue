<script setup lang="ts">
import { useForm } from "@inertiajs/vue3"
</script>

<template>
    <button type="button" @click="useForm({}).post(route('logout'))">
        登出
    </button>
</template>
