var pagesToPreload = ["config.php", "header.php", "hero.php", "footer.php", "definisi.php", "pencegahan.php", "lapor.php", "kuis.php", "loginpage.php", "registerpage.php", "about.php"];

// Fungsi untuk memuat halaman-halaman
function preloadPages() {
  pagesToPreload.forEach(function (page) {
    var preloadLink = document.createElement("link");
    preloadLink.href = page;
    preloadLink.rel = "preload";
    preloadLink.as = "document";
    document.head.appendChild(preloadLink);
  });
}

// Panggil fungsi preloadPages() ketika halaman sudah dimuat
document.addEventListener("DOMContentLoaded", preloadPages);

if (window.location.pathname === "/" || window.location.pathname === "/index.php") {
  const cardContainer = document.querySelector(".card-container");
  let isDown = false;
  let startX;
  let scrollLeft;

  cardContainer.addEventListener("mousedown", (e) => {
    isDown = true;
    cardContainer.classList.add("active");
    startX = e.pageX - cardContainer.offsetLeft;
    scrollLeft = cardContainer.scrollLeft;
    e.preventDefault();
  });

  cardContainer.addEventListener("mouseleave", () => {
    isDown = false;
    cardContainer.classList.remove("active");
  });

  cardContainer.addEventListener("mouseup", () => {
    isDown = false;
    cardContainer.classList.remove("active");
  });

  cardContainer.addEventListener("mousemove", (e) => {
    if (!isDown) return;
    e.preventDefault();
    const x = e.pageX - cardContainer.offsetLeft;
    const walk = (x - startX) * 1;
    cardContainer.scrollLeft = scrollLeft - walk;
  });

  cardContainer.addEventListener("touchstart", (e) => {
    isDown = true;
    cardContainer.classList.add("active");
    startX = e.touches[0].pageX - cardContainer.offsetLeft;
    scrollLeft = cardContainer.scrollLeft;
    e.preventDefault();
  });

  cardContainer.addEventListener("touchmove", (e) => {
    if (!isDown) return;
    e.preventDefault();
    const x = e.touches[0].pageX - cardContainer.offsetLeft;
    const walk = (x - startX) * 1;
    cardContainer.scrollLeft = scrollLeft - walk;
  });

  cardContainer.addEventListener("touchend", () => {
    isDown = false;
    cardContainer.classList.remove("active");
  });

  cardContainer.addEventListener("touchcancel", () => {
    isDown = false;
    cardContainer.classList.remove("active");
  });
}

function toggleDisplay(element) {
  var content = element.nextElementSibling;
  if (content && content.classList.contains("pencegahandropdown-content")) {
    if (content.classList.contains("hidden")) {
      content.style.display = "block";
      var height = content.scrollHeight + "px";
      content.style.height = height;
      setTimeout(function () {
        content.classList.remove("hidden");
        content.classList.add("visible");
        content.style.height = "auto";
        content.style.opacity = 1;
      }, 10);
    } else {
      content.style.height = content.scrollHeight + "px";
      setTimeout(function () {
        content.style.height = "0";
        content.style.opacity = 0;
      }, 10);
      setTimeout(function () {
        content.classList.remove("visible");
        content.classList.add("hidden");
        content.style.display = "none";
      }, 500);
    }
  }
}

document.addEventListener("DOMContentLoaded", function () {
  var elements = document.querySelectorAll(".pencegahandropdown-content");
  elements.forEach(function (element) {
    element.style.height = "0";
    element.style.opacity = "0";
    element.classList.add("hidden");
  });
});

window.onload = function () {
  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.has("submitted") && urlParams.get("submitted") === "true") {
    alert("Kuesioner berhasil terkirim! Terimakasih sudah meluangkan waktu untuk mengisi kuesioner kami!");
  }
};

// Animasi
document.addEventListener("DOMContentLoaded", () => {
  const fadeElements = document.querySelectorAll(".fade-in");

  const handleScroll = () => {
    fadeElements.forEach((element, index) => {
      const rect = element.getBoundingClientRect();
      if (rect.top < window.innerHeight && rect.bottom > 0) {
        setTimeout(() => {
          element.classList.add("visible");
        }, index * 50);
      }
    });
  };

  window.addEventListener("scroll", handleScroll);

  handleScroll();
});
