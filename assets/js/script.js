const slider = document.querySelector('.slider');
if (slider) {
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
        } else if (currentIndex < slides.length) {
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

        if (currentIndex < 0) {
            currentIndex = totalSlides - 1;
            slider.style.transition = 'none';
            slider.style.transform = `translateX(-${currentIndex * (slideWidth + gap)}px)`;
            requestAnimationFrame(() => {
                currentIndex--;
                updateSlider();
            });
        } else {
            updateSlider();
        }
    }

    // Event listeners for buttons
    nextButton.addEventListener('click', goToNextSlide);
    prevButton.addEventListener('click', goToPrevSlide);

    // Auto-slide functionality
    let autoSlide = setInterval(() => {
        if (!isTransitioning) {
            goToNextSlide();
        }
    }, 3000);

    // Pause auto-slide on hover
    slider.addEventListener('mouseenter', () => clearInterval(autoSlide));
    slider.addEventListener('mouseleave', () => {
        autoSlide = setInterval(() => {
            if (!isTransitioning) {
                goToNextSlide();
            }
        }, 3000);
    });
}

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

document.addEventListener('DOMContentLoaded', function () {
    // Function to animate counting numbers
    function animateCountUp(element, start, end, duration, hasPlus) {
        let startTime = null;

        function countStep(currentTime) {
            if (!startTime) startTime = currentTime;
            const progress = Math.min((currentTime - startTime) / duration, 1); // Ensure progress does not exceed 1
            const value = Math.floor(progress * (end - start) + start);
            element.textContent = value;

            if (progress < 1) {
                requestAnimationFrame(countStep);
            } else if (hasPlus) {
                element.textContent += '+'; // Append "+" after counting finishes
            }
        }

        requestAnimationFrame(countStep);
    }

    // Observe when the stats section comes into view
    const statsSection = document.querySelector('.statistics');
    const stats = document.querySelectorAll('.stat-box h3');

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                stats.forEach(stat => {
                    const textContent = stat.textContent.trim();
                    const hasPlus = textContent.includes('+'); // Check if "+" is present
                    const targetValue = parseInt(textContent.replace(/\D/g, '')); // Extract number value
                    animateCountUp(stat, 0, targetValue, 3000, hasPlus); // Pass `hasPlus` to function
                });
                observer.disconnect(); // Stop observing after animation runs
            }
        });
    }, { threshold: 0.1 }); // Trigger when 10% of the section is visible

    observer.observe(statsSection);
});
