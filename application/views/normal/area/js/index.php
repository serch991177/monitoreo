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
                "url": "<?php echo site_url('normal/area/index'); ?>",
                //"type": "POST"
                //sirve para enviar variables en la peticion http
                data: function(d) {
                    //console.log(d);
                    //d.myKey = "myValue";
                    d.search_custom = d.search.value; //usar variables para filtros.
                    d.filter_estado = $('#estado').val();
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
                    data: 'nombre_area'
                },
                {
                    sortable: false,
                    render: function(data, type, row, meta) {

                        var content = '';

                        resp = decodeHtml(row.detalle);

                        content += resp;

                        return content;
                    }
                },
                {
                    className: 'dt-body-center',
                    sortable: false,
                    render: function(data, type, row, meta) {

                        var content = '';

                        if (row.id_estado == 1) {
                            content += '<span id="span' + row.id_area + '" class="label success">HABILITADO</span>';
                        } else {
                            content += '<span id="span' + row.id_area + '" class="label alert">DESHABILITADO</span>';
                        }

                        return content;
                    }
                },
                {
                    className: 'dt-body-center',
                    sortable: false,
                    render: function(data, type, row, meta) {

                        var button = '';

                        var click = "modArea(" + row.id_area + ");";
                        button += '&nbsp<button title="Modificar Área" data-tooltip="Modificar Área" class="list-bt palette-Defecto bg button" onclick="' + click + '" data-open="modalArea"><i class="las la-edit la-2x"></i></button>';

                        var url = "cambiarEstado(" + row.id_area + ")";
                        button += '<button title="Cambiar de Estado" class="list-bt palette-Defecto bg button" onclick="' + url + '" type="button" value="' + row.id_area + '">';
                        button += '<i class="las la-exchange-alt la-2x"></i>';
                        button += '</button>';

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

    function cambiarEstado(elemento) {
        url = "<?= site_url('cambiar-estado') ?>";

        var data = new FormData();
        data.append('id_elemento', elemento);
        data.append('tabla', 'area');
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

    function nuevaArea()
    {
        document.getElementById("titulo-modal").innerHTML = "Agregar Nueva Área";
        document.getElementById("btn_reg_area").innerHTML = "Registrar Área";
        document.getElementById("area").value = "";
        document.getElementById("id_area").value = "";
        tinymce.get("detalle").setContent("");
        document.getElementById("estado").value = "";
    }

    function modArea(identificador) {

        document.getElementById("titulo-modal").innerHTML = "Modificar Área"
        document.getElementById("btn_reg_area").innerHTML = "Modificar Área";

        document.getElementById("area").value = "";
        document.getElementById("id_area").value = "";
        tinymce.get("detalle").setContent("");
        document.getElementById("estado").value = "";

        url = "<?= site_url('obtain-info') ?>";

        var data = new FormData();
        data.append('id_elemento', identificador);
        data.append('tabla', 'area');
        $.ajax({
            url: url,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: (response) => {

                document.getElementById("area").value = response.response.data.nombre_area;

                var html = decodeHtml(response.response.data.detalle);
                tinymce.get("detalle").setContent(html);

                document.getElementById("id_area").value = response.response.data.id_area;

                document.getElementById("estado").value = response.response.data.id_estado;


            },
            error: function(xhr, status, error) {
                alert(xhr.responseText);
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