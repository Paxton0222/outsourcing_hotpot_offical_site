<script setup lang="ts">
import { changePageQuery } from "@/pagination"

defineProps<{
    page: number
    options: number[]
}>()

const perPage = defineModel({ type: Number })
</script>

<template>
    <select
        v-model="perPage"
        class="select select-bordered max-w-xs select-sm"
        @change="changePageQuery(page, perPage!)"
    >
        <template v-for="(pageOption, index) in options" :key="index">
            <option>{{ pageOption }}</option>
        </template>
    </select>
</template>

<style scoped></style>
