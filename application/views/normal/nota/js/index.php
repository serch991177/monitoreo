<script>
  let now = new Date();
  let day = ("0" + now.getDate()).slice(-2);
  let month = ("0" + (now.getMonth() + 1)).slice(-2);

  $('#fecha_ini').pickadate({

    monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
    weekdaysFull: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
    weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
    labelMonthNext: 'Siguiente Mes',
    labelMonthPrev: 'Anterior Mes',
    labelMonthSelect: 'Seleccionar un Mes',
    labelYearSelect: 'Seleccionar un Año',
    selectYears: true,
    selectMonths: true,
    firstDay: 'Monday',
    today: 'Hoy',
    clear: 'Limpiar',
    close: 'Cerrar',
    selectYears: 60,
    formatSubmit: 'yyyy-mm-dd',
    min: new Date(2021, 04, 24),
    max: new Date(now.getFullYear(), month - 1, day)
  });

  $('#fecha_fin').pickadate({

    monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
    weekdaysFull: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
    weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
    labelMonthNext: 'Siguiente Mes',
    labelMonthPrev: 'Anterior Mes',
    labelMonthSelect: 'Seleccionar un Mes',
    labelYearSelect: 'Seleccionar un Año',
    selectYears: true,
    selectMonths: true,
    firstDay: 'Monday',
    today: 'Hoy',
    clear: 'Limpiar',
    close: 'Cerrar',
    selectYears: 60,
    formatSubmit: 'yyyy-mm-dd',
    min: new Date(2021, 04, 24),
    max: new Date(now.getFullYear(), month - 1, day)
  });

  $('.datepicker').on('change', function() {
    if ($(this).attr('id') === 'fecha_ini') {
      //alert($(this).val())
      $('#fecha_fin').pickadate('picker').set('min', $(this).val());
    }
    if ($(this).attr('id') === 'fecha_fin') {
      $('#fecha_ini').pickadate('picker').set('max', $(this).val());
    }
  });
  $(document).ready(function() {

    var table = $('#example').DataTable({
      lengthMenu: [
        [10, 20, 50, 100, 1000, 10000],
        ['10', '20', '50', '100', '1000', '10000']
      ],
      "lengthChange": false,
      "responsive": true,
      "processing": true,
      "serverSide": true,
      "paging": true,
      //colReorder: true,
      "searching": true,
      "language": {

        "sProcessing": '<p style="color: #012d02;">Cargando. Por favor espere...</p>',
        //"sProcessing": '<img src="https://media.giphy.com/media/3o7bu3XilJ5BOiSGic/giphy.gif" alt="Funny image">',
        "sLengthMenu": "Mostrar _MENU_ registros",
        "sZeroRecords": "No se encontraron resultados",
        "sEmptyTable": "Ningún dato disponible en esta tabla",
        "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty": "",
        "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix": "",
        "sSearch": 'Buscar Datos:',
        "sUrl": "",
        "sInfoThousands": ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
          "sFirst": 'Primero',
          "sLast": "Último",
          "sNext": "Siguiente",
          "sPrevious": "Anterior"
        },
        "oAria": {
          "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
          "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        },
        "buttons": {
          "copy": "Copiar",
          "colvis": "Visibilidad"
        }
      },
      "bDestroy": false,
      "bJQueryUI": true,
      //datos
      "ajax": {
        "url": "<?php echo site_url('normal/nota/index'); ?>",
        //"type": "POST"
        //sirve para enviar variables en la peticion http
        data: function(d) {
          //console.log(d);
          //d.myKey = "myValue";
          d.search_custom = d.search.value; //usar variables para filtros.
          d.filter_estado = $('#estado').val();
          d.filter_fechaini = document.getElementsByName("fecha_ini_submit")[0].value;
          d.filter_fechafin = document.getElementsByName("fecha_fin_submit")[0].value;
        }
      },

      "columns": [{
          sortable: false,
          "render": function(data, type, row, meta) {
            var value = meta.row + meta.settings._iDisplayStart + 1; //contador de numeros.
            return value.toString();
          }

        },
        {
          data: 'nombre_dependencia'
        },
        {
          data: 'tema'
        },
        /*{
          data: 'nombre_area'
        },*/


        {
          data: 'fecha_registro_format'
        },
        {
          data: 'lista_medios'
        },
        /*{
            className: 'dt-body-center',
            sortable: false,
            render: function(data, type, row, meta) {

                var content = '';
                if (row.id_estado == 1) {
                    content += '<span id="span' + row.id_nota+ '" class="label success">HABILITADO</span>';
                } else {
                    content += '<span id="span' + row.id_nota + '" class="label alert">DESHABILITADO</span>';
                }

                return content;
            }
        },*/
        {
          className: 'dt-body-center',

          sortable: false,
          render: function(data, type, row, meta) {

            var button = '';

            var click = "modNota(" + row.id_nota + ")";
            button += '&nbsp<button title="Modificar Nota" data-tooltip="Modificar Nota" class="list-bt palette-Defecto bg button" onclick="' + click + '" data-open="modalModNota"><i class="las la-edit la-2x"></i></button>';

            if (row.id_estado == 1) {
              var click = "medioNota(" + row.id_nota + ")";
              button += '&nbsp<button title="Añadir Medios a Nota" data-tooltip="Añadir Medios a Nota" class="list-bt palette-Defecto bg button" onclick="' + click + '" data-open="modalMedio"><i class="las la-images la-2x"></i></button>';

              var click = "subirNota(" + row.id_nota + ")";
              button += '&nbsp<button title="Subir Archivo" data-tooltip="Subir Archivo" class="list-bt palette-Defecto bg button" onclick="' + click + '" data-open="modalArchivo"><i class="las la-file-upload la-2x"></i></button>';
            }
            //var url = "cambiarEstado(" + row.id_nota + ")";
            //button += '<button title="Cambiar de Estado" class="list-bt palette-Defecto bg button" onclick="' + url + '" type="button" value="' + row.id_nota + '">';
            //button += '<i class="las la-exchange-alt la-2x"></i>';
            //button += '</button>';

            return button;
          },
          width: "20%"
        }
      ],
      dom: 'Bfrtip',
      buttons: ['pageLength', {
          extend: 'excelHtml5',
          titleAttr: 'Se exportará el reporte según a la cantidad de filas.',
          autoFilter: true,
          title: 'Reporte de Notas Registradas',
          text: 'EXPORTAR EXCEL',
          //message: "Any message for header inside the file. I am not able to put message in next row in excel file but you can use \n",
          customize: function(xlsx) {}
        },
        // export funtion pdf
        {
          extend: 'pdfHtml5',
          titleAttr: 'Exportar el reporte a PDF',
          text: 'EXPORTAR PDF',
          title: 'REPORTE DE NOTAS REGISTRADAS',
          alignment: 'center',
          orientation: 'portrait',
          customize: function(doc) {

            doc.content.splice(0, 0, {
              margin: [0, 0, 0, -25],
              alignment: 'left',
              image: '',
              width: 200,
            });
            doc.styles.tableHeader.fillColor = '#CEF6F5';
            doc.styles.tableHeader.color = '#0B4C5F';
            doc.defaultStyle.fillColor = '#EFF5FB';
            doc.defaultStyle.fontSize = 7;
            doc.defaultStyle.alignment = 'center';
            doc.styles.tableHeader.fontSize = 7;
            doc.content.splice(0, 1);
            var now = new Date();
            var jsDate = now.getDate() + '-' + (now.getMonth() + 1) + '-' + now.getFullYear();

            doc['footer'] = (function(page, pages) {
              return {
                columns: [{
                    alignment: 'left',
                    text: ['Generado el: ', {
                      text: jsDate.toString()
                    }]
                  },
                  {
                    alignment: 'right',
                    text: ['Pagina ', {
                      text: page.toString()
                    }, ' de ', {
                      text: pages.toString()
                    }]
                  }
                ],
                margin: 20
              }
            });

          }
        },
        {
          extend: 'copyHtml5',
          text: 'COPIAR',
          titleAttr: 'Copiar en el portapapeles'
        },
      ]
    });
    $('#fecha_ini').on('change', function() {
      table.columns(0).search(this.value).draw();
    });

    $('#fecha_fin').on('change', function() {
      table.columns(0).search(this.value).draw();
    });
    //listado de temas
    /* select2 temas**/
    $('.tema').select2({
      placeholder: '--- Seleccionar Un Tema---',
      ajax: {
        url: "<?= site_url('search-tema') ?>",
        dataType: 'json',
        delay: 10,
        processResults: function(data) {
          return {
            results: data
          };
        },
        cache: true
      }
    });
    $('.selected_area').select2({
      placeholder: '--- Seleccionar Area---',

      ajax: {
        url: "<?= site_url('search-area') ?>",
        dataType: 'json',
        delay: 10,
        processResults: function(data) {
          return {

            results: data
          };
        },
        cache: true
      }
    });
    $('.dependencia').select2({
      placeholder: '--- Seleccionar Una Dependencia ---',

      ajax: {
        url: "<?= site_url('search-dependecia') ?>",
        dataType: 'json',
        delay: 10,
        processResults: function(data) {
          return {

            results: data
          };
        },
        cache: true
      }
    });

  });
  tinymce.init({
    selector: 'textarea.basicEditor',
    language: "es",
    height: 245,
    menubar: false,
    resize: false,
    plugins: ['advlist lists image charmap print preview anchor',
      'searchreplace visualblocks code fullscreen',
      'insertdatetime media table paste code wordcount'
    ],
    toolbar: 'undo redo | formatselect | ' +
      'bold italic | alignleft aligncenter ' +
      'alignright alignjustify | bullist numlist outdent indent | ' +
      'removeformat',
    content_style: 'body { font-family:Poppins,sans-serif; font-size:13px }',
    setup: function(editor) {
      editor.on('change', function() {
        tinymce.triggerSave();
        validarEditor(0,this);
      });
    }
  });

  function hoy() {
    var f = new Date();
    var hoy = f.getFullYear() + "-" + (f.getMonth() + 1) + "-" + f.getDate();
    hoy = hoy + ' 00:00:00';
    return hoy;
  }

  function cambiarEstado(elemento) {
    url = "<?= site_url('cambiar-estado') ?>";
    //alert(elemento);
    var data = new FormData();
    data.append('id_elemento', elemento);
    data.append('tabla', 'nota');
    $.ajax({
      url: url,
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      type: 'POST',
      success: (response) => {
        var nombre = "span" + elemento;
        res = response.response;
        if (res == 1) {
          document.getElementById(nombre).className = "label success";
          document.getElementById(nombre).innerHTML = "";
          document.getElementById(nombre).innerHTML = "HABILITADO";
        } else {
          document.getElementById(nombre).className = "label alert";
          document.getElementById(nombre).innerHTML = "";
          document.getElementById(nombre).innerHTML = "DESHABILITADO";
        }
      },
      error: function(xhr, status, error) {
        alert(xhr.responseText);
      }
    });
  }

  function nuevaNota() {
    document.getElementById("titulo-modal").innerHTML = "Agregar Nueva Nota";
    document.getElementById("btn_reg_nota").innerHTML = "Registrar Nota";
    document.getElementById("id_nota").value = "";

  }

  function subirNota(identificador) {
    document.getElementById("titulo-modal").innerHTML = "Subir Archivo Nota"
    document.getElementById("btn_subir_nota").innerHTML = "Subir Archivo Nota";

    document.getElementById("id_n").value = identificador;
  }
  $(function() {
    $('#archivo').change(function(e) {
      addImage(e, '#file_img');
      document.getElementById('file_img').style.display = 'inline';
    });

    function addImage(e, src) {
      var file = e.target.files[0],
        imageType = /image.*/;

      var reader = new FileReader();

      reader.onload = function(e) {
        var result;
        if (!file.type.match(imageType)) {
          result = "public/images/default.jpg"
          $(src).attr("src", result);
          $(src).width('20%');
          $(src).height('20%');
        } else {
          result = e.target.result;
          $(src).width('40%');
          $(src).height('40%');
        }

        $(src).attr("src", result);
      }

      reader.readAsDataURL(file);
    }
  });

  function subirNota(elemento) {

    $('#ver_archiv').empty();
    var id = elemento;
    $.getJSON('<?php echo site_url('normal/nota/getArchivo'); ?>', {
        id: id
      })
      .done(function(data) {
        $("#id_n").val(id);
        $('#ver_archivo').empty();
        //alert(data.adjunto);

        //$('#ver_archivo').attr('href',''data.adjunto);
        if (data.adjunto != null) {
          $('#ver_archivo').append('<a href="<?php echo site_url() ?>public/archivos/' + data.adjunto + '" title="' + data.adjunto + '" target="_blank">' + data.adjunto + '</a><br>');
        }

      });
  }

  function modNota(identificador) {
    document.getElementById("titulo-modal").innerHTML = "Modificar Nota";
    document.getElementById("btn_reg_nota").innerHTML = "Modificar Nota";
    document.getElementById("id_nota_mod").value = identificador;
    var id = identificador;
    //alert(id);
    $.getJSON('<?php echo site_url('normal/nota/getNota'); ?>', {
        id: id
      })
      .done(function(data) {
        document.getElementById("dependencia_mod").value = data.id_dependencia;
        $("#selected_tema_mod").append('<option selected="$selected" value="' + data.id_tema + '">' + data.tema + '</option>');
        document.getElementById("id_nota_mod").value = data.id_nota;
        //document.getElementById("area_mod").value = data.id_area;
        document.getElementById("estado").value = data.id_estado;

        var html2 = decodeHtml(data.detalle);
        tinymce.get("detalle_mod").setContent(html2);

      });

  }

  function modMedio(identificador) {
    document.getElementById("titulo-modal").innerHTML = "Modificar Medio";
    document.getElementById("btn_mod_medio").innerHTML = "Modificar Medio";
    document.getElementById("id_detalle_medio").value = identificador;
    var id = identificador;
    //alert(id);
    $.getJSON('<?php echo site_url('normal/nota/getMedio'); ?>', {
        id: id
      })
      .done(function(data) {
        document.getElementById("medio_mod").value = data.id_recurso;
        document.getElementById("tendencia_mod").value = data.id_tendencia;
        document.getElementById("tipo_noticia_mod").value = data.id_tipo_noticia;
        document.getElementById("turno_mod").value = data.id_turno;

        document.getElementById("id_detalle_medio").value = data.id_detalle_medio;
        //document.getElementById("area_mod").value = data.id_area;
        //document.getElementById("estado").value = data.id_estado;
        var html2 = decodeHtml(data.detalle);
        tinymce.get("detalle_med").setContent(html2);
        var html2 = decodeHtml(data.acciones);
        tinymce.get("acciones").setContent(html2);

      });

  }

  function medioNota(identificador) {

    document.getElementById("titulo-modal").innerHTML = "Añadir Medios"
    document.getElementById("btn_med_nota").innerHTML = "Añadir Medios";

    document.getElementById("id_nota_medio").value = "";

    document.getElementById("medio").value = "";
    document.getElementById("turno").value = "";
    document.getElementById("tendencia").value = "";
    document.getElementById("tipo_noticia").value = "";

    tinymce.get("detalle").setContent("");
    tinymce.get("acciones").setContent("");

    var id = identificador;
    //alert(id);
    var num = 1;
    document.getElementById("id_nota_med").value = id;
    $.getJSON('<?php echo site_url('normal/nota/getDetalleMedio'); ?>', {
        id: id
      })
      .done(function(data) {
        //alert(data[0]['nombre']);

        $('#listmedios').empty();
        for (var i = 0; i < data.length; i++) {

          var click = "modMedio(" + data[i]["id_detalle_medio"] + ")";
          $('#listmedios').append('<tr><td>' + num + '</td><td>' + data[i]["nombre"] + '</td><td>' + data[i]["nombre_tendencia"] + '</td><td>' + data[i]["tipo_noticia"] + '</td><td>' + data[i]["turno"] + '</td><td>' + decodeHtml(data[i]["detalle"]) + '</td><td>' + decodeHtml(data[i]["acciones"]) + '</td><td><button title="Modificar Medio" data-tooltip="Modificar Medio" class="list-bt palette-Defecto bg button" onclick="' + click + '" data-open="modalModMedio"><i class="las la-edit la-2x"></i></button></td</tr>');
          num++;


        }

      });
  }

  function selecdep() {

    var sel_dep = document.getElementById("selected_dependencia").value;

    if (sel_dep != 0) {
      document.getElementById("nueva_dep").style.display = 'none';
    } else {
      document.getElementById("nueva_dep").style.display = 'block';
    }
  }

  function selecttema() {

    var sel_tem = document.getElementById("selected_tema").value;

    if (sel_tem != 0) {
      document.getElementById("new_tema").style.display = 'none';
    } else {
      document.getElementById("new_tema").style.display = 'block';
    }
  }

  function validarForm() {

    var bandera = true;

    var sel_dep = document.getElementById("selected_dependencia").value;
    var dep = document.getElementById("dependencia_nueva").value;

    var sel_tem = document.getElementById("selected_tema").value;
    var tem = document.getElementById("tema_nue").value;


    if ((sel_dep != 0 || dep != '') && (sel_tem != 0 || tem != '')) {

      bandera = true;

    } else {
      if (sel_dep != 0 || dep != '') {
        generarError("tema_nue");
      } else {
        if (sel_tem != 0 || tem != '') {
          generarError("dependencia_nueva");
        } else {
          generarError("tema_nue");
          generarError("dependencia_nueva");
        }

      }

      bandera = false;
    }

    if(!validarEditor(1,"detalle"))
    {

      bandera = false;
    }

    var req = document.getElementsByClassName('req');

		for (let index = 0; index < req.length; index++) {
			
			if(req[index].value == '')
			{
        req[index].style.borderColor = 'red';
				bandera = false;
			}
			
		}    

    return bandera;
  }

  function limpiar(cadena) {

    switch (cadena) {
      case "tema":
        $("#selected_tema").select2("val", 0);
        break;
      case "dependencia":
        $("#selected_dependencia").select2("val", 0);
        break;
      default:
        break;
    }

  }

  function generarError(etiqueta) {
    document.getElementById(etiqueta).classList.add('is-invalid-input');
    $('label[for="' + etiqueta + '"]').addClass('is-invalid-label');
    $('span[data-form-error-for="' + etiqueta + '"]').addClass('is-visible');

  }

  function limpiarError(etiqueta) {
    document.getElementById(etiqueta).className = "input-group-field";
    $('label[for="' + etiqueta + '"]').removeClass('is-invalid-label');
    $('span[data-form-error-for="' + etiqueta + '"]').removeClass('is-visible');
  }

  function decodeHtml(html) {
    var txt = document.createElement('textarea');
    txt.innerHTML = html;
    return txt.value;
  }

  function validarEditor(cad, elemento) {

    if(cad == 1)
    {
      var cadena = elemento;
    }
    else{
      var cadena = elemento.targetElm.id;
    }  


    var myContent = tinymce.get(cadena).getContent();

    if (myContent == '') {
      document.getElementById(cadena+"_ifr").style.backgroundColor = '#f9ecea';
      document.getElementById(cadena+"_ifr").style.borderTop = '2px solid red';
      document.getElementById(cadena+"_ifr").style.borderBottom = '2px solid red';
      document.getElementById(cadena+"_ifr").style.borderRight = '2px solid red';
      document.getElementById(cadena+"_ifr").style.borderLeft = '2px solid red';
      $('span[data-form-error-for="'+cadena + '"]').addClass('is-visible');
      return false;
    } else {
      document.getElementById(cadena+"_ifr").style.backgroundColor = "#FFFFFF";
      document.getElementById(cadena+"_ifr").style.borderTop = '0px';
      document.getElementById(cadena+"_ifr").style.borderBottom = '0px';
      document.getElementById(cadena+"_ifr").style.borderRight = '0px';
      document.getElementById(cadena+"_ifr").style.borderLeft = '0px';
      $('span[data-form-error-for="'+cadena + '"]').removeClass('is-visible');
      return true;
    }
  }
  var i = 1;
  $('#add').click(function() {
    i++;

    var arreglo = <?php echo json_encode($medios) ?>;
    var html = armarCombo(arreglo, i);

    var arreglo1 = <?php echo json_encode($tendencias) ?>;
    var html1 = armarCombo1(arreglo1, i);

    var arreglo2 = <?php echo json_encode($tipo_noticias) ?>;
    var html2 = armarCombo2(arreglo2, i);

    var arreglo3 = <?php echo json_encode($turnos) ?>;
    var html3 = armarCombo3(arreglo3, i);

    $('#dynamic_field').append('<tr id="row' + i + '"><td>' + html + '</td><td>' + html1 + '</td><td>' + html2 + '</td><td>' + html3 + '</td><td><input id="detalle_reg' + i + '" type="text" name="detalle_reg[' + i + ']"  /></td><td><input id="acciones_reg' + i + '" type="text" name="acciones_reg[' + i + ']"  /></td><td><button type="button" name="remove" id="' + i + '" class="btn bg palette-Red btn_remove"><i class="las la-minus-circle la-2x"></i></button></td></tr>');

  });
  /*  */

  function armarCombo(arreglo, i) {
    var html = '<select  name="medio[' + i + ']" class="input-group-field req" onchange="validar_blanco(this)">';
    var k = 0;
    Object.entries(arreglo).forEach(([key, value]) => {
      if (key == "")
        html += '<option value="' + `${key}` + '" selected="selected">' + `${value}` + '</option>';
      else
        html += '<option value="' + `${key}` + '">' + `${value}` + '</option>';
      k++;
    });

    html += "</select>";

    return html;
  }

  function armarCombo1(arreglo1, i) {
    var html1 = '<select  name="tendencia[' + i + ']" class="input-group-field req" onchange="validar_blanco(this)">';
    var k = 0;
    Object.entries(arreglo1).forEach(([key, value]) => {
      if (key == "")
        html1 += '<option value="' + `${key}` + '" selected="selected">' + `${value}` + '</option>';
      else
        html1 += '<option value="' + `${key}` + '">' + `${value}` + '</option>';
      k++;
    });

    html1 += "</select>";

    return html1;
  }

  function armarCombo2(arreglo2, i) {
    var html2 = '<select  name="tipo_noticia[' + i + ']" class="input-group-field req" onchange="validar_blanco(this)">';
    var k = 0;
    Object.entries(arreglo2).forEach(([key, value]) => {
      if (key == "")
        html2 += '<option value="' + `${key}` + '" selected="selected">' + `${value}` + '</option>';
      else
        html2 += '<option value="' + `${key}` + '">' + `${value}` + '</option>';
      k++;
    });

       html2 += "</select>";

    return html2;
  }

  function armarCombo3(arreglo3, i) {
    var html3 = '<select  name="turno[' + i + ']" class="input-group-field req" onchange="validar_blanco(this)">';
    var k = 0;
    Object.entries(arreglo3).forEach(([key, value]) => {
      if (key == "")
        html3 += '<option value="' + `${key}` + '" selected="selected">' + `${value}` + '</option>';
      else
        html3 += '<option value="' + `${key}` + '">' + `${value}` + '</option>';
      k++;
    });

    html3 += "</select>";

    return html3;
  }
  $(document).on('click', '.btn_remove', function() {
    var button_id = $(this).attr("id");
    $('#row' + button_id + '').remove();

  });

  function validar_blanco(elemento)
  {
    if(elemento.value == "")
    {
      elemento.style.borderColor = 'red';
    }
    else{
      elemento.style.borderColor = '#FFFFFF';
    }
  }
</script>

<script>


  var i = 1;

  
  function miFuncion() {

    var allEditors = document.querySelectorAll('.editable');

    var cant = Object.keys(editor).length;

    var k = 0;

    for (var i = 1; i < cant; ++i) {


      if (i != eliminados[k]) {
        editor[i].updateSourceElement();
      } else {
        k++;
      }
    }
  }

  let eliminados = [];

  $(document).on('click', '.btn_remove', function() {
    var button_id = $(this).attr("id");
    $('#row' + button_id + '').remove();
    eliminados.push(button_id);
  });
</script>