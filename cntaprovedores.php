<?php
$pagina = "proveedor";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

$consulta = "SELECT * FROM proveedor WHERE estado_prov = 1 ORDER BY id_prov";
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
                    <h1 class="card-title  mx-auto">Proveedores</h1>
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
                                <table name="tablaProveedor" id="tablaProveedor" class="table table-sm table-striped table-bordered table-condensed text-nowrap w-auto mx-auto" style="width:100%">
                                    <thead class="text-center bg-gradient-green">
                                        <tr>
                                            <th>Id</th>
                                            <th>RFC</th>
                                            <th>Nombre</th>
                                            <th>Direccion</th>
                                            <th>Tel Fijo</th>
                                            <th>Tel Móvil</th>
                                            <th>Email</th>
                                            <th>Edo</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($data as $dat) {
                                        ?>
                                            <tr>
                                                <td><?php echo $dat['id_prov'] ?></td>
                                                <td><?php echo $dat['rfc'] ?></td>
                                                <td><?php echo $dat['nombre'] ?></td>
                                                <td><?php echo $dat['direccion'] ?></td>
                                                <td><?php echo $dat['telefono'] ?></td>
                                                <td><?php echo $dat['movil'] ?></td>
                                                <td><?php echo $dat['email'] ?></td>
                                                <td><?php echo $dat['estado_prov'] ?></td>
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
                        <h5 class="modal-title" id="exampleModalLabel">NUEVO PROVEEDOR</h5>

                    </div>
                    <form id="formDatos" action="" method="POST">
                        <div class="modal-body">
                            <div class="row justify-content">

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="rfc" class="col-form-label">RFC:</label>
                                        <input type="text" class="form-control" name="rfc" id="rfc" autocomplete="off" placeholder="RFC">
                                    </div>
                                </div>

                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="nombre" class="col-form-label">Nombre del proveedor:</label>
                                        <input type="text" class="form-control" name="nombre" id="nombre" autocomplete="off" placeholder="Nombre Proveedor">
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="direccion" class="col-form-label">Dirección:</label>
                                        <textarea name="direccion" class="form-control"  id="direccion" rows="2" placeholder="Direccion"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="telefono" class="col-form-label">Teléfono:</label>
                                        <input type="text" class="form-control" name="telefono" id="telefono" autocomplete="off" placeholder="Tel Fijo">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="movil" class="col-form-label">Móvil:</label>
                                        <input type="text" class="form-control" name="movil" id="movil" autocomplete="off" placeholder="Tel Móvil">
                                    </div>
                                </div>

                                <div class="col-sm-6">

                                    <div class="form-group">
                                        <label for="email" class="col-form-label">Correo:</label>
                                        <input type="email" class="form-control" name="email" id="email">
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
    <!-- /.content -->
</div>


<?php include_once 'templates/footer.php'; ?>
<script src="fjs/cntaproveedor.js?v=<?php echo(rand()); ?>"></script>
<script src="fjs/proveedor.js?v=<?php echo (rand()); ?>"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>