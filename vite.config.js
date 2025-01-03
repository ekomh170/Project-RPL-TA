import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
    ],
    server: {
        https: true, // Pastikan server development menggunakan HTTPS
    },
    build: {
        assetsPublicPath: "/", // Gunakan path relatif jika perlu
    },
});
