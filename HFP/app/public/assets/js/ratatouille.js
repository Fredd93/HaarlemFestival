let slideIndex = 1;

function showSlides(n) {
    const slides = document.querySelectorAll(".slide");
    const dots = document.querySelectorAll(".dot");

    const totalSlides = slides.length;
    const totalDots = dots.length;

    if (totalSlides === 0 || totalDots === 0) return;

    if (n > totalSlides) slideIndex = 1;
    if (n < 1) slideIndex = totalSlides;

    slides.forEach(slide => slide.style.display = "none");
    dots.forEach(dot => dot.classList.remove("active"));

    if (slides[slideIndex - 1]) {
        slides[slideIndex - 1].style.display = "block";
    }

    if (dots[slideIndex - 1]) {
        dots[slideIndex - 1].classList.add("active");
    }
}

function moveSlide(n) {
    showSlides(slideIndex += n);
}

function currentSlide(n) {
    showSlides(slideIndex = n);
}

document.addEventListener("DOMContentLoaded", () => {
    const slides = document.querySelectorAll(".slide");
    const dots = document.querySelectorAll(".dot");

    if (slides.length === 0 || dots.length === 0) {
        console.warn("No slides or dots found.");
        return;
    }

    showSlides(slideIndex);

    setInterval(() => {
        moveSlide(1);
    }, 5000);
});
