$(document).ready(function () {
  $('[data-toggle="tooltip"]').tooltip()

  var id, opcion
  var operacion = $('#opcion').val()

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

  tablaC = $('#tablaC').DataTable({
    columnDefs: [
      {
        targets: -1,
        data: null,
        defaultContent:
          "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-success btnSelCliente'><i class='fas fa-hand-pointer'></i></button></div></div>",
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

  tablaCon = $('#tablaCon').DataTable({
    columnDefs: [
      {
        targets: -1,
        data: null,
        defaultContent:
          "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-success btnSelConcepto'><i class='fas fa-hand-pointer'></i></button></div></div>",
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

  //TABLA DESECHABLE
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

  $(document).on('click', '#bproveedor', function () {
    $('.modal-header').css('background-color', '#007bff')
    $('.modal-header').css('color', 'white')

    $('#modalProspecto').modal('show')
  })

  $(document).on('click', '#bproveedorplus', function () {
    window.location.href = 'cntaproveedor.php'
  })

  $(document).on('click', '#bproyectoplus', function () {
    window.location.href = 'cntaproyecto.php'
  })

  $(document).on('click', '#bproyecto', function () {
    $('.modal-header').css('background-color', '#007bff')
    $('.modal-header').css('color', 'white')

    $('#modalProyecto').modal('show')

    $('#claveconcepto').val('')
    $('#concepto').val('')
    $('#id_umedida').val('')
    $('#usomat').val('')
    $('#nom_umedida').val('')
    $('#bmaterial').prop('disabled', true)
    $('#clavemat').val('')
    $('#material').val('')
    $('#clave').val('')
    $('#idprecio').val('')
    $('#unidad').val('')

    $('#precio').val('')
    $('#cantidad').val('')
    $('#cantidad').prop('disabled', true)
  })

  $(document).on('click', '.btnSelCliente', function () {
    fila = $(this).closest('tr')

    idprov = fila.find('td:eq(0)').text()
    nomprov = fila.find('td:eq(2)').text()

    opcion = 1

    $('#id_prov').val(idprov)
    $('#nombre').val(nomprov)
    $('#modalProspecto').modal('hide')
  })

  $(document).on('click', '#btnGuardar', function () {
    folio = $('#folio').val()
    fecha = $('#fecha').val()

    id_prov = $('#id_prov').val()
    proveedor = $('#nombre').val()
    id_proy = $('#id_proy').val()
    proyecto = $('#proyecto').val()
    concepto = $('#concepto').val()

    total = $('#total').val().replace(/,/g, '')
    tokenid = $('#tokenid').val()
    opcion = $('#opcion').val()

    if (
      total.length != 0 &&
      concepto.length != 0 &&
      id_prov.length != 0 &&
      id_proy.length != 0
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
          id_proy: id_proy,
          proyecto: proyecto,
          concepto: concepto,
          total: total,
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
              window.location.href = 'cntaordencompra.php'
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

  $(document).on('click', '.btnSelConcepto', function () {
    fila = $(this).closest('tr')
    idpartida = fila.find('td:eq(0)').text()
    partida = fila.find('td:eq(2)').text()
    $('#id_proy').val(idpartida)
    $('#proyecto').val(partida)
    $('#modalProyecto').modal('hide')
  })

  //BOTON BUSCAR DESECHABLE
  $(document).on('click', '#btnInsumodes', function () {
    $('#modalDes').modal('show')
  })

  // SELECCIONAR  DESECHABLE
  $(document).on('click', '.btnSelDesechable', function () {
    fila = $(this).closest('tr')
    idconcepto = fila.find('td:eq(0)').text()
    clave = fila.find('td:eq(1)').text()
    concepto = fila.find('td:eq(2)').text()
    unidad = fila.find('td:eq(3)').text()

    /*
     */
    $('#idconcepto').val(idconcepto)
    $('#unidadm').val(unidad)
    $('#nomconcepto').val(concepto)
    $('#claveconcepto').val(clave)
    $('#costou').prop('disabled', false)
    $('#cantidadconcepto').prop('disabled', false)

    $('#modalDes').modal('hide')
  })

  //BOTON LIMPIAR DESECHABLE
  $(document).on('click', '#btlimpiarides', function () {
    limpiardes()
  })

  //AGREGAR DESECHABLE
  $(document).on('click', '#btnagregarides', function () {
    folio = $('#folio').val()
    idcon = $('#idconcepto').val()
    cantidad = $('#cantidadconcepto').val().replace(/,/g, '')
    concepto = $('#nomconcepto').val()
    unidad = $('#unidadm').val()
    costo = $('#costou').val().replace(/,/g, '')
    clave = $('#claveconcepto').val()
    subtotal = parseFloat(costo) * parseFloat(cantidad)
    usuario = $('#nameuser').val()
    opcion = 1

    if (
      folio.length != 0 &&
      idcon.length != 0 &&
      cantidad.length != 0 &&
      costo.length != 0
    ) {
      $.ajax({
        type: 'POST',
        url: 'bd/detalleorden.php',
        dataType: 'json',
        //async: false,
        data: {
          folio: folio,
          idcon: idcon,
          cantidad: cantidad,
          concepto: concepto,
          opcion: opcion,
          usuario: usuario,
          subtotal,
          subtotal,
          unidad: unidad,
          clave: clave,
          costo: costo,
        },
        success: function (data) {
          id_reg = data[0].id_reg
          clave = data[0].clave
          concepto = data[0].concepto
          cantidad = data[0].cantidad
          unidad = data[0].unidad
          precio = data[0].precio
          subtotal = data[0].monto

          tablaDetIndes.row
            .add([id_reg, clave, concepto, cantidad, unidad, precio, subtotal])
            .draw()
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

  function limpiardes() {
    $('#idconcepto').val('')
    $('#nomconcepto').val('')
    $('#claveconcepto').val('')
    $('#cantidadconcepto').val('')
    $('#costou').val('')
    $('#costou').prop('disabled', true)
    $('#cantidadconcepto').prop('disabled', true)
  }

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
