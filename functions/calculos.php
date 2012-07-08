<?php

require_once('datosConexion.php');

function maxImporte(){
	$res = mysql_query('SELECT MAX(importe) FROM Conceptos;');
	return mysql_result($res, 0);
}

function calcularValorBarra($valorMax,$valorImporte){
	$valorImporte = ceil((($valorImporte*100)/$valorMax));
	return $valorImporte;
}

function calcularTiempoTareas($numHoras, $numMinutos, $precioHora) {
	return (($numHoras+($numMinutos/60))*$precioHora);
}

function calcularCantidadTareas($numUnidades, $precioUnidad) {
	return ($numUnidades*$precioUnidad);
}

function totalImportes() {
	$res = mysql_query('SELECT SUM(importe) FROM Conceptos;');
        return mysql_result($res,0);
}

?>