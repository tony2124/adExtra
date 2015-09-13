<?php
if(!defined("_access")) {
	die("Error: You don't have permission to access here...");
}

include(_pathwww.'/lib/funciones/funciones.php');


class Admin_Controller extends ZP_Controller {
	
	public function __construct() {
		$this->app("admin");
		$this->Templates = $this->core("Templates");
		$this->Templates->theme();
		$this->Admin_Model = $this->model("Admin_Model");
	}
	
	public function index() {	
		
		if( SESSION('user_admin') )
			return redirect(get('webURL') .  _sh .'admin/estadistica');

		redirect(get('webURL') . _sh . 'admin/login');
	}

	public function subirfoto(){
		// Define a destination
		$tipo = $_POST['tipo'];
		$club = $_POST['club'];
		$album = $_POST['album'];

		$targetFolder = '/extra/img/galeria/'.$club.'/'.$album.'/'; // Relative to the root 
		mysql_connect("localhost","root","simpus2124");

		mysql_select_db("itsaextr_extra");

		if (!empty($_FILES)) {
			$tempFile = $_FILES['Filedata']['tmp_name'];

			$name = $_FILES['Filedata']['name'];
			$ext = explode(".",$name);				 		
			$id = uniqid(); //date("YmdHis").rand(0,100).rand(0,100);
			$name = $id.".".$ext[1];

			$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
			mkdir($targetPath,0700);
			$targetFile = rtrim($targetPath,'/') . '/' . $name;
			
				// Validate the file type
			$fileTypes = array('jpg','jpeg','JPG','JPEG', 'PNG','png'); // File extensions
			$fileParts = pathinfo($_FILES['Filedata']['name']);
			  
			if (in_array($fileParts['extension'],$fileTypes)) {
			    move_uploaded_file($tempFile,$targetFile);
			    createThumbs($targetPath, $name, $targetPath,800);
			    createThumbs($targetPath, $name, $targetPath."/thumbs/",200);
			    $query = "INSERT into galeria values('$id','$name','$album','".date("Y-m-d")."','1','')";
			    mysql_query($query) or die(mysql_error());
			    echo '1';
			  } else {
			    echo 'Invalid file type.';
			  }
		}
	}


/*INICIO DE SESION-*/
	public function logout() {
		unsetSessions(get('webURL') . _sh . 'admin');
	}

	function login()
	{
		if (SESSION('user_admin'))
			return redirect(get('webURL') .  _sh .'admin/estadistica');

		$vars['view'] = $this->view("login",true);
		$vars['error'] = '0';
		$this->render("noRightContent", $vars);
	} 

	public function iniciarsesion()
	{
		$usuario = POST('usuario');
		$clave = POST('clave');
		$data = $this->Admin_Model->getData($usuario);

		if (crypt($clave, $data[0]['contrasena_administrador']) == $data[0]['contrasena_administrador'])
		{
			SESSION('user_admin',$data[0]['usuario_administrador']);
			SESSION('id_admin',$data[0]['id_administrador']);
			SESSION('name_admin',$data[0]['nombre_administrador']);
			SESSION('last1_admin',$data[0]['apellido_paterno_administrador']);
			SESSION('last2_admin',$data[0]['apellido_materno_administrador']);
			SESSION('profesion_admin',$data[0]['abreviatura_profesion']);
			return redirect(get('webURL') .  _sh .'admin/estadistica');
		}
		
		$vars['view'] = $this->view("login",true);
		$vars['error'] = '1';
		$this->render("noRightContent", $vars);

	}



/************* ESTADISTICA  ***********/
	public function estadistica($periodo = NULL)
	{
		if (!SESSION('user_admin'))
			return redirect(get('webURL') .  _sh .'admin/login');

		//$configuracion = $this->Admin_Model->getConfiguracion();
		//si no existe periodo calcular periodo actual

		if(!isset($periodo)) 
		{
			$periodo = periodo_actual();
		}

		$periodos_grafico = periodos("2".( substr(date("Y"),2,2) - 1)."2");

		$clubes = $this->Admin_Model->getClubes('all');
		$alumnos = $this->Admin_Model->getAlumnosInscritos( array($periodo) );
		$todos_alumnos = $this->Admin_Model->getAlumnosInscritos( $periodos_grafico );
		$carreras = $this->Admin_Model->getCarreras(NULL, false);
		$clubesdescarga = $this->Admin_Model->getClubes();

		/***** SELECCION DE PERIODOS AGREGADOS EN LA BD *****/
		$periodossss = $this->Admin_Model->getPeriodos();
		$i = 0;
		if(strcmp($periodossss[0]['periodo'], periodo_actual()) != 0)
		{
			$periodos[$i] = periodo_actual();
			$i++;
		}

		foreach ($periodossss as $per) {
			$periodos[$i] = $per['periodo']; 
			$i++;
		}
		$vars["periodos"] = $periodos; //periodos_combo("2082");
		/****************************************************/
		
		$vars["view"]	 = $this->view("estadistica3", TRUE);
		$vars["periodo"] = $periodo;
		$vars["clubes"] = $clubes;
		$vars["clubesdescarga"] = $clubesdescarga;
		$vars["alumnos"] = $alumnos;
		
		$vars["carreras"] = $carreras;
		$vars["todos_alumnos"] = $alumnos;

		$vars["menu"] = 1;
		$this->render("content", $vars);
	}

	
	/******LISTAS *********/
	public function listaclub($club = NULL, $periodo = NULL)
	{
		if (!SESSION('user_admin'))
			return redirect(get('webURL') .  _sh .'admin/login');

		$clubes = $this->Admin_Model->getClubes('all');
		$alumnos = $this->Admin_Model->getAlumnosClubes($club, $periodo);
		/***** SELECCION DE PERIODOS AGREGADOS EN LA BD *****/
		$periodossss = $this->Admin_Model->getPeriodos();
		$i = 0;
		if(strcmp($periodossss[0]['periodo'], periodo_actual()) != 0)
		{
			$periodos[$i] = periodo_actual();
			$i++;
		}

		foreach ($periodossss as $per) {
			$periodos[$i] = $per['periodo']; 
			$i++;
		}

		$vars["periodos"] = $periodos; //periodos_combo("2082");
		/****************************************************/
		$vars['par1'] = $club;
		$vars['par2'] = $periodo;
		$vars['alumnos'] = $alumnos;
		$vars['clubes'] = $clubes;
		$vars['promotorasignado'] = $this->Admin_Model->getPromotorAsignado($club, $periodo);
		$vars['view'] = $this->view("listaclub", true);
		$vars["menu"] = 2;
		$this->render("content", $vars);
 	}

 	/***** REGISTRO DE NUEVO ALUMNO ********/
 	public function formRegistroAlumno()
	{
		if (!SESSION('user_admin'))
			return redirect(get('webURL') .  _sh .'admin/login');

		$vars['carreras'] = $this->Admin_Model->getCarreras(NULL, false);
		$vars['view'] = $this->view('registroalumno',true);
		$vars['menu'] = 2;
		$this->render("content",$vars);
	}




 	public function listacarrera($carrera = NULL, $periodo = NULL)
	{
		if (!SESSION('user_admin'))
			return redirect(get('webURL') .  _sh .'admin/login');

		$carreras = $this->Admin_Model->getCarreras(NULL, false);
		$alumnos = $this->Admin_Model->getAlumnosCarreras($carrera, $periodo);
		/***** SELECCION DE PERIODOS AGREGADOS EN LA BD *****/
		$periodossss = $this->Admin_Model->getPeriodos();
		$i = 0;
		if(strcmp($periodossss[0]['periodo'], periodo_actual()) != 0)
		{
			$periodos[$i] = periodo_actual();
			$i++;
		}

		foreach ($periodossss as $per) {
			$periodos[$i] = $per['periodo']; 
			$i++;
		}

		$vars["periodos"] = $periodos; //periodos_combo("2082");
		/****************************************************/
		$vars['par1'] = $carrera;
		$vars['par2'] = $periodo;
		$vars['alumnos'] = $alumnos;
		$vars['carreras'] = $carreras;
		//$vars['periodos'] = periodos('2083');
		$vars["menu"] = 2;
		$vars['view'] = $this->view("listacarrera", true);
		$this->render("content", $vars);
 	}


/* PROMOTORES */
	function promotores($buscar = "")
	{
		if( !SESSION('user_admin') )
			return redirect(get('webURL') . _sh . 'admin/login');

		if( POST('buscar') != null )
			$buscar = POST('buscar');
		$vars['promotores']  = $this->Admin_Model->obtenerListaPromotores($buscar);
		$vars['buscar'] = $buscar;
		$vars['menu'] = 3;
		$vars['view'] = $this->view('promotores',true);
		$this->render('content', $vars);
	}

