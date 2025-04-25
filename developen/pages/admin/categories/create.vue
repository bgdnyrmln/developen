<template>
    <div class="container" style="padding-left: 34vh;">
      <h1>Create New Category</h1>
  
      <form @submit.prevent="createCategory" class="register-form">
        <input class="register-input" type="text" name="name" placeholder="Category Name" />
        <input class="register-input-color"
        style="
            border: 5px solid grey;
            border-radius: 15px;" type="color" name="color" placeholder="Category Color" />
        <button class="register-button" type="submit">Create</button>
      </form>
    </div>
    <admin-panel />
  </template>
  
  <script setup>
  import axios from 'axios';
  
  const createCategory = async (e) => {
    try {
      const form = e.target;
  
      const payload = {
        name: form.name.value,
        color: form.color.value, // Color value from the color input
      };
  
      // CSRF setup
      await axios.get("http://localhost:9000/sanctum/csrf-cookie", {
        withCredentials: true,
      });
  
      const token = decodeURIComponent(
        document.cookie
          .split("; ")
          .find((row) => row.startsWith("XSRF-TOKEN="))
          ?.split("=")[1] ?? ""
      );
  
      await axios.post("http://localhost:9000/api/categories", payload, {
        withCredentials: true,
        headers: {
          "X-XSRF-TOKEN": token,
          "Content-Type": "application/json",
        },
      });
  
      alert("Category created successfully!");
      form.reset();
    } catch (error) {
      console.error("Error creating category:", error.response?.data || error);
    }
  };
  </script>
  