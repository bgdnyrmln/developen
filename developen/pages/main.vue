<template>
<headerline/>
    <div class="container1">
        <!-- down the header (big cool text 0_0, might add some animation) -->
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
                        <a class = "button-title" href="/exercises/all">lets get started</a>
                    </div>
                </div>
            </div>
       </div>

<!-- cards (need to add cool animations) -->
<div class = "cards">
    <div class="container">
        <div class="card-holder">
            <div class = "card">
                <div class = "card-image">
                    <img class="card-img" src="assets/card1.png" alt="">
                </div>
                <div class="card-title">
                    New  <span> feelings.</span>
                </div>
                <div class="card-desc">  
                    Embrace the journey <br>  
                    towards tomorrow. <br>  
                    Challenge yourself, <br>  
                    grow with each step, <br>  
                    and discover new talents. <br>  
                </div>
                
            </div>
            <div class = "card">
                <div class = "card-image">
                    <img class="card-img" src="assets/card2.png" alt="">
                </div>
                <div class="card-title">
                    New  <span> ideas.</span>
                </div>
                <div class="card-desc">  
                    Step into the future <br>  
                    with an open heart. <br>  
                    Dare to explore, <br>  
                    expand your horizons, <br>  
                    and unlock new possibilities. <br>   
                </div>
                
            </div>
            <div class = "card">
                <div class = "card-image">
                    <img class="card-img" src="assets/card3.png" alt="">
                </div>
                <div class="card-title">
                    New  <span> skills.</span>
                </div>
                <div class = "card-desc">
                    Be open to be a <br>
                    part of the future <br>
                    by trying yourself<br>
                    and learning <br>
                    new skills. <br>
                    <br>
                </div>
                
            </div>
        </div>
    </div>
</div>

<footerline/>
</template>

<script setup>
</script>


<style>

.container1{
    height: 100vh;
    background-image: url(assets/background.png);
    background-size: cover;
    background-position: center center; /* Keeps the image centered */
    background-repeat: no-repeat; /* Prevents the image from repeating */
}
</style>

