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
    apiUrl: "http://localhost:9000/",  // API URL for Sanctum authentication
    authMode: "token",  // Switch to token-based authentication
  },




  compatibilityDate: '2025-04-03',
})