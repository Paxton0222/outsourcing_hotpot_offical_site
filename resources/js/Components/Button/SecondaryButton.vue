<script lang="ts" setup>
withDefaults(
    defineProps<{
        type?: "button" | "submit" | "reset"
        loading?: boolean
    }>(),
    {
        type: "button",
        loading: false,
    }
)
</script>

<template>
    <button :type="type" class="btn btn-square py-0 w-[5rem] btn-secondary">
        <span v-if="loading" class="loading loading-spinner" />
        <slot v-else />
    </button>
</template>
