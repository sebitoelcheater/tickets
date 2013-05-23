<?php
class Rut{
	public $rut;
	public $db;

	function __construct($r){
		$this->rut = $r;
		$this->db = new SQL;
	}

	function fusion(){
		$query = "SELECT * FROM person WHERE $rut='".$this->rut."'";
		$result = $this->db->sqlExecute($query);
		$row = pg_fetch_row($result);

		$name = $row[1];
		$last_name = $row[2];
		$bird_date = $row[4];
		$mail = $row[5];

		$User = new User($this->rut,$name,$last_name,$bird_date,$mail);

		return $User;
	}

	function login($pass){
        if (empty($this->rut)) return false;
        if (empty ($pass)) return false;

        $sql = "SELECT password FROM person WHERE rut='".$this->rut."'";
        $result = $this->db->sqlExecute($sql);
        $row = pg_fetch_row($result);
        if ($row[0]==$pass){
        	return true;
        }
        return false;
	}

	function getRut(){
		return $this->rut;
	}
}

class Person extends Rut{
	public $name;
	public $last_name;
	public $bird_date;
	public $mail;
	public $db;

	function __construct($r,$n,$ln,$bd,$m){
		parent::__construct($r);
		$this->name = $n;
		$this->last_name = $ln;
		$this->bird_date = $bd;
		$this->mail = $m;
		$this->db = new SQL;
	}

	function getData(){
		return array($this->name,$this->last_name,$this->bird_date,$this->mail);
	}

	function register($pass){
		$query = "INSERT INTO person VALUES ('".$this->rut."','".$this->name."','".$this->$last_name."','".$this->password."','".$this->bird_date."','".$this->mail."')";
		$this->db->sqlExecute($query);
	}

	function getName(){
		return $this->name;
	}
	function getLastName(){
		return $this->last_name;
	}
	function getBirdDate(){
		return $this->bird_date;
	}
	function getMail(){
		return $this->mail;
	}
}

?>