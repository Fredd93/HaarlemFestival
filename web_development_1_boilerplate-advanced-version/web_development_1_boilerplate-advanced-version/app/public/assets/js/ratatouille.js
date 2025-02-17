// Image Slideshow for "A Glimpse of Ratatouille"
let slideIndex = 1;

function showSlides(n) {
    let slides = document.querySelectorAll(".slide");
    let dots = document.querySelectorAll(".dot");

    if (n > slides.length) { slideIndex = 1; }
    if (n < 1) { slideIndex = slides.length; }

    slides.forEach(slide => slide.style.display = "none");
    dots.forEach(dot => dot.classList.remove("active"));

    slides[slideIndex - 1].style.display = "block";
    dots[slideIndex - 1].classList.add("active");
}

// Move Slide
function moveSlide(n) {
    showSlides(slideIndex += n);
}

// Jump to a specific slide
function currentSlide(n) {
    showSlides(slideIndex = n);
}

// Auto Play
setInterval(() => {
    moveSlide(1);
}, 5000);

// Initialize the slider on page load
document.addEventListener("DOMContentLoaded", () => {
    showSlides(slideIndex);
});


