<?php
 include($_SERVER['DOCUMENT_ROOT'].'/macrotelecomnuevo/functions/datosConexion.php');
 include_once($_SERVER['DOCUMENT_ROOT'].'/macrotelecomnuevo/functions/consultas.php');
 $RegistrosAMostrar=25;

 //estos valores los recibo por GET
 if(isset($_GET['pag'])&&(isset($_GET['agente'])&&isset($_GET['fecha'])&&isset($_GET['emp'])&&isset($_GET['fechaini'])&&isset($_GET['fechafin']))){
  $RegistrosAEmpezar=($_GET['pag']-1)*$RegistrosAMostrar;
  $PagAct=$_GET['pag'];
  //caso contrario los iniciamos
 }else{
  $RegistrosAEmpezar=0;
  $PagAct=1;
 }

 if(isset($_GET['fecha'])&&isset($_GET['agente'])&&isset($_GET['emp'])&&isset($_GET['fechaini'])&&isset($_GET['fechafin'])) {     
      $agente = $_GET['agente'];   
      $fecha = $_GET['fecha'];
      $empleado = $_GET['emp'];
      if($_GET['fechaini']!="" && $_GET['fechafin']!="") {
            $fechaini = preg_replace('#(\d{2})/(\d{2})/(\d{4})\s(.*)#', '$3-$2-$1 $4', $_GET['fechaini']." 00:00:00");
            $fechafin = preg_replace('#(\d{2})/(\d{2})/(\d{4})\s(.*)#', '$3-$2-$1 $4', $_GET['fechafin']." 00:00:00");      
      }
      
      $Resultado = mysql_query(consultarTareasLimit2($empleado, $fecha, $fechaini, $fechafin, $agente,$RegistrosAEmpezar,$RegistrosAMostrar));
      $NroRegistros = mysql_num_rows(mysql_query(consultarTareas2($empleado, $fecha, $fechaini, $fechafin, $agente)));
             
   }
   else {
       $Resultado = mysql_query(consultarTareasLimit2("", "", "", "", "",$RegistrosAEmpezar,$RegistrosAMostrar));
       $NroRegistros = mysql_num_rows(mysql_query(consultarTareas2("", "", "", "", "")));
   }
 

 $registros = array();
 $x=0;
 while($row = mysql_fetch_array($Resultado)) {
     
       for($i=0; $i<mysql_num_fields($Resultado);$i++) {
           if(mysql_field_name($Resultado,$i)=='Comision'||mysql_field_name($Resultado,$i)=='Coste') {
                $registros[$x][mysql_field_name($Resultado,$i)] = curr_format('EUR', $row[$i]);                
           }
           else {
                $registros[$x][mysql_field_name($Resultado,$i)] = $row[$i];
           }
       }
   $x++;    
}     


// Si el campo empleados no es nulo es que se ha seleccionado un empleado, procedemos a hacer
// una consulta para calcular sus retribuciones

if($empleado!="") {
    $resultadoRetrib = mysql_query(consultarTareas2($empleado, $fecha, $fechaini, $fechafin, $agente));
    
    while($row = mysql_fetch_array($resultadoRetrib)) {
     
       for($i=0; $i<mysql_num_fields($resultadoRetrib);$i++) {
           if(mysql_field_name($resultadoRetrib,$i)=='Comision'||mysql_field_name($resultadoRetrib,$i)=='Coste') {                
                $registros[0][total]+=$row[$i];
           }
       }   
   }     
}

// Total a retribuir al empleado 
$total = $registros[0][total];
$registros[0][total] = curr_format('EUR', $total);

//******--------determinar las páginas---------******//
 $registros[0][numRegistros] = $NroRegistros;
 $registros[0][pagAnterior] = $PagAnt=$PagAct-1;
 $registros[0][pagSiguiente] = $PagSig=$PagAct+1;
 $PagUlt=$NroRegistros/$RegistrosAMostrar;

 //verificamos residuo para ver si llevará decimales
 $Res=$NroRegistros%$RegistrosAMostrar;
 // si hay residuo usamos funcion floor para que me
 // devuelva la parte entera, SIN REDONDEAR, y le sumamos
 // una unidad para obtener la ultima pagina
 if($Res>0) $PagUlt=floor($PagUlt)+1;
  $registros[0][pagUltima] = $PagUlt;
 echo json_encode($registros);

 
?>
