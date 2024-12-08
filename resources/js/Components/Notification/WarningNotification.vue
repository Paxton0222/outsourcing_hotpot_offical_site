<script setup lang="ts">
import Icon from "@/Components/Icon.vue"

defineProps<{
    notify: string
}>()
</script>

<template>
    <div class="alert alert-warning">
        <div class="flex items-center">
            <Icon type="rounded" name="warning" />
        </div>
        <div>
            <span>{{ notify }}</span>
        </div>
    </div>
</template>

<style scoped></style>
