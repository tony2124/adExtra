<?php
//obtener datos de la liberacion

$row = $this->Admin_Model->getAlumnoInscrito($folio);

//obtener datos del administrador a cargo en el periodo
$admin = $this->Admin_Model->getAdminData($row[0]['id_administrador']);

/***** obtener datos de revision ****/
$periodo = $row[0]['periodo'];
$club = $row[0]['nombre_club'];
if(strcmp(substr($periodo, 0,3), "AGO") == 0) 
  $fecha = substr($periodo, 11,4)."-01-31"; 
else  
  $fecha = substr($periodo, 11,4)."-07-31";

$rev = $this->Admin_Model->getRevisionActual(3, $fecha);
SESSION('codigo',$rev[0]['codigo']);
SESSION('norma',$rev[0]['norma']);
SESSION('rev',$rev[0]['nombre_revision']);

/******************************************/

	//configuracion de la página del PDF
$pdf = new Liberacion(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Simpus Soluciones Informáticas');
$pdf->SetTitle('Boleta de acreditación de actividades culturales, deportivas y recreativas');
$pdf->SetSubject($row[0]['numero_control']."_".$folio);
$pdf->SetKeywords('horas, extraescolares, clubes, club');
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(20, 50, 20);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->SetFont('dejavusans', '', 10);
$pdf->AddPage(); 

//codigo html que se incluirá en el PDF
$html = '<br><br><br>
<table width="620">
	<tr>
		<td width="620" align="center">
			<strong>DEPARTAMENTO DE ACTIVIDADES CULTURALES, DEPORTIVAS Y  RECREATIVAS</strong>
		</td>
	</tr>
</table>
<br><br><br>
<table width="620" border="1" cellpadding="0"  cellspacing="0" style="border-collapse:collapse; font-family:Arial, Helvetica, sans-serif">
  <tr>
    <td align="center" colspan="5" valign="top" height="45">
	<strong><br>BOLETA DE ACREDITACIÓN DE ACTIVIDADES CULTURALES, DEPORTIVAS Y RECREATIVAS</strong>
	</td>
  </tr>
  <tr>
    <td width="130" valign="top"><strong> No. DE CONTROL:</strong></td>
    <td width="160" valign="top"> '.$row[0]['numero_control'].'</td>
    <td width="140" colspan="2"  valign="top"><strong> PERIODO ESCOLAR:</strong></td>
    <td width="190" valign="top"> '.$row[0]['periodo'].'</td>
  </tr>
  <tr>
    <td><strong> ALUMNO:</strong></td>
    <td colspan="4" valign="top"> '.$row[0]['nombre_alumno'].' '.$row[0]['apellido_paterno_alumno'].' '.$row[0]['apellido_materno_alumno'].'</td>
  </tr>
  <tr>
    <td valign="top"><strong> ESPECIALIDAD:</strong></td>
    <td valign="top">&nbsp;'.$row[0]['abreviatura_carrera'].'</td>
    <td colspan="2" valign="top"><strong> SEMESTRE: </strong></td>
    <td valign="top" align="center">'.$row[0]['semestre'].'</td>
  </tr>
  <tr>
    <td valign="top"><strong> ACTIVIDAD:</strong></td>
    <td colspan="4" valign="top"> '.$row[0]['nombre_club'];
    if($row[0]['observaciones'] != '' && $row[0]['tipo_club'] == 3 ) $html .= " (".$row[0]['observaciones'].")";
    $html .= '</td>
  </tr>
  <tr>
    <td valign="top"><strong> RESULTADO:</strong></td>
    <td colspan="4" valign="top">';
    if($row[0]['acreditado'] == 0 ) $html.=' NO ACREDITADO'; else $html.=' ACREDITADO';
    $html.='</td>
  </tr>
  <tr>
    <td align="center" height="137" valign="middle">
      <br><strong> FECHA DE DESCARGA:</strong>
		<br><br>'.convertirFecha(date("Y-m-d"))."<br>".date("H:i:s").'<br><br><b>FECHA DE LIBERACIÓN</b><br><br>
		'.convertirFecha($row[0]['fecha_liberacion_club']).'
	 </td>
    <td align="center" colspan="3" valign="top">
	<br><br>ATENTAMENTE<br><br><br><br>'.strtoupper($admin[0]['abreviatura_profesion'].' '.$admin[0]['nombre_administrador'].' '.$admin[0]['apellido_paterno_administrador'].' '.$admin[0]['apellido_materno_administrador']).'&nbsp;
	<br>
      <br><strong>JEFE DEL DEPARTAMENTO DE ACTIVIDADES CULTURALES, DEPORTIVAS Y RECREATIVAS</strong>
	</td>
    <td align="center" colspan="1" valign="top">
    
      <strong>SELLO:</strong><br><!--<img src="sello.png" />--></td>
  </tr>
</table>
<br><br><br>
<table style="text-align:justify"><tr><td>
<strong>NOTA.*  CONSERVE ESTA BOLETA SE LE SOLICITARÁ EN LA REALIZACIÓN DE OTROS TRÁMITES.</strong>
</td></tr></table>
';

$pdf->writeHTML($html, true, false, true, false, '');
$style = array(
    'border' => 0,
    'vpadding' => 'auto',
    'hpadding' => 'auto',
    'fgcolor' => array(0,0,0),
    'bgcolor' => false, 
    'module_width' => 1, 
    'module_height' => 1 
);

$pdf->write2DBarcode('ITS9406305S8'.$row[0]["numero_control"].STR_PAD($folio,15,"0",STR_PAD_LEFT).STR_PAD($row[0]["id_carrera"],3,"0",STR_PAD_LEFT).STR_PAD($row[0]["id_club"],3,"0",STR_PAD_LEFT).SUBSTR($row[0]["periodo"],0,7).SUBSTR($row[0]["periodo"],8,7), 'QRCODE,L', 145, 113, 45, 45, $style, 'N');
$pdf->lastPage();

?>