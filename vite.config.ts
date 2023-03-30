import { defineConfig } from "vite";

import laravel from "laravel-vite-plugin";
import react from "@vitejs/plugin-react";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'react-front/index.css',
                'react-front/main.tsx'
            ],
            refresh: true
        }),
        react()
    ]
});