	function verpromotor($id)
	{
		if( !SESSION('user_admin') )
			return redirect(get('webURL') . _sh . 'admin/login');

		
		$result  = $this->Admin_Model->getpromotorId($id);
		$vars['promotor'] = $result[0];

		$result  = $this->Admin_Model->getHistorialPromotor($id);
		$vars['historial'] = $result;
		//____($vars['promotor']);
		$vars['menu'] = 3;
		$vars['view'] = $this->view('verpromotor',true);
		$this->render('content', $vars);
	}

	function habilitarpromotor($id, $dato)
	{
		if( !SESSION('user_admin') )
			return redirect(get('webURL') . _sh . 'admin/login');

		$this->Admin_Model->habilitarpromotor($id, $dato);
		redirect(get('webURL'). _sh . 'admin/promotores');
		
	}

	function guardarHorario($periodo)
	{
		$vars['club'] = POST('club');
		$vars['promotor'] = POST('promotor');
		$vars['lugar'] = POST('lugar');
		$vars['horario'] = POST('horario');
		$vars['periodo'] = $periodo;
		$this->Admin_Model->guardarHorario($vars);
	}


	function formHorarios($periodo = NULL){
		if( !SESSION('user_admin') )
			return redirect(get('webURL') . _sh . 'admin/login');

		/***** SELECCION DE PERIODOS AGREGADOS EN LA BD *****/
		/***** SELECCION DE PERIODOS AGREGADOS EN LA BD *****/
		$periodossss = $this->Admin_Model->getPeriodos();
		$i = 0;
		if(strcmp($periodossss[0]['periodo'], periodo_actual()) != 0)
		{
			$periodos[$i] = periodo_actual();
			$i++;
		}

		foreach ($periodossss as $per) {
			$periodos[$i] = $per['periodo']; 
			$i++;
		}



		$periodossss = $this->Admin_Model->getPeriodos();

		$i = 0;
		$bandera = false;
		if(strcmp($periodossss[0]['periodo'], periodo_actual()) != 0)
		{
			$periodos[$i] = periodo_actual();
			$i++;
		}
		foreach ($periodossss as $per) {
			$periodos[$i] = $per['periodo']; 
			$i++;
		}
		
		$vars['periodo_anterior'] = $periodos[1];	
		
		
		$vars["periodos"] = $periodos; //periodos_combo("2082");
		/****************************************************/
		if($periodo == NULL)
			$vars['periodo'] = periodo_actual();
		else if($periodo != 1)
			$vars['periodo'] = $periodo;
			else $vars['periodo'] = periodo_actual();

		if($periodo == 1)
		{
			$vars['promotores']  = $this->Admin_Model->getPromotores($vars['periodo_anterior']);
			$vars["mostrar_datos"] = 1;
		}
		else
			$vars['promotores']  = $this->Admin_Model->getPromotores($vars['periodo']);
		$vars['todos_promotores'] = $this->Admin_Model->getPromotores("all");
		$vars['promotores_actuales'] = $this->Admin_Model->getPromotores(NULL);
		$vars['clubes'] = $this->Admin_Model->getClubes();

		$vars['menu'] = 3;
		$vars['view'] = $this->view('horarios',true);
		$this->render('noRightContent', $vars);
	}

/*
	function buscar_promotor()
	{
		if( !SESSION('user_admin') )
			return redirect(get('webURL') . _sh . 'admin/login');

		$palabra = POST("nombre");
		redirect(get("webURL")._sh."admin/promotores/".$palabra);
	}
/*
	public function elimPromotor()
	{
		if( !SESSION('user_admin') )
			return redirect(get('webURL') . _sh . 'admin/login');

		$usuario_promotor = POST('usuario_promotor');
		$this->Admin_Model->elimPromotor($usuario_promotor);
		redirect(get('webURL'). _sh . 'admin/promotores');
	}*/

	public function formRegistroPromotor()
	{
		if( !SESSION('user_admin') )
			return redirect(get('webURL') . _sh . 'admin/login');

		$vars['clubes'] = $this->Admin_Model->getClubesProm();
		$vars['menu'] = 3;
		$vars['view'] = $this->view('registroPromotor', true);
		$this->render('content', $vars);
	}

	public function formEdicionPromotor($id)
	{
		if( !SESSION('user_admin') )
			return redirect(get('webURL') . _sh . 'admin/login');

		$data = $this->Admin_Model->getPromotorId($id);
		$vars['promotor'] = $data[0];
		$vars['clubes'] = $this->Admin_Model->getClubes();
		$vars['menu'] = 3;
		$vars['view'] = $this->view('editPromotor', true);
		$this->render('content', $vars);
	}

	public function editProm()
	{
		if( !SESSION('user_admin') )
			return redirect(get('webURL') . _sh . 'admin/login');

		$name = "nofoto.jpg";

		if( strcmp(POST('mantener'), "S") != 0 )
		if (FILES("foto", "tmp_name")) 
		{
		    $path = _spath.'/img/promotores/';  
		    $tmp_name = $_FILES["foto"]["tmp_name"];
			$name = $_FILES["foto"]["name"];
	
			$ext = explode(".",$name);		
			if($ext[1]=='JPG' || $ext[1]=='jpg')
			{		 		
				$id = date("YmdHis").rand(0,100).rand(0,100);
				$name = $id.".".$ext[1];

				move_uploaded_file($tmp_name, $path.$name); # Guardar el archivo en una ubicaci�n, debe tener los permisos necesarios
				chmod($path.$name,0777);

				$rutaImagenOriginal = $path.$name;
				$img_original = imagecreatefromjpeg($rutaImagenOriginal);
				$max_ancho = 200;
				$max_alto = 200;
				list($ancho,$alto) = getimagesize($rutaImagenOriginal);
				$x_ratio = $max_ancho /$ancho;
				$y_ratio = $max_alto / $alto;
				if(($ancho <= $max_ancho) && ($alto <= $max_alto))
				{
					$ancho_final = $ancho;
					$alto_final = $alto;
				}
				elseif(($x_ratio * $alto) <$max_alto)
				{
					$alto_final = ceil($x_ratio * $alto);
					$ancho_final = $max_ancho;
				}
				else 
				{
					$ancho_final = ceil($y_ratio*$ancho);
					$alto_final = $max_alto;
				}

				$tmp = imagecreatetruecolor($ancho_final,$alto_final);
				imagecopyresampled($tmp, $img_original, 0, 0, 0, 0, $ancho_final, $alto_final, $ancho, $alto);
				imagedestroy($img_original);
				$calidad = 95;
				imagejpeg($tmp,$path."tm".$name,$calidad);
				chmod($path."tm".$name,0777);
				unlink($path.$name);
				$name = "tm".$name;
			}else $name="nofoto.jpg";
		}

		$vars['usuario'] = POST('user');
		$vars['usuarionuevo'] = POST('usernew');
		$vars['pass'] = POST('pass');
		$vars['foto'] = $name;
		$vars['nombre'] = strtoupper(POST('nombre'));
		$vars['ap'] = strtoupper(POST('ap'));
		$vars['am'] = strtoupper(POST('am'));
		$vars['fecha_nac'] = POST('fecha_nac');
		$vars['fecha_reg'] = date("Y-m-d");
		$vars['sexo'] = POST('sexo');
		//$vars['club'] = POST('club');
		$vars['sexo'] = POST('sexo');
		$vars['email'] = POST('email');
		$vars['tel'] = POST('tel');
		$vars['direccion'] = POST('direccion');
		$vars['ocupacion'] = strtoupper(POST('ocupacion'));
		//____($vars);
		if( strcmp(POST('mantener'), "S") != 0 )
			$this->Admin_Model->updatePromotor($vars);
		if( strcmp(POST('mantener'), "S") == 0 )
			$this->Admin_Model->updatePromotorMantener($vars);
		redirect(get('webURL'). _sh . 'admin/promotores');
	}
	

