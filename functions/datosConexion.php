<?

// datos de conexión
$host="localhost";
$user="francisco";
$pass= sha1("ns4iN9cL");
$db = 'macrotelecom';

// datos del CIF de la empresa para hacer la consulta de sus datos (lo tomamos como la clave al buscarlo
// si la empresa cambia algún día de nombre o CIF, hay que cambiarlo aquí
global $cif;
$cif= "B92841578";

// directorio del template, definimos la variable 

$dir_template="macrotelecomnuevo";

if (!($conexion=mysql_pconnect($host,$user,$pass))) {
	die ("No se estableció la conexión");}
mysql_select_db($db);
// Para establecer por defecto la codificacion del text en utf8
mysql_set_charset("utf8", $conexion);
?>
