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
                "url": "<?php echo site_url('agenda/agenda/index'); ?>",
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
                    data: 'motivo_espacio'

                },
                {
                    sortable: true,
                    className: 'dt-body-center',
                    data: 'nombre_completo'
                },
                {
                    className: 'dt-body-center',
                    sortable: false,
                    render: function(data, type, row, meta) {


                        var button = '';

                        var clickest = "add_agenda(" + row.id_espacio + ");";
                        button += '<button title="Añadir Espacio" data-open="modalAdicion" data-tooltip="Abrir Proyecto" class="list-bt palette-Defecto bg button" id="est_ag' + row.id_espacio + '"onclick="' + clickest + '"><i class="las la-plus-circle la-2x"></i></button>';

                        clickest = "ver_agenda(" + row.id_espacio + ");";
                        button += '<button title="Ver Espacios" data-open="modalEspacios" data-tooltip="Ver Espacios" class="list-bt palette-Defecto bg button" id="esp' + row.id_espacio + '"onclick="' + clickest + '"><i class="las la-eye la-2x"></i></button>';

                        return button;
                    }
                }
            ],
            dom: 'Bfrtip',
            buttons: ['pageLength', {
                    extend: 'excelHtml5',
                    titleAttr: 'Se exportará el reporte según a la cantidad de filas.',
                    autoFilter: true,
                    title: 'Agenda de Medios',
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
                    title: 'AGENDA DE MEDIOS',
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
        $('#medio_add').select2();
        $('#interlocutor_add').select2();
        $('#hora').select2();
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
        min: new Date(2022, 05, 27)
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

    $('#fecha_add').pickadate({

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
        min: new Date(2022, 05, 27)
    });

    $('#fecha_new').pickadate({

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
        min: new Date(2022, 05, 27),
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

        $('#fecha_fin').pickadate('picker').set('max', nueva_fecha);

    });
    $('#fecha_fin').on('change', function() {

        var table = $('#example').DataTable();

        var valor = new Date(document.getElementsByName("fecha_fin_submit")[0].value);

        table
            .columns(6).search(document.getElementsByName("fecha_fin_submit")[0].value)
            .draw();
    });

    var tabla = $('#programas-table').dataTable({
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
            "zeroRecords": "No se encontró registro de programas",
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
                title: "Medio",
                className: 'text-center',
                data: 'nombre',
                width: "50%",
            },
            {
                title: "Programa",
                className: 'text-center',
                data: 'nombre_programa',
                width: "50%",
            },
            {
                title: "Acciones",
                className: 'text-center',
                data: null,
                render: function(data, type, full, meta) {
                    var button = '';

                    var click = "eliminarPrograma(" + data.id_programa + ");";
                    button += '&nbsp<button data-tooltip="Borrar Programa" title="Borrar Programa" class="list-bt palette-Defecto bg button" onclick="' + click + '"><i class="las la-trash-alt la-2x"></i></button>';

                    return button;
                },
                width: "10%"
            }
        ]
    });
    var tabla = $('#interlocutores-table').dataTable({
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
            "zeroRecords": "No se encontró registro de interlocutores",
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
                title: "Interlocutor",
                className: 'text-center',
                data: 'nombre_completo',
                width: "50%",
            },
            {
                title: "Cargo",
                className: 'text-center',
                data: 'cargo',
                width: "50%",
            },
            {
                title: "Acciones",
                className: 'text-center',
                data: null,
                render: function(data, type, full, meta) {
                    var button = '';

                    var click = "eliminarInterlocutor(" + data.id_interlocutor + ");";
                    button += '&nbsp<button data-tooltip="Borrar Interlocutor" title="Borrar Interlocutor" class="list-bt palette-Defecto bg button" onclick="' + click + '"><i class="las la-trash-alt la-2x"></i></button>';

                    return button;
                },
                width: "10%"
            }
        ]
    });
    var tabla = $('#spaces-table').dataTable({
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
            "zeroRecords": "No se encontró registro de programas",
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
                title: "Fecha",
                className: 'text-center',
                data: 'fecha_format',
                width: "20%",
            },
            {
                title: "Hora",
                className: 'text-center',
                data: 'hora_format',
                width: "10%",
            },
            {
                title: "Lugar",
                className: 'text-left',
                data: 'lugar',
                width: "50%",
            },
            {
                title: "Opciones",
                className: 'text-center',
                data: null,
                render: function(data, type, full, meta) {
                    var button = '';

                    if (data.asistio == null) {
                        var click = "asistir(" + 1 + ',' + data.id_agenda + ");";
                        button += '&nbsp<button data-tooltip="ASISTIO" title="ASISTIO" class="list-bt palette-Green-300 bg button" onclick="' + click + '"><i class="las la-check-circle la-2x"></i></button>';
                        click = "asistir(" + 0 + ',' + data.id_agenda + ");";
                        button += '&nbsp<button data-tooltip="NO ASISTIO" title="NO ASISTIO" class="list-bt palette-Red bg button" onclick="' + click + '"><i class="las la-times-circle la-2x"></i></button>';

                        click = "eliminarEspacio(" + data.id_agenda + ");";
                    button += '&nbsp<button data-tooltip="Borrar Espacio" title="Borrar Espacio" class="list-bt palette-Defecto bg button" onclick="' + click + '"><i class="las la-trash-alt la-2x"></i></button>';
                    }
                    else{

                        if(data.asistio == 'SI')
                        {
                            button += '<span>ASISTIO</span>';
                        }
                        else{
                            button += '<span>NO ASISTIO</span>';
                        }
                    }
                    return button;
                },
                width: "20%"
            }
        ]
    });

    function mostrarProgramas() {

        url = "<?php echo base_url() ?>obtener-programas";

        var data = new FormData();

        $.ajax({
            url: url,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: (response) => {
                $('#programas-table').DataTable().clear();
                $('#programas-table').DataTable().rows.add(JSON.parse(response.response.resultado));
                $('#programas-table').DataTable().draw();
            },
            error: function(xhr, status, error) {
                alert(xhr.responseText);
            }
        });
    }

    function registrarPrograma() {

        var programa = document.getElementById("programa_add").value;
        var medio = document.getElementById("medio_add").value;

        if (programa != '' && medio != '') {

            var data = new FormData();
            data.append('programa', programa)
            data.append('id_recurso', medio)

            url = "<?php echo base_url() ?>guardar-programa";

            $.ajax({
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: (response) => {

                    if (response.status) {
                        $('#programas-table').DataTable().clear();
                        $('#programas-table').DataTable().rows.add(response.response.data);
                        $('#programas-table').DataTable().draw();

                        document.getElementById("programa_add").value = "";
                        document.getElementById("medio_add").value = '';

                        var select = document.getElementById("programa");

                        select.innerHTML = "";

                        var option = document.createElement("option");
                        option.text = "SELECCIONE EL PROGRAMA";
                        option.value = '';
                        select.add(option);

                        for (value in response.response.programas) {
                            option = document.createElement("option");
                            option.text = response.response.programas[value];
                            option.value = value;
                            //select.appendChild(option);
                            select.add(option);
                        }


                    } else {
                        alert(response.response);
                    }


                },
                error: function(xhr, status, error) {
                    alert(xhr.responseText);
                }
            });

        } else {
            if (programa == '') {
                generarError("programa_add");
            } else {
                limpiarError("programa_add");
            }
            if (medio == '') {
                generarError("medio_add");
            } else {
                limpiarError("medio_add");
            }
        }
    }

    function eliminarPrograma(id) {

        swal({
                title: "¿Esta Seguro de Eliminar El Programa Seleccionado?",
                text: "Una vez eliminado no podra volver a verlo",
                icon: "warning",
                buttons: {
                    cancelar: {
                        text: "Cancelar",
                        className: "button expanded bg palette-Defecto"
                    },
                    eliminar: {
                        text: "Eliminar",
                        className: "button expanded bg palette-Defecto"
                    },
                },
            })
            .then((value) => {
                switch (value) {

                    case "eliminar":

                        url = "<?php echo base_url() ?>borrar-programa";

                        var data = new FormData();
                        data.append('id_prog', id);
                        $.ajax({
                            url: url,
                            data: data,
                            cache: false,
                            contentType: false,
                            processData: false,
                            type: 'POST',
                            success: (response) => {

                                if (response.status) {

                                    $('#programas-table').DataTable().clear();
                                    $('#programas-table').DataTable().rows.add(response.response.data);
                                    $('#programas-table').DataTable().draw();
                                }

                            },
                            error: function(xhr, status, error) {
                                alert(xhr.responseText);
                            }
                        });
                }
            });
    }

    function mostrarInterlocutores() {

        url = "<?php echo base_url() ?>obtener-interlocutores";

        var data = new FormData();

        $.ajax({
            url: url,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: (response) => {
                $('#interlocutores-table').DataTable().clear();
                $('#interlocutores-table').DataTable().rows.add(JSON.parse(response.response.resultado));
                $('#interlocutores-table').DataTable().draw();
            },
            error: function(xhr, status, error) {
                alert(xhr.responseText);
            }
        });
    }

    function registrarInterlocutor() {

        var interlocutor = document.getElementById("funcionario_add").value;
        var cargo = document.getElementById("cargo_add").value;

        if (interlocutor != '' && cargo != '') {

            var data = new FormData();
            data.append('interlocutor', interlocutor)
            data.append('cargo', cargo)

            url = "<?php echo base_url() ?>guardar-interlocutor";

            $.ajax({
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: (response) => {

                    if (response.status) {
                        $('#interlocutores-table').DataTable().clear();
                        $('#interlocutores-table').DataTable().rows.add(response.response.data);
                        $('#interlocutores-table').DataTable().draw();

                        document.getElementById("funcionario_add").value = "";
                        document.getElementById("cargo_add").value = '';

                        var select = document.getElementById("interlocutor_add");

                        select.innerHTML = "";

                        var option = document.createElement("option");
                        option.text = "SELECCIONE EL INTERLOCUTOR";
                        option.value = '';
                        select.add(option);

                        for (value in response.response.interlocutores) {
                            option = document.createElement("option");
                            option.text = response.response.interlocutores[value];
                            option.value = value;
                            //select.appendChild(option);
                            select.add(option);
                        }

                    } else {
                        alert(response.response);
                    }
                },
                error: function(xhr, status, error) {
                    alert(xhr.responseText);
                }
            });

        } else {
            if (interlocutor == '') {
                generarError("funcionario_add");
            } else {
                limpiarError("funcionario_add");
            }
            if (cargo == '') {
                generarError("cargo_add");
            } else {
                limpiarError("cargo_add");
            }
        }
    }

    function eliminarInterlocutor(id) {

        swal({
                title: "¿Esta Seguro de Eliminar El Interlocutor Seleccionado?",
                text: "Una vez eliminado no podra volver a verlo",
                icon: "warning",
                buttons: {
                    cancelar: {
                        text: "Cancelar",
                        className: "button expanded bg palette-Defecto"
                    },
                    eliminar: {
                        text: "Eliminar",
                        className: "button expanded bg palette-Defecto"
                    },
                },
            })
            .then((value) => {
                switch (value) {

                    case "eliminar":

                        url = "<?php echo base_url() ?>borrar-interlocutor";

                        var data = new FormData();
                        data.append('id_inter', id);
                        $.ajax({
                            url: url,
                            data: data,
                            cache: false,
                            contentType: false,
                            processData: false,
                            type: 'POST',
                            success: (response) => {

                                if (response.status) {

                                    $('#interlocutores-table').DataTable().clear();
                                    $('#interlocutores-table').DataTable().rows.add(response.response.data);
                                    $('#interlocutores-table').DataTable().draw();
                                }

                            },
                            error: function(xhr, status, error) {
                                alert(xhr.responseText);
                            }
                        });
                }
            });
    }

    function add_agenda(id) {

        document.getElementById("id_espacio_new").value = id;

        var data = new FormData();
        data.append('id', id)

        url = "<?php echo base_url() ?>recuperar-espacio";

        $.ajax({
            url: url,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: (response) => {

                if (response.status) {

                    document.getElementById("motivo_new").value = response.response.espacio.motivo_espacio;
                    document.getElementById("interlocutor_new").value = response.response.espacio.id_interlocutor;

                    var select = document.getElementById("programa_new");

                    select.innerHTML = "";

                    var option = document.createElement("option");
                    option.text = "SELECCIONE EL PROGRAMA";
                    option.value = '';
                    select.add(option);

                    for (value in response.response.programas) {
                        option = document.createElement("option");
                        option.text = response.response.programas[value];
                        option.value = value;
                        //select.appendChild(option);
                        select.add(option);
                    }

                } else {
                    alert(response.response);
                }
            },
            error: function(xhr, status, error) {
                alert(xhr.responseText);
            }
        });
    }

    function registrar_agenda() {

        var id = document.getElementById("id_espacio_new").value;
        var hora = document.getElementById("hora_new").value;
        var programa = document.getElementById("programa_new").value;
        var lugar = document.getElementById("lugar_new").value;
        var fecha = document.getElementsByName("fecha_new_submit")[0].value;

        if (hora != '' && programa != '' && lugar != '' && fecha != '') {

            var data = new FormData();
            data.append('id', id)
            data.append('hora', hora)
            data.append('programa', programa)
            data.append('lugar', lugar)
            data.append('fecha', fecha)

            url = "<?php echo base_url() ?>guardar-agenda";

            $.ajax({
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: (response) => {

                    if (response.status) {

                        swal("Registro Realizado", response.message, 'success');

                        document.getElementById("id_espacio_new").value = "";
                        document.getElementById("hora_new").value = "";
                        document.getElementById("programa_new").value = "";
                        document.getElementById("lugar_new").value = "";
                        document.getElementById("fecha_new").value = "";
                        document.getElementsByName("fecha_new_submit")[0].value = "";

                        $('#modalAdicion').foundation("close");


                    } else {
                        alert(response.response);
                    }
                },
                error: function(xhr, status, error) {
                    alert(xhr.responseText);
                }
            });

        } else {
            if (hora == '') {
                generarError("hora_new");
            } else {
                limpiarError("hora_new");
            }
            if (programa == '') {
                generarError("programa_new");
            } else {
                limpiarError("programa_new");
            }
            if (lugar == '') {
                generarError("lugar_new");
            } else {
                limpiarError("lugar_new");
            }
            if (cargo == '') {
                generarError("fecha_new");
            } else {
                limpiarError("fecha_new");
            }
        }

    }

    function imprimirAgenda() {

        var name_ini = "f_ini";
        var name_fin = "f_fin";
        document.getElementById(name_ini).value = document.getElementsByName("fecha_ini_submit")[0].value;
        document.getElementById(name_fin).value = document.getElementsByName("fecha_fin_submit")[0].value;

        return true;
    }



    function ver_agenda(id) {

        url = "<?php echo base_url() ?>obtener-espacios";

        var data = new FormData();
        data.append('id', id)

        $.ajax({
            url: url,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: (response) => {

                document.getElementById("titulo_motivo").innerHTML = response.response.espacio.motivo_espacio;
                document.getElementById("titulo_interlocutor").innerHTML = response.response.espacio.nombre_completo;
                document.getElementById("id_espacio_modal").value = id;

                $('#spaces-table').DataTable().clear();
                $('#spaces-table').DataTable().rows.add(response.response.agenda);
                $('#spaces-table').DataTable().draw();
            },
            error: function(xhr, status, error) {
                alert(xhr.responseText);
            }
        });

    }

    function eliminarEspacio(id) {

        var id_espacio = document.getElementById("id_espacio_modal").value;

        swal({
                title: "¿Esta Seguro de Eliminar El Espacio Seleccionado?",
                text: "Una vez eliminado no podra volver a verlo",
                icon: "warning",
                buttons: {
                    cancelar: {
                        text: "Cancelar",
                        className: "button expanded bg palette-Defecto"
                    },
                    eliminar: {
                        text: "Eliminar",
                        className: "button expanded bg palette-Defecto"
                    },
                },
            })
            .then((value) => {
                switch (value) {

                    case "eliminar":

                        url = "<?php echo base_url() ?>borrar-espacio";

                        var data = new FormData();
                        data.append('id_agenda', id);
                        data.append('id_espacio', id_espacio);
                        $.ajax({
                            url: url,
                            data: data,
                            cache: false,
                            contentType: false,
                            processData: false,
                            type: 'POST',
                            success: (response) => {

                                if (response.status) {

                                    $('#spaces-table').DataTable().clear();
                                    $('#spaces-table').DataTable().rows.add(response.response.data);
                                    $('#spaces-table').DataTable().draw();
                                }

                            },
                            error: function(xhr, status, error) {
                                alert(xhr.responseText);
                            }
                        });
                }
            });
    }

    function asistir(seleccion,id) {

        url = "<?php echo base_url() ?>marcar-asistencia";

        var id_espacio = document.getElementById("id_espacio_modal").value;

        var data = new FormData();
        data.append('id_agenda', id);
        data.append('id_espacio', id_espacio);
        data.append('seleccion', seleccion);
        $.ajax({
            url: url,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: (response) => {

                if (response.status) {

                    $('#spaces-table').DataTable().clear();
                    $('#spaces-table').DataTable().rows.add(response.response.data);
                    $('#spaces-table').DataTable().draw();
                }

            },
            error: function(xhr, status, error) {
                alert(xhr.responseText);
            }
        });

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
</script>