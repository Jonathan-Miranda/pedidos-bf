<script>
    // add-user
    $('#add-client').submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this); // Crea un nuevo objeto FormData con los datos del formulario
        for (var pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }
        $.ajax({
            url: "src/add-user-client.php",
            type: "POST",
            data: formData,
            processData: false, // Importante para que jQuery no intente procesar el FormData
            contentType: false,  // Importante para que jQuery no configure un tipo de contenido automático
            dataType: "json",
            success: function (response) {
                if (response.status) {
                    Swal.fire({
                        icon: response.icon,
                        title: response.msj,
                    }).then(() => {
                        window.location.href = "user.php";
                    });

                } else {
                    Swal.fire({
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
    // FIN add user

    //Update user
    $('#edit-client').submit(function (e) {
        e.preventDefault();
        var nombre = $.trim($("#edit-name").val());
        var descripcion = $.trim($("#edit-descripcion").val());
        var id = $.trim($("#edit-id").val());

        $.ajax({
            url: "src/edit-user-type.php",
            type: "POST",
            dataType: "json",
            data: {
                nombre: nombre,
                descripcion: descripcion,
                id: id
            },
            success: function (response) {
                if (response.status) {
                    Swal.fire({
                        icon: response.icon,
                        title: response.msj,
                    }).then(() => {
                        window.location.href = "tipo-cliente.php";
                    });

                } else {
                    Swal.fire({
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
    // END update user

    //delete user
    $('.delete-client').submit(function (e) {
        e.preventDefault();
        var id = $.trim($(this).find(".delete-id").val());
        console.log("clic btn borrar: " + id);
        Swal.fire({
            title: `¿Quieres borrar ${id}?`,
            text: "Esta acción no se puede revertir",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#157347",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, estoy seguro"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "src/delete-user-type.php",
                    type: "POST",
                    dataType: "json",
                    data: {
                        id: id
                    },
                    success: function (response) {
                        if (response.status) {
                            Swal.fire({
                                icon: response.icon,
                                title: response.msj,
                            }).then(() => {
                                window.location.href = "tipo-cliente.php";
                            });

                        } else {
                            Swal.fire({
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
            }
        });

    });
    //END delete user

    //add data modal
    // Esperar a que el documento esté completamente cargado
    document.addEventListener('DOMContentLoaded', function () {
        const exampleModal = document.getElementById('edit-user');

        if (exampleModal) {
            exampleModal.addEventListener('show.bs.modal', event => {
                // Botón que activó la modal
                const button = event.relatedTarget;

                // Extraer la información del botón
                const nombre = button.getAttribute('data-bs-whatever');
                const descripcion = button.getAttribute('data-bs-descripcion');
                const id = button.getAttribute('data-bs-id');

                // Actualizar los campos en la modal
                const modalTitle = exampleModal.querySelector('.modal-title');
                const nombreInput = exampleModal.querySelector('#edit-name');
                const descripcionInput = exampleModal.querySelector('#edit-descripcion');
                const userIdInput = exampleModal.querySelector('#edit-id');

                // Llenar los valores de la modal con los datos
                modalTitle.textContent = `Editando: ${nombre}`;
                nombreInput.value = nombre;
                descripcionInput.value = descripcion;
                userIdInput.value = id;
            });
        }
    });
    //end add data modal
</script>