<?php $this->load->view('general/layout/menu') ?>
<div class="row">
  <div class="large-9 large-centered columns">

    <?= form_open('reporte-tematica', array('id' => 'reporte_tematica', 'data-abide' => '', 'no-validate' => '')); ?>
      <div class="large-3 medium-6 small-12 columns">
          <?= form_label(lang('fecha'), 'fecha_ini'); ?>
          <div class="input-group">
              <span class="input-group-label"><i class="las la-calendar"></i></span>
              <?= form_input('fecha_ini', set_value('fecha_ini'), ['class' => 'input-group-field datepicker', 'required' => 'required', 'id' => 'fecha_ini']); ?>
          </div>
          <span class="form-error" data-form-error-for="fecha_ini">
            <?= lang('campo.requerido') ?>
          </span>
      </div>
      <!--div class="large-3 medium-6 small-12 columns">
          <?= form_label(lang('fecha.final'), 'fecha_fin'); ?>
          <div class="input-group">
              <span class="input-group-label"><i class="las la-calendar-alt"></i></span>
              <?= form_input('fecha_fin', set_value('fecha_fin'), ['class' => 'input-group-field datepicker', 'required' => 'required', 'id' => 'fecha_fin','onchange'=>'cambio();']); ?>
          </div>
          <span class="form-error" data-form-error-for="fecha_fin">
              <?= lang('campo.requerido') ?>
          </span>
      </div-->
      <div class="large-4 medium-6 small-12 columns">
          <?= form_label(lang('funcionario'), 'funcionario'); ?>
          <div class="input-group">
              <span class="input-group-label"><i class="las la-question-circle"></i></span>
              <?=form_dropdown('funcionario', $funcionarios, $id_usuario, ['class'=>'input-group-field', 'id'=>'funcionario', 'onchange'=>'cambio();']); ?>
          </div>
          <span class="form-error" data-form-error-for="funcionario">
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
<?php

