<script>
    const fgt = $(".fgt").hide();
    const pp = $(".p-2").hide();
    const p = $(".p").hide();

    // LOGIN
    $('#frm-login').submit(function(e) {
        e.preventDefault();
        var email = $.trim($("#email").val());
        $.ajax({
            url: "sources/login.php",
            type: "POST",
            datatype: "json",
            data: {
                email: email,
                dt: 1
            },
            success: function(data) {
                if (data == "null") {
                    Swal.fire({
                        icon: 'error',
                        title: 'No existe este usuario, Intenta nuevamente',
                    });
                } else if (data == 3) {
                    pp.show();
                    $("#pw-nw").attr("required", true);
                    $("#pw-nw2").attr("required", true);
                    $('#frm-login').off('submit');

                    var pw_1 = $("#pw-nw").val();
                    var pw_2 = $("#pw-nw2").val();

                    if (pw_1 != pw_2) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Las contraseñas no coinciden',
                        });
                    } else {

                        $('#frm-login').submit(function(e) {
                            e.preventDefault();
                            var email = $.trim($("#email").val());
                            var pwl_2 = $.trim($("#pw-nw").val());
                            $.ajax({
                                url: "sources/login.php",
                                type: "POST",
                                datatype: "json",
                                data: {
                                    email: email,
                                    pwl: pwl_2,
                                    dt: 3
                                },
                                success: function(data) {
                                    if (data == "null") {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Usuario / contraseña incorrecto, intenta nuevamente',
                                        });
                                    } else {
                                        Swal.fire("¡Bien!", "Se guardo tu contraseña", "success");
                                    }
                                }
                            });
                        });
                    }

                } else {
                    p.show();
                    fgt.show();
                    $("#pwl").attr("required", true);
                    $('#frm-login').off('submit');

                    $('#frm-login').submit(function(e) {
                        e.preventDefault();
                        var email = $.trim($("#email").val());
                        var pwl = $.trim($("#pwl").val());
                        $.ajax({
                            url: "sources/login.php",
                            type: "POST",
                            datatype: "json",
                            data: {
                                email: email,
                                pwl: pwl,
                                dt: 2
                            },
                            success: function(data) {
                                if (data == "null") {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Usuario / contraseña incorrecto, intenta nuevamente',
                                    });
                                } else {
                                    Swal.fire("¡Hurra!", "Sesion iniciada correctamente", "success")
                                        .then((value) => {
                                            if (`${value}`) {
                                                window.location.href = "index.php";
                                            }
                                        });
                                }
                            }
                        });
                    });

                }
            }
        });
    });

    // FIN LOGIN
</script>