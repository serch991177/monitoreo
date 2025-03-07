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
            "bDestroy": true,
            "bJQueryUI": true,
            //datos
            "ajax": {
                "url": "<?php echo site_url('normal/reporte/index'); ?>",
                //"type": "POST"
                //sirve para enviar variables en la peticion http
                data: function(d) {
                    //console.log(d);
                    //d.myKey = "myValue";
                    d.search_custom = d.search.value; //usar variables para filtros.
                    d.filter_estado = $('#estado').val();
                    d.filter_prioridad = $('#select_dependencia').val();
                    d.filter_funcionario = $('#select_area').val();
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
                    data: 'fecha_registro_format'
                },
                {
                    data: 'tema'
                },
                /*{
                    sortable: false,
                    render: function(data, type, row, meta) {

                        var content = '';

                        resp = decodeHtml(row.tema);

                        content += resp;

                        return content;
                    }
                },*/
                {
                    data: 'nombre_area'
                },
              
                {
                    className: 'dt-body-center',
                    sortable: false,
                    render: function(data, type, row, meta) {

                        var content = '';

                        if (row.id_estado == 1) {
                            content += '<span id="span' + row.id_nota + '" class="label success">HABILITADO</span>';
                        } else {
                            content += '<span id="span' + row.id_nota + '" class="label alert">DESHABILITADO</span>';
                        }

                        return content;
                    }
                },
                {
                    className: 'dt-body-center',
                    sortable: false,
                    render: function(data, type, row, meta) {

                        var button = '';

                        var click = "verNota(" + row.id_nota + ");";
                        button += '&nbsp<button title="Ver Nota" data-tooltip="Ver Nota" class="list-bt palette-Defecto bg button" onclick="' + click + '" data-open="modalNota"><i class="las la-eye la-2x"></i></button>';

                        return button;
                    }
                }
            ],
            dom: 'Bfrtip',
            buttons: ['pageLength', {
                    extend: 'excelHtml5',
                    titleAttr: 'Se exportará el reporte según a la cantidad de filas.',
                    autoFilter: true,
                    title: 'Reporte de Estructuras Registradas',
                    text: 'EXPORTAR EXCEL',
                    //message: "Any message for header inside the file. I am not able to put message in next row in excel file but you can use \n",
                    customize: function(xlsx) {}
                },
                // export funtion pdf
                {
                    extend: 'pdfHtml5',
                    titleAttr: 'Exportar el resporte a PDF',
                    text: 'EXPORTAR PDF',
                    title: 'REPORTE DE ESTRUCTURAS REGISTRADAS',
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
                validarEditor();
            });
        }
    });

    function verNota(identificador) {
      //alert(identificador);
      document.getElementById("titulo-modal").innerHTML = "Ver Nota";
      $('#ver_archivo_reporte').empty();

      var id=identificador;
      $.getJSON('<?php echo site_url('normal/nota/getNota');?>', { id: id })
      .done(function(data) {
        $("#id_not").val(id);
        $('#dependencia').val(data.nombre_dependencia);

        var html = decodeHtml(data.tema);
        $('#tema').val(html);

        $('#nombre_area').val(data.nombre_area);
        $('#nombre_medio').val(data.nombre);
        $('#nombre_tendencia').val(data.nombre_tendencia);
        $('#tip_noticia').val(data.tipo_noticia);
        $('#ver_obs').val(data.observacion);
        $('#ver_estado').val(data.descripcion);
        if(data.adjunto != null){
          $('#ver_archivo_reporte').append('<a href="<?php echo site_url()?>public/archivos/'+data.adjunto+'" title="'+data.adjunto+'" target="_blank">'+data.adjunto+'</a><br>');
        }
      });
    }

    function validarForm() {

        return true;

    }

    function decodeHtml(html) {
        var txt = document.createElement('textarea');
        txt.innerHTML = html;
        return txt.value;
    }

</script>
