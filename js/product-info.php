<script>
    $('#mas').click(function () {
        var currentVal = parseInt($('#agregar').val()) || 0;
        var maxValue = parseInt($('#agregar').attr('max'));
        if (currentVal < maxValue) {
            $('#agregar').val(currentVal + 1);
        }
    });

    $('#menos').click(function () {
        var currentVal = parseInt($('#agregar').val());
        if (currentVal > 1) {
            $('#agregar').val(currentVal - 1);
        }
    });

    $('#btn-add').click(function () {
        var cantidad = $('#agregar').val();
        var prod_id = <?php echo json_encode($_GET['id_product']); ?>;

        var maxValue = $('#agregar').attr('max');
        maxValue = parseInt(maxValue, 10);

        if (cantidad <= 0 || cantidad > maxValue) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Agrega una cantidad correcta',
                confirmButtonText: 'Cerrar'
            });
        } else {

            $.ajax({
                url: "src/shop_car.php",
                method: "POST",
                data: {
                    cantidad: cantidad,
                    product_id: prod_id
                },
                dataType: "json",
                success: function (response) {
                    $('#agregar').val('');
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
        }//else end
    });

</script>