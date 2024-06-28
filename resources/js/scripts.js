const carouselContainer = document.querySelector(".champions-content");
const prevBtn = document.getElementById("prevBtn");
const nextBtn = document.getElementById("nextBtn");
const buttons = document.querySelectorAll(".champions-data-jogos");

let scrollAmount = 0;
const buttonWidth = buttons[0].offsetWidth + 10; // largura do botão + gap
const maxScroll = carouselContainer.scrollWidth - carouselContainer.clientWidth;

nextBtn.addEventListener("click", () => {
  if (scrollAmount < maxScroll) {
    scrollAmount += buttonWidth;
  } else {
    // Voltar ao início
    scrollAmount = 0;
  }
  carouselContainer.scrollTo({
    top: 0,
    left: scrollAmount,
    behavior: "smooth",
  });
});

prevBtn.addEventListener("click", () => {
  if (scrollAmount > 0) {
    scrollAmount -= buttonWidth;
  } else {
    // Ir para o final
    scrollAmount = maxScroll;
  }
  carouselContainer.scrollTo({
    top: 0,
    left: scrollAmount,
    behavior: "smooth",
  });
});

