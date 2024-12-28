<<<<<<< HEAD
let login = document.getElementById('login-btn');
let register = document.getElementById('register-btn');

login.addEventListener('click', () => {
  window.location.href = 'login.html';
})
register.addEventListener('click', () => {
  window.location.href = 'register.html';
})
=======
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
>>>>>>> a20b91df91cf93a53c68079aad8cd8787435106e
