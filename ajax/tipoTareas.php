<?php

include($_SERVER['DOCUMENT_ROOT'].'/macrotelecomnuevo/functions/datosConexion.php');
 include_once($_SERVER['DOCUMENT_ROOT'].'/macrotelecomnuevo/functions/consultas.php');

     $resTarea = mysql_query("SELECT idTipoTarea AS 'idTarea', nombre AS 'Nombre' FROM TipoTarea");
     
     $registros = array();
     $x=0;
     while($row = mysql_fetch_array($resTarea)) {

         for($i=0; $i<mysql_num_fields($resTarea);$i++) {              
                $registros[$x][mysql_field_name($resTarea,$i)] = $row[$i];              
            }
        $x++;    
     }    
     
     echo json_encode($registros);
     
?>
