<?php
$pagina = "items";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

$consulta = "SELECT * FROM items WHERE estado_item = 1 ORDER BY id_item";
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
                <h1 class="card-title  mx-auto">Items</h1>
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
                                <table name="tablaItems" id="tablaItems" class="table table-sm table-striped table-bordered table-condensed text-nowrap w-auto mx-auto" style="width:100%">
                                    <thead class="text-center bg-gradient-green">
                                        <tr>
                                            <th>Id</th>
                                            <th>Descripción</th>
                                            <th>Tipo</th>
                                            <th>Precio</th>
                                            <th>Costo</th>
                                            <th>Existencia</th>
                                            <th>Edo</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($data as $dat) {
                                        ?>
                                            <tr>
                                                <td><?php echo $dat['id_item'] ?></td>
                                                <td><?php echo $dat['descripcion'] ?></td>
                                                <td><?php echo $dat['tipo'] ?></td>
                                                <td><?php echo $dat['precio'] ?></td>
                                                <td><?php echo $dat['costo'] ?></td>
                                                <td><?php echo $dat['existencia'] ?></td>
                                                <td><?php echo $dat['estado_item'] ?></td>
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
                        <h5 class="modal-title" id="exampleModalLabel">NUEVO ITEM</h5>

                    </div>
                    <form id="formDatos" action="" method="POST">
                        <div class="modal-body row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label for="descripcion" class="col-form-label">Descripción:</label>
                                    <input type="text" class="form-control" name="descripcion" id="descripcion" autocomplete="off" placeholder="descripcion">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group auto">
                                    <label for="tipo" class="col-form-label">Tipo:</label>
                                    <select class="form-control" name="tipo" id="tipo">
                                        
                                            <option id="1" value="Articulo">Articulo</option>
                                            <option id="2" value="Servicio">Servicio</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="precio" class="col-form-label">Precio:</label>
                                    <input type="text" class="form-control" name="precio" id="precio" autocomplete="off" placeholder="Precio">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="costo" class="col-form-label">Costo:</label>
                                    <input type="text" class="form-control" name="costo" id="costo" autocomplete="off" placeholder="Costo">
                                </div>
                            </div>   
                            <div class="col-sm-4">  
                                <div class="form-group">
                                    <label for="existencia" class="col-form-label">Existencia:</label>
                                    <input type="text" class="form-control" name="existencia" id="existencia" autocomplete="off" placeholder="Existencia">
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
<script src="fjs/cntaitems.js?v=<?php echo(rand()); ?>"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>