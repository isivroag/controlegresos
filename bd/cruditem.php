<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$descripcion = (isset($_POST['descripcion'])) ? $_POST['descripcion'] : '';
$tipo = (isset($_POST['tipo'])) ? $_POST['tipo'] : '';
$precio = (isset($_POST['precio'])) ? $_POST['precio'] : '';
$costo = (isset($_POST['costo'])) ? $_POST['costo'] : '';
$existencia = (isset($_POST['existencia'])) ? $_POST['existencia'] : '';


$id_item = (isset($_POST['id_prov'])) ? $_POST['id_prov'] : '';

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

switch($opcion){
    case 1: //alta

        
        $consulta = "INSERT INTO items (descripcion,tipo,precio,costo,existencia) VALUES('$descripcion','$tipo', '$precio', '$costo','$existencia') ";			
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 

        $consulta = "SELECT * FROM items ORDER BY id_item DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 2: //modificación
        
        $consulta = "UPDATE items SET descripcion='$descripcion',tipo='$tipo', precio='$precio', costo='$costo', existencia='$existencia'";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();        
        
        $consulta = "SELECT * FROM items WHERE id_prov='$id_item' ";       
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;        
    case 3://baja
        $consulta = "UPDATE items SET estado_item=0 WHERE id_item='$id_item' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 
        $data=1;                          
        break;        
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
