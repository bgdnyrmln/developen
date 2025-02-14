<template>

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
                        <a class = "button-title" href="#">lets get started</a>
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
                <div class = "card-btn">
                    <a class = "card-button" id="modal-button1" 
                    @click.prevent="setupModal('modal3')">learn more</a>  
                </div>
                <div class = "modal" id = "modal1"> 
                    <div class = "modal-content">
                        <div class = "modal-header">
                            <div class = "modal-title">
                                New feelings.
                            </div>
                        </div>
                        <div class = "modal-body">
                            <div class = "modal-text">
                                Life is a journey filled with opportunities for growth and discovery. 
                                Embracing the path to tomorrow means stepping out of your comfort zone 
                                and into a world of new possibilities. By challenging yourself, 
                                you open doors to experiences that help you learn, grow, and unlock 
                                your full potential. Each step forward brings new lessons and skills 
                                that shape you into a stronger, more capable version of yourself. 
                                It’s not just about reaching a destination; it’s about the transformation 
                                that happens along the way. So, take that leap—your future is waiting for 
                                you to claim it.
                            </div>
                        </div>
                    </div>
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
                <div class = "card-btn">
                    <a class = "card-button" href = "#" id="modal-button2" 
                    @click.prevent="setupModal('modal2')">learn more</a>
                </div>
                <div class = "modal" id = "modal2"> 
                    <div class = "modal-content">
                        <div class = "modal-header">
                            <div class = "modal-title">
                                New ideas.
                            </div>
                        </div>
                        <div class = "modal-body">
                            <div class = "modal-text">
                                The future is an open canvas, ready for those who dare to 
                                paint their dreams upon it. By stepping forward with curiosity 
                                and courage, you set yourself on a path to discover the unknown. 
                                Exploring new ideas and learning fresh skills isn’t just about 
                                personal growth—it’s about finding joy in the process and 
                                becoming part of something greater. Each moment you choose 
                                to learn and expand your horizons is a moment of empowerment, 
                                one that brings you closer to your fullest potential. Dare to try, 
                                to dream, and to create. The possibilities are endless, and it all 
                                starts with you.
                            </div>
                        </div>
                    </div>
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
                <div class = "card-btn">
                    <a class = "card-button" href = "#" id="modal-button3" 
                    @click.prevent="setupModal('modal3')">learn more</a>
                </div>
                <div class = "modal" id = "modal3"> 
                    <div class = "modal-content">
                        <div class = "modal-header">
                            <div class = "modal-title">
                                New skills.
                            </div>
                        </div>
                        <div class = "modal-body">
                            <div class = "modal-text">
                                Being open to the future means embracing the possibilities it holds and 
                                stepping into the unknown with courage and curiosity.
                                It’s about more than just dreaming of a better tomorrow—it’s about 
                                actively participating in creating it. By challenging yourself,
                                you unlock hidden potential and discover strengths you never
                                knew you had. Learning new skills not only equips you for the 
                                changes ahead but also empowers you to grow, adapt, and thrive. 
                                The future isn’t something that happens to you; it’s something you shape 
                                with every effort you make. Take the first step, and let your journey toward 
                                growth and innovation begin today.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</template>

<script>

// Modal Functionality
const disableScrolling = () => {
  document.body.style.overflow = "hidden"
}
const enableScrolling = () => {
  document.body.style.overflow = "auto"
}

// Function to open modals
const setupModal = (modalId) => {
  const modal = document.getElementById(modalId)

  if (modal) {
    modal.style.display = "block"
    disableScrolling()

    // Close modal when clicking outside content
    modal.addEventListener("click", (event) => {
      if (event.target === modal) {
        modal.style.display = "none"
        enableScrolling()
      }
    })
  }
}
</script>


<style>
.container1{
height: 80vh;
    background-image: url(background.png);
    background-size: cover;
    background-position: center center; /* Keeps the image centered */
    background-repeat: no-repeat; /* Prevents the image from repeating */
}
</style>