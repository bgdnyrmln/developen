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
    apiUrl: "/",
    authMode: "cookie",  // Switch to token-based authentication
  },
  


  nitro: {
    routeRules: {
      '/':{
        cors: true,
        proxy: 'http://localhost:9000/',
      },
      '/api/**': {
        cors: true,
        proxy: 'http://localhost:9000/api/**',
      },
      '/sanctum/**': {
        cors: true,
        proxy: 'http://localhost:9000/sanctum/**',
      },

      'auth/**': {
        cors: true,
        proxy: 'http://localhost:9000/auth/**',
      },

      '/logout': {
      proxy: 'http://localhost:9000/auth/logout',
    },

    }  
  },



  compatibilityDate: '2025-04-03',
})