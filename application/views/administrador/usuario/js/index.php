<script>
    $(document).ready(function() {

        var table = $('#table').dataTable({
            data: <?php echo $usuarios ?>,
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
					width: "4%",
					data: "row",
				},

                {
                    title: "Nombre Completo",
                    className: 'text-center',
                    data: "nombre_completo",
                    width: "15%"
                },
                {
                    title: "Carnet de Identidad",
                    className: 'text-center',
                    data: 'dni',
                    width: "8%"
                },
                {
                    title: "Unidad Organizacional",
                    className: 'text-center',
                    data: 'unidad_organizacional',
                    width: "16%"
                },
                {
                    title: "Cargo",
                    className: 'text-center',
                    data: 'cargo',
                    width: "10%"
                },
                {
                    title: "Nº de Item",
                    className: 'text-center',
                    data: 'nro_item',
                    width: "8%"
                },
                {
                    title: "Correo",
                    className: 'text-center',
                    data: 'correo_municipal',
                    width: "11%"
                },
                {
                    title: "Rol",
                    className: 'text-center',
                    data: 'nombre_rol',
                    width: "10%",
                },
                {
                    title: "Opciones",
                    className: 'text-center',
                    data: null,
                    render: function(data, type, full, meta) {

                        var button = '';
                        var url = "<?= site_url('funciones-usuario/') ?>" + data.id_usuario;
                        var urle = "<?= site_url('editar-usuario') ?>";

                        var click = "modal(" + data.id_usuario + ",'" + data.nombre_completo + "'," + data.id_rol + ");";

                        button += '<form  style="display : inline;" action="' + url + '" method="post" id="form' + data.id_usuario + '">';
                        button += '<button type="submit" data-tooltip="Funciones de Usuario" title="Funciones de Usuario" class="palette-Defecto bg button" form="form' + data.id_usuario + '">';
                        button += '<i class="las la-cogs la-2x"></i></button>';
                        button += '</form>';

                        button += '&nbsp<button title="Cambiar Rol" class="palette-Defecto bg button" onclick="' + click + '" data-open="modalRol"><i class="las la-briefcase la-2x"></i></i></button>';                      

                        button += '&nbsp<form  style="display : inline;" action="' + urle + '" method="post" id="forme' + data.id_usuario + '">';
                        button += '<input type="hidden" name="usuario" value="' + data.id_usuario + '">';
                        button += '<button type="submit" data-tooltip="Editar Usuario" title="Editar Usuario" class="palette-Defecto bg button" form="forme' + data.id_usuario + '">';
                        button += '<i class="las la-pen la-2x"></i></button>';
                        button += '</form>';
   
                        return button;
                    },
                    width: "20%"
                }
            ]
        });
    });

    function modal(id,nombre,rol){
        
        document.getElementById('id_rol').value = rol;
        document.getElementById('usu').innerHTML = nombre;
        document.getElementById('id_usuario').value = id;        
        document.getElementById('rol_ant').value = rol;
    }
</script>