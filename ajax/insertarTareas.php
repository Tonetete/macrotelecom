<?php
 //require_once('')
 include($_SERVER['DOCUMENT_ROOT'].'/macrotelecomnuevo/functions/datosConexion.php');
 include_once($_SERVER['DOCUMENT_ROOT'].'/macrotelecomnuevo/functions/consultas.php');
 
 

 //estos valores los recibo por GET
 if(isset($_GET['user'])&&(isset($_GET['fecha']))&&(isset($_GET['horaini']))&&(isset($_GET['horafin']))&&
         (isset($_GET['tarea']))&&(isset($_GET['uni']))) {
  
     $resTarea = mysql_query("SELECT idTipoTarea FROM TipoTarea WHERE nombre='".$_GET['tarea']."'");
     $tarea = mysql_result($resTarea,0);
     $resUser = mysql_query("SELECT idAgente FROM Agentes WHERE nombre='".$_GET['user']."'");
     $user = mysql_result($resUser,0);
     $dateIni = $_GET['fecha']." ".$_GET['horaini'].":00";
     $dateIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})\s(.*)#', '$3-$2-$1 $4', $dateIni);
     $dateFin = $_GET['fecha']." ".$_GET['horafin'].":00";
     $dateFin = preg_replace('#(\d{2})/(\d{2})/(\d{4})\s(.*)#', '$3-$2-$1 $4', $dateFin);
     $query = "INSERT INTO Tareas (idTipoTarea,idAgente,fechaTarea,horaInicio,horaFin,observaciones,unidades)
               VALUES(".$tarea.",".$user.",'".$dateIni."','".$dateIni."','".$dateFin."','',".$_GET['uni'].");";
     mysql_query($query);
     $id = mysql_insert_id();
     
     echo json_encode($id);
     
 }
 
?>
