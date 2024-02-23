document.addEventListener("DOMContentLoaded", function () {

    // Get all elements with the class 'clickable'
    const clickableItems = document.querySelectorAll('.clickable');
  
    // Add a click event listener to each of them
    clickableItems.forEach(item => {
      item.addEventListener('click', function () {
        // Get the value from the 'data-value' attribute
        const pageValue = item.getAttribute('data-value');
  
        // Redirect to the appropriate page based on the value
        window.location.href = pageValue; // Navigate to the clicked page
      });
    });
  

});