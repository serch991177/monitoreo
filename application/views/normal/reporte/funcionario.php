<?php $this->load->view('general/layout/menu') ?>
<div class="row">
  <div class="large-9 large-centered columns">

    <?= form_open('reporte-funcionario', array('id' => 'reporte_tematica', 'data-abide' => '', 'no-validate' => '')); ?>
      <div class="large-4 medium-4 small-12 columns">
          <?= form_label(lang('fecha.inicial'), 'fecha_ini'); ?>
          <div class="input-group">
              <span class="input-group-label"><i class="las la-calendar"></i></span>
              <?= form_input('fecha_ini', set_value('fecha_ini'), ['class' => 'input-group-field datepicker', 'required' => 'required', 'id' => 'fecha_ini']); ?>
          </div>
          <span class="form-error" data-form-error-for="fecha_ini">
            <?= lang('campo.requerido') ?>
          </span>
      </div>
      <div class="large-4 medium-4 small-12 columns">
          <?= form_label(lang('fecha.final'), 'fecha_fin'); ?>
          <div class="input-group">
              <span class="input-group-label"><i class="las la-calendar-alt"></i></span>
              <?= form_input('fecha_fin', set_value('fecha_fin'), ['class' => 'input-group-field datepicker', 'required' => 'required', 'id' => 'fecha_fin']); ?>
          </div>
          <span class="form-error" data-form-error-for="fecha_fin">
              <?= lang('campo.requerido') ?>
          </span>
      </div>
      <div class="large-2 medium-2 small-12 columns">
        <button type="submit" name="print" class="large button palette-Defecto bg">
            <i class="las la-filter la-2x"></i><span>Buscar</span>
        </button>
      </div>
    <?= form_close(); ?>
  </div>
</div>
<?php if(!empty($medios)){?>
  <?php

     if(empty($fecha_i) && empty($fecha_f)){
       $fecha_i = date('Y-m-d');
       $fecha_f = date('Y-m-d');
     }?>
<div class="row">
    <?= form_open('imprimir-reporte-funcionario', ['id' => 'imprimir_reporte', 'target' => 'blank']); ?>
  <div class="large-12 columns center">
    <button type="submit" name="print" class="large button palette-Defecto bg">
        <i class="las la-filter la-2x"></i><span>Imprimir</span>
    </button>
    <input type="hidden" name="fecha_in" value="<?php echo $fecha_i?>" />
    <input type="hidden" name="fecha_fi" value="<?php echo $fecha_f?>" />

  </div>
  <?= form_close(); ?>
</div>
<div class="row">
    <div class="large-11 large-centered columns">
        <?php $this->load->view('general/layout/message') ?>

        <div class="box no-shadow">
            <div class="box-header panel palette-Defecto bg">
                <h3 class="box-title palette-White"><i class="las la-th-list la-2x"></i>
                    <span><?= lang('reporte.funcionario') ?></span>
                </h3>
            </div>
            <div class="box-body">
              <?php  $porcentaje_mayor= 0; ?>
              <div class="row">
                <div class="large-12 columns">
                  <table id="example" class="display cell-border" style="width:100%">

                    <thead>
                      <tr>
                          <th>#</th>
                          <th>Funcionario</th>
                          <?php foreach ($medios as $medio){?>
                            <th><?= $medio->nombre?></th>

                          <?php }?>

                          <th>TOTAL</th>
                          <th>%</th>
                      </tr>
                    </thead>
                    <tbody>
										<?php $numero = 1; $total = 0;?>
										<?php foreach($funcionarios as $funcionario){
                    $cont_total_fila = 0;
                    $ten_total_fila = 0;
											?>
											<tr>
												<td><?php echo $numero ?></td>
												<td><?php echo $funcionario->nombre_completo?></td>
                        <?php

                        foreach($medios as $medio){
                          $query_i = "select count(detalle_medio.id_nota) as contador
            							from detalle_medio
            							left join recurso on recurso.id_recurso = detalle_medio.id_recurso
            							left join nota  on nota.id_nota = detalle_medio.id_nota
            							where nota.id_estado=1 and
            							nota.fecha_registro > '".$fecha_i." 00:00:00' AND nota.fecha_registro <= '".$fecha_f." 23:59:59' AND detalle_medio.id_usuario= '$funcionario->id_usuario' and nombre = '$medio->nombre'";
                          $consulta = $this->db->query($query_i);
                          $listas_contador = $consulta->result();
                          //print_r($listas_contador);
                            //if(isset($listas_contador->contador))?>
                          <td><?php echo $listas_contador[0]->contador?></td>
                          <?php
                            $cont_total_fila = $cont_total_fila + $listas_contador[0]->contador;
                         }?>




                        <td><?php echo $cont_total_fila?></td>

                        <?php $total = $total + $listas_contador[0]->contador;

                        $porcentaje =number_format(($cont_total_fila * 100) / $tot,2,".","");
                      ?>
                        <td><?php echo $porcentaje.' %'?></td>
                        </tr>
												<?php


                      } ?>
                        <tr>
                          <td colspan="2" align="center"><b><?php echo 'Total'?></b></td>
                          <?php foreach($medios as $medio){
                            $query_medios = "select count(detalle_medio.id_nota) as contador
                            from detalle_medio
                            left join nota  on nota.id_nota = detalle_medio.id_nota
                            where nota.id_estado=1 and
                            nota.fecha_registro > '".$fecha_i." 00:00:00' AND nota.fecha_registro <= '".$fecha_f." 23:59:59' AND detalle_medio.id_recurso = '$medio->id_recurso'
                                        ";
                            $consulta = $this->db->query($query_medios);
                            $contador_medios = $consulta->result();
                            ?>
                            <td><?php echo $contador_medios[0]->contador?></td>

                            <?php } ?>

                            <td ><b><?php echo $tot?></b></td>
                            <td ><b><?php echo '100 %'?></b></td>
                        </tr>
                    </tbody>
                  </table>

                  </div>
              </div>
              <div class="row">
                <div class="large-8 large-centered columns">
                  <div class="box no-shadow">
                    <div class="box-header panel palette-Defecto bg">
                        <h3 class="box-title palette-White"><i class="las la-th-list la-2x"></i>
                            <span><?= lang('porcentaje.usuario') ?></span>
                        </h3>
                    </div>
                    <div class="box-body">
                      <div class="row">
                        <div class="large-8 columns">
                          <canvas id="pie-chart-funcionario" width="600" height="450"></canvas>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!--div class="row">
                <div class="large-10 large-centered columns">
                  <div class="box no-shadow">
                    <div class="box-header panel palette-NInstitucional bg">
                        <h3 class="box-title palette-White"><i class="las la-info"></i>
                            <span><?= lang('registro.medios.funcionario') ?></span>
                        </h3>
                    </div>
                    <div class="box-body">
                      <div class="row">
                        <div class="large-12">
                            <canvas id="bar-chart-grouped" width="800" height="450"></canvas>

                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div-->

            </div>
        </div>
    </div>
</div>
<?php }?>
<?php $this->load->view('normal/reporte/js/graficos_funcionarios') ?>
<?php $this->load->view('normal/reporte/js/funcionario') ?>
<?php $this->load->view('general/layout/footer') ?>
