<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?php

 require_once('./functions/consultas.php');
 require_once('./ajax/ejemploGrid.php');
 require_once('./functions/funcionesTareas.php');

?>


<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<title>WebStarter Admin Template - DataGrid</title>

<meta name="description" content="" />
<meta name="keywords" content="" />
<meta http-equiv="Content-Language" content="en" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
<link rel="stylesheet" type="text/css" href="css/webstarter.css" media="screen" />
<link rel="stylesheet" type="text/css" href="css/jquery-ui-1.8.13.custom.css" />
<link rel="stylesheet" type="text/css" href="css/superfish.css" />
<link rel="stylesheet" type="text/css" href="css/jquery.wysiwyg.css" />
<link rel="stylesheet" type="text/css" href="css/fullcalendar.css" />
<link rel="stylesheet" href="resources/jquery-ui-1.8.14.custom.css" type="text/css" />
<link rel="stylesheet" href="resources/jquery.ui.timepicker.css?v=0.3.0" type="text/css" />
<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>


<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.13.custom.min.js"></script>
<script type="text/javascript" src="js/jquery.gvChart-1.0.1.min.js"></script>
<script type="text/javascript" src="js/jquery.vAlign.js"></script>
<script type="text/javascript" src="js/jquery.disableSelection.js"></script>
<script type="text/javascript" src="js/jquery.superfish.js"></script>
<script type="text/javascript" src="js/fullcalendar.min.js"></script>
<script type="text/javascript" src="js/gcal.js"></script>
<script type="text/javascript" src="js/jquery.wysiwyg.js"></script>
<script type="text/javascript" src="js/ws.init.js"></script>
<script type="text/javascript" src="ajax/ajaxPaginador.js"></script>
<script type="text/javascript" src="ajax/ajaxRetribucion.js"></script>
<script type="text/javascript" src="ajax/tareasFunctions.js"></script>
<script type="text/javascript" src="js/jquery.ui.timepicker.js?v=0.3.0"></script>
<script type="text/javascript" charset="utf-8" src="js/jquery.validationEngine-es.js"></script>
<script type="text/javascript" charset="utf-8" src="js/jquery.validationEngine.js" ></script>
<script type="text/javascript" src="js/jquery.jeditable.js"></script>
<script type="text/javascript" src="js/jquery.jeditable.datepicker.js"></script>
<script type="text/javascript" src="js/jquery.jeditable.timepicker.js"></script>
<script type="text/javascript" src="js/jquery.dataTables.js"></script>
<script type="text/javascript" src="js/jsEdit.js"></script>

	
<!--[if lte IE 6]>

<script type="text/javascript" src="js/jquery.pngFix.js"></script>
<script type="text/javascript" src="js/jquery.pngFix.init.js"></script>

<![endif]-->

</head>

