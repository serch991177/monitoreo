<div class="box-header panel palette-Defecto bg">
    <h3><span>PORCENTAJE DE MEDIOS AÑADIDOS POR FUNCIONARIO</span></h3>
</div>
<table border="0" cellpadding="1" cellspacing="1" width="90%">
  <?php $colores = array("#4AC1E0", "#6D56A0", "#EA547C", "#4FB9A8", "#F9B154", "#009877", "#00ACD8", "#482778", "#AE1857", "#F18721");
   $i=0;?>
  <?php foreach($funcionarios as $funcionario){?>
    <tr>
      <td width="8%" bgcolor= "<?php echo $colores[$i]?>"></td>
      <td width="50%"><?php echo $funcionario->nombre_completo?></td>
    </tr>
  <?php $i++;}?>

</table>
