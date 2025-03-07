<div class="box-header panel palette-Defecto bg">
  <h3><span>MONITOREO DE NOTAS MUNICIPALES</span></h3>
</div>
<table border="1" width="80%">
  <thead>
    <tr>
      <th width="40%"><b>TENDENCIA</b></th>
      <th width="15%"><b>CANT</b></th>
      <th width="15%"><b>PORCENTAJE</b></th>
    </tr>
  </thead>
  <tbody>
    <?php $id_depend = 1; ?>
    <?php
    while ($id_depend <= 3) {
      $where3['nota.id_estado'] = 1;
      $where3['nota.fecha_registro >'] = $fecha_i . ' 00:00:00';
      $where3['nota.fecha_registro <='] = $fecha_i . ' 23:59:59';
      $where3['detalle_medio.id_tendencia ='] = $id_depend;
      if ($id_usuario > 0) {
        $where3['detalle_medio.id_usuario ='] = $id_usuario;
      }

      $listas_tendencia = $this->main->getListSelectJoin('detalle_medio', 'tendencia.nombre_tendencia ,count(detalle_medio.id_nota) as total', null, $where3, null, null, ['tendencia' => 'id_tendencia', 'nota' => 'id_nota'], ['tendencia.nombre_tendencia']);
      foreach ($listas_tendencia as $list) { ?>
        <tr>
          <td width="40%"><?php echo $list->nombre_tendencia ?></td>
          <td width="15%"><?php echo $list->total ?></td>
          <?php $conteo = $list->total;
          $porcentaje = number_format(($conteo * 100) / $tot, 2, ".", ""); ?>
          <td width="15%"><?php echo $porcentaje . ' %' ?></td>
        </tr>

      <?php } ?>
      <?php $id_depend++; ?>

    <?php } ?>
    <tr>
      <td width="40%"><b>TOTAL</b></td>
      <td width="15%"><b><?php echo $tot ?></b></td>
      <td width="15%"><b><?php echo '100 %' ?></b></td>
    </tr>
  </tbody>
</table>