	public function regProm()
	{
		if( !SESSION('user_admin') )
			return redirect(get('webURL') . _sh . 'admin/login');

		$name = "";

		if (FILES("foto", "tmp_name")) 
		{
		    $path = _spath.'/img/promotores/';  
		    $tmp_name = $_FILES["foto"]["tmp_name"];
			$name = $_FILES["foto"]["name"];
	
			$ext = explode(".",$name);		
			if($ext[1]=='JPG' || $ext[1]=='jpg')
			{		 		
				$id = date("YmdHis").rand(0,100).rand(0,100);
				$name = $id.".".$ext[1];

				move_uploaded_file($tmp_name, $path.$name); # Guardar el archivo en una ubicaci�n, debe tener los permisos necesarios
				chmod($path.$name,0777);

				$rutaImagenOriginal = $path.$name;
				$img_original = imagecreatefromjpeg($rutaImagenOriginal);
				$max_ancho = 200;
				$max_alto = 200;
				list($ancho,$alto) = getimagesize($rutaImagenOriginal);
				$x_ratio = $max_ancho /$ancho;
				$y_ratio = $max_alto / $alto;
				if(($ancho <= $max_ancho) && ($alto <= $max_alto))
				{
					$ancho_final = $ancho;
					$alto_final = $alto;
				}
				elseif(($x_ratio * $alto) <$max_alto)
				{
					$alto_final = ceil($x_ratio * $alto);
					$ancho_final = $max_ancho;
				}
				else 
				{
					$ancho_final = ceil($y_ratio*$ancho);
					$alto_final = $max_alto;
				}

				$tmp = imagecreatetruecolor($ancho_final,$alto_final);
				imagecopyresampled($tmp, $img_original, 0, 0, 0, 0, $ancho_final, $alto_final, $ancho, $alto);
				imagedestroy($img_original);
				$calidad = 95;
				imagejpeg($tmp,$path."tm".$name,$calidad);
				chmod($path."tm".$name,0777);
				unlink($path.$name);
				$name = "tm".$name;
			}else $name="nofoto.jpg"; 

		}

		$vars['user'] = POST('user');
		$vars['pass'] = POST('pass');
		$vars['foto'] = $name;
		$vars['nombre'] = strtoupper(POST('nombre'));
		$vars['ap'] = strtoupper(POST('ap'));
		$vars['am'] = strtoupper(POST('am'));
		$vars['fecha_nac'] = POST('fecha_nac');
		$vars['fecha_reg'] = date("Y-m-d");
		$vars['sexo'] = POST('sexo');
		//$vars['club'] = POST('club');
		$vars['sexo'] = POST('sexo');
		$vars['email'] = POST('email');
		$vars['tel'] = POST('tel');
		$vars['direccion'] = POST('direccion');
		$vars['ocupacion'] = POST('ocupacion');
		print $this->Admin_Model->regPromotor($vars);
		redirect(get('webURL'). _sh . 'admin/promotores');
	}



	
	/* ALUMNOS  **/
	public function buscar()
	{
		if (!SESSION('user_admin'))
			return redirect(get('webURL') .  _sh .'admin/login');

		$busqueda = POST('bus');
		$sit = POST('sit');

		if(!POST('sit')) $sit='1';
		$error = NULL;
		if($busqueda=='') $error = 1;

		$datos = $this->Admin_Model->getRespuesta($busqueda,$sit);
		
		/***************** variables **********************/
		$vars["error"] = $error;
		$vars["palabra"] = $busqueda;
		
		$vars["datos"] = $datos;
		
		$vars["view"] = $this->view("busquedaAlumnos",true);
		/*****************************************************/
		$vars['menu'] = 0;

		$this->render("content",$vars);
	}

	public function alumno($nctrl = NULL)
	{
		if (!SESSION('user_admin'))
			return redirect(get('webURL') .  _sh .'admin/login');
		//include(_corePath . _sh .'/libraries/funciones/funciones.php');
		$datos = $this->Admin_Model->getAlumno($nctrl);
		$inscripciones = $this->Admin_Model->getClubesInscritosAlumno($nctrl);
		$clubes = $this->Admin_Model->getClubes('all');

		$vars["carreras"] = $this->Admin_Model->getCarreras(NULL, false);

		$vars["nombreAlumno"] = $datos[0]['apellido_paterno_alumno'].' '.$datos[0]['apellido_materno_alumno'].' '.$datos[0]['nombre_alumno'];
		$vars["periodos"] = periodos($datos[0]['fecha_inscripcion']);
		$vars['clubes'] = $clubes;
		$vars["alumno"] = $datos[0];
		$vars["inscripciones"] = $inscripciones;
		$vars['menu'] = 0;

		$vars["view"] = $this->view("alumno",true);

		$this->render("content",$vars);
	}

	public function revisiones($id = NULL)
	{
		if (!SESSION('user_admin'))
			return redirect(get('webURL') .  _sh .'admin/login');
		//include(_corePath . _sh .'/libraries/funciones/funciones.php');
		
		$vars['revactual'] = $this->Admin_Model->getRevision($id);

		$vars['type'] = $id;

 		$formatos = $this->Admin_Model->getFormatos();
		$revisiones = $this->Admin_Model->getRevisiones();
		$vars['formatos'] = $formatos;
		$vars['revisiones'] = $revisiones;
		$vars['menu'] = 4;

		$vars["view"] = $this->view("revisiones",true);

		$this->render("content",$vars);
	}

	public function guardarRevision()
	{
		if( !SESSION('user_admin') )
			return redirect(get('webURL') . _sh . 'admin/login');

		$vars['nombre'] = POST("nombre");
		$vars['codigo'] = POST("codigo");
		$vars['norma'] = POST("norma");
		$vars['tipo_formato'] = POST("tipo_formato");
		$vars['fecha'] = POST("fecha");

		$this->Admin_Model->guardarRevision($vars);
		//____($vars);
		redirect(get('webURL')._sh.'admin/revisiones/success');
	}

	public function actualizarRevision($id)
	{
		if( !SESSION('user_admin') )
			return redirect(get('webURL') . _sh . 'admin/login');

		$vars['nombre'] = POST("nombre");
		$vars['codigo'] = POST("codigo");
		$vars['norma'] = POST("norma");
		$vars['tipo_formato'] = POST("tipo_formato");
		$vars['fecha'] = POST("fecha");

		$this->Admin_Model->actualizarRevision($vars, $id);
		//____($vars);
		redirect(get('webURL')._sh.'admin/revisiones');
	}


	public function regisalumno()
	{
		if (!SESSION('user_admin'))
			return redirect(get('webURL') .  _sh .'admin/login');

		$vars['numero_control'] = POST('numero_control');
		$vars['nombre'] = strtoupper(POST('nombre'));
		$vars['ap'] = strtoupper(POST('ap'));
		$vars['am'] = strtoupper(POST('am'));
		$vars['fecha_nac'] = POST('fecha_nac');
		$vars['fecha_ins'] = '2'.substr(POST('numero_control'), 0, 2).'3';
		$vars['sexo'] = POST('sexo');
		$vars['email'] = POST('email');
		$vars['se'] = POST('se');
		$vars['clave'] = POST('clave');
		$vars['car'] = POST('carrera');
		
		$this->Admin_Model->regAlumno($vars);
		redirect(get('webURL').'/admin/alumno/'.$vars['numero_control']);
	}

	public function editalumno()
	{
		if (!SESSION('user_admin'))
			return redirect(get('webURL') .  _sh .'admin/login');

		$vars['numero_control'] = POST('numero_control');
		$vars['numero_control_ant'] = POST('numero_control_ant');
		$vars['nombre'] = POST('nombre');
		$vars['ap'] = POST('ap');
		$vars['am'] = POST('am');
		$vars['car'] = POST('carrera');
		$vars['fecha_nac'] = POST('fecha_nac');
		$vars['sexo'] = POST('sexo');
		$vars['email'] = POST('email');
		$vars['se'] = POST('se');
		$vars['clave'] = POST('clave');
		//____($vars);
		$this->Admin_Model->updateAlumno($vars);

		redirect(get('webURL').'/admin/alumno/'.$vars['numero_control']);
	}


