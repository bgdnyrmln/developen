// nuxt.config.ts
export default defineNuxtConfig({
  app: {
    head: {
      title: 'DevelOpen',
      meta: [{ name: 'description', content: 'A Nuxt 3 application' }],
      link: [{ rel: 'icon', type: 'image/x-icon', href: 'assets/logo.png' }],
    },
  },
  qiet: false,
  routeRules: {
    "/": {
      // Temporary redirect using a 307 status code
      redirect: "/main",
    }
  },


  compatibilityDate: '2025-02-11'
})