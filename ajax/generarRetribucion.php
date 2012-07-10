<?php
 //require_once('')
 include($_SERVER['DOCUMENT_ROOT'].'/macrotelecomnuevo/functions/datosConexion.php');
 include_once($_SERVER['DOCUMENT_ROOT'].'/macrotelecomnuevo/functions/consultas.php');
 require($_SERVER['DOCUMENT_ROOT'].'/macrotelecomnuevo/fpdf/invoice.php');
 //require($_SERVER['DOCUMENT_ROOT'].'/macrotelecomnuevo/fpdf/factura.php');
 
 
 
 //estos valores los recibo por GET
 if(isset($_GET['fecha']) && isset($_GET['fechaini']) && isset($_GET['fechafin']) && isset($_GET['emp'])) {
  
            
            // Establecemos el numero de paginas a 1 para cada retribucion
         
            $pag = 1;
            $resTareas = mysql_query(consultarTareas2($_GET['emp'], $_GET['fecha'], $_GET['fechaini'], $_GET['fechafin'], ""));
            
            // Si tenemos 0 filas, no imprimimos su retirbucion
            if(mysql_num_rows($resTareas)!=0) {
            $pdf = new PDF_Invoice( 'P', 'mm', 'A4' );         
            
            $pdf->AddPage();            
            $pdf->Image($_SERVER['DOCUMENT_ROOT'].'/macrotelecomnuevo/fpdf/logo.jpg',9,5,35);

            // Obtenemos los datos de la empresa

            $datosEmpresa = consultarDatosEmpresa();

            $pdf->addSociete($datosEmpresa[0],$datosEmpresa[1]);
            $pdf->fact_dev( " ", "" );
            $pdf->temporaire(utf8_decode( "RETRIBUCIÓN"));
            
            $pdf->addEcheance(getMes(getMesQuery($_GET['fecha']))." ".substr($_GET['fecha'], 0, 4));
            $pdf->addClient($row['nombre']);
            $pdf->addPageNumber("1");
            $pdf->addClientAdresse("Empleado: ". utf8_decode(ucwords(strtolower($row['nombre']))). "\n".
                                    "Tipo de Agente: ".utf8_decode(strtoupper($row['TipoAgente'])). "\n");
            $pdf->addReglement("Transferencia Bancaria");
            $pdf->addEcheance("");
            $pdf->addNumTVA(getIVA()."%");
            //$pdf->addReference("Devis ... du ....");
            $cols=array( "REFERENCIA"    => 23,
                        "TIPO DE TAREA"  => 66,
                        "UNIDADES"     => 22,
                        "HORAS"      => 26,
                        "COMISION" => 27,
                        "TOTAL HORAS" => 26 );
            $pdf->addCols( $cols);
            $cols=array( "REFERENCIA"    => "L",
                        "TIPO DE TAREA"  => "L",
                        "UNIDADES"     => "C",
                        "HORAS"      => "R",
                        "COMISION" => "R",
                        "TOTAL HORAS" => "C" );
            $pdf->addLineFormat( $cols);
            $pdf->addLineFormat($cols);
            
            // Margen vertical 
            
            $y    = 109;            
            
            // Establecemos nuestro acumulador de total horas y total comisiones
            $totalComisiones = 0;
            $totalHoras = 0;

            while($rowTareas = mysql_fetch_array($resTareas)) {
                
                $line = array( "REFERENCIA"    => utf8_decode($rowTareas['idTipoTarea']),
                            "TIPO DE TAREA"  => utf8_decode($rowTareas['TipoTarea']),
                            "UNIDADES"     => utf8_decode($rowTareas['Unidades']),
                            "HORAS"      => utf8_decode($rowTareas['Intervalo']),
                            "COMISION" => number_format($rowTareas['Comision'], 2, ",", " ").EURO,
                            "TOTAL HORAS"  => number_format($rowTareas['Coste'], 2, ",", " ").EURO);
                
                $totalComisiones+=$rowTareas['Comision'];
                $totalHoras+=$rowTareas['Coste'];
                $size = $pdf->addLine( $y, $line );
                $y   += $size + 2;
                
                // Añadimos nueva página si se sale de los márgenes
                if($y>235) {
                    $pag++;
                    $pdf->AddPage();            
                    $pdf->Image($_SERVER['DOCUMENT_ROOT'].'/macrotelecomnuevo/fpdf/logo.jpg',9,5,35);

                    // Obtenemos los datos de la empresa

                    $datosEmpresa = consultarDatosEmpresa();

                    $pdf->addSociete($datosEmpresa[0],$datosEmpresa[1]);
                    $pdf->fact_dev( " ", "" );
                    $pdf->temporaire(utf8_decode( "RETRIBUCIÓN"));
                    $pdf->addEcheance(getMes(getMesQuery($_GET['fecha']))." ".substr($_GET['fecha'], 0, 4));
                    $pdf->addClient($row['nombre']);
                    $pdf->addPageNumber("1");
                    $pdf->addClientAdresse("Empleado: ". utf8_decode(ucwords(strtolower($row['nombre']))). "\n".
                                            "Tipo de Agente: ".utf8_decode(strtoupper($row['TipoAgente'])). "\n");
                    $pdf->addReglement("Transferencia Bancaria");
                    $pdf->addEcheance("");
                    $pdf->addNumTVA(getIVA()."%");
                    //$pdf->addReference("Devis ... du ....");
                    $cols=array( "REFERENCIA"    => 23,
                                "TIPO DE TAREA"  => 66,
                                "UNIDADES"     => 22,
                                "HORAS"      => 26,
                                "COMISION" => 27,
                                "TOTAL HORAS" => 26 );
                    $pdf->addCols( $cols);
                    $cols=array( "REFERENCIA"    => "L",
                                "TIPO DE TAREA"  => "L",
                                "UNIDADES"     => "C",
                                "HORAS"      => "R",
                                "COMISION" => "R",
                                "TOTAL HORAS" => "C" );
                    $pdf->addLineFormat( $cols);
                    $pdf->addLineFormat($cols);
                    $y  = 109;
                }
            }

            //$pdf->addCadreTVAs();

            // invoice = array( "px_unit" => value,
            //                  "qte"     => qte,
            //                  "tva"     => code_tva );
            // tab_tva = array( "1"       => 19.6,
            //                  "2"       => 5.5, ... );
            // params  = array( "RemiseGlobale" => [0|1],
            //                      "remise_tva"     => [1|2...],  // {la remise s'applique sur ce code TVA}
            //                      "remise"         => value,     // {montant de la remise}
            //                      "remise_percent" => percent,   // {pourcentage de remise sur ce montant de TVA}
            //                  "FraisPort"     => [0|1],
            //                      "portTTC"        => value,     // montant des frais de ports TTC
            //                                                     // par defaut la TVA = 19.6 %
            //                      "portHT"         => value,     // montant des frais de ports HT
            //                      "portTVA"        => tva_value, // valeur de la TVA a appliquer sur le montant HT
            //                  "AccompteExige" => [0|1],
            //                      "accompte"         => value    // montant de l'acompte (TTC)
            //                      "accompte_percent" => percent  // pourcentage d'acompte (TTC)
            //                  "Remarque" => "texte"              // texte
            
            /*$tot_prods = array( array ( "px_unit" => 600, "qte" => 1, "tva" => 1 ),
                    array ( "px_unit" =>  10, "qte" => 1, "tva" => 1 ));*/
           
            //$pdf->addTVAs( $params, $tab_tva, $tot_prods);
            
            
            
            $total = $totalComisiones + $totalHoras;
            $cuenta = $total*(doubleval(getIVA())/100);
            $neto = $total-$cuenta;
            $pdf->addCustomTVAs(number_format($total,2, ",", " "), number_format($cuenta,2, ",", " "), number_format($neto),2, ",", " ");
            $total=0; $cuenta=0; $neto=0;
            $pdf->addCadreEuros();
            $pdf->Output($_SERVER['DOCUMENT_ROOT'].'/macrotelecomnuevo/pdf/retrib-'.$row['nombre'].'-'.$_GET['fecha'].'.pdf','F');
            
     }   
     //echo json_encode("Retribuciones para la fecha ".$_GET['fecha']." han sido generadas.");
 }
 
 else {
         //echo json_encode("Debes seleccionar una fecha antes de generar las retribuciones.");
     }
 
?>
