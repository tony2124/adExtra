<?php
$data = $this->Admin_Model->getAlumnosClubes1($club, $periodo);
$promotor = $this->Admin_Model->getPromotor($club, $periodo);
$admin = $this->Admin_Model->getAdminData(SESSION('id_admin'));

SESSION('periodo',$periodo);
SESSION('actividad', $data[0]['nombre_club']);
SESSION('promotor',strtoupper($promotor[0]['apellido_paterno_promotor'].' '.$promotor[0]['apellido_materno_promotor'].' '.$promotor[0]['nombre_promotor']));

/***** obtener datos de revision ****/

$rev = $this->Admin_Model->getRevisionActual(2);
SESSION('codigo',$rev[0]['codigo']);
SESSION('norma',$rev[0]['norma']);
SESSION('rev',$rev[0]['nombre_revision']);

/******************************************/

$pdf = new Resultados('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Alfonso Calderon');
$pdf->SetTitle('Cédula de resultados');
$pdf->SetSubject('Lista');
$pdf->SetKeywords('cedula, extraescolares, clubes, club');
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

$pdf->SetMargins(20, 93, 20);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetAutoPageBreak(TRUE, 60);

$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->SetFont('dejavusans', '', 10);
$pdf->AddPage();
$html = '
<table style="border-collapse:collapse; font-family:Arial, Helvetica, sans-serif" border="1" 
		cellspacing="0" cellpadding="0">
 ';
  $contador = 1;
  foreach($data as $row)
  {
  	$html .= '<tr>
		<td width = "25">&nbsp;'.($contador++).'</td>
		<td width = "390">&nbsp;'.$row['apellido_paterno_alumno'].' '.$row['apellido_materno_alumno'].' '.$row['nombre_alumno'].'</td>
		<td width = "90">&nbsp;'.$row['numero_control'].'</td>
		<td width = "150">&nbsp;'.$row['abreviatura_carrera'].'</td>
		
		<td width = "45">&nbsp;'.$row['semestre'].'</td>
		
		<td  width = "150" class="margin-left:10px"> '.( (strcmp($row['acreditado'],'1') == 0) ? 'ACREDITADO' : 'NO ACREDITADO').' </td>
	</tr>';
	
  }

$html.='</table>';

$pdf->writeHTML($html, true, false, true, false, '');

$pdf->lastPage();

?>