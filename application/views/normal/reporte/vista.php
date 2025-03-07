<?php
$sep_fech = explode('-',$fecha_i);
if($sep_fech[1]== '01'){
  $mes ='Enero';
}
else if($sep_fech[1]== '02'){
  $mes ='Febrero';
}
else if($sep_fech[1]== '03'){
  $mes ='Marzo';
}
else if($sep_fech[1]== '04'){
  $mes ='Abril';
}
else if($sep_fech[1]== '06'){
  $mes ='Junio';
}
else if($sep_fech[1]== '07'){
  $mes ='Julio';
}
else if($sep_fech[1]== '08'){
  $mes ='Agosto';
}
else if($sep_fech[1]== '09'){
  $mes ='Septiembre';
}
else if($sep_fech[1]== '10'){
  $mes ='Octubre';
}
else if($sep_fech[1]== '11'){
  $mes ='Noviembre';
}
else if($sep_fech[1]== '12'){
  $mes ='Diciembre';
}
/*$sep_fec_f = explode('-',$fecha_f);
if($sep_fec_f[1]== '01'){
  $mes_f ='Enero';
}
else if($sep_fec_f[1]== '02'){
  $mes_f ='Febrero';
}
else if($sep_fec_f[1]== '03'){
  $mes_f ='Marzo';
}
else if($sep_fec_f[1]== '04'){
  $mes_f ='Abril';
}
else if($sep_fec_f[1]== '06'){
  $mes_f ='Junio';
}
else if($sep_fec_f[1]== '07'){
  $mes_f ='Julio';
}
else if($sep_fec_f[1]== '08'){
  $mes_f ='Agosto';
}
else if($sep_fec_f[1]== '09'){
  $mes_f ='Septiembre';
}
else if($sep_fec_f[1]== '10'){
  $mes_f ='Octubre';
}
else if($sep_fec_f[1]== '11'){
  $mes_f ='Noviembre';
}
else if($sep_fec_f[1]== '12'){
  $mes_f ='Diciembre';
}*/

?>
<div align="center">
    <h3><span>
      <?php if($id_usuario > 0){
       echo 'Reporte Monitoreo de fecha : '.$sep_fech[2]. ' de '.$mes.' del '.$sep_fech[0] .' del Funcionario: '. $this->session->sistema->nombre_completo;
      
      }else{
        echo 'Reporte Monitoreo de fecha : '.$sep_fech[2]. ' de '.$mes.' del '.$sep_fech[0];
      }?>
    </span></h3>
