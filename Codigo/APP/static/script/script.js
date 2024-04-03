const header = document.querySelector("header");
const hamburgerBtn = document.querySelector("#hamburger-btn");
const closeMenuBtn = document.querySelector("#close-menu-btn");

// Toggle mobile menu on hamburger button click
hamburgerBtn.addEventListener("click", () => header.classList.toggle("show-mobile-menu"));

// Close mobile menu on close button click
closeMenuBtn.addEventListener("click", () => hamburgerBtn.click());
//Mudar cor da NavBar
window.addEventListener('scroll', function() {
const navbar = document.querySelector('nav.navbar');
if (window.scrollY > 0) {
navbar.classList.add('scrolled');
} else {
navbar.classList.remove('scrolled');
}
});