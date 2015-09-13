<?php
/**
 * Access from index.php:
 */
if(!defined("_access")) {
	die("Error: You don't have permission to access here...");
}

require_once(_spath.'/pdf/config/lang/eng.php');
require_once(_spath.'/pdf/tcpdf.php');
include(_pathwww.'/lib/funciones/funciones.php');


//Encabezado personalizado de la cédula de inscripción
class Cedula extends TCPDF {
	
    //Page header
    public function Header($var = NULL) {
        // Set font
        $this->SetFont('helvetica', 'N', 10);
        $this->SetY(15);

        // Se genera la tabla del encabezado de la cédula de inscripción
        $html = '<table style="border-collapse:collapse; font-family:Arial, Helvetica, sans-serif" border="1" cellspacing="0" cellpadding="0" width="620">
        <tr>
          <td height="110" width="150" rowspan="3" align="center" valign="middle">
          &nbsp;<br><img src="'._spath.'/formatos/DGEST.jpg" width="140"  />
        </td>
          
        <td height="60" width="450" align="center" >
          <strong><br> Formato para  Cédula de Inscripción a Actividades Culturales, <br>Deportivas y Recreativas</strong>
        </td>
          
        <td width="250" align="center">
          <strong><br> Código: '.SESSION("codigo").'</strong>
        </td> 
        </tr>

        <tr>    
        <td rowspan="2" valign="middle" align="center">
          <strong><br> Referencia a la Norma '.SESSION("norma").'</strong>
        </td>

        <td height="25" valign="middle">
          <strong> '.SESSION("rev").'</strong>
        </td>  
        </tr>

        <tr>
          <td valign="top">
          <strong> Página '.$this->getAliasNumPage().' de '.$this->getAliasNbPages().'</strong>
        </td>
        </tr>
      </table> <p align="center">
					<b>
						DEPARTAMENTO DE ACTIVIDADES CULTURALES, DEPORTIVAS Y RECREATIVAS
					</b> 
				</p>
				<p align="center">
					<b>
						INSCRIPCIÓN - PERIODO: </b>'.SESSION('periodo').'
					
				</p>
				<br>
				<table style="border-collapse:collapse; font-family:Arial, Helvetica, sans-serif" border="0" 
						cellspacing="0" cellpadding="0">
				  <tr>
				    <td width="100">
				   		<b>ACTIVIDAD:</b>
					</td>
					<td width="200">
				   		'.SESSION('actividad').'
					</td>
					<td width="60" >
				   		<b>GRUPO:</b> 
					</td>
					<td width="100">
					ÚNICO
					</td>
					<td width="80">
				   		<b>HORA:</b>
					</td>
					<td width="300">'.
					SESSION('horario')
					.'</td>
				  </tr>
				</table><p>&nbsp;</p>
				<table style="border-collapse:collapse; font-family:Arial, Helvetica, sans-serif" border="1" 
						cellspacing="0" cellpadding="0">
				  <tr align = "center">
				    <td width = "25">No.</td>
				    <td width = "300">ALUMNOS</td>
				    <td width = "90">No. CONTROL</td>
				    <td width = "150">CARRERA</td>
				    <td width = "45">SEM</td>
				    <td width = "45">EDAD</td>
				    <td width = "45">SEXO</td>
				    <td width = "150">OBSERVACIONES</td>
				  </tr></table>';
				//  $this->Text(50,73, "asdds");
       $this->writeHTML($html, true, false, true, false, '');
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-40);
        // Set font
        $this->SetFont('helvetica', 'N', 12);
        
        $html = '<p>Jefe de Departamento de Actividades Culturales, Deportivas y Recreativas: <b>'.SESSION('admin').'</b></p><p>&nbsp;</p>';
        $this->writeHTML($html,true,false,true,false,'');

        $this->SetFont('helvetica', 'I', 10);
        $this->Cell(0, 10, SESSION("codigo")."                                                                                                                                                    				".SESSION("rev"), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}


class Resultados extends TCPDF {
	
