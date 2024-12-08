<script setup lang="ts">
import MenuIcon from "@/Components/Button/MenuIcon.vue"
</script>

<template>
    <div class="dropdown">
        <slot name="btn">
            <MenuIcon />
        </slot>
        <ul
            tabindex="0"
            class="menu menu-sm dropdown-content bg-base-200 rounded-box z-[1] mt-5 min-w-52 p-4 shadow-md [&>li>*]:p-3"
        >
            <slot />
        </ul>
    </div>
</template>
