$(document).ready(function() {


    tabla = $("#tabla").DataTable({
        searching:false,
        ordering:false,
        info:false,
        paging:false,

        columnDefs: [{
                targets: -1,
                data: null,
                defaultContent: "<div class='text-center'>\
                                    <div class='btn-group'>\
                                        <button class='btn btn-sm btn-primary  btnEditar'><i class='fas fa-edit'></i></button>\
                                    </div>\
                                </div>"
            },
            { className: 'text-center', targets: [0] },
            { className: 'text-center', targets: [1] },
            { className: 'text-center', targets: [2] },
            { className: 'text-right', targets: [3] },
            { className: 'text-right', targets: [4] },
            { className: 'text-right', targets: [5] },
            { className: 'text-right', targets: [6] },
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
        },

        rowCallback: function (row, data) {
       
          valor=data[1]
         
          if (valor == "ENG") {
            //$($(row).find("td")[6]).css("background-color", "warning");
            $($(row).find('td')).addClass('bg-gradient-purple')
            //$($(row).find('td')['9']).text('PENDIENTE')
          } else if (valor =="MSI") {
            //$($(row).find("td")[9]).css("background-color", "blue");
            $($(row).find('td')).addClass('bg-gradient-success')
            //$($(row).find('td')['9']).text('ENVIADO')
          } else{
            $($(row).find('td')).addClass('bg-normal')
           
          }
        },
    });


    $("#btnCalcular").click(function() {
       
        vt=$('#vt').val().replace(/,/g, '')
        nmenseng=$('#nmenseng').val().replace(/,/g, '')
        montoeng=$('#montoeng').val().replace(/,/g, '')
        fechaini=$('#fechaini').val()

        tinteres=$('#tinteres').val().replace(/,/g, '')
        nmenssin=$('#nmenssin').val().replace(/,/g, '')
        nmenscon=$('#nmenscon').val().replace(/,/g, '')

        tabla.clear()
        tabla.draw()

        $.ajax({

            url: "../bd/calcular.php",
            type: "POST",
            dataType: "json",
            data: { vt: vt, nmenseng: nmenseng, tinteres: tinteres, fechaini: fechaini, montoeng: montoeng, nmenssin: nmenssin, nmenscon: nmenscon },

            success: function(res) {
            
                for (var i = 0; i < res.length; i++) {
                    tabla.row
                      .add([
                        res[i].id,
                        res[i].tipo,
                        res[i].fecha,
                        res[i].capital,
                        res[i].interes,
                        res[i].sumaTotal,
                        res[i].saldo,
                        
                      
                      ])
                      .draw()
                  }
            },
            error: function(){
                alert("Funcion Error")
            }
        });
       
    });

    $(document).on('click', '.btnEditar', function () {
        $("#modalEditar").modal('show')

       
    });

    

    $(".btnBorrar").click(function() {
        alert("BOTON BORRAR");
       
    });


    
    document.getElementById('vt').onblur = function () {
      
        this.value = parseFloat(this.value.replace(/,/g, ''))
          .toFixed(2)
          .toString()
          .replace(/\B(?=(\d{3})+(?!\d))/g, ',')
      }

      document.getElementById('montoeng').onblur = function () {
        calcularpor(this.value.replace(/,/g, ''))
      
        this.value = parseFloat(this.value.replace(/,/g, ''))
          .toFixed(2)
          .toString()
          .replace(/\B(?=(\d{3})+(?!\d))/g, ',')
      }

      document.getElementById('poreng').onblur = function () {
        calcularmonto(this.value.replace(/,/g, ''))
      
        this.value = parseFloat(this.value.replace(/,/g, ''))
          .toFixed(2)
          .toString()
          .replace(/\B(?=(\d{3})+(?!\d))/g, ',')
      }

      document.getElementById('tmonto').onblur = function () {
      
        this.value = parseFloat(this.value.replace(/,/g, ''))
          .toFixed(2)
          .toString()
          .replace(/\B(?=(\d{3})+(?!\d))/g, ',')
      }


      
      function calcularpor(monto){
        valor=$('#vt').val().replace(/,/g, '')
       
        porcentaje=((monto/valor)*100).toFixed(2)
       
        $('#poreng').val(porcentaje)
      }
      function calcularmonto(porcentaje){
        valor=$('#vt').val().replace(/,/g, '')
        
        monto=(valor*(porcentaje/100)).toFixed(0)
       
        $('#montoeng').val(parseFloat(monto.replace(/,/g, ''))
        .toFixed(2)
        .toString()
        .replace(/\B(?=(\d{3})+(?!\d))/g, ','))
      }

})


function filterFloat(evt, input) {
    // Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
    var key = window.Event ? evt.which : evt.keyCode
    var chark = String.fromCharCode(key)
    var tempValue = input.value + chark
    var isNumber = key >= 48 && key <= 57
    var isSpecial = key == 8 || key == 13 || key == 0 || key == 46
    if (isNumber || isSpecial) {
      return filter(tempValue)
    }
  
    return false
  }
  function filter(__val__) {
    var preg = /^([0-9]+\.?[0-9]{0,2})$/
    return preg.te
    st(__val__) === true
  }