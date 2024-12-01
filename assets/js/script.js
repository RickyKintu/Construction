const slider = document.querySelector('.slider');
const slides = Array.from(document.querySelectorAll('.slide'));
const prevButton = document.querySelector('.prev');
const nextButton = document.querySelector('.next');

let currentIndex = slides.length; // Start after the prepended clones
let isTransitioning = false;

// Clone all slides and append/prepend them
slides.forEach(slide => {
    const cloneFirst = slide.cloneNode(true); // Clone for prepending
    const cloneLast = slide.cloneNode(true); // Clone for appending

    slider.appendChild(cloneLast); // Append clones to the end
    slider.insertBefore(cloneFirst, slides[0]); // Prepend clones to the beginning
});

// Update allSlides to include original slides + clones
const allSlides = Array.from(document.querySelectorAll('.slide'));

// Calculate slide dimensions
const slideWidth = 400; // Fixed slide width
const gap = 16; // Space between slides
const totalSlides = allSlides.length;
const totalWidth = (slideWidth + gap) * totalSlides;

// Set slider width dynamically
slider.style.width = `${totalWidth}px`;

// Initial position (centered on the original first slide)
slider.style.transform = `translateX(-${currentIndex * (slideWidth + gap)}px)`;

// Function to update slider position
function updateSlider() {
    slider.style.transition = 'transform 0.5s ease-in-out';
    slider.style.transform = `translateX(-${currentIndex * (slideWidth + gap)}px)`;

    slider.addEventListener('transitionend', handleCircularTransition);
}

// Handle looping for seamless transitions
function handleCircularTransition() {
    slider.removeEventListener('transitionend', handleCircularTransition);

    if (currentIndex >= totalSlides - slides.length) {
        // If we're past the last set of real slides, jump to the first set
        currentIndex = slides.length;
        slider.style.transition = 'none';
        slider.style.transform = `translateX(-${currentIndex * (slideWidth + gap)}px)`;
    }

    if (currentIndex < slides.length) {
        // If we're before the first set of real slides, jump to the last set
        currentIndex = totalSlides - slides.length * 2;
        slider.style.transition = 'none';
        slider.style.transform = `translateX(-${currentIndex * (slideWidth + gap)}px)`;
    }

    isTransitioning = false;
}

// Move to the next slide
function goToNextSlide() {
    if (isTransitioning) return;
    isTransitioning = true;

    currentIndex++;
    updateSlider();
}

// Move to the previous slide
function goToPrevSlide() {
    if (isTransitioning) return;
    isTransitioning = true;

    currentIndex--;
    updateSlider();
}

// Event listeners for buttons
nextButton.addEventListener('click', goToNextSlide);
prevButton.addEventListener('click', goToPrevSlide);

// Auto-slide functionality
setInterval(() => {
    if (!isTransitioning) {
        goToNextSlide();
    }
}, 3000);


// Smooth scrolling with optional offset
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault(); // Prevent the default anchor behavior

        const targetId = this.getAttribute('href').substring(1); // Get the target ID
        const targetElement = document.getElementById(targetId);

        if (targetElement) {
            // Scroll to the target element with an offset for sticky navbar
            const offset = 80; // Adjust this value based on your navbar height
            const elementPosition = targetElement.getBoundingClientRect().top;
            const offsetPosition = elementPosition + window.pageYOffset - offset;

            window.scrollTo({
                top: offsetPosition,
                behavior: 'smooth', // Smooth scrolling
            });
        }
    });
});
