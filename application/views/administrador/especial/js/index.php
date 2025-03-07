<script>
    $(document).ready(function() {

        var table = $('#table').dataTable({
            data: <?php echo $dnis ?>,
            responsive: true,
            "lengthMenu": [
                [15, 30, 45, -1],
                [15, 30, 45, "Todo"]
            ],
            "pageLength": 15,

            "language": {
                "search": "Buscar",
                "lengthMenu": "Mostrar _MENU_",
                "zeroRecords": "No se encontró nada",
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

            columns: [


                {
                    title: "Nº",
					width: "5%",
					data: "row",
				},

                {
                    title: "Documento de Identidad",
                    className: 'text-center',
                    data: "dni",
                    width: "30%"
                },
                {
                    title: "Rol",
                    className: 'text-center',
                    data: 'nombre_rol',
                    width: "20%",
                },
                {
                    title: "Estado",
                    className: 'text-center',
                    data: null,
                    render: function(data, type, full, meta) {
                        var estado = '';

                        if (data.descripcion === 'HABILITADO') {
                            estado = '<span id="span' + data.id_especial + '" class="label success">HABILITADO</span>';
                        } else {
                            estado = '<span id="span' + data.id_especial + '" class="label alert">INHABILITADO</span>';
                        }

                        return estado;
                    },
                    width: "15%"
                },
                {
                    title: "Opciones",
                    className: 'text-center',
                    data: null,
                    render: function(data, type, full, meta) {

                        var button = '';

                        if (data.registrado == "NO") {

                            var url = "cambiarEstado(" + data.id_especial + ")";
                            var click = "modal(" + data.id_especial + ",'" + data.dni + "','" + data.id_rol + "');";

                            button += '<button title="Cambiar de Estado" class="palette-Defecto bg button" onclick="' + url + '" type="button" value="' + data.id_especial + '">';
                            button += '<i class="las la-exchange-alt la-2x"></i>';
                            button += '</button>';

                            button += '&nbsp<button title="Editar DNI" class="palette-Defecto bg button" onclick="' + click + '" data-open="modalEditar"><i class="las la-pen la-2x"></i></i></button>';

                        }
                        else{
                            button += '<span class="label success">USUARIO CREADO</span>';
                        }
                        return button;

                    },
                    width: "10%"

                }
            ]
        });
    });

    function cambiarEstado(especial, estado) {
        url = "<?= site_url('cambiar-estado-dni') ?>";

        var data = new FormData();
        data.append('id_especial', especial);

        $.ajax({
            url: url,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: (response) => {
                var nombre = "span" + especial;
                //alert(nombre);
                if (response == 1) {
                    document.getElementById(nombre).className = "label success";
                    document.getElementById(nombre).innerHTML = "";
                    document.getElementById(nombre).innerHTML = "HABILITADO";
                } else {
                    document.getElementById(nombre).className = "label alert";
                    document.getElementById(nombre).innerHTML = "";
                    document.getElementById(nombre).innerHTML = "INHABILITADO";
                }
            },
            error: function(xhr, status, error) {
                alert(xhr.responseText);
            }
        });
    }

    function modal(especial, dni, rol) {

        document.getElementById('especial').value = especial;
        document.getElementById('dni').value = dni;
        document.getElementById('rol').value = rol;
    }
</script>
