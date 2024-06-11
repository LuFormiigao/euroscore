function mostrarRegistro() {
    document.getElementById("login").style.display = "none";
    document.getElementById("registro").style.display = "block";
}

function mostrarLogin() {
    document.getElementById("registro").style.display = "none";
    document.getElementById("login").style.display = "block";
}

// Scroll
function direcao(e) {
    var direcao = document.getElementById("slide");
    var scrollAmount = 200; // Valor de scroll
    var scrollMax = direcao.scrollWidth - direcao.clientWidth; // Valor máximo de scroll

    if (e == 1) {
        // esquerda
        if (direcao.scrollLeft - scrollAmount <= 0) {
            direcao.scrollLeft = scrollMax; // Volta para o final
        } else {
            direcao.scrollLeft -= scrollAmount;
        }
    } else if (e == 2) {
        // direita
        if (direcao.scrollLeft + scrollAmount >= scrollMax) {
            direcao.scrollLeft = 0; // Volta para o início
        } else {
            direcao.scrollLeft += scrollAmount;
        }
    }
}

// Carrossel
const btnNext = document.getElementById("nextSlide");
const btnPrevious = document.getElementById("previousSlide");
const carrossel = document.querySelector(".carrossel-content");
const content = document.querySelector(".carrossel");
const dots = document.querySelectorAll(".dot");
const slides = document.querySelectorAll(".imagem-content");

let counter = 0;
let autoSlideInterval;

if (btnNext && btnPrevious && carrossel && content) {
    const sliderStyle = window.getComputedStyle(carrossel);
    const contentStyle = window.getComputedStyle(content);

    const sliderWidth = parseInt(sliderStyle.width);
    const contentWidth = carrossel.scrollWidth;

    const slideProps = {
        width: sliderWidth,
        scroll: 0,
    };

    function updateIndicators() {
        dots.forEach((dot, index) => {
            if (index === counter) {
                dot.classList.add("active");
            } else {
                dot.classList.remove("active");
            }
        });
    }

    function controlSlide(event) {
        const id = event ? event.target.id : "nextSlide";
        if (id === "nextSlide") {
            if (slideProps.scroll + slideProps.width < contentWidth) {
                slideProps.scroll += slideProps.width;
                counter = (counter + 1) % slides.length;
            } else {
                slideProps.scroll = 0;
                counter = 0;
            }
        } else if (id === "previousSlide") {
            if (slideProps.scroll - slideProps.width >= 0) {
                slideProps.scroll -= slideProps.width;
                counter = (counter - 1 + slides.length) % slides.length;
            } else {
                slideProps.scroll = contentWidth - slideProps.width;
                counter = slides.length - 1;
            }
        }
        carrossel.scrollLeft = slideProps.scroll;
        updateIndicators();
    }

    function startAutoSlide() {
        autoSlideInterval = setInterval(() => {
            controlSlide();
        }, 5000);
    }

    function stopAutoSlide() {
        clearInterval(autoSlideInterval);
    }

    btnNext.addEventListener("click", () => {
        controlSlide({ target: btnNext });
        stopAutoSlide();
        startAutoSlide();
    });
    btnPrevious.addEventListener("click", () => {
        controlSlide({ target: btnPrevious });
        stopAutoSlide();
        startAutoSlide();
    });

    window.addEventListener("load", () => {
        carrossel.scrollLeft = 0;
        slideProps.scroll = 0;
        updateIndicators();
        startAutoSlide();
    });
}

// Champions Page - Exibe as partidas de acordo com a data
document.addEventListener("DOMContentLoaded", function () {
    const buttons = document.querySelectorAll(".champions-data-jogos");
    const matches = document.querySelectorAll(".partida-content");

    buttons.forEach((button) => {
        button.addEventListener("click", function () {
            const selectedDate = this.getAttribute("data-date");

            buttons.forEach((btn) => btn.classList.remove("active"));

            this.classList.add("active");

            matches.forEach((match) => {
                if (match.getAttribute("data-date") === selectedDate) {
                    match.style.display = "flex";
                    setTimeout(() => {
                        match.classList.add("partida-visible");
                    }, 10);
                } else {
                    match.classList.remove("partida-visible");
                    match.addEventListener(
                        "transitionend",
                        function () {
                            if (!match.classList.contains("partida-visible")) {
                                match.style.display = "none";
                            }
                        },
                        { once: true }
                    );
                }
            });
        });
    });
    document.querySelector(".champions-data-jogos.active").click();
});
