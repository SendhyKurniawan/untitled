const navbar = document.getElementById("navbar");

window.addEventListener("scroll", function () {
  if (window.pageYOffset > 0) {
    navbar.classList.add("navbar-after-scroll");
  } else {
    navbar.classList.remove("navbar-after-scroll");
  }
});
