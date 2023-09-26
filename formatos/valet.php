<?php
/*
if (isset($_GET['folio'])) {
    echo getPlantilla($_GET['folio']);
}*/


function getPlantilla($folio)
{
  include_once '../bd/conexion.php';
  $plantilla = "";
  if ($folio != "") {
    $objeto = new conn();
    $conexion = $objeto->connect();

    $consulta = "SELECT * FROM orden WHERE folio_ord='$folio'";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();

    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

    foreach ($data as $dt) {

      $fecha = $dt['fecha'];

      $proyecto = $dt['nom_proy'];
      $proveedor = $dt['nom_prov'];
      $concepto = $dt['concepto'];


      $total = $dt['total'];
    }

    $consultadet = "SELECT * FROM orden_detalle where folio_ord='$folio' and estado_reg='1' order by id_reg";
    $resultadodet = $conexion->prepare($consultadet);
    $resultadodet->execute();
    $datadet = $resultadodet->fetchAll(PDO::FETCH_ASSOC);
  } else {
    echo '<script type="text/javascript">';
    echo 'window.location.href="../cntavale.php";';
    echo '</script>';
  }

  $plantilla .= '



  <body>
    <header class="clearfix">
      <div id="logo">
        <img src="../img/logo-bosque.png">
      </div>
      <div id="company">
        <h3 class="name">ORDEN DE COMPRA</h3>
      </div>

      <div id="folio">
        <table style="border:0">
            <tbody style="border:0">
            <tr style="border:0">
            <td class="desc" style="border:0"><strong>Folio Orden<strong></td>
            <td style="border:0"><strong style="color:red;text-align:right">' . $folio . '</strong></td>

            </tr>
            <tr style="border:0">
            <td class="desc" style="border:0"><strong>Fecha</strong></td>
            <td style="border:0"><p style="text-align:right">' . $fecha . '</p></td>
            </tr>
           
            </tbody>
        </table>
      
      </div>

     
    </header>
    <main>
      <div id="details" class="clearfix">
        <div id="client">
          <p style="text-align:justify">PROYECTO: <strong>' . $proyecto . '</strong></p>
          <p style="text-align:justify">PROVEEDOR: <strong>' . $proveedor . '</strong></p>
          <p style="text-align:justify">CONCEPTO:' . $$concepto . '</p>
        </div>
        
      </div>
    
   

    <table class="sborde" border="0" cellspacing="0" cellpadding="0">
        <thead style:"background-color:#067623">
            <tr>
        
                <th class="total"><strong>CLAVE</strong></th>
                <th class="total"><strong>CONCEPTO</strong></th>
                <th class="total"><strong>CANTIDAD</strong></th>
                <th class="total"><strong>UNIDAD</strong></th>
                <th class="total"><strong>PRECIO U</strong></th>
                <th class="total"><strong>MONTO</strong></th>
            </tr>
        </thead>
        <tbody>';

  foreach ($datadet as $row) {

    $plantilla .= '
            <tr>
                <td class="desc">' . $row['clave'] . '</td>
                <td class="desc">' . $row['concepto'] . '</td>
                <td class="medida">' . $row['cantidad'] . '</td>
                <td class="medida">' . $row['unidad'] . '</td>
                <td class="medida" style="text-align: right">$ ' . number_format($row['precio'], 2) . '</td>
                <td class="medida" style="text-align: right">$ ' . number_format($row['monto'], 2) . '</td>
            </tr>
            ';
  }
  $plantilla .= '
        </tbody>
        <tfoot class="sborde">
                   
        <tr>
          <td ></td>
          <td ></td>
          <td></td>
          <td></td>
          <td  >IMPORTE</td>
          <td >$ ' . number_format($total, 2) . '</td>
        </tr>
      </tfoot>
    </table>

<div style="padding-top:100px">
            <table style="border:0 max-width:25%">
           
                <tbody style="border:0" >
                    <tr>
                    <td style="border:0;border-bottom:1px solid #000000"></td>
                   
                    </tr>
                    <tr>
                    <td class="desc" style="border:0; text-align:center">AUTORIZADO POR:</td>
                   
                    </tr>
                   
                  </tbody>
                 
            </table>
</div>

    </main>
    <footer>
    </footer>
  </body>';

  return $plantilla;
}
