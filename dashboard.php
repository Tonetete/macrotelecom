<?php

 require_once('./functions/datosConexion.php');
 require_once('./functions/consultas.php');
 require_once('./functions/calculos.php');

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<title>WebStarter Admin Template - Dashboard</title>

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
<link rel="stylesheet" type="text/css" href="css/barChart_style.css" />

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
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
<script type="text/javascript" src="js/barChart.js"></script>

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
				<div class="bigIcons">
					<div class="bigIcon">
						<a href="#"><img src="img/big_icon_settings.png" alt="Settings" /></a>
						<div class="bigIconText"><a href="#">Basic Settings</a></div>
					</div>
					
					<div class="bigIcon">
						<a href="#"><img src="img/big_icon_orders.png" alt="Orders" /></a>
						<div class="bigIconText"><a href="#">Recent Orders</a></div>
					</div>
					
					<div class="bigIcon">
						<a href="#"><img src="img/big_icon_comments.png" alt="Comments" /></a>
						<div class="bigIconText"><a href="#">Recent Comments</a></div>
					</div>
					
					<div class="bigIcon">
						<a href="#"><img src="img/big_icon_email.png" alt="Email" /></a>
						<div class="bigIconText"><a href="#">Send Newsletter</a></div>
					</div>
					
					<div class="bigIcon">
						<a href="#"><img src="img/big_icon_note.png" alt="Page" /></a>
						<div class="bigIconText"><a href="#">New Page</a></div>
					</div>
					
					<div class="bigIcon">
						<a href="#"><img src="img/big_icon_customer.png" alt="Customer" /></a>
						<div class="bigIconText"><a href="#">New Customer</a></div>
					</div>
					
					<div class="bigIcon">
						<a href="#"><img src="img/big_icon_stat.png" alt="Stat" /></a>
						<div class="bigIconText"><a href="#">Statistics</a></div>
					</div>
					
					<div class="clear"></div>
				</div><!-- END OF .bigIcons -->

				<div class="box">
					<h2>Totalizador</h2>
					<div>
						<div class="text">
							<div class="infoColumnUp">
								<div class="infoColumnIcon"><img src="img/quick_info_up.png" alt="Up" /></div>
								<div class="infoColumnNumber"><div class="infoColumnNumberBg">
									<?php echo totalizadorIngresos().'€'; ?>
								   </div>
								</div>
								<p>Ingresos Totalizador</p>
							</div>
							
							<div class="infoColumnDown">
								<div class="infoColumnIcon"><img src="img/quick_info_down.png" alt="Down" /></div>
								<div class="infoColumnNumber"><div class="infoColumnNumberBg">
								  <?php echo totalizadorGastos().'€'; ?>	
								 </div>
								</div>
								<p>Gastos Totalizador</p>
							</div>
							
							<div class="infoColumnSame">
								<div class="infoColumnIcon"><img src="img/quick_info_same.png" alt="-" /></div>
								<div class="infoColumnNumber"><div class="infoColumnNumberBg">
								  <?php echo (totalizadorIngresos() - totalizadorGastos()).'€'; ?>
								 </div>
								</div>
								<p>Situación Actual</p>
							</div>
							
							<div class="infoColumnUp">
								<div class="infoColumnIcon"><img src="img/quick_info_up.png" alt="Up" /></div>
								<div class="infoColumnNumber"><div class="infoColumnNumberBg">$3200</div></div>
								<p>Revenue</p>
							</div>
			
							<div class="infoColumnDown last">
								<div class="infoColumnIcon"><img src="img/quick_info_down.png" alt="Down" /></div>
								<div class="infoColumnNumber"><div class="infoColumnNumberBg">$56</div></div>
								<p>Average Orders</p>
							</div>

							<div class="clear"></div>
						</div>
					</div>
				</div>

				<div class="box">
					<h2>Visitors Overview</h2>
					<div>
						<ul id="chart">								
								<?php  totalizadorBarras();?>	
						</ul>
						   <g>
							<text text-anchor="start" x="283" y="47.35" font-family="Arial"
							font-size="11" stroke="none" stroke-width="0" fill="blue">Ganancias</text>
							<text text-anchor="start" x="283" y="47.35" font-family="Arial"
							font-size="11" stroke="none" stroke-width="0" fill="blue">Deudas</text>
						   </g>
					</div>
				</div>
				
				<div class="box2">
					<h2>Traffic Sources Overview</h2>
					<div>
						<table class="pieChart">
							<thead>
								<tr>
									<th></th>
									<th>Search Engines</th>
									<th>Referring Sites</th>
									<th>Direct Traffic</th>
								</tr>
							</thead>

							<tbody>
								<tr>
									<th>Sources</th>
									<td>34523</td>
									<td>22123</td>
									<td>25031</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				
				<div class="box2">
					<h2>Simple Table Example</h2>
					<div>
						<table>
							<thead>
								<tr>
									<th>Keyword</th>
									<th>Visits</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>anhembi parque</td>
									<td>12232</td>
								</tr>
								<tr>
									<td>wm gucken</td>
									<td>6874</td>
								</tr>
								<tr>
									<td>world cup</td>
									<td>6533</td>
								</tr>
								<tr>
									<td>bundeskanzleramt</td>
									<td>4321</td>
								</tr>
							</tbody>
						</table>
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