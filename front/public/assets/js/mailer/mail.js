$(document).ready(function(){

    $('#submit_btn').on('click', function(){

        //obtengo los datos del formulario
        var nombre = $('#first_name').val();
        var mail = $('#email').val();
        var asunto = $('#asunto').val();
        var mensaje = $('#message').val();
        

        $.ajax({
            type: 'POST',
            url: './js/mailer/mail.php',
            data: {"nombre" : nombre, "mail" : mail, "asunto" : asunto, "mensaje" : mensaje},
            success: function(resp){

                //Respuesta de envio de mail
                if(resp == "OK"){
                   
                    $('#mensaje').html('<p>Mensaje enviado correctamente...</p>');
                    $('#myModal').modal('show');
                    $('#first_name').val("");
                    $('#last_name').val("");
                    $('#email').val("");
                    $('#phone').val("");
                    $('#asunto').val("");
                    $('#message').val("");

                }else{
                    $('#mensaje').html('<p>Mensaje no enviado, vuelva a intentarlo...</p>');
                    $('#myModal').modal('show');
                }

            },
            error: function(e){
                alert('Mensaje: ' + e.message);
            }
        });

    });


});