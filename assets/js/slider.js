document.addEventListener('DOMContentLoaded', function() {
    // Slider functionality
    const slides = document.querySelectorAll('.slide');
    const indicators = document.querySelectorAll('.indicator');
    const nextBtn = document.querySelector('.next-btn');
    const prevBtn = document.querySelector('.prev-btn');
    
    let currentSlide = 0;
    let slideInterval;
    
    // Initialize autoplay
    startAutoSlide();
    
    // Function to show a specific slide
    function showSlide(index) {
        // Remove active class from all slides and indicators
        slides.forEach(slide => slide.classList.remove('active'));
        indicators.forEach(indicator => indicator.classList.remove('active'));
        
        // Add active class to current slide and indicator
        slides[index].classList.add('active');
        indicators[index].classList.add('active');
        
        // Update current slide
        currentSlide = index;
    }
    
    // Next slide function
    function nextSlide() {
        currentSlide = (currentSlide + 1) % slides.length;
        showSlide(currentSlide);
    }
    
    // Previous slide function
    function prevSlide() {
        currentSlide = (currentSlide - 1 + slides.length) % slides.length;
        showSlide(currentSlide);
    }
    
    // Start autoplay
    function startAutoSlide() {
        // Clear any existing interval
        clearInterval(slideInterval);
        // Set new interval
        slideInterval = setInterval(nextSlide, 5000);
    }
    
    // Event Listeners
    nextBtn.addEventListener('click', function() {
        nextSlide();
        startAutoSlide(); // Reset timer when manually changed
    });
    
    prevBtn.addEventListener('click', function() {
        prevSlide();
        startAutoSlide(); // Reset timer when manually changed
    });
    
    // Add click event to indicators
    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', function() {
            showSlide(index);
            startAutoSlide(); // Reset timer when manually changed
        });
    });
    
    // Pause autoplay when hovering over slider
    const sliderContainer = document.querySelector('.slider-container');
    
    sliderContainer.addEventListener('mouseenter', function() {
        clearInterval(slideInterval);
    });
    
    sliderContainer.addEventListener('mouseleave', function() {
        startAutoSlide();
    });
});