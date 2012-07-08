<?php

 include($_SERVER['DOCUMENT_ROOT'].'/macrotelecomnuevo/functions/datosConexion.php');
 include_once($_SERVER['DOCUMENT_ROOT'].'/macrotelecomnuevo/functions/consultas.php');
 
 

 //estos valores los recibo por GET
 if(isset($_GET['id'])) {
     
     // Obtenemos el id del tipo de tarea
     $res = mysql_query("DELETE FROM Tareas WHERE idTarea=".$_GET['id']."");
     mysql_close($db);
     
     
 }
 
 
?>
