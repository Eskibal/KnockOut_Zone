
        let slideIndex = 0;
        const slides = document.querySelectorAll('.banner-slide');
        let slideInterval = null;
        let isAnimating = false;

        function showSlide(newIndex, direction = 1) {
            if (isAnimating || newIndex === slideIndex) return;
            isAnimating = true;

            const current = slides[slideIndex];
            const next = slides[(newIndex + slides.length) % slides.length];

            // Remove all animation classes
            slides.forEach(slide => {
                slide.classList.remove('slide-in-left', 'slide-in-right', 'slide-out-left', 'slide-out-right', 'active');
                slide.style.display = 'none';
                if (slide.querySelector('video')) slide.querySelector('video').pause();
            });

            // Prepare next slide
            next.style.display = 'block';
            next.classList.add('active');
            if (direction === 1) {
                next.classList.add('slide-in-right');
                current.classList.add('slide-out-left');
            } else {
                next.classList.add('slide-in-left');
                current.classList.add('slide-out-right');
            }
            current.style.display = 'block';

            // Play video if present
            if (next.querySelector('video')) next.querySelector('video').play();

            // Wait for animation to finish
            setTimeout(() => {
                current.classList.remove('slide-out-left', 'slide-out-right', 'active');
                current.style.display = 'none';
                next.classList.remove('slide-in-left', 'slide-in-right');
                isAnimating = false;
            }, 700);

            slideIndex = (newIndex + slides.length) % slides.length;
        }

        function changeSlide(n) {
            if (isAnimating) return;
            let direction = n > 0 ? 1 : -1;
            showSlide(slideIndex + n, direction);
            resetAutoplay();
        }

        function nextSlide() {
            showSlide(slideIndex + 1, 1);
        }

        function startAutoplay() {
            slideInterval = setInterval(nextSlide, 50000);
        }

        function resetAutoplay() {
            clearInterval(slideInterval);
            startAutoplay();
        }

        // Initialize
        slides.forEach((slide, i) => {
            slide.style.display = i === 0 ? 'block' : 'none';
            if (i === 0) slide.classList.add('active');
        });
        if (slides[0].querySelector('video')) slides[0].querySelector('video').play();
        startAutoplay();