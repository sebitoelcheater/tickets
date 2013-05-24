<?php
class SQL{
	public $conn;
	public $host = "localhost";
	public $port = "5432";
	public $dbname = "tickets";
	public $user = "_postgres";
	public $password = "pko2RWu";

	function __construct(){
		$this->conn = pg_pconnect("host=".$this->host." port=".$this->port." dbname=".$this->dbname." user=".$this->user." password=".$this->password);
		if (!$this->conn) {
			echo "An error occurredd.\n";
			exit;
		}
	}

	function __destruct(){
		pg_close($this->conn);
	}

	function sqlExecute($query){
		$result = pg_query($this->conn, $query);
		if (!$result) {
		  	echo "An error occurred.";
		  	exit;
		}
		return $result;
	}
}