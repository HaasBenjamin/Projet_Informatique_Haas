import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'
import { VitePWA } from 'vite-plugin-pwa'

// https://vitejs.dev/config/
export default defineConfig({
	build: {
		rollupOptions: {
			output: {
			entryFileNames: 'js/app.js'
			},
		},
  },
  plugins: [
    react(),
  VitePWA({
	strategies: 'injectManifest',
    includeAssets: ['icons/icon-512x512.png','icons/favicon.ico'],
	manifest: {
	"short_name": "ToDoList",
	"icons": [
		{
			"src": "icons/pwa-64x64.png",
			"sizes": "64x64",
			"type": "image/png"
		},
		{
			"src": "icons/pwa-192x192.png",
			"sizes": "192x192",
			"type": "image/png"
		},
		{
			"src": "icons/pwa-512x512.png",
			"sizes": "512x512",
			"type": "image/png",
			"purpose": "any"
		},
		{
			"src": "icons/maskable-icon-512x512.png",
			"sizes": "512x512",
			"type": "image/png",
			"purpose": "maskable"
		}
		],
		"start_url": "/",
		"display": "standalone",
		"screenshots": [
			{
				"src": "/icons/maskable-icon-512x512.png",
				"type": "image/png",
				"sizes": "512x512"
			},
			{
				"src": "/icons/pwa-512x512.png",
				"type": "image/jpg",
				"sizes": "512x512",
				"form_factor": "wide"
			}
			]
	}
  })
  ],
})


