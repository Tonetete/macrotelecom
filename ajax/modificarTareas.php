<?php
 //require_once('')
 include($_SERVER['DOCUMENT_ROOT'].'/macrotelecomnuevo/functions/datosConexion.php');
 include_once($_SERVER['DOCUMENT_ROOT'].'/macrotelecomnuevo/functions/consultas.php');
 
 

 //estos valores los recibo por GET
 if(isset($_GET['id'])&&(isset($_GET['fecha']))&&(isset($_GET['inicio']))&&(isset($_GET['fin']))&&
         (isset($_GET['tarea']))) {
  
     $dateIni = $_GET['fecha']." ".$_GET['inicio'].":00";
     $dateIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})\s(.*)#', '$3-$2-$1 $4', $dateIni);
     $dateFin = $_GET['fecha']." ".$_GET['fin'].":00";
     $dateFin = preg_replace('#(\d{2})/(\d{2})/(\d{4})\s(.*)#', '$3-$2-$1 $4', $dateFin);
     
     // Obtenemos el id del tipo de tarea
     //$idTipoTarea = 0;
     $res = mysql_query("SELECT idTipoTarea from TipoTarea WHERE nombre='".$_GET['tarea']."'");
     $idTipoTarea = mysql_result($res,0);
     
     $resTarea = mysql_query("UPDATE Tareas SET fechaTarea='".$dateIni."' ,
                               horaInicio='".$dateIni."', horaFin='".$dateFin."', 
                               idTipoTarea=".$idTipoTarea." WHERE idTarea=".$_GET['id']."");
     
     // Realizamos de nuevo la consulta para modificar la fila resultante, en este caso los posibles valores a
     // mostrar son los que actualizamos y buscaremos por el id de tarea
     
     $filaMod = mysql_query("SELECT TIMEDIFF(t.horaFin,t.horaInicio) AS 'Intervalo', 
                            (tipo.precioHora*(HOUR(TIMEDIFF(t.horaFin,t.horaInicio)))+(MINUTE(TIMEDIFF(t.horaFin,t.horaInicio))*tipo.precioHora)/60) AS 'Coste', 
                            tipo.precioTarea*t.unidades AS 'Comision'
                            FROM Agentes a, Tareas t, TipoTarea tipo
                            WHERE tipo.idTipoTarea=t.idTipoTarea AND t.idTarea =".$_GET['id']."");
     
     while($row = mysql_fetch_array($filaMod)) {
     $x=0;
     for($i=0; $i<mysql_num_fields($filaMod);$i++) {   
         
         if(mysql_field_name($filaMod,$i)=='Comision'||mysql_field_name($filaMod,$i)=='Coste') {
                $registros[$x][mysql_field_name($filaMod,$i)] = curr_format('EUR', $row[$i]);
           }
         else {
           $registros[$x][mysql_field_name($filaMod,$i)] = $row[$i];          
           }
       }
      $x++;
     }
     echo json_encode($registros);
     
 }

 
?>
