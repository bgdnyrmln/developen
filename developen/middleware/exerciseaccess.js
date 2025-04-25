export default defineNuxtRouteMiddleware(async (to, from) => {
    const routeid = Number(to.params.id);
  
    const user = await useSanctumFetch('/api/user');
  
    // In your previous code: typo: `exerices_count` => `exercises_count`
    if (user.exercises_count < routeid) {
      return navigateTo('/exercises');
    }
  });
  