	/*OPERACIONES DE ACTIVIDADES / CLUBES  **/
	public function inscipcionActividad()
	{
		if( !SESSION('user_admin') )
			return redirect(get('webURL') . _sh . 'admin/login');

		$vars['numero_control'] = POST('numero_control');
		$vars['id_administrador'] = SESSION('id_admin');
		$vars['club'] = POST('actividad');
		$vars['periodo'] = POST('periodo');
		$vars['semestre'] = POST('semestre');
		$vars['fecha_inscripcion'] = date('Y-m-d');
		$vars['fecha_modificacion'] = date('Y-m-d');
		$vars['observaciones'] = str_replace( "'", "\"", $_POST['obsIns']);
		$vars['acreditado'] = POST('acreditado');
		print $this->Admin_Model->inscribirActividad($vars);
		redirect(get('webURL').'/admin/alumno/'.POST('numero_control'));
	}
	
	

	public function editActividad()
	{

		if (!SESSION('user_admin'))
			return redirect(get('webURL') .  _sh .'admin/login');

		$folio = POST('folio');
		$numero_control = POST('nc');
		$club=POST('actividad');
		print $this->Admin_Model->updateActividad($folio, $club);
		redirect(get('webURL').'/admin/alumno/'.$numero_control);
	}

	public function elimActividad()
	{
		if( !SESSION('user_admin') )
			return redirect(get('webURL') . _sh . 'admin/login');

		$folio = POST('folio');
		$nc=POST("nc");
		$this->Admin_Model->elimActividad($folio);
		redirect(get('webURL'). _sh . 'admin/alumno/'.$nc);
	}

	public function editResultado()
	{
		if (!SESSION('user_admin'))
			return redirect(get('webURL') .  _sh .'admin/login');

		$resultado = POST('acreditado');
		$folio = POST('folio');
		$numero_control = POST('numero_control');
		$obs = str_replace( "'", "\"", $_POST['obs']);
		$fecha_lib = date("Y-m-d");
		print $this->Admin_Model->updateRes($resultado, $folio, $obs, $fecha_lib);
		redirect(get('webURL').'/admin/alumno/'.$numero_control);
	}

	public function fech_liberacion($tipo)
	{
		if( !SESSION('user_admin') )
			return redirect(get('webURL') . _sh . 'admin/login');

		$vars['ins_ini'] = POST('ins_ini');
		$vars['ins_fin'] = POST('ins_fin');
		$vars['lib_ini'] = POST('lib_ini');
		$vars['lib_fin'] = POST('lib_fin');
		$vars['periodo'] = POST('periodo');
		$vars['nper'] = POST('nper');
		//____($vars);
		if($tipo == 1)
			$this->Admin_Model->updateLiberacion($vars);
		else
			$this->Admin_Model->insertarLiberacion($vars);
		
		redirect(get('webURL')._sh.'admin/configLiberacion/'.$vars['periodo']."/success");
	}

	/*/***** ADMINISTRACION DEL SITIO ***/
	public function avisos()
 	{
 		if( !SESSION('user_admin') )
			return redirect(get('webURL') . _sh . 'admin/login');

 		$mensaje = $this->Admin_Model->getAviso();
 		$conf = $this->Admin_Model->getConfiguracion();
 		$vars['conf'] = $conf[0];
 		$vars['mensaje'] = $mensaje[0]; 
 		$vars['view'] = $this->view('avisos',true);
 		$vars['menu'] = 6;
 		$this->render('content', $vars);
 	}

	public function guardarAviso()
	{
		if( !SESSION('user_admin') )
			return redirect(get('webURL') . _sh . 'admin/login');

		$cuerpo =str_replace( "'", "\"",  $_POST['aviso'] );
		$mostrar = POST('mostrarAviso');
		if($mostrar) $mostrar = 1; else $mostrar = 0;
		$this->Admin_Model->guardarAviso($cuerpo, $mostrar);
		redirect(get('webURL')._sh.'admin/avisos');
	}

	public function subirBD($data = NULL)
	{
		if( !SESSION('user_admin') )
			return redirect(get('webURL') . _sh . 'admin/login');
		if($data != NULL)
			$vars['estado'] = 1;

		$vars['view'] = $this->view('subiralumnos',true);
		$vars['menu'] = 0;
 		$this->render('content', $vars);

	}

	public function subiendoBD()
	{
		if( !SESSION('user_admin') )
			return redirect(get('webURL') . _sh . 'admin/login');
		
		if(is_uploaded_file($_FILES['archivo']['tmp_name']))
		{
			$nombre = $_FILES['archivo']['name'];
			$arreglo = explode(".", $nombre);
			$tempname = "datos." . $arreglo[1];
			move_uploaded_file($_FILES['archivo']['tmp_name'], _spath.'/datos/'.$tempname);

		}
		$ruta = _spath.'/datos/'.$tempname;
		$this->Admin_Model->subirBDAlumnos($ruta);
		redirect(  get('webURL') . _sh . 'admin/subirBD/ingresado'  );

	}

	public function subirarchivos()
	{
		if( !SESSION('user_admin') )
			return redirect(get('webURL') . _sh . 'admin/login');
		$ruta = _spath.'/descarga/';
		$files = array();
		if (is_dir($ruta)) 
		{
      		if ($dh = opendir($ruta)) 
      		{
      			$i=0;
         		while (($file = readdir($dh)) !== false) 
         		{
            		if($file!="." && $file!="..")
               			$files[$i++] = $file;
         		}
      			closedir($dh);
      		}
   		}
   		$vars['files'] = $files;
		$vars['view'] = $this->view('subirarchivo',true);
		$vars['menu'] = 6;
 		$this->render('content', $vars);
	}

	public function eliminararchivo($archivo)
	{
		if( !SESSION('user_admin') )
			return redirect(get('webURL') . _sh . 'admin/login');
		unlink( _spath . '/descarga/' . $archivo);
		redirect(  get('webURL') . _sh . 'admin/subirarchivos'  );
	}

	public function subiendo()
	{
		if( !SESSION('user_admin') )
			return redirect(get('webURL') . _sh . 'admin/login');
		
		if(is_uploaded_file($_FILES['archivo']['tmp_name']))
		{
			$nombre = $_FILES['archivo']['name'];
			$arreglo = explode(".", $nombre);
			$tempname = $arreglo[0];
			$caracteres = array("ñ","Ñ"," ","á","é","í","ó","ú","Á","É","Í","Ó","Ú");
			$tempname = str_replace($caracteres, "_", $tempname);

			$tempname = $tempname . "." . $arreglo[1];
			move_uploaded_file($_FILES['archivo']['tmp_name'], _spath.'/descarga/'.$tempname);
		}

		
		redirect(  get('webURL') . _sh . 'admin/subirarchivos'  );
	}

	/*************** RESPALDO DE LA BD  ***************/

	public function respaldoBD()
	{
		if( !SESSION('user_admin') )
			return redirect(get('webURL') . _sh . 'admin/login');
		
		$ruta = _spath.'/respaldos/';
		$files = array();

		if (is_dir($ruta)) 
		{
      		if ($dh = opendir($ruta)) 
      		{
      			$i=0;
         		while (($file = readdir($dh)) !== false) 
         		{
            		if($file!="." && $file!=".." && $file!="index.html")
               			$files[$i++] = $file;
         		}
      			closedir($dh);
      		}
   		}

   		$vars['files'] = $files;
   		$vars['menu'] = 0;
		$vars['view'] = $this->view("respaldobd",true);
		$this->render("content", $vars);
	}

	public function eliminarrespaldo($archivo)
	{
		if( !SESSION('user_admin') )
			return redirect(get('webURL') . _sh . 'admin/login');
		unlink( _spath . '/respaldos/' . $archivo);
		redirect(  get('webURL') . _sh . 'admin/respaldobd'  );
	}

	public function respaldando()
	{
		
		/*$resultado = null;*/
		$name = date("y-m-d_H-i-s");
		
		//$this->Admin_Model->hacerespaldo( _spath.'/respaldos/'.$name );
		

		$usuario = "root";


		$passwd = "";
		$host = "localhost";
		$bd = "itsaextr_extra";

		$executa = "mysqldump -h ". $host ." -u ".$usuario." -p ".$passwd." ".$bd." > "._spath.'/respaldos/'.$name.".sql";
		$resultado = system($executa); 
		if($resultado) 
		print "Error al ejecutar comando:   "  . $executa;
		else redirect( get('webURL') . _sh . 'admin/respaldoBD' );
		//redirect( get('webURL') . _sh . 'admin/respaldoBD' );
	}


	/********* NOTICIAS   ****///

