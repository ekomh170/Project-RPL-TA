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
        https: true, // Pastikan development menggunakan HTTPS
        proxy: {
            // Pastikan app server juga dikelola dengan baik jika ada pengaturan proxy
            "/app": "http://localhost", // Sesuaikan jika ada pengaturan backend server
        },
    },
    build: {
        // Public path untuk memastikan assets dihasilkan dengan base yang benar
        assetsPublicPath: "/",
        base: "/build/", // Set base path untuk assets
    },
});
