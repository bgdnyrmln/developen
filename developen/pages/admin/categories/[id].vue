<template>
  <div class="container" style="padding-left: 30vw; width: 60vw; padding-bottom: 10vh; padding-top: 10vh;">
    <h1>Edit Category</h1>
    <p>Category ID: {{ category.id }}</p>
    <p>Category Name: {{ category.name }}</p>
    <p>Category Color: <span :style="{ color: category.color }">{{ category.color }}</span></p>

    <form @submit.prevent="editCategory($event, category.id)" class="register-form">
      <input class="register-input" type="text" name="id" placeholder="id" :value="category.id" readonly />
      <input class="register-input" type="text" name="name" placeholder="Name" :value="category.name" />
      <input class="register-input-color"
       type="color" name="color" placeholder="Color" :value="category.color" />
      <button class="register-button" type="submit">Submit</button>
    </form>
  </div>
  <admin-panel />
</template>

<script setup>
import axios from 'axios';
import { useRoute, useRouter } from 'vue-router';
import { ref, onMounted } from 'vue';

const route = useRoute();
const router = useRouter();
const id = route.params.id;
const category = ref({});

onMounted(async () => {
  try {
    await axios.get("http://localhost:9000/sanctum/csrf-cookie", { withCredentials: true });

    // Fetch category details
    const categoryRes = await axios.get(`http://localhost:9000/api/categories/${id}`);
    category.value = categoryRes.data;
  } catch (error) {
    console.error("Error fetching category:", error);
  }
});

const editCategory = async (e, id) => {
  try {
    const form = e.target;
    const formData = new FormData(form);

    const payload = {
      id: formData.get("id"),
      name: formData.get("name"),
      color: formData.get("color"),
    };

    const token = decodeURIComponent(
      document.cookie
        .split("; ")
        .find((row) => row.startsWith("XSRF-TOKEN="))
        ?.split("=")[1] ?? ""
    );

    await axios.put(`http://localhost:9000/api/categories/${id}`, payload, {
      withCredentials: true,
      headers: {
        "X-XSRF-TOKEN": token,
      },
    });

    alert("Category updated successfully!");
    router.push(`/admin/categories/${id}`);
  } catch (error) {
    console.error("Error editing category:", error);
  }
};
</script>