</div>
  <table border="1" width="100%">
    <thead>
      <tr>
          <th width="2%"><b>#</b></th>
          <th width="18%"><b>TEMAS</b></th>
          <?php $porcentaje_mayor= 0;
          foreach ($medios as $medio){?>
          <th width="5%"><b><?= $medio->nombre?></b></th>

          <?php }?>
          <?php foreach ($lis_tendencias as $tenden){?>
            <th width="6%"><b><?= $tenden->nombre_tendencia?></b></th>

          <?php }?>
          <th width="4.5%"><b>TOTAL</b></th>
          <th width="4.5%"><b> % </b></th>
      </tr>
    </thead>
    <tbody>
		<?php $numero = 1; $total = 0;?>
		<?php foreach($temas as $tema){
    $cont_total_fila = 0;
    $ten_total_fila = 0;
			?>
			<tr>
				<td width="2%"><?php echo $numero ?></td>
				<td width="18%"><?php echo $tema->tema?></td>
        <?php

        foreach($medios as $medio){
          if($id_usuario > 0){
            $query_i = "select count(detalle_medio.id_nota) as contador
  					from detalle_medio
  					left join recurso on recurso.id_recurso = detalle_medio.id_recurso
  					left join nota  on nota.id_nota = detalle_medio.id_nota
  					 left join tema t on t.id_tema =nota.id_tema
  					where nota.id_estado=1 and
  					nota.fecha_registro > '".$fecha_i." 00:00:00' AND nota.fecha_registro <= '".$fecha_i." 23:59:59' AND detalle_medio.id_usuario = $id_usuario AND t.tema= '$tema->tema' and nombre = '$medio->nombre'";

          }else{
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
          <td width="5%"><?php echo $listas_contador[0]->contador?></td>
          <?php
            $cont_total_fila = $cont_total_fila + $listas_contador[0]->contador;
         }?>

				<?php $numero++; ?>
        <?php foreach ($lis_tendencias as $tenden){
          if($id_usuario > 0){
            $query_t = "select count(detalle_medio.id_nota) as contador_tenden
            from detalle_medio
            left join tendencia on tendencia.id_tendencia = detalle_medio.id_tendencia
            left join nota  on nota.id_nota = detalle_medio.id_nota
             left join tema t on t.id_tema =nota.id_tema
            where nota.id_estado=1 and
            nota.fecha_registro > '".$fecha_i." 00:00:00' AND nota.fecha_registro <= '".$fecha_i." 23:59:59' AND detalle_medio.id_usuario = $id_usuario AND t.tema= '$tema->tema' and tendencia.nombre_tendencia = '$tenden->nombre_tendencia'";

      }
      else{
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

          <td width="6%"><?php echo $tend_contador[0]->contador_tenden?></td>
        <?php $ten_total_fila = $ten_total_fila + $tend_contador[0]->contador_tenden;
      }?>


        <td width="4.5%"><?php echo $cont_total_fila?></td>

        <?php $total = $total + $listas_contador[0]->contador;

        $porcentaje = number_format(($cont_total_fila * 100) / $tot,2,".","");
      ?>
        <td width="4.5%"><?php echo $porcentaje.' %'?></td>
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
          <td colspan="2" align="center"><b><?php echo 'Total'?></b></td>
          <?php foreach($medios as $medio){
            if($id_usuario > 0){
              $query_medios = "select count(detalle_medio.id_nota) as contador
              from detalle_medio
              left join nota  on nota.id_nota = detalle_medio.id_nota
              where nota.id_estado=1 and
              nota.fecha_registro > '".$fecha_i." 00:00:00' AND nota.fecha_registro <= '".$fecha_i." 23:59:59' AND detalle_medio.id_usuario=$id_usuario AND detalle_medio.id_recurso = '$medio->id_recurso'";

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
                nota.fecha_registro > '".$fecha_i." 00:00:00' AND nota.fecha_registro <= '".$fecha_i." 23:59:59' AND detalle_medio.id_usuario = $id_usuario AND detalle_medio.id_tendencia = '$tend->id_tendencia'";
              }
              else{
                $query_tendencias = "select count(detalle_medio.id_nota) as contador_t
                from detalle_medio
                left join nota  on nota.id_nota = detalle_medio.id_nota
                where nota.id_estado=1 and
                nota.fecha_registro > '".$fecha_i." 00:00:00' AND nota.fecha_registro <= '".$fecha_i." 23:59:59' AND detalle_medio.id_tendencia = '$tend->id_tendencia'";

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
  <div class="box-header panel palette-Defecto bg">
      <h3>
          <span>Temáticas Destacadas </span>
      </h3>
  </div>
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

    <p><b><?php echo 'Temática 1: ' .$lis_cont[0]->tema?> </b> <?php echo html_entity_decode($lis_cont[0]->detalle)?><br></p>
    <?php if(!empty($lis_cont[1]->tema)){?>
    <p><b><?php echo 'Temática 2: ' .$lis_cont[1]->tema?> </b> <?php echo html_entity_decode($lis_cont[1]->detalle)?><br></p>
  <?php }if(!empty($lis_cont[2]->tema)){?>
    <p><b><?php echo 'Temática 3: ' .$lis_cont[2]->tema?> </b> <?php echo html_entity_decode($lis_cont[2]->detalle)?><br></p>
  <?php }if(!empty($lis_cont[3]->tema)){?>
    <p><b><?php echo 'Temática 4: ' .$lis_cont[3]->tema?> </b> <?php echo html_entity_decode($lis_cont[3]->detalle)?><br></p>
  <?php }if(!empty($lis_cont[4]->tema)){?>
    <p><b><?php echo 'Temática 5: ' .$lis_cont[4]->tema?> </b> <?php echo html_entity_decode($lis_cont[4]->detalle)?></p>
      <?php }?>
