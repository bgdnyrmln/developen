// nuxt.config.ts
export default defineNuxtConfig({

  app: {
    head: {
      title: 'DevelOpen',
      meta: [{ name: 'description', content: 'A Nuxt 3 application' }],
      link: [{ rel: 'icon', type: 'image/x-icon', href: 'assets/logo.png' }],
    },
  },

  routeRules: {
    "/": {
      // Temporary redirect using a 307 status code
      redirect: "/main",
    }
  },
  modules: ['nuxt-mapbox', 'nuxt-maplibre', 'nuxt-auth-utils', "@qirolab/nuxt-sanctum-authentication"],

  laravelSanctum: {
    apiUrl: process.env.BACKEND_URL,  // Make sure this points to your backend URL
    authMode: "cookie",  // Cookie-based authentication with Sanctum
  },
  

  nitro: {
    routeRules: {
      '/api/**': {
        cors: true,
        proxy: process.env.BACKEND_URL + '/api/**',  // Ensure this points to your backend API
      },
      '/sanctum/csrf-cookie': {
        cors: true,
        proxy: process.env.BACKEND_URL + '/sanctum/csrf-cookie',  // Handle CSRF token request
      },
    },
  },
  




  compatibilityDate: '2025-04-03',
})