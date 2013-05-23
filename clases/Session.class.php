<?php
class Session {
	public $user = "User";
	public $id = "rut";


	function __construct(){
		@session_start(); //inicia sesion (la @ evita los mensajes de error si la session ya está iniciada)
	}

	function logued(){
        if (!isset($_SESSION[$this->user])) return false; //no existe la variable $_SESSION['USUARIO']. No logeado.
        if (!is_array($_SESSION[$this->user])) return false; //la variable no es un array $_SESSION['USUARIO']. No logeado.
        if (empty($_SESSION[$this->user][$this->id])) return false; //no tiene almacenado el usuario en $_SESSION['USUARIO']. No logeado.

        return true;
	}

	function whoIsLogued(){
		if ($this->logued()){
			return $_SESSION[$this->user][$this->id];
		}
		return false;
	}

	public function logout() {
        @session_start(); //inicia sesion (la @ evita los mensajes de error si la session ya está iniciada)
        unset($_SESSION[$this->user]); //eliminamos la variable con los datos de usuario;
        session_write_close(); //nos asegurmos que se guarda y cierra la sesion
        return true;
    }

    public function login($user){
    	$rut = $user->getRut();
    	@session_start();
    	$_SESSION[$this->user]=array($this->id=>$rut);
    }

    function filter(){
    	if (!$this->logued()){
    		header('Location: ../index.php');
    		exit;
    	}
    }
}
?>