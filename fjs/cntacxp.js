$(document).ready(function() {
    var id, opcion;
    opcion = 4;

    tablacxp = $("#tablaCxp").DataTable({



        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-primary  btnEditar'><i class='fas fa-edit'></i></button><button class='btn btn-sm btn-danger btnBorrar'><i class='fas fa-trash-alt'></i></button></div></div>"
            },
        

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
        window.location.href ="cxp.php"

    });

    var fila; //capturar la fila para editar o borrar el registro

    //botón EDITAR    
    $(document).on("click", ".btnEditar", function() {
        
            fila = $(this).closest("tr");
            id = parseInt(fila.find('td:eq(0)').text());
            fecha = fila.find('td:eq(1)').text();
            proveedor = fila.find('td:eq(2)').text();
            descripcion = fila.find('td:eq(3)').text();
            gtotal = fila.find('td:eq(4)').text();
            saldo = fila.find('td:eq(5)').text();
            facturado = fila.find('td:eq(6)').text();
            estado_reg = fila.find('td:eq(7)').text();
        

            $("#folio").val(id);
            $("#fecha").val(fecha);
            $("#proveedor").val(proveedor);
            $("#descripcion").val(descripcion);
            $("#gtotal").val(gtotal);
            $("#saldo").val(saldo);
            $("#facturado").val(facturado);
    
            opcion = 2; //editar
    
            $(".modal-header").css("background-color", "#007bff");
            $(".modal-header").css("color", "white");
            $(".modal-title").text("Editar Items");
            $("#modalU").modal("show");
    
        });

    //botón BORRAR
    $(document).on("click", ".btnBorrar", function() {
        fila = $(this);

        id = parseInt($(this).closest("tr").find('td:eq(0)').text());
        opcion = 3 //borrar
            //agregar codigo de sweatalert2
        var respuesta = confirm("¿Está seguro de eliminar el registro: " + id + "?");

        if (respuesta) {
            $.ajax({

                url: "bd/crudcxp.php",
                type: "POST",
                dataType: "json",
                data: { id: id, opcion: opcion },

                success: function() {
                    console.log(data);

                    tablacxp.row(fila.parents('tr')).remove().draw();
                }
            });
        }
    });

    $("#formDatos").submit(function(e) {
        e.preventDefault();



        fecha = $.trim($("#fecha").val());
        proveedor = $.trim($("#proveedor").val());
        descripcion = $.trim($("#descripcion").val());
        gtotal = $.trim($("#gtotal").val());
        saldo = $.trim($("#saldo").val());
        facturado = $.trim($("#facturado").val());

        if (fecha.length == 0 || proveedor.length == 0 || descripcion.length == 0 ||
            gtotal.length == 0 || saldo.length == 0 || facturado.length == 0) {
            Swal.fire({
                title: 'Datos Faltantes',
                text: "Debe ingresar todos los datos de la cuenta",
                icon: 'warning',
            })
            return false;


        } else {
            
                $.ajax({
                    url: "bd/crudcxp.php",
                    type: "POST",
                    dataType: "json",
                    data: { id: id, fecha: fecha, proveedor: proveedor, descripcion: descripcion, gtotal: gtotal, saldo: saldo, facturado: facturado, opcion: opcion },
                    success: function(data) {
                        console.log(data);

                        //tabla.ajax.reload(null, false);
                        id = data[0].id;
                        fecha = data[0].fecha;
                        proveedor = data[0].proveedor;
                        descripcion = data[0].descripcion;
                        gtotal = data[0].gtotal;
                        saldo = data[0].saldo;
                        facturado = data[0].facturado;
                        
                        
                        


                        if (opcion == 1) {
                            tablacxp.row.add([id , fecha, proveedor, descripcion, gtotal, saldo, facturado, estado_reg]).draw();
                        } else {
                            tablacxp.row(fila).data([id , fecha, proveedor, descripcion, gtotal, saldo, facturado, estado_reg  ]).draw();
                        }

                    }
                });

                $("#modalU").modal("hide");
            



        }


    });


});