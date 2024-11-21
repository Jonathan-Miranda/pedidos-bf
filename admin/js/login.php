<script>
    $('#frm-login').submit(function(e){
    e.preventDefault();
    var usuario = $.trim($("#user").val());    
    var password =$.trim($("#pw").val());    
         $.ajax({
            url:"src/login.php",
            type:"POST",
            datatype: "json",
            data: {usuario:usuario, password:password}, 
            success:function(data){               
                if(data == "null"){
                    Swal.fire({
                        icon:'error',
                        title:'Usuario y/o Contraseña incorrecto',
                    });
                }else{
                    Swal.fire("!Bienvenido¡", "Haz click en el boton para ingresar", "success")
                        .then((value) => {
                            if(`${value}`){
                                window.location.href = "dashboard.php";
                            }
                    });
                }
            }    
         });
 });
</script>