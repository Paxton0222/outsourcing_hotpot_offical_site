<script lang="ts" setup>
withDefaults(
    defineProps<{
        loading?: boolean
    }>(),
    {
        loading: false,
    }
)
</script>

<template>
    <button class="btn btn-square py-0 w-[5rem] btn-primary">
        <span v-if="loading" class="loading loading-spinner" />
        <slot v-else />
    </button>
</template>
