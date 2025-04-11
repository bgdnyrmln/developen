import {  useRoute  } from 'vue-router';


export default defineNuxtRouteMiddleware(async (to, from) => {
    const route = useRoute();
    const routeid = to.params.id; // Access `id` from `to.params`
  
    const { id } = await useSanctumFetch('http://localhost:9000/api/user');
  
    if (id !== Number(routeid)) {
      return navigateTo('/main');
    }
  });
  
  