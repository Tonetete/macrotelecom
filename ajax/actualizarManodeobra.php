<?php
 //require_once('')
 include($_SERVER['DOCUMENT_ROOT'].'/macrotelecomnuevo/functions/datosConexion.php');
 include_once($_SERVER['DOCUMENT_ROOT'].'/macrotelecomnuevo/functions/consultas.php');
 
 

 //estos valores los recibo por GET
 if(isset($_GET['fecha']) && isset($_GET['fechaini']) && isset($_GET['fechafin']) && isset($_GET['emp']) && isset($_GET['salario'])) {
     if($_GET['fechaini']=="" && $_GET['fechafin']=="") {
         $res = mysql_query("SELECT day(last_day('".$_GET['fecha']."-01'))");
         $dia = mysql_result($res, 0);
         $fechaini = $_GET['fecha']."-01 23:59:59";
         $fechafin = $_GET['fecha']."-".$dia." 00:00:00";
     }     
     
     else {
         
         $fechaini = $_GET['fechaini']." 00:00:00";         
         $fechaini = preg_replace('#(\d{2})/(\d{2})/(\d{4})\s(.*)#', '$3-$2-$1 $4', $fechaini);
         
         $fechafin = $_GET['fechafin']." 00:00:00";         
         $fechafin = preg_replace('#(\d{2})/(\d{2})/(\d{4})\s(.*)#', '$3-$2-$1 $4', $fechafin);
     }
     $salario = $_GET['salario'];
     
     
     // Insertamos la retribución en la tabla retribuciones
     
     $queryRetrib = "INSERT INTO retribucion (idAgente, fechaInicio, fechaFin, salario, pagado) 
                                       VALUES(".$_GET['emp'].", '".$fechaini."', '".$fechafin."',".$salario.", 0)";
     $resRetrib = mysql_query($queryRetrib);
     
     // Actualizamos la tabla conceptos para el valor de mano de obtra
     
     $resObra = mysql_query("SELECT importe FROM conceptos WHERE nombre='MANO DE OBRA'");
     $importe = mysql_result($resObra, 0);
     $importe-=$salario;
     
     $queryUpdImporte = "UPDATE conceptos SET importe=".$importe." WHERE nombre='MANO DE OBRA'";
     $resImporte = mysql_query($queryUpdImporte);
     
     
 }

 
?>
