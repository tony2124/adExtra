<?php
/**
 * Access from index.php:
 */
include(_pathwww.'/lib/funciones/funciones.php');

if(!defined("_access")) {
	die("Error: You don't have permission to access here...");
}

class Promotor_Controller extends ZP_Controller {
	 
	public function __construct() {
		$this->app("promotor");
		
		$this->Templates = $this->core("Templates");

		$this->Templates->theme("promotor");

		$this->Promotor_Model = $this->model("Promotor_Model");
	}
	
	public function index($periodo = NULL) {	
		if(!SESSION('usuario_promotor')) redirect(get('webURL')._sh.'promotor/login');

		//$id_club = SESSION('id_club');
		if(!isset($periodo)) 
		{
			$periodo = periodo_actual();
		}

		/***** SELECCION DE PERIODOS AGREGADOS EN LA BD *****/
		$periodossss = $this->Promotor_Model->getPeriodos();
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
		$vars["periodo"] = $periodo;

		/****************************************************/
		$vars['liberacion'] = $this->Promotor_Model->verificarAcreditacion($periodo);
		$vars['alumnos'] = $this->Promotor_Model->getAlumnos(SESSION('usuario_promotor'),$periodo);
		$vars['promotorasignado'] = $this->Promotor_Model->getPromotorAsignado(SESSION('usuario_promotor'),$periodo);
		$vars['menu'] = 1;
		$vars['view'] = $this->view('liberarAlumnos', true);
		$this->render('content', $vars);
	}

	public function login()
	{
		if(SESSION('usuario_promotor')) redirect(get('webURL')._sh.'promotor');
		$vars['error'] = '0';
		$vars['view'] = $this->view('loginForm', true);
		$this->render('content', $vars);
	}

	public function iniciarsesion()
	{
		if(SESSION('usuario_promotor')) redirect(get('webURL')._sh.'promotor');
		$user = POST('usuario');
		$clave = POST('clave');

		$data = $this->Promotor_Model->getPromotor($user);

		if($data != NULL)
			if(strcmp($data[0]['contrasena_promotor'], $clave) == 0)
			{
				SESSION('usuario_promotor', $data[0]['usuario_promotor']);
				SESSION('nombre_promotor', $data[0]['nombre_promotor']);
				SESSION('ap_promotor', $data[0]['apellido_paterno_promotor']);
				SESSION('am_promotor', $data[0]['apellido_materno_promotor']);
				SESSION('email', $data[0]['correo_electronico_promotor']);
				redirect(get('webURL')._sh.'promotor');
			}
		
		$vars['error'] = '1';
		$vars['view']=$this->view('loginForm',true);
		$this->render('content', $vars);
		
		
	}

	public function salirSesion()
	{
		unsetSessions();
		redirect(get('webURL')._sh.'promotor');
	}

	public function alumno($nctrl = NULL)
	{
		if (!SESSION('usuario_promotor'))
			return redirect(get('webURL') .  _sh .'admin/login');

		$datos = $this->Promotor_Model->getAlumno($nctrl);
		$vars["alumno"] = $datos[0];
		$vars['menu'] = 0;
		$vars["view"] = $this->view("alumno",true);

		$this->render("content",$vars);
	}

	function datos()
	{
		if( !SESSION('usuario_promotor') )
			return redirect(get('webURL') . _sh . 'admin/login');

		$id = SESSION("usuario_promotor");
		$result  = $this->Promotor_Model->getpromotorId($id);
		$vars['promotor'] = $result[0];

		$result  = $this->Promotor_Model->getHistorialPromotor($id);
		$vars['historial'] = $result;
		
		$vars['menu'] = 2;
		$vars['view'] = $this->view('verpromotor',true);
		$this->render('content', $vars);
	}

	function horarios(){
		if( !SESSION('usuario_promotor') )
			return redirect(get('webURL') . _sh . 'admin/login');
		
		$vars['promotores']  = $this->Promotor_Model->getPromotores(periodo_actual());
		$vars['clubes'] = $this->Promotor_Model->getClubes();

		$vars['menu'] = 2;
		$vars['view'] = $this->view('horarios',true);
		$this->render('content', $vars);
	}


	public function acreditando($periodo)
	{
		if(!SESSION('usuario_promotor')) redirect(get('webURL')._sh.'promotor/login');

		$datospromotor = $this->Promotor_Model->getPromotorAsignado(SESSION('usuario_promotor'),$periodo);
		
		$vars['id_creador'] = SESSION('usuario_promotor');
		$vars['id_club'] = $datospromotor[0]['id_club'];
		$vars['periodo'] = $periodo;

		$conf = $this->Promotor_Model->getConfiguracion($periodo);
		
		
		$i = 0;
		while($i < POST('na')){
			$vars['folio'] = POST('folio'.$i);
			$vars['res'] = POST('res'.$i);
			
			$vars['nombre_operacion'] = 'Actualizacion a '.$vars['res'].' al folio '.$vars['folio'];
			$this->Promotor_Model->setResultado($vars);
			$this->Promotor_Model->operacion($vars);
			$i++;
		}
		redirect(get('webURL')._sh.'promotor/index/'.$periodo);

	}

}
