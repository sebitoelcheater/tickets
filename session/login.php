<?php
include('SQL.class.php');
include('Session.class.php');
include('Person.class.php');

$rut = $_POST['user'];
$pass = $_POST['password'];

$user = new Person($rut);

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