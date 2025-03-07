<div class="box-header panel palette-Defecto bg">
    <h3><span>PORCENTAJE DE FRECUENCIA POR TEMÁTICA</span></h3>
</div>
<table width="100%" border="0">
  <tr>
    <td>
      <table border="0" width="100%">
        <?php $colores = array("#4AC1E0", "#6D56A0", "#EA547C", "#4FB9A8", "#F9B154", "#009877", "#00ACD8", "#482778", "#784212", "#F18721", "#1E90FF","#2E8B57", "#ADFF2F","#DC143C" ,"#BA55D3","#0000FF","#FF00FF","#808000","#C0C0C0","#800000", "#00FFFF","#A58FE3", "#D68910","#F9E79F","#00BCD4" ,"#27AE60","#B2BABB","#34495E", "#AE1857", "#0097A7","#1A237E", "#795548","#283593","#AB47BC","#A93226","#DE8D25", "#E2EC1F","#86B918","#23B98E","#3FB7B0","#3E5A7C","#A353AF","#D932BD","#D93274",
        "#ED3636","#943126","#8AEF40","#B3A844","#E06C11","#DE7171","#AF7474","#EF4040","#4AC1E0", "#6D56A0", "#EA547C", "#4FB9A8", "#F9B154", "#009877", "#00ACD8", "#482778", "#784212", "#F18721", "#1E90FF","#2E8B57", "#ADFF2F","#DC143C" ,"#BA55D3","#0000FF","#FF00FF","#808000","#C0C0C0","#800000", "#00FFFF","#A58FE3", "#D68910","#F9E79F","#00BCD4" ,"#27AE60","#B2BABB","#34495E", "#AE1857", "#0097A7","#1A237E", "#795548","#283593","#AB47BC","#A93226","#DE8D25", "#E2EC1F","#86B918","#23B98E","#3FB7B0","#3E5A7C","#A353AF","#D932BD","#D93274",
        "#ED3636","#943126","#8AEF40","#B3A844","#E06C11","#DE7171","#AF7474","#EF4040","#4AC1E0", "#6D56A0", "#EA547C", "#4FB9A8", "#F9B154", "#009877", "#00ACD8", "#482778", "#784212", "#F18721", "#1E90FF","#2E8B57", "#ADFF2F","#DC143C" ,"#BA55D3","#0000FF","#FF00FF","#808000","#C0C0C0","#800000", "#00FFFF","#A58FE3");
          ?>
         <?php $i=0;
         $b=0;?>

        <?php $tam = count($temas);
          foreach($temas as $tema){?>
          <tr>
            <td width="10%" bgcolor= "<?php echo $colores[$i]?>"></td>
            <td width="88%"><?php echo  $tema->tema?></td>
          </tr>
          <?php
          $b++;
        $i++;?>
      <?php }?>

      </table>
    </td>
    <td>

      <?php $conta_te = explode(',', $not);
      $dat = implode('-',$conta_te);
      //echo $dat
      $ruta_archivo = "https://monitoreo.cochabamba.bo/ejemplo/".$dat;?>
      <img src="<?php echo $ruta_archivo ?>" width="680px" height="480px"/>
    </td>
  </tr>

</table>
