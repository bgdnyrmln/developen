function onEntry(entry) {
    entry.forEach(change => {
      if (change.isIntersecting) {
       change.target.classList.add('cards-show');
      }
    });
  }
  
  let options = {
    threshold: [0.5] };
  let observer = new IntersectionObserver(onEntry, options);
  let elements = document.querySelectorAll('.cards-animation');
  
  for (let elm of elements) {
    observer.observe(elm);
  }


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
  



  $( ".changetheme" ).on("click", function() {
    if( $( "body" ).hasClass( "dark" )) {
        $( "body" ).removeClass( "dark" );
        $( ".changetheme" ).text( "unfreak my eyes pls" );
    } else {
        $( "body" ).addClass( "dark" );
        $( ".change" ).text( "ON" );
    }
});