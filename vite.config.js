import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";

export default defineConfig({
    // server: {
    //     hmr: {
    //         host: localhost,
    //     },
    // },
    // server: {
    //     host: true,
    // },
    plugins: [
        laravel({
            input: "resources/js/app.js",
            refresh: true,
            // refresh: ["resources/views/**"],
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
});
