<?php
/**
 * Access from index.php:
 */
if(!defined("_access")) {
	die("Error: You don't have permission to access here...");
}

class Promotor_Model extends ZP_Model {
	
	public function __construct() {
		$this->Db = $this->db();
		$this->helpers();
	}

	public function getPromotor($user)
	{
		return $this->Db->query("select * from promotores where usuario_promotor = '$user' and eliminado_promotor=false");
	}

	public function getPromotores($periodo)
	{
		return $this->Db->query("select * from promotores natural join horarios natural join clubes where periodo='$periodo' order by nombre_promotor asc, apellido_paterno_promotor asc, apellido_materno_promotor asc");
	}

	public function getClubes()
	{
		return $data = $this->Db->query("select * from clubes where eliminado_club = 0 and tipo_club!=3 order by nombre_club asc");
	}

	public function verificarAcreditacion( $periodo )
	{
		$fecha_actual = date("Y-m-d");
		return $data = $this->Db->query("SELECT * from conf_fechas where periodo = '$periodo' AND '$fecha_actual' >= fecha_inicio_liberacion AND '$fecha_actual' <= fecha_fin_liberacion ");
	}	


	public function getAlumnos($promotor, $periodo)
	{
		return $this->Db->query("SELECT folio, semestre,alumnos.numero_control as numero_control, nombre_alumno, apellido_paterno_alumno, apellido_materno_alumno,
								 clubes.id_club as id_club, nombre_club, carreras.id_carrera as id_carrera, abreviatura_carrera, sexo, fecha_inscripcion, acreditado from inscripciones, alumnos, carreras, clubes, horarios where 
								 inscripciones.numero_control = alumnos.numero_control AND alumnos.id_carrera = carreras.id_carrera AND
								 inscripciones.id_club = clubes.id_club AND horarios.id_club = clubes.id_club AND 
								 inscripciones.periodo = '$periodo' AND horarios.periodo = '$periodo' AND horarios.usuario_promotor = '$promotor' order by apellido_paterno_alumno asc, apellido_materno_alumno asc, nombre_alumno asc");
	}
	public function getAlumno($n)
	{
		return $this->Db->query("select * from alumnos natural join carreras where numero_control = '$n'");
	}

	public function getPromotorAsignado($promotor, $periodo){
		return $this->Db->query("SELECT * from horarios, clubes, promotores where horarios.id_club = clubes.id_club AND 
									horarios.usuario_promotor = promotores.usuario_promotor AND 
									horarios.usuario_promotor = '$promotor' AND horarios.periodo = '$periodo'");
	}

	public function getPromotorId($id)
	{
		return $this->Db->query("SELECT * from promotores where usuario_promotor = '$id'");
	}

	public function getHistorialPromotor($id)
	{
		return $this->Db->query("SELECT horarios.periodo as per, substring(horarios.periodo,4,4) as ini, substring(horarios.periodo, 12,4) as fin, clubes.id_club as idclub, nombre_club, horario, lugar, count(folio) as ins from promotores, horarios, clubes, inscripciones where inscripciones.periodo = horarios.periodo AND horarios.id_club = inscripciones.id_club AND clubes.id_club = horarios.id_club AND promotores.usuario_promotor = horarios.usuario_promotor AND promotores.usuario_promotor = '$id' GROUP BY horarios.periodo ORDER BY ini DESC, fin DESC");

	}


	public function getPeriodos()
	{		
		return $this->Db->query("SELECT periodo, substring(periodo,4,4) as ini, substring(periodo, 12,4) as fin from inscripciones group by periodo order by ini DESC, fin DESC");		
	}

	public function getConfiguracion($periodo)
	{
		return $this->Db->query("SELECT * from conf_fechas WHERE periodo = '$periodo'");
	}

	public function setResultado($vars)
	{
		$fecha = date("Y-m-d");
		return $this->Db->query("update inscripciones set acreditado = '$vars[res]', fecha_liberacion_club = '$fecha' where folio = '$vars[folio]' and id_club = '$vars[id_club]' and periodo='$vars[periodo]'");
	}

	public function operacion($vars)
	{
		return $this->Db->query("insert into operaciones_administrativas(id_creador, nombre_operacion, fecha_creacion, hora_creacion) values('$vars[id_creador]','$vars[nombre_operacion]','".date('Y-m-d')."','".date('H:i:s')."')");
	}
	
}