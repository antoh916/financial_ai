document.addEventListener('DOMContentLoaded', function() {
    const slider = document.querySelector('.product-sliderr');
    const slides = document.querySelectorAll('.slidee');
    const prevBtn = document.querySelector('.prev-btnn');
    const nextBtn = document.querySelector('.next-btnn');
    
    let currentIndex = 0;
    const slideCount = slides.length;
    
    // Set slider width
    function setSliderWidth() {
        slider.style.width = `${slideCount * 100}%`;
        slides.forEach(slide => {
            slide.style.width = `${100 / slideCount}%`;
        });
    }
    
    // Move slider to specific index
    function moveToSlide(index) {
        if (index < 0) {
            index = slideCount - 1;
        } else if (index >= slideCount) {
            index = 0;
        }
        
        currentIndex = index;
        const offset = -currentIndex * (100 / slideCount);
        slider.style.transform = `translateX(${offset}%)`;
    }
    
    // Event listeners
    prevBtn.addEventListener('click', () => {
        moveToSlide(currentIndex - 1);
    });
    
    nextBtn.addEventListener('click', () => {
        moveToSlide(currentIndex + 1);
    });
    
    // Initialize slider
    setSliderWidth();
    
    // Add automatic sliding (optional)
    let interval = setInterval(() => {
        moveToSlide(currentIndex + 1);
    }, 5000);
    
    // Pause auto-slide on hover
    slider.addEventListener('mouseenter', () => {
        clearInterval(interval);
    });
    
    slider.addEventListener('mouseleave', () => {
        interval = setInterval(() => {
            moveToSlide(currentIndex + 1);
        }, 5000);
    });
    
    // Handle window resize
    window.addEventListener('resize', setSliderWidth);
});