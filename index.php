<?php
include('clases/SQL.class.php');
$S = new SQL;
$S -> sqlExecute("");
?>

<meta http-equiv="content-type" content="text/xml; charset=utf-8" />

<center>
<form action="session/login.php" method="post">
	Usuario <input name="user">
	Contraseña <input name="password">
	<input type="submit" value="Entrar">
</form>
<form action="session/register.php" method="post">
	<input type="submit" value="Registrar">
</form>
</center>