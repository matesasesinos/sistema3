<?php

      use PHPMailer\PHPMailer\PHPMailer;
      use PHPMailer\PHPMailer\Exception;

      require 'Mailer/Exception.php';
      require 'Mailer/PHPMailer.php';
      require 'Mailer/SMTP.php';
      require 'Mailer/OAuth.php';

    if(isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['mail']) && isset($_POST['tel']) && isset($_POST['asunto']) && isset($_POST['mensaje']) && isset($_POST['idioma']) ){
        

        //Datos del formulario
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $correo = $_POST['mail'];
        $tel = $_POST['tel'];
        $asunto = $_POST['asunto'];
        $msj = $_POST['mensaje'];

        $nombreCompleto = $nombre . ' ' . $apellido;

        $enviado = false;

        $mail = new PHPMailer(true);
        /*$mail->CharSet = 'UTF-8';*/
        try{

          $mail->IsSMTP();
          $mail->Host       = 'smtp.octopusmedia.com.ar';
          $mail->Port       = 25;
          $mail->SMTPDebug  = 0;
          $mail->SMTPSecure = 'tls';
          $mail->SMTPAuth   = false;
  
          $mail->SetFrom('info@octopusmedia.com.ar', 'Octopus Social Media');
          $mail->AddAddress('info@octopusmedia.com.ar');

          $mail->isHTML(true);
          $mail->Subject    = $asunto;
          
          $body ='<strong>Consulta realizada a través del sitio web de Octopus Social Media </strong> <br/><br/> Nombre y Apellido: '. $nombre .' '. $apellido .'<br/>Correo electronico: '. $correo .'<br/>Telefono: '. $tel .'<br/> Mensaje: <br/><br/>'. $msj;
          $mail->Body = $body;

          if($mail->send()){

            $enviado = true;

          }

        }catch (Exception $e){
          $enviado = false;
        }
        
        if($enviado){
            echo "OK";
        }else{
            echo "NO";
        }

        
    }

?>