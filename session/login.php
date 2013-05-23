<?php
include('../clases/SQL.class.php');
include('../clases/Session.class.php');
include('../clases/Person.class.php');

$rut = $_POST['user'];
$pass = $_POST['password'];

$user = new Rut($rut);

if ($user->validate($pass)){
	$S = new Session;
	$S->login($user);
	header('Location: index.php');
    exit;
} else {
	header('Location: ../index.php?message=Usuario o contraseña incorrectos');
    exit;
}

?>