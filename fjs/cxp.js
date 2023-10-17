$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip()
  
    var id, opcion
    var operacion = $('#opcion').val()
   //VARIABLES PARA APARTAR EL LUGAR 
    var usuario = $('#nameuser').val()
    var fecha = $('#fechasys').val()
  
    var textopermiso = permisos()
  
    function permisos() {
      if (operacion == 1) {
        columnas =
          "<div class='text-center'><button class='btn btn-sm btn-danger btnBorrar'><i class='fas fa-trash-alt'></i></button></div>"
      } else {
        columnas = ''
      }
      return columnas
    }
  //tabla2 es tabla buscar proveedor
    tablaC = $('#tabla2').DataTable({
      columnDefs: [
        {
          targets: -1,
          data: null,
          defaultContent:
            "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-success btnSelprov'><i class='fas fa-hand-pointer'></i></button></div></div>",
        },
      ],
  
      //Para cambiar el lenguaje a español
      language: {
        lengthMenu: 'Mostrar _MENU_ registros',
        zeroRecords: 'No se encontraron resultados',
        info:
          'Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros',
        infoEmpty: 'Mostrando registros del 0 al 0 de un total de 0 registros',
        infoFiltered: '(filtrado de un total de _MAX_ registros)',
        sSearch: 'Buscar:',
        oPaginate: {
          sFirst: 'Primero',
          sLast: 'Último',
          sNext: 'Siguiente',
          sPrevious: 'Anterior',
        },
        sProcessing: 'Procesando...',
      },
    })
  
    
    //TABLA DETALLE DE desechables
    tablaDetIndes = $('#tablaDetIndes').DataTable({
      paging: false,
      ordering: false,
      info: false,
      searching: false,
  
      columnDefs: [
        {
          targets: -1,
          data: null,
          defaultContent: textopermiso,
        },
      ],
  
      language: {
        lengthMenu: 'Mostrar _MENU_ registros',
        zeroRecords: 'No se encontraron resultados',
        info:
          'Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros',
        infoEmpty: 'Mostrando registros del 0 al 0 de un total de 0 registros',
        infoFiltered: '(filtrado de un total de _MAX_ registros)',
        sSearch: 'Buscar:',
        oPaginate: {
          sFirst: 'Primero',
          sLast: 'Último',
          sNext: 'Siguiente',
          sPrevious: 'Anterior',
        },
        sProcessing: 'Procesando...',
      },
  
      rowCallback: function (row, data) {
        $($(row).find('td')[3]).addClass('text-right')
        val = numeral(data[3]).format('0,0.00')
        
  
        $($(row).find('td')[3]).text(val)
  
        val2 = numeral(data[5]).format('0,0.00')
  
        $($(row).find('td')[5]).addClass('text-right')
        $($(row).find('td')[5]).text(val2)
  
        val3 = numeral(data[6]).format('0,0.00')
  
        $($(row).find('td')[6]).addClass('text-right')
        $($(row).find('td')[6]).text(val3)
      },
    })
  
    //TABLA DESECHABLE , tabla seleccionar items boton seleccionar
    tablaDes = $('#tablaDes').DataTable({
      columnDefs: [
        {
          targets: -1,
          data: null,
          defaultContent:
            "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-success btnSelDesechable'><i class='fas fa-hand-pointer'></i></button></div></div>",
        },
      ],
  
      //Para cambiar el lenguaje a español
      language: {
        lengthMenu: 'Mostrar _MENU_ registros',
        zeroRecords: 'No se encontraron resultados',
        info:
          'Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros',
        infoEmpty: 'Mostrando registros del 0 al 0 de un total de 0 registros',
        infoFiltered: '(filtrado de un total de _MAX_ registros)',
        sSearch: 'Buscar:',
        oPaginate: {
          sFirst: 'Primero',
          sLast: 'Último',
          sNext: 'Siguiente',
          sPrevious: 'Anterior',
        },
        sProcessing: 'Procesando...',
      },
    })

  //boton buscar provedor
    $(document).on('click', '#bproveedor', function () {
      $('.modal-header').css('background-color', '#007bff')
      $('.modal-header').css('color', 'white')
      $('#modalProveedor').modal('show')
    })

    //boton selecionar provedor
    $(document).on('click', '#bproveedorplus', function () {
      window.location.href = 'cntaprovedores.php'
    })

    //funcion del boton seleccionar prov,
    // selecciona los datos de la fila y llena los campos correspondientes
    $(document).on('click', '.btnSelprov', function () {
      fila = $(this).closest('tr')
  
      idprov = fila.find('td:eq(0)').text()
      nomprov = fila.find('td:eq(2)').text()
  
      opcion = 1
  
      $('#id_prov').val(idprov)
      $('#nombre').val(nomprov)
      $('#modalProveedor').modal('hide')
    })

    //BOTON GUARDAR ORDENES DE COMPRA
    $(document).on('click', '#btnGuardar', function () {
      folio = $('#folio').val()
      fecha = $('#fechasys').val()
  
      id_prov = $('#id_prov').val()
      proveedor = $('#nombre').val()
      descripcion = $('#descripcion').val()
      
      id_item = $('#').val();
      nom_item = $('#').val();
      
      gtotal = $('#gtotal').val().replace(/,/g, '')
      tokenid = $('#tokenid').val()
      opcion = $('#opcion').val()

    //validacion de campos faltantes de la orden
      if (
        gtotal.length != 0 &&
        descripcion.length != 0 &&
        id_prov.length != 0 &&
        proveedor.length != 0 &&
        id_item.length != 0 &&
        nom_item.length != 0
      ) {
        $.ajax({
          type: 'POST',
          url: 'bd/crudorden.php',
          dataType: 'json',
          data: {
            fecha: fecha,
            folio: folio,
            id_prov: id_prov,
            proveedor: proveedor,
            descripcion: descripcion,
            gtotal: gtotal,
            tokenid: tokenid,
            opcion: opcion,
          },
          success: function (res) {
            if (res == 0) {
              Swal.fire({
                title: 'Error al Guardar',
                text: 'No se puedo guardar los datos del cliente',
                icon: 'error',
              })
            } else {
              Swal.fire({
                title: 'Operación Exitosa',
                text: 'Presupuesto Guardado',
                icon: 'success',
              })
  
              window.setTimeout(function () {
                window.location.href = 'ordencompra.php'
              }, 1500)
            }
          },
        })
      } else {
        Swal.fire({
          title: 'Datos Faltantes',
          text: 'Debe ingresar todos los datos del Item',
          icon: 'warning',
        })
        return false
      }
    })

    //BOTON BUSCAR DESECHABLE,
    $(document).on('click', '#btnInsumodes', function () {
      $('#modalDes').modal('show')
    })
  
    // SELECCIONAR  DESECHABLE
    $(document).on('click', '.btnSelDesechable', function () {
      
      fila = $(this).closest('tr')
      id_item = fila.find('td:eq(0)').text()
      concepto = fila.find('td:eq(1)').text()
      unidad = fila.find('td:eq(2)').text()
      precio = fila.find('td:eq(3)').text()

      $('#idconcepto').val(id_item)
      $('#nomconcepto').val(concepto)
      $('#costou').val(precio)
      $('#unidadm').val(unidad)
      
      
      $('#unidadm').prop('disabled', true)
      $('#costou').prop('disabled', true)
      $('#importe').prop('disabled', true)
      $('#gimporte').prop('disabled', true)
      $('#cantidad').prop('disabled', false)
      $('#desc').prop('disabled', false)

      

      $('#modalDes').modal('hide')
      obtImport();
      
    })
