export default defineNuxtRouteMiddleware(async (to, from) => {
    const { role } = await useSanctumFetch('/api/user');

    // You may need to replace this with your actual API or logic to get the user's role
    if (role !== 2) {
      // Redirect to another page if the user is not an admin
      return navigateTo('/main'); // Or any other path (e.g., login page)
    }
  });
  