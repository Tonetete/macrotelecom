<?php

include($_SERVER['DOCUMENT_ROOT'].'/macrotelecomnuevo/functions/datosConexion.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/macrotelecomnuevo/functions/consultas.php');



switch (@$_REQUEST['action'])
{
    case "consultar" :

      $data =  mysql_query(consultarTareasTiempoEmpleadosFiltrar($_POST['query']));

	$table = '<table>
                  <thead>
               <tr>
               <th>Tipo de Agente</th>
                <th>Nombre</th>
                <th>Fecha</th>
                <th>Inicio</th>
                <th>Fin</th>
                <th>Intervalo</th>
                <th>Tipo de Tarea</th>
                <th>Coste/Horas</th>
                <th>Coste/Comisiones</th>
              </tr>
              </thead>
              <tbody>';
;

 while($i = mysql_fetch_array($data, MYSQL_ASSOC))
   {
 $table .= " <tr>";
        $table .="<td>".$i['TipoAgente']."</td>";         
        $table .="<td>".$i['Nombre']."</td>";
        $table .="<td>".$i['Fecha']."</td>";
        $table .="<td>".$i['Inicio']."</td>";
        $table .="<td>".$i['Fin']."</td>";
	      $table .="<td>".$i['Intervalo']."</td>";
	      $table .="<td>".$i['TipoTarea']."</td>";
	      $table .="<td>".curr_format('EUR',$i['Coste'])."</td>";
	      $table .="<td>".curr_format('EUR',$i['Comision'])."</td>";
              $table .= '<td><img src="img/pencil.png" alt="Edit" /></td>';
	      $table .= '<td><input type="checkbox" name="delete[]" value="" /></td>';
        $table .="</tr>";
    }
         $table .="</tbody>";
         $table .="</table>";
      //echo"<pre>"; var_dump($i); echo"</pre>";    
    echo json_encode($table);  
        
    exit;
          
}


?>