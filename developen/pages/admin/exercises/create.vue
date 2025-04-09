<template>
    <div class="container" style="padding-left: 34vh;">
      <h1>Create New Exercise</h1>
  
      <form @submit.prevent="createExercise" class="register-form">
        <input class="register-input" type="text" name="name" placeholder="Exercise Name" />
        <input class="register-input" type="text" name="description" placeholder="Description" />
        <input class="register-input" type="text" name="answer" placeholder="Answer" />
        <button class="register-button" type="submit">Create</button>
      </form>
    </div>
    <admin-panel />
  </template>
  

<script setup>
import axios from 'axios';

definePageMeta({
  middleware: ["$auth", "admin"],
});

const createExercise = async (e) => {
  try {
    const form = e.target;

    const payload = {
      name: form.name.value,
      description: form.description.value,
      answer: form.answer.value,
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

    await axios.post("http://localhost:9000/api/exercises", payload, {
      withCredentials: true,
      headers: {
        "X-XSRF-TOKEN": token,
        "Content-Type": "application/json",
      },
    });

    alert("Exercise created successfully!");
    // Optional: Reset form or navigate away
    form.reset();
  } catch (error) {
    console.error("Error creating exercise:", error.response?.data || error);
  }
};
</script>
