<?php
    class conn{
        
        function connect(){
       //REMOTO
       /* 
            define('servidor','bosquedelasanimas.com.mx');
            define('bd_nombre','bosquede_inba');
            define('usuario','bosquede_sistema');
            define('password','Gpoferche2022#');
            */
//LOCAL
            define('servidor','localhost');
            define('bd_nombre','capacitacion');
            define('usuario','root');
            define('password','');

            //USUARIO PARA ENTRAR admin CONTRASEÑA 12345

            $opciones=array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');

            try{
                $conexion=new PDO("mysql:host=".servidor.";dbname=".bd_nombre, usuario,password, $opciones);
                return $conexion;
            }catch(Exception $e){
                return null;
            }
        }
    }
?>