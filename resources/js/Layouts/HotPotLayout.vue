<script setup lang="ts">

</script>

<template>
    <slot name="header" />
    <slot name="content">
        <slot name="banner"></slot>
    </slot>
    <slot name="footer" />
</template>

<style scoped>

</style>
