function loadPage(url) {
  window.location.href = url; // Redirects to the specified URL
}

// Attach event listeners to buttons
document.getElementById('lgbtn').addEventListener('click', function() {
  loadPage('login.html'); // Redirect to the login page
});

document.getElementById('rgbtn').addEventListener('click', function() {
  loadPage('register.html'); // Redirect to the register page
});