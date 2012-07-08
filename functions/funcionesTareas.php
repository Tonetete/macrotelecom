<?php

require_once('datosConexion.php');


function insertarFechas() {
    $res = "SELECT min(fechaTarea) AS 'minDate',max(fechaTarea) AS 'maxDate'
from Tareas";
    $res = mysql_query($res);
    
    while($row = mysql_fetch_array($res)) {
        $minDate = $row['minDate'];
        $maxDate = $row['maxDate'];
    }
    
    $resMinMonth = mysql_query("SELECT MONTH('".$minDate."')");
    $resMinYear = mysql_query("SELECT YEAR('".$minDate."')");
    
    
    $resMinMonth = mysql_result($resMinMonth,0);
    $resMinYear = mysql_result($resMinYear,0);    
    
    $resMaxMonth = mysql_query("SELECT MONTH('".$maxDate."')");
    $resMaxYear = mysql_query("SELECT YEAR('".$maxDate."')");
    
    $resMaxMonth = mysql_result($resMaxMonth,0);
    $resMaxYear = mysql_result($resMaxYear,0);  
  
    
    $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio",
                   "Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    
    
    echo '<select id="fechaTareas">';
    echo '<option value="">Todos</option>';
    
    for($i=$resMaxYear; $i>=$resMinYear; $i--) {
        
        if($i==$resMaxYear){
            for($j=$resMaxMonth;$j>=1;$j--) {
                if($j<10) {
                    echo "<option value='".$i."-0".$j."'>".$i." ".$meses[$j-1]."</option>";
                }
                else {
                    echo "<option value='".$i."-".$j."'>".$i." ".$meses[$j-1]."</option>";
                }
            }   
        }
        
        else if($i==$resMinYear){
            for($j=12;$j>=$resMinMonth;$j--) {
                if($j<10) {
                    echo "<option value='".$i."-0".$j."'>".$i." ".$meses[$j-1]."</option>";
                }
                else {
                    echo "<option value='".$i."-".$j."'>".$i." ".$meses[$j-1]."</option>";
                }
            }
        }
        
        else {
            for($j=12;$j>=1;$j--) {
                if($j<10) {
                    echo "<option value='".$i."-0".$j."'>".$i." ".$meses[$j-1]."</option>";
                }
                else {
                    echo "<option value='".$i."-".$j."'>".$i." ".$meses[$j-1]."</option>";
                }
            }
        }
    }
    
    echo'</select>';
    
}

function listarAgentes() {
    
    $res ="SELECT nombre FROM Perfil ORDER BY nombre ASC;";
    $res = mysql_query($res);
    
    echo'<select id="tipoAgente">';
    echo "<option value=''>Todos</option>";
      while($row = mysql_fetch_array($res)) {
        echo "<option value='".$row[0]."'>".$row[0]."</option>";
    }                                                              
    echo '</select>';
}


// Listamos los empleados, la opción es pasada para imprimirlo como tarea o filtro, sólo cambia el mensaje
// del valor por defecto

function listarEmpleados($tipo,$opcion) {
    $res ="SELECT idAgente, nombre FROM Agentes ORDER BY nombre ASC;";
    $res = mysql_query($res);
    
    if($tipo=='tarea'){
        echo '<select id="empleadoTarea">';
    }
    else if($tipo=='listar') {
        echo '<select id="empleado">';
        echo '<option value="">'.$opcion.'</option>';
    }
    
    
    while($row = mysql_fetch_array($res)) {
        echo '<option value="'.$row[0].'">'.$row[1].'</option>';
    }
    
    echo'</select>';
}

function listarTareas() {
    $res ="SELECT nombre FROM TipoTarea ORDER BY nombre ASC;";
    $res = mysql_query($res);
    
    echo '<select id="tareas">';
    
    while($row = mysql_fetch_array($res)) {
        echo '<option>'.$row[0].'</option>';
    }
    
    echo'</select>';
}


?>