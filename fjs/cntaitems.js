$(document).ready(function() {
    var id_item, opcion;
    opcion = 4;

    tablaitems = $("#tablaItems").DataTable({



        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-primary  btnEditar'><i class='fas fa-edit'></i></button><button class='btn btn-sm btn-danger btnBorrar'><i class='fas fa-trash-alt'></i></button></div></div>"
            },
            { className: "hide_column", targets: [6] },


        ],

        //Para cambiar el lenguaje a español
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros",
            "zeroRecords": "No se encontraron resultados",
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sSearch": "Buscar:",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "sProcessing": "Procesando...",
        }
    });

    $("#btnNuevo").click(function() {


        $("#formDatos").trigger("reset");
        $(".modal-header").css("background-color", "#28a745");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Nuevo Item");
        $("#modalU").modal("show");
        id_item = null;
        opcion = 1; //alta
    });

    var fila; //capturar la fila para editar o borrar el registro

    //botón EDITAR    
    $(document).on("click", ".btnEditar", function() {
        fila = $(this).closest("tr");
        id_item = parseInt(fila.find('td:eq(0)').text());

        descripcion = fila.find('td:eq(1)').text();
        tipo = fila.find('td:eq(2)').text();
        precio = fila.find('td:eq(3)').text();
        costo = fila.find('td:eq(4)').text();
        existencia = fila.find('td:eq(5)').text();
        estado_item = fila.find('td:eq(6)').text();

        
        $("#descripcion").val(descripcion);
        $("#tipo").val(tipo);
        $("#precio").val(precio);
        $("#costo").val(costo);
        $("#existencia").val(existencia);

        opcion = 2; //editar

        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Editar Item");
        $("#modalU").modal("show");

    });

    //botón BORRAR
    $(document).on("click", ".btnBorrar", function() {
        fila = $(this);

        id_item = parseInt($(this).closest("tr").find('td:eq(0)').text());
        opcion = 3 //borrar
            //agregar codigo de sweatalert2
        var respuesta = confirm("¿Está seguro de eliminar el registro: " + id_item + "?");

        if (respuesta) {
            $.ajax({

                url: "bd/cruditem.php",
                type: "POST",
                dataType: "json",
                data: { id_item: id_item, opcion: opcion },

                success: function() {
                    console.log(data);

                    tablaI.row(fila.parents('tr')).remove().draw();
                }
            });
        }
    });

    $("#formDatos").submit(function(e) {
        e.preventDefault();


        
        descripcion = $.trim($("#descripcion").val());
        tipo = $.trim($("#tipo").val());
        precio = $.trim($("#precio").val());
        costo = $.trim($("#costo").val());
        existencia = $.trim($("#existencia").val());

        if (descripcion.length == 0 || tipo.length == 0 || precio.length == 0 ||
            costo.length == 0 || existencia.length == 0 ) {
            Swal.fire({
                title: 'Datos Faltantes',
                text: "Debe ingresar todos los datos del item",
                icon: 'warning',
            })
            return false;


        } else {
            
                $.ajax({
                    url: "bd/cruditem.php",
                    type: "POST",
                    dataType: "json",
                    data: { id_item: id_item, descripcion: descripcion, tipo: tipo, precio: precio, costo: costo, existencia: existencia, opcion: opcion } ,
                    success: function(data){
                        console.log(data);

                        //tablaI.ajax.reload(null, false);
                        
                        id_item = data[0].id_item;
                        descripcion = data[0].descripcion;
                        tipo = data[0].tipo;
                        precio = data[0].precio;
                        costo = data[0].costo;
                        existencia = data[0].existencia;
                        



                        if (opcion == 1) {
                            tablaitems.row.add([id_item, descripcion, tipo, precio, costo, existencia, estado_item ]).draw();
                        } else {
                            tablaitems.row(fila).data([id_item, descripcion, tipo, precio, costo, existencia, estado_item ]).draw();
                        }

                    }
                });

                $("#modalU").modal("hide");
            



        }




    });

});