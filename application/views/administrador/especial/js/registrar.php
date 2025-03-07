<script>
    var i = 1;
    $('#add').click(function() {
        i++;
        $('#dynamic_field').append('<div id="row' + i +'" class="large-12 columns"><label for="dni['+i+']">Documento de Identidad</label><div class="input-group"><span class="input-group-label"><i class="las la-address-card"></i></span><input type="text" id="dni' + i +'" name="dni['+i+']" class ="input-group-field"> <span class="input-group-label btn_remove" name="remove" id="' + i + '"><i class="las la-minus-circle"></i></span></div>');
    });

    $(document).on('click', '.btn_remove', function() {
        var button_id = $(this).attr("id");
        $('#row' + button_id + '').remove();
    });
</script>