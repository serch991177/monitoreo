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
$sep_fec_f = explode('-',$fecha_f);
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
}

?>
<div align="center">
    <h3><span>
      <?php if($fecha_i == $fecha_f){
       echo 'Reporte por Funcionario de fecha : '.$sep_fech[2]. ' de '.$mes.' del '.$sep_fech[0] ;
      }
      else{
        echo 'Reporte por Funcionario de fecha: '.$sep_fech[2]. ' de '.$mes.' del '.$sep_fech[0].' al ' .$sep_fec_f[2]. ' de '.$mes_f.' del '.$sep_fec_f[0] ;
      }?>
    </span></h3>
</div>
  <table border="1" width="100%">

    <thead>
      <tr>
          <th width="3%"><b>#</b></th>
          <th width="21%"><b>FUNCIONARIO</b></th>
          <?php
          foreach ($medios as $medio){?>
          <th width="10%"><b><?= $medio->nombre?></b></th>

          <?php }?>
            <th width="5%"><b>TOTAL</b></th>
            <th width="5%"><b> % </b></th>
      </tr>
    </thead>
    <tbody>
      <?php $numero = 1; $total = 0;?>
      <?php foreach($funcionarios as $funcionario){
      $cont_total_fila = 0;
      $ten_total_fila = 0;
      ?>
      <tr>
        <td width="3%"><?php echo $numero ?></td>
        <td width="21%"><?php echo $funcionario->nombre_completo?></td>
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
          <td width="10%"><?php echo $listas_contador[0]->contador?></td>
          <?php
            $cont_total_fila = $cont_total_fila + $listas_contador[0]->contador;
         }?>




        <td width="5%"><?php echo $cont_total_fila?></td>

        <?php $total = $total + $listas_contador[0]->contador;

        $porcentaje =number_format(($cont_total_fila * 100) / $tot,2,".","");
      ?>
        <td width="5%"><?php echo $porcentaje.' %'?></td>
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
