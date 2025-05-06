<template>
  <!-- header component -->
  <headerline />

  <!-- Login form container -->
  <div class="register">
    <div class="container">
      <div class="register-title">
        <h1>Welcome back!</h1>
      </div>
      <div class="register-text">
        <p>Log into your account.</p>
      </div>

      <!-- Form section -->
      <div class="register-form">
        <div class="form-group">
          <!-- Form submit is handled via submitForm function -->
          <form @submit.prevent="submitForm">

            <!-- Email input -->
            <label class="register-text" for="email">Email:</label>
            <input
              class="register-input"
              type="email"
              id="email"
              v-model="form.email"
              placeholder="Enter your email"
            />

            <!-- Password input -->
            <label class="register-text" for="password">Password:</label>
            <input
              class="register-input"
              type="password"
              id="password"
              v-model="form.password"
              placeholder="Enter your password"
            />

            <!-- Error message shown only if login fails -->
            <p v-if="error" style="color: red;">{{ error }}</p>

            <!-- Submit button -->
            <button class="register-button" type="submit">Enter</button>
          </form>

          <!-- Link to registration page -->
          <button class="register-button" @click="navigateTo('/register')">
            Don't have an account
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Bottom footer component -->
  <footerline />
</template>

<script setup>
import axios from 'axios';
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';

// Router instance to programmatically navigate pages
const router = useRouter();

// Middleware to restrict this page to guests only
definePageMeta({
  middleware: ["$guest"],
});

// Setup CSRF protection on mount for Laravel Sanctum
onMounted(async () => {
  await axios.get("/sanctum/csrf-cookie", {
    withCredentials: true
  });
});

// Login form state
const form = ref({
  email: '',
  password: ''
});

// Error message to display login issues
const error = ref(null);

// Provided by sanctum module to refresh auth state after login
const { refreshUser } = useSanctum();

// Handle form submission
const submitForm = async () => {
  try {
    // Retrieve CSRF token from browser cookies
    const token = decodeURIComponent(
      document.cookie
        .split("; ")
        .find((row) => row.startsWith("XSRF-TOKEN="))
        ?.split("=")[1] ?? ""
    );

    // Attempt login request
    await axios.post("http://localhost:9000/login", form.value, {
      withCredentials: true,
      headers: {
        "X-XSRF-TOKEN": token,
      },
    });

    // Refresh user session after login
    await refreshUser();

    // Redirect to exercises page on success
    router.push("/exercises");
  } catch (err) {
    // Show generic error message on failure
    error.value = "Invalid username or password";
    console.error("Login error:", err);
  }
};
</script>
