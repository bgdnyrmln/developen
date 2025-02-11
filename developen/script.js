  const app = Vue.createApp({
    data() {
      return {
        message: "Hello World!",
        name: "Bogdan",
        surname: "Yarmolinsqy",
        number: "+37122073901",
        aboutpage: "/pages/pages/about.html",
        contactpage: "/pages/pages/contacts.html"
      }
    }
  })
  app.mount('#app')

  
  const headerline = document.getElementById("headerline");
  const viewportHeight = window.innerHeight;
  const scrollLimit = 0.99 * viewportHeight;

  // Add an event listener for scroll event
  window.addEventListener("scroll", function() {
      // Check if page has been scrolled by at least 1 pixel
      if (window.scrollY > 0) {
        headerline.style.backgroundColor = "black"; // Change to desired color
      } else {
        headerline.style.backgroundColor = "transparent";  // Original color
      }

      if (scrollY > scrollLimit) {
        headerline.style.opacity = "0"; // Hide the div by making it transparent
        headerline.style.pointerEvents = "none"; // Disable interaction when hidden
      } else {
        headerline.style.opacity = "1";  // Show the div
        headerline.style.pointerEvents = "auto"; // Re-enable interaction
    }
    
  });


  function disableScrolling(){ // Disable scrolling
    var x=window.scrollX;
    var y=window.scrollY;
    window.onscroll=function(){window.scrollTo(x, y);};
  }

  function enableScrolling(){ // Enable scrolling
    window.onscroll=function(){};
  }



  //function that calls modal logs 
  function setupModal(buttonId, modalId) {
    const button = document.getElementById(buttonId);
    const modal = document.getElementById(modalId);
  
    button.addEventListener("click", function () {
      modal.style.display = "block"; // Open the modal
      disableScrolling(); // Disable scrolling
    });
  
    modal.addEventListener("click", function () {
      modal.style.display = "none"; // Close the modal
      enableScrolling(); // Enable scrolling
    });
  }
  
  
  setupModal("modal-button2", "modal2")
  setupModal("modal-button3", "modal3")
  

            
  document.getElementById("logo").addEventListener("click", function () {
    if(window.innerWidth <= 815) {  // works only for mobile version
      document.getElementById("side-menu").style.width = "250px"; // Open the side menu
    }
    else {
      document.getElementById("logo").href = "main.html";
    }
  });
        


  document.getElementById("close-btn").addEventListener("click", function () {
    document.getElementById("side-menu").style.width = "0"; // Close the side menu
  });


  
  const themeToggleButton = document.getElementById('theme-toggle');
  const bodyElement = document.body;

  // Function to toggle between light and dark themes
  themeToggleButton.addEventListener('click', () => {
    bodyElement.classList.toggle('light-theme');
    // Update the button text based on the current theme
    if (bodyElement.classList.contains('light-theme')) {
      themeToggleButton.textContent = 'Back to Dark Mode';
    } else {
      themeToggleButton.textContent = 'freak my eyes pls';
    }
  });
        
  console.log(app);