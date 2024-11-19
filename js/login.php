<script>
    const fgt = $(".fgt").hide();
    const pp = $(".p-2").hide();
    const p = $(".p").hide();

    // LOGIN
    $('#frm-login').submit(function(e) {
        e.preventDefault();
        var email = $.trim($("#email").val());
        $.ajax({
            url: "src/login.php",
            type: "POST",
            datatype: "json",
            data: {
                email: email,
                dt: 1
            },
            success: function(data) {
                if (dt == 1 && data.status) {

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
                                url: "src/login.php",
                                type: "POST",
                                datatype: "json",
                                data: {
                                    email: email,
                                    pwl: pwl_2,
                                    dt: 2
                                },
                                success: function(data) {
                                    if (dt == 2 && data.status) {
                                        Swal.fire({
                                            icon: data.icon,
                                            title: data.msj,
                                        });
                                    } else {
                                        Swal.fire({
                                            icon: data.icon,
                                            title: data.msj,
                                        });
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
                            url: "src/login.php",
                            type: "POST",
                            datatype: "json",
                            data: {
                                email: email,
                                pwl: pwl,
                                dt: 3
                            },
                            success: function(data) {
                                if (dt == 3 && data.status) {
                                    Swal.fire({
                                        icon: data.icon,
                                        title: data.msj,
                                    });
                                } else {
                                    Swal.fire("¡Hurra!", "Sesion iniciada correctamente", "success")
                                        .then((value) => {
                                            if (`${value}`) {
                                                window.location.href = "catalogo.php";
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