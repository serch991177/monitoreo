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

    function obtener() {

        var e = document.getElementById("funcionario");
        var value = e.options[e.selectedIndex].value;

        var fecha = document.getElementsByName("fecha_ini_submit")[0].value;

        if (value != '') {
            document.getElementById('id_usuario').value = value;
        }

        if (fecha != '') {
            document.getElementById('fecha_in').value = fecha;
        }

        return true;
    }

    function cambio(){

        var id_sesion = <?= $this->session->sistema->id_usuario ?>;
        var id_rol = <?= $this->session->sistema->id_rol ?>;

        if (id_rol != 1) {

            var e = document.getElementById("funcionario");
            var value = e.options[e.selectedIndex].value;

            if (value != id_sesion) {
            
                document.getElementById("btn_print").style.display = 'none';
            }

        }
        else{
            document.getElementById("btn_print").style.display = 'block';
        }

    }

    $(document).ready(function() {

        var id_sesion = <?= $this->session->sistema->id_usuario ?>;
        var id_rol = <?= $this->session->sistema->id_rol ?>;

        if (id_rol != 1) {

            var e = document.getElementById("funcionario");
            var value = e.options[e.selectedIndex].value;

            if (value == id_sesion) {
                document.getElementById("btn_print").style.display = 'block';
            } else {
                document.getElementById("btn_print").style.display = 'none';
            }

        } else {
            document.getElementById("btn_print").style.display = 'block';
        }



    });
</script>
