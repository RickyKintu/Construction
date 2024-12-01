// Select all elements with scroll-effect or slide-in classes
const scrollElements = document.querySelectorAll('.scroll-effect, .slide-in');

// Function to check if element is in viewport
function isInViewport(el) {
    const rect = el.getBoundingClientRect();
    return (
        rect.top <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.bottom >= 0
    );
}

// Add 'visible' class when in view
function handleScroll() {
    scrollElements.forEach(el => {
        if (isInViewport(el)) {
            el.classList.add('visible');
        }
    });
}

// Listen for scroll events
window.addEventListener('scroll', handleScroll);

// Trigger animations for elements already in view on page load
handleScroll();
