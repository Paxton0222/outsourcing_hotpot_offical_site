<script lang="ts" setup>
const model = defineModel({
    type: Boolean,
})
</script>

<template>
    <input
        v-model="model"
        class="checkbox checkbox-sm"
        type="checkbox"
        :checked="model"
    />
</template>