if(!empty($medios)){?>
  <?php

     if(empty($fecha_i)){
       $fecha_i = date('Y-m-d');
       //$fecha_f = date('Y-m-d');
     }?>

<div class="row" id="btn_print" style="display: none;">
    <?= form_open('imprimir-reporte-tematica', ['id' => 'imprimir_reporte', 'target' => 'blank', 'onsubmit' => 'obtener();']); ?>
  <div class="large-12 columns center">
    <button type="submit" name="print" class="large button palette-Defecto bg">
        <i class="las la-filter la-2x"></i><span>Imprimir</span>
    </button>
    <input type="hidden" name="fecha_in" id="fecha_in" value="<?php echo $fecha_i?>" />
    <!--input type="hidden" name="fecha_fi" value="<?php echo $fecha_f?>" /-->
    <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $id_usuario?>" />

  </div>
  <?= form_close(); ?>
</div>
<div class="row">
    <div class="large-11 large-centered columns">
        <?php $this->load->view('general/layout/message') ?>

        <div class="box no-shadow">
            <div class="box-header panel palette-Defecto bg">
                <h3 class="box-title palette-White"><i class="las la-th-list la-2x"></i>
                    <span><?= lang('reporte.monitoreo') ?></span>
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
                          <th>Temas</th>
                          <?php foreach ($medios as $medio){?>
                            <th><?= $medio->nombre?></th>

                          <?php }?>
                          <?php foreach($lis_tendencias as $tenden){?>
                            <th><?= $tenden->nombre_tendencia?></th>

                          <?php }?>
                          <th>TOTAL</th>
                          <th>%</th>
                      </tr>
                    </thead>
                    <tbody>
										<?php $numero = 1; $total = 0;?>
										<?php foreach($temas as $tema){
                    $cont_total_fila = 0;
                    $ten_total_fila = 0;
											//$proyecto = $this->main->getField('proyecto', 'descripcion', array('id_proyecto'=>$contrato->id_proyecto));
											?>
											<tr>
												<td><?php echo $numero ?></td>
												<td><?php echo $tema->tema?></td>
                        <?php

                        foreach($medios as $medio){
                          if($id_usuario > 0){
                            $query_i = "select count(detalle_medio.id_nota) as contador
              							from detalle_medio
              							left join recurso on recurso.id_recurso = detalle_medio.id_recurso
              							left join nota  on nota.id_nota = detalle_medio.id_nota
              							 left join tema t on t.id_tema =nota.id_tema
              							where nota.id_estado=1 and
              							nota.fecha_registro > '".$fecha_i." 00:00:00' AND nota.fecha_registro <= '".$fecha_i." 23:59:59' AND detalle_medio.id_usuario = '$id_usuario' AND t.tema= '$tema->tema' and nombre = '$medio->nombre'";

                          }
                          else{
                            $query_i = "select count(detalle_medio.id_nota) as contador
              							from detalle_medio
              							left join recurso on recurso.id_recurso = detalle_medio.id_recurso
              							left join nota  on nota.id_nota = detalle_medio.id_nota
              							 left join tema t on t.id_tema =nota.id_tema
              							where nota.id_estado=1 and
              							nota.fecha_registro > '".$fecha_i." 00:00:00' AND nota.fecha_registro <= '".$fecha_i." 23:59:59' AND t.tema= '$tema->tema' and nombre = '$medio->nombre'";
                          }
                          $consulta = $this->db->query($query_i);
                          $listas_contador = $consulta->result();
                          //print_r($listas_contador);
                            //if(isset($listas_contador->contador))?>
                          <td><?php echo $listas_contador[0]->contador?></td>
                          <?php
                            $cont_total_fila = $cont_total_fila + $listas_contador[0]->contador;
                         }
                       ?>

												<?php $numero++; ?>
                        <?php foreach ($lis_tendencias as $tenden){
                          if($id_usuario > 0){
                            $query_t = "select count(detalle_medio.id_nota) as contador_tenden
                            from detalle_medio
                            left join tendencia on tendencia.id_tendencia = detalle_medio.id_tendencia
                            left join nota  on nota.id_nota = detalle_medio.id_nota
                             left join tema t on t.id_tema =nota.id_tema
                            where nota.id_estado=1 and
                            nota.fecha_registro > '".$fecha_i." 00:00:00' AND nota.fecha_registro <= '".$fecha_i." 23:59:59' AND t.tema= '$tema->tema' and tendencia.nombre_tendencia = '$tenden->nombre_tendencia' AND detalle_medio.id_usuario = $id_usuario";

                          }else{
                            $query_t = "select count(detalle_medio.id_nota) as contador_tenden
                            from detalle_medio
                            left join tendencia on tendencia.id_tendencia = detalle_medio.id_tendencia
                            left join nota  on nota.id_nota = detalle_medio.id_nota
                             left join tema t on t.id_tema =nota.id_tema
                            where nota.id_estado=1 and
                            nota.fecha_registro > '".$fecha_i." 00:00:00' AND nota.fecha_registro <= '".$fecha_i." 23:59:59' AND t.tema= '$tema->tema' and tendencia.nombre_tendencia = '$tenden->nombre_tendencia'";
                          }
                        $consulta = $this->db->query($query_t);
                        $tend_contador = $consulta->result();?>

                          <td><?php echo $tend_contador[0]->contador_tenden?></td>
                        <?php $ten_total_fila = $ten_total_fila + $tend_contador[0]->contador_tenden;
                      }?>


                        <td><?php echo $cont_total_fila?></td>

                        <?php $total = $total + $listas_contador[0]->contador;

                        $porcentaje =number_format(($cont_total_fila * 100) / $tot,2,".","");
                      ?>
                        <td><?php echo $porcentaje.' %'?></td>
                        </tr>
												<?php
                        if($porcentaje > $porcentaje_mayor){
                          $porcentaje_mayor = $porcentaje;
                          $id_tema_popular =  $tema->id_tema;
                          $tema_popular =  $tema->tema;
                        }
                        else{
                          $porcentaje_mayor = $porcentaje_mayor;
                          //$tema_popular =  $tema->tema;
                        }

                      } ?>
                        <tr>
                          <td colspan="2" aling="center"><b><?php echo 'Total'?></b></td>
                          <?php foreach($medios as $medio){
                            if($id_usuario > 0){
                              $query_medios = "select count(detalle_medio.id_nota) as contador
                              from detalle_medio
                              left join nota  on nota.id_nota = detalle_medio.id_nota
                              where nota.id_estado=1 and
                              nota.fecha_registro > '".$fecha_i." 00:00:00' AND nota.fecha_registro <= '".$fecha_i." 23:59:59' AND detalle_medio.id_recurso = '$medio->id_recurso' AND detalle_medio.id_usuario = $id_usuario";

                            }
                            else{
                              $query_medios = "select count(detalle_medio.id_nota) as contador
                              from detalle_medio
                              left join nota  on nota.id_nota = detalle_medio.id_nota
                              where nota.id_estado=1 and
                              nota.fecha_registro > '".$fecha_i." 00:00:00' AND nota.fecha_registro <= '".$fecha_i." 23:59:59' AND detalle_medio.id_recurso = '$medio->id_recurso'";
                            }
                            $consulta = $this->db->query($query_medios);
                            $contador_medios = $consulta->result();
                            ?>
                            <td><?php echo $contador_medios[0]->contador?></td>

                            <?php } ?>
                            <?php foreach($lis_tendencias as $tend){
                              if($id_usuario > 0){
                                $query_tendencias = "select count(detalle_medio.id_nota) as contador_t
                                from detalle_medio
                                left join nota  on nota.id_nota = detalle_medio.id_nota
                                where nota.id_estado=1 and
                                nota.fecha_registro > '".$fecha_i." 00:00:00' AND nota.fecha_registro <= '".$fecha_i." 23:59:59' AND detalle_medio.id_tendencia = $tend->id_tendencia AND detalle_medio.id_usuario = $id_usuario";

                              }
                              else{
                                $query_tendencias = "select count(detalle_medio.id_nota) as contador_t
                                from detalle_medio
                                left join nota  on nota.id_nota = detalle_medio.id_nota
                                where nota.id_estado=1 and
                                nota.fecha_registro > '".$fecha_i." 00:00:00' AND nota.fecha_registro <= '".$fecha_i." 23:59:59' AND detalle_medio.id_tendencia = $tend->id_tendencia";
                              }

                              $consulta = $this->db->query($query_tendencias);
                              $contador_tendendecia = $consulta->result();
                              ?>
                              <td><?php echo $contador_tendendecia[0]->contador_t?></td>

                              <?php } ?>
                            <td ><b><?php echo $tot?></b></td>
                            <td ><b><?php echo '100 %'?></b></td>
                        </tr>
                    </tbody>
                  </table>

                  </div>
                  <div class="row">
                    <div class="large-12 large-centered columns">
                      <div class="box no-shadow">
                        <div class="box-header panel palette-Defecto bg">
                            <h3 class="box-title palette-White"><i class="las la-th-list la-2x"></i>
                                <span><?= lang('tematica.destacada') ?></span>
                            </h3>
                        </div>
                        <div class="box-body">

                          <?php if($id_usuario > 0){
                            $query_c = "select count(detalle_medio.id_nota) as cont,detalle_medio.id_nota,detalle_medio.id_nota, nota.detalle,t.tema
                            	from detalle_medio left join recurso on recurso.id_recurso = detalle_medio.id_recurso
                            	left join nota on nota.id_nota = detalle_medio.id_nota
                            	left join tema t on t.id_tema =nota.id_tema
                            	where nota.id_estado=1
                            	and nota.fecha_registro > '".$fecha_i." 00:00:00' AND nota.fecha_registro <= '".$fecha_i." 23:59:59' AND detalle_medio.id_usuario = $id_usuario group by detalle_medio.id_nota,detalle_medio.id_nota,nota.detalle,t.tema  order by cont DESC" ;

                          }
                          else{
                            $query_c = "select count(detalle_medio.id_nota) as cont,detalle_medio.id_nota,detalle_medio.id_nota, nota.detalle,t.tema
                            	from detalle_medio left join recurso on recurso.id_recurso = detalle_medio.id_recurso
                            	left join nota on nota.id_nota = detalle_medio.id_nota
                            	left join tema t on t.id_tema =nota.id_tema
                            	where nota.id_estado=1
                            	and nota.fecha_registro > '".$fecha_i." 00:00:00' AND nota.fecha_registro <= '".$fecha_i." 23:59:59' group by detalle_medio.id_nota,detalle_medio.id_nota,nota.detalle,t.tema  order by cont DESC" ;
                          }

                            $consulta = $this->db->query($query_c);
                            $lis_cont = $consulta->result();
                          ?>

                            <p><b><?php echo 'Tem&aacute;tica 1: ' .$lis_cont[0]->tema?> </b> <?php echo html_entity_decode($lis_cont[0]->detalle)?><br></p>
                            <?php if(!empty($lis_cont[1]->tema)){?>
                            <p><b><?php echo 'Tem&aacute;tica 2: ' .$lis_cont[1]->tema?> </b> <?php echo html_entity_decode($lis_cont[1]->detalle)?><br></p>
                          <?php }if(!empty($lis_cont[2]->tema)){?>
                            <p><b><?php echo 'Tem&aacute;tica 3: ' .$lis_cont[2]->tema?> </b> <?php echo html_entity_decode($lis_cont[2]->detalle)?><br></p>
                          <?php }if(!empty($lis_cont[3]->tema)){?>
                            <p><b><?php echo 'Tem&aacute;tica 4: ' .$lis_cont[3]->tema?> </b> <?php echo html_entity_decode($lis_cont[3]->detalle)?><br></p>
                          <?php }if(!empty($lis_cont[4]->tema)){?>
                            <p><b><?php echo 'Tem&aacute;tica 5: ' .$lis_cont[4]->tema?> </b> <?php echo html_entity_decode($lis_cont[4]->detalle)?></p>
                              <?php }?>
                        </div>
                      </div>
                  </div>
                </div>
                <div class="row">
                  <div class="large-12 large-centered columns">
                    <div class="box no-shadow">
                      <div class="box-header panel palette-Defecto bg">
                          <h3 class="box-title palette-White"><i class="las la-th-list la-2x"></i>
                              <span><?= lang('frecuencia.tematica') ?></span>
                          </h3>
                      </div>
                      <div class="box-body">
                        <div class="row">
                          <div class="large-12 columns">

                            <canvas id="pie-chart-tematica" width="600" height="450"></canvas>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                  <div class="large-5 columns">
                    <div class="box no-shadow">
                    <div class="box-header panel palette-Defecto bg">
                        <h3 class="box-title palette-White"><i class="las la-th-list la-2x"></i>
                            <span><?= lang('monitoreo.notas') ?></span>
                        </h3>
                    </div>
                    <div class="box-body">
                      <div class="row">
                        <table  class="display cell-border" style="width:100%">
                          <thead>
                            <tr>
                                <th colspan="3">MONITOREO DE NOTAS MUNICIPALES</th>
                            </tr>
                          </thead>
                          <tbody>
											  <?php $id_depend = 1; ?>
                        <?php
                          while($id_depend <= 3){

                            $where3['nota.id_estado'] = 1 ;
                            $where3['nota.fecha_registro >'] = $fecha_i.' 00:00:00';
                            $where3['nota.fecha_registro <='] =$fecha_i.' 23:59:59';
                            $where3['detalle_medio.id_tendencia ='] = $id_depend;
                            if($id_usuario > 0){
                              $where3['detalle_medio.id_usuario ='] = $id_usuario;
                            }

                            $listas_tendencia = $this->main->getListSelectJoin('detalle_medio', 'tendencia.nombre_tendencia ,count(detalle_medio.id_nota) as total', null, $where3, null, null, ['tendencia'=>'id_tendencia','nota'=>'id_nota'], ['tendencia.nombre_tendencia']);
                            foreach($listas_tendencia as $list){?>
                              <tr>
                                <td><?php echo $list->nombre_tendencia ?></td>
                                <td><?php echo $list->total ?></td>
                                <?php $conteo = $list->total;

                                $porcentaje = number_format(($conteo * 100) / $tot,2,".","");?>
                                <td><?php echo $porcentaje.' %'?></td>
                              </tr>

                          <?php }?>
                          <?php $id_depend++; ?>

                        <?php }?>
                          <tr>
                          	<td>TOTAL</td>
                            <td><b><?php echo $tot?></b></td>
                            <td><b><?php echo '100 %'?></b></td>
                          </tr>
                        </tbody>
                      </table>
                  </div>
                </div>
              </div>

            </div>


            <div class="large-7 columns">
              <div class="box no-shadow">
                <div class="box-header panel palette-Defecto bg">
                    <h3 class="box-title palette-White"><i class="las la-th-list la-2x"></i>
                        <span><?= lang('notas.alcalde') ?></span>
                    </h3>
                </div>
                <div class="box-body">
                  <div class="row">
                    <div class="large-12">
                        <canvas id="bar-chart" width="800" height="450"></canvas>
                    </div>
                </div>
                </div>
              </div>
            </div>
              <?php } else{?>
                <div class="row" id="btn_print" style="display: none;">
                <?php } ?>
        </div>
    </div>
</div>
<?php $this->load->view('normal/reporte/js/graficos') ?>
<?php $this->load->view('normal/reporte/js/tematica') ?>
<?php $this->load->view('general/layout/footer') ?>
