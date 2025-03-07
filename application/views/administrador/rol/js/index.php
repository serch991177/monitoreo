<script>
    $(document).ready(function() {

        var table = $('#table').dataTable({
            data: <?php echo $roles ?>,
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
                    title: "Rol",
                    className: 'text-center',
                    data: "nombre_rol",
                    width: "25%"
                },

                {
                    title: "Estado",
                    className: 'text-center',
                    data: null,
                    render: function(data, type, full, meta) {
                        var estado = '';

                        if (data.descripcion === 'HABILITADO') {
                            estado = '<span id="span' + data.id_rol + '" class="label success">HABILITADO</span>';
                        } else {
                            estado = '<span id="span' + data.id_rol + '" class="label alert">INHABILITADO</span>';
                        }

                        return estado;
                    },
                    width: "20%"
                },
                {
                    title: "Opciones",
                    className: 'text-center',
                    data: null,
                    render: function(data, type, full, meta) {

                        var button = '';

                        var url = "cambiarEstado(" + data.id_rol + ")";
                        var click = "modal(" + data.id_rol + ",'" + data.nombre_rol + "');";

                        button += '<button title="Cambiar de Estado" class="palette-Defecto bg button" onclick="' + url + '" type="button" value="' + data.id_rol + '">';
                        button += '<i class="las la-exchange-alt la-2x"></i>';
                        button += '</button>';

                        button += '&nbsp<button title="Editar Rol" class="palette-Defecto bg button" onclick="' + click + '" data-open="modalEditar"><i class="las la-pen la-2x"></i></i></button>';

                        return button;
                    },
                    width: "10%"
                }
            ]
        });
    });


    function cambiarEstado(rol, nombre) {
        url = "<?= site_url('cambiar-estado-rol') ?>";

        var data = new FormData();
        data.append('id_rol', rol);

        $.ajax({
            url: url,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: (response) => {
                var nombre = "span" + rol;
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

    function modal(rol, nombre) {

        document.getElementById('id_rol').value = rol;
        document.getElementById('rol').value = nombre;
    }
</script>
