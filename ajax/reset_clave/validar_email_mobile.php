<?php
/**
 * Created by PhpStorm.
 * User: Ailanthus
 * Date: 11-12-2017
 * Time: 03:55 PM
 */

include '../../config/conexion.php';

function generarLinkTemporal($idusuario, $username){
    // Se genera una cadena para validar el cambio de contraseña
    $cadena = $idusuario.$username.rand(1,9999999).date('Y-m-d');
    $token = sha1($cadena);

    // Se inserta el registro en la tabla tblreseteopass
    $sql = "INSERT INTO resetclave (id_usuario, nombre, token, creado) VALUES($idusuario,'$username','$token',NOW());";
    $resultado = $con->query($sql);
    if(($resultado) or die("Error en: $resultado: " . $con->error)){
        // Se devuelve el link que se enviara al usuario
        $enlace = $_SERVER["SERVER_NAME"].'/sistema/restablecer?idusuario='.sha1($idusuario).'&token='.$token;
        return $enlace;
    }
    else
        return FALSE;
}

function enviarEmail( $email, $link ){
    $mensaje = '<html>
     <head>
        <title>Restablece tu contraseña</title>
     </head>
     <body>
       <p>Hemos recibido una petición para restablecer la contraseña de tu cuenta.</p>
       <p>Si hiciste esta petición, haz clic en el siguiente enlace, si no hiciste esta petición puedes ignorar este correo.</p>
       <p>
         <strong>Enlace para restablecer tu contraseña</strong><br>
         <a href="'.$link.'"> Restablecer contraseña </a>
       </p>
     </body>
    </html>';

    #$cabeceras = 'MIME-Version: 1.0' . "\r\n";
    #$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    #$cabeceras .= 'From: Ailanthus Sistems <soporteit@ailanthus-sistems.com>' . "\r\n";
    $cabeceras = 'From:soporteit@ailanthus-sistems.com ' . "\r\n" .
        'Reply-To:'.$email.' ' . "\r\n" .
        'Content-type: text/html; charset=UTF-8\r\n'.
        'X-Mailer: PHP/' . phpversion();
    // Se envia el correo al usuario
    mail($email, "Recuperar contraseña", $mensaje, $cabeceras);
}



$respuesta = new stdClass();
validar_email();

function validar_email(){
    $email = $_POST['email'];
    $resp = new stdClass();
    if( $email != "" ){
    $sql = "SELECT *FROM usuario WHERE correo = '$email' ";
    $query_user = $con->query($sql) or die("Error en: $sql: " . $con->error);
    if($usuario = mysqli_fetch_array($query_user)){
        $linkTemporal = generarLinkTemporal( $usuario['codigo'], $usuario['nombre'] );
        if($linkTemporal){
            enviarEmail( $email, $linkTemporal );
            $resp->respuesta='Correo de recuperación enviado';
            $resp->subresp='Un correo ha sido enviado a su cuenta de email con las instrucciones para restablecer la contraseña.';
        }
    }
    else
    {
        $resp->respuesta='Correo invalido';
        $resp->subresp='No existe una cuenta asociada a ese correo.';
    }
}
else
{
    $resp->respuesta='Campo correo vacio';
    $resp->subresp='Debes introducir un correo electronico.';
}
echo json_encode((Object)$resp);
}