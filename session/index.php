<?php
include('../clases/SQL.class.php');
include('../clases/Session.class.php');
include('../clases/Person.class.php');

$S = new Session;
$S->filter();

$rut = $S->whoIsLogued();

$R = new Rut($rut);
$U = $R->fusion();
?>

<h1>Bienvenido <?php echo $U->getName()." ".$U->getLastName();?></h1>

Tus datos son los siguientes:

<table>
	<tr>
		<td>Nacimiento</td><td><?php echo $U->getBirdDate();?></td>
	</tr>
	<tr>
		<td>Mail</td><td><?php echo $U->getMail();?></td>
	</tr>
</table>