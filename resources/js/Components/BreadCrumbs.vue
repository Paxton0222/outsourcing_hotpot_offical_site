<script setup lang="ts">
import { Link } from "@inertiajs/vue3"
import { useSessionStorage } from "@vueuse/core"

const position = useSessionStorage("menuPosition", 0)

defineProps<{
    data: {
        title: string
        url: string | null
    }[]
}>()
</script>

<template>
    <div class="breadcrumbs text-sm">
        <ul>
            <template v-for="(value, index) in data" :key="index">
                <li>
                    <template v-if="value.url !== null">
                        <Link :href="value.url" @click="position = 0">
                            {{ value.title }}
                        </Link>
                    </template>
                    <template v-else>
                        {{ value.title }}
                    </template>
                </li>
            </template>
        </ul>
    </div>
</template>

<style scoped></style>