//FUNCIONES OBTENER IMPORTE AUTOMATICO
function obtImport() {
  var costou = parseFloat(document.getElementById('costou').value) || 0;
  var cantidad = parseInt(document.getElementById('cantidad').value) || 0;
  var importe = costou * cantidad;
  document.getElementById('importe').value = importe.toFixed(2);
  obtGimport();
}

//FUNCIONES OBTENER subtotal AUTOMATICO
    function obtGimport(){
      var desc = parseFloat(document.getElementById('desc').value) || 0;
      var importe = parseFloat(document.getElementById('importe').value) || 0;
      
      
          var gimporte = importe - (importe * (desc/100));
          document.getElementById('subtotal').value = gimporte.toFixed(2);
      
    }

    //BOTON LIMPIAR DESECHABLE
    $(document).on('click', '#btlimpiarides', function () {
      limpiardes()
    });
  
    //AGREGAR DESECHABLE, ITEM A LA TABLA DETALLES
    $(document).on('click', '#btnagregarides', function () {
      
      folio = $('#folio').val()
      iditem = $('#idconcepto').val()
      clave = $('#claveconcepto').val()
      concepto = $('#nomconcepto').val()
      cantidad = $('#cantidad').val().replace(/,/g, '')
      unidad = $('#unidadm').val()
      precio = $('#costou').val().replace(/,/g, '')
      desc = $('#desc').val()
      importe = $('#importe').val()
      gimporte = $('#subtotal').val()



      usuario = $('#nameuser').val()
      opcion = 1 
  
      if (
        folio.length != 0 &&
        iditem.length != 0 &&
        cantidad.length != 0 &&  
        precio.length != 0 &&
        desc.length != 0 
      ) {
        $.ajax({
          type: 'POST',
          url: 'bd/detalleorden.php',
          dataType: 'json',
          async: false,
          data: {
          
            folio: folio,
            iditem: iditem,
            clave: clave,
            concepto: concepto,
            cantidad: cantidad,
            unidad: unidad,
            precio: precio, 
            desc: desc,
            importe: importe,
            gimporte: gimporte,
            opcion: opcion,
            usuario: usuario
          },
          success: function (data) {
            id_reg = data[0].id_reg //id_reg
            clave = data[0].clave
            concepto = data[0].concepto
            cantidad = data[0].cantidad
            unidad = data[0].unidad
            precio = data[0].precio
            gimporte = data[0].gimporte
  
            tablaDetIndes.row.add([id_reg, clave, concepto, cantidad, unidad, precio, gimporte]).draw()
            tipo = 4
            $.ajax({
              url: 'bd/sumadetalle.php',
              type: 'POST',
              dataType: 'json',
              async: false,
              data: { folio: folio },
              success: function (data) {
                total = data
  
                var myNumeral = numeral(total)
                var valor = myNumeral.format('0,0.00')
                
                $('#total').val(valor)
              },
            })
            limpiardes()
          },
        })
      } else {
        Swal.fire({
          title: 'Datos Faltantes',
          text: 'Debe ingresar todos los datos del Item',
          icon: 'warning',
        })
        return false
      }
    })
  
    function limpiar() {
      var today = new Date()
      var dd = today.getDate()
  
      var mm = today.getMonth() + 1
      var yyyy = today.getFullYear()
      if (dd < 10) {
        dd = '0' + dd
      }
  
      if (mm < 10) {
        mm = '0' + mm
      }
  
      today = yyyy + '-' + mm + '-' + dd
  
      $('#id_prov').val('')
      $('#nombre').val('')
      $('#fecha').val(today)
      $('#folio').val('')
      $('#folior').val('')
      $('#id_partida').val('')
      $('#partida').val('')
      $('#ccredito').val(false)
      $('#fechal').val(today)
      $('#cfactura').val(false)
      $('#referencia').val('')
      $('#proyecto').val('')
      $('#subtotal').val('')
      $('#iva').val('')
      $('#total').val('')
      $('#cinverso').val(false)
    }
    //funcion limpiar campos de la seccion detalles del concepto 
    function limpiardes() {
      $('#idconcepto').val('')
      $('#nomconcepto').val('')
      $('#unidadm').val('')
      $('#cantidadconcepto').val('')
      $('#costou').val('')
      $('#desc').val('')
      $('#costou').prop('disabled', true)
      $('#cantidadconcepto').prop('disabled', true)
      $('#importe').val('')
      $('#subtotal').val('')
      
    }

    //funcion redondear decimales
    function round(value, decimals) {
      return Number(Math.round(value + 'e' + decimals) + 'e-' + decimals)
    }
  
    // BORRAR MATERIAL
    $(document).on('click', '.btnBorrar', function (e) {
      e.preventDefault()
      fila = $(this)
      folio = $('#folio').val()
      id = parseInt($(this).closest('tr').find('td:eq(0)').text())
      usuario = $('#nameuser').val()
  
      tipooperacion = 2
  
      $.ajax({
        type: 'POST',
        url: 'bd/detalleorden.php',
        dataType: 'json',
        data: { id: id, opcion: tipooperacion, folio: folio },
        success: function (data) {
          if (data == 1) {
            tablaDetIndes.row(fila.parents('tr')).remove().draw()
            tipo = 4
            $.ajax({
              url: 'bd/sumadetalle.php',
              type: 'POST',
              dataType: 'json',
              async: false,
              data: { folio: folio, tipo: tipo },
              success: function (data) {
                total = data
  
                var myNumeral = numeral(total)
                var valor = myNumeral.format('0,0.00')
              
                $('#total').val(valor)

              },
            })
          } else {
            mensajeerror()
          }
        },
      })
    })
  
    function mensajeerror() {
      swal.fire({
        title: 'Operacion No exitosa',
        icon: 'error',
        focusConfirm: true,
        confirmButtonText: 'Aceptar',
      })
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
  
  function addCommas(nStr) {
    nStr += ''
    x = nStr.split('.')
    x1 = x[0]
    x2 = x.length > 1 ? '.' + x[1] : ''
    var rgx = /(\d+)(\d{3})/
    while (rgx.test(x1)) {
      x1 = x1.replace(rgx, '$1' + ',' + '$2')
    }
    return x1 + x2
  }
  