<body>

    
<div id="bgTop">

	<div id="core">

		<div id="bgBottom">

			<div id="header">

				<div id="logo">
					<a href="dashboard.html"><img src="img/ws_logo.png" alt="WebStarter Dashboard" /></a>
				</div>
				
				<div id="controls">
					<img src="img/ws_icon_user.png" alt="User" /> Logged in: <strong>Your Name</strong>
				</div>
				
				<div id="logOff">
					<a href="#"><img src="img/ws_logoff.png" alt="Log off" /></a>
				</div>

			</div><!-- END OF #header -->

			<div id="menu">
				<ul id="menuUl" class="sf-menu">
					<li><span class="folder"><img src="img/key.png" align="left" style="padding-right: 4px;" alt="Login Page" /><a href="login.html">Login Page</a></span></li>
					<li><span class="folder"><img src="img/house.png" align="left" style="padding-right: 4px;" alt="Dashboard" /><a href="dashboard.html">Dashboard</a></span></li>
					<li><span class="folder"><img src="img/application_form.png" align="left" style="padding-right: 4px;" alt="Form" /><a href="form.html">Form</a></span></li>
					<li><span class="folder"><img src="img/application_error.png" align="left" style="padding-right: 4px;" alt="Messages" /><a href="messages.html">Messages</a></span></li>
					<li><span class="folder"><img src="img/application_view_columns.png" align="left" style="padding-right: 4px;" alt="Table" /><a href="datagrid.html">Table</a></span></li>
					<li><span class="folder"><img src="img/chart_bar.png" align="left" style="padding-right: 4px;" alt="Charts" /><a href="charts.html">Charts</a></span></li>
					<li><span class="folder"><img src="img/plugin.png" align="left" style="padding-right: 4px;" alt="Other Widgets" /><a href="others.html">Other Widgets</a></span></li>
				</ul>
			</div><!-- END OF #menu -->

			<div id="content">
			
				<div class="dataGrid">
				
					<div class="dataGridControl">
						<div class="dataGridControlButtons">
                                                     <div  style="display:none;" id="formTarea">
                                                            <h1>
                                                                Añadir Tarea
                                                            </h1>
                                                            <form id="formID" action="#" method="post" enctype="multipart/form-data" onsubmit="return false">                                                                
                                                                <table class="horiz">
                                                                <thead>
                                                                    <tr>
                                                                    <th>Nombre de Empleado</th>
                                                                    <th>Fecha Tarea</th>
                                                                    <th>Hora Inicio</th>
                                                                    <th>Hora Fin</th>
                                                                    <th>Tipo de Tarea</th>
                                                                    <th>Unidades</th>                                                                    
                                                                  </tr>
                                                                </thead>    
                                                                
                                                                <tr>
                                                                    <td>                                                                    
                                                                        
                                                                        <?php listarEmpleados('tarea','Seleccionar...'); ?>
                                                                    </td>
                                                                    <td>               
                                                                     
                                                                     <input class="validate[required,custom[date]] text-input datepicker" type="text" name="date" id="date" />
                                                                    </td>
                                                                    <td>                                                         
                                                                        <input class="validate[required,custom[hour]] text-input" type="text" style="width: 70px" id="timepicker_inicio_insertar" value="00:00" />
                                                                           <div class="timepicker_inicio_button" style="width: 16px; height:16px; background: url(resources/include/ui-lightness/images/ui-icons_222222_256x240.png) -80px, -96px;
                                                                              display: inline-block; border-radius: 2px; border: 1px solid #222222; margin-top: 3px; cursor:pointer; top: 3px;position: relative;"></div>                                                             
                                                                    </div>
                                                                    </td>
                                                                    <td>                                                         
                                                                        <input class="validate[required,custom[hour]] text-input" type="text" style="width: 70px" id="timepicker_fin_insertar" value="00:00" />
                                                                           <div class="timepicker_fin_button" style="width: 16px; height:16px; background: url(resources/include/ui-lightness/images/ui-icons_222222_256x240.png) -80px, -96px;
                                                                              display: inline-block; border-radius: 2px; border: 1px solid #222222; margin-top: 3px; cursor:pointer; top: 3px;position: relative;"></div>                                                             
                                                                    </div>
                                                                    </td>
                                                                    <td>                                                                    
                                                                        <?php listarTareas(); ?>
                                                                    </td>
                                                                    <td><input class="validate[required,custom[integer]] text-input" type="text" value="0" name="unidades" id="unidades" />
                                                                    </td>
                                                                </tr>
                                                                   
                                                                </table>
                                                                <p>
                                                                <input type="submit" id="ingresarBoton" value="Introducir Tarea" />
                                                                &nbsp;                                                                
                                                                <input type="reset" value="Limpiar Campos" />
                                                                &nbsp;
                                                                <input type="button" id="cancelarTarea" value="Cancelar" />
                                                                &nbsp;
                                                                </p>
                                                            </form>
                                                         </div>
                                                    
                                                      <div style="float:left" id="menuOptions">
						       
                                                        <img id="anadirTarea"src="img/add.png" alt="New" /> <a href="#">Nueva Tarea</a>
                                                        <img class="borrarTodos" src="img/delete.png" alt="Remove" /> <a href="#">Borrar sel.</a>							
                                                        <!-- Procedimiento para listar las fechas de las tareas desde el mínimo hasta el máximo trabajado-->
                                                        <img id src="img/calendar_view_month.png" alt="consultarFecha" /> <a href="#">Filtrar mes</a><?php insertarFechas(); ?> 
                                                        <img id src="img/group.png" alt="consultarAgente" /> <a href="#">Agente</a><?php listarAgentes(); ?> 
                                                        <img id src="img/user.png" alt="consultarEmpleado" /> <a href="#">Empleado</a><?php listarEmpleados('listar','Todos'); ?>
                                                        <img class="firstPag" id="firstUp" src="img/resultset_first.png" alt="First" /> 
                                                        <img class="antPag" id="antUp" src="img/resultset_previous.png" alt="Previous" /> 
                                                        <select id="selPagAlto" name="pageBottom">                                                            
                                                        </select> 
                                                        <img class="sigPag" id="sigUp" src="img/resultset_next.png" alt="Next" /> 
                                                        <img class="lastPag" id="lastUp"src="img/resultset_last.png" alt="Last" />
                                                       
                                                       <div style="float:left">   
                                                        Fecha Inicio: <img id src="img/calendar_view_month.png" alt="consultarFecha" /> <input style="width:70px;" class="validate[required,custom[date]] select-input rangoFechas datepicker" id="dateini"/>
                                                        Fecha Fin: <img id src="img/calendar_view_month.png" alt="consultarFecha" /> <input style="width:70px;" class="validate[required,custom[date]] select-input rangoFechas datepicker" id="datefin"/>                                                                                                                       
                                                        
                                                       </div>
                                                          <div style="float: right;">
                                                                
                                                            </div>
                                                      </div>
						</div>

						

						<div class="clear"></div>
					</div>
					<div id="dataGridTareas">
						<table>
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
                                                                    <th>&nbsp;</th>
                                                                    <th><input type="checkbox" name="deleteAll" value="" /></th>
								</tr>
							</thead>
							
							<tbody id="contenido">                                                        

                                                                                                                        
							</tbody>
	
						</table>                                            
               
					</div>						
					<div class="dataGridControl">
						<div class="dataGridControlButtons">
							                                                                                                                 
                                                        <img class="borrarTodos" src="img/delete.png" alt="Remove" /> <a href="#">Borrar seleccionados</a>
                                                        <img src="img/pdf.png" alt="Remove" /> <a href="#">Generar retribuciones</a>
                                                         <select id="pdfRetrib" name="retribucion">
                                                            <option value="Sel">Seleccionar...</option>
                                                            <option value="retrbEmpleados">Retrib. Mensual Emp.</option>                                                            
                                                        </select>
						</div>

						<div class="dataGridPages">
                                                    
                                                        <img class="firstPag" id="firstDown" src="img/resultset_first.png" alt="First" /> 
                                                        <img class="antPag" id="antDown" src="img/resultset_previous.png" alt="Previous" /> 							
                                                        <select id="selPagBajo" name="pageBottom">                                                            
                                                        </select> 
                                                        <img class="sigPag" id="sigDown" src="img/resultset_next.png" alt="Next" /> 
                                                        <img class="lastPag" id="lastDown"src="img/resultset_last.png" alt="Last" />&nbsp;                                                        
                                                        <!--Registros por página: 
                                                        <select name="perPageBottom">
                                                            <option value="25">25</option><option value="50">50</option>
                                                            <option value="100">100</option>
                                                        </select>-->
						</div>

						<div class="clear"></div>
					</div>

				</div>

			</div><!-- END OF #content -->

			<div id="footer">
				<strong>WebStarter Content Management System</strong> - 2011 &copy; YourDomainName.com
			</div>

		</div><!-- END OF #bgBottom -->

	</div><!-- END OF #core -->

</div><!-- END OF #bgTop -->

</body>
</html>