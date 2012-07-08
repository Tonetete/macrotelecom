<?php

include('datosConexion.php');
require_once('calculos.php');


$consultaTareas = "SELECT t.idTarea AS 'idTarea', tipo.idTipoTarea AS 'idTipoTarea', p.nombre AS 'TipoAgente', a.nombre AS 'Nombre', 
DATE_FORMAT(t.horaInicio,'%d/%m/%Y') AS 'Fecha', DATE_FORMAT(t.horaInicio,'%H:%i') AS 'Inicio',
DATE_FORMAT(t.horaFin,'%H:%i') AS 'Fin', TIMEDIFF(t.horaFin,t.horaInicio) AS 'Intervalo',
tipo.nombre AS 'TipoTarea', (tipo.precioHora*(HOUR(TIMEDIFF(t.horaFin,t.horaInicio)))+(MINUTE(TIMEDIFF(t.horaFin,t.horaInicio))*tipo.precioHora)/60) AS 'Coste',  tipo.precioTarea*t.unidades   AS 'Comision'
FROM Agentes a, Tareas t, TipoTarea tipo, Perfil p
WHERE t.idAgente = a.idAgente AND t.idTipoTarea=tipo.idTipoTarea AND p.idPerfil=a.idPerfil ";

function comprobarUsuario($user, $password) {

	$password = sha1($password);
	$res = mysql_query('call verUsuarios()');
	$fila = mysql_fetch_array($res);
	echo $fila['nombre'];
	//$res = mysql_query('call '.$db.'.comprobarUsuario('.$user.','.$password.')');
	//$fila = mysql_fetch_array($res);
	//echo $fila['nombre'];
	/*if(mysql_num_rows($res)==1) {
		return true;
	}
	else {
		return false;
	}*/
}

function getIVA() {
    $res = mysql_query("SELECT valor from Tributar where nombre='iva'");
    return mysql_result($res,0);
}

function totalizadorIngresos() {
	$res = mysql_query('SELECT SUM(importe) FROM Conceptos WHERE Conceptos.importe >0');
	return mysql_result($res,0);
	
}

function totalizadorGastos() {
	$res = mysql_query('SELECT SUM(ABS(importe)) FROM Conceptos WHERE Conceptos.importe <0');
	return mysql_result($res,0);
	
}

function totalizadorBarras() {
	$res = mysql_query('SELECT nombre, importe FROM Conceptos;');
	// Por defecto la clase para nuestra barra sera azul
	// muestra los valores positivos y rojo para los negativos
		$colorBarra = "blue";
		$max = maxImporte();
		while ($row = mysql_fetch_array($res, MYSQL_NUM)) {
			if($row[1]<0){
				$colorBarra = "red";
				$valor = abs($row[1]);
			}
			else {
				$colorBarra = "blue";
				$valor = $row[1];
			}
			echo '<li name ="'.$valor.'"title="'.calcularValorBarra($max,$valor).'" class="'.$colorBarra.'">'.
				 '<span style="" class="title-bar">'.$row[0].'</span>'.
				 '<span class="bar"></span>'.
				 '<span class="percent"></span>'.
				 '</li>'; 
			}
}

function getDia( $timestamp = 0 ){
	$timestamp = $timestamp == 0 ? time() : $timestamp;
	$dias = array('Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sábado');
	return $dias[date("w", $timestamp)];
}

