<?php
$pagina = "cxp";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();

$conexion = $objeto->connect();
$usuario = $_SESSION['s_nombre'];
$fecha = (isset($_GET['fechasys'])) ? $_GET['fechasys'] : '';
$tokenid = md5($_SESSION['s_usuario']);




$consulta = "SELECT * FROM vcxp WHERE estado_cxp = 1 ORDER BY folio_cxp";

 

$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);


$message = "";


?>

<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->


    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header bg-gradient-green">
                <div class="card-title">
                    <h1 class="card-title  mx-auto">CUENTAS POR PAGAR</h1>
                </div>
            </div>

            <div class="card-body">

                <div class="row">
                    <div class="col-lg-12">
                        <button id="btnNuevo" type="button" class="btn bg-gradient-green btn-ms" data-toggle="modal"><i class="fas fa-user-plus text-light"></i><span class="text-light"> Nuevo</span></button>
                    </div>
                </div>
                <br>
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table name="tablaCxp" id="tablaCxp" class="table table-sm table-striped table-bordered table-condensed text-nowrap w-auto mx-auto" style="width:100%">
                                    <thead class="text-center bg-gradient-green">
                                        <tr>
                                            <th>Folio</th>
                                            <th>Fecha</th>
                                            <th>Proveedor</th>
                                            <th>Descripcion</th>
                                            <th>Gran Total</th>
                                            <th>Saldo</th>
                                            <th>Facturado</th>
                                            <th>Acciones</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($data as $dat) {
                                        ?>
                                            <tr>
                                                <td><?php echo $dat['folio_cxp'] ?></td>
                                                <td><?php echo $dat['fecha'] ?></td>
                                                <td><?php echo $dat['nombre'] ?></td>
                                                <td><?php echo $dat['descripcion'] ?></td>
                                                <td><?php echo $dat['gtotal'] ?></td>
                                                <td><?php echo $dat['saldo'] ?></td>
                                                <td><?php echo $dat['tipo'] ?></td>
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
            <!-- /.card-body -->

            <!-- /.card-footer-->
        </div>
        <!-- /.card -->

    </section>

    <section>
        <div class="modal fade" id="modalU" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-green">
                        <h5 class="modal-title" id="exampleModalLabel">CUENTA POR PAGAR</h5>

                    </div>
                    <form id="formDatos" action="" method="POST">
                        <div class="modal-body">
                            <div class="row justify-content">

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="folio" class="col-form-label">Folio:</label>
                                        <input type="text" class="form-control" name="folio" id="folio" autocomplete="off" placeholder="folio" disabled>
                                    </div>
                                </div>

                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="fecha" class="col-form-label">Fecha:</label>
                                        <input type="date" class="form-control" name="fecha" id="fecha" value="<?php echo $fecha; ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="proveedor" class="col-form-label">Proveedor:</label>
                                        <textarea name="proveedor" class="form-control"  id="proveedor" rows="2" placeholder="proveedor"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="descripcion" class="col-form-label">Descripcion:</label>
                                        <input type="text" class="form-control" name="descripcion" id="descripcion" autocomplete="off" placeholder="Descripcion">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="gtotal" class="col-form-label">Gran Total:</label>
                                        <input type="text" class="form-control" name="gtotal" id="gtotal" autocomplete="off" placeholder="Gran Total">
                                    </div>
                                </div>

                                <div class="col-sm-6">

                                    <div class="form-group">
                                        <label for="saldo" class="col-form-label">Saldo:</label>
                                        <input type="text" class="form-control" name="saldo" id="saldo">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="facturado" class="col-form-label">Facturado:</label>
                                        <input type="text" class="form-control" name="facturado" id="facturado" autocomplete="off" placeholder="Facturado" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>





                        <?php
                        if ($message != "") {
                        ?>
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <span class="badge "><?php echo ($message); ?></span>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>

                            </div>

                        <?php
                        }
                        ?>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</button>
                            <button type="submit" id="btnGuardar" name="btnGuardar" class="btn btn-success" value="btnGuardar"><i class="far fa-save"></i> Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
                    



</div>


<?php include_once 'templates/footer.php'; ?>
<script src="fjs/cntacxp.js?v=<?php echo (rand()); ?>"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>