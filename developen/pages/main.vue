<template>
  <!-- Header component -->
  <headerline />

  <!-- main section -->
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
        <!-- Call-to-action button -->
        <div class="btn">
          <a class="button-title" href="/exercises">
            Let's get started
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Cards section (placeholder data for now) -->
  <div class="cards">
    <div class="container">
      <div class="card-holder">
        <!-- Card 1 -->
        <div class="card">
          <div class="card-image">
            <img class="card-img" src="assets/card1.png" alt="">
          </div>
          <div class="card-title">
            New <span>perspectives.</span>
          </div>
          <div class="card-desc">
            See the world through fresh eyes, <br>
            embrace what’s different, <br>
            and open your mind to endless opportunities. <br>
          </div>
        </div>

        <!-- Card 2 -->
        <div class="card">
          <div class="card-image">
            <img class="card-img" src="assets/card2.png" alt="">
          </div>
          <div class="card-title">
            New <span> challenges.</span>
          </div>
          <div class="card-desc">                    
            Push past your comfort zone, <br>
            face your fears, <br>
            and grow stronger every day. <br>
          </div>
        </div>

        <!-- Card 3 -->
        <div class="card">
          <div class="card-image">
            <img class="card-img" src="assets/card3.png" alt="">
          </div>
          <div class="card-title">
            New <span> connections.</span>
          </div>
          <div class="card-desc">
            Meet new people, <br>
            build meaningful relationships, <br>
            and learn from diverse perspectives. <br>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer component -->
  <footerline />
</template>


<style>
/* Full-height background image for main section */
.container1 {
  height: 100vh;
  background-image: url(assets/background.png);
  background-size: cover;
  background-position: center center;
  background-repeat: no-repeat;
}
</style>