    //Page header
    public function Header($var = NULL) {
        // Set font
        $this->SetFont('helvetica', 'N', 10);
        $this->SetY(15);

        // Title
        $html = '<table style="border-collapse:collapse; font-family:Arial, Helvetica, sans-serif" border="1" cellspacing="0" cellpadding="0" width="620">
        <tr>
          <td height="110" width="150" rowspan="3" align="center" valign="middle">
          &nbsp;<br><img src="'._spath.'/formatos/DGEST.jpg" width="140"  />
        </td>
          
        <td height="60" width="450" align="center">
          <strong><br> Formato para Cédula de Resultados de Actividades Culturales, <br>Deportivas y Recreativas.</strong>
        </td>
          
        <td width="250" align="center">
          <strong><br> Código: '.SESSION("codigo").'</strong>
        </td> 
        </tr>

        <tr>    
        <td rowspan="2" valign="middle" align="center">
          <strong><br> Referencia a la Norma '.SESSION("norma").'</strong>
        </td>

        <td height="25" valign="middle">
          <strong> '.SESSION("rev").'</strong>
        </td>  
        </tr>

        <tr>
          <td valign="top">
          <strong> Página '.$this->getAliasNumPage().' de '.$this->getAliasNbPages().'</strong>
        </td>
        </tr>
      </table> <p align="center">
					<b>
						DEPARTAMENTO DE ACTIVIDADES CULTURALES, DEPORTIVAS Y RECREATIVAS
					</b> 
				</p>
				<p align="center">
					<b>
						INSCRIPCIÓN - PERIODO:</b> '.SESSION('periodo').'
					
				</p>
				<br>
				<table style="border-collapse:collapse; font-family:Arial, Helvetica, sans-serif" border="0" 
						cellspacing="0" cellpadding="0">
				  <tr>
				    <td width="100">
				   		<b>ACTIVIDAD:</b>
					</td>
					<td width="250">
				   		'.SESSION('actividad').'
					</td>
				  </tr>
				</table><p>&nbsp;</p>
				<table style="border-collapse:collapse; font-family:Arial, Helvetica, sans-serif" border="1" 
						cellspacing="0" cellpadding="0">
				  <tr align = "center">
				    <td width = "25">No.</td>
				    <td width = "390">ALUMNOS</td>
				    <td width = "90">No. CONTROL</td>
				    <td width = "150">ESP.</td>
				    <td width = "45">SEM</td>
				    <td width = "150">RESULTADO</td>
				  </tr></table>';
				//  $this->Text(50,73, "asdds");
       $this->writeHTML($html, true, false, true, false, '');

    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-55);

        $this->SetFont('helvetica', 'N', 12);
        
        $fech = substr(SESSION('periodo'), - 7, -4);

        if(strcmp($fech,"ENE") == 0)
        	$fech = "Enero del ".substr(SESSION('periodo'), -4);
        else
        	$fech = "Julio del ".substr(SESSION('periodo'), -4);

        $html = '<p>Lugar y fecha: Apatzingán, Michoacán. '.$fech.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Descargado el :'.convertirFecha(date("Y-m-d")).'</p>
				<br>
        <table align="center">
        	<tr>
        		<td><b>PROMOTOR:</b></td>
        		<td><b>JEFE DE DEPARTAMENTO</b></td>
        	</tr>
        	
	        <tr>
	        	<td>'.SESSION('promotor').'</td>
	        	<td>'.SESSION('admin').'</td>
	        </tr>
       		
       	</table>
       	<p>&nbsp;</p>';
        $this->writeHTML($html,true,false,true,false,'');

        $this->SetFont('helvetica', 'I', 10);
        $this->Cell(0, 10, SESSION("codigo")."                                                                                                                                                    				".SESSION("rev"), 0, false, 'C', 0, '', 0, false, 'T', 'M');

    }
}


class Liberacion extends TCPDF {

