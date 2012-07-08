<?php
// (c) Xavier Nicolay
// Exemple de génération de devis/facture PDF
require_once($_SERVER['DOCUMENT_ROOT'].'/macrotelecomnuevo/functions/consultas.php');
require_once('invoice.php');


//function generarPagina($pdf) {
    
    $pdf->AddPage();            
            $pdf->Image($_SERVER['DOCUMENT_ROOT'].'/macrotelecomnuevo/fpdf/logo.jpg',9,5,35);

            // Obtenemos los datos de la empresa

            $datosEmpresa = consultarDatosEmpresa();

            $pdf->addSociete($datosEmpresa[0],$datosEmpresa[1]);
            $pdf->fact_dev( " ", "" );
            $pdf->temporaire(utf8_decode( "RETRIBUCIÓN"));
            $pdf->addDate( getMes(substr($_GET['fecha'], 5, 7)." ".substr($_GET['fecha'], 0, 4)));
            $pdf->addClient($row['nombre']);
            $pdf->addPageNumber("1");
            $pdf->addClientAdresse("\n");
            $pdf->addReglement("Transferencia Bancaria");
            $pdf->addEcheance("31/12/2003");
            $pdf->addNumTVA("18%");
            //$pdf->addReference("Devis ... du ....");
            $cols=array( "REFERENCIA"    => 23,
                        "TIPO DE TAREA"  => 78,
                        "UNIDADES"     => 22,
                        "HORAS"      => 14,
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
//}

?>