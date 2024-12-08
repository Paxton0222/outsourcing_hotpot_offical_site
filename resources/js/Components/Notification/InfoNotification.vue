<script setup lang="ts">
defineProps<{
    notify: string
}>()
</script>

<template>
    <div class="alert alert-info">
        <span>{{ notify }}</span>
    </div>
</template>

<style scoped></style>
