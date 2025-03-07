<script>
    $(document).ready(function() {

        var table = $('#table').dataTable({
            data: <?php echo $defecto ?>,
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
                    title: "Icono",
                    data: null,
                    className: 'text-center',
                    render: function(data, type, full, meta) {
                        return '<i class="' + data.icon + ' la-2x"></i>';
                    },
                    width: "10%"
                },
                {
                    title: "Rol",
                    className: 'text-center',
                    data: 'nombre_rol',
                    width: "15%",
                },
                {
                    title: "Estado",
                    className: 'text-center',
                    data: null,
                    render: function(data, type, full, meta) {
                        var estado = '';

                        if (data.descripcion === 'HABILITADO') {
                            estado = '<span id="span'+data.id_por_defecto+'" class="label success">HABILITADO</span>';
                        } else {
                            estado = '<span id="span'+data.id_por_defecto+'" class="label alert">INHABILITADO</span>';
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

                        var url = "cambiarEstado("+data.id_por_defecto+")";

                        button += '<button title="Cambiar de Estado" class="palette-Defecto bg button" onclick="'+url+'" type="button" value="' + data.id_por_defecto + '">';
                        button += '<i class="las la-exchange-alt la-2x"></i>';
                        button += '</button>';

                        return button;
                    },
                    width: "10%"
                }                
            ]
        });
    });
    function cambiarEstado(por_defecto,estado)
    {
        url = "<?= site_url('cambiar-estado-por-defecto') ?>";

        var data = new FormData();
        data.append('id_por_defecto', por_defecto);

        $.ajax({
            url: url,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: (response) => {
                var nombre = "span"+por_defecto;
                if (response == 1) {
                    document.getElementById(nombre).className = "label success";
                    document.getElementById(nombre).innerHTML = "";
                    document.getElementById(nombre).innerHTML = "HABILITADO";
                }
                else{
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
</script>