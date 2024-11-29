<script>
    // raton
    const swiperContainer = document.querySelector('.mySwiper');
    const dragIndicator = document.querySelector('.drag-indicator');

    swiperContainer.addEventListener('mousemove', (e) => {
        const rect = swiperContainer.getBoundingClientRect();
        const x = (e.clientX - rect.left) - 20;
        const y = (e.clientY - rect.top) - 10;

        dragIndicator.style.left = `${x}px`;
        dragIndicator.style.top = `${y}px`;
        dragIndicator.style.opacity = 1; // Muestra el texto al mover el ratón
    });

    swiperContainer.addEventListener('mouseleave', () => {
        dragIndicator.style.opacity = 0; // Oculta el texto al salir
    });
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
    var swiper = new Swiper(".mySwiper", {
        loop: true,
        slidesPerView: 3,
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
                slidesPerView: 3,
                spaceBetween: 30
            }
        },
        autoplay: {
            delay: 4000,
        },
    });

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
                spaceBetween: 30
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

    //ajax wish-list

    $(".toggle-wishlist").on("click", function (e) {
        e.preventDefault();
        const button = $(this);
        const productId = button.data("product-id");
        console.log(productId);
        
        $.ajax({
            url: "src/toggle_wishlist.php",
            method: "POST",
            data: { product_id: productId },
            dataType: "json",
            success: function (response) {
                if (response.status) {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.onmouseenter = Swal.stopTimer;
                            toast.onmouseleave = Swal.resumeTimer;
                        }
                    });
                    Toast.fire({
                        icon: response.icon,
                        title: response.msj,
                    });
                } else {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.onmouseenter = Swal.stopTimer;
                            toast.onmouseleave = Swal.resumeTimer;
                        }
                    });
                    Toast.fire({
                        icon: response.icon,
                        title: response.msj,
                    });
                }
            },
            error: function (xhr, status, error) {
                // Función que se ejecuta si ocurre un error
                Swal.fire({
                    icon: 'error', // Tipo de alerta (error)
                    title: 'Error',
                    text: 'Ocurrió un error',
                    footer: 'Detalles del error: ' + xhr.responseText, // Aquí mostramos los detalles del error
                    confirmButtonText: 'Cerrar'
                });
            }
        });
    });
    //END ajax wish-list
</script>