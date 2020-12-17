<?php

include("mailer/src/PHPMailer.php");
include("mailer/src/SMTP.php");
include("mailer/src/Exception.php");


try {
  $usuario_id = $_POST['usuario_id'];
  $fromemail = "brianeperillo@gmail.com";
  $host = "smtp.gmail.com";
  $port = "587";
  $SMTPAuth = "login";
  $SMTPSecure = "tls";
  $password = "Briesirhaper8547";

  $mail = new PHPMailer\PHPMailer\PHPMailer;
  // Valores enviados desde el formulario
  if (!isset($_POST["usuario"]) || !isset($_POST["correo"]) || !isset($_POST["asunto"])  || !isset($_POST["mensaje"])) {
      die ("Es necesario completar todos los datos del formulario");
  }

  $fromname = $_POST["usuario"];

  $emailTo = $_POST["correo"];

  $subject = $_POST["asunto"];

  $bodyEmail = $_POST["mensaje"];

  //
  // Le digo a a PHP Mailer que use SMTP
  $mail->isSMTP();
  $mail->SMTPDebug = 1;
  $mail->Host = $host;
  $mail->Port = $port;
  $mail->SMTPAuth = $SMTPAuth;
  $mail->SMTPSecure = $SMTPSecure;
  $mail->Username = $fromemail;
  $mail->Password = $password;
  /*
  $mail->SMTPOptions = array(
    'ssl' => array(
      'verify_peer' => false,
      'verify_peer_name' => false,
      'allow_self_signed' => true,
    )
  );
  */
  $mail->setFrom($fromemail, $fromname);

  //Destinatarios -- Para enviar a muchos destinatarios, podemos crear un array y va tomando los values sino/else, solo envia a uno (el $emailTo)
  if(is_array($emailTo)) {
    foreach($emailTo as $key => $value){
      $mail->addAdress($value);
      }
    }else{
      $mail->addAddress($emailTo);
    }

  //Asunto
  $mail->isHTML(true);
  $mail->Subject = $subject;

  //Cuerpo Email
  $mail->Body = $bodyEmail;

  if(!$mail->send()){
    echo "No se pudo enviar el correo"; die();
  }    else{
      //Guardar mail en db
        include("db.php");

            $query = "INSERT INTO mails(usuario, mail, asunto, mensaje, usuario_id) VALUES ('$fromname', '$emailTo', '$subject', '$bodyEmail', '$usuario_id')"; // INSERTA VALUES EN LA TABLA TASK
          // Consulto si se guardaron los valores / si todo salió bien. Si resulto no devuelve nada es porque hubo algún problema/error
            $result = (mysqli_query($conn, $query));
          // Si hubo un error le digo que termine con la aplicación - die().
            if(mysqli_error($conn)){
              die("Query Failed. Falló la Query para insertar el mail en la db - Error: " . mysqli_error($conn));
            }


            //header("Location:index.php?pagina=1"); // Redirecciono nuevamente al index.php.
                echo "Correo enviado"; die();
          }


} catch (Exception $e) {

}

?>
