<script>
    $(document).ready(function() {

        var table = $('#table').dataTable({
            data: <?php echo $funciones ?>,
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
                    title: "Nombre de Función",
                    className: 'text-center',
                    data: "nombre_accion",
                    width: "20%"
                },
                {
                    title: "Es Menu Principal",
                    className: 'text-center',
                    data: 'es_menu',
                    width: "10%"
                },
                {
                    title: "Es Sub-Menu",
                    className: 'text-center',
                    data: 'es_submenu',
                    width: "10%"
                },
                {
                    title: "Es Sub-Sub-Menu",
                    data: 'es_sub_submenu',
                    width: "10%"
                },
                {
                    title: "Es Boton",
                    className: 'text-center',
                    data: 'es_boton',
                    width: "10%"
                },
                {
                    title: "Icono",
                    data: null,
                    className: 'text-center',
                    render: function(data, type, full, meta) {
                        return '<i class="' + data.icon + ' la-2x"></i>';
                    },
                    width: "10%"
                },
                {
                    title: "Ruta Amigable",
                    className: 'text-center',
                    data: 'ruta_amigable',
                    width: "15%",
                },
                {
                    title: "Opciones",
                    className: 'text-center',
                    data: null,
                    render: function(data, type, full, meta) {

                        var button = '';
                        var url = "<?= site_url('editar-funcion') ?>";

                        button += '<form action="' + url + '" method="post" id="form' + data.id_accion + '">';
                        button += '<input name="id_funcion" type="hidden" value="' + data.id_accion + '"/>';
                        button += '<button class="palette-Defecto bg button" type="submit" form="form' + data.id_accion + '" value="' + data.id_accion + '"><i class="las la-pen la-2x"></i></button>'
                        button += '</form>';

                        return button;
                    },
                    width: "10%"
                }
            ]
        });


    });
</script>