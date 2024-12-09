<script>
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