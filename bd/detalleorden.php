<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$id = (isset($_POST['id_reg'])) ? $_POST['id_reg'] : '';
$id_item = (isset($_POST['idconcepto'])) ? $_POST['idconcepto'] : '';
$concepto = (isset($_POST['nomconcepto'])) ? $_POST['nomconcepto'] : '';
$cantidad = (isset($_POST['cantidad'])) ? $_POST['cantidad'] : '';
$precio = (isset($_POST['costou'])) ? $_POST['costou'] : '';
$importe = (isset($_POST['importe'])) ? $_POST['importe'] : '';
$desc = (isset($_POST['desc'])) ? $_POST['desc'] : '';
$gimporte = (isset($_POST['subtotal'])) ? $_POST['subtotal'] : '';

$folio= (isset($_POST['folio'])) ? $_POST['folio'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

switch($opcion){
    case 1: //AGREGAR ITEM A TABLA DETALLE CXP

        
        $consulta = "INSERT INTO cxp_detalle (folio_cxp,id_item,cantidad,precio,importe,descuento,gimporte)
         VALUES('$folio','$id_item','$cantidad','$precio','$importe','$desc','$gimporte') ";			
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 

        $consulta = "SELECT * FROM vdetalle_cxptmp where folio_cxp='$folio' and estado_reg=1 order by id_reg";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 2: //modificación
        
        $consulta = "UPDATE items SET descripcion='$descripcion',tipo='$tipo', precio='$precio', costo='$costo', existencia='$existencia' WHERE id_item='$id_item'";		 //corregir consulta update 
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();        
        
        $consulta = "SELECT * FROM items ORDER BY id_item ";       
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
