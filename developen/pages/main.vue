<template>
    <headerline />
    <div class="container1">
      <div class="header-down">
        <div class="header-title">
          Welcome to the
          <div class="header-subtitle">
            DevelOpen.
          </div>
          <div class="header-suptitle">
            Place to start your journey.
          </div>
          <div class="btn">
            <a class="button-title" href="/exercises">
              Let's get started</a>
          </div>
        </div>
      </div>
    </div>
  
    <!-- cards (need to add cool animations) -->
    <div class="cards">
      <div class="container">
        <div class="card-holder">
          <!-- Card 1 -->
          <div class="card">
            <div class="card-image">
              <img class="card-img" src="assets/card1.png" alt="">
            </div>
            <div class="card-title">
              New <span>{{ 1 }}.</span>
            </div>
            <div class="card-desc">
              {{ 1 }} <br>
            </div>
          </div>
          <!-- Card 2 -->
          <div class="card">
            <div class="card-image">
              <img class="card-img" src="assets/card2.png" alt="">
            </div>
            <div class="card-title">
              New <span>{{ 1 }}.</span>
            </div>
            <div class="card-desc">
              {{ 1 }} <br>
            </div>
          </div>
          <!-- Card 3 -->
          <div class="card">
            <div class="card-image">
              <img class="card-img" src="assets/card3.png" alt="">
            </div>
            <div class="card-title">
              New <span>{{ 1 }}.</span>
            </div>
            <div class="card-desc">
              {{ 1 }} <br>
            </div>
          </div>
        </div>
      </div>
    </div>
  
    <footerline />
  </template>
  
  <script setup>
  import { ref } from 'vue';
  

  // const data = await $fetch('/api/cards');
  
  // // Extract all the IDs
  // const allIds = data.map(item => item.id);
  
  // // Shuffle the IDs and pick the first 3
  // const shuffledIds = allIds.sort(() => 0.5 - Math.random());
  // const [randomId1, randomId2, randomId3] = shuffledIds.slice(0, 3);
  
  // // Find the corresponding cards
  // const randomCards = data.filter(item =>
  //   item.id === randomId1 || item.id === randomId2 || item.id === randomId3
  // );

  
  
  </script>
  
  <style>
  .container1 {
    height: 100vh;
    background-image: url(assets/background.png);
    background-size: cover;
    background-position: center center;
    background-repeat: no-repeat;
  }
  
  </style>
  