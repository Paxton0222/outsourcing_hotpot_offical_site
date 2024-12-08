<script lang="ts" setup>
defineProps<{
    value?: string
}>()
</script>

<template>
    <div class="label">
        <span v-if="value" class="label-text">{{ value }}</span>
        <span v-else class="label-text"><slot /></span>
    </div>
</template>
