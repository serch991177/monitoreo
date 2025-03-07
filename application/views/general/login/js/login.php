
<script type="text/javascript" chartset="utf-8">

   jQuery('#search_dni').click(function()
   {

      var dni = $('#dni').val();

      $.post('https://appgamc.cochabamba.bo/transparencia/servicio/busqueda_empleados.php',
      {
			   tipo: 'D',
			   dato: dni,
			   consulta: 'obtienefuncionarios'
      })

      .done(function(data)
      {
         var result = data.data[0];

         $('#nombre_completo').val(result.empleado);
         $('#unidad_organizacional').val(result.unidad);
         $('#cargo').val(result.cargo);
         $('#nro_item').val(result.item);

      });

   });


</script>
