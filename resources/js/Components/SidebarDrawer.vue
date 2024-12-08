<script setup lang="ts">
import MenuIcon from "@/Components/Button/MenuIcon.vue"

withDefaults(
    defineProps<{
        id?: string
    }>(),
    {
        id: "sidebar-drawer",
    }
)
</script>

<template>
    <div class="drawer">
        <input :id="id" type="checkbox" class="drawer-toggle" />
        <div class="drawer-content">
            <label :for="id" class="drawer-button">
                <slot name="btn">
                    <MenuIcon />
                </slot>
            </label>
        </div>
        <div class="drawer-side z-50">
            <label
                :for="id"
                aria-label="close sidebar"
                class="drawer-overlay"
            ></label>
            <slot />
        </div>
    </div>
</template>
