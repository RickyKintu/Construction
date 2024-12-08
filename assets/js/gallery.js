document.addEventListener('DOMContentLoaded', function () {
    // Select all gallery items
    const galleryItems = document.querySelectorAll('.gallery-item img');
    const modal = document.createElement('div');
    const modalImage = document.createElement('img');
    const closeModalBtn = document.createElement('button');
    const nextBtn = document.createElement('button');
    const prevBtn = document.createElement('button');

    let currentIndex = 0;

    // Add classes and styles for modal
    modal.classList.add('gallery-modal');
    modal.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.9);
        display: flex;
        justify-content: center;
        align-items: center;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease;
        z-index: 9999;
    `;

    modalImage.style.cssText = `
        max-width: 90%;
        max-height: 80%;
        border-radius: 10px;
    `;

    closeModalBtn.innerHTML = '×';
    closeModalBtn.style.cssText = `
        position: absolute;
        top: 20px;
        right: 20px;
        font-size: 2rem;
        color: #fff;
        background: none;
        border: none;
        cursor: pointer;
    `;

    nextBtn.innerHTML = '>';
    nextBtn.style.cssText = `
        position: absolute;
        top: 50%;
        right: 20px;
        font-size: 2rem;
        color: #fff;
        background: none;
        border: none;
        cursor: pointer;
        transform: translateY(-50%);
    `;

    prevBtn.innerHTML = '<';
    prevBtn.style.cssText = `
        position: absolute;
        top: 50%;
        left: 20px;
        font-size: 2rem;
        color: #fff;
        background: none;
        border: none;
        cursor: pointer;
        transform: translateY(-50%);
    `;

    modal.appendChild(modalImage);
    modal.appendChild(closeModalBtn);
    modal.appendChild(nextBtn);
    modal.appendChild(prevBtn);
    document.body.appendChild(modal);

    function showModal(index) {
        currentIndex = index;
        const imageSrc = galleryItems[currentIndex].src;
        modalImage.src = imageSrc;
        modal.style.opacity = '1';
        modal.style.visibility = 'visible';
    }

    function closeModal() {
        modal.style.opacity = '0';
        modal.style.visibility = 'hidden';
    }

    function nextImage() {
        currentIndex = (currentIndex + 1) % galleryItems.length;
        modalImage.src = galleryItems[currentIndex].src;
    }

    function prevImage() {
        currentIndex = (currentIndex - 1 + galleryItems.length) % galleryItems.length;
        modalImage.src = galleryItems[currentIndex].src;
    }

    // Attach click events
    galleryItems.forEach((item, index) => {
        item.addEventListener('click', () => showModal(index));
    });

    closeModalBtn.addEventListener('click', closeModal);
    nextBtn.addEventListener('click', nextImage);
    prevBtn.addEventListener('click', prevImage);

    modal.addEventListener('click', (event) => {
        if (event.target === modal) {
            closeModal();
        }
    });

    // Keyboard navigation
    document.addEventListener('keydown', (event) => {
        if (modal.style.visibility === 'visible') {
            if (event.key === 'ArrowRight') {
                nextImage();
            } else if (event.key === 'ArrowLeft') {
                prevImage();
            } else if (event.key === 'Escape') {
                closeModal();
            }
        }
    });
});