	public function noticias($id = NULL)
	{
		if (!SESSION('user_admin'))
			return redirect(get('webURL') .  _sh .'admin/login');

		$noticias = $this->Admin_Model->getNoticias();
		$vars['noticias'] = $noticias;
		$vars['view'] = $this->view("noticias",true);
		$vars['id'] = NULL;
		if($id)
		{
			$vars['id'] = $id;
			$n = $this->Admin_Model->getNoticia($id);
			$vars['modnot'] = $n[0];
		} 
		$vars['menu'] = 6;

		$this->render("content", $vars);
	}


	public function vernoticia($id = NULL)
	{
		if (!SESSION('user_admin'))
			return redirect(get('webURL') .  _sh .'admin/login');

		$not = $this->Admin_Model->getNoticia($id);
		$vars['noticia'] = $not[0];
		
		$vars['view'] = $this->view("vernoticia",true);
		$vars['menu'] = 6;

		$this->render("content", $vars);
	}

	public function elimnoticia($id)
	{
		if (!SESSION('user_admin'))
			return redirect(get('webURL') .  _sh .'admin/login');

		$this->Admin_Model->elimNoticia($id);
		redirect(get('webURL')._sh.'admin/noticias');
		
	}



	public function guardarnoticia()
	{
		if (!SESSION('user_admin'))
			return redirect(get('webURL') .  _sh .'admin/login');

		$nombre = $_POST['name'];
		$texto = $_POST['texto']; //porque necesito el código en formato HTML NO FORMATEADO

		$cadena = str_replace( "'", "\"", $texto);
		$nombre = str_replace( "'", "\"", $nombre);

		$name = "";

		if (FILES("foto", "tmp_name")) 
		{
		    $path = _spath.'/IMAGENES/fotosNoticias/';  
		    $tmp_name = $_FILES["foto"]["tmp_name"];
			$name = $_FILES["foto"]["name"];
	
			$ext = explode(".",$name);		
			if($ext[1]=='JPG' || $ext[1]=='jpg')
			{		 		
				$id = date("YmdHis").rand(0,100).rand(0,100);
				$name = $id.".".$ext[1];

				move_uploaded_file($tmp_name, $path.$name); # Guardar el archivo en una ubicaci�n, debe tener los permisos necesarios
				chmod($path.$name,0777);

				$rutaImagenOriginal = $path.$name;
				$img_original = imagecreatefromjpeg($rutaImagenOriginal);
				$max_ancho = 800;
				$max_alto = 800;
				list($ancho,$alto) = getimagesize($rutaImagenOriginal);
				$x_ratio = $max_ancho /$ancho;
				$y_ratio = $max_alto / $alto;
				if(($ancho <= $max_ancho) && ($alto <= $max_alto))
				{
					$ancho_final = $ancho;
					$alto_final = $alto;
				}
				elseif(($x_ratio * $alto) <$max_alto)
				{
					$alto_final = ceil($x_ratio * $alto);
					$ancho_final = $max_ancho;
				}
				else 
				{
					$ancho_final = ceil($y_ratio*$ancho);
					$alto_final = $max_alto;
				}

				$tmp = imagecreatetruecolor($ancho_final,$alto_final);
				imagecopyresampled($tmp, $img_original, 0, 0, 0, 0, $ancho_final, $alto_final, $ancho, $alto);
				imagedestroy($img_original);
				$calidad = 95;
				imagejpeg($tmp,$path."tm".$name,$calidad);
				chmod($path."tm".$name,0777);
				unlink($path.$name);
				$name = "tm".$name;
			}else $name=""; 

		}

		$vars["id_noticias"] = uniqid();
		$vars["nombre_noticia"] = $nombre;
		$vars["texto_noticia"] = $cadena;
		$vars["imagen_noticia"] = $name;
		$vars["fecha_modificacion"] = date("Y-m-d");
		$vars["hora"] = date("H:i:s");
		$vars["id_administrador"] = SESSION('id_admin');

		$this->Admin_Model->saveNew($vars);
		redirect(get('webURL')._sh.'admin/noticias');
	}


	public function modnoticia($id_not)
	{
		if (!SESSION('user_admin'))
			return redirect(get('webURL') .  _sh .'admin/login');

		$nombre = $_POST['name'];
		$cadena = $_POST['texto']; //porque necesito el código en formato HTML NO FORMATEADO
		//____($nombre." ".$texto);
		$cadena = str_replace( "'", "\"", $cadena);
		$nombre = str_replace( "'", "\"", $nombre);

		$name = POST('mostrarfoto');

		if (FILES("foto", "tmp_name")) 
		{
			$path = _spath.'/img/noticias/'; 

		    $tmp_name = $_FILES["foto"]["tmp_name"];
			$name = $_FILES["foto"]["name"];
	
			$ext = explode(".",$name);		
			if($ext[1]=='JPG' || $ext[1]=='jpg')
			{		 		
				$id = date("YmdHis").rand(0,100).rand(0,100);
				$name = $id.".".$ext[1];

				move_uploaded_file($tmp_name, $path.$name); # Guardar el archivo en una ubicaci�n, debe tener los permisos necesarios
				chmod($path.$name,0777);

				$rutaImagenOriginal = $path.$name;
				$img_original = imagecreatefromjpeg($rutaImagenOriginal);
				$max_ancho = 800;
				$max_alto = 800;
				list($ancho,$alto) = getimagesize($rutaImagenOriginal);
				$x_ratio = $max_ancho /$ancho;
				$y_ratio = $max_alto / $alto;
				if(($ancho <= $max_ancho) && ($alto <= $max_alto))
				{
					$ancho_final = $ancho;
					$alto_final = $alto;
				}
				elseif(($x_ratio * $alto) <$max_alto)
				{
					$alto_final = ceil($x_ratio * $alto);
					$ancho_final = $max_ancho;
				}
				else 
				{
					$ancho_final = ceil($y_ratio*$ancho);
					$alto_final = $max_alto;
				}

				$tmp = imagecreatetruecolor($ancho_final,$alto_final);
				imagecopyresampled($tmp, $img_original, 0, 0, 0, 0, $ancho_final, $alto_final, $ancho, $alto);
				imagedestroy($img_original);
				$calidad = 95;
				imagejpeg($tmp,$path."tm".$name,$calidad);
					
				
				chmod($path."tm".$name,0777);
				unlink($path.$name);
				$name = "tm".$name;
			}else $name=""; 

		} 

		$vars["id_noticias"] = $id_not;
		$vars["nombre_noticia"] = $nombre;
		$vars["texto_noticia"] = $cadena;
		$vars["imagen_noticia"] = $name;
		$vars["fecha_modificacion"] = date("Y-m-d");
		$vars["hora"] = date("H:i:s");
		$vars["id_administrador"] = SESSION('id_admin');

		print $this->Admin_Model->updateNew($vars);

		redirect(get('webURL')._sh.'admin/noticias');
	}

	public function carreras($tipo = NULL, $id = NULL)
 	{
 		if( !SESSION('user_admin') )
			return redirect(get('webURL') . _sh . 'admin/login');

		$vars['menu'] = 2;

		if(strcmp($tipo,"nueva-edit") == 0){
			if($id != NULL) 
				$vars['carrera'] = $this->Admin_Model->getCarreras($id,true);
			else 
				$vars['carrera'] = NULL;
			$vars['view'] = $this->view('regcarrera',true);
		}
		else
		{
			$vars['carreras'] = $this->Admin_Model->getCarreras(NULL, true);
	 		$vars['view'] = $this->view('carreras',true);
	 		
	 		
 		}
 		$this->render('content', $vars);
 	}

 	public function reglamento()
 	{
 		if( !SESSION('user_admin') )
			return redirect(get('webURL') . _sh . 'admin/login');
		$reg = $this->Admin_Model->obtenerReglamento();
		$vars['reglamento'] = $reg[0]; 
 		$vars['view'] = $this->view('reglamento',true);
 		$vars['menu'] = 6;
 		$this->render('content', $vars);
 	}

 	public function guardarReglamento()
 	{
 		if( !SESSION('user_admin') )
			return redirect(get('webURL') . _sh . 'admin/login');
		$reg = $_POST['reglamento'];
 		$this->Admin_Model->guardarReglamento($reg);
 		redirect(get('webURL')._sh.'admin/reglamento');
 	}

 	

