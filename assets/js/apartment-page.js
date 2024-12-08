document.addEventListener('DOMContentLoaded', () => {
    const mainImage = document.getElementById('current-image');
    const imageLabel = document.getElementById('image-label');
    const thumbnails = document.querySelectorAll('.thumbnails img');

    // Add click event to each thumbnail
    thumbnails.forEach(thumbnail => {
        thumbnail.addEventListener('click', () => {
            mainImage.src = thumbnail.src;
            imageLabel.textContent = thumbnail.getAttribute('data-label');

            // Remove active class from all thumbnails
            thumbnails.forEach(thumb => thumb.classList.remove('active'));

            // Add active class to clicked thumbnail
            thumbnail.classList.add('active');
        });
    });

    // Key bindings for navigation
    document.addEventListener('keydown', (e) => {
        const currentIndex = Array.from(thumbnails).findIndex(
            thumbnail => thumbnail.src === mainImage.src
        );

        if (e.key === 'ArrowRight') {
            const nextIndex = (currentIndex + 1) % thumbnails.length;
            thumbnails[nextIndex].click();
        } else if (e.key === 'ArrowLeft') {
            const prevIndex = (currentIndex - 1 + thumbnails.length) % thumbnails.length;
            thumbnails[prevIndex].click();
        }
    });

    // Set the first thumbnail as active on page load
    thumbnails[0].classList.add('active');
});

document.addEventListener('DOMContentLoaded', function () {
    // Select all info buttons
    const infoButtons = document.querySelectorAll('.info-btn');

    infoButtons.forEach((btn) => {
        // Extract and store the title attribute value in a data-tooltip attribute
        const tooltipText = btn.getAttribute('title');
        if (tooltipText) {
            btn.setAttribute('data-tooltip', tooltipText);
            btn.removeAttribute('title'); // Remove default tooltip
        }
    });
});
document.addEventListener("DOMContentLoaded", () => {
    const galleryModal = document.querySelector(".gallery-modal");
    const closeBtn = document.querySelector(".gallery-modal .close-btn");
    const fullscreenBtn = document.getElementById("fullscreen-btn");
    const mainImage = document.getElementById("current-image");
    const galleryImages = Array.from(document.querySelectorAll(".gallery-modal .gallery-images img"));
    const thumbnails = Array.from(document.querySelectorAll(".thumbnails img"));
    const positionIndicator = document.createElement("div");

    let currentIndex = 0;
    let indicatorTimeout;

    // Create position indicator
    positionIndicator.className = "position-indicator";
    galleryModal.appendChild(positionIndicator);

    const updateGalleryView = () => {
        galleryImages.forEach((img, index) => {
            const offset = index - currentIndex;
            img.style.transform = `translateX(${offset * 110}%) scale(${index === currentIndex ? 1.1 : 0.8})`;
            img.style.opacity = index === currentIndex ? "1" : "0.5";
            img.style.zIndex = index === currentIndex ? "2" : "1";
        });

        // Update position indicator
        positionIndicator.textContent = `${currentIndex + 1}/${galleryImages.length}`;
        positionIndicator.style.opacity = "1";

        // Fade out position indicator after 3 seconds
        clearTimeout(indicatorTimeout);
        indicatorTimeout = setTimeout(() => {
            positionIndicator.style.opacity = "0";
        }, 3000);
    };

    // Define enterRealFullscreen function
    const enterRealFullscreen = () => {
        if (galleryModal.requestFullscreen) {
            galleryModal.requestFullscreen();
        } else if (galleryModal.webkitRequestFullscreen) { // Safari
            galleryModal.webkitRequestFullscreen();
        } else if (galleryModal.msRequestFullscreen) { // IE11
            galleryModal.msRequestFullscreen();
        }
    };

    // Define exitRealFullscreen function
    const exitRealFullscreen = () => {
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.webkitExitFullscreen) { // Safari
            document.webkitExitFullscreen();
        } else if (document.msExitFullscreen) { // IE11
            document.msExitFullscreen();
        }
    };

    // Open the gallery modal
    const openFullscreenGallery = (startIndex) => {
        currentIndex = startIndex;
        galleryModal.classList.add("active");
        document.body.style.overflow = "hidden"; // Disable scrolling
        enterRealFullscreen(); // Enter real fullscreen mode
        updateGalleryView();
    };

    // Click event for fullscreen button
    fullscreenBtn.addEventListener("click", () => {
        const mainImageSrc = mainImage.src;
        const matchingIndex = galleryImages.findIndex((img) => img.src === mainImageSrc);
        openFullscreenGallery(matchingIndex >= 0 ? matchingIndex : 0);
    });

    // Close the gallery modal
    closeBtn.addEventListener("click", () => {
        galleryModal.classList.remove("active");
        document.body.style.overflow = ""; // Re-enable scrolling
        exitRealFullscreen(); // Exit real fullscreen mode
    });

    // Navigate left and right
    galleryImages.forEach((img, index) => {
        img.addEventListener("click", () => {
            currentIndex = index;
            updateGalleryView();
        });
    });

    // Keyboard navigation
    document.addEventListener("keydown", (e) => {
        if (!galleryModal.classList.contains("active")) return;

        if (e.key === "ArrowRight") {
            currentIndex = (currentIndex + 1) % galleryImages.length;
            updateGalleryView();
        } else if (e.key === "ArrowLeft") {
            currentIndex = (currentIndex - 1 + galleryImages.length) % galleryImages.length;
            updateGalleryView();
        } else if (e.key === "Escape") {
            // Exit real fullscreen mode if active
            if (document.fullscreenElement) {
                exitRealFullscreen();
            }
            // Close the modal if it is active
            if (galleryModal.classList.contains("active")) {
                galleryModal.classList.remove("active");
                document.body.style.overflow = ""; // Re-enable scrolling
            }
        }
    });

    // Reference to arrows and timeout
    const leftArrow = document.querySelector(".left-arrow");
    const rightArrow = document.querySelector(".right-arrow");
    let arrowTimeout;

    // Function to show arrows and fade them
    function showArrowsWithTimeout() {
        clearTimeout(arrowTimeout);
        leftArrow.classList.remove("fade");
        rightArrow.classList.remove("fade");

        // Set timeout to hide arrows after 3 seconds
        arrowTimeout = setTimeout(() => {
            leftArrow.classList.add("fade");
            rightArrow.classList.add("fade");
        }, 3000);
    }

    // Function to navigate images with arrows
    function navigateGallery(direction) {
        const images = document.querySelectorAll(".gallery-images img");
        const totalImages = images.length;

        // Update the current index
        currentIndex = (currentIndex + direction + totalImages) % totalImages;

        // Update the gallery to show the selected image
        updateGalleryView();

        // Reset the indicator and arrows timer
        showArrowsWithTimeout();
    }

    // Event Listeners for arrows
    leftArrow.addEventListener("click", () => navigateGallery(-1));
    rightArrow.addEventListener("click", () => navigateGallery(1));

    // Add arrow visibility on gallery open
    galleryModal.addEventListener("mouseenter", showArrowsWithTimeout);
    galleryModal.addEventListener("mousemove", showArrowsWithTimeout);
});
