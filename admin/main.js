document.querySelector(".dropdown-button").addEventListener("click", function (e) {
  e.preventDefault();
  document.querySelector(".dropdown-menu").classList.toggle("show");
});

window.addEventListener("click", function (e) {
  let dropdown = document.querySelectorAll(".dropdown-menu");
  if (e.target.className !== "dropdown-menu" && !e.target.className.startsWith("fi")) {
    dropdown.forEach(el => {
      el.classList.remove("show");
    });
  }
});