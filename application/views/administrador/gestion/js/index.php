<script>
    $(document).ready(function() {

        var table = $('#table').dataTable({
            data: <?php echo $gestiones ?>,
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
                    title: "Gestión",
                    className: 'text-center',
                    data: "descripcion_gestion",
                    width: "10%"
                },
                {
                    title: "Nombre Alcalde",
                    className: 'text-center',
                    data: 'nombre_alcalde',
                    width: "25%",
                },
                {
                    title: "Cargo Alcalde",
                    className: 'text-center',
                    data: 'cargo_alcalde',
                    width: "25%",
                },
                {
                    title: "Estado",
                    className: 'text-center',
                    data: null,
                    render: function(data, type, full, meta) {
                        var estado = '';

                        if (data.editable === 'SI') {
                            estado = '<span class="label success">EDITABLE</span>';
                        } else {
                            estado = '<span class="label alert">CERRADO</span>';
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
                        var url = "<?= site_url('cambiar-estado-gestion') ?>";

                        button += '<form action="' + url + '" method="post" id="gestion' + data.id_gestion + '">';
                        button += '<input name="id_gestion" type="hidden" value="' + data.id_gestion + '"/>';
                        button += '<input name="editable" type="hidden" value="' + data.editable + '"/>';

                        button += '<button title="Cambiar de Estado" class="palette-Defecto bg button" type="submit" form="gestion' + data.id_gestion + '">';
                        button += '<i class="las la-exchange-alt la-2x"></i>';
                        button += '</button>';
                        button += '</form>';

                        return button;
                    },
                    width: "10%"
                }
            ]
        });


    });
</script>