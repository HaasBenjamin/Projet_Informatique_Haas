import { defineConfig } from "vite";
import react from "@vitejs/plugin-react";

export default defineConfig({
  base: "/",
  plugins: [react()],
  preview: {
    port: 8080,
    strictPort: true,
  },
  server: {
    port: 8080,
    strictPort: true,
    host: true,
    origin: "http://0.0.0.0:8080",
    watch: {
      usePolling: true,
    },
  },
  define: {
    "process.env.REACT_APP_API_ENTRYPOINT": JSON.stringify(
      process.env.REACT_APP_API_ENTRYPOINT,
    ),
  },
});