	/******* CLUBES   *****/

	public function adminclubes($id = NULL)
 	{
 		if( !SESSION('user_admin') )
			return redirect(get('webURL') . _sh . 'admin/login');

		if($id != NULL) $vars['club'] = $this->Admin_Model->obtenerDatosClub($id);
		else $vars['club'] = NULL;
		
		$vars['clubes'] = $this->Admin_Model->getClubes("elim");
 		$vars['view'] = $this->view('adminclubes',true);
 		$vars['menu'] = 3;
 		$this->render('content', $vars);
 	}

	public function guardarclub()
	{
		if (!SESSION('user_admin'))
			return redirect(get('webURL') .  _sh .'admin/login');

		$nombre = $_POST['name'];
		$texto = $_POST['texto']; //porque necesito el código en formato HTML NO FORMATEADO
		$tipo = POST('tipo');
		$cadena = str_replace( "'", "\"", $texto);
		$nombre = str_replace( "'", "\"", $nombre);

		$name = "";

		if (FILES("foto", "tmp_name")) 
		{
		    $path = _spath.'/img/clubes/';  
		    $tmp_name = $_FILES["foto"]["tmp_name"];
			$name = $_FILES["foto"]["name"];
	
			$ext = explode(".",$name);		
			if($ext[1]=='JPG' || $ext[1]=='jpg')
			{		 		
				$id = date("YmdHis").rand(0,100).rand(0,100);
				$name = $id.".".$ext[1];

				move_uploaded_file($tmp_name, $path.$name); # Guardar el archivo en una ubicaci�n, debe tener los permisos necesarios
				chmod($path.$name,0777);

				$rutaImagenOriginal = $path.$name;
				$img_original = imagecreatefromjpeg($rutaImagenOriginal);
				$max_ancho = 800;
				$max_alto = 800;
				list($ancho,$alto) = getimagesize($rutaImagenOriginal);
				$x_ratio = $max_ancho /$ancho;
				$y_ratio = $max_alto / $alto;
				if(($ancho <= $max_ancho) && ($alto <= $max_alto))
				{
					$ancho_final = $ancho;
					$alto_final = $alto;
				}
				elseif(($x_ratio * $alto) <$max_alto)
				{
					$alto_final = ceil($x_ratio * $alto);
					$ancho_final = $max_ancho;
				}
				else 
				{
					$ancho_final = ceil($y_ratio*$ancho);
					$alto_final = $max_alto;
				}

				$tmp = imagecreatetruecolor($ancho_final,$alto_final);
				imagecopyresampled($tmp, $img_original, 0, 0, 0, 0, $ancho_final, $alto_final, $ancho, $alto);
				imagedestroy($img_original);
				$calidad = 95;
				imagejpeg($tmp,$path."tm".$name,$calidad);
				chmod($path."tm".$name,0777);
				unlink($path.$name);
				$name = "tm".$name;
			}else $name=""; 

		}

		$vars["nombre_club"] = $nombre;
		$vars["texto_club"] = $cadena;
		$vars["foto_club"] = $name;
		$vars["fecha_creacion"] = date("Y-m-d");
		$vars["tipo_club"] = $tipo;

	

		if(strcmp($vars["nombre_club"], "") != 0)
			$this->Admin_Model->guardarClub($vars);

		redirect(get('webURL')._sh.'admin/adminclubes');
	}

	public function guardarcarrera()
	{
		if (!SESSION('user_admin'))
			return redirect(get('webURL') .  _sh .'admin/login');

		$id = $_POST['id_carrera'];
		$nombre = strtoupper($_POST['name']);
		$abreviatura = strtoupper(POST('abreviatura'));
		$sem = POST('sem');
		$plan = strtoupper(POST('plan'));

		$abreviatura = str_replace( "'", "\"", $abreviatura);
		$nombre = str_replace( "'", "\"", $nombre);
		$plan = str_replace( "'", "\"", $plan);

		$vars["id"] = $id;
		$vars["nombre_carrera"] = $nombre;
		$vars["abreviatura_carrera"] = $abreviatura;
		$vars["semestres_carrera"] = $sem;
		$vars["plan"] = $plan;
		
		

		if(strcmp($vars["nombre_carrera"], "") != 0 || strcmp($vars["abreviatura_carrera"], "") != 0)
			$this->Admin_Model->guardarcarrera($vars);

		redirect(get('webURL')._sh.'admin/carreras');
	}

	public function modcarrera($id)
	{
		if (!SESSION('user_admin'))
			return redirect(get('webURL') .  _sh .'admin/login');

		$nombre = strtoupper($_POST['name']);
		$abreviatura = strtoupper(POST('abreviatura'));
		$sem = POST('sem');
		$plan = strtoupper(POST('plan'));

		$abreviatura = str_replace( "'", "\"", $abreviatura);
		$nombre = str_replace( "'", "\"", $nombre);
		$plan = str_replace( "'", "\"", $plan);

		$vars["nombre_carrera"] = $nombre;
		$vars["abreviatura_carrera"] = $abreviatura;
		$vars["semestres_carrera"] = $sem;
		$vars["plan"] = $plan;
		$vars["id_carrera"] = $id;
		

		if(strcmp($vars["nombre_carrera"], "") != 0 || strcmp($vars["abreviatura_carrera"], "") != 0)
			$this->Admin_Model->modcarrera($vars);

		redirect(get('webURL')._sh.'admin/carreras');
	}

	public function modclub($id)
	{
		if (!SESSION('user_admin'))
			return redirect(get('webURL') .  _sh .'admin/login');

		$nombre = $_POST['name'];
		$texto = $_POST['texto']; //porque necesito el código en formato HTML NO FORMATEADO
		$tipo = POST('tipo');

		$cadena = str_replace( "'", "\"", $texto);
		$nombre = str_replace( "'", "\"", $nombre);

		$name = POST('mostrarfoto');

		if (FILES("foto", "tmp_name")) 
		{
			$path = _spath.'/img/clubes/'; 

		    $tmp_name = $_FILES["foto"]["tmp_name"];
			$name = $_FILES["foto"]["name"];

			$ext = explode(".",$name);		
			if($ext[1]=='JPG' || $ext[1]=='jpg')
			{		 		
				$id_foto = date("YmdHis").rand(0,100).rand(0,100);
				$name = $id_foto.".".$ext[1];

				move_uploaded_file($tmp_name, $path.$name); # Guardar el archivo en una ubicaci�n, debe tener los permisos necesarios
				chmod($path.$name,0777);

				$rutaImagenOriginal = $path.$name;
				$img_original = imagecreatefromjpeg($rutaImagenOriginal);
				$max_ancho = 500;
				$max_alto = 500;
				list($ancho,$alto) = getimagesize($rutaImagenOriginal);
				$x_ratio = $max_ancho /$ancho;
				$y_ratio = $max_alto / $alto;
				if(($ancho <= $max_ancho) && ($alto <= $max_alto))
				{
					$ancho_final = $ancho;
					$alto_final = $alto;
				}
				elseif(($x_ratio * $alto) <$max_alto)
				{
					$alto_final = ceil($x_ratio * $alto);
					$ancho_final = $max_ancho;
				}
				else 
				{
					$ancho_final = ceil($y_ratio*$ancho);
					$alto_final = $max_alto;
				}

				$tmp = imagecreatetruecolor($ancho_final,$alto_final);
				imagecopyresampled($tmp, $img_original, 0, 0, 0, 0, $ancho_final, $alto_final, $ancho, $alto);
				imagedestroy($img_original);
				$calidad = 95;
				imagejpeg($tmp,$path."tm".$name,$calidad);

				chmod($path."tm".$name,0777);
				unlink($path.$name);
				$name = "tm".$name;
			}else $name=""; 

		} 

		$vars["id_club"] = $id;
		$vars["nombre_club"] = $nombre;
		$vars["texto_club"] = $cadena;
		$vars["foto_club"] = $name;
		$vars["tipo_club"] = $tipo;
		$vars["fecha_modificacion"] = date("Y-m-d");

		$this->Admin_Model->updateClub($vars);

		redirect(get('webURL')._sh.'admin/adminclubes');
	}

	


	public function habilitarClub($id, $estado)
	{
		if( !SESSION('user_admin') )
			return redirect(get('webURL') . _sh . 'admin/login');

		$this->Admin_Model->hclub($id, $estado);
		redirect(get('webURL'). _sh . 'admin/adminclubes');
	}

