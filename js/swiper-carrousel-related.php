<script>
    //---------------------------
    const swiperContainer2 = document.querySelector('.mySwiper2');
    const dragIndicator2 = document.querySelector('.drag-indicator2');

    swiperContainer2.addEventListener('mousemove', (e) => {
        const rect = swiperContainer2.getBoundingClientRect();
        const x2 = (e.clientX - rect.left) - 20;
        const y2 = (e.clientY - rect.top) - 10;

        dragIndicator2.style.left = `${x2}px`;
        dragIndicator2.style.top = `${y2}px`;
        dragIndicator2.style.opacity = 1; // Muestra el texto al mover el ratón
    });

    swiperContainer2.addEventListener('mouseleave', () => {
        dragIndicator2.style.opacity = 0; // Oculta el texto al salir
    });
    // end raton

    var swiper = new Swiper(".mySwiper2", {
        loop: true,
        slidesPerView: 4,
        spaceBetween: 30,
        // Responsive breakpoints
        breakpoints: {
            // when window width is >= 320px
            320: {
                slidesPerView: 2,
                spaceBetween: 20
            },
            // when window width is >= 480px
            480: {
                slidesPerView: 3,
                spaceBetween: 20
            },
            // when window width is >= 640px
            640: {
                slidesPerView: 4,
                spaceBetween: 30
            }
        },
        autoplay: {
            delay: 5000,
        },
    });
</script>