<?php
$pagina = "ordencompra";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";


include_once 'bd/conexion.php';

$folio = (isset($_GET['folio'])) ? $_GET['folio'] : '';
$objeto = new conn();
$conexion = $objeto->connect();
$tokenid = md5($_SESSION['s_usuario']);

if ($folio != "") {

    $opcion = 2;
    $consulta = "SELECT * FROM orden where folio_cxp='$folio'";

    $resultado = $conexion->prepare($consulta);
    $resultado->execute();


    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

    foreach ($data as $dt) {
        $folio = $dt['folio_cxp'];

        $fecha = $dt['fecha'];
        $id_prov = $dt['id_prov'];
        $proveedor = $dt['nombre'];
        
        $concepto = $dt['concepto'];
        $total = $dt['total'];
    }





    $message = "";
} else {


    //BUSCAR CUENTA ABIERTA


    $consultatmp = "SELECT * FROM orden WHERE tokenid='$tokenid' and activo='0' ORDER BY folio_ord DESC LIMIT 1";
    $resultadotmp = $conexion->prepare($consultatmp);
    $resultadotmp->execute();
    if ($resultadotmp->rowCount() >= 1) {
        $datatmp = $resultadotmp->fetchAll(PDO::FETCH_ASSOC);
    } else {

        // INSERTAR FOLIO NUEVO

        $fecha = date('Y-m-d');
        $consultatmp = "INSERT INTO orden (tokenid,fecha,total,activo) VALUES('$tokenid','$fecha','0','0')";
        $resultadotmp = $conexion->prepare($consultatmp);
        $resultadotmp->execute();


        $consultatmp = "SELECT * FROM orden WHERE tokenid='$tokenid' and activo='0'  ORDER BY folio_ord DESC LIMIT 1";
        $resultadotmp = $conexion->prepare($consultatmp);
        $resultadotmp->execute();
        $datatmp = $resultadotmp->fetchAll(PDO::FETCH_ASSOC);
    }





    foreach ($datatmp as $dt) {

        $folio =  $dt['folio_ord'];
        $opcion = 1;
        $fecha = $dt['fecha'];
        $id_prov = "";
        $proveedor = "";
        
        
        $concepto = "";
        $total =  $dt['total'];
    }
}

$consultac = "SELECT * FROM w_proveedor WHERE estado_prov=1 ORDER BY id_prov";
$resultadoc = $conexion->prepare($consultac);
$resultadoc->execute();
$datac = $resultadoc->fetchAll(PDO::FETCH_ASSOC);

$consultacon = "SELECT * FROM w_proyecto WHERE estado_proy=1 ORDER BY id_proy";
$resultadocon = $conexion->prepare($consultacon);
$resultadocon->execute();
$dataproyecto = $resultadocon->fetchAll(PDO::FETCH_ASSOC);

$cntades = "SELECT * FROM w_concepto where estado_concepto=1 order by id_concepto";
$resdes = $conexion->prepare($cntades);
$resdes->execute();
$datades = $resdes->fetchAll(PDO::FETCH_ASSOC);

?>

<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

