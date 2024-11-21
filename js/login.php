<script>
    const fgt = $(".fgt").hide();
    const pp = $(".p-2").hide();
    const p = $(".p").hide();

    // LOGIN
    $('#frm-login').submit(function (e) {
        e.preventDefault();
        var email = $.trim($("#email").val());

        // Primer AJAX
        $.ajax({
            url: "src/login.php",
            type: "POST",
            dataType: "json",
            data: {
                email: email,
                dt: 1
            },
            success: function (response) {
                if (response.status) {

                    switch (response.process) {
                        case 2:

                            pp.show();

                            $("#pw-nw").attr("required", true);
                            $('#frm-login').off('submit');
                            var pwl_2 = $("#pw-nw").val();


                            $('#frm-login').submit(function (e) {
                                e.preventDefault();
                                var pwl_2 = $("#pw-nw").val();

                                $.ajax({
                                    url: "src/login.php",
                                    type: "POST",
                                    dataType: "json",
                                    data: {
                                        email: email,
                                        pwl: pwl_2,
                                        dt: 2
                                    },
                                    success: function (secondResponse) {

                                        if (secondResponse.status) {
                                            Swal.fire({
                                                icon: secondResponse.icon,
                                                title: secondResponse.msj,
                                            }).then(() => {
                                                window.location.href = "index.php";
                                            });
                                        } else {
                                            Swal.fire({
                                                icon: secondResponse.icon,
                                                title: secondResponse.msj,
                                            });
                                        }
                                    }
                                });
                            });

                            break;

                        case 3:

                            p.show();
                            fgt.show();
                            $("#pw").attr("required", true);

                            $('#frm-login').off('submit');

                            $('#frm-login').submit(function (e) {
                                e.preventDefault();
                                var email = $.trim($("#email").val());
                                var pwl = $.trim($("#pw").val());

                                $.ajax({
                                    url: "src/login.php",
                                    type: "POST",
                                    dataType: "json",
                                    data: {
                                        email: email,
                                        pw: pwl,
                                        dt: 3
                                    },
                                    success: function (thirdResponse) {

                                        if (thirdResponse.status) {
                                            Swal.fire({
                                                icon: thirdResponse.icon,
                                                title: thirdResponse.msj,
                                            });
                                        } else {
                                            Swal.fire({
                                                icon: thirdResponse.icon,
                                                title: thirdResponse.msj,
                                            });
                                        }
                                    }
                                });
                            });
                            break;

                        default:
                            break;
                    }
                } else {
                    Swal.fire({
                        icon: response.icon,
                        title: response.msj,
                    });
                }
            }
        });
    });
    // FIN LOGIN
</script>