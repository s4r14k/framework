<?php
/*
*
*---------------------------------------------------------
*				Alpha Group Madagascar 
*				(c) 2018 Madagascar
*---------------------------------------------------------
*
*@author 	S4r14k
*@email 	sarikraf@gmail.com
*/

// Include the main TCPDF library (search for installation path).
require_once(BASE.'/plugins/TCPDF/examples/tcpdf_include.php');

// create new PDF document
function writeNewClient ($name, $aboutClient, $type, $reserver, $payment) {

	$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

	// set document information
	$pdf->SetCreator('PDF_CREATOR');
	$pdf->SetAuthor('s4r14k');
	$pdf->SetTitle('Client Alpha Group');
	$pdf->SetSubject('Alpha Group MADAGASCAR');
	$pdf->SetKeywords('Alpha, MADAGASCAR, AG');

	// set default header data
	$pdf->SetHeaderData('logoA.png', 15, 'ALPHA GROUP MADAGASCAR', "LOT IVS 30 Antanimena Antananarivo 101\n+261 33 08 624 62\nwww.alphaGroup.org");

	// set header and footer fonts
	$pdf->setHeaderFont(Array('helvetica', '', PDF_FONT_SIZE_MAIN));
	$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

	// set default monospaced font
	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

	// set margins
	$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

	// set auto page breaks
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

	// set image scale factor
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

	// set some language-dependent strings (optional)
	if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
		require_once(dirname(__FILE__).'/lang/eng.php');
		$pdf->setLanguageArray($l);
	}

	// ---------------------------------------------------------


	// set font
	$pdf->SetFont('helvetica', '', 11);

	// add a page
	$pdf->AddPage();

	// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
	// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

	//$html = AboutClient("Sariaka", "Raf", "s4r14k", "Sarikraf@gmail.com", "12/12/12", "Lot II P 50 Avaradoha", "", "Hello World", "MADAGASCAR", "Antananarivo");

	// output the HTML content
	$div = '<br/><div style="text-align:center">NEW RESERVATION : '.$type.'</div><br/>';

	$titre1 = '<h3 style="background-color:#336699;color:snow">1 - About Client :</h3>';
	$titre2 = '<br><h3 style="background-color:#336699;color:snow">2 - Reservation :</h3>';

	$pdf->writeHTML($div, true, false, true, false, '');
	$pdf->writeHTML($titre1, true, false, true, false, '');
	$pdf->writeHTML($aboutClient, true, false, true, false, '');
	$pdf->writeHTML($titre2, true, false, true, false, '');
	$pdf->writeHTML($reserver, true, false, true, false, '');

	// reset pointer to the last page
	$pdf->lastPage();

	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	// Print a table

	// add a page
	$pdf->AddPage();

	// create some HTML content

	$titre3 = '<br><h3 style="background-color:#336699;color:snow">3 - Payment :</h3>';;

	// output the HTML content
	$pdf->writeHTML($titre3, true, false, true, false, '');
	$pdf->writeHTML($payment, true, false, true, false, '');
	// Print some HTML Cells

	// reset pointer to the last page
	$pdf->lastPage();

	// ---------------------------------------------------------

	//Close and output PDF document
	$pdf->Output($_SERVER['DOCUMENT_ROOT']."/alphaGroup/Web/pdf/{$name}.pdf", 'F');

	//============================================================+
	// END OF FILE
	//============================================================+
}