<style>
    .borde-titulogris {
        border-left: grey;
        border-style: outset;
        ;
    }

    .fondogris {
        background-color: rgba(183, 185, 187, .8);
    }

    .borde-titulazul {
        border-left: rgb(117, 74, 195);
        border-style: outset;
        ;
    }

    .fondoazul {
        background-color: rgba(117, 74, 195, 0.8);
    }

    .borde-titulinfo {
        border-left: rgb(23, 162, 184);
        border-style: outset;
        ;
    }

    .fondoinfo {
        background-color: rgba(23, 162, 184, .8);
    }

    .borde-titulpur {
        border-left: rgb(117, 74, 195);
        border-style: outset;
        ;
    }

    .fondopur {
        background-color: rgba(117, 74, 195, .8);
    }




    .punto {
        height: 20px !important;
        width: 20px !important;

        border-radius: 50% !important;
        display: inline-block !important;
        text-align: center;
        font-size: 15px;
    }

    .div_carga {
        position: absolute;
        /*top: 50%;
    left: 50%;
    */

        width: 100%;
        height: 100%;
        background-color: rgba(60, 60, 60, 0.5);
        display: none;

        justify-content: center;
        align-items: center;
        z-index: 3;
    }

    .cargador {
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: -25px;
        margin-left: -25px;
    }

    .textoc {
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: 120px;
        margin-left: 20px;


    }
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->


    <!-- FOMRULARIO ALTA CXP -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header bg-gradient-secondary text-light">
                <h1 class="card-title mx-auto">ORDENES DE COMPRA</h1>
            </div>

            <div class="card-body">

                <div class="row">
                    <div class="col-lg-12">
                        <?php if ($opcion == 1) { ?>
                            <button type="button" id="btnGuardar" name="btnGuardar" class="btn btn-success" value="btnGuardar" <?php echo $opcion == 2 ? 'disabled' : '' ?>><i class="far fa-save"></i> Guardar</button>
                        <?php } ?>

                    </div>
                </div>

                <br>



                <form id="formDatos" action="" method="POST">


                    <div class="content" disab>

                        <div class="card card-widget" style="margin-bottom:0px;">

                            <div class="card-header bg-gradient-secondary " style="margin:0px;padding:8px">

                                <h1 class="card-title ">DETALLE DE ORDEN DE COMPRA</h1>
                            </div>

                            <div class="card-body" style="margin:0px;padding:1px;">

                                <div class="row justify-content-sm-center">

                                    <div class="col-sm-2"></div>

                                    <div class="col-sm-2">
                                        <div class="form-group input-group-sm">
                                            <label for="folior" class="col-form-label">Folio:</label>
                                            <input type="hidden" class="form-control" name="folio" id="folio" value="<?php echo $folio; ?>">
                                            <input type="text" class="form-control" name="folior" id="folior" value="<?php echo   $folio; ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-4"></div>

                                    <div class="col-sm-2">
                                        <div class="form-group input-group-sm">
                                            <label for="fecha" class="col-form-label">Fecha:</label>
                                            <input type="date" class="form-control" name="fecha" id="fecha" value="<?php echo $fecha; ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-2"></div>


                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <input type="hidden" class="form-control" name="tokenid" id="tokenid" value="<?php echo $tokenid; ?>">
                                            <input type="hidden" class="form-control" name="opcion" id="opcion" value="<?php echo $opcion; ?>">
                                            <input type="hidden" class="form-control" name="id_prov" id="id_prov" value="<?php echo $id_prov; ?>">
                                            <label for="nombre" class="col-form-label">Proveedor:</label>

                                            <div class="input-group input-group-sm">

                                                <input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo $proveedor; ?>" disabled>
                                                <?php if ($opcion == 1) { ?>
                                                    <span class="input-group-append">
                                                        <button id="bproveedor" type="button" class="btn btn-primary "><i class="fas fa-search"></i></button>
                                                        <button id="bproveedorplus" type="button" class="btn btn-success "><i class="fas fa-plus-square"></i></button>
                                                    </span>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="col-sm-4">
                                        <div class="form-group">

                                            <input type="hidden" class="form-control" name="id_proy" id="id_proy" value="<?php echo $id_proy; ?>">
                                            <label for="proyecto" class="col-form-label">Proyecto:</label>

                                            <div class="input-group input-group-sm">

                                                <input type="text" class="form-control" name="proyecto" id="proyecto" value="<?php echo $proyecto; ?>" disabled>
                                                <?php if ($opcion == 1) { ?>
                                                    <span class="input-group-append">
                                                        <button id="bproyecto" type="button" class="btn btn-primary "><i class="fas fa-search"></i></button>
                                                        <button id="bproyectoplus" type="button" class="btn btn-success "><i class="fas fa-plus-square"></i></button>
                                                    </span>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>




                                </div>

                                <div class=" row justify-content-sm-center">
                                    <div class="col-sm-8">

                                        <div class="form-group">
                                            <label for="concepto" class="col-form-label">Concepto:</label>
                                            <textarea rows="2" class="form-control" name="concepto" id="concepto"><?php echo $concepto; ?></textarea>
                                        </div>

                                    </div>



                                </div>
                                <div class="row justify-content-sm-center m-auto" style="padding:5px 0px;margin-bottom:5px">
                                    <div class="col-sm-10">
                                        <div class="card ">

                                            <div class="card-header bg-secondary " style="margin:0px;padding:8px">
                                                <div class="card-tools" style="margin:0px;padding:0px;">


                                                </div>
                                                <h1 class="card-title text-light">DETALLE DE CONCEPTO</h1>
                                                <div class="card-tools" style="margin:0px;padding:0px;">


                                                </div>
                                            </div>

                                            <div class="card-body" style="margin:0px;padding:3px;">

                                                <div class="card card-widget collapsed-card " style="margin:2px;padding:5px;">

                                                    <div class="card-header " style="margin:0px;padding:8px;">

                                                        <button type="button" class="btn bg-gradient-secondary btn-sm" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                            Agregar Concepto <i class="fas fa-plus"></i>
                                                        </button>

                                                    </div>

                                                    <div class="card-body " style="margin:0px;padding:2px 5px;">
                                                        <div class="row justify-content-sm-center">

                                                            <div class="col-lg-5">
                                                                <div class="input-group input-group-sm">

                                                                    <input type="hidden" class="form-control" name="idconcepto" id="idconcepto">

                                                                    <input type="hidden" class="form-control" name="claveconcepto" id="claveconcepto">


                                                                    <label for="nomconcepto" class="col-form-label">Concepto:</label>
                                                                    <div class="input-group input-group-sm">
                                                                        <input type="text" class="form-control" name="nomconcepto" id="nomconcepto" disabled>
                                                                        <span class="input-group-append">
                                                                            <button id="btnInsumodes" type="button" class="btn btn-sm btn-primary"><i class="fas fa-search"></i></button>
                                                                        </span>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="col-sm-1">
                                                            <label for="unidadm" class="col-form-label">Unidad:</label>
                                                                <div class="input-group input-group-sm">
                                                                    <input type="text" class="form-control" name="unidadm" id="unidadm" disabled>
                                                                </div>
                                                            </div>



                                                            <div class="col-lg-2">
                                                                <label for="costou" class="col-form-label">Precio:</label>
                                                                <div class="input-group input-group-sm">
                                                                    <input type="text" class="form-control" name="costou" id="costou" disabled>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-2">
                                                                <label for="cantidadconcepto" class="col-form-label">Cantidad:</label>
                                                                <div class="input-group input-group-sm">
                                                                    <input type="text" class="form-control" name="cantidadconcepto" id="cantidadconcepto" disabled>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-1 justify-content-center">
                                                                <label for="" class="col-form-label">Acción:</label>
                                                                <div class="input-group-append input-group-sm justify-content-center d-flex">
                                                                    <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Agregar Item">
                                                                        <button type="button" id="btnagregarides" name="btnagregarides" class="btn btn-sm bg-gradient-orange" value="btnGuardari"><i class="fas fa-plus-square"></i></button>
                                                                    </span>
                                                                    <span class="d-inline-block" tabindex="1" data-toggle="tooltip" title="Limpiar">
                                                                        <button type="button" id="btlimpiarides" name="btlimpiarides" class="btn btn-sm bg-gradient-secondary" value="btnlimpiari"><i class="fas fa-brush"></i></button>
                                                                    </span>
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>


                                                <div class="row">

                                                    <div class="col-lg-12 mx-auto">
                                                        <div class="table-responsive" style="padding:5px;">
                                                            <table name="tablaDetIndes" id="tablaDetIndes" class="table table-sm table-striped table-bordered table-condensed text-nowrap mx-auto" style="width:100%;font-size:15px">
                                                                <thead class="text-center bg-gradient-secondary">
                                                                    <tr>
                                                                        <th>Id</th>
                                                                        <th>Folio</th>
                                                                        <th>id_item </th>
                                                                        <th>Cantidad</th>
                                                                        <th>Precio</th>
                                                                        <th>Precio U.</th>
                                                                        <th>Importe</th>
                                                                        <th>Descuento</th>
                                                                        <th>GImporte</th>
                                                                        <th>Acciones</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    $consultadeto = "SELECT * FROM cxp_detalle where folio_cxp='$folio' and estado_reg=1 order by id_reg";
                                                                    $resultadodeto = $conexion->prepare($consultadeto);
                                                                    $resultadodeto->execute();
                                                                    $datadeto = $resultadodeto->fetchAll(PDO::FETCH_ASSOC);
                                                                    foreach ($datadeto as $rowdet) {
                                                                    ?>
                                                                        <tr>
                                                                            <td><?php echo $rowdet['id_reg'] ?></td>
                                                                            <td><?php echo $rowdet['clave'] ?></td>
                                                                            <td><?php echo $rowdet['concepto'] ?></td>
                                                                            <td class="text-right"><?php echo number_format($rowdet['cantidad'],2) ?></td>
                                                                            <td ><?php echo $rowdet['unidad'] ?></td>
                                                                            <td class="text-right"><?php echo number_format($rowdet['precio'],2) ?></td>
                                                                            <td class="text-right"><?php echo number_format($rowdet['monto'],2) ?></td>
                                                                            <td></td>
                                                                        </tr>
                                                                    <?php
                                                                    }
                                                                    ?>

                                                                </tbody>
                                                            </table>

                                                        </div>

                                                    </div>

                                                </div>




                                            </div>

                                        </div>
                                    </div>
                                </div>


                                <div class="row justify-content-sm-center" style="padding:5px 0px;margin-bottom:5px">

                                    <div class="col-sm-8 ">


                                    </div>

                                    

                                    <div class="col-sm-2 ">
                                        <label for="total" class="col-form-label ">Total:</label>

                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-dollar-sign"></i>
                                                </span>
                                            </div>

                                            <input type="text" class="form-control text-right" name="total" id="total" value="<?php echo number_format($total,2); ?>" onkeypress="return filterFloat(event,this);" disabled>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>



                <!-- MATERIALES USADOS-->

                <!-- TERMINA MATERIALES USADOS -->
            </div>

        </div>
    </section>
    <!-- TERMINA ALTA CXP -->

    <!-- INICIA TABLA PROVEEDOR-->
    <section>
        <div class="container">
            <div class="modal fade" id="modalProspecto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content w-auto">
                        <div class="modal-header bg-gradient-secondary">
                            <h5 class="modal-title" id="exampleModalLabel">BUSCAR PROVEEDOR</h5>

                        </div>
                        <br>
                        <div class="table-hover table-responsive w-auto " style="padding:10px">
                            <table name="tablaC" id="tablaC" class="table table-sm table-striped text-nowrap table-bordered table-condensed " style="width:100%">
                                <thead class="text-center bg-gradient-primary">
                                    <tr>
                                        <th>Id</th>
                                        <th>RFC</th>
                                        <th>Proveedor</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($datac as $datc) {
                                    ?>
                                        <tr>
                                            <td><?php echo $datc['id_prov'] ?></td>
                                            <td><?php echo $datc['rfc_prov'] ?></td>
                                            <td><?php echo $datc['razon_prov'] ?></td>
                                            <td></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- TERMINA TABLA PROVEEDOR-->

    <!-- INICIA TABLA PROYECTO -->
    <section>
        <div class="container">

            <!-- Default box -->
            <div class="modal fade" id="modalProyecto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-md" role="document">
                    <div class="modal-content w-auto">
                        <div class="modal-header bg-gradient-secondary">
                            <h5 class="modal-title" id="exampleModalLabel">BUSCAR PROYECTO</h5>

                        </div>
                        <br>
                        <div class="table-hover table-responsive w-auto" style="padding:15px">
                            <table name="tablaCon" id="tablaCon" class="table table-sm text-nowrap table-striped table-bordered table-condensed" style="width:100%">
                                <thead class="text-center bg-gradient-primary">
                                    <tr>
                                        <th>Id</th>
                                        <th>Clave</th>
                                        <th>Proyecto</th>
                                        <th>Seleccionar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($dataproyecto as $datc) {
                                    ?>
                                        <tr>
                                            <td><?php echo $datc['id_proy'] ?></td>
                                            <td><?php echo $datc['clave_proy'] ?></td>
                                            <td><?php echo $datc['nom_proy'] ?></td>
                                            <td></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- TERMINA TABLA PROYECTO -->

    <!-- TABLA CONCEPTOS -->
    <section>
        <div class="container">

            <!-- Default box -->
            <div class="modal fade" id="modalDes" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-md" role="document">
                    <div class="modal-content w-auto">
                        <div class="modal-header bg-gradient-secondary">
                            <h5 class="modal-title" id="exampleModalLabel">BUSCAR CONCEPTOS</h5>

                        </div>
                        <br>
                        <div class="table-hover table-responsive w-auto" style="padding:15px">
                            <table name="tablaDes" id="tablaDes" class="table table-sm table-striped table-bordered table-condensed" style="width:100%">
                                <thead class="text-center bg-gradient-primary">
                                    <tr>

                                        <th>Id</th>
                                        <th>Concepto</th>
                                        <th>Tipo</th>
                                        <th>Precio</th>
                                        <th>Seleccionar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($datades as $datd) {
                                    ?>
                                        <tr>

                                            <td><?php echo $datd['id_item'] ?></td>
                                            <td><?php echo $datd['descripcion'] ?></td>
                                            <td><?php echo $datd['tipo'] ?></td>
                                            <td><?php echo $datd['precio'] ?></td>
                                            <td></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- TERMINA CONCEPTOS -->

    <!-- /.content -->
</div>



<?php include_once 'templates/footer.php'; ?>
<script src="fjs/ordencompra.js?v=<?php echo (rand()); ?>"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script src="http://cdn.datatables.net/plug-ins/1.10.21/sorting/formatted-numbers.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>