<?php
/*
 * Valida un usuario y contraseña o presenta el formulario para hacer login
 */

if ($_SERVER['REQUEST_METHOD']=='POST') { // ¿Nos mandan datos por el formulario?
    include('php_lib/config.ini.php'); //incluimos configuración
    include('php_lib/login.class.php'); //incluimos las funciones
    $Login=new Login();
    //si hace falta cambiamos las propiedades tabla, campo_usuario, campo_contraseña, metodo_encriptacion

    //verificamos el usuario y contraseña mandados
    if ($Login->login($_POST['user'],$_POST['password'])) {

       //acciones a realizar cuando un usuario se identifica
       //EJ: almacenar en memoria sus datos completos, registrar un acceso en una tabla mysql
       //Estas acciones se veran en los siguientes tutorianes en http://www.emiliort.com

        //saltamos al inicio del área restringida
        header('Location: pagina-acceso-restringido.php');
        die();
    } else {
        //acciones a realizar en un intento fallido
        //Ej: mostrar captcha para evitar ataques fuerza bruta, bloquear durante un rato esta ip, ....
        //Estas acciones se veran en los siguientes tutorianes en http://www.emiliort.com

        //preparamos un mensaje de error y continuamos para mostrar el formulario
        $mensaje='Usuario o contraseña incorrecto.';
    }
} //fin if post
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>Ejemplo login 3</title>
    </head>
    <body>
        <h1>Ejemplo login 3</h1>
        <?php
            //si hay algún mensaje de error lo mostramos escapando los carácteres html
            if (!empty($mensaje)) echo('<h2>'.htmlspecialchars($mensaje).'</h2>');
        ?>
        <form action="login.php" enctype="multipart/form-data" method="post">
            <label>Usuario:
                <input name="user" type="text" />
            </label>
            <label>Contraseña:
                <input name="password" type="password" />
            </label>
            <input type="submit" value="Entrar" />
        </form>
    </body>
</html>

