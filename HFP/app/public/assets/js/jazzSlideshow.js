document.addEventListener("DOMContentLoaded", function () {
    let slideIndex = 0;
    let slides = document.querySelectorAll(".slide");
    let dots = document.querySelectorAll(".dot");

    if (slides.length === 0) {
        console.warn("No slides found. Check if the images exist.");
        return;
    }

    function showSlides(n) {
        if (n !== undefined) {
            slideIndex = n - 1; // Adjust for zero-based index
        } else {
            slideIndex++;
        }

        if (slideIndex >= slides.length) {
            slideIndex = 0;
        }

        slides.forEach((slide, i) => {
            slide.style.display = i === slideIndex ? "block" : "none";
            dots[i].classList.toggle("active", i === slideIndex);
        });

        setTimeout(showSlides, 3000);
    }

    window.currentSlide = function (n) {
        showSlides(n);
    };

    showSlides();
});
