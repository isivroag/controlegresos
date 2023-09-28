<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$rfc = (isset($_POST['rfc'])) ? $_POST['rfc'] : '';
$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';
$direccion = (isset($_POST['direccion'])) ? $_POST['direccion'] : '';
$telefono = (isset($_POST['telefono'])) ? $_POST['telefono'] : '';
$movil = (isset($_POST['movil'])) ? $_POST['movil'] : '';
$email = (isset($_POST['email'])) ? $_POST['email'] : '';

$id_prov = (isset($_POST['id_prov'])) ? $_POST['id_prov'] : '';

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

switch($opcion){
    case 1: //alta

        
        $consulta = "INSERT INTO proveedor (rfc,nombre,direccion,telefono,movil,email) VALUES('$rfc','$nombre', '$direccion', '$telefono','$movil','$email') ";			
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 

        $consulta = "SELECT * FROM proveedor ORDER BY id_prov DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 2: //modificación
        
        $consulta = "UPDATE proveedor SET rfc='$rfc',nombre='$nombre', direccion='$direccion', telefono='$telefono', movil='$movil', email='$email' WHERE id_prov='$id_prov' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();        
        
        $consulta = "SELECT * FROM proveedor WHERE id_prov='$id_prov' ";       
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;        
    case 3://baja
        $consulta = "UPDATE proveedor SET estado_prov=0 WHERE id_prov='$id_prov' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 
        $data=1;                          
        break;        
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
