<?php
include('../clases/SQL.class.php');
include('../clases/Session.class.php');
include('../clases/Person.class.php');

$rut = $_POST['user'];
$pass = $_POST['password'];

$user = new Rut($rut);

echo "ss".$rut."pass".$pass;
?>