<template>
    <div class="card bg-base-200 w-full shadow-xl h-full">
        <div class="card-body h-full">
            <div class="card-title">
                <slot name="title" />
            </div>
            <slot />
            <div class="card-actions justify-end gap-4 items-center">
                <slot name="actions" />
            </div>
        </div>
    </div>
</template>
