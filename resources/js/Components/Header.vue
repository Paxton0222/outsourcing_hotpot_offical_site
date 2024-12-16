<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
</script>

<template>
    <div class="navbar bg-base-100">
        <div class="flex-1">
            <a class="btn btn-ghost text-xl">daisyUI</a>
        </div>
        <div class="flex-none">
            <ul class="menu menu-horizontal px-1">
                <li class="px-4"><Link href="/home">首頁</Link></li>
                <li class="px-4"><Link href="/classic">經典原味</Link></li>
                <li class="px-4"><Link href="/location">門市據點</Link></li>
                <li class="px-4"><Link href="/join">加盟冒大仙</Link></li>
            </ul>
        </div>
    </div>
</template>

<style scoped>

</style>
