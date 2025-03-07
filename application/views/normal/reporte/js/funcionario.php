<script>

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
        min: new Date(2021, 04, 24),
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
        min: new Date(2021, 04, 24),
        max: new Date(now.getFullYear(), month - 1, day)
    });

    $('.datepicker').on('change', function() {
        if ($(this).attr('id') === 'fecha_ini') {
            //alert($(this).val())
            $('#fecha_fin').pickadate('picker').set('min', $(this).val());
        }
        if ($(this).attr('id') === 'fecha_fin') {
            $('#fecha_ini').pickadate('picker').set('max', $(this).val());
        }
    });

</script>
