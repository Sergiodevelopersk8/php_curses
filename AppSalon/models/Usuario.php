<?php

namespace Model;

class Usuario extends ActiveRecord{


protected static $tabla = 'usuarios';
protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'password', 'telefono', 'admin', 'confirmado', 'token'];

public $id;
public $nombre;
public $apellido;
public $email;      
public $password;
public $telefono;
public $admin;
public $confirmado;
public $token;


 public function __construct($args = []) {
    
 // Inicializar las propiedades del objeto con los valores proporcionados en $args o con valores predeterminados
    $this->id = $args['id'] ?? null;
    $this->nombre = $args['nombre'] ?? '';
    $this->apellido = $args['apellido'] ?? '';
    $this->email = $args['email'] ?? '';
    $this->password = $args['password'] ?? '';
    $this->telefono = $args['telefono'] ?? '';
    $this->admin = $args['admin'] ?? '0';
    $this->confirmado = $args['confirmado'] ?? '0';
    $this->token = $args['token'] ?? '';
}


//mensajes de validacion para la creacion de una cuenta
public function validarNuevaCuenta($object = object) {
    
    $password = $object->password;
    
    foreach ($object as $key => $value) {
        
        
        // Verificar si el valor está vacío y si la clave no es 'id', 'admin', 'confirmado' o 'token'
        if (empty($value) && $key !== 'id' && $key !== 'admin' && $key !== 'confirmado' && $key !== 'token' ) {
            

    
        self::$alertas['error'][] = "El campo {$key} es obligatorio";
            
        }
    }

    if (strlen($this->password) < 6) {
        self::$alertas['error'][] =
            "El password debe tener al menos 6 caracteres";
    }




   
    return self::$alertas;
    
    
    }




    public function existeUsuario(){

       $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";
      
       $resultado = self::$db->query($query); 

       if($resultado->num_rows) {
        self::$alertas['error'][] = "El usuario ya esta registrado";
       }


       return $resultado; 

    }


    public function hashPassword(){
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }


    public function crearToken(){
        $this->token = uniqid();
    }














}


