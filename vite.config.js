import { defineConfig } from "vite"
import laravel from "laravel-vite-plugin"
import vue from "@vitejs/plugin-vue"
import eslint from "vite-plugin-eslint"
import checker from "vite-plugin-checker"

export default defineConfig({
    plugins: [
        laravel({
            input: "resources/js/app.ts",
            ssr: "resources/js/ssr.ts",
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        eslint({
            include: ["./resources/js"],
        }),
        // checker({
        //     vueTsc: true,
        //     typescript: true,
        // }),
    ],
    resolve: {
        alias: {
            "@": "/resources/js",
        },
    },
})
