const navbar = document.getElementById("navbar");

window.addEventListener("scroll", function () {
  if (window.pageYOffset > 0) {
    navbar.classList.add("navbar-after-scroll");
  } else {
    navbar.classList.remove("navbar-after-scroll");
  }
});

document.addEventListener("DOMContentLoaded", function () {
  const mobileMenuIcon = document.getElementById("mobile-menu-icon");
  const navMenu = document.getElementById("nav-menu");

  mobileMenuIcon.addEventListener("click", function () {
    console.log("Menu icon clicked"); // Debugging line
    navMenu.classList.toggle("active");
  });
});

// Script for handling scroll effect
window.addEventListener("scroll", function () {
  const navbar = document.getElementById("navbar");
  if (window.scrollY > 50) {
    navbar.classList.add("navbar-after-scroll");
  } else {
    navbar.classList.remove("navbar-after-scroll");
  }
});

document.getElementById("mobile-menu-icon").addEventListener("click", function () {
  document.querySelector(".nav-menu").classList.toggle("nav-menu-visible");
});
