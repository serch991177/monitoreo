<script>
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
                "url": "<?php echo site_url('dashboard/dashboard/index'); ?>",
                //"type": "POST"
                //sirve para enviar variables en la peticion http
                data: function(d) {
                    //console.log(d);
                    //d.myKey = "myValue";
                    d.search_custom = d.search.value; //usar variables para filtros.
                    d.filter_ini = document.getElementsByName("fecha_ini_submit")[0].value;
                    d.filter_fin = document.getElementsByName("fecha_fin_submit")[0].value;
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
                    sortable: true,
                    data: 'tema'

                },
                {
                    sortable: true,
                    className: 'dt-body-center',
                    data: 'canti_notas'
                },
                {
                    sortable: true,
                    className: 'dt-body-center',
                    data: 'positivos'
                },
                {
                    sortable: true,
                    className: 'dt-body-center',
                    data: 'negativos'
                },
                {
                    className: 'dt-body-center',
                    sortable: true,
                    data: 'neutros'
                },

                {
                    className: 'dt-body-center',
                    sortable: false,
                    render: function(data, type, row, meta) {

                        var urlfi = '<?= site_url() ?>' + 'print-notas';
                        var urlfp = '<?= site_url() ?>' + 'print-posis';
                        var urlfn = '<?= site_url() ?>' + 'print-negas';

                        var title = "Imprimir Notas";

                        var button = '';

                        var clickest = "obtenerNotas(" + row.id_tema + ");";
                        button += '&nbsp<button title="Ver Notas" data-tooltip="Ver Notas" class="list-bt palette-Defecto bg button" data-open="modalNotas" onclick="' + clickest + '"><i class="las la-eye"></i></button>';

                        button += '&nbsp<form style="display: inline;" onsubmit="return printNotas('+ row.id_tema + ');" action="' + urlfi + '" method="post" id="form' + row.id_tema + '">';
                        button += '<input type="hidden" name="id_tema" value="' + row.id_tema + '">';
                        button += '<input type="hidden" name="f_ini" id="f_ini' + row.id_tema + '">';
                        button += '<input type="hidden" name="f_fin" id="f_fin' + row.id_tema + '">';
                        button += '<button type="submit" name="btn' + row.id_tema + '" title="' + title + '" data-tooltip="' + title + '" class="list-bt palette-Defecto bg button" form="form' + row.id_tema + '">';
                        button += '<i class="las la-print"></i></button>';
                        button += '</form>';

                        button += '&nbsp<form style="display: inline;" onsubmit="return printNotas('+ row.id_tema + ');" action="' + urlfp + '" method="post" id="formp' + row.id_tema + '">';
                        button += '<input type="hidden" name="id_tema" value="' + row.id_tema + '">';
                        button += '<input type="hidden" name="f_ini" id="f_ini' + row.id_tema + '">';
                        button += '<input type="hidden" name="f_fin" id="f_fin' + row.id_tema + '">';
                        button += '<button type="submit" name="btn' + row.id_tema + '" title="' + title + '" data-tooltip="' + title + '" class="list-bt palette-Defecto bg button" form="formp' + row.id_tema + '">';
                        button += '<i class="las la-plus"></i></button>';
                        button += '</form>';

                        button += '&nbsp<form style="display: inline;" onsubmit="return printNotas('+ row.id_tema + ');" action="' + urlfn + '" method="post" id="formn' + row.id_tema + '">';
                        button += '<input type="hidden" name="id_tema" value="' + row.id_tema + '">';
                        button += '<input type="hidden" name="f_ini" id="f_ini' + row.id_tema + '">';
                        button += '<input type="hidden" name="f_fin" id="f_fin' + row.id_tema + '">';
                        button += '<button type="submit" name="btn' + row.id_tema + '" title="' + title + '" data-tooltip="' + title + '" class="list-bt palette-Defecto bg button" form="formn' + row.id_tema + '">';
                        button += '<i class="las la-minus"></i></button>';
                        button += '</form>';

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
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    },
                    titleAttr: 'Exportar el resporte a PDF',
                    text: 'EXPORTAR PDF',
                    title: 'REPORTE DE TEMAS REGISTRADOS',
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

        $('#fecha_ini').pickadate('picker').set('select', new Date(now.getFullYear(), month - 1, day));
    });

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
        min: new Date(2022, 01, 01),
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
        max: new Date(now.getFullYear(), month - 1, day)
    });

    $('#fecha_ini').on('change', function() {

        var valor = new Date(document.getElementsByName("fecha_ini_submit")[0].value);

        document.getElementById("fecha_fin").disable = false;

        var dia = ("0" + (valor.getDate() + 1)).slice(-2);
        var mes = ("0" + (valor.getMonth() + 1)).slice(-2);
        var anio = valor.getFullYear();
        nueva_fecha = new Date(valor.getFullYear(), mes - 1, dia);

        //$('#fecha_fin').pickadate('picker').set('select', nueva_fecha);
        $('#fecha_fin').pickadate('picker').set('min', nueva_fecha);

        nueva_fecha.setDate(nueva_fecha.getDate() + 6);

        var difference = new Date(now.getFullYear(), month - 1, day) - nueva_fecha;
        var days = difference / (1000 * 3600 * 24);

        if (days < 0) {
            $('#fecha_fin').pickadate('picker').set('max', new Date(now.getFullYear(), month - 1, day));
        } else {
            $('#fecha_fin').pickadate('picker').set('max', nueva_fecha);
        }
    });
    $('#fecha_fin').on('change', function() {

        var table = $('#example').DataTable();

        var valor = new Date(document.getElementsByName("fecha_fin_submit")[0].value);

        table
            .columns(6).search(document.getElementsByName("fecha_fin_submit")[0].value)
            .draw();
    });
    var tabla = $('#notas-table').dataTable({
        data: null,
        responsive: true,

        "lengthMenu": [
            [15, 30, 45, -1],
            [15, 30, 45, "Todo"]
        ],
        "pageLength": 15,

        "language": {
            "search": "Buscar",
            "lengthMenu": "Mostrar _MENU_",
            "zeroRecords": "No se encontró registro de contratos asociados al proyecto",
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(Filtrado de _MAX_ registros totales)",
            "previous": "Anterior",
            "oPaginate": {
                "sNext": "Siguiente",
                "sLast": "Último",
                "sPrevious": "Anterior",
                "sFirst": "Primero"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            },
        },

        columns: [{
                title: "Nº",
                className: 'text-center',
                width: "5%",
                render: function(data, type, full, meta) {
                    var value = meta.row + meta.settings._iDisplayStart + 1;
                    return value.toString();
                }
            },
            {
                title: "Medio",
                className: 'text-center',
                data: 'nombre',
                width: "15%",
            },
            {
                title: "Tendencia",
                className: 'text-center',
                data: 'nombre_tendencia',
                width: "10%",
            },
            {
                title: "Dependencia",
                className: 'text-center',
                data: 'nombre_dependencia',
                width: "10%",
            },
            {
                title: "Tipo Noticia",
                className: 'text-center',
                data: 'tipo_noticia',
                width: "5%",
            },
            {
                title: "Turno",
                className: 'text-center',
                data: 'turno',
                width: "5%",
            },
            {
                title: "Fecha",
                className: 'text-center',
                data: 'fecha_registro_nota',
                width: "10%",
            },
            {
                title: "Detalle",
                width: "40%",
                render: function(data, type, full, meta) {
                    return '<p>' + decodeHtml(full.detalle) + '</p>';
                }
            }
        ]
    });

    function obtenerNotas(id) {

        url = "<?php echo base_url() ?>obtener-notas";

        var data = new FormData();
        data.append('id_tema', id);
        data.append('fecha_ini', document.getElementsByName("fecha_ini_submit")[0].value);
        data.append('fecha_fin', document.getElementsByName("fecha_fin_submit")[0].value);

        $.ajax({
            url: url,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: (response) => {

                document.getElementById("titulo_tema").innerHTML = response.response.notas[0].tema;
                $('#notas-table').DataTable().clear();
                $('#notas-table').DataTable().rows.add(response.response.notas);
                $('#notas-table').DataTable().draw();


            },
            error: function(xhr, status, error) {
                alert(xhr.responseText);
            }
        });
    }

    function printNotas(id_tema){

        var name_ini = "f_ini" + id_tema;
        var name_fin = "f_fin" + id_tema;
        document.getElementById(name_ini).value = document.getElementsByName("fecha_ini_submit")[0].value;
        document.getElementById(name_fin).value = document.getElementsByName("fecha_fin_submit")[0].value;

        return true;
    }


    function decodeHtml(html) {
        var txt = document.createElement('textarea');
        txt.innerHTML = html;
        return txt.value;
    }
</script>