	public function habilitarCarrera($id, $estado)
	{
		if( !SESSION('user_admin') )
			return redirect(get('webURL') . _sh . 'admin/login');

		$this->Admin_Model->habilitarCarrera($id, $estado);

		redirect(get('webURL'). _sh . 'admin/carreras');
	}


	
	/* GALERIA  */
	public function galeria($tipo=NULL, $club = NULL, $album = NULL, $subalbum = NULL)
 	{
 		if( !SESSION('user_admin') )
			return redirect(get('webURL') . _sh . 'admin/login');

 		$vars['URL']['tipo'] = $tipo;
 		$vars['URL']['club'] = $club;
 		$vars['URL']['album'] = $album;
 		if(isset($tipo)){
 			if($tipo==0)
 			{
 				$data[0]
 				['nombre_club'] = 'GENERAL';
 				$data[0]['id_club'] = '0';

 				$vars['clubes'] = $data;
 			}
 			else
 			{
 				$data = $this->Admin_Model->getClubes($tipo);
 				if($data) $vars['clubes'] = $data;
 			}
 		} 

 		if(isset($club)) {

 			$data = $this->Admin_Model->getAlbumes('club',$club);
 			$vars['albumes'] = $data;
 			
 		}
 		if(isset($album)){
 			$vars['subalbumes'] = $this->Admin_Model->getAlbumes('album', $album);
 			$vars['fotos'] = $this->Admin_Model->getFotos($album);
 		}

 		$vars['view'] = $this->view('galeria',true);
 		$vars['menu'] = 6;
 		$this->render('content', $vars);
 	}
	
	function crearAlbum($tipo, $club)
	{
		if( !SESSION('user_admin') )
			return redirect(get('webURL') . _sh . 'admin/login');

		$nombre_album = strtoupper( POST('nombre_album') );
		$id=uniqid();
		mkdir(_spath . _sh . 'img/galeria/'.$club, 0777);
		chmod(_spath . _sh . 'img/galeria/'.$club, 0777);
		mkdir(_spath . _sh . 'img/galeria/'.$club.'/'.$id, 0777);
		chmod(_spath . _sh . 'img/galeria/'.$club.'/'.$id, 0777);
		mkdir(_spath . _sh . 'img/galeria/'.$club.'/'.$id . '/thumbs', 0777);
		chmod(_spath . _sh . 'img/galeria/'.$club.'/'.$id, 0777);
		$this->Admin_Model->crearAlbum($id, $nombre_album, $club);
		redirect(get('webURL')._sh.'admin/galeria/'.$tipo._sh.$club);
	}

	function editAlbum($tipo, $club, $album)
	{
		$nombre = strtoupper(POST('nombre_album'));

		$this->Admin_Model->editAlbum($album, $nombre);

		redirect(get('webURL') . _sh . 'admin/galeria/'.$tipo.'/'.$club.'/'.$album);
	}

	function elimAlbum($tipo, $club, $album)
	{

		/* ELIMINO TODOS LOS ARCHIVOS DENTRO DEL ÁLBUM */
		$filename = _spath."/img/galeria/".$club."/".$album."/";
		$handle = opendir($filename."thumbs/");

		while ($file = readdir($handle))
		{
		   if (is_file($filename."thumbs/".$file))
		   {
		       unlink($filename."thumbs/".$file);
		   }
		}

		chmod($filename."thumbs", 0777);
		rmdir($filename."thumbs");

		$handle = opendir($filename);

		while ($file = readdir($handle))
		{
		   if (is_file($filename.$file))
		   {
		       unlink($filename.$file);
		   }
		}

		chmod($filename, 0777);
		rmdir($filename);

		$this->Admin_Model->eliminarFotosAlbum($album);
		$this->Admin_Model->eliminarAlbum($album);

		redirect(get('webURL'). _sh . 'admin/galeria/'.$tipo.'/'.$club);
	}

	public function elimFoto()
	{

		if( !SESSION('user_admin') )
			return redirect(get('webURL') . _sh . 'admin/login');

		$id=POST('id_imagen');
		$image_name = POST('image_name');
		$url = $_POST['url'];
		$path = $_POST['path'];
		$filename = _spath.'/img/galeria/'.$path._sh;
		/** DELETING PHISICS FILES ***/
		chmod($filename."thumbs/".$image_name, 0777);
		unlink($filename."thumbs/".$image_name);
		chmod($filename.$image_name, 0777);
		unlink($filename.$image_name);

		/****** DELETING FROM THE DATABASE ***/
		$this->Admin_Model->elimFoto($id);
		redirect($url);
	}


	
 	public function configLiberacion($periodo = NULL, $succ =null)
 	{
 		if( !SESSION('user_admin') )
			return redirect(get('webURL') . _sh . 'admin/login');

		if($periodo == NULL)
			$periodo = periodo_actual();

			
		$config = $this->Admin_Model->getConfFechas($periodo);

		if($config == null)
			$vars['nuevo'] = 1;
		else
			$vars['nuevo'] = 0;

		$vars['succ'] = $succ;
		$vars['config'] = $config[0];
 		$vars['menu'] = 4;

 		$vars['periodo'] = $periodo;
		$vars['periodos'] = periodos_combo('1142');

 		$vars['view'] = $this->view('configLiberacion', true);
 		
 		$this->render('content', $vars);
 	}

 	/***** ADMINISTRADOR  *******/ 	

 	public function cambiarEstado ($estado = NULL,$userAdmin = NULL)
 	{
 		if( !SESSION('user_admin') )
			return redirect(get('webURL') . _sh . 'admin/login');
		
 		$this->sessionOn();
		if($estado == 'Vigente')
			$array = array("actual" => "1");
 		else if($estado == 'noVigente' && $this->Admin_Model->comprobarEstados() >= 2)
 			$array = array("actual" => "0");
 		else
 		{

 			$vars = $this->getDatosAdmin(SESSION('id_admin'));
 			$vars['menu'] = 0;
 			$vars['errorEstado'] = true;
 			$vars["view"] = $this->view("adminconfig",true);
 			$this->render("content",$vars);
 			return;
 		}
 		$idAdministrador = $this->Admin_Model->getCampos("administradores","id_administrador","usuario_administrador='$userAdmin'");
 		$this->Admin_Model->setCampos("administradores",$array,isset($userAdmin)?$idAdministrador[0]['id_administrador']:SESSION('id_admin'));

 		return redirect(get('webURL') .  _sh .'admin/adminconfig/');
 	}