    //Page header
    public function Header() {
        // Set font
        $this->SetFont('helvetica', 'N', 10);
        $this->SetY(15);
        
        // Title
        $html = '<table style="border-collapse:collapse; font-family:Arial, Helvetica, sans-serif" border="1" cellspacing="0" cellpadding="0" width="620">
        <tr>
          <td height="110" width="150" rowspan="3" align="center" valign="middle">
          &nbsp;<br><img src="'._spath.'/formatos/DGEST.jpg" width="140"/>
        </td>
          
        <td height="60" width="280" align="center" valign="middle">
          <strong><br> Formato para Boleta de Acreditación de Actividades Culturales, Deportivas y Recreativas.</strong>
        </td>
          
        <td width="190" align="center">
          <strong> <br>Código:<br>'.SESSION("codigo").'</strong>
        </td> 
        </tr>

        <tr>    
        <td rowspan="2" valign="middle" align="center">
          <strong><br> Referencia a la Norma '.SESSION("norma").'</strong>
        </td>

        <td height="25" valign="middle">
          <strong> '.SESSION("rev").'</strong>
        </td>  
        </tr>

        <tr>
          <td valign="top">
          <strong> Página '.$this->getAliasNumPage().' de '.$this->getAliasNbPages().'</strong>
        </td>
        </tr>
      </table>
      
      ';
       $this->writeHTML($html, true, false, true, false, '');
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'N', 12);
        // Page number
        $this->Cell(0, 10, SESSION("codigo")."                                                ".SESSION("rev") , 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}



class Pdf_Controller extends ZP_Controller {
	
	public function __construct() {
		$this->app("admin");
		$this->Admin_Model = $this->model("Admin_Model");
	}
	
