<?php
/**
 * Clase Login para validar un usuario comprobando su usuario (o email) y contraseña
 * Forma parte del paquete de tutoriales en PHP disponible en http://www.emiliort.com
 * @author Emilio Rodríguez - http://www.emiliort.com
 */
class Login {
    
    public $tabla='Vendedores'; //nombre de la tabla usarios
    public $campo_rut='rut'; //campo que contiene los datos de los usuarios (se puede usar el email)
    public $campo_clave='contrasena'; //campo que contiene la contraseña
    public $campo_telefono = 'telefono';
    public $campo_nombre = 'nombre';
    public $campo_apellido = 'apellido';
    public $campo_cupo = 'cupo';
    public $campo_mail = 'mail';
    public $campo_admin = 'admin';
    public $campo_addedBy = 'addedBy';
    public $campo_fecha = 'fecha';
    public $metodo_encriptacion='texto'; //método utilizado para almacenar la contrasela. Opciones: sha1, md5, o texto
    
    private $link; //identificador de la conexión mysql que usamos
    
    /**
     * establecemos el método  de construccion de la clase que se llamará al crear el objeto. Conectamos a la base de datos
     * @return bool
     */
   public function __construct() {
       //1 - conectamos a la base de datos utilizando los parámetros globales
       // deberiamos utilizar una clase de acceso a la base de datos con el patrón singleton, pero lo dejo para otro tutorial
        $this->link =  mysql_connect(SERVIDOR_MYSQL, USUARIO_MYSQL, PASSWORD_MYSQL);

        if (!$this->link) {
            trigger_error('Error al conectar al servidor mysql: ' . mysql_error(),E_USER_ERROR);
        }
        
        // Seleccionar la base de datos activa
        $db_selected = mysql_select_db(BASE_DATOS,$this->link);
        if (!$db_selected) {
            trigger_error ('Error al conectar a la base de datos: ' . mysql_error($this->link),E_USER_ERROR);
        }
        
        return true;
        
   }
   
   //el metodo de destrucción al destruir el objeto
   public function __destruct() {
       mysql_close($this->link);
   }
   
   
    /**
     * valida un usuario y contraseña
     * @param string $usuario
     * @param string $password
     * @return bool
     */
    public function login($usuario, $password) {

        //usuario y password tienen datos?
        if (empty($usuario)) return false;
        if (empty ($password)) return false;
        //2 - preparamos la consulta SQL a ejecutar utilizando sólo el usuario y evitando ataques de inyección SQL.
        $query='SELECT * FROM '.$this->tabla.' WHERE '.$this->campo_rut.'="'.mysql_real_escape_string($usuario).'" LIMIT 1 ';  //la tabla y el campo se definen en los parametros globales
        $result = mysql_query($query);
        if (!$result) {
            trigger_error('Error al ejecutar la consulta SQL: ' . mysql_error($this->link),E_USER_ERROR);
        }


        //3 - extraemos el registro de este usuario
        $row = mysql_fetch_assoc($result);

        if ($row) {
            //4 - Generamos el hash de la contraseña encriptada para comparar o lo dejamos como texto plano
            switch ($this->metodo_encriptacion) {
                case 'sha1'|'SHA1':
                    $hash=sha1($password);
                    break;
                case 'md5'|'MD5':
                    $hash=md5($password);
                    break;
                case 'texto'|'TEXTO':
                    $hash=$password;
                    break;
                default:
                    trigger_error('El valor de la propiedad metodo_encriptacion no es válido. Utiliza MD5 o SHA1 o TEXTO',E_USER_ERROR);
            }

            //5 - comprobamos la contraseña
            if ($hash==$row[$this->campo_clave]) {
                @session_start();
                $_SESSION['USUARIO']=array('rut'=>$row[$this->campo_rut],'telefono'=>$row[$this->campo_telefono],'nombre'=>$row[$this->campo_nombre],'apellido'=>$row[$this->campo_apellido],'cupo'=>$row[$this->campo_cupo],'mail'=>$row[$this->campo_mail],'admin'=>$row[$this->campo_admin],'addedBy'=>$row[$this->campo_addedBy],'fecha'=>$row[$this->campo_fecha]); //almacenamos en memoria el usuario
                // en este punto puede ser interesante guardar más datos en memoria para su posterior uso, como por ejemplo un array asociativo con el id, nombre, email, preferencias, ....
                return true; //usuario y contraseña validadas
            } else {
                @session_start();
                unset($_SESSION['USUARIO']); //destruimos la session activa al fallar el login por si existia
                return false; //no coincide la contraseña
            }
        } else {
            //El usuario no existe
            return false;
        }

    }
    
    


    /**
     * Veridica si el usuario está logeado
     * @return bool
     */
    public function estoy_logeado () {
        @session_start(); //inicia sesion (la @ evita los mensajes de error si la session ya está iniciada)

        if (!isset($_SESSION['USUARIO'])) return false; //no existe la variable $_SESSION['USUARIO']. No logeado.
        if (!is_array($_SESSION['USUARIO'])) return false; //la variable no es un array $_SESSION['USUARIO']. No logeado.
        if (empty($_SESSION['USUARIO']['rut'])) return false; //no tiene almacenado el usuario en $_SESSION['USUARIO']. No logeado.

        //cumple las condiciones anteriores, entonces es un usuario validado
        return true;

    }

    /**
     * Vacia la sesion con los datos del usuario validado
     */
    public function logout() {
        @session_start(); //inicia sesion (la @ evita los mensajes de error si la session ya está iniciada)
        unset($_SESSION['USUARIO']); //eliminamos la variable con los datos de usuario;
        session_write_close(); //nos asegurmos que se guarda y cierra la sesion
        return true;
    }
    
    
}




    
?>