$(document).ready(function() {
    var id_prov, opcion;
    opcion = 4;

    tablaProv = $("#tablaProveedor").DataTable({



        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-primary  btnEditar'><i class='fas fa-edit'></i></button><button class='btn btn-sm btn-danger btnBorrar'><i class='fas fa-trash-alt'></i></button></div></div>"
            },
            { className: "hide_column", targets: [7] },
           
         

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
        $(".modal-title").text("Nuevo Proveedor");
        $("#modalU").modal("show");
        id_prov = null;
        opcion = 1; //alta
    });

    var fila; //capturar la fila para editar o borrar el registro

    //botón EDITAR    
    $(document).on("click", ".btnEditar", function() {
        fila = $(this).closest("tr");
        id_prov = parseInt(fila.find('td:eq(0)').text());
        rfc = fila.find('td:eq(1)').text();
        nombre = fila.find('td:eq(2)').text();
        direccion = fila.find('td:eq(3)').text();
        telefono = fila.find('td:eq(4)').text();
        movil = fila.find('td:eq(5)').text();
        email = fila.find('td:eq(6)').text();
        edo_prov = fila.find('td:eq(7)').text();
        
       
        $("#rfc").val(rfc);
        $("#nombre").val(nombre);
        $("#direccion").val(direccion);
        $("#telefono").val(telefono);
        $("#movil").val(movil);
        $("#email").val(email);

        opcion = 2; //editar

        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Editar Items");
        $("#modalU").modal("show");

    });

    //botón BORRAR
    $(document).on("click", ".btnBorrar", function() {
        fila = $(this);

        id_prov = parseInt($(this).closest("tr").find('td:eq(0)').text());
        opcion = 3 //borrar
            //agregar codigo de sweatalert2
        var respuesta = confirm("¿Está seguro de eliminar el registro: " + id_prov + "?");

        if (respuesta) {
            $.ajax({

                url: "bd/crudproveedor.php",
                type: "POST",
                dataType: "json",
                data: { id_prov: id_prov, opcion: opcion },

                success: function() {
                    console.log(data);

                    tablaProv.row(fila.parents('tr')).remove().draw();
                }
            });
        }
    });

    $("#formDatos").submit(function(e) {
        e.preventDefault();



        rfc = $.trim($("#rfc").val());
        nombre = $.trim($("#nombre").val());
        direccion = $.trim($("#direccion").val());
        telefono = $.trim($("#telefono").val());
        movil = $.trim($("#movil").val());
        email = $.trim($("#email").val());

        if (rfc.length == 0 || nombre.length == 0 || direccion.length == 0 ||
            telefono.length == 0 || movil.length == 0 || email.length == 0) {
            Swal.fire({
                title: 'Datos Faltantes',
                text: "Debe ingresar todos los datos del Prospecto",
                icon: 'warning',
            })
            return false;


        } else {
            
                $.ajax({
                    url: "bd/crudproveedor.php",
                    type: "POST",
                    dataType: "json",
                    data: { id_prov: id_prov, rfc: rfc, nombre: nombre, direccion: direccion, telefono: telefono, movil: movil, email: email, opcion: opcion },
                    success: function(data) {
                        console.log(data);

                        //tablaProv.ajax.reload(null, false);
                        id_prov = data[0].id_prov;
                        rfc = data[0].rfc;
                        nombre = data[0].nombre;
                        direccion = data[0].direccion;
                        telefono = data[0].telefono;
                        movil = data[0].movil;
                        email = data[0].email;
                        
                        
                        


                        if (opcion == 1) {
                            tablaProv.row.add([id_prov , rfc, nombre, direccion, telefono, movil, email, edo_prov]).draw();
                        } else {
                            tablaProv.row(fila).data([id_prov , rfc, nombre, direccion, telefono, movil, email, edo_prov  ]).draw();
                        }

                    }
                });

                $("#modalU").modal("hide");
            



        }




    });

});