	public function formatos($for, $club=NULL, $periodo=NULL)
 	{

 		switch($for)
 		{
 			case 'lista':
	 			if (!SESSION('user_admin') && !SESSION('usuario_promotor'))
				return redirect(get('webURL') .  _sh .'admin/login');

				//consulta de alumnos inscritos y datos del club en el club $club y en el periodo $periodo
 				$data = $this->Admin_Model->getAlumnosClubes2($club, $periodo);

 				//obtiene nombre de promotor si es que es un club del departamento
				$prommotor = $this->Admin_Model->getPromotor($club, $periodo);

				$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
				$pdf->SetCreator(PDF_CREATOR);
				$pdf->SetAuthor('Simpus Soluciones Informaticas');
				$pdf->SetTitle('Lista de alumnos');
				$pdf->SetSubject('Lista');
				$pdf->SetKeywords('lista, extraescolares, clubes, club');
				$pdf->SetHeaderData("logo.png", 15, "RELACIÓN DE ALUMNOS DEL CLUB DE ".$data[0]['nombre_club'],"INSTITUTO TECNOLÓGICO SUPERIOR DE APATZINGÁN\nDEPARTAMENTO DE ACTIVIDADES CULTURALES, DEPORTIVAS Y RECREATIVAS\n".$prommotor[0]['nombre_promotor']." ".$prommotor[0]['apellido_paterno_promotor']." ".$prommotor[0]['apellido_materno_promotor']);
				$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
				$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
				$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
				$pdf->SetMargins(20, PDF_MARGIN_TOP, 20);
				$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
				$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
				$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
				$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
				$pdf->SetFont('helvetica', 'N', 10);
				$pdf->AddPage();
				$html = '
					<br>
					<p align="center">
					RELACIÓN DE ALUMNOS DEL CLUB DE '.$data[0]['nombre_club'].' DEL PERIODO '.$periodo.'  
					</p>
					<table border="1" width="850">
						<tr height="80" align="center">
							<td align="center"><br><br><br>No.</td>
							<td width="100" height = "80"><br><br><br>Número de control</td>
							<td width="360" height = "80"><br><br><br>Nombre del alumno</td>';
							$i=0;
							while($i<18)
							{
								$html .= '<td width="20"></td>';
								$i++;
							}
							$html .='
						</tr>';
						$cont = 0;
						foreach ($data as $row ) {
							
							$html .= '
								<tr>
									<td align="center">'.++$cont.'</td>
									<td align="center"> '.$row['numero_control'].'</td>
									<td> '.$row['apellido_paterno_alumno'].' '.$row['apellido_materno_alumno'].' '.$row['nombre_alumno'].'</td>';
									
							for($i = 0; $i < 18; $i++)
								$html .= '<td></td>';	
							$html .='
								
								</tr>
								';
						}
						$html .= '</table>';
					
				$pdf->writeHTML($html, true, false, true, false, '');
				$pdf->lastPage();
				$pdf->Output("lista".$club.$periodo.".pdf", 'I');
 			break;
 			case 'cedula':
 				if (!SESSION('user_admin'))
				return redirect(get('webURL') .  _sh .'admin/login');

				include(_pathwww."/lib/funciones/CedulaInscripcion.php");

				$pdf->Output("cedins_".$data[0]['nombre_club']."_".$periodo.".pdf", 'I');
 			break;
 			case 'resultados':
	 			if (!SESSION('user_admin'))
				return redirect(get('webURL') .  _sh .'admin/login');

				include(_pathwww.'/lib/funciones/CedulaResultado.php');
 				
				$pdf->Output("cedres".$promotor[0]['nombre_club'].$periodo.".pdf", 'I');
 			break;
 			case 'liberacion':
 				//seguridad
	 			if (!SESSION('user_admin'))
				return redirect(get('webURL') .  _sh .'admin/login');

				$folio = $club;
				include(_pathwww.'/lib/funciones/FormatoAcreditacion.php');
				$pdf->Output($row[0]['numero_control']."_".$row[0]['nombre_club']."_".$periodo.".pdf", 'I');
 			break;
 			case "zip-lib":
					$folio = $club;
				    include(_pathwww.'/lib/funciones/FormatoAcreditacion.php');
				    $pdf->Output(_spath.'/temp/' .$row[0]['numero_control'] ."_". $folio . '.pdf', 'F');				    
 			break;
 			case "zip-lib-desc":
 				$ruta = _spath."/temp/";

 				$zip = new ZipArchive();
				$filename = "BoletasAcreditacion_".$periodo."_".$club.".zip";
				$zip->open($ruta.$filename, ZipArchive::CREATE);

 				$directorio = opendir($ruta); 
				while ($archivo = readdir($directorio)) 
				{
				    if (!is_dir($archivo))
				    {
				    	$archivo_ruta = _spath.'/temp/'.$archivo;
				    	$zip->addFile($archivo_ruta, $archivo);
				    }
				}
				$zip->close();
 			break;
 			case "zip-ins":
				//$ruta = _spath."/temp/".$filename;
				include(_pathwww.'/lib/funciones/CedulaInscripcion.php');
				$pdf->Output (_spath.'/temp/cedins_' . $periodo ."_". POST('nombre_club').'.pdf', 'F');
 			break;
 			case "zip-ins-desc":
 				$ruta = _spath."/temp/";

 				$zip = new ZipArchive();
				$filename = "CedulasInscripcion_$periodo.zip";
				$zip->open($ruta.$filename, ZipArchive::CREATE);

 				$directorio = opendir($ruta); 
				while ($archivo = readdir($directorio)) 
				{
				    if (!is_dir($archivo))
				    {
				    	$archivo_ruta = _spath.'/temp/'.$archivo;
				    	$zip->addFile($archivo_ruta, $archivo);
				    }
				}
				$zip->close();
 			break;
 			case "re-temp":
 				//eliminar archivos temporales
 				$files = glob(_spath.'/temp/*'); 
				foreach($files as $file){ 
				  if(is_file($file))
				    unlink($file); 
				}
 			break;
 			case "zip-res":
 				//$ruta = _spath."/temp/".$filename;
				include(_pathwww.'/lib/funciones/CedulaResultado.php');
				$pdf->Output (_spath.'/temp/cedres_' . $periodo ."_". POST('nombre_club') .'.pdf', 'F');
 			break;
 			case "zip-res-desc":
 				$ruta = _spath."/temp/";

 				$zip = new ZipArchive();
				$filename = "CedulasResultados_$periodo.zip";
				$zip->open($ruta.$filename, ZipArchive::CREATE);

 				$directorio = opendir($ruta); 
				while ($archivo = readdir($directorio)) 
				{
				    if (!is_dir($archivo))
				    {
				    	$archivo_ruta = _spath.'/temp/'.$archivo;
				    	$zip->addFile($archivo_ruta, $archivo);
				    }
				}
				$zip->close();
 			break;
 		}
 	}

}
