<script>
    $(document).ready(function() {
        $('#id_padre').select2();
    });

    function selectMenu() {
        var estado = document.getElementById('es_menu').value;

        if (estado == 'SI') {
            document.getElementById('es_submenu').value = 'NO';
            document.getElementById('es_sub_submenu').value = 'NO';
        } else {
            document.getElementById('es_submenu').value = '';
            document.getElementById('es_sub_submenu').value = '';
        }
    }

    function selectSubmenu() {
        var estado = document.getElementById('es_submenu').value;

        if (estado == 'SI') {
            document.getElementById('es_menu').value = 'NO';
            document.getElementById('es_sub_submenu').value = 'NO';
        } else {
            document.getElementById('es_menu').value = '';
            document.getElementById('es_sub_submenu').value = '';
        }
    }

    function selectSubsubmenu() {
        var estado = document.getElementById('es_sub_submenu').value;

        if (estado == 'SI') {
            document.getElementById('es_menu').value = 'NO';
            document.getElementById('es_submenu').value = 'NO';
        } else {
            document.getElementById('es_menu').value = '';
            document.getElementById('es_submenu').value = '';
        }
    }
</script>