<?php
namespace Controllers;

use Model\Usuario;
use MVC\Router;
use Classes\Email;

class LoginController {
    public static function login(Router $router) {
        $router->render('auth/login');
    }

    public static function logout(){
        echo "desde logout";
    }
    public static function olvide(Router $router){
        $router->render('auth/olvide-password',[]);
    }

     public static function recuperar(){
        echo "desde recuperar";
    }

     public static function crear(Router $router){
         
     $usuario = new Usuario($_POST); 

     $alertas = [];
     
     if($_SERVER['REQUEST_METHOD'] === 'POST'){
         
         $usuario->sincronizar($_POST);
         
         

        $alertas = $usuario->validarNuevaCuenta($usuario);

        //revisar que alertas este vacio
        if(empty($alertas)){

         $resultado =  $usuario->existeUsuario();    
        
        if($resultado ->num_rows){

            $alertas = Usuario::getAlertas();


        } 
        else{
            //no esta registrado
              
            $usuario->hashPassword();
            $usuario->crearToken();

            //enviar correo
            $email = new Email($usuario->email, $usuario->nombre, $usuario->token);

            $email->enviarConfirmacion();


            //crear usuario
            $resultado = $usuario->guardar();

            if($resultado){
                header('Location: /mensaje');
            }


            
        }


        }

     }

     $router->render('auth/crear-cuenta',[

     'usuario' => $usuario,
     'alertas' => $alertas  


        ]);
    }


    public static function mensaje(Router $router){

    $router->render('auth/mensaje');

    }












}//fin de la clase