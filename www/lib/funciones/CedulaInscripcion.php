<?php

$data = $this->Admin_Model->getAlumnosClubes1($club, $periodo);
$prommotor = $this->Admin_Model->getPromotor($club, $periodo);

$admin = $this->Admin_Model->getAdminData($data[0]['id_administrador']);


SESSION('periodo',$periodo);
SESSION('horario',substr($prommotor[0]['horario'],0,40));
SESSION('actividad', $data[0]['nombre_club']);
SESSION('admin', strtoupper($admin[0]['abreviatura_profesion'].' '.$admin[0]['apellido_paterno_administrador'].' '.$admin[0]['apellido_materno_administrador'].' '.$admin[0]['nombre_administrador'] ) );

/***** obtener datos de revision ****/
if(strcmp(substr($periodo, 0,3), "AGO") == 0) 
  $fecha = substr($periodo, 11,4)."-01-31"; 
else  
  $fecha = substr($periodo, 11,4)."-07-31";

$rev = $this->Admin_Model->getRevisionActual(1, $fecha);
SESSION('codigo',$rev[0]['codigo']);
SESSION('norma',$rev[0]['norma']);
SESSION('rev',$rev[0]['nombre_revision']);

/******************************************/


$pdf = new Cedula('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Simpus Soluciones Informaticas');
$pdf->SetTitle('Cédula de inscripción');
$pdf->SetSubject('Cedula');
$pdf->SetKeywords('lista,cedulas, extraescolares, clubes, club');
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

$pdf->SetMargins(20, 93, 20);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetAutoPageBreak(TRUE, 50);

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
		<td width = "300">&nbsp;'.$row['apellido_paterno_alumno'].' '.$row['apellido_materno_alumno'].' '.$row['nombre_alumno'].'</td>
		<td align="center" width = "90">&nbsp;'.$row['numero_control'].'</td>
		<td width = "150">&nbsp;'.$row['abreviatura_carrera'].'</td>
		<td align="center" width = "45">&nbsp;'.$row['semestre'].'</td>
		<td align="center" width = "45">&nbsp;'.calcularEdad($row['fecha_nacimiento'], $row['fecha_inscripcion_club']).'</td>
		<td align="center" width = "45">&nbsp;';
		
		if($row['sexo'] == 1) $html .= "H"; else $html.= "M";
		
		$html .= '</td>
		<td  width = "150" class="margin-left:10px"> '.$row['observaciones'].'</td>
	</tr>';
	
  }

$html.='</table>';

$pdf->writeHTML($html, true, false, true, false, '');

$pdf->lastPage();

?>