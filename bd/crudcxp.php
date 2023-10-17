<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$fecha = (isset($_POST['fechasys'])) ? $_POST['fechasys'] : '';
$proveedor = (isset($_POST['id_prov'])) ? $_POST['id_prov'] : '';
$descripcion = (isset($_POST['descripcion'])) ? $_POST['descripcion'] : '';
$gtotal = (isset($_POST['gtotal'])) ? $_POST['gtotal'] : '';
$saldo = (isset($_POST['saldo'])) ? $_POST['saldo'] : '';
$facturado = (isset($_POST['tipo'])) ? $_POST['tipo'] : '';

$subtotal = (isset($_POST[''])) ? $_POST[''] : '';
$iva = (isset($_POST[''])) ? $_POST[''] : '';
$total = (isset($_POST[''])) ? $_POST[''] : '';
$desc = (isset($_POST[''])) ? $_POST[''] : '';
$total = (isset($_POST[''])) ? $_POST[''] : '';

$usuario = (isset($_POST['nameuser'])) ? $_POST['nameuser'] : '';



$id = (isset($_POST['folio'])) ? $_POST['folio'] : '';

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

switch($opcion){
    case 1: //alta

        
        $consulta = "INSERT INTO cxptmp (fecha, usuario) VALUES('$fecha', '$id_prov','$descripcion', '$subtotal', '$iva','$subtotal','$desc', '$gtotal', '$saldo', '$facturado') ";			
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 

        $consulta = "SELECT * FROM cxp ORDER BY folio_cxp DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 2: //modificación
        
        $consulta = "UPDATE cxp SET fecha='$fecha',gtotal='$gtotal',saldo='$saldo'  WHERE folio_cxp='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();        
        
        $consulta = "SELECT * FROM cxp WHERE folio_cxp='$id' ";       
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;        
    case 3://baja
        $consulta = "UPDATE cxp SET estado_cxp=0 WHERE folio_cxp='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 
        $data=1;                          
        break;        
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
