<?php

require_once('DBConnection.inc.php');
require_once('./functions/consultas.php');


$db = new DbConnection('localhost','root','','macrotelecom');
$color_row=array('#cccccc', 'lightblue');
$ind_color=0;

switch (@$_REQUEST['action'])
{
    case "consultar" :
    $db->connect();
      $data =  $db->getAllRows("SELECT p.nombre AS 'TipoAgente', a.nombre AS 'Nombre', 
DATE_FORMAT(t.horaInicio,'%d-%m-%Y') AS 'Fecha', DATE_FORMAT(t.horaInicio,'%H:%i:%s') AS 'Inicio',
DATE_FORMAT(t.horaFin,'%H:%i:%s') AS 'Fin', TIMEDIFF(t.horaFin,t.horaInicio) AS 'Intervalo',
tipo.nombre AS 'TipoTarea', (tipo.precioHora*(HOUR(TIMEDIFF(t.horaFin,t.horaInicio)))+(MINUTE(TIMEDIFF(t.horaFin,t.horaInicio))*tipo.precioHora)/60) AS 'Coste',  '-'   AS 'Comision'
FROM Agentes a, Tareas t, TipoTarea tipo, Perfil p
WHERE t.idAgente = a.idAgente AND t.idTipoTarea=tipo.idTipoTarea AND tipo.computable='S'
AND tipo.precioHora>0.00 AND p.idPerfil=a.idPerfil AND p.nombre = '".$_POST['query']."'
ORDER BY t.horaInicio DESC;");
    $db->disconnect();    
   
	$table = '<table id=\"tab\" style=\"border: solid 1px black;\">
               <tr>
               <td>TipoAgente</td>
                <td>Nombre</td>
                <td>Fecha</td>
                <td>Inicio</td>
                <td>Fin</td>
                <td>Intervalo</td>
                <td>TipoTarea</td>
                <td>Coste</td>
                <td>Comision</td>
              </tr> \n';
;

 foreach($data as $i)
   {
       $ind_color++;
       $ind_color %= 2;
 $table .= " <tr bgcolor=${color_row[$ind_color]}>";
        $table .="<td>".$i['TipoAgente']."</td>";         
        $table .="<td>".$i['Nombre']."</td>";
        $table .="<td>".$i['Fecha']."</td>";
        $table .="<td>".$i['Inicio']."</td>";
        $table .="<td>".$i['Fin']."</td>";
	      $table .="<td>".$i['Intervalo']."</td>";
	      $table .="<td>".$i['TipoTarea']."</td>";
	      $table .="<td>".$i['Coste']."</td>";
	      $table .="<td>".$i['Comision']."</td>";
        $table .="</tr>";
    }
         $table .="</table>";
      //echo"<pre>"; var_dump($i); echo"</pre>";    
      //var_dump($table);
    echo json_encode($table);  
        
    exit;
          
}



?>