function getMes($mes){
	//$timestamp = $timestamp == 0 ? time() : $timestamp;
	$meses = array('','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
	return $meses[$mes];
}

function getMesQuery($fecha) {
    $res = mysql_query("SELECT MONTH(".$fecha."-01)");
    return mysql_result($res, 0);
    
}

function curr_format($curr, $amount){
  switch ($curr){
  case "EUR":
  $ret = number_format($amount, 2, ",", " ")."€";
  break;
  case "US":
  $ret = number_format($amount, 2, ".", ",")."&#38;#36;";
  break;
  }
return $ret;
}

// Consulta de datos de la empresa para imprimirlo en la factura final

function consultarDatosEmpresa(){
    $res = mysql_query("SELECT cif, nombre, direccion, cp, ciudad, provincia, pais, telefono,
                        fax, email, web from Proveedores where cif='".$GLOBALS['cif']."';");
    
    while($row=  mysql_fetch_array($res)) {
        
         $nombre = $row['nombre']; 
         $datos.= $row['cif']." \n";
         $datos.= $row['direccion']." \n";
         $datos.= "CP: ".$row['cp']."    ";
         $datos.= $row['ciudad']." \n";
         $datos.= $row['provincia']."    ";
         $datos.= $row['pais']." \n";
         $datos.= "Teléfono: ".$row['telefono']." \n";
         $datos.= "Fax: ".$row['fax']." \n";
         $datos.= "Email: ".$row['email']." \n";
         $datos.= "Web: ".$row['web']." \n";
    }
    $info = array();
    $info[0] = $nombre;
    $info[1] = utf8_decode($datos);
    return $info;
}

function consultarTareas() {
	$res ="SELECT t.idTarea AS 'idTarea', tipo.idTipoTarea AS 'idTipoTarea', p.nombre AS 'TipoAgente', a.nombre AS 'Nombre', 
DATE_FORMAT(t.horaInicio,'%d/%m/%Y') AS 'Fecha', DATE_FORMAT(t.horaInicio,'%H:%i') AS 'Inicio',
DATE_FORMAT(t.horaFin,'%H:%i') AS 'Fin', TIMEDIFF(t.horaFin,t.horaInicio) AS 'Intervalo',
tipo.nombre AS 'TipoTarea', (tipo.precioHora*(HOUR(TIMEDIFF(t.horaFin,t.horaInicio)))+(MINUTE(TIMEDIFF(t.horaFin,t.horaInicio))*tipo.precioHora)/60) AS 'Coste',  tipo.precioTarea*t.unidades   AS 'Comision'
FROM Agentes a, Tareas t, TipoTarea tipo, Perfil p
WHERE t.idAgente = a.idAgente AND t.idTipoTarea=tipo.idTipoTarea AND p.idPerfil=a.idPerfil
ORDER BY t.horaInicio DESC";
        return $res;

	//imprimirTareas($res);
}


function consultarTareasLimit($RegistrosAEmpezar, $RegistrosAMostrar) {
	$res ="SELECT t.idTarea AS 'idTarea', tipo.idTipoTarea AS 'idTipoTarea', p.nombre AS 'TipoAgente', a.nombre AS 'Nombre', 
DATE_FORMAT(t.horaInicio,'%d/%m/%Y') AS 'Fecha', DATE_FORMAT(t.horaInicio,'%H:%i') AS 'Inicio',
DATE_FORMAT(t.horaFin,'%H:%i') AS 'Fin', TIMEDIFF(t.horaFin,t.horaInicio) AS 'Intervalo',
tipo.nombre AS 'TipoTarea', (tipo.precioHora*(HOUR(TIMEDIFF(t.horaFin,t.horaInicio)))+(MINUTE(TIMEDIFF(t.horaFin,t.horaInicio))*tipo.precioHora)/60) AS 'Coste', tipo.precioTarea*t.unidades AS 'Comision'
FROM Agentes a, Tareas t, TipoTarea tipo, Perfil p
WHERE t.idAgente = a.idAgente AND t.idTipoTarea=tipo.idTipoTarea AND p.idPerfil=a.idPerfil
ORDER BY t.horaInicio DESC
LIMIT ".$RegistrosAEmpezar.", ".$RegistrosAMostrar.";";
        return $res;

	//imprimirTareas($res);
}

function consultarTareasEmpleado($empleado) {
	$res ="SELECT t.idTarea AS 'idTarea', tipo.idTipoTarea AS 'idTipoTarea', p.nombre AS 'TipoAgente', a.nombre AS 'Nombre', 
DATE_FORMAT(t.horaInicio,'%d/%m/%Y') AS 'Fecha', DATE_FORMAT(t.horaInicio,'%H:%i') AS 'Inicio',
DATE_FORMAT(t.horaFin,'%H:%i') AS 'Fin', TIMEDIFF(t.horaFin,t.horaInicio) AS 'Intervalo',
tipo.nombre AS 'TipoTarea', (tipo.precioHora*(HOUR(TIMEDIFF(t.horaFin,t.horaInicio)))+(MINUTE(TIMEDIFF(t.horaFin,t.horaInicio))*tipo.precioHora)/60) AS 'Coste',  tipo.precioTarea*t.unidades   AS 'Comision'
FROM Agentes a, Tareas t, TipoTarea tipo, Perfil p
WHERE t.idAgente = a.idAgente AND t.idTipoTarea=tipo.idTipoTarea AND p.idPerfil=a.idPerfil AND a.nombre='".$empleado."'
ORDER BY t.horaInicio DESC";
        return $res;

	//imprimirTareas($res);
}

function consultarTareasEmpleadoLimit($empleado, $RegistrosAEmpezar, $RegistrosAMostrar) {
	$res ="SELECT t.idTarea AS 'idTarea', tipo.idTipoTarea AS 'idTipoTarea', p.nombre AS 'TipoAgente', a.nombre AS 'Nombre', 
DATE_FORMAT(t.horaInicio,'%d/%m/%Y') AS 'Fecha', DATE_FORMAT(t.horaInicio,'%H:%i') AS 'Inicio',
DATE_FORMAT(t.horaFin,'%H:%i') AS 'Fin', TIMEDIFF(t.horaFin,t.horaInicio) AS 'Intervalo',
tipo.nombre AS 'TipoTarea', (tipo.precioHora*(HOUR(TIMEDIFF(t.horaFin,t.horaInicio)))+(MINUTE(TIMEDIFF(t.horaFin,t.horaInicio))*tipo.precioHora)/60) AS 'Coste',  tipo.precioTarea*t.unidades   AS 'Comision'
FROM Agentes a, Tareas t, TipoTarea tipo, Perfil p
WHERE t.idAgente = a.idAgente AND t.idTipoTarea=tipo.idTipoTarea AND p.idPerfil=a.idPerfil AND a.nombre='".$empleado."'
ORDER BY t.horaInicio DESC
LIMIT ".$RegistrosAEmpezar.", ".$RegistrosAMostrar.";";
        return $res;

	//imprimirTareas($res);
}


function consultarTareasFiltrar($filtro) {
	$res ="SELECT t.idTarea AS 'idTarea', tipo.idTipoTarea AS 'idTipoTarea', p.nombre AS 'TipoAgente', a.nombre AS 'Nombre', 
DATE_FORMAT(t.horaInicio,'%d/%m/%Y') AS 'Fecha', DATE_FORMAT(t.horaInicio,'%H:%i') AS 'Inicio',
DATE_FORMAT(t.horaFin,'%H:%i') AS 'Fin', TIMEDIFF(t.horaFin,t.horaInicio) AS 'Intervalo',
tipo.nombre AS 'TipoTarea', (tipo.precioHora*(HOUR(TIMEDIFF(t.horaFin,t.horaInicio)))+(MINUTE(TIMEDIFF(t.horaFin,t.horaInicio))*tipo.precioHora)/60) AS 'Coste', tipo.precioTarea*t.unidades AS 'Comision'
FROM Agentes a, Tareas t, TipoTarea tipo, Perfil p
WHERE t.idAgente = a.idAgente AND t.idTipoTarea=tipo.idTipoTarea AND p.idPerfil=a.idPerfil AND p.nombre='".$filtro."'
ORDER BY t.horaInicio DESC;";
        return $res;

}


function consultarTareasLimitFiltrar($filtro, $RegistrosAEmpezar, $RegistrosAMostrar) {
	$res ="SELECT t.idTarea AS 'idTarea', tipo.idTipoTarea AS 'idTipoTarea', p.nombre AS 'TipoAgente', a.nombre AS 'Nombre', 
DATE_FORMAT(t.horaInicio,'%d/%m/%Y') AS 'Fecha', DATE_FORMAT(t.horaInicio,'%H:%i') AS 'Inicio',
DATE_FORMAT(t.horaFin,'%H:%i') AS 'Fin', TIMEDIFF(t.horaFin,t.horaInicio) AS 'Intervalo',
tipo.nombre AS 'TipoTarea', (tipo.precioHora*(HOUR(TIMEDIFF(t.horaFin,t.horaInicio)))+(MINUTE(TIMEDIFF(t.horaFin,t.horaInicio))*tipo.precioHora)/60) AS 'Coste', tipo.precioTarea*t.unidades AS 'Comision'
FROM Agentes a, Tareas t, TipoTarea tipo, Perfil p
WHERE t.idAgente = a.idAgente AND t.idTipoTarea=tipo.idTipoTarea AND p.idPerfil=a.idPerfil AND p.nombre='".$filtro."'
ORDER BY t.horaInicio DESC
LIMIT ".$RegistrosAEmpezar.", ".$RegistrosAMostrar.";";
        return $res;

	//imprimirTareas($res);
}

function consultarTareasLimitFiltrarFecha($fecha,$filtro,$RegistrosAEmpezar, $RegistrosAMostrar) {
        $res ="SELECT t.idTarea AS 'idTarea', tipo.idTipoTarea AS 'idTipoTarea', p.nombre AS 'TipoAgente', a.nombre AS 'Nombre', 
DATE_FORMAT(t.horaInicio,'%d/%m/%Y') AS 'Fecha', DATE_FORMAT(t.horaInicio,'%H:%i') AS 'Inicio',
DATE_FORMAT(t.horaFin,'%H:%i') AS 'Fin', TIMEDIFF(t.horaFin,t.horaInicio) AS 'Intervalo',
tipo.nombre AS 'TipoTarea', (tipo.precioHora*(HOUR(TIMEDIFF(t.horaFin,t.horaInicio)))+(MINUTE(TIMEDIFF(t.horaFin,t.horaInicio))*tipo.precioHora)/60) AS 'Coste', tipo.precioTarea*t.unidades AS 'Comision'
FROM Agentes a, Tareas t, TipoTarea tipo, Perfil p
WHERE t.idAgente = a.idAgente AND t.idTipoTarea=tipo.idTipoTarea AND p.idPerfil=a.idPerfil AND p.nombre='".$filtro."' AND t.horaInicio LIKE '%".$fecha."%'
ORDER BY t.horaInicio DESC
LIMIT ".$RegistrosAEmpezar.", ".$RegistrosAMostrar.";";
        return $res;
}

function consultarTareasFiltrarFecha($fecha,$filtro) {
        $res ="SELECT t.idTarea AS 'idTarea', tipo.idTipoTarea AS 'idTipoTarea', p.nombre AS 'TipoAgente', a.nombre AS 'Nombre', 
DATE_FORMAT(t.horaInicio,'%d/%m/%Y') AS 'Fecha', DATE_FORMAT(t.horaInicio,'%H:%i') AS 'Inicio',
DATE_FORMAT(t.horaFin,'%H:%i') AS 'Fin', TIMEDIFF(t.horaFin,t.horaInicio) AS 'Intervalo',
tipo.nombre AS 'TipoTarea', (tipo.precioHora*(HOUR(TIMEDIFF(t.horaFin,t.horaInicio)))+(MINUTE(TIMEDIFF(t.horaFin,t.horaInicio))*tipo.precioHora)/60) AS 'Coste', tipo.precioTarea*t.unidades AS 'Comision'
FROM Agentes a, Tareas t, TipoTarea tipo, Perfil p
WHERE t.idAgente = a.idAgente AND t.idTipoTarea=tipo.idTipoTarea AND p.idPerfil=a.idPerfil AND p.nombre='".$filtro."' AND t.horaInicio LIKE '%".$fecha."%'
ORDER BY t.horaInicio DESC";
        return $res;
}

function consultarTareasLimitFecha($fecha,$RegistrosAEmpezar, $RegistrosAMostrar) {
    $res ="SELECT t.idTarea AS 'idTarea', tipo.idTipoTarea AS 'idTipoTarea', p.nombre AS 'TipoAgente', a.nombre AS 'Nombre', 
DATE_FORMAT(t.horaInicio,'%d/%m/%Y') AS 'Fecha', DATE_FORMAT(t.horaInicio,'%H:%i') AS 'Inicio',
DATE_FORMAT(t.horaFin,'%H:%i') AS 'Fin', TIMEDIFF(t.horaFin,t.horaInicio) AS 'Intervalo',
tipo.nombre AS 'TipoTarea', (tipo.precioHora*(HOUR(TIMEDIFF(t.horaFin,t.horaInicio)))+(MINUTE(TIMEDIFF(t.horaFin,t.horaInicio))*tipo.precioHora)/60) AS 'Coste', tipo.precioTarea*t.unidades AS 'Comision'
FROM Agentes a, Tareas t, TipoTarea tipo, Perfil p
WHERE t.idAgente = a.idAgente AND t.idTipoTarea=tipo.idTipoTarea AND p.idPerfil=a.idPerfil AND t.horaInicio LIKE '%".$fecha."%'
ORDER BY t.horaInicio DESC
LIMIT ".$RegistrosAEmpezar.", ".$RegistrosAMostrar.";";
        return $res;
}

function consultarTareasFecha($fecha) {
    $res ="SELECT t.idTarea AS 'idTarea', tipo.idTipoTarea AS 'idTipoTarea', p.nombre AS 'TipoAgente', a.nombre AS 'Nombre', 
DATE_FORMAT(t.horaInicio,'%d/%m/%Y') AS 'Fecha', DATE_FORMAT(t.horaInicio,'%H:%i') AS 'Inicio',
DATE_FORMAT(t.horaFin,'%H:%i') AS 'Fin', TIMEDIFF(t.horaFin,t.horaInicio) AS 'Intervalo',
tipo.nombre AS 'TipoTarea', (tipo.precioHora*(HOUR(TIMEDIFF(t.horaFin,t.horaInicio)))+(MINUTE(TIMEDIFF(t.horaFin,t.horaInicio))*tipo.precioHora)/60) AS 'Coste', tipo.precioTarea*t.unidades AS 'Comision'
FROM Agentes a, Tareas t, TipoTarea tipo, Perfil p
WHERE t.idAgente = a.idAgente AND t.idTipoTarea=tipo.idTipoTarea AND p.idPerfil=a.idPerfil AND t.horaInicio LIKE '%".$fecha."%'
ORDER BY t.horaInicio DESC";
        return $res;
}



function consultarEmpleados() {
    $res = "SELECT a.nombre AS 'nombre' , p.nombre AS 'TipoAgente'
            FROM Agentes a, Perfil p
            WHERE a.idPerfil = p.idPerfil
            ORDER BY nombre ASC;";
    return $res;
}

function consultarTareasFechaEmpleado($fecha,$empleado) {
    $res ="SELECT t.idTarea AS 'idTarea', tipo.idTipoTarea AS 'idTipoTarea', t.idTipoTarea AS 'idTipoTarea', p.nombre AS 'TipoAgente', a.nombre AS 'Nombre', 
DATE_FORMAT(t.horaInicio,'%d/%m/%Y') AS 'Fecha', DATE_FORMAT(t.horaInicio,'%H:%i') AS 'Inicio',
DATE_FORMAT(t.horaFin,'%H:%i') AS 'Fin', TIMEDIFF(t.horaFin,t.horaInicio) AS 'Intervalo',
tipo.nombre AS 'TipoTarea', t.unidades AS 'Unidades', (tipo.precioHora*(HOUR(TIMEDIFF(t.horaFin,t.horaInicio)))+(MINUTE(TIMEDIFF(t.horaFin,t.horaInicio))*tipo.precioHora)/60) AS 'Coste', tipo.precioTarea*t.unidades AS 'Comision'
FROM Agentes a, Tareas t, TipoTarea tipo, Perfil p
WHERE t.idAgente = a.idAgente AND t.idTipoTarea=tipo.idTipoTarea AND p.idPerfil=a.idPerfil AND t.horaInicio LIKE '%".$fecha."%'
AND a.nombre='".$empleado."'
ORDER BY t.horaInicio DESC";
        return $res;
}


function consultarTareas2($empleado,$fecha,$fechaIni,$fechaFin,$agente) {
    
    $consulta = $GLOBALS['consultaTareas'];
    
    if($fecha!="") {
        $consulta.= "AND t.horaInicio LIKE '%".$fecha."%' ";
    }
    
    if($empleado!="") {
        $consulta.= "AND a.nombre='".$empleado."' ";
    }
    
    if($agente!="") {
        $consulta.= "AND p.nombre='".$agente."' ";
    }
    
    $consulta.= "ORDER BY t.horaInicio DESC ";
    
    return $consulta;
}

function consultarTareasLimit2($empleado,$fecha,$fechaIni,$fechaFin,$agente,$RegistrosAEmpezar,$RegistrosAMostrar) {

    $consulta = consultarTareas2($empleado,$fecha,$fechaIni,$fechaFin,$agente);
    $consulta.= "LIMIT ".$RegistrosAEmpezar.", ".$RegistrosAMostrar.";";
    
    return $consulta;
}


?>