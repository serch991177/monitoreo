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
                "url": "<?php echo site_url('normal/nota/index'); ?>",
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
                    data: 'nombre_dependencia'
                },
                {
                    sortable: false,
                    render: function(data, type, row, meta) {

                        var content = '';

                        resp = decodeHtml(row.tema);

                        content += resp;

                        return content;
                    }
                },
                {
                    data: 'nombre_area'
                },
                {
                    data: 'nombre'
                },
                {
                    data: 'nombre_tendencia'
                },

                {
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
                },
                {
                    className: 'dt-body-center',
                    sortable: false,
                    render: function(data, type, row, meta) {

                        var button = '';

                        var click = "modNota(" + row.id_nota + ")";
                        button += '&nbsp<button title="Modificar Nota" data-tooltip="Modificar Nota" class="list-bt palette-Defecto bg button" onclick="' + click + '" data-open="modalNota"><i class="las la-edit la-2x"></i></button>';

                        var click = "subirNota(" + row.id_nota + ")";
                        button += '&nbsp<button title="Subir Archivo" data-tooltip="Subir Archivo" class="list-bt palette-Defecto bg button" onclick="' + click + '" data-open="modalArchivo"><i class="las la-file-upload la-2x"></i></button>';

                        var url = "cambiarEstado(" + row.id_nota + ")";
                        button += '<button title="Cambiar de Estado" class="list-bt palette-Defecto bg button" onclick="' + url + '" type="button" value="' + row.id_nota + '">';
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
                    titleAttr: 'Exportar el reporte a PDF',
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

    function nuevaNota()
    {
        document.getElementById("titulo-modal").innerHTML = "Agregar Nueva Nota";
        document.getElementById("btn_reg_nota").innerHTML = "Registrar Nota";
        document.getElementById("id_nota").value = "";
        document.getElementById("area").value = "";
        document.getElementById("medio").value = "";
        document.getElementById("tendencia").value = "";
        document.getElementById("dependencia").value = "";
        document.getElementById("tipo_noticia").value = "";


        tinymce.get("tema").setContent("");
        tinymce.get("observacion").setContent("");
        document.getElementById("estado").value = "";
          document.getElementById("turno").value = "";
    }
    function subirNota(identificador){
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

    function subirNota(elemento){

           $('#ver_archiv').empty();
          var id=elemento;
          $.getJSON('<?php echo site_url('normal/nota/getArchivo');?>', { id: id })
      		.done(function(data) {
      			$("#id_n").val(id);
              $('#ver_archivo').empty();
              //alert(data.adjunto);

      				//$('#ver_archivo').attr('href',''data.adjunto);
      				if(data.adjunto != null){
                $('#ver_archivo').append('<a href="<?php echo site_url()?>public/archivos/'+data.adjunto+'" title="'+data.adjunto+'" target="_blank">'+data.adjunto+'</a><br>');
              }

            //}

      		});
        }
    function modNota(identificador) {

        document.getElementById("titulo-modal").innerHTML = "Modificar Nota"
        document.getElementById("btn_reg_nota").innerHTML = "Modificar Nota";

        document.getElementById("tema").value = "";
        document.getElementById("id_nota").value = "";
        tinymce.get("tema").setContent("");
        tinymce.get("observacion").setContent("");
        document.getElementById("area").value = "";
        document.getElementById("medio").value = "";
        document.getElementById("turno").value = "";
        document.getElementById("tendencia").value = "";
        document.getElementById("dependencia").value = "";
        document.getElementById("estado").value = "";
        document.getElementById("tipo_noticia").value = "";

        url = "<?= site_url('obtain-info') ?>";

        var data = new FormData();
        data.append('id_elemento', identificador);
        data.append('tabla', 'nota');
        $.ajax({
            url: url,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: (response) => {

                document.getElementById("nota").value = response.response.data.nombre_dependencia;

                var html = decodeHtml(response.response.data.tema);
                tinymce.get("tema").setContent(html);
                document.getElementById("id_nota").value = response.response.data.id_nota;
                document.getElementById("area").value = response.response.data.id_area;
                document.getElementById("medio").value = response.response.data.id_recurso;
                document.getElementById("tendencia").value = response.response.data.id_tendencia;
                document.getElementById("dependencia").value = response.response.data.id_dependencia;

                document.getElementById("tipo_noticia").value = response.response.data.id_tipo_noticia;
                  document.getElementById("turno").value = response.response.data.id_turno;
                document.getElementById("estado").value = response.response.data.id_estado;

                var html2 = decodeHtml(response.response.data.observacion);
                tinymce.get("observacion").setContent(html2);

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

    function validarEditor() {
        var myContent = tinymce.get("descripcion").getContent();

        if (myContent == '') {
            document.getElementById("descripcion_ifr").style.backgroundColor = '#f9ecea';
            document.getElementById("descripcion_ifr").style.borderTop = '2px solid red';
            document.getElementById("descripcion_ifr").style.borderBottom = '2px solid red';
            document.getElementById("descripcion_ifr").style.borderRight = '2px solid red';
            document.getElementById("descripcion_ifr").style.borderLeft = '2px solid red';
            $('span[data-form-error-for="descripcion"]').addClass('is-visible');
            return 0;
        } else {
            document.getElementById("descripcion_ifr").style.backgroundColor = "#FFFFFF";
            document.getElementById("descripcion_ifr").style.borderTop = '0px';
            document.getElementById("descripcion_ifr").style.borderBottom = '0px';
            document.getElementById("descripcion_ifr").style.borderRight = '0px';
            document.getElementById("descripcion_ifr").style.borderLeft = '0px';
            $('span[data-form-error-for="descripcion"]').removeClass('is-visible');
            return 1;
        }
    }
</script>
