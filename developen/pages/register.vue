<template>
    <div class="register">
      <div class="container">
        <div class="register-title">
          <h1>Let's get started!</h1>
        </div>
        <div class="register-text">
          <p>Fill in the form below to create an account.</p>
        </div>
        <div class="register-form">
          <form @submit.prevent="register"> 
            <div class="form-group">
              <label class="register-text" for="name">Name:</label>
              <input class="register-input" type="text" id="name" v-model="name" placeholder="Enter your name" required />
  
              <label class="register-text" for="surname">Surname:</label>
              <input class="register-input" type="text" id="surname" v-model="surname" placeholder="Enter your surname" required />
  
              <label class="register-text" for="username">Username:</label>
              <input class="register-input" type="text" id="username" v-model="username" placeholder="Enter your username" required />
  
              <label class="register-text" for="password">Password:</label>
              <input class="register-input" type="password" id="password" v-model="password" placeholder="Enter your password" required />
  
              <button class="register-button" type="submit">Enter</button>
              <button class="register-button">Already have an account?</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue'
  
  const name = ref('')
  const surname = ref('')
  const username = ref('')
  const password = ref('')
  
  const register = async () => {
    if (!name.value || !surname.value || !username.value || !password.value) {
      alert('Please fill out all fields!')
      return
    }
  
    try {
      const response = await fetch('/api/register', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          name: name.value,
          surname: surname.value,
          username: username.value,
          password: password.value
        })
      })
  
      const result = await response.json()
      console.log(result) // Check response in console
  
      if (result.success) {
        alert('Registration successful!')
        name.value = ''
        surname.value = ''
        username.value = ''
        password.value = ''
      } else {
        alert(`Error: ${result.error}`)
      }
    } catch (error) {
      console.error('Error:', error)
      alert('Something went wrong, please try again.')
    }
  }
  </script>
  
  <style>
  .register {
    height: 100vh;
    background-image: url(assets/background3.png);
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
  }
  </style>
  