 	public function editaAdmin ()
 	{
 		if( !SESSION('user_admin') )
			return redirect(get('webURL') . _sh . 'admin/login');

 		//$this->sessionOn();
 		$datosAdmin = $this->Admin_Model->getCampos("administradores","contrasena_administrador","id_administrador = ".SESSION('id_admin'));
 		if(POST('guardarCambios'))
 		{
 			$datos = array(
 				0 => array(utf8_encode(POST('newpass1')),utf8_encode(POST('newpass2')),6,25,NULL,NULL,NULL),
 				1 => array(utf8_encode(POST('nombre')),NULL,NULL,25,"/^([A-Z][a-záéíóúñ]+([[:space:]][A-Z][a-záéíóúñ]+)*|[A-ZÁÉÍÓÚÑ]+([[:space:]][A-ZÁÉÍÓÚÑ]+)*)$/",NULL,NULL),
 				2 => array(utf8_encode(POST('adminAP')),NULL,NULL,25,"/^([A-Z][a-záéíóúñ]+([[:space:]][A-Z][a-záéíóúñ]+)*|[A-ZÁÉÍÓÚÑ]+([[:space:]][A-ZÁÉÍÓÚÑ]+)*)$/",NULL,NULL),
 				3 => array(utf8_encode(POST('adminAM')),NULL,NULL,25,"/^([A-Z][a-záéíóúñ]+([[:space:]][A-Z][a-záéíóúñ]+)*|[A-ZÁÉÍÓÚÑ]+([[:space:]][A-ZÁÉÍÓÚÑ]+)*)$/",NULL,NULL),
 				4 => array(utf8_encode(POST('email')),NULL,NULL,45,"/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/","administradores","correo_electronico"),
 				5 => array(utf8_encode(POST('direc')),NULL,NULL,100,"/^[[:ascii:]]*$/i",NULL,NULL),
 				6 => array(utf8_encode(POST('profe')),NULL,NULL,45,"/^[[:ascii:]]*$/i",NULL,NULL),
 				7 => array(utf8_encode(POST('abrevi')),NULL,NULL,40,"/^[[:ascii:]]*$/i",NULL,NULL),
 				8 => array(utf8_encode(POST('fecha')),NULL,NULL,40,NULL,NULL,NULL)
 				);

 			$campos = array(
 				0 => array("contrasena_administrador","Contraseña"),
 				1 => array("nombre_administrador","Nombre"),
 				2 => array("apellido_paterno_administrador","Apellido paterno"),
 				3 => array("apellido_materno_administrador","Apellido materno"),
 				4 => array("correo_electronico","E-mail"),
 				5 => array("direccion_administrador","Dirección"),
 				6 => array("profesion_administrador","Profesión"),
 				7 => array("abreviatura_profesion","Abreviatura"),
 				8 => array("fecha_nacimiento_admin","Fecha de nacimiento")
 				);
 			$array = array();
 			$i = 1;
 			while ($i < count($datos))
 			{
 				if(!$vars['adminUpdate'] = ($this->Admin_Model->isValid($datos[$i])))
	 			{
	 				$array += array($campos[$i][0] => utf8_decode($datos[$i][0]) );
	 			}
	 			else
	 			{
	 				$vars['adminUpdate'] = $campos[$i][1].": Al modificar - ".$vars['adminUpdate'];
	 				break;
				}
	 			$i++;
 			}
 			
 			if(!$vars['adminUpdate'] && POST('lastpass') && (crypt(POST('lastpass'), $datosAdmin[0]['contrasena_administrador']) == $datosAdmin[0]['contrasena_administrador']))
 			{
 				//if(POST('lastpass') != $datosAdmin[0]['contrasena_administrador'])
					//$vars['adminUpdate'] = "Contraseña actual: La contraseña introducida no es correcta, favor de verificar.";
 				if(!$vars['adminUpdate'] = $this->Admin_Model->isValid($datos[0]))
 				{
 					$array += array($campos[0][0] => utf8_decode(crypt($datos[0][0])));
 				}
 				else
 				{
 					$vars['adminUpdate'] = $campos[0][1].": Al modificar - ".$vars['adminUpdate'];
 				}
 			}
 			if(!$vars['adminUpdate'])
	 			$this->Admin_Model->setCampos("administradores",$array,SESSION('id_admin'));
 		}
 		$vars = $this->getDatosAdmin(SESSION('id_admin'),$vars);
		$vars["view"] = $this->view("adminconfig",true);
		$vars['menu'] = 0;
		$this->render("content",$vars);
 	}

 	public function regisAdmin()
 	{
 		if( !SESSION('user_admin') )
			return redirect(get('webURL') . _sh . 'admin/login');

 		$this->sessionOn();
 		$vars['date'] = date("Y-m-d");
 		$vars['menu'] = 0;
 		if(POST('btnSubmit'))
 		{
 			//Explainer
 			/*	Array( 0 , 1 , 2 , n)
 			(value,	=> x , x , x , x
			compare,=> x , x , x , x
			min,	=> x , x , x , x
			max,	=> x , x , x , x
			expreg,	=> x , x , x , x
			tabla,	=> x , x , x , x
			columna)=> x , x , x , x
 			*/
 			$getPost = array(
 				0 => array(utf8_encode(POST('usuario')),NULL,6,25,"/^[A-Za-z][A-Za-z0-9]*$/","administradores","usuario_administrador"),	//4 letras iniciales seguidas de numeros o letras
 				1 => array(utf8_encode(POST('passone')),utf8_encode(POST('passtwo')),6,25,NULL,NULL,NULL), //Cualquier caracter exepto espacio
 				2 => array(utf8_encode(POST('nombre')),NULL,NULL,25,"/^([A-Z][a-záéíóúñ]+([[:space:]][A-Z][a-záéíóúñ]+)*|[A-ZÁÉÍÓÚÑ]+([[:space:]][A-ZÁÉÍÓÚÑ]+)*)$/",NULL,NULL),
 				3 => array(utf8_encode(POST('apepat')),NULL,NULL,25,"/^([A-Z][a-záéíóúñ]+([[:space:]][A-Z][a-záéíóúñ]+)*|[A-ZÁÉÍÓÚÑ]+([[:space:]][A-ZÁÉÍÓÚÑ]+)*)$/",NULL,NULL),
 				4 => array(utf8_encode(POST('apemat')),NULL,NULL,25,"/^([A-Z][a-záéíóúñ]+([[:space:]][A-Z][a-záéíóúñ]+)*|[A-ZÁÉÍÓÚÑ]+([[:space:]][A-ZÁÉÍÓÚÑ]+)*)$/",NULL,NULL),
 				5 => array(utf8_encode(POST('email')),NULL,NULL,45,"/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/","administradores","correo_electronico"),
 				6 => array(utf8_encode(POST('direccion')),NULL,NULL,100,"/^[[:ascii:]]*$/i",NULL,NULL),
 				7 => array(utf8_encode(POST('prof')),NULL,NULL,45,"/^[[:ascii:]]*$/i",NULL,NULL),
 				8 => array(utf8_encode(POST('abprof')),NULL,NULL,40,"/^[[:ascii:]]*$/i",NULL,NULL)
 				);
 			$campos = array(
 				0 => array("usuario_administrador","Usuario"),
 				1 => array("contrasena_administrador","Contraseña"),
 				2 => array("nombre_administrador","Nombre"),
 				3 => array("apellido_paterno_administrador","Apellido paterno"),
 				4 => array("apellido_materno_administrador","Apellido materno"),
 				5 => array("correo_electronico","E-mail"),
 				6 => array("direccion_administrador","Dirección"),
 				7 => array("profesion_administrador","Profesión"),
 				8 => array("abreviatura_profesion","Abreviatura")
 				);
 			$array = array();
 			$i = 0;
 			while ($i < count($getPost))
 			{
 				if(!$vars['regAdminError'] = ($this->Admin_Model->isValid($getPost[$i])))
	 			{
	 				$array += array($campos[$i][0] => utf8_decode($getPost[$i][0]) );
	 			}
	 			else
	 			{
	 				$vars['regAdminError'] = $campos[$i][1].": ".$vars['regAdminError'];
	 				break;
	 			}
	 			$i++;
 			}
	 		$array += array(
	 			"fecha_registro" => $vars['date'],
	 			"actual" => 1,
	 			"eliminado" => 0,
	 			"tipo_administrador" => 1
	 			);
	 		if(!$vars['regAdminError'])
	 			$vars['success'] = $this->Admin_Model->setRow("administradores",$array);
	 	}
 		$vars['view'] = $this->view("registroAdmin",true);
 		$this->render("content",$vars);
 	}

 	private function getDatosAdmin ($id,$vars = NULL)
 	{
 		if( !SESSION('user_admin') )
			return redirect(get('webURL') . _sh . 'admin/login');
		
 		$datosAdmin = $this->Admin_Model->getAdminData($id);
		$datosAllAdmin = $this->Admin_Model->getAllAdminData();

		$vars['datosAdmin'] = $datosAdmin;
		$vars['allAdmin'] = $datosAllAdmin;

		return $vars;
 	}

 	private function sessionOn()
 	{
 		if (!SESSION('user_admin'))
			return redirect(get('webURL') . _sh .'admin/login');
 	}

 	public function adminconfig($id = NULL)
	{
		if (!SESSION('user_admin'))
			return redirect(get('webURL') . _sh .'admin/login');	
		
		if(!$id) $id = SESSION('id_admin');
		
		$vars = $this->getDatosAdmin($id);
		$vars["view"] = $this->view("adminconfig",true);
		//$vars["view"]['registroAdmin'] = $this->view("registroAdmin",true);
		$vars['menu'] = 0;
		$this->render("content",$vars);
	}

	public function editadmin($id = NULL)
	{
		if (!SESSION('user_admin'))
			return redirect(get('webURL') . _sh .'admin/login');	
		
		if(!$id) $id = SESSION('id_admin');
		
		$vars = $this->getDatosAdmin($id);
		$vars["view"] = $this->view("editadmin",true);
		//$vars["view"]['registroAdmin'] = $this->view("registroAdmin",true);
		$vars['menu'] = 0;
		$this->render("content",$vars);
	}

}
