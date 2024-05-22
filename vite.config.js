import { defineConfig } from "vite";
import { resolve } from "path";
import laravel from "laravel-vite-plugin";

export default defineConfig({
  resolve: {
    alias: {
      "~bootstrap": resolve(__dirname, "node_modules/bootstrap"),
      "~bootstrap-icons": resolve(__dirname, "node_modules/bootstrap-icons"),
      "~perfect-scrollbar": resolve(
        __dirname,
        "node_modules/perfect-scrollbar",
      ),
      "~@fontsource": resolve(__dirname, "node_modules/@fontsource"),
    },
  },
  plugins: [
    laravel({
      input: [
        "resources/scss/bootstrap.scss",
        "resources/scss/themes/dark/app-dark.scss",
        "resources/scss/app.scss",
        "resources/scss/pages/auth.scss",
        "resources/css/app.css",
        "resources/js/app.js",
        "resources/js/initTheme.js",
      ],
      refresh: true,
    }),
  ],
});
