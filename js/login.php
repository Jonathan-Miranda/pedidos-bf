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
            },
            success: function(data) {
                if (data.status) {
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

    // FIN LOGIN
</script>