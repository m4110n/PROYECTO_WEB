<?php
if (isset($_POST['boton_enviar'])) {
    if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['asunto']) && !empty($_POST['mensaje'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $asunto = $_POST['asunto'];
        $mensaje = $_POST['mensaje'];

        $header = "From: correo@gmail.com" . "\r\n";
        $header .= "Reply-To: correo@gmail.com" . "\r\n";
        $header .= "X-Mailer: PHP/" . phpversion();

        $destinatario = "sesmaikel@gmail.com";
        $mail = @mail($name, $email, $asunto, $mensaje, $header);
        if ($mail) {
            echo "<h4>Correo enviado</h4>";
        }
    }
}
