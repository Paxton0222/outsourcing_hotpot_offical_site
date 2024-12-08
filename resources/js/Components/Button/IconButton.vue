<script setup lang="ts">
import Icon from "@/Components/Icon.vue"

defineProps<{
    name?: string
}>()
</script>

<template>
    <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
        <Icon v-if="name" :name="name" />
        <slot />
    </div>
</template>

<style